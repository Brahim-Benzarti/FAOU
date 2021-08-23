<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\ApplicationsImport;
use App\Exports\ApplicationsExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\HeadingRowImport;
use Illuminate\Validation\Rule;
use App\Models\Application;
use Illuminate\Support\Facades\Http; 
use Auth;
use App\Mail\InterviewMail;
use Illuminate\Support\Facades\Mail;

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



    public function view(Request $request, $page = 1){
        $applications= Application::all()->where('User_id',Auth::user()->id);
        if(count($applications)){
            return view('viewapplications',[
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
        $applications= Application::all()->where('User_id',Auth::user()->id)->where("seen",0);
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
        }else{
            return redirect()->route('viewdefault');
        }
    }

    public function seen(Request $request, $page){
        $this->validate($request,[
            "rejected"=>["required"],
            "accepted"=>["required"],
            "flagged"=>["required"],
            "incomplete"=>["required"]
        ]);
        $applications= Application::all()->where('User_id',Auth::user()->id)->where("seen",1);
        if(!$applications->count()){
            return "<div class='display-2' style='margin:auto;width:fit-content;'>Nothing Here!</div>";
        }
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
        $pages=ceil(count($applications)/10);
        if($page<=$pages){
            return view("applicationlist",[
                "applications"=>$applications->skip(($page-1)*10)->take(10),
                "pages"=>$pages,
                "current_page"=>$page,
                "doing"=>"seen"
            ]);
        }else{
            return redirect()->route('viewdefault');
        }
    }

    public function viewone(Request $request,$index){
        if($request->method()=="GET"){
            if($index){
                $application=Application::where('User_id',Auth::user()->id)->find($index);
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
            $application=Application::where('User_id',Auth::user()->id)->find($index);
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



    public function download(){
        return Excel::download(new ApplicationsExport, "Applications.xlsx");
        
    }

    public function people(Request $request){
        $this->validate($request,[
            "number"=>["required","numeric"]
        ]);
        $applications=Application::all()->where('User_id',Auth::user()->id)->sortByDesc("stars")->take($request->number);
        return view("peoplelist",[
            "applications"=>$applications
        ]);
    }



    public function mail($id=0){
        if($id){
            $applicant=Application::find($id);
            if($applicant){
                Mail::to(env('TEST_EMAIL'))->send(new InterviewMail("Me","https://calendly.com/brahim-benzarti/faou",Auth::user()->name,"21621061865","IT Manager"));
                // return new InterviewMail($applicant->First_Name." ".$applicant->Last_Name,"https://calendly.com/brahim-benzarti/faou",Auth::user()->name,"21621061865","IT Manager");
            }
        }
        return new InterviewMail(NULL,NULL,NULL,NULL,NULL);
    }


    public function interview(Request $request){
        if($request->method()=="GET"){
            return new InterviewMail("Barhoum","https://www.google.com");
        }else if($request->method()=="POST"){
            $this->validate($request,[
                "link"=>["required","string"],
                "number"=>["required","numeric"]
            ]);
            if($request->me){
                Mail::to(env('TEST_EMAIL'))->send(new InterviewMail("Me","https://calendly.com/brahim-benzarti/faou",Auth::user()->name,"21621061865","IT Manager"));
                return "sent";
            }else{
                $applications=Application::all()->where('User_id',Auth::user()->id)->sortByDesc("stars")->take($request->number);
                foreach($applications as $application){
                    Mail::to($application->Email)->send(new InterviewMail($applicant->First_Name." ".$applicant->Last_Name,"https://calendly.com/brahim-benzarti/faou",Auth::user()->name,"21621061865","IT Manager"));
                }
                return "sent";
            }
        }
    }


    public function reject(){

    }
}
