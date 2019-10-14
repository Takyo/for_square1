@extends('layouts.main_layout')

@section('content')
<div class="d-flex justify-content-between mt-4" >
	<h1 class="float-left">List of products</h1>
	<div class="form-group float-right">
	{!! Form::open(['method'=>'get']) !!}
	{!! Form::select('sort', ['asc' => 'Price asc', 'desc' => 'Price desc'], $sort , ['class'=>'form-control', 'onChange' => 'this.form.submit()' ]) !!}
	{!! Form::close() !!}
	</div>
</div>
<div class="card-columns">
	@include('products.products',['products' => $products])
</div>
    {!! $products->render() !!}

@endsection





