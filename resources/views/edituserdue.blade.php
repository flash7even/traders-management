@extends('layouts.app')

@section('head')
    <title>Edit User Info</title>
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
    $headline = "কাস্টোমারের বাকির হিসাব আপডেট করুন";
    $uinfo = "";
    $list = DB::select('select * from users where id = ?', [$userid]);
    foreach ($list as $key) {
      $uinfo = $key;
      break;
    }
    $due_amount = Session::get('due_amount');
    Session::forget('due_amount');
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
  <form role="form" method="POST" action="edituserduesubmit" style="background-color:#E6E6FA;padding:10px;width: 100%">

    <div class="form-group">
        <label for="pwd">ইউজার আইডি: [এখানে কিছু করার দরকার নাই]</label>
        <input type="number" name="userid" id="userid" class="form-control" value="<?php echo $userid; ?>" readonly>
    </div>

    <div class="form-group">
        <label for="pwd">নাম: [এখানে কিছু করার দরকার নাই]</label>
        <input type="text" name="username" id="username" class="form-control" value="<?php echo $uinfo->name; ?>" readonly>
    </div>

    <div class="form-group">
        <label for="pwd">সর্বমোট বাকির পরিমাণ:</label>
        <input type="number" name="totaldue" id="totaldue" class="form-control" value="<?php echo $due_amount; ?>" readonly>
    </div>

    {!! csrf_field() !!}
    
    <div class="form-group">
        <label for="pwd">এখন জমার পরিমাণ:</label>
        <input type="number" name="deposit" id="deposit" class="form-control" placeholder="Enter Deposit Amount" required>
    </div>

    <button type="submit" name="submit" id="edituserduesubmit" value="edituserduesubmit" class="btn btn-default" style="text-align:center;">Submit</button>
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