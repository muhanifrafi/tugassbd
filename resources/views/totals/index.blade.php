@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>List Game</h2>
            </div>
        </div>
    </div>
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
    <table class="table table-bordered">
        <tr>
            <th>Nama Game</th>
            <th>Detail</th>
            <th>Nama Rak</th>
            <th>Nama Publisher</th>
        </tr>
        @foreach ($joins as $join)
        <tr>
            <td>{{ $join->nama }}</td>
            <td>{{ $join->detail }}</td>
            <td>{{ $join->rak_name }}</td>
            <td>{{ $join->nama_publisher }} </td>
        </tr>
        @endforeach
    </table>
    {!! $joins->links() !!}
    <p class="text-center text-primary"><small>Tutorial by LaravelTuts.com</small></p>
@endsection