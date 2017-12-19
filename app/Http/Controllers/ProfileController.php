<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Session;


class ProfileController extends Controller
{
    public function listUsers(Request $request)
    {
       $email = Session::get('userEmail');
       $admin = "tarangokhan77@gmail.com";
       
       if($email != $admin){
       		/// Also pop up a java script box to show "you are not the admin".
       		/// return redirect('home');
       }
       return view('Users');
    }
    public function showProfile(Request $request, $uid)
    {
       $email = Session::get('userEmail');
       $admin = "tarangokhan77@gmail.com";
       
       if($email != $admin){
       		/// Also pop up a java script box to show "you are not the admin".
       		/// return redirect('home');
       }
       return view('profile')->with('user_id',$uid);
    }
}
