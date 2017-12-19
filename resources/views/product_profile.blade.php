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

  $prod_id = $pid;
  $slist = DB::select('select * from sells where product_id = ?', [$prod_id]);
  $curDate = date("Y-m-d");
  $costAry = array();

  for($i = 0;$i<12;$i++){
    $prevDate = prevMonth($curDate);
    array_push($costAry,0);
    foreach ($slist as $key) {
        $createDate = new DateTime($key->created_at);
        $date = $createDate->format('Y-m-d');
        if(dateInRange($prevDate,$curDate,$date)){
          $costAry[$i] = $costAry[$i] + $key->product_qty;
        }
    }
    $curDate = $prevDate;
  }
?>

<title>Product Profile</title>
<link rel="stylesheet" href="http://localhost/TarangoProject/public/css/tablestyle.css">
<script type="text/javascript" src="https://canvasjs.com/assets/script/jquery-ui.1.11.2.min.js"></script>
<script type="text/javascript" src="https://canvasjs.com/assets/script/jquery.canvasjs.min.js"></script>


<script type="text/javascript">
var cost = <?php echo json_encode($costAry); ?>;
window.onload = function () {
  //Better to construct options first and then pass it as a parameter
  var options1 = {
    title: {
      text: "Sell Statistics Over Last 12 Months"
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
    $slist = DB::select('select * from sells where product_id = ?', [$prod_id]);
    $blist = DB::select('select * from buys where product_id = ?', [$prod_id]);
    $plist = DB::select('select * from products where id = ?', [$prod_id]);
    $pinfo = "";
    $total_sold_qty = 0;
    $total_buy_qty = 0;
    $total_transaction = 0;
    $total_sold_amount = 0;
    $total_buy_amount = 0;
    $last_sold_date = "";
    $last_buy_date = "";

    foreach ($plist as $key) {
        $pinfo = $key;
        break;
    }

    foreach ($slist as $key) {
        $total_sold_qty = $total_sold_qty + $key->product_qty;
        $total_sold_amount = $total_sold_amount + $key->price*$key->product_qty;
        $total_transaction++;
    }

    $cartlist = DB::table('sells')
                ->where('product_id', $prod_id)
                ->orderBy('created_at', 'desc')
                ->get();

    foreach ($cartlist as $key) {
        $last_sold_date = new DateTime($key->created_at);
        $last_sold_date = $last_sold_date->format('Y-m-d');
        break;
    }

    foreach ($blist as $key) {
        $total_buy_qty = $total_buy_qty + $key->product_qty;
        $total_buy_amount = $total_buy_amount + $key->price*$key->product_qty;
        $total_transaction++;
    }

    $cartlist = DB::table('buys')
                ->where('product_id', $prod_id)
                ->orderBy('created_at', 'desc')
                ->get();

    foreach ($cartlist as $key) {
        $last_buy_date = new DateTime($key->created_at);
        $last_buy_date = $last_buy_date->format('Y-m-d');
        break;
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
      <div class="col-md-3">
      </div>

        <div class="col-md-6">
            <div class="well profile">

            <h2 style="text-align: center;"> <?php echo $pinfo->product_name; ?> </h2>
            <br>
            <div class="col-md-12" style="display: inline;">

                <div id = "img1" class="col-md-6">
                    <figure>
                        <img src="http://ddjmyers.com/ddj_cms/wp-content/uploads/2011/09/product-db.jpg" alt="" class="img-circle img-responsive"  height="200" width="200">
                    </figure>
                </div>
                <br>

                <div id = "info1" class="text-center" class="col-md-6">
                    <p><strong>সর্বমোট বিক্রয় মূল্যে: </strong> <?php echo $total_sold_amount; ?> </p>
                    <p><strong>সর্বমোট ক্রয় মূল্যে: </strong> <?php echo $total_buy_amount; ?> </p>
                    <p><strong>সর্বশেষ বিক্রয়ের তারিখ: </strong> <?php echo $last_sold_date; ?> </p>
                    <p><strong>সর্বশেষ ক্রয়ের তারিখ: </strong> <?php echo $last_buy_date; ?> </p>
                </div>

            </div>

            <div class="col-xs-12 divider text-center">
                <div class="col-xs-12 col-sm-4 emphasis">
                    <h2><strong> <?php echo $total_transaction; ?> </strong></h2>
                    <p><small>লেনদেনের সংখ্যা</small></p>
                </div>
                <div class="col-xs-12 col-sm-4 emphasis">
                    <h2><strong>  <?php echo $total_buy_qty; ?>  </strong></h2>                    
                    <p><small>ক্রয়ের পরিমাণ</small></p>
                </div>
                <div class="col-xs-12 col-sm-4 emphasis">
                    <h2><strong> <?php echo $total_sold_qty; ?> </strong></h2>
                    <p><small>বিক্রয়ের পরিমাণ</small></p>
                </div>
            </div>             
            </div>
        </div>
    </div>


<div class="container">
    <?php 
        if(count($slist) > 0){
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
            <th>কাস্টোমারের নাম</th>
            <th>পরিমাণ</th>
            <th>মূল্যে</th>
            </tr>
        </thead>
        
        <tbody>
            <?php
            foreach ($slist as $cur) {
              $clist = DB::select('select * from carts where id = ?', [$cur->cart_id]);
              $cartinfo = "";
              $uname = "";
              foreach ($clist as $ckey) {
                $cartinfo = $ckey;
                break;
              }
              $ulist = DB::select('select * from users where id = ?', [$cartinfo->user_id]);
              foreach ($ulist as $key) {
                $uname = $key->name;
                break;
              }

            ?>
                <tr>
                    <td><?php echo $cur->created_at?></td>
                    <td><?php echo $uname?></td>
                    <td><?php echo $cur->product_qty?></td>
                    <td><?php echo $cur->price?></td>
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
