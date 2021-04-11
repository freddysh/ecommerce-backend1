@extends('adminlte::page')

@section('title', 'Orion')

@section('content_header')
    <h1>Orion</h1>
@stop

@section('content')
    <p>Bienvenido al formulario desacoplado.</p>
    <chekout-component></chekout-component>
@stop

@section('css')
{{-- <link rel="stylesheet" href="https://pocpaymentserve.s3.amazonaws.com/payform.min.css"> --}}
@stop

@section('js')

    {{-- <chekout-component></chekout-component> --}}

@stop
