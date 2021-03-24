@extends('adminlte::page')

@section('title', 'Orion')

@section('content_header')
    <h1>Orion</h1>
@stop

@section('content')
<orders-entregar-component></orders-entregar-component>
@stop

@section('css')
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop
