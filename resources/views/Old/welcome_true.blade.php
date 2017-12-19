@extends('layouts.app')

<style type="text/css">
  body{
    background-size: cover;
    background-repeat: no-repeat;
    background-position: center center;
    background-attachment: fixed; 
    background-image: url("https://preview.ibb.co/kn56jF/icanandiwill.jpg");
  }
  div.welcometext{
    text-align: center;
    color: #13173B;
    font-style: oblique;
  }
</style>

@section('head')


@endsection

<?php
  if (Session::has('ucat_id')) {

  }else{
    Session::put('ucat_id', '0');
  }
?>

@section('content')

<div class="container" >
<br><br><br><br><br><br><br><br>
    <div class="row col-md-9 welcometext" id = "welcometext">
        <h2>Welcome to Tarango Enterprise</h2>
        <h3>We Are Here to Meet All of Your Needs to Build Your House!</h3>
        <h3>We Sell Rod, Cement, Dhew Tin, Angel And Many More Stuffs!</h3>
    </div>
</div>

@endsection
