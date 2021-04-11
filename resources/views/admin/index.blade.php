@extends('adminlte::page')

@section('title', 'Orion')

@section('content_header')
    <h1>Orion</h1>
@stop

@section('content')
    <p>Bienvenido.</p>

    <div id="txtTarjeta"></div>

@stop

@section('css')
<link rel="stylesheet" href="https://pocpaymentserve.s3.amazonaws.com/payform.min.css">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
    <script src="https://pocpaymentserve.s3.amazonaws.com/payform.min.js"></script>
    <script type="text/javascript">
    var configuration = {
    callbackurl: '/v1/payment_respuesta/2020100901',
    sessionkey: '74334a16267de87dfa89bff51be6df5a6fcb92b64c320ba33c7e1700f901e7a9',
    channel: 'web',
    merchantid: '456879852',
    purchasenumber: '2020100901',
    amount: '10.5',
    language: 'es',
    font: 'https://fonts.googleapis.com/css?family=Montserrat:400&display=swap',
    recurrencemaxamount: '8.5'
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
        card.then(element => {
        element.on('bin', function (data) {
        /* Tú código aquí */
        });

        element.on('change', function (data) {
        /* Tú código aquí */
        });

        element.on('dcc', function (data) {
        /* Tú código aquí */
        });

        element.on('installments', function (data) {
        /* Tú código aquí */
        });
        });

        function sendPayment() {
            var data = {
             name: 'Juan',
             lastName: 'Perez',
             email: 'jperez@test.com'
             };
          /* Caso de uso: Control unificado */
          payform.createToken(card, data).then(function(response){
             /* Tú código aquí */
             console.log(response);
             }).catch(function(error){
             /* Tú código aquí */
             });
            }
    </script>
    {{-- <chekout-component></chekout-component> --}}

@stop
