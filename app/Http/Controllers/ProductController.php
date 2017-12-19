<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;
use App\Product;
use App\Cart;
use App\Buy;
use App\Sell;
use DB;
use Session;


class ProductController extends Controller
{
    public function showAllStorage(Request $request)
    {
        return view('storage');
    }

    public function showAllStorageCat(Request $request, $ucat_id)
    {
        Session::put('ucat_id', $ucat_id);
        return redirect()->action('ProductController@showAllStorage');
    }
    
    public function showAllProduct(Request $request)
    {
        return view('product');
    }

    public function showProductInfo(Request $request, $pid)
    {
        return view('product_profile')->with('pid',$pid);
    }

    public function showAllProductCat(Request $request, $ucat_id)
    {
        Session::put('ucat_id', $ucat_id);
        return redirect()->action('ProductController@showAllProduct');
    }

    /// Show the final list of order and other info to confirm order
    public function buyProductConfirmation(Request $request, $uid)
    {
        $List = DB::select('select * from orders where user_id = ?', [$uid]);
        $cnt = count($List);
        return view('buy_product_confirmation', compact('List', 'uid'));
    }

    /// Process all the orders of a user
    public function buyProduct(Request $request)
    {
        $nameAry = $request->input('name');
        $qtyAry = $request->input('quantity');
        $catAry = $request->input('category');
        $priceAry = $request->input('price');

        $totalAmount = $request->input('totalAmount');
        $depositAmount = $request->input('depositAmount');
        $deadline = '2018-09-15';
        $userid = $request->input('userid');
        $rating = $request->input('rating');

        $dueAmount = $totalAmount-$depositAmount;

        /// Insert in cart table:
        $cart = new Cart();
        $cart->user_id = $userid;
        $cart->total_amount = $totalAmount;
        $cart->due_amount = $dueAmount;
        $cart->rating = $rating;
        $cart->due_deadline = $deadline;
        $cart->cart_type = 0; /// 0 means buy
        $cart->save();

        /// Find the id of the last cart entry for sell table update:
        $results = DB::select('select * from carts order by id DESC');
        $cartid = 0;
        foreach ($results as $res) {
            $cartid = $res->id;
            break;
        }

        /// Take each product entry:
        for($i = 0;$i<count($nameAry);$i++){
            $p = new Product();
            $p->product_name = $nameAry[$i];
            $p->product_qty = $qtyAry[$i];
            $p->cat_name = $catAry[$i];
            $p->price = $priceAry[$i];
            $product_id = -1;
            
            /// Update in the product table:
            $plist = DB::select('select * from products where product_name = ?', [$p->product_name]);
            if(count($plist) == 0){
                /// Insert this item as a new one.
                /// Show an error: the product must exist.
            }else{
                /// Update the previous entry.
                foreach ($plist as $res) {
                    $product_id = $res->id;
                    $res->product_qty = $res->product_qty + $p->product_qty;
                    $res->price = $p->price;
                    if($res->product_qty<0){
                        $res->product_qty = 0;
                        /// Do something here.
                        /// Not supposed to happen.
                    }
                    DB::table('products')
                        ->where('product_name', $res->product_name)
                        ->update(['product_qty' => $res->product_qty]);

                    DB::table('products')
                        ->where('product_name', $res->product_name)
                        ->update(['price' => $res->price]);

                    $curDate = date("Y-m-d");
                    DB::table('products')
                        ->where('product_name', $res->product_name)
                        ->update(['updated_at' => $curDate]);
                        
                    break;
                }
            }

            /// Update in the sell table:
            if($product_id == -1){
                /// Show Unexpected Error.
                echo "Prod Name: ".$p->product_name;
                return view('home');
            }
            $b = new Buy();
            $b->product_id = $product_id;
            $b->product_qty = $qtyAry[$i];
            $b->user_id = $userid;
            $b->cart_id = $cartid;
            $b->price = $priceAry[$i];
            $b->save();
        }

        DB::table('orders')->where([
            ['user_id',$userid],
        ])->delete();

        return redirect()->action('InsertCustomerDataController@successfullUpdate');
    }

    /// Show the final list of order and other info to confirm order
    public function sellProductConfirmation(Request $request, $uid)
    {
        $List = DB::select('select * from orders where user_id = ?', [$uid]);
        $cnt = count($List);
        return view('sell_product_confirmation', compact('List', 'uid'));
    }

    /// Process all the orders of a user
    public function sellProduct(Request $request)
    {
        $nameAry = $request->input('name');
        $qtyAry = $request->input('quantity');
        $catAry = $request->input('category');
        $priceAry = $request->input('price');

        $totalAmount = $request->input('totalAmount');
        $depositAmount = $request->input('depositAmount');
        $deadline = '2018-09-15';
        $userid = $request->input('userid');
        $rating = $request->input('rating');
        $dueAmount = $totalAmount-$depositAmount;

        /// Insert in cart table:
        $cart = new Cart();
        $cart->user_id = $userid;
        $cart->total_amount = $totalAmount;
        $cart->due_amount = $dueAmount;
        $cart->rating = $rating;
        $cart->due_deadline = $deadline;
        $cart->cart_type = 1;
        $cart->save();

        /// Find the id of the last cart entry for sell table update:
        $results = DB::select('select * from carts order by id DESC');
        $cartid = 0;
        foreach ($results as $res) {
            $cartid = $res->id;
            break;
        }

        /// Take each product entry:
        for($i = 0;$i<count($nameAry);$i++){
            $p = new Product();
            $p->product_name = $nameAry[$i];
            $p->product_qty = $qtyAry[$i];
            $p->cat_name = $catAry[$i];
            $p->price = $priceAry[$i];
            $product_id = -1;
            
            /// Update in the product table:
            $plist = DB::select('select * from products where product_name = ?', [$p->product_name]);
            if(count($plist) == 0){
                /// Insert this item as a new one.
                /// Show an error: the product must exist.
            }else{
                /// Update the previous entry.
                foreach ($plist as $res) {
                    $product_id = $res->id;
                    $res->product_qty = $res->product_qty - $p->product_qty;
                    if($res->product_qty<0){
                        $res->product_qty = 0;
                        /// Do something here.
                        /// You don't have sufficient enough to sell.
                    }
                    DB::table('products')
                        ->where('product_name', $res->product_name)
                        ->update(['product_qty' => $res->product_qty]);

                    DB::table('products')
                        ->where('product_name', $res->product_name)
                        ->update(['price' => $res->price]);

                    $curDate = date("Y-m-d");
                    DB::table('products')
                        ->where('product_name', $res->product_name)
                        ->update(['updated_at' => $curDate]);
                        
                    break;
                }
            }

            /// Update in the sell table:
            if($product_id == -1){
                /// Show Unexpected Error.
                echo "Prod Name: ".$p->product_name;
                return view('home');
            }
            $b = new Sell();
            $b->product_id = $product_id;
            $b->product_qty = $qtyAry[$i];
            $b->user_id = $userid;
            $b->cart_id = $cartid;
            $b->price = $priceAry[$i];
            $b->save();
        }

        DB::table('orders')->where([
            ['user_id',$userid],
        ])->delete();

        return redirect()->action('InsertCustomerDataController@successfullUpdate');
    }












    /// extra
        public function storeProductConfirmation(Request $request)
    {
        $nameAry = $request->input('name');
        $input2 = $request->input('quantity');
        $input3 = $request->input('category');
        $input4 = $request->input('price');
        $userid = $request->input('userid');

        $List = array();
        for($i = 0;$i<count($nameAry);$i++){
            $p = new Product();
            $p->product_name = $nameAry[$i];
            $p->product_qty = $input2[$i];
            $p->cat_id = $input3[$i];
            $p->price = $input4[$i];
            array_push($List, $p);
        }
        //array_push($List, $request->input('userid'));
        //return view('store_product_confirmation')->with('List',$List);
        //return view('user.store_product_confirmation', ['List' => $List]);
        //echo "Current User: ".$userid;
        return view('store_product_confirmation', compact('List', 'userid'));
    }

    public function storeProduct(Request $request)
    {
        $nameAry = $request->input('name');
        $qtyAry = $request->input('quantity');
        $catAry = $request->input('category');
        $priceAry = $request->input('price');

        $totalAmount = $request->input('totalAmount');
        $dueAmount = $request->input('dueAmount');
        $deadline = $request->input('deadline');
        $userid = $request->input('userid');

        /// Insert in cart table:
        $cart = new Cart();
        $cart->user_id = $userid;
        $cart->total_amount = $totalAmount;
        $cart->due_amount = $dueAmount;
        $cart->due_deadline = $deadline;
        $cart->cart_type = 0;
        $cart->save();

        /// Find the id of the last cart entry for buy table update:
        $results = DB::select('select * from carts order by id DESC');
        $cartid = -1;
        foreach ($results as $res) {
            $cartid = $res->id;
            break;
        }

        /// Take each product entry:
        for($i = 0;$i<count($nameAry);$i++){
            $p = new Product();
            $p->product_name = $nameAry[$i];
            $p->product_qty = $qtyAry[$i];
            $p->cat_id = $catAry[$i];
            $p->price = $priceAry[$i];
            
            /// Update in the product table:
            $results = DB::select('select * from products where product_name = ?', [$p->product_name]);
            if(count($results) == 0){
                /// Insert this item as a new one.
                $p->save();
            }else{
                /// Update the previous entry.
                foreach ($results as $res) {
                    $p->product_qty = $p->product_qty + $res->product_qty;
                    DB::table('products')
                        ->where('product_name', $p->product_name)
                        ->update(['product_qty' => $p->product_qty]);

                    DB::table('products')
                        ->where('product_name', $p->product_name)
                        ->update(['price' => $p->price]);
                }
            }

            /// Update in the buy table:
            $results = DB::select('select * from products where product_name = ?', [$p->product_name]);
            $prodid = -1;
            foreach ($results as $res) {
                $prodid = $res->id;
                break;
            }
            $b = new Buy();
            $b->product_id = $prodid;
            $b->product_qty = $qtyAry[$i];
            $b->user_id = $userid;
            $b->cart_id = $cartid;
            $b->price = $priceAry[$i];
            $b->save();
        }

        $productList = Product::all();
        return view('products')->with('productList',$productList);
    }
}
