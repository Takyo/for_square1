@extends('layouts.main_layout')

@section('content')


    @include('wishlist.info')
    {{-- <a href="{{ route('listado.create') }}" class="btn btn-primary pull-right">nuevo</a> --}}
    <div class="card mt-4">
        <div class="card-header">List of wishlists
            <div>
                {!! Form::open(['route' => ['wishlist.create'], 'method'=>'get']) !!}
                {!! Form::submit('NEW WISHLIST', ['class'=> 'btn btn-sm btn-secondary']) !!}
                {!! Form::close() !!}
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Name wishlist</th>
                        <th>Items</th>
                        <th>Public url</th>
                        <th>Options</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($wishlists as $wl)
                        <tr>
                            <td> {{ $wl->name }} </td>
                            <td> {{ count($wl->products) }} </td>
                            <td><a href="{{ route('wishlist.show', $wl->id) }}">{{ route('wishlist.show', $wl->id) }}</a></td>
                            <td>
                                {{-- <a class="btn btn-sm btn-primary" href="{{ route('user.show', $wl) }}">Show</a> --}}
                                {!! Form::open(['route' => ['wishlist.edit', $wl], 'method'=>'get']) !!}
                                {!! Form::submit('EDIT', ['class'=> 'btn btn-sm btn-primary']) !!}
                                {!! Form::close() !!}
                                {!! Form::open(['route' => ['wishlist.delete', $wl->id], 'method'=>'delete']) !!}
                                {!! Form::submit('DELETE', ['class'=> 'btn btn-sm btn-danger']) !!}
                                {!! Form::close() !!}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="pull-right">{!! $wishlists->render() !!}</div>
        </div>
    </div>



@endsection