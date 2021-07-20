@extends('adminlte::page')

@section('title', 'Orion')

@section('content_header')
    <h1>Orion</h1>
@stop

@section('content')
<order-crear-component :user_id="{{ Auth::user()->id }}"></order-crear-component>
@stop
@section('css')
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop
