@extends('layouts.app')

@section('head')
    <title>Add Category</title>
@endsection

@section('content')

<?php
  $admin_level = Session::get('admin_level');
?>

<?php
  if($admin_level == 10){
?>

<?php
    $headline = "নতুন ক্যাটেগরী এড করুন";
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
  <form role="form" method="POST" action="addcatsubmit" style="background-color:#E6E6FA;padding:10px;width: 100%">

    <div class="form-group">
        <label for="pwd">ক্যাটেগরীর নাম:</label>
        <input type="text" name="name" id="name" class="form-control" placeholder="Enter The Name" required>
    </div>

    {!! csrf_field() !!}

    <button type="submit" name="submit" id="addcatsubmit" value="addcatsubmit" class="btn btn-default" style="text-align:center;">Submit</button>
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