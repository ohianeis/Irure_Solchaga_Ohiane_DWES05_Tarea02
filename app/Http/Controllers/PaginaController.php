<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * Clase Pagina.
 * 
 * Recoge url que el usuario pueda ingresar distinta de las rutas definidas
 * 
 * @author ohiane irure
 * @since 26/01/2025
 */

class PaginaController extends Controller
{
    /**
     * Muestra página en la que se encuentra usuario.
     * 
     * @param String $url Parámetro que viene de la ruta, recoge valor
     * 
     * @return view Devuelve la view 'pagina' que muestra la info
     */
    public function __invoke($url)
    {
        $showPagina="Estas en la página $url";
        return view('pagina',['mensaje'=>$showPagina]);
    }
}
