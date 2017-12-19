@extends('layouts.app')

@section('head')
    <title>Confirmation Page</title>
@endsection

@section('content')

<?php
  $admin_level = Session::get('admin_level');
?>

<?php
if($admin_level == 10){
?>


<?php
  $userid = $uid;

    $username = "";
    $list = DB::select('select * from users where id = ?', [$uid]);
    foreach ($list as $key) {
      $username = $key->name;
      break;
    }
    $headline = "বিক্রয়ের সকল হিসাব কনফার্ম করুণ [কাস্টোমার: ".$username;
    $headline = $headline."]";
?>

<style type="text/css">
  
</style>

<div class="container" style="
  background-color:#E6E6FA;
  text-align:center;
  border-color: #F8F8FC;">
  <h2 style="color:#00005C;"><?php echo $headline; ?></h2>
</div>
</br>
<div class="container">
<div class="row">
  <form role="form" method="POST" action="sellitemconfirm" style="background-color:#E6E6FA;padding:10px;width: 100%">

    <table id = "myTable" style="width: 100%;text-align: center;">
        {!! csrf_field() !!}
        <thead>
        <th><label for='name'>প্রোডাক্টের নাম</label></th>
        <th><label for='category'>ক্যাটেগরী</label></th>
        <th><label for='quantity'>পরিমাণ</label></th>
        <th><label for='price'>মূল্য</label></th>
        </thead>

        <tbody>
	  	<?php
	  		$total = count($List);
	  		$totalPrice = 0;
	  		foreach ($List as $key) {
          $totalPrice += ($key->price * $key->product_qty);
          $product_name = "";
          $cat_name = "";
          $cat_id = "";
          $product_qty = $key->product_qty;
          $price = $key->price;
          $plist = DB::select('select * from products where id = ?', [$key->product_id]);
          foreach ($plist as $p) {
            $product_name = $p->product_name;
            $cat_id = $p->cat_id;
            break;
          }
          $clist = DB::select('select * from categories where id = ?', [$cat_id]);
          foreach ($clist as $p) {
            $cat_name = $p->category;
            break;
          }
	  	?>
		        <tr>
		        <td><input class="name form-control" id="name[]" name="name[]"  value= "<?php echo $product_name;  ?>" readonly></td>
		        <td><input class="category form-control" id="category[]" type="text" name="category[]"  value= "<?php echo $cat_name;  ?>" readonly></td>
		        <td><input class="quantity form-control" id="quantity[]" type="number" name="quantity[]"  value= <?php echo $product_qty;  ?> readonly></td>
		        <td><input class="price form-control" id="price[]" type="number" name="price[]"  value= <?php echo $price;  ?> readonly></td>
		        </tr>
	  	<?php
	  		}
	  	?>
	  	</tbody>
    </table>
    <br>

    <div class="form-group">
        <label for="pwd">সর্বমোট মূল্যে:</label>
        <input class="name form-control" id="totalAmount" type="number" name="totalAmount"  value= <?php echo $totalPrice;  ?> readonly>
    </div>

    <div class="form-group">
        <label for="pwd">জমার পরিমাণ:</label>
        <input type="number" name="depositAmount" id="depositAmount" class="form-control" placeholder="Enter Deposited Amount" required>
    </div>

    <div class="form-group">
        <label for="pwd">১ থেকে ১০ এর মধ্যে রেটিং: [লেনদেন করে আপনি কতটুকু সন্তুষ্ট]</label>
        <input type="number" name="rating" id="rating" class="form-control" placeholder="Enter The Rating of This Transaction" required>
    </div>

    <div class="form-group">
        <input class="name form-control" id="userid" type="hidden" name="userid"  value= <?php echo $userid;  ?>>
    </div>

    <button type="submit" name="submit" id="sellitemconfirm" value="sellitemconfirm" class="btn btn-default" style="text-align:center;">Confirm</button>
  </form>
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