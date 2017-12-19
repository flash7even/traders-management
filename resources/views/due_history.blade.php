@extends('layouts.app')

@section('head')
    <title>Due History</title>
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
    
    class dueClass{
        var $date;
        var $user_name;
        var $amount;
    }
    $List = array();
    $selllist = DB::table('carts')->get();
    foreach ($selllist as $cur) {
        if($cur->due_amount <= 0) continue;
        $t = new dueClass();
        $t->date = $cur->due_deadline;
        $t->amount = $cur->due_amount;
        $res = DB::select('select * from users where id = ?', [$cur->user_id]);
        foreach ($res as $r) {
            $t->user_name = $r->name;
            break;
        }
        array_push($List, $t);
    }
    
?>

<div class="container">
    <div class="row">
        <div>
            <h2 style="text-align: center;">বাকির সকল হিসাব</h2>
        </div>

        @if(Auth::check())
      <!-- Table -->
        <table class="table" id = "tablecss">
        <thead>
            <tr>
            <th>জমার ডেডলাইন</th>
            <th>কাস্টোমারের নাম</th>
            <th>বাকির পরিমাণ</th>
            </tr>
        </thead>
        
        <tbody>
            <?php
            foreach ($List as $cur) {
            ?>
                <tr>
                    <td><?php echo $cur->date?></td>
                    <td><?php echo $cur->user_name?></td>
                    <td><?php echo $cur->amount?></td>
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

        @endif
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