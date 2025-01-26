@extends('layouts.head')
@section('content')
    <header class="m-5" >
           @if(isset($errores))
           <section class="container">
            <div class="errores">
               <p>Los siguientes campos del formulario tienen errores</p>
                <ul class="list-group">
                @foreach($errores as $error=>$info)
                    <li class="list-group-item" >{{$error}}</li>
                
                @endforeach
                </ul>
            </div>
            </section>
            @endif
        <h1 class="text-center" >Informatics</h1>
    </header>
    <main>
    
         
        
        <section class="container " id="ventaOnline">
            <div class="row">
                <div class="col mr-4">
            <table border="1" class="table table-striped table-hover border border-dark">
                <caption>Listado de productos</caption>
                <thead>
                    <tr>
                        <th  class="text-primary">PRODUCTOS</th>
                        <th class="text-primary">CANTIDAD</th>
                    </tr>
                </thead>
                <tbody>
                    @if (session('productos'))
                        @foreach (session('productos') as $nombre => $cantidad)
                            <tr>
                                <td>{{ $nombre }}</td>
                                <td>{{ $cantidad }}</td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
        <div class="col ml-4">
            <form action="{{ route('compra.procesar') }}" method="POST" autocomplete="yes">
                @csrf
                <div class="form-group border border-primary p-4">
                <fieldset><span class="agrupacion">Datos Personales</span>
                    <br />
                    <label for="nombre">Nombre</label>
                    <input type="text" class="{{ isset($errores['nombre']) ? 'form-control border border-danger' : 'form-control'}}" name="nombre" id="nombre" value="{{ isset($datosPedido) ? $datosPedido['nombre'] : ''}}" placeholder="Ingrese su nombre" required>
                    <label for="apellidos">Apellidos:</label>
                    <input type="text" class="{{ isset($errores['apellidos']) ? 'form-control border border-danger' : 'form-control'}}" name="apellidos" id="apellidos" value="{{ isset($datosPedido) ? $datosPedido['apellidos'] : ''}}" placeholder="Ingrese sus apellidos"
                        maxlength="50" required>
                    <label for="telefono">Teléfono: </label>
                    <input type="number" class="{{ isset($errores['telefono']) ? 'form-control border border-danger' : 'form-control'}}" name="telefono" id="telefono" value="{{ isset($datosPedido) ? $datosPedido['telefono'] : ''}}" placeholder="Ingrese su teléfono"
                        minlength="9" maxlength="9" required>

                </fieldset>
            </div>
            <div class="form-group border border-primary p-4">
                <fieldset><span class="agrupacion">Carrito</span>
                    <br />
                    <label for="producto">Producto</label>
                    <select name="producto" class="form-control" id="producto" required>
                        @if (session('productos'))
                            @foreach (session('productos') as $producto => $cantidad)
                            @if(isset($datosPedido) && $datosPedido['producto'] == $producto)
                                <option value="{{ $producto }}" selected>{{ $producto }}</option>
                            @else 
                            <option value="{{ $producto }}" >{{ $producto }}</option>
                        @endif

                        @endforeach
                        @endif
                    </select>
                    <label for="cantidad">Cantidad</label>
                    <input type="number" class="{{ isset($errores['cantidad']) ? 'form-control border border-danger' : 'form-control'}}" name="cantidad" id="cantidad" value="{{ isset($datosPedido) ? $datosPedido['cantidad'] : ''}}" placeholder="Cantidad a comprar" required>

                    </input>
                </fieldset>
            </div>

                <input type="submit" class="text-white btn bg-primary btn-outline-dark "  name="enviar" value="Enviar" />
                <input type="reset" class="text-primary btn btn-outline-dark" value="Reset" />
            </form>
            @if(isset($errores))
            <a href="{{ route('home') }}" class="btn btn-primary">Volver página principal</a>
            @endif
        </div>
        </div>
        </section>

    </main>
@endsection
