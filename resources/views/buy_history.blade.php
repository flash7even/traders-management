@extends('layouts.app')

@section('head')
    <title>Buy History</title>
<link rel="stylesheet" href="http://localhost/TarangoProject/public/css/tablestyle.css">
<script type="text/javascript" src="https://canvasjs.com/assets/script/jquery-ui.1.11.2.min.js"></script>
<script type="text/javascript" src="https://canvasjs.com/assets/script/jquery.canvasjs.min.js"></script>
@endsection

@section('content')

<?php
  $admin_level = Session::get('admin_level');
?>

<?php
if($admin_level == 10){
?>

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
  
  $list = DB::select('select * from buys');
  $curDate = date("Y-m-d");
  $costAry = array();
  $perform = array();

  for($i = 0;$i<12;$i++){
    $prevDate = prevMonth($curDate);
    array_push($costAry,0);
    foreach ($list as $key) {
        $createDate = new DateTime($key->created_at);
        $date = $createDate->format('Y-m-d');
        if(dateInRange($prevDate,$curDate,$date)){
          $costAry[$i] = $costAry[$i] + $key->price;
        }
    }
    $curDate = $prevDate;
  }
?>

<?php
    
    class buyClass{
        var $date;
        var $item_name;
        var $user_name;
        var $price;
        var $quantity;
    }

    $List = array();
    $buylist = DB::table('buys')->get();
    foreach ($buylist as $cur) {
        $t = new buyClass();
        $t->date = $cur->created_at;
        $t->quantity = $cur->product_qty;
        $t->price = $cur->price;
        $res = DB::select('select * from users where id = ?', [$cur->user_id]);
        foreach ($res as $r) {
            $t->user_name = $r->name;
            break;
        }
        $res = DB::select('select * from products where id = ?', [$cur->product_id]);
        foreach ($res as $r) {
            $t->item_name = $r->product_name;
            break;
        }
        array_push($List, $t);
    }
    
?>

<script type="text/javascript">
var cost = <?php echo json_encode($costAry); ?>;
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

<div class="container">
    <div class="row">
        <div>
            <h2 style="text-align: center;">ক্রয়ের সকল হিসাব</h2>
        </div>
      <!-- Table -->
        <table class="table" id = "tablecss">
        <thead>
            <tr>
            <th>তারিখ</th>
            <th>প্রোডাক্টের নাম</th>
            <th>মহাজনের নাম</th>
            <th>পরিমাণ</th>
            <th>মূল্যে</th>
        </tr>
        </thead>
        
        <tbody>
            <?php
            foreach ($List as $cur) {
            ?>
                <tr>
                    <td><?php echo $cur->date?></td>
                    <td><?php echo $cur->item_name?></td>
                    <td><?php echo $cur->user_name?></td>
                    <td><?php echo $cur->quantity?></td>
                    <td><?php echo $cur->price?></td>
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

    </div>
</div>

<div class="container">
    <br><br>
    <div class="row">
    <div id="resizable" style="height: 420px;border:1px solid gray;">
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