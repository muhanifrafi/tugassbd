@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Publishers Deleted</h2>
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
            <th>ID Publisher</th>
            <th>Nama Publisher</th>
            <th width="280px">Action</th>
        </tr>
        @foreach ($publishers as $publisher)
        <tr>
            <td>{{ $publisher->id_publisher }}</td>
            <td>{{ $publisher->nama_publisher }}</td>
            <td>
                <form action="{{ route('publishers.destroy',$publisher->id_publisher) }}" method="POST">
                    @can('product-delete')
                    <a class="btn btn-primary" href="trash/{{ $publisher->id_publisher }}/restore">Restore</a>
                    @endcan
                    @csrf
                    @can('product-delete')
                    <a class="btn btn-danger" href="trash/{{ $publisher->id_publisher }}/forcedelete">Force Delete</a>
                    @endcan             
                </form>
            </td>
        </tr>
        @endforeach
    </table>
    {!! $publishers->links() !!}
    <p class="text-center text-primary"><small>Tutorial by LaravelTuts.com</small></p>
@endsection