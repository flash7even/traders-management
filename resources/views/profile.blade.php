@extends('layouts.app')

<style>
    @import url(http://fonts.googleapis.com/css?family=Lato:400,700);
    body
    {
        font-family: 'Lato', 'sans-serif';
    }
    .profile 
    {
        min-height: 300px;
        display: inline-block;
    }
</style>

@section('head')

<?php
  /// This php part calculate the transaction statistics in last 1 year.
  /// Then store it for showing in jquery chart

  function dateInRange($start_date, $end_date, $date_from_user){
    $start_ts = strtotime($start_date);
    $end_ts = strtotime($end_date);
    $user_ts = strtotime($date_from_user);
    return (($user_ts > $start_ts) && ($user_ts <= $end_ts));
  }

  function prevMonth($date) {
      $date = new DateTime($date);
      $day = $date->format('j');
      $next_month_day = $date->format('j');
      $date->modify('last day of last month');
      return $date->format("Y-m-d");
  }

  $uid = $user_id;
  $editlink = "edituser/".$uid;
  $editlink2 = "edituserdue/".$uid;
  $cartlist = DB::select('select * from carts where user_id = ?', [$uid]);
  $curDate = date("Y-m-d");
  $costAry = array();
  $perform = array();

  for($i = 0;$i<12;$i++){
    $prevDate = prevMonth($curDate);
    array_push($costAry,0);
    foreach ($cartlist as $key) {
        $createDate = new DateTime($key->created_at);
        $date = $createDate->format('Y-m-d');
        if(dateInRange($prevDate,$curDate,$date)){
          $costAry[$i] = $costAry[$i] + $key->total_amount;
        }
    }
    $curDate = $prevDate;
  }

  $cartlist = DB::table('carts')
                ->where('user_id', $uid)
                ->orderBy('id', 'desc')
                ->get();
  foreach ($cartlist as $key) {
      array_push($perform, $key->rating);
      if(count($perform) == 10) break;
  }
  while(count($perform)<10){
      array_push($perform, 0);
  }

?>

<title>User Profile</title>
<link rel="stylesheet" href="http://localhost/TarangoProject/public/css/tablestyle.css">
<script type="text/javascript" src="https://canvasjs.com/assets/script/jquery-ui.1.11.2.min.js"></script>
<script type="text/javascript" src="https://canvasjs.com/assets/script/jquery.canvasjs.min.js"></script>
<script type="text/javascript">
    var cost = <?php echo json_encode($costAry); ?>;
    var perf = <?php echo json_encode($perform); ?>;
    $(function () {

    //Better to construct options first and then pass it as a parameter
    var options = {
      exportEnabled: true,
                  animationEnabled: true,
      title: {
        text: "Performance of User"
      },
      data: [
      {
        type: "splineArea", //change it to line, area, bar, pie, etc
        dataPoints: [
          { x: 1, y: perf[0] },
          { x: 2, y: perf[1] },
          { x: 3, y: perf[2] },
          { x: 4, y: perf[3] },
          { x: 5, y: perf[4] },
          { x: 6, y: perf[5] },
          { x: 7, y: perf[6] },
          { x: 8, y: perf[7] },
          { x: 9, y: perf[8] },
          { x: 10, y: perf[9] },
        ]
      }
      ]
    };

    $("#chartContainer").CanvasJSChart(options);

});
</script>


<script type="text/javascript">
window.onload = function () {
  //Better to construct options first and then pass it as a parameter
  var options1 = {
    title: {
      text: "Transactions Statistics Over Last 12 Months"
    },
                animationEnabled: true,
    data: [
    {
    type: "column", //change it to line, area, bar, pie, etc
      dataPoints: [
        { x: 1, y: cost[0] },
        { x: 2, y: cost[1] },
        { x: 3, y: cost[2] },
        { x: 4, y: cost[3] },
        { x: 5, y: cost[4] },
        { x: 6, y: cost[5] },
        { x: 7, y: cost[6] },
        { x: 8, y: cost[7] },
        { x: 9, y: cost[8] },
        { x: 10, y: cost[9] },
        { x: 11, y: cost[10] },
        { x: 12, y: cost[11] },
      ]
    }
    ]
  };

  $("#resizable").resizable({
    create: function (event, ui) {
      //Create chart.
      $("#chartContainer1").CanvasJSChart(options1);
    },
    resize: function (event, ui) {
      //Update chart size according to its container's size.
      $("#chartContainer1").CanvasJSChart().render();
    }
  });

}
</script>

@endsection

<?php 
    $cartlist = DB::select('select * from carts where user_id = ?', [$uid]);
    $userlist = DB::select('select * from users where id = ?', [$uid]);
    $depositlist = DB::select('select * from deposit where user_id = ?', [$uid]);
    $uinfo = "";
    $total_amount = 0;
    $total_transaction = 0;
    $due_amount = 0;
    $start_date = "";
    $last_tran_date = "";

    foreach ($userlist as $key) {
        $uinfo = $key;
        break;
    }

    foreach ($cartlist as $key) {
        $total_amount = $total_amount + $key->total_amount;
        $due_amount = $due_amount + $key->due_amount;
        $total_transaction++;
    }

    foreach ($depositlist as $key) {
        $due_amount = $due_amount - $key->deposit_amount;
    }

    if (Session::has('due_amount')) {
      Session::forget('due_amount');
    }
    Session::put('due_amount', $due_amount);

    $cartlist = DB::table('carts')
                ->where('user_id', $uid)
                ->orderBy('created_at', 'desc')
                ->get();

    foreach ($cartlist as $key) {
        $last_tran_date = new DateTime($key->created_at);
        $last_tran_date = $last_tran_date->format('Y-m-d');
        break;
    }

    $start_date = new DateTime($uinfo->created_at);
    $start_date = $start_date->format('Y-m-d');

    $identity = $uinfo->name." [";
    if($uinfo->admin == 10){
        $identity = $identity."Boss]";
    }else if($uinfo->admin == 1){
        $identity = $identity."কাস্টোমার]";
    }else if($uinfo->admin == 0){
        $identity = $identity."মহাজন]";
    }
?>

@section('content')

<?php
  $admin_level = Session::get('admin_level');
?>

<?php
if($admin_level == 10){
?>


<div class="container">
    <div class="row">
        <div class="col-md-6">
            <div class="well profile">

            <h2 style="text-align: center;"> <?php echo $identity; ?> </h2>
            <br>
            <div class="col-md-12" style="display: inline;">

                <div id = "img1" class="col-md-6">
                    <figure>
                        <img src="https://x1.xingassets.com/assets/frontend_minified/img/users/nobody_m.original.jpg" alt="" class="img-circle img-responsive"  height="200" width="200">
                    </figure>
                </div>
                <br>

                <div id = "info1" class="text-center" class="col-md-6">
                    <p><strong>এলাকা: </strong> <?php echo $uinfo->address; ?> </p>
                    <p><strong>ইমেইল: </strong> <?php echo $uinfo->email; ?> </p>
                    <p><strong>মোবাইল: </strong> <?php echo $uinfo->mobile; ?> </p>
                    <p><strong>সর্বশেষ লেনদেন: </strong> <?php echo $last_tran_date; ?> </p>
                    <p><strong>প্রথম লেনদেন: </strong> <?php echo $start_date; ?> </p>
                    <button type="button" class="btn btn-default"><a href= <?php echo $editlink; ?> >এডিট</a></button>
                    <button type="button" class="btn btn-default"><a href= <?php echo $editlink2; ?> >বাকি আপডেট</a></button>
                </div>

            </div>

            <div class="col-xs-12 divider text-center">
                <div class="col-xs-12 col-sm-4 emphasis">
                    <h2><strong> <?php echo $total_transaction; ?> </strong></h2>
                    <p><small>লেনদেনের সংখ্যা</small></p>
                </div>
                <div class="col-xs-12 col-sm-4 emphasis">
                    <h2><strong>  <?php echo $total_amount; ?>  </strong></h2>                    
                    <p><small>সর্বমোট লেনদেনের পরিমাণ</small></p>
                </div>
                <div class="col-xs-12 col-sm-4 emphasis">
                    <h2><strong> <?php echo $due_amount; ?> </strong></h2>
                    <p><small>বাকির পরিমাণ</small></p>
                </div>
            </div>             
            </div>
        </div>
        <div class="col-md-6"  id="resizable" style="height: 465px;border:1px solid gray;"">
            <div id="chartContainer" style="height: 100%;width: 100%;"></div>
        </div>
    </div>


<div class="container">
    <?php 
        if(count($cartlist) > 0){
    ?>
    <div class="row">
        <div>
            <h2 style="text-align: center;">সর্বশেষ লেনদেনের হিসাব</h2>
        </div>

        @if(Auth::check())
      <!-- Table -->
        <table class="table" id = "tablecss">
        <thead>
            <tr>
            <th>তারিখ</th>
            <th>সর্বমোট মূল্যে</th>
            <th>জমার পরিমাণ</th>
            <th>বাকির পরিমাণ</th>
            <th>বাকি জমার ডেডলাইন</th>
            </tr>
        </thead>
        
        <tbody>
            <?php
            foreach ($cartlist as $cur) {
            ?>
                <tr>
                    <td><?php echo $cur->created_at?></td>
                    <td><?php echo $cur->total_amount?></td>
                    <td><?php echo $cur->total_amount - $cur->due_amount?></td>
                    <td><?php echo $cur->due_amount?></td>
                    <td><?php echo $cur->due_deadline?></td>
                </tr>
            <?php 
            }
            ?>
        </tbody>

        </table>


        @endif
    </div>
    <?php } ?>
            <script type="text/javascript">
            $(document).ready( function () {
                $('table').DataTable();
            } );
        </script>
    <br><br>
  <div class="row">
    <div id="resizable" style="height: 500px;border:1px solid gray;">
      <div id="chartContainer1" style="height: 100%; width: 100%;"></div>
    </div>
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
