@extends('layouts.app')

<?php 
    $productlist = DB::table('products')->get();
    $itemarray = array();
    foreach ($productlist as $prod) {
        array_push($itemarray, $prod->product_name);
    }
?>

@section('head')
<title>Hllo WOrld</title>
<script type="text/javascript">
    $(document).ready(function(){
        // Defining the local dataset
        // var cars = ['Audi', 'BMW', 'Bugatti', 'Ferrari', 'Ford', 'Lamborghini', 'Mercedes Benz', 'Porsche', 'Rolls-Royce', 'Volkswagen'];

        var cars = <?php echo json_encode($itemarray); ?>; /// Convert a PHP array to java script array.
        
        // Constructing the suggestion engine
        var cars = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.whitespace,
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            local: cars
        });
        
        // Initializing the typeahead
        $('.typeahe').typeahead({
            hint: true,
            highlight: true, /* Enable substring highlighting */
            minLength: 1 /* Specify minimum characters required for showing result */
        },
        {
            name: 'cars',
            source: cars
        });
    });

    var totalRow = 0;
    function add_fields() {
        totalRow++;


                    var cars = <?php echo json_encode($itemarray); ?>; /// Convert a PHP array to java script array.
        
        // Constructing the suggestion engine
        var cars = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.whitespace,
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            local: cars
        });
        
        // Initializing the typeahead
        $('.typeahe').typeahead({
            hint: true,
            highlight: true, /* Enable substring highlighting */
            minLength: 1 /* Specify minimum characters required for showing result */
        },
        {
            name: 'cars',
            source: cars
        });

        // For adding a new input box after clicking add button:
        document.getElementById("myTable").insertRow(-1).innerHTML = '<tr><td><input class="typeahe" id="name" type="text" name="name" placeholder="Name" required></td><td><input class="category form-control" id="category" type="number" name="category" placeholder="Category" required></td><td><input class="quantity form-control" id="quantity" type="number" name="quantity" placeholder="Quantity" required></td><td><input class="price form-control" id="price" type="number" name="price" placeholder="Price" required></td><td><input class="discount form-control" id="discount" type="number" name="discount" placeholder="Discount" required></td><td><input type="button" id="more_fields" onclick="delete_item(this);" value="Remove" class="btn btn-info"/></td></tr>';

            /// Just for temporarily:
            /*if(totalRow == 10){
                var res = "";
                var i;
                for(i = 1;i<=totalRow;i++){
                    var x = document.getElementById("myTable").rows[i];
                    var j;
                    for(j = 0;j<5;j++){
                        var add = x.cells[j].children[0].value;
                        res = res.concat(add);
                        res = res.concat(' ');
                    }
                    res = res.concat('<br>');
                }
                document.write(res);
            }*/




    }

    /// When user want to delete any item from the selected list:
    function delete_item(x) {
        var row = x.parentNode.parentNode;
        var table = row.parentNode;
        table.removeChild(row);
    }
</script>

<style type="text/css">
    .twitter-typeahead{
        position: absolute;
        display: inline-block;
    }
</style>

@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
        <div class="container" style=
          "padding:5px;
          width:1150px;
          text-align:left;">
          <h2 style="color:#00005C;">Please Enter The Items Here:</h2>
          <br>

        </div>
        <div class="table set-form">

            <table id = "myTable">
                <thead>
                <th><label for='name'>Item Name</label></th>
                <th><label for='name'>Category</label></th>
                <th><label for='name'>Quantity</label></th>
                <th><label for='name'>Price</label></th>
                <th><label for='name'>Discount</label></th>
                </thead>

                <tr>
                <td><input class="typeahe" id="name" type="text" name="name" placeholder="Name" required></td>
                <td><input class="category form-control" id="category" type="number" name="category" placeholder="Category" required></td>
                <td><input class="quantity form-control" id="quantity" type="number" name="quantity" placeholder="Quantity" required></td>
                <td><input class="price form-control" id="price" type="number" name="price" placeholder="Price" required></td>
                <td><input class="discount form-control" id="discount" type="number" name="discount" placeholder="Discount" required></td>
                <td><input type="button" id="more_fields" onclick="delete_item(this);" value="Remove" class="btn btn-info"/></td>
                </tr>
                
            
            </table>
            <br>
            <div class="set-form">
                <input type="button" id="more_fields" onclick="add_fields()" value="Add More" class="btn btn-info" />
                <input type="button" id="more_fields" onclick="" value="Preview" class="btn btn-info" />
                <input type="button" id="more_fields" onclick="" value="Confirm" class="btn btn-info" />
            </div>

      </div>

      </div>
    </div>
</div>

@endsection
