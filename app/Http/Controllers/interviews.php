<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class interviews extends Controller
{
    public function index(){
        return view('interviews');
    }

    public function add(Request $request){
        if($request->method()=="GET"){
            return view('addingapplications');
        }else if($request->method()=="POST"){
            $this->validate($request,[
                "csvfile"=>["required","file","mimes:csv,xlsx,xlsm,xlsb,xltx,xltm,xls,xlt,xls"]
            ]);
            return "validation done";
        }
    }
    public function view(){

    }
}
