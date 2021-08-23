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
                    }else if($request->decision=="0"){
                        return view('viewapplications',[
                            "current_page"=>$index,
                            "pages"=>ceil($table->where("decision","rejected")->count()/10),
                            "status"=>"0",
                            "decision"=>"0",
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

    public function view2(Request $request, $page = 1){
        $applications= Application::all();
        if(count($applications)){
            return view('viewapplications2',[
                "accepted"=>$applications->where("accepted",1)->count(),
                "rejected"=>$applications->where("rejected",1)->count(),
                "incomplete"=>$applications->where("incomplete",1)->count(),
                "flag"=>$applications->where("flag",1)->count(),
                "seen"=>$applications->where("seen",0)->count()
            ]);
        }else{
            return redirect()->route("AddApplications");
        }
    }

    public function pending(Request $request, $page){
        $applications= Application::all()->where("seen",0);
        if(!$applications->count()){
            return "<div class='display-2' style='margin:auto;width:fit-content;'>You're Done</div>";
        }
        $pages=ceil($applications->count()/10);
        if($page<=$pages){
            return view("applicationlist",[
                "applications"=>$applications->skip(($page-1)*10)->take(10),
                "pages"=>$pages,
                "current_page"=>$page,
                "doing"=>"pending"
            ]);
        }
    }

    public function seen(Request $request, $page){
        $this->validate($request,[
            "rejected"=>["required"],
            "accepted"=>["required"],
            "flagged"=>["required"],
            "incomplete"=>["required"]
        ]);
        $applications= Application::all()->where("seen",1);
        if(!$applications->count()){
            return "<div class='display-2' style='margin:auto;width:fit-content;'>Nothing Here!</div>";
        }
        $pages=ceil(count($applications)/10);
        if($page<=$pages){
            if($request->boolean("rejected")){
                $applications=$applications->where("rejected",1);
            }
            if($request->boolean("flagged")){
                $applications=$applications->where("flag",1);
            }
            if($request->boolean("accepted")){
                $applications=$applications->where("accepted",1);
            }
            if($request->boolean("incomplete")){
                $applications=$applications->where("incomplete",1);
            }
            
            return view("applicationlist",[
                "applications"=>$applications->skip(($page-1)*10)->take(10),
                "pages"=>$pages,
                "current_page"=>$page,
                "doing"=>"seen"
            ]);
        }

    }

    public function viewone(Request $request,$index){
        if($request->method()=="GET"){
            if($index){
                $application=Application::find($index);
                if($application){
                    if($application->seen=='0'){
                        $application->seen='1';
                        $application->save();
                    }
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
                    };
                    return view("viewapplication", [
                        "country"=>"Earth",
                        "countrycode"=>0,
                        "application"=>$application
                    ]);
                }else{
                    return redirect()->route("viewdefault");
                }
            }else{
                return redirect()->route("viewdefault");
            }
        }else if($request->method()=="POST"){
            $this->validate($request, [
                "event"=>["required",Rule::in(["Interview","Flag","Incomplete","Reject","star1","star2","star3","star4","star5"])]
            ]);
            $application=Application::find($index);
            if($request->event=="Interview"){
                $application->accepted="1";
            }
            if($request->event=="Flag"){
                $application->flag="1";
            }
            if($request->event=="Incomplete"){
                $application->incomplete="1";
            }
            if($request->event=="Reject"){
                $application->rejected="1";
            }
            if(strstr($request->event,"star")){
                $application->stars=substr($request->event,4,1);
            }
            $application->save();
            return "ok";
        }
    }
}
