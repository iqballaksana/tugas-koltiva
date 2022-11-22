@extends('template.master')
@section('title', 'Pengaturan user')
@section('content')
<div class="col-md-12">
  &nbsp;
</div>
<div class="container">
	Selamat datang {{ !empty(Auth::user()->name)?Auth::user()->name:'Guest' }}    
</div>
@endsection
