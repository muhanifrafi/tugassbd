@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Publishers</h2>
            </div>
            <div class="pull-right">
                @can('product-create')
                <a class="btn btn-success" href="{{ route('publishers.create') }}"> Create New Publisher</a>
                @endcan
                @can('product-delete')
                <a class="btn btn-info" href = "/publishers/trash">Deleted Data</a>
                @endcan   
            </div>
            <div class="my-3 col-12 col-sm-8 col-md-5">
                <form action="" method="get">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Find" name = "find" aria-label="Find" aria-describedby="basic-addon1">
                        <button class="input-group-text btn btn-primary" id="basic-addon1">Find</button>
                    </div>
                </form>
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
                    <a class="btn btn-info" href="{{ route('publishers.show',$publisher->id_publisher) }}">Show</a>
                    @can('product-edit')
                    <a class="btn btn-primary" href="{{ route('publishers.edit',$publisher->id_publisher) }}">Edit</a>
                    @endcan
                    @csrf
                    @method('DELETE')
                    @can('product-delete')
                    <button type="submit" class="btn btn-danger">Delete</button>
                    @endcan             
                </form>
            </td>
        </tr>
        @endforeach
    </table>
    {!! $publishers->links() !!}
    <p class="text-center text-primary"><small>Tutorial by LaravelTuts.com</small></p>
@endsection