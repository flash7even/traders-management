@extends('layouts.app')

@section('head')
    <title>Add New User</title>
@endsection

@section('content')

<?php
  $admin_level = Session::get('admin_level');
?>

<?php
  if($admin_level == 10){
?>

<?php
    $headline = "নতুন কাস্টোমার/মহাজন এড করুন";
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
  <form role="form" method="POST" action="addusersubmit" style="background-color:#E6E6FA;padding:10px;width: 100%">

    <div class="form-group">
        <label for="pwd">নাম:</label>
        <input type="text" name="name" id="name" class="form-control" placeholder="Enter The Name" required>
    </div>

    {!! csrf_field() !!}
    
    <div class="form-group">
        <input type="hidden" name="password" id="password" class="form-control" value = "xyz123" readonly>
    </div>

    <div class="form-group">
        <input type="hidden" name="email" id="email" class="form-control" value = "abc@gmail.com" readonly>
    </div>

    <div class="form-group">
        <label for="pwd">মোবাইল নাম্বার:</label>
        <input type="text" name="mobile" id="mobile" class="form-control" placeholder="Enter User's Mobile Number" required>
    </div>

    <div class="form-group">
        <label for="pwd">এলাকার নাম:</label>
        <input type="text" name="address" id="address" class="form-control" placeholder="Enter The Address of The User" required>
    </div>

    <div class="form-group">
      <label for="pwd">মহাজন/কাস্টোমার</label>
        <select class="form-control" name="adminlevel" id="adminlevel" required>
          <option> মহাজন হলে "Seller" সিলেক্ট করুন, কাস্টোমার হলে "Buyer" সিলেক্ট করুন </option>
          <option> Buyer </option>
          <option> Seller </option>
        </select>
    </div>

    <button type="submit" name="submit" id="addusersubmit" value="addusersubmit" class="btn btn-default" style="text-align:center;">Submit</button>
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