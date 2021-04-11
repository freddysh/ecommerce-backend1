@extends('adminlte::page')

@section('title', 'Orion')

@section('content_header')
    <h1>Orion</h1>
@stop

@section('content')
    <p>Bienvenido.</p>


<form role="form" id="form_login12" method="post" action="{{route('admin.payment_respuesta',[$purchasenumber,$entorno,$amount])}}">
    @csrf
    <script src="https://static-content-qas.vnforapps.com/v2/js/checkout.js?qa=true"
        data-sessiontoken="{{$sessionkey}}"
        data-channel="{{$channel}}"
        data-merchantid="{{$merchantid}}"
        data-purchasenumber="{{$purchasenumber}}"
        data-amount="{{$amount}}"
        data-expirationminutes="20"
        data-timeouturl="about:blank"
        data-merchantlogo="img/comercio.png"
        data-formbuttoncolor="#007bff"
    />
</form>
@stop

@section('css')
@stop

@section('js')
    <script> console.log('Hi!'); </script>


@stop
