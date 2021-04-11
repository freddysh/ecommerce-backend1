@extends('adminlte::page')

@section('title', 'Orion')

@section('content_header')
    <h1>Orion</h1>
@stop

@section('content')
    <p>Bienvenido.</p>
    @csrf
    <div id="txtTarjeta">

    </div>
    <button class="btn btn-primary" onclick="sendPayment()">Pagar({{ $amount }})</button>
    <!--Caso de uso: Controles independientes-->

    <div id="txtNumeroTarjeta"></div>

    <div id="txtFechaVencimiento"></div>

    <div id="txtCvv"></div>
    <button class="btn btn-secondary" onclick="sendPayment2()">Pagar({{ $amount }})</button>

@stop

@section('css')
{{-- <link rel="stylesheet" href="https://pocpaymentserve.s3.amazonaws.com/payform.min.css"> --}}
@stop

@section('js')
    <script> console.log('Hi!'); </script>
    <script src="https://pocpaymentserve.s3.amazonaws.com/payform.min.js"></script>
    <script type="text/javascript">

    var configuration = {
    callbackurl: "/admin/payment_respuesta/{{ $purchasenumber }}",
    sessionkey: "{{ $sessionkey }}",
    channel: "{{ $channel }}",
    merchantid: "{{ $merchantid }}",
    purchasenumber: "{{ $purchasenumber }}",
    amount: "{{ $amount }}",
    language: "{{ $language }}",
    font: "{{ $font }}",
    recurrencemaxamount: "{{ $recurrencemaxamount }}",
    };
    payform.setConfiguration(configuration);

    </script>
    <script type="text/javascript">
        var elementStyles = {
         base: {
          color: '#666666',
          fontWeight: 700,
          fontFamily: "'Montserrat', sans-serif",
          fontSize: '16px',
          fontSmoothing: 'antialiased',
          placeholder: {
           color: '#999999',
          },
          autofill: {
           color: '#e39f48',
          },
         },
        invalid: {
         color: '#E25950',
         '::placeholder': {
          color: '#FFCCA5',
          },
         },
        };

    var card = payform.createElement('card',
        {
            style: elementStyles,
            placeholder: 'Número de tarjeta'
        }
        , 'txtTarjeta');


        /* Caso de uso: Controles independientes */

 var cardNumber = payform.createElement('card-number',
 {
  style: elementStyles,
  placeholder: 'Número de tarjeta'
 }
 , 'txtNumeroTarjeta');

 var cardExpiry = payform.createElement('card-expiry',
  {
   style: elementStyles,
   placeholder: 'MM/YY'
  }
  , 'txtFechaVencimiento');

  var cardCvc = payform.createElement('card-cvc',
 {
  style: elementStyles,
  placeholder: 'CVC'
 }
 , 'txtCvv');

        function sendPayment() {
            var _token = document.getElementsByName("_token")[0].value;
            console.log("token:"+_token);
            var data = {
             name: 'Juan',
             lastName: 'Perez',
             email: 'jperez@test.com',
             alias: "{{ $purchasenumber }}",
             recurrence:"false",
             _token:_token,
             };
          /* Caso de uso: Control unificado */
          payform.createToken(card, data).then(function(response){
             /* Tú código aquí */
             console.log(response);
             }).catch(function(error){
             /* Tú código aquí */
             });
            }


            function sendPayment2() {

            var _token = document.getElementsByName("_token")[0].value;
                var data = {
                 name: 'Juan',
                 lastName: 'Perez',
                 email: 'jperez@test.com',
                 alias: "{{ $purchasenumber }}",
                 recurrence:"false",
                 _token:_token,
                 };
              /* Caso de uso: Controles independientes */

              payform.createToken([cardNumber,cardExpiry,cardCvc], data).then(function(response){
                 /* Tú código aquí */
                 }).catch(function(error){
                 /* Tú código aquí */
                 });
                }
    </script>
    {{-- <chekout-component></chekout-component> --}}

@stop
