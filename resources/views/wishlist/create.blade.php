@extends('layouts.main_layout')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card mt-4">
                <div class="card-header">New list</div>

                <div class="card-body">
                    {{-- {!! Form::model('Wishlist', ['method' => 'post']) !!} --}}
                    {!! Form::open(['route' => 'wishlist.store', 'method' => 'post', 'class' => 'form-inline']) !!}
                    @include('wishlist.form')
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection