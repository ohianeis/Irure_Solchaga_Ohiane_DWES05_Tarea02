<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\VarDumper\VarDumper;

/**
 * Clase Home.
 * 
 * Página 'index' de la app con formulario para el pedido de algun producto
 * 
 * @author ohiane irure
 * @since 26/01/2025
 */
class HomeController extends Controller
{
    /**
     * Crea la session con los productos y obtiene url.
     * 
     * @param Request $request Obtiene info de la solicitud.
     * 
     * @return view Devuelve la vista home
     */
    public function __invoke(Request $request)
    {
        if(!session()->has('productos')){
            $productos = [
                "Teclado" => 20,
                "Raton" => 15,
                "Pantalla" => 5,
                "Disco duro 1TB" => 17,
                "Cable usb" => 50
            
            ];
            session(['productos'=>$productos]);
        }
     
        $path=null;
        //obtener ruta actual
        if($request->path()==='/'){
            $path='home';
        }else{
              $path=$request->path();
        }
        echo "Estas en la página " .$path;
        return view('home');
    }
}
