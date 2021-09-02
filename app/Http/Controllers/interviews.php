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
        $res=Application::where('User_id',Auth::user()->id)->where("new","1")->where('rejected','0')->where('accepted','1')->where("mailed","1")->get();
        $sent=0;
        if($res->count()){
            $sent=1;
        }
        return view('interviews',[
            "sent"=>$sent,
            "applicants"=>$sent ? $res : null
        ]);
    }

    public function acceptance(){
        return view('sendacceptance');
    }

    public function interviews(){
        return view('sendinterviews');
    }

    public function add(Request $request){
        if($request->method()=="GET"){
            return view('addapplication',[
                "success"=>""
            ]);
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
            return redirect()->route("viewdefault");
        }
    }



    public function view(Request $request, $page = 1){
        $applications= Application::where('User_id',Auth::user()->id)->where("new",1)->get();
        if(count($applications)){
            return view('viewapplications',[
                "accepted"=>$applications->where("accepted",1)->count(),
                "rejected"=>$applications->where("rejected",1)->count(),
                "incomplete"=>$applications->where("incomplete",1)->count(),
                "flag"=>$applications->where("flag",1)->count(),
                "seen"=>$applications->where("seen",0)->count()
            ]);
        }else{
            return redirect()->route("AddApplications", [
                "success"=>""
            ]);
        }
    }

    public function pending(Request $request, $page){
        $applications= Application::where('User_id',Auth::user()->id)->where("new",1)->where("seen",0);
        if(!$applications->count()){
            return "<div class='display-2' style='margin:auto;width:fit-content;'>You're Done</div>";
        }
        $pages=ceil($applications->count()/10);
        if($page<=$pages){
            return view("applicationlist",[
                "applications"=>$applications->skip(($page-1)*10)->take(10)->get(),
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
        $applications= Application::where('User_id',Auth::user()->id)->where("new",1)->where("seen",1)->get();
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
            $msg="";
            if($request->event=="Interview"){
                if($application->accepted=="1"){
                    $application->accepted="0";
                    $msg="Interview";
                }else{
                    $application->accepted="1";
                    $msg="Cancel Interview";
                }
            }
            if($request->event=="Flag"){
                if($application->flag=="1"){
                    $application->flag="0";
                    $msg="Flag";
                }else{
                    $application->flag="1";
                    $msg="Remove Flag";
                }
            }
            if($request->event=="Incomplete"){
                if($application->incomplete=="1"){
                    $application->incomplete="0";
                    $msg="Completed";
                }else{
                    $application->incomplete="1";
                    $msg="Incomplete";
                }
            }
            if($request->event=="Reject"){
                if($application->rejected=="1"){
                    $application->rejected="0";
                    $msg="Reject";
                }else{
                    $application->rejected="1";
                    $msg="Remove Rejection";
                }
            }
            if(strstr($request->event,"star")){
                $application->stars=substr($request->event,4,1);
            }
            $application->save();
            return $msg;
        }
    }



    public function download(){
        return Excel::download(new ApplicationsExport, "Applications.xlsx");
        
    }

    public function people(Request $request){
        $this->validate($request,[
            "number"=>["required","numeric"]
        ]);
        $applications=Application::where('User_id',Auth::user()->id)->where("new",1)->where('rejected','0')->where('accepted','1')->where("mailed",0)->orderBy("stars","desc")->take($request->number)->get();
        return view("peoplelist",[
            "applications"=>$applications
        ]);
    }

    public function acceptedpeople(Request $request){
        $this->validate($request,[
            "number"=>["required","numeric"]
        ]);
        $applications=Application::where('User_id',Auth::user()->id)->where("new",1)->where('rejected','0')->where('accepted','1')->where("mailed",'1')->where('intern','1')->take($request->number)->get();
        return view("peoplelist",[
            "applications"=>$applications
        ]);
    }


    public function mail($id=0){
        if($id){
            $applicant=Application::find($id);
            if($applicant){
                $user=Auth::user();
                // Mail::to(env('TEST_EMAIL'))->send(new InterviewMail("Me","https://calendly.com/brahim-benzarti",$user->name,$user->number,$user->position);
                return new InterviewMail($applicant->First_Name." ".$applicant->Last_Name,"https://calendly.com/brahim-benzarti",$user->name,$user->number,$user->position);
            }
        }
        return new InterviewMail(NULL,NULL,NULL,NULL,NULL);
    }


    public function interview(Request $request){
        if($request->method()=="GET"){
            return new InterviewMail(NULL,NULL,NULL,NULL,NULL);
        }else if($request->method()=="POST"){
            $this->validate($request,[
                "link"=>["required","string"],
                "number"=>["required","numeric"],
                "me"=>["required"]
            ]);
            if($request->boolean('me')){
                $user=Auth::user();
                Mail::to(env('TEST_EMAIL'))->send(new InterviewMail("Me",$request->link,$user->name,$user->number,$user->position));
                return "sent";
            }else{
                $user=Auth::user();
                $i=0;
                $emails="";
                $applications=Application::where('User_id',Auth::user()->id)->where("new",1)->where('rejected','0')->where('accepted','1')->where("mailed",0)->orderBy("stars","desc")->take($request->number)->get();
                foreach($applications as $application){
                    if(env("APP_ENV")!=="local"){
                        Mail::to($application->Email)->send(new InterviewMail($application->First_Name." ".$application->Last_Name,$request->link,$user->name,$user->number,$user->position));
                        $application->mailed="1";
                        $application->save();
                    }
                    $emails.=$application->Email." ";
                    $i++;
                }
                return "sent".$i." ".$emails;
            }
        }
    }


    public function reject(){

    }

    public function intern($id){
        $applicant=Application::find($id);
        if($applicant){
            $applicant->rejected='0';
            $applicant->intern='1';
            $applicant->save();
            return "done";
        }
        return "nothing";
    }
    public function decline($id){
        $applicant=Application::find($id);
        if($applicant){
            $applicant->intern='0';
            $applicant->rejected='1';
            $applicant->save();
            return "done";
        }
        return "nothing";
    }
}
