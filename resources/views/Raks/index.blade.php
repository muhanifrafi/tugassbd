@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Raks</h2>
            </div>
            <div class="pull-right">
                @can('rak-create')
                <a class="btn btn-success" href="{{ route('raks.create') }}"> Create New Rak</a>
                @endcan
                @can('rak-delete')
                <a class="btn btn-info" href = "/raks/trash">Deleted Data</a>
                @endcan   
            </div>
            <div class="my-3 col-12 col-sm-8 col-md-5">
                <form action="" method="get">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Search" name = "search" aria-label="Keyword" aria-describedby="basic-addon1">
                        <button class="input-group-text btn btn-primary" id="basic-addon1">Search</button>
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
            <th>ID Rak</th>
            <th>Nama</th>
            <th>Details</th>
            <th width="280px">Action</th>
        </tr>
        @foreach ($rak as $raks)
        <tr>
            <td>{{ $raks->id_rak }}</td>
            <td>{{ $raks->name }}</td>
            <td>{{ $raks->detail }}</td>
            <td>
                <form action="{{ route('raks.destroy',$raks->id_rak) }}" method="POST">
                    <a class="btn btn-info" href="{{ route('raks.show',$raks->id_rak) }}">Show</a>
                    @can('rak-edit')
                    <a class="btn btn-primary" href="{{ route('raks.edit',$raks->id_rak) }}">Edit</a>
                    @endcan
                    @csrf
                    @method('DELETE')
                    @can('rak-delete')
                    <button type="submit" class="btn btn-danger">Delete</button>
                    @endcan             
                </form>
            </td>
        </tr>
        @endforeach
    </table>
    {!! $rak->links() !!}
    <p class="text-center text-primary"><small>Tutorial by LaravelTuts.com</small></p>
@endsection