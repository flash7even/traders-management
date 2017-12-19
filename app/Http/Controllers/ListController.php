<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class ListController extends Controller
{
    public function show()
    {
       return view('welcome');
    }

    public function deleteAll()
    {
        DB::table('users')->where([
            ['id','>',1],
        ])->delete();

        DB::table('sells')->delete();
        DB::table('buys')->delete();
        DB::table('carts')->delete();
        DB::table('products')->delete();
        DB::table('categories')->delete();
        DB::table('deposit')->delete();
        DB::table('orders')->delete();

        return view('success');
    }
}