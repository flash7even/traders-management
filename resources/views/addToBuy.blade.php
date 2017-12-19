@extends('layouts.app')

<?php 
?>

@section('head')

<?php
    $productlist = DB::table('products')->get();
    $itemarray = array();
    foreach ($productlist as $prod) {
        array_push($itemarray, $prod->product_name);
    }

    $uid = $user_id;
    $username = "";
    $orderlist = DB::select('select * from orders where user_id = ?', [$uid]);
    $list = DB::select('select * from users where id = ?', [$uid]);
    foreach ($list as $key) {
      $username = $key->name;
      break;
    }
    $headline = $username." এর কাছে আপনার সকল অর্ডারের লিস্ট";
    $headline2 = $username." এর কাছে আপনি এখনো কোন অর্ডার করেন নাই";

    $linkconfirm = "conformbuyorder/".$uid;
    $linkupdate = "updatebuyorder/".$uid;
?>

<!-- Java Script Part for Search -->

<title>Order Item to Buy</title>

@endsection

@section('content')

<?php
  $admin_level = Session::get('admin_level');
?>

<?php
if($admin_level == 10){
?>

<style type="text/css">
.tt-query {
  -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
     -moz-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
          box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
}

.tt-hint {
  color: #999
}

.tt-menu {    /* used to be tt-dropdown-menu in older versions */
  width: 422px;
  margin-top: 4px;
  padding: 4px 0;
  background-color: #fff;
  border: 1px solid #ccc;
  border: 1px solid rgba(0, 0, 0, 0.2);
  -webkit-border-radius: 4px;
     -moz-border-radius: 4px;
          border-radius: 4px;
  -webkit-box-shadow: 0 5px 10px rgba(0,0,0,.2);
     -moz-box-shadow: 0 5px 10px rgba(0,0,0,.2);
          box-shadow: 0 5px 10px rgba(0,0,0,.2);
}

.tt-suggestion {
  padding: 3px 20px;
  line-height: 24px;
}

.tt-suggestion.tt-cursor,.tt-suggestion:hover {
  color: #fff;
  background-color: #0097cf;

}

.tt-suggestion p {
  margin: 0;
}

    #outPopUp {
      position: absolute;
      width: 600px;
      height: 160px;
      z-index: 15;
      top: 50%;
      left: 40%;
      margin: -100px 0 0 -150px;
      background: #E7E7E7;
      text-align: center;
    }

</style>

<div class="container">
    <div class="row">
            <?php
                if(count($orderlist) > 0){
            ?>
            <div class="container" style= "
              padding:5px;
              width:1150px;
              text-align:left;">
              <h2 style="color:#00005C; text-align: center;"> <?php echo $headline; ?> </h2>
              <br>
            </div>
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>প্রোডাক্টের নাম</th>
                  <th>ক্যাটেগরী</th>
                  <th>পরিমাণ</th>
                  <th>মূল্যে</th>
                  <th>অর্ডার বাতিল</th>
                </tr>
              </thead>
              <tbody>
                <?php 
                  foreach ($orderlist as $key) {
                    $product_name = "";
                    $cat_name = "";
                    $cat_id = "";
                    $product_qty = $key->product_qty;
                    $price = $key->price;
                    $plist = DB::select('select * from products where id = ?', [$key->product_id]);
                    foreach ($plist as $p) {
                      $product_name = $p->product_name;
                      $cat_id = $p->cat_id;
                      break;
                    }
                    $clist = DB::select('select * from categories where id = ?', [$cat_id]);
                    foreach ($clist as $p) {
                      $cat_name = $p->category;
                      break;
                    }
                    $rlink = "removerorder/".$uid."/".$key->id;
                ?>
                <tr>
                  <td><?php echo $product_name; ?></td>
                  <td><?php echo $cat_name; ?></td>
                  <td><?php echo $product_qty; ?></td>
                  <td><?php echo $price; ?></td>
                  <td> <button type="button" class="btn btn-default"><a href= <?php echo $rlink; ?> >Remove</a></button> </td>
                </tr>
                <?php } ?>
              </tbody>
            </table>
            <input type="button" id="more_fields" onclick="" data-toggle="modal" data-target="#myModal" value="Add New" class="btn btn-info" />
            <button type="button" class="btn btn-default"><a href= <?php echo $linkconfirm; ?> >Confirm</a></button>
            <?php
            }else{
            ?>
            <div class="row" id="outPopUp">
                    <h2><?php echo $headline2; ?></h2>
                <input type="button" id="more_fields" onclick="" data-toggle="modal" data-target="#myModal" value="Add The First Order" class="btn btn-info" />
            </div>

            <?php
            }
            ?>

            <!-- Modal -->
            <div class="modal fade" id="myModal" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-body">
                        <!-- Include the body part here -->
                        <h3>নতুন অর্ডারের ইনফরমেশন এড করুন:</h3>
                        <form method="post" action=<?php echo $linkupdate; ?> role = "form">
                        <table id = "myTable">
                            <thead>
                            <th><label for='name'>প্রডাক্ট এর নাম</label></th>
                            <th><label for='name'>পরিমাণ</label></th>
                            <th><label for='name'>মূল্যে</label></th>
                            </thead>
                            {!! csrf_field() !!}
                            <tr>

                            <td id="tt"><input class="typeahead form-control" id="name" type="text" name="name" placeholder="Name" required></td>

                            <td><input class="quantity form-control" id="quantity" type="number" name="quantity" placeholder="Quantity" required></td>
                            <td><input class="price form-control" id="price" type="number" name="price" placeholder="Price" required></td>
                            </tr>
                    
                        </table>
                        <br>
                        <div class="row">
                        <div class="col-md-8"></div>
                        <div class="col-md-4">
                        <button type="button" class="btn btn-info" data-dismiss="modal">Go Back</button>
                        <button type="submit" name="submit" id="updatebuyorder" value="updatebuyorder" class="btn btn-default" style="text-align:center;">Submit</button>
                        </div>
                        </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                    </div>
                </div>
              
            </div>
            </div>

      </div>
</div>

<script type="text/javascript">
var substringMatcher = function(strs) {
  return function findMatches(q, cb) {
    var matches, substringRegex;

    // an array that will be populated with substring matches
    matches = [];

    // regex used to determine if a string contains the substring `q`
    substrRegex = new RegExp(q, 'i');

    // iterate through the pool of strings and for any string that
    // contains the substring `q`, add it to the `matches` array
    $.each(strs, function(i, str) {
      if (substrRegex.test(str)) {
        matches.push(str);
      }
    });

    cb(matches);
  };
};

var states = <?php echo json_encode($itemarray); ?>;

$('#tt .typeahead').typeahead({
  hint: true,
  highlight: true,
  minLength: 1
},
{
  name: 'states',
  source: substringMatcher(states)
});
</script>

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
