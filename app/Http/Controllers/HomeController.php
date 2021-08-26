<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Application;
use App\Models\User;
use Auth;
use Illuminate\Support\Facades\Http; 
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $departments=Application::all()->where('User_id',Auth::user()->id)->groupBy("Position");
        $topass=[];
        if($departments){
            foreach($departments as $department=>$val){
                array_push($topass,array($department,$val->where("seen",0)->count(),$val->count()));
            }
        }
        return view('home',[
            "dep_num"=>$departments->count(),
            "departments"=>$topass
        ]);
    }

    public function edit(Request $request){
        if($request->method()=="GET"){
            return view('profile');
        }else if($request->method()=="POST"){
            if($request->profile_picture){
                $this->validate($request, [
                    "profile_picture"=>["required","file","mimes:jpg,jpeg,png"]
                ]);
                $user= User::find(Auth::user()->id);
                if($user->picture){
                    unlink(public_path("images/users/".$user->picture));
                }
                $ext=$request->file("profile_picture")->getClientOriginalExtension();
                $fname=time().Auth::user()->id.".".$ext;
                $request->file("profile_picture")->move(public_path("images/users/"),$fname);
                $user->picture=$fname;
                $user->save();
                return asset('images/users/'.$fname);
            }
            $user= User::find(Auth::user()->id);
            if($request->country){
                $this->validate($request,[
                    "country"=>["sometimes","string"]
                ]);
                $countrycodes=Http::get('https://flagcdn.com/en/codes.json')->json();
                foreach($countrycodes as $code=>$country){
                    if(stristr($request->country,$country)){
                        $user->countrycode=$code;
                    }
                };
                $user->country=$request->country;
                $user->save();
            }
            if($request->tel){
                $this->validate($request,[
                    "tel"=>["sometimes","string"]
                ]);
                $user->number=$request->tel;
                $user->save();
            }
        }
    }
    public function newseason(Request $request){
        DB::update("update applications set new=0 where User_id = ? and new = 1", [Auth::user()->id]);
        return redirect()->route('home');
    }
}
