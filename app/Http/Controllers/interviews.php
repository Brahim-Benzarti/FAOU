<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\ApplicationsImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\HeadingRowImport;
use Illuminate\Validation\Rule;
use App\Models\Application;
use Illuminate\Support\Facades\Http; 

class interviews extends Controller
{
    public function index(){
        return view('interviews');
    }

    public function add(Request $request){
        if($request->method()=="GET"){
            return view('addapplication');
        }else if($request->method()=="POST"){
            $this->validate($request,[
                "csvfile"=>["required","file","mimes:csv,xlsx,xlsm,xlsb,xltx,xltm,xls,xlt,xls"]
            ]);


            // $headingShouldBe=["Submission Time","First Name","Last Name","Email","Nationality","Birthday","Position you want to apply for","Is this your first time applying?","Share your LinkedIn Profile OR Online CV","Brief Biography (Max 1000 Character)","Motivation Letter (Max 3000 Charcter)"];
            // $headings = (new HeadingRowImport)->toArray($request->csvfile);
            // return $headings;
            // run these to get the heading info


            $h=["submission_time","first_name","last_name","email","nationality","birthday","position_you_want_to_apply_for","is_this_your_first_time_applying","share_your_linkedin_profile_or_online_cv","brief_biography_max_1000_character","motivation_letter_max_3000_charcter"];
            Excel::import(new ApplicationsImport,$request->csvfile);
            return redirect()->route("AddApplications",["success"=>1]);
        }
    }
    public function view(Request $request,$index = 1){
        $table= Application::all();
        if(count($table)==0){
            return view('viewapplications',[
                "current_page"=>0,
                "pages"=>0,
                "status"=>"0",
                "decision"=>"0",
                "accepted"=>"none",
                "pending"=>"none",
                "applications"=>[]
            ]);
        }
        if($index<=ceil($table->count()/10)){
            if($request->method()=="GET"){
                return view('viewapplications',[
                    "current_page"=>$index,
                    "pages"=>ceil($table->count()/10),
                    "status"=>"0",
                    "decision"=>"2",
                    "accepted"=>$table->where("decision","accepted")->count(),
                    "pending"=>$table->where("status","pending")->count(),
                    "applications"=>$table->skip(($index-1)*10)->take(10)
                ]);
            }else if($request->method()=="POST"){
                $this->validate($request, [
                    "status"=>["required",Rule::in(["0","1","2"])], //0: all, 1: read, 2: pending
                    "decision"=>[Rule::in(["0","1","2"])], //0: default, 1:accepted, 2: rejected
                    "flag"=>"sometimes|required"
                ]);
                if($request->flag=="on"){
                    return view('viewapplications',[
                        "current_page"=>$index,
                        "pages"=>ceil($table->where("flag",1)->count()/10),
                        "status"=>"0",
                        "decision"=>"2",
                        "accepted"=>$table->where("decision","accepted")->count(),
                        "pending"=>$table->where("status","pending")->count(),
                        "applications"=>$table->where("flag",1)->skip(($index-1)*10)->take(10)
                    ]);
                }else if($request->status=="0"){
                    if($request->decision=="2"){
                        return view('viewapplications',[
                            "current_page"=>$index,
                            "pages"=>ceil($table->count()/10),
                            "status"=>"0",
                            "decision"=>"2",
                            "accepted"=>$table->where("decision","accepted")->count(),
                            "pending"=>$table->where("status","pending")->count(),
                            "applications"=>$table->skip(($index-1)*10)->take(10)
                        ]);
                    }else if($request->decision=="1"){
                        return view('viewapplications',[
                            "current_page"=>$index,
                            "pages"=>ceil($table->where("decision","accepted")->count()/10),
                            "status"=>"0",
                            "decision"=>"1",
                            "accepted"=>$table->where("decision","accepted")->count(),
                            "pending"=>$table->where("status","pending")->count(),
                            "applications"=>$table->where("decision","accepted")->skip(($index-1)*10)->take(10)
                        ]);
                    }else if($request->decision=="1"){
                        return view('viewapplications',[
                            "current_page"=>$index,
                            "pages"=>ceil($table->where("decision","rejected")->count()/10),
                            "status"=>"0",
                            "decision"=>"1",
                            "accepted"=>$table->where("decision","accepted")->count(),
                            "pending"=>$table->where("status","pending")->count(),
                            "applications"=>$table->where("decision","rejected")->skip(($index-1)*10)->take(10)
                        ]);
                    }
                }else if($request->status=="1"){
                    if($request->decision=="2"){
                        return view('viewapplications',[
                            "current_page"=>$index,
                            "pages"=>ceil($table->where("status","read")->count()/10),
                            "status"=>"1",
                            "decision"=>"2",
                            "accepted"=>$table->where("decision","accepted")->count(),
                            "pending"=>$table->where("status","pending")->count(),
                            "applications"=>$table->where("status","read")->skip(($index-1)*10)->take(10)
                        ]);
                    }else if($request->decision=="1"){
                        return view('viewapplications',[
                            "current_page"=>$index,
                            "pages"=>ceil($table->where("status","read")->where("decision","accepted")->count()/10),
                            "status"=>"1",
                            "decision"=>"1",
                            "accepted"=>$table->where("decision","accepted")->count(),
                            "pending"=>$table->where("status","pending")->count(),
                            "applications"=>$table->where("status","read")->where("decision","accepted")->skip(($index-1)*10)->take(10)
                        ]);
                    }else if($request->decision=="0"){
                        return view('viewapplications',[
                            "current_page"=>$index,
                            "pages"=>ceil($table->where("status","read")->where("decision","rejected")->count()/10),
                            "status"=>"1",
                            "decision"=>"0",
                            "accepted"=>$table->where("decision","accepted")->count(),
                            "pending"=>$table->where("status","pending")->count(),
                            "applications"=>$table->where("status","read")->where("decision","rejected")->skip(($index-1)*10)->take(10)
                        ]);
                    }
                }else if($request->status=="2"){
                    if($request->decision=="2"){
                        return view('viewapplications',[
                            "current_page"=>$index,
                            "pages"=>ceil($table->where("status","pending")->count()/10),
                            "status"=>"2",
                            "decision"=>"2",
                            "accepted"=>$table->where("decision","accepted")->count(),
                            "pending"=>$table->where("status","pending")->count(),
                            "applications"=>$table->where("status","pending")->skip(($index-1)*10)->take(10)
                        ]);
                    }else if($request->decision=="1"){
                        return view('viewapplications',[
                            "current_page"=>$index,
                            "pages"=>ceil($table->where("status","pending")->where("decision","accepted")->count()/10),
                            "status"=>"2",
                            "decision"=>"1",
                            "accepted"=>$table->where("decision","accepted")->count(),
                            "pending"=>$table->where("status","pending")->count(),
                            "applications"=>$table->where("status","pending")->where("decision","accepted")->skip(($index-1)*10)->take(10)
                        ]);
                    }else if($request->decision=="0"){
                        return view('viewapplications',[
                            "current_page"=>$index,
                            "pages"=>ceil($table->where("status","pending")->where("decision","rejected")->count()/10),
                            "status"=>"2",
                            "decision"=>"0",
                            "accepted"=>$table->where("decision","accepted")->count(),
                            "pending"=>$table->where("status","pending")->count(),
                            "applications"=>$table->where("status","pending")->where("decision","rejected")->skip(($index-1)*10)->take(10)
                        ]);
                    }
                }
            }
        }else{
            return redirect()->route("ViewApplications");
        }
    }

    public function viewone(Request $request,$index){
        if($request->method()=="GET"){
            if($index){
                $application=Application::find($index);
                if($application){
                    $countrycodes=Http::get('https://flagcdn.com/en/codes.json')->json();
                    // dd(array_search(ucfirst(strtolower(trim($application->Nation))),$countrycodes));  
                    foreach($countrycodes as $code=>$country){
                        if(stristr($application->Nationality,$country)){
                            return view("viewapplication", [
                                "country"=>$country,
                                "countrycode"=>$code,
                                "application"=>$application
                            ]);
                        }
                    }
                }else{
                    return redirect()->route("ViewApplications");
                }
            }else{
                return redirect()->route("ViewApplications");
            }
        }else if($request->method()=="POST"){
            $this->validate($request, [
                "event"=>["required",Rule::in(["Read","Interview","Flag","Incomplete","Reject"])]
            ]);
            $application=Application::find($index);
            if($request->event=="Read"){
                $application->status="read";
            }else if($request->event=="Interview"){
                $application->decision="accepted";
            }else if($request->event=="Flag"){
                $application->flag=1;
            }else if($request->event=="Incomplete"){
                $application->incomplete=1;
            }else if($request->event=="Reject"){
                $application->decision="rejected";
            }
            $application->save();
            return "ok";
        }
    }
}
