@extends('template.master')

@section('title', 'Detail User')

@section('content')
<div class="col-md-12">
    &nbsp;
</div>
<div class="col-md-12">
    <div class="box">
        <table class="table table-bordered">
            <tr>
                <th width="15%">ID</th>
                <td>{{ $user->id }}</td>
            </tr>
            <tr>
                <th>Name</th>
                <td>{{ $user->name }}</td>
            </tr>
            <tr>
                <th>Address</th>
                <td>{{ $user->address }}</td>
            </tr>
            <tr>
                <th>No Mobile</th>
                <td>{{ $user->nomobile }}</td>
            </tr>
        </table>
        <div class="col-md-12">
            <a class="btn btn-danger m-2" href="{{ Route('user_admin') }}">
                Back
            </a>
        </div>
    </div>
    <div class="col-md-12">
    &nbsp;
    </div>
</div>
@endsection