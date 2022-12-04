@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Products</h2>
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
            <th>ID Game</th>
            <th>Nama</th>
            <th>Details</th>
            <th>No rak</th>
            <th>No publisher</th>
            <th width="280px">Action</th>
        </tr>
        @foreach ($products as $product)
        <tr>
            <td>{{ $product->id_game }}</td>
            <td>{{ $product->name }}</td>
            <td>{{ $product->detail }}</td>
            <td>{{ $product->no_rak }}</td>
            <td>{{ $product->no_publisher }}</td>
            <td>
                    @can('product-delete')
                    <a class="btn btn-primary" href="trash/{{ $product->id_game }}/restore">Restore</a>
                    @endcan
                    @csrf
                    @can('product-delete')
                    <a class="btn btn-danger" href="trash/{{ $product->id_game }}/forcedelete">Force Delete</a>
                    @endcan             
            </td>
        </tr>
        @endforeach
    </table>
    {!! $products->links() !!}
    <p class="text-center text-primary"><small>Tutorial by LaravelTuts.com</small></p>
@endsection