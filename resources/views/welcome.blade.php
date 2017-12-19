@extends('layouts.app')

<style type="text/css">
  body{
    background-size: cover;
    background-repeat: no-repeat;
    background-position: center center;
    background-attachment: fixed; 
    background-image: url("http://sultantemizlikurunleri.com/wp-content/uploads/2015/03/blue-bg1.jpg");
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
<br><br>

    <div class="row">
    <div class="row col-md-6"> </div>
    <div class="row col-md-6 welcometext" id = "welcometext">
        <img src="https://preview.ibb.co/md19uF/Cement_Factory.jpg" alt="Smiley face" height="120" width="170" style="padding-top: 5px;">
        <img src="https://image.ibb.co/joKCEF/Rod_3.png" alt="Smiley face" height="120" width="170" style="padding-top: 5px;">
        <img src="https://image.ibb.co/b1PUuF/lafarge_ciment_fr_uk_584x328.jpg" alt="Smiley face" height="120" width="170" style="padding-top: 5px;">
    </div>
    </div>

    <div class="row">
    <div class="row col-md-6"> </div>
    <div class="row col-md-6 welcometext" id = "welcometext">
        <img src="" alt="Smiley face" height="120" width="170" style="visibility:hidden;">
        <img src="https://preview.ibb.co/hJ6sEF/cover.jpg" alt="Smiley face" height="120" width="170" style="padding-top: 5px;">
        <img src="https://image.ibb.co/hEZq1v/Tin.jpg" alt="Smiley face" height="120" width="170" style="padding-top: 5px;">
    </div>
    </div>

    <div class="row">
    <div class="row col-md-6">
    <div class="welcometext" id = "welcometext">
        <h2>Welcome to Tarango Enterprise</h2>
        <h4>We are here to meet all your needs to build your long dreaming house. We sell rod, cement, dhew tin, angel, flatbar and many more stuffs according to your need! We take pre orders and serve you the quality products faster than others</h4>
        <h3>We Are Obliged To Serve You The Best</h3>
        <h4>Call Us At 01712515215</h4>
    </div>
    </div>
    <div class="row col-md-6 welcometext" id = "welcometext">
        <img src="" alt="Smiley face" height="120" width="170" style="visibility:hidden">
        <img src="" alt="Smiley face" height="120" width="170" style="visibility:hidden">
        <img src="https://image.ibb.co/gM1sEF/Rod2.jpg" alt="Smiley face" height="120" width="170" style="padding-top: 5px;">
    </div>

    </div>
</div>

@endsection
