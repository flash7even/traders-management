<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Session;
use DB;

class InsertCustomerDataController extends Controller
{
    public function successfullUpdate(Request $request)
    {
       return view('success');
    }
    public function insertDataToBuy(Request $request, $uid)
    {
       return view('addToBuy')->with('user_id',$uid);
    }

    public function buyDataUser(Request $request)
    {
       return view('buy_user');
    }

    /// Insert a new buy order to the order table
    public function insertNewBuyOrder(Request $request, $uid)
    {
        $product_name = $request->input('name');
        $product_id = "";
        $list = DB::select('select * from products where product_name = ?', [$product_name]);
        foreach ($list as $key) {
          $product_id = $key->id;
          break;
        }
        $product_qty = $request->input('quantity');
        $price = $request->input('price');
        $user_id = $uid;
        DB::table('orders')->where([
            ['user_id',$user_id],
            ['product_id',$product_id],
        ])->delete();
        DB::table('orders')->insert(
            ['user_id' => $user_id, 'product_id' => $product_id,'product_qty' => $product_qty,'price' => $price]
        );
        return redirect()->action(
            'InsertCustomerDataController@insertDataToBuy', ['uid' => $uid]
        );
    }

    /// Insert a new buy order to the order table
    public function removeBuyOrder(Request $request, $uid, $oid)
    {
        DB::table('orders')->where('id', '=', $oid)->delete();
        return redirect()->action(
            'InsertCustomerDataController@insertDataToBuy', ['uid' => $uid]
        );
    }

    public function insertDataToSell(Request $request, $uid)
    {
       return view('addToSell')->with('user_id',$uid);
    }

    public function sellDataUser(Request $request)
    {
       return view('sell_user');
    }

    /// Insert a new sell order to the order table
    public function insertNewSellOrder(Request $request, $uid)
    {
        $product_name = $request->input('name');
        $product_id = "";
        $list = DB::select('select * from products where product_name = ?', [$product_name]);
        foreach ($list as $key) {
          $product_id = $key->id;
          break;
        }
        $product_qty = $request->input('quantity');
        $price = $request->input('price');
        $user_id = $uid;
        DB::table('orders')->where([
            ['user_id',$user_id],
            ['product_id',$product_id],
        ])->delete();
        DB::table('orders')->insert(
            ['user_id' => $user_id, 'product_id' => $product_id,'product_qty' => $product_qty,'price' => $price]
        );
        return redirect()->action(
            'InsertCustomerDataController@insertDataToSell', ['uid' => $uid]
        );
    }
    public function removeSellOrder(Request $request, $uid, $oid)
    {
        DB::table('orders')->where('id', '=', $oid)->delete();
        return redirect()->action(
            'InsertCustomerDataController@insertDataToSell', ['uid' => $uid]
        );
    }
}
