<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Session;
use DB;
use App\User;
use App\Product;
use App\Category;
use App\Deposit;

class AdminController extends Controller
{
    public function takeUserInfo(Request $request)
    {
   		return view('addnewuser');
    }

    public function insertUser(Request $request)
    {
    	$nuser = new User();
    	$nuser->name = $request->input('name');
    	$nuser->password = $request->input('password');
    	$nuser->email = $request->input('email');
    	$nuser->mobile = $request->input('mobile');
    	$nuser->address = $request->input('address');
    	$admin = $request->input('adminlevel');
    	$boss = "Boss";
    	$manager = "Manager";
    	$assistant = "Assistant Manager";
    	$buyer = "Buyer";
    	$seller = "Seller";

    	if(strcmp($admin, $boss) == 0){
    		$nuser->admin = 10;
    	}else if(strcmp($admin, $manager) == 0){
    		$nuser->admin = 5;
    	}else if(strcmp($admin, $assistant) == 0){
    		$nuser->admin = 4;
    	}else if(strcmp($admin, $buyer) == 0){
    		$nuser->admin = 1;
    	}else if(strcmp($admin, $seller) == 0){
    		$nuser->admin = 0;
    	}
    	$nuser->save();
   		return view('success');
    }

    public function editUserInfo(Request $request, $uid)
    {
   		return view('edituser')->with('uid',$uid);
    }

    public function editUserDueInfo(Request $request, $uid)
    {
   		return view('edituserdue')->with('uid',$uid);
    }

    public function editUser(Request $request)
    {
    	$id = $request->input('userid');
    	$name = $request->input('name');
    	$mobile = $request->input('mobile');
    	$address = $request->input('address');
    	$admin = $request->input('adminlevel');
    	$adminlevel = "";

    	$boss = "Boss";
    	$manager = "Manager";
    	$assistant = "Assistant Manager";
    	$buyer = "Buyer";
    	$seller = "Seller";

    	if(strcmp($admin, $boss) == 0){
    		$adminlevel = 10;
    	}else if(strcmp($admin, $manager) == 0){
    		$adminlevel = 5;
    	}else if(strcmp($admin, $assistant) == 0){
    		$adminlevel = 4;
    	}else if(strcmp($admin, $buyer) == 0){
    		$adminlevel = 1;
    	}else if(strcmp($admin, $seller) == 0){
    		$adminlevel = 0;
    	}

		DB::table('users')
        ->where('id', $id)
        ->update(['name' => $name]);

		DB::table('users')
        ->where('id', $id)
        ->update(['mobile' => $mobile]);

		DB::table('users')
        ->where('id', $id)
        ->update(['address' => $address]);

		DB::table('users')
        ->where('id', $id)
        ->update(['admin' => $adminlevel]);
        
        return redirect()->action(
            'ProfileController@showProfile', ['uid' => $id]
        );
    }

    public function editUserDue(Request $request)
    {
    	$obj = new Deposit();
    	$obj->user_id = $request->input('userid');
    	$obj->deposit_amount = $request->input('deposit');
        $obj->save();
        return redirect()->action(
            'ProfileController@showProfile', ['uid' => $obj->user_id]
        );
    }

    public function takeProductInfo(Request $request)
    {
   		return view('addnewproduct');
    }

    public function insertProduct(Request $request)
    {
    	$nuser = new Product();
    	$nuser->product_name = $request->input('name');
    	$nuser->product_qty = $request->input('quantity');
    	$nuser->price = $request->input('price');
    	$cat_name = $request->input('category');
    	$list = DB::select('select * from categories where category = ?', [$cat_name]);
    	foreach ($list as $key) {
    		$nuser->cat_id = $key->id;
    		break;
    	}
    	$nuser->save();
   		return view('success');
    }

    public function takeCatInfo(Request $request)
    {
   		return view('addnewcat');
    }

    public function insertCat(Request $request)
    {
    	$nuser = new Category();
    	$nuser->category = $request->input('name');
    	$nuser->save();
   		return view('success');
    }
}
