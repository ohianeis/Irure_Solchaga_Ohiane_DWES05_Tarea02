<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\PaginaController;

//ruta por defecto en public
Route::get('/', HomeController::class)->name('home');

Route::post('pedido/procesar',[PedidoController::class,'procesar'])->name('compra.procesar');
Route::get('pedido/confirmar',[PedidoController::class,'confirmacion'])->name('compra.confirmar');
Route::get('pedido/errores',[PedidoController::class,'error'])->name('compra.error');

//ruta con parámetro para recoger url
Route::get('/{pagina}',PaginaController::class)->name('url.mostrar');