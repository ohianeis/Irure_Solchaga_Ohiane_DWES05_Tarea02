@extends('layouts.head')
@section('content')
    <div class="container">
        <div class="card text-center">
            <div class="card-header">
                ¡Compra realizada!
            </div>
            <div class="card-body">
                <h5 class="card-title">{{ $pedido['nombre'] }} {{ $pedido['apellidos'] }} gracias por su compra
                </h5>
                <p class="card-text"><span class="text-info">Detalle de su pedido</span> <br />Producto: {{ $pedido['producto'] }} <br />Cantidad:
                    {{ $pedido['cantidad'] }} <br />Su pedido será enviado lo antes posible </p>
                <a href="{{ route('home') }}" class="btn btn-primary">Volver listado de productos</a>
            </div>
        </div>
    </div>
@endsection
