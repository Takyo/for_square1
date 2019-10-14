@extends('layouts.main_layout')

@section('content')

<div class="card-columns pt-2">
    @include('products.products',['products' => $wishlist->products])
</div>
@endsection