<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">
<style>
    .text-gray{
        color: #6c757d;
    }
    .customers {
    font-family: Arial, Helvetica, sans-serif;
    border-collapse: collapse;
    width: 100%;
    }

    .customers td, .customers th {
    border: 1px solid #ddd;
    padding: 8px;
    }

    .customers tr:nth-child(even){background-color: #f2f2f2;}

    .customers tr:hover {background-color: #ddd;}

    .customers th {
    padding-top: 12px;
    padding-bottom: 12px;
    text-align: left;
    background-color: #6c757d;
    color: white;
    }

    .customers1 {
    font-family: Arial, Helvetica, sans-serif;
    border-collapse: collapse;
    border: 1px solid #ddd;
    width: 100%;
    }

    .customers1 td, .customers1 th {
    padding: 8px;
    }

    .customers1 tr:nth-child(even){background-color: #f2f2f2;}

    .customers1 th {
    padding-top: 12px;
    padding-bottom: 12px;
    text-align: left;
    }

    .text-rigth{
        text-align: right!important;
    }
    .h1{
        font-size: 1.2rem
    }
    .slogan{
        font-family: 'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif;
        font-style: italic;
    }
</style>
</head>
<body>
<span class="h1">Hola {{ $order->cliente->name  }}</span>, gracias por realizar su pedido este es su detalle.
<table class="customers1">
    <thead>
        <tr>
            <th><b>Datos generales</b></th>
            <th><b>Datos de factura</b></th>
            <th><b>Datos de envio</b></th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                <p><span class="text-gray">Codigo:</span>{{ $order->code }}</p>
                <p><span class="text-gray">Estado:</span>{{ $order->state==1?'Pendiente':'' }}</p>
                <p><span class="text-gray">Fecha de creacion:</span>{{ $order->created_at }}</p>
            </td>
            <td>
                <p><span class="text-gray">Cliente:</span>{{ $order->cliente->name }}</p>
                <p><span class="text-gray">Email:</span>{{ $order->cliente->email }}</p>
                <p><span class="text-gray">Direccion:</span>{{ $order->cliente->address }}</p>
                <p><span class="text-gray">Celular:</span>{{ $order->cliente->phone }}</p>
                <p><span class="text-gray">Metodo de pago:</span>{{ $order->cliente->phone }}</p>
            </td>
            <td>
                <p><span class="text-gray">Cliente:</span>{{ $order->cliente->name }}</p>
                <p><span class="text-gray">Celular:</span>{{ $order->cliente->phone }}</p>
                <p><span class="text-gray">Direccion:</span>{{ $order->cliente->address }}</p>
                <p><span class="text-gray">Fecha de entrega:</span>{{ $order->fecha_entrega }} {{ $order->hora_entrega  }}</p>
            </td>
        </tr>
    </tbody>
</table>
</br>
<table class="customers">
    <thead>
        <tr>
            <th><b>Codigo</b></th>
            <th><b>Producto</b></th>
            <th><p>P.U(S/.)</p></th>
            <th><p>Cant.</p></th>
            <th><p>SubTotal(S/.)</p></th>
        </tr>
    </thead>
    <tbody>
        @php
            $suma=0;
        @endphp
        @foreach($order->productos_ordenados as $key => $value)
        <tr>
            <td>{{ $value->producto->code }}</td>
            <td>{{ $value->producto->name }} - {{ $value->producto->detail }}</td>
            <td class="text-rigth">{{ number_format($value->pu,2) }}</td>
            <td class="text-rigth">{{ number_format($value->quantity,2) }}</td>
            <td class="text-rigth">{{ number_format(Round(($value->pu*$value->quantity) * 100) / 100,2) }}</td>
        </tr>
        @php
            $suma+=Round(($value->pu*$value->quantity) * 100) / 100;
        @endphp
        @endforeach
        <tr>
            <td colspan="4" class="text-rigth"><b>SubTotal</b></td>
            <td class="text-rigth">{{ number_format($suma,2) }}</td>
        </tr>
        <tr>
            <td colspan="4" class="text-rigth"><b>Costo de envio</b></td>
            <td class="text-rigth">{{ number_format($order->tax,2) }}</td>
        </tr>

        <tr>
            <td colspan="4" class="text-rigth"><b>Total</b></td>
            <td class="text-rigth">{{ number_format(Round(($order->tax+$suma) * 100) / 100,2) }}</td>
        </tr>
    </tbody>
</table>

<p class="slogan">Orion Supermecados, la estrella de los precios bajos.</p>
</body>
</html>
