<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Email;
use App\Models\Application;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Mail\AcceptMail;
use Illuminate\Support\Facades\Mail;
use Auth;

class EmailController extends Controller
{
    public function index(Request $request){
        //so make a page for each kind of email that has a form 
        //the form data will be submitted to the database only the super can access this
        //add a button for customizing email in the home page for the super only.
        //remove that edit icon from the preview of the emails.
        if($request->method()=='GET'){
            // dd(Email::all());
            return view('editmail');
        }else if($request->method()=="POST"){
            $this->validate($request, [
                "options"=>["required",Rule::in(["interview","accept"])],
                "primary"=>["required","string","max:1000"],
                "secondary"=>["nullable","string","max:500"]
            ]);
            if($request->options=="interview"){
                if(!count(Email::where('name','interview')->get())){
                    DB::insert('insert into emails (name, main, secondary) values (?, ?, ?)', [
                        "interview",
                        $request->primary,
                        $request->secondary
                    ]);
                }else{
                    $record=Email::where('name','interview')->first();
                    $record->main=$request->primary;
                    $record->secondary=$request->secondary;
                    $record->save();
                }
            }else if($request->options=="accept"){
                $this->validate($request, [
                    "attachements.*"=>["nullable","file","mimes:docs,pdf,txt,jpg,png"]
                ]);
                $filesExist=0;
                $files="";
                try{
                    Storage::deleteDirectory(public_path('files\email\accept'));
                }catch(exception $e){
                    dd($e);
                }
                if($request->attachements){
                    $filesExist++;
                    foreach($request->attachements as $file){
                        $files.=$file->getClientOriginalName().'|';
                        $file->move(public_path("files/email/accept"),$file->getClientOriginalName());
                    }
                }
                if(!count(Email::where('name','accept')->get())){
                    DB::insert('insert into emails (name, main, secondary, files) values (?, ?, ?, ?)', [
                        "accept",
                        $request->primary,
                        $request->secondary,
                        $filesExist ? substr($files,0,-1) : null
                    ]);
                }else{
                    $record=Email::where('name','accept')->first();
                    $record->main=$request->primary;
                    $record->secondary=$request->secondary;
                    $record->files=$filesExist ? substr($files,0,-1) : null;
                    $record->save();
                }
            }
        }
        return redirect()->route('home');
    }

    public function acceptmail(Request $request, $id=0){
        if($request->method()=="GET"){
            if($id){
                $applicant=Application::find($id);
                $admin=Auth::user();
                return new AcceptMail($applicant->First_Name." ".$applicant->Last_Name,$admin->name,$admin->number,$admin->position);
            }else{
                // Mail::to(env('TEST_EMAIL'))->send(new AcceptMail(null,null,null,null));
                return new AcceptMail(null,null,null,null);
            }
        }else if($request->method()=="POST"){
            $this->validate($request,[
                "number"=>["required","numeric"],
                "me"=>["required"]
            ]);
            if($request->boolean('me')){
                $user=Auth::user();
                Mail::to(env('TEST_EMAIL'))->send(new AcceptMail("Me",$user->name,$user->number,$user->position));
                return "sent";
            }else{
                $user=Auth::user();
                $i=0;
                $emails="";
                $applications=Application::where('User_id',Auth::user()->id)->where("new",1)->where('rejected','0')->where('accepted','1')->where("mailed",0)->orderBy("stars","desc")->take($request->number)->get();
                foreach($applications as $application){
                    if(env("APP_ENV")!=="local"){
                        Mail::to($application->Email)->send(new AcceptMail($application->First_Name." ".$application->Last_Name,$user->name,$user->number,$user->position));
                    }
                    $emails.=$application->Email." ";
                    $i++;
                }
                return "sent".$i." ".$emails;
            }
        }
        // Mail::to(env('TEST_EMAIL'))->send(new AcceptMail(null,null,null,null));
    }
}
