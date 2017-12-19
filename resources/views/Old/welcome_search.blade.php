@extends('layouts.app')

@section('head')
<title>Hllo WOrld</title>
<script type="text/javascript">
$(document).ready(function(){
    // Defining the local dataset
    var cars = ['Audi', 'BMW', 'Bugatti', 'Ferrari', 'Ford', 'Lamborghini', 'Mercedes Benz', 'Porsche', 'Rolls-Royce', 'Volkswagen'];
    
    // Constructing the suggestion engine
    var cars = new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.whitespace,
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        local: cars
    });
    
    // Initializing the typeahead
    $('.typeahead').typeahead({
        hint: true,
        highlight: true, /* Enable substring highlighting */
        minLength: 1 /* Specify minimum characters required for showing result */
    },
    {
        name: 'cars',
        source: cars
    });
});  
</script>
@endsection



@section('content')
 <div class="bs-example">
    <h2>Type your favorite car name</h2>
    <input type="text" class="typeahead tt-query" autocomplete="off" spellcheck="false">
</div>
@endsection
