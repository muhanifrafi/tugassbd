@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Raks</h2>
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
            <th width="280px">Action</th>
        </tr>
        @foreach ($rak as $raks)
        <tr>
            <td>{{ $raks->id_rak }}</td>
            <td>{{ $raks->name }}</td>
            <td>{{ $raks->detail }}</td>
            <td>
                <form action="{{ route('products.destroy',$raks->id_rak) }}" method="POST">
                    @can('rak-delete')
                    <a class="btn btn-primary" href="trash/{{ $raks->id_rak }}/restore">Restore</a>
                    @endcan
                    @csrf
                    @can('rak-delete')
                    <a class="btn btn-danger" href="trash/{{ $raks->id_rak }}/forcedelete">Force Delete</a>
                    @endcan             
                </form>
            </td>
        </tr>
        @endforeach
    </table>
    {!! $rak->links() !!}
    <p class="text-center text-primary"><small>Tutorial by LaravelTuts.com</small></p>
@endsection