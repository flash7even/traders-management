@extends('layouts.app')

@section('head')

<title>Buy</title>

@endsection

@section('content')

<?php
  $admin_level = Session::get('admin_level');
?>

<?php
if($admin_level == 10){
?>

<?php
    //$results = DB::table('users')->get();
    $results = DB::select('select * from users where admin = ?', ['0']);
?>

<div class="container">
  <div class="">

  <div>
      <h2 style="text-align: center;">ক্রয়ের জন্যে মহাজনের নাম সিলেক্ট করুন</h2>
  </div>
    <?php
        foreach ($results as $res) {
            if($res->admin != 0) continue;
            $user_id = $res->id;
            $info = "";
            $tmp = $res->name." [";
            $info = $info.$tmp;
            $tmp = $res->address."]";
            $info = $info.$tmp;

            $link = "wanttobuy/".$user_id;
    ?>
                <div class="user_list" style="border: 1px solid #ddd; padding: 1px;">
                  <a style="background-color: #C2E3FF" href= <?php echo $link ?> class="name list-group-item list-group-item-info" id = "user_id" value = <?php echo $user_id; ?> > <h4> <?php echo $info; ?> </h4> </a>
                </div>
    <?php
        }
    ?>
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