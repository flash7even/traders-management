@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">

		<button type="button" onclick="myFunction()">Try it</button>

		<script>
		function myFunction() {
			var tmp = document.getElementById("InputsWrapper").innerHTML;
			tmp = tmp + tmp;
			//document.write(tmp);
		    document.getElementById("InputsWrapper").innerHTML = tmp;
		}
		</script>

		<script>


    	</script>

		<table id="InputsWrapper" >
            <tr>
                <span class="small"><a href="#" id="AddMoreFileBox" class="btn btn-info">Add More Field</a></span>
            </tr>
            <tr>
                <td><label for='item'>Item:</label></td><td><label for='qty'>Quantity:</label></td><td><label for='price'>Price:</label></td><td><label for='discount'>Discount %</label></td><td><label for='total'>Final Price:</label></td>
            </tr>
            <tr>
                <td><input class='item form-control' id="find" type='text'  name='item[]' required></td>
                <td><input class='qty form-control' id="find" type='number' name='qty[]' required></td>
                <td><input class='price form-control' id="find" type='number' name='price[]' required></td>
                <td><input class='discount form-control' id="find" type='number'  name='discount[]' required></td>
                <td><input class='total form-control' id="find" type='number' name='total[]' required></td>
            </tr>
        </table>

        Total : <input id='totaldp' class="form-control" type='number' name='totaldp' readonly required> <input type="hidden" id="name_id" name="name_id" />

        </div>
    </div>
</div>
@endsection