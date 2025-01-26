<?php

namespace App\Http\Controllers;

use Faker\Core\Number;
use Illuminate\Http\Request;


/**
 * Clase Pedido.
 * 
 * Realiza las operaciones referentes al pedido del producto
 * 
 * @author ohiane irure
 * @since 26/01/2025
 */
class PedidoController extends Controller
{
    /**
     * Procesa los datos del pedido para verificar su confirmacion o posibles errores.
     * 
     * *Descripcion*, se ayuda de las funciones privadas comrpobarCantidad y ComprobarDatos para verificar
     * los inputs con los datos, si hay errores se manda a la view tanto el array de errores como el array pedido
     * para obtener detalle de estos en el formulario
     * 
     * @param Request $datos Obtiene dato de la peticion, path.
     * 
     * @return route/route Reedirgue si no hay errores la ruta compra.confirmar o si no la ruta compra.error
     */
    public function procesar(Request $datos){
         $path=$datos->path();
        echo "<p>$path</p>";
        $pedidoDatos=[];
        $errores=[];
        $producto=$datos->input('producto');
   
        $pedido=$datos->all();
        foreach($pedido as $dato=>$valor){
            if($dato=='_token')continue;
            
            if($dato=='producto'){
                $pedidoDatos['producto']=$valor;
                continue;
            }
            if($dato=='enviar') continue;
            if($dato =='cantidad'){
                $pedidoDatos[$dato]=$valor;
                if(!$this->comprobarCantidad($producto,$valor)){
                    $errores[$dato]=$valor;//controlar errores en home tanto info de ellos como resaltado en formulario
                }
            }else{
                  $pedidoDatos[$dato]=$valor;
                if(!$this->comprobarDatos($dato,$valor)){
                   $errores[$dato]=$valor;
                }
            }
        }

       
       if(empty($errores)){
            return redirect()->route('compra.confirmar')->with('pedido',$pedidoDatos);
        }else{
            return redirect()->route('compra.error')->with('errores',$errores)->with('datosPedido',$pedidoDatos);

        }
       

    }

    /**
     * Maneja el input cantidad del formulario para ver posibles errores
     * 
     * @param string $producto producto que se quiere comprar
     * @param string $canitdad Cantidad del producto a comprar
     * 
     * @return bol Devuelve false si tiene fallo o true si es correcto
     */
    private function comprobarCantidad($producto,$cantidad){
       
        $productos=session('productos');//recupero datos sesion
        $cantidadProducto=$productos[$producto];//obtengo cantidad del producto a mirar
        $cantidad=intval($cantidad);
 
        if($cantidadProducto<$cantidad || $cantidad<=0){
            return false;
        }else{
            return true;
        }
    
    }

    /**
     * Comprueba los distintos inputs del formulario excepto cantidad.
     * 
     * @param string $dato Input a comprobar.
     * @param string $valor Valor del input a comprobar.
     * 
     * @return bol|string Devuelve false si el dato es incorrecto o el valor del input.
     */
    private function comprobarDatos($dato,$valor){
        $patternNombre="/^[a-zA-ZñÑ\s]+$/"; //de la a-z tanto minúsculas y mayúsculas + la letra ñ
        $patternMovil="/^(6|7)[0-9]{8}$/"; //8 números del 0-9 y puede empezar por 6 o 7
        switch($dato){
            case 'nombre':
                $nombre=trim($valor);
    
                if(preg_match($patternNombre,$nombre )&& strlen($nombre)>=3){
                    return $nombre;
                }else{
                    return false;
                }
                break;
                case 'apellidos':
                    $apellidos=trim($valor );
                    if(preg_match($patternNombre,$apellidos )&& strlen($apellidos)>=4){
                        return $apellidos;
                    }else{
                        return false;
                    }
                    break;
               case 'telefono':
            
                    $telefono=trim($valor);
                    if(preg_match($patternMovil,$telefono) ){
                        return $telefono;
                    }else{
                        return false;
                    }
                    break;
        }
    }

    /**
     * Maneja la confimarcion (todos los datos son correctos) del pedido, contolador de la ruta pedido.confirmar.
     * 
     * *Descripcion*, en la confirmacion se resta la cantidad del producto que el usuario quiere comprar al stock en tienda de ese producto y se
     * modifica la sesion que tiene los datos de los productos.
     * 
     * @param Request $datos Obtiene info de la solicitud , path.
     *  
     * @return view|route Devuelve la view confirmacion que muestra info pedido, devuelve la ruta home si el array es null
     */
    public function confirmacion(Request $datos){
        $path=$datos->path();
        echo "<p>Estas en la página $path</p>";
        $productos=session('productos');
       
       
        $pedido=session('pedido');
       // contola que en url se ponga pedido/confirmar
        if($pedido==null){
            return redirect()->route('home');
           
        }
     
        $cantidadComprada=intval($pedido['cantidad']);
      
        $productoComprado=$pedido['producto'];
     
        $productos[$productoComprado]=$productos[$productoComprado]-$cantidadComprada;
        session()->put('productos',$productos);
      
        
        return view('confirmacion',compact('pedido'));


    }

    /**
     * Maneja el error al realizar el pedido, controlador de la ruta pedido.error.
     * @param Request $datos Obtiene info de la solicitud , path.
     * 
     * @return view|route Devuelve la view home mostrando los errores o va a la ruta home incial si algun array es null.
     * 
     */
    public function error(Request $datos){
       
        $path=$datos->path();
        echo "<p>Estas en la página $path</p>";
        $datosPedido=session('datosPedido');
        $errores=session('errores');
        //controlar que se ponga en url pedidos/errores
        if($datosPedido==null || $errores==null){
            return redirect()->route('home');

        }
      
        return view('home',compact('errores','datosPedido'));

    }
}
