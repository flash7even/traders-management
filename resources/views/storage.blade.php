@extends('layouts.app')

@section('head')
    <title>Product List</title>
<link rel="stylesheet" href="http://localhost/TarangoProject/public/css/tablestyle.css">
@endsection

@section('content')

<?php
  $admin_level = Session::get('admin_level');
?>

<?php
if($admin_level == 10){
?>


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
                <a href= "storage/0" class="name list-group-item list-group-item-primary" id = "ucat_id" value = 0 > <h4> All </h4> </a>
              </div>
        <?php
        }else{
        ?>
              <div class="user_list" style="border: 1px solid #ddd; padding: 1px;">
                <a href= "storage/0" class="name list-group-item list-group-item-info" id = "ucat_id" value = 0 > <h4> All </h4> </a>
              </div>
        <?php
        }
            $catlist = DB::table('categories')->get();
            foreach ($catlist as $key) {
                $cat_id = $key->id;
                $cat_name = $key->category;

                $link = "storage/".$cat_id;
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
    $headline = "আপনার বর্তমান স্টোরেজ [ ক্যাটেগরী :  ";
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
    
    foreach ($selllist as $cur) {
        $t = new itemClass();
        $t->item_name = $cur->product_name;
        $t->item_id = $cur->id;
        $t->quantity = $cur->product_qty;
        $t->price = $cur->price;
        $t->date = $cur->updated_at;
        $res = DB::select('select * from categories where id = ?', [$cur->cat_id]);
        foreach ($res as $r) {
            $t->cat_name = $r->category;
            break;
        }
        array_push($List, $t);
    }
    
?>

<div class="container">
    <div class="row">
                
              <div>
                  <h2 style="text-align: center;"> <?php echo $headline; ?> </h2>
              </div>
                      <!-- Table -->
                      <table class="table" id = "tablecss">
                          <thead>
                            <tr>
                              <th>প্রোডাক্টের নাম</th>
                              <th>ক্যাটেগরী</th>
                              <th>পরিমাণ</th>
                              <th>মূল্য</th>
                              <th>সর্বশেষ লেনদেন</th>
                          </tr>
                          </thead>
                          <tbody>
                            <?php 
                                foreach ($List as $item) {
                            ?>
                                <tr>
                                  <td><?php echo $item->item_name?></td>
                                  <td><?php echo $item->cat_name?></td>
                                  <td><?php echo $item->quantity?></td>
                                  <td><?php echo $item->price?></td>
                                  <td><?php echo $item->date?></td>
                                </tr>
                            <?php
                                }
                            ?>
                          </tbody>
                      </table>

        <script type="text/javascript">
            $(document).ready( function () {
                $('table').DataTable();
            } );
        </script>


            </div>
</div>

<?php
}else{
?>

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

<?php
}
?>


@endsection