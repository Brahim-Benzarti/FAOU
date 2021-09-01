<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EmailController extends Controller
{
    public function index(Request $request, $for){
        //so make a page for each kind of email that has a form 
        //the form data will be submitted to the database only the super can access this
        //add a button for customizing email in the home page for the super only.
        //remove that edit icon from the preview of the emails.
        if($request->method()=='GET'){
            if($for=="interview"){

            }else if($for=="accept"){
    
            }
        }else if($request->method()=="POST"){
            if($for=="interview"){
    
            }else if($for=="accept"){
    
            }
        }
        return response()->redirect('home');
    }
}
