@extends('adminlte::page')

@section('title', 'Race Manager')

@section('content_header')
    <h1>Race Manager Dashboard</h1>
@endsection

@section('content')
    <p>Welcome to the Race Manager application!</p>
    <a href="{{ url('races/create') }}" class="btn btn-success">Create Races</a>
@endsection