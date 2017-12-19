@extends('layouts.app')

@section('head')
<title>Success</title>
@endsection

@section('content')

@if(Auth::check())
<div class="container">
    <div class="row">
      <div class="col-md-2">
        
      </div>
        <div id = "img1" class="col-md-8">
            <figure>
                <img src="https://marketing4ecommerce.mx/wp-content/uploads/2015/12/Personalizacion2Ok.jpg" alt="" class="img-circle img-responsive"  height="100%" width="100%">
            </figure>
        </div>
    </div>
    <div  class="row">
        <h2 style="text-align: center;">সকল আপডেট সফলভাবে সম্পন্যে হয়েছে</h2>
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
        <div>
        <h2>Sorry!You Are Not Authorized To View This Page</h2>
        </div>
    </div>
</div>
@endif

@endsection
