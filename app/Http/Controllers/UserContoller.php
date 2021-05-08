<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserContoller extends Controller
{
  public function signUp(Request $dd)
  {
  	$validate =validator::make($dd->all()
  	[
  		"name" => 'required',
  		"second_name" => 'required',
  		"login" => 'required',
  	    "password" => 'required|min:6'
  	]);
  	if ($validate->fails())
  	{
  		return respons()->json(
  			[
        "message"=>$validate->errors(),
  		
  	    ]);
  	}
  	User::create(&dd->all());
  	return respons()->json("Vse good")
  }
  function signIn(Request $zz){

  	$validate=validate::make($zz->all(),
  		[
  			"login"=>'required',
  			"password"=>'required'
  			     ]);
  	    if($validate->fails())
  	    {
  	    	return respons()->json([
  	    		"message"=>$validate->error(),
  	    	]);
  	    }
  	    $user =User::where ("login",$zz->login)->first();
  	    if($user)
  	    {
  	     if($zz->password && $user->password)
  	     {
  	      $user->api_token = Str::random(50);
  	      $user->save();
  	      return respons()->json([
  	      	"api_token"=>$user->api_token,
  	      ]);
  	     }
  	    }   return renspons()-> json([
                       "massage"=>"Вы не зарегестрированы!", 
                   ]);
       }
    public function output(Request $output){

     $user = User::where("login", $output->login)->first();
        if($user->api_token != null)
        {
            $user->api_token = null;
         }
    }
    public function reset_password(Request $reset){
     $validator = Validator::make($reset->all(), [
         "login" => "required",
     ]);

     $user = User::where("login", $reset->login)->first();


     if ($user) {
         $new_password = Validator::make($reset->all(), [
         "password" => "required|min:6",
         ]);
         $user->password = $new_password->password;
         $user->save();
     
    }
}
