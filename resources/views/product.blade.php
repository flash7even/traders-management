@extends('layouts.app')

@section('head')
    <title>Product List</title>
<link rel="stylesheet" href="http://localhost/TarangoProject/public/css/tablestyle.css">
@endsection

@section('content')


@if(Auth::check())

<?php
    $ucat_id = Session::get('ucat_id');
?>

<div class="container">
  <div class="row">
      <div>
      <h2 style="text-align: center;">সকল ক্যাটেগরী এর লিস্ট</h2>
      </div>
      <?php
        if($ucat_id == 0){
      ?>
              <div class="user_list" style="border: 1px solid #ddd; padding: 1px;">
                <a href= "product/0" class="name list-group-item list-group-item-primary" id = "ucat_id" value = 0 > <h4> All </h4> </a>
              </div>
        <?php
        }else{
        ?>
              <div class="user_list" style="border: 1px solid #ddd; padding: 1px;">
                <a href= "product/0" class="name list-group-item list-group-item-info" id = "ucat_id" value = 0 > <h4> All </h4> </a>
              </div>
        <?php
        }
            $catlist = DB::table('categories')->get();
            foreach ($catlist as $key) {
                $cat_id = $key->id;
                $cat_name = $key->category;

                $link = "product/".$cat_id;
                if($key->id == $ucat_id){
        ?>
                <div class="user_list" style="border: 1px solid #ddd; padding: 1px;">
                  <a href= <?php echo $link ?> class="name list-group-item list-group-item-primary" id = "ucat_id" value = <?php echo $cat_id; ?> > <h4> <?php echo $cat_name; ?> </h4> </a>
                </div>
                
                <?php
                }else{
                ?>

                <div class="user_list" style="border: 1px solid #ddd; padding: 1px;">
                  <a href= <?php echo $link ?> class="name list-group-item list-group-item-info" id = "ucat_id" value = <?php echo $cat_id; ?> > <h4> <?php echo $cat_name; ?> </h4> </a>
                </div>
        <?php
                }
            }
        ?>
  </div>
</div>

<br><br>


<?php
    
    class itemClass{
        var $item_name;
        var $item_id;
        var $cat_name;
        var $price;
        var $quantity;
        var $date;
    }
    
    $List = array();
    $headline = "প্রোডাক্টের লিস্ট [ ক্যাটেগরী :  ";

    $cat_name = "All";

    if($ucat_id != 0){
      $selllist = DB::select('select * from products where cat_id = ?', [$ucat_id]);
      $clist = DB::select('select * from categories where id = ?', [$ucat_id]);
      foreach ($clist as $key) {
        $cat_name = $key->category;
        break;
      }
    }else{
      $selllist = DB::table('products')->get();
    }
    $headline = $headline.$cat_name;
    $headline = $headline." ]";
?>

<div class="container">
    <div class="row">
                
              <div>
                  <h2 style="text-align: center;"> <?php echo $headline; ?> </h2>
                  <h4 style="text-align: center;">কোন প্রোডাক্টের সকল ইনফরমেশন জানতে  তার নামের উপর ক্লিক করুন</h4>
              </div>
                      <!-- Table -->
                      <table class="table" id = "tablecss">
                          <tbody>
                            <?php 
                                foreach ($selllist as $pkey) {
                                  $plink = "productinfo/".$pkey->id;
                            ?>
                                <tr>
                                  <div style="height: 50px;">
                                  <a href= <?php echo $plink ?> class="name list-group-item" id = "pid" value = <?php echo $pkey->id; ?> > <h4> <?php echo $pkey->product_name; ?> </h4> </a>
                                  </div>
                                </tr>
                            <?php
                                }
                            ?>
                          </tbody>
                      </table>

            </div>
</div>
@endif

@if(Auth::guest())
<div class="container">
    <div  class="row" style="
      position: absolute;
      width: 800px;
      height: 80px;
      z-index: 15;
      top: 50%;
      left: 33%;
      margin: -100px 0 0 -150px;
      background: #E7EBF9;
      text-align: center;">
        <h2>Sorry!You Are Not Authorized To View This Page</h2>
    </div>
</div>
@endif


@endsection