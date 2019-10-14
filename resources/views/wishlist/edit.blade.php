@extends('layouts.main_layout')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card mt-4">
                <div class="card-header">Edit list</div>

                <div class="card-body">
                    {!! Form::model($wishlist, ['route' => ['wishlist.update', $wishlist->id], 'method' => 'put', 'class'=>'form-inline']) !!}
                    {{-- {!! Form::open(['route' => 'wishlist.store', 'method' => 'post']) !!} --}}
                    @include('wishlist.form')
                    {!! Form::close() !!}
                </div>

            </div>
        </div>
    </div>
    <div class="card-columns pt-2">
        @include('products.products',['products' => $wishlist->products])
    </div>
</div>
@endsection
