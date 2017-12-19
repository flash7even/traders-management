@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">

        <div class="set-form">
          <table id="myTable">
                <tr>
                <td><label for='name'>Item Name</label></td>
                <td><label for='name'>Category</label></td>
                <td><label for='name'>Quantity</label></td>
                <td><label for='name'>Price</label></td>
                <td><label for='name'>Discount</label></td>
                </tr>

                <tr>
                <td><input class="name form-control" id="name" type="text" name="name" placeholder="Name" required></td>
                <td><input class="category form-control" id="category" type="number" name="category" placeholder="Category" required></td>
                <td><input class="quantity form-control" id="quantity" type="number" name="quantity" placeholder="Quantity" required></td>
                <td><input class="price form-control" id="price" type="number" name="price" placeholder="Price" required></td>
                <td><input class="discount form-control" id="discount" type="number" name="discount" placeholder="Discount" required></td>
                <td><input type="button" id="more_fields" onclick="delete_item(this);" value="Remove" class="btn btn-info"/></td>
                </tr>
            
          </table>
          <br>
          <div class="set-form">
            <input type="button" id="more_fields" onclick="add_fields();" value="Add More" class="btn btn-info" />
          </div>

      </div>
        <div id="the-basics">
         <input class="typeahead" type="text" placeholder="States of USA">
        </div>

        </div>
    </div>
</div>
@endsection

<script>
      var totalRow = 0;
      function add_fields() {
        totalRow++;
        // For adding a new input box after clicking add button:
        document.getElementById("myTable").insertRow(-1).innerHTML = '<tr><td><input class="name form-control" id="name" type="text" name="name" placeholder="Name" required></td><td><input class="category form-control" id="category" type="number" name="category" placeholder="Category" required></td><td><input class="quantity form-control" id="quantity" type="number" name="quantity" placeholder="Quantity" required></td><td><input class="price form-control" id="price" type="number" name="price" placeholder="Price" required></td><td><input class="discount form-control" id="discount" type="number" name="discount" placeholder="Discount" required></td><td><input type="button" id="more_fields" onclick="delete_item(this);" value="Remove" class="btn btn-info"/></td></tr>';

            /// Just for temporarily:
            if(totalRow == 10){
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
            }
      }

      /// When user want to delete any item from the selected list:
      function delete_item(x) {
          var row = x.parentNode.parentNode;
          var table = row.parentNode;
          table.removeChild(row);
      }

      /// Bootstrap typehead part:
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
      var states = ['Alabama', 'Alaska', 'Arizona', 'Arkansas', 'California',
        'Colorado', 'Connecticut', 'Delaware', 'Florida', 'Georgia', 'Hawaii',
        'Idaho', 'Illinois', 'Indiana', 'Iowa', 'Kansas', 'Kentucky', 'Louisiana',
        'Maine', 'Maryland', 'Massachusetts', 'Michigan', 'Minnesota',
        'Mississippi', 'Missouri', 'Montana', 'Nebraska', 'Nevada', 'New Hampshire',
        'New Jersey', 'New Mexico', 'New York', 'North Carolina', 'North Dakota',
        'Ohio', 'Oklahoma', 'Oregon', 'Pennsylvania', 'Rhode Island',
        'South Carolina', 'South Dakota', 'Tennessee', 'Texas', 'Utah', 'Vermont',
        'Virginia', 'Washington', 'West Virginia', 'Wisconsin', 'Wyoming'
      ];

      $('#the-basics .typeahead').typeahead({
        hint: true,
        highlight: true,
        minLength: 1
      },
      {
        name: 'states',
        source: substringMatcher(states)
      });
      
</script>