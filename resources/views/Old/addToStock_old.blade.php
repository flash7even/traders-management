@extends('layouts.app')

@section('content')
<div class="container">
      <h3>Insert a Product</h3>

      <ul>
          @foreach($errors->all() as $error)
              <li>{{ $error }}</li>
          @endforeach
      </ul>

      {!! Form::open(array('route' => 'addtostockpost', 'class' => 'form-inline')) !!}

      <div class="form-group">
          {!! Form::label('Name') !!}
          {!! Form::text('name', null, 
              array('required', 
                    'class'=>'form-control', 
                    'placeholder'=>'Enter Product Name')) !!}
      </div>

      <div class="form-group">
          {!! Form::label('Quantity') !!}
          {!! Form::text('quantity', null, 
              array('required', 
                    'class'=>'form-control', 
                    'placeholder'=>'Enter Quantity')) !!}
      </div>

      <div class="form-group">
          {!! Form::label('Category') !!}
          {!! Form::text('category', null, 
              array('required', 
                    'class'=>'form-control', 
                    'placeholder'=>'Enter Category ID')) !!}
      </div>

      <div class="form-group">
          {!! Form::label('Price') !!}
          {!! Form::text('price', null, 
              array('required', 
                    'class'=>'form-control', 
                    'placeholder'=>'Enter The Price')) !!}
      </div>

      <div class="form-group">
          {!! Form::submit('Submit', 
            array('class'=>'btn btn-primary')) !!}
      </div>
      {!! Form::close() !!}
</div>

@endsection