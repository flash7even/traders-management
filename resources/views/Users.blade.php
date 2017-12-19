@extends('layouts.app')

@section('head')

<title>User List</title>

@endsection

@section('content')

<?php
  $admin_level = Session::get('admin_level');
?>

<?php
if($admin_level == 10){
?>


<?php
    $results = DB::table('users')->get();
?>

<div class="container">
  <div class="">

  <div>
      <h2 style="text-align: center;">সকল কাস্টোমার এবং মহাজনের লিস্ট</h2>
      <h4 style="text-align: center;">কোন কাস্টোমার/মহাজনের সকল ইনফরমেশন জানতে  তার নামের উপর ক্লিক করুন</h4>
  </div>
    <?php
        $cnt = 1;
        foreach ($results as $res) {
            if($res->admin > 1) continue;
            $user_id = $res->id;
            $info = "";
            $tmp = $res->name." [";
            $info = $info.$tmp;
            $tmp = $res->address."]";
            $info = $info.$tmp;

            $link = "wanttoseeprofile/".$user_id;
    ?>
            <div class="user_list" style="border: 1px solid #ddd; padding: 1px;">
              <a href= <?php echo $link ?> class="name list-group-item list-group-item-info" id = "user_id" value = <?php echo $user_id; ?> > <h4> <?php echo $info; ?> </h4> </a>
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