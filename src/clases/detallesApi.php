<?php 
require_once "detalles.php";
class detallesApi extends detalles
{
    public function TraerTodos($request, $response, $args)
    {
        $todosLosDetalles=detalles::TraerTodosLosDetalles();
        $newresponse = $response->withJson($todosLosDetalles,200);
        return $newresponse;
    }
    public function TraerUnoClientes($request, $response, $args)
    {
        $codP = $args['id'];
        $unDetalle=detalles::TraerUnDetalleClientes($codP);
        $newresponse = $response->withJson($unDetalle,200);
        return $newresponse;
    }
    
    public function TraerPendientes($request, $response, $args)
    {
        $ArrayDeParametros = $request->getParsedBody();
        $area = $ArrayDeParametros['area'];
        $unDetalle=detalles::TraerDetallesPendientesArea($area);
        $newresponse = $response->withJson($unDetalle,200);
        return $newresponse;
    }
    public function CargarUno($request, $response, $args) 
    {   
        $ArrayDeParametros = $request->getParsedBody();
        $codPedido = $ArrayDeParametros['cod_pedido'];
        $area = $ArrayDeParametros['area'];
        $item = $ArrayDeParametros['item'];
        $estado_pedido= "Pendiente";
        //$tiempo_estimado = $ArrayDeParametros['estimado'];
        /* -------------CLARIFICACION DE LOS DATOS
        el estado va ir como pendiente cuando lo añade el mozo
        el tiempo de inicio lo pone la base a la hora de cargar los datos.
        el estimado por default es 00:00, y lo va a modificar el chef*/
        $miDetalle = new detalles();
        $miDetalle->setCod_pedido($codPedido);
        $miDetalle->setArea($area);
        $miDetalle->setItem($item);
        $miDetalle->setEstado_pedido($estado_pedido);
        //echo var_dump($miDetalle);
        $miDetalle->InsertUnDetalle();       
        $objDelaRespuesta= new stdClass();
        $objDelaRespuesta->respuesta="Se guardo el detalle";   
        return $response->withJson($objDelaRespuesta, 200);
    }

    public function ModificarUno($request, $response, $args) {
        $ArrayDeParametros = $request->getParsedBody();
       //var_dump($ArrayDeParametros);    	
       $miDetalle = new detalles();
       $miDetalle->setCod_pedido($ArrayDeParametros['cod']);
       $miDetalle->setEstado_pedido($ArrayDeParametros['estado']);
       $miDetalle->setTiempo_estimado($ArrayDeParametros['tiempo_est']);
       $miDetalle->setId($ArrayDeParametros['id']);
       $miDetalle->setItem($ArrayDeParametros['item']);

       $resultado =$miDetalle->ModificarEstado();
       $objDelaRespuesta= new stdclass();
       //var_dump($resultado);
       $objDelaRespuesta->resultado=$resultado;
       $objDelaRespuesta->tarea="Pedido ".$miDetalle->getCod_pedido()." modificado satisfactoriamente";
       return $response->withJson($objDelaRespuesta, 200);		
   }
   public function PrepararPedido($request, $response, $args) 
   {
    $ArrayDeParametros = $request->getParsedBody();
   $tiempo = date('Y-m-d H:i:s');   	
   $miDetalle = new detalles();
   $miDetalle->setCod_pedido($ArrayDeParametros['cod']);
   $miDetalle->setEstado_pedido('en preparacion');
   $miDetalle->setTiempo_estimado($ArrayDeParametros['tiempo_est']);
   $miDetalle->setId($ArrayDeParametros['id']);
   $miDetalle->setItem($ArrayDeParametros['item']);
   $miDetalle->setEstado_pedido('listo para servir');
   $miDetalle->setTiempo_inicio($tiempo);

   $resultado =$miDetalle->ModificarPreparar();
   $objDelaRespuesta= new stdclass();
   //var_dump($resultado);
   $objDelaRespuesta->resultado=$resultado;
   $objDelaRespuesta->tarea="Pedido ".$miDetalle->getCod_pedido()." ".$miDetalle->getItem()." en preparacion!";
   return $response->withJson($objDelaRespuesta, 200);		
}
   public function TerminarPedido($request, $response, $args) {
    $ArrayDeParametros = $request->getParsedBody();
   $tiempo = date('Y-m-d H:i:s');   	
   $miDetalle = new detalles();
   $miDetalle->setCod_pedido($ArrayDeParametros['cod']);
   $miDetalle->setItem($ArrayDeParametros['item']);
   $miDetalle->setEstado_pedido('listo para servir');
   $miDetalle->setTiempo_fin($tiempo);
   

   $resultado =$miDetalle->ModificarTerminar();
   $objDelaRespuesta= new stdclass();
   //var_dump($resultado);
   $objDelaRespuesta->resultado=$resultado;
   $objDelaRespuesta->tarea="Pedido ".$miDetalle->getCod_pedido()." Listo para servir!";
   return $response->withJson($objDelaRespuesta, 200);		
}
   public function TraerPorArea($request, $response, $args)
   {
    $todasOperaciones=detalles::TraerOperacionesXArea();
    $newresponse = $response->withJson($todasOperaciones,200);
    return $newresponse;
   }

   public function TraerPorAreaID($request, $response, $args)
   {
       $todasOperaciones=detalles::TraerOperacionesAreaEmp();
       $newresponse = $response->withJson($todasOperaciones,200);
       return $newresponse;
   }
   public function TraerOperacionesEmpIndv($request, $response, $args)
   {
       $ArrayDeParametros = $request->getParsedBody();
       $id = $ArrayDeParametros['id'];
       $miOperacion=detalles::TraerOperacionesEmpIndividual($id);
       $newresponse = $response->withJson($miOperacion,200);
       return $newresponse;
   }
   public function TraerVendidos($request, $response, $args)
   {
       $ArrayDeParametros = $request->getParsedBody();
       $opcion = $ArrayDeParametros['opcion'];
       $todosLosVendidos=detalles::TraerMasMenosVendidos($opcion);
       $objDelaRespuesta= new stdclass();
       $objDelaRespuesta->tarea="Items ".$opcion." vendidos!";
       $objDelaRespuesta->resultado=$todosLosVendidos;
       return $response->withJson($objDelaRespuesta, 200);		
   }
   public function TraerTarde($request, $response, $args)
   {
       $todosLosPedidosTarde=detalles::TraerPedidosTarde();
       $newresponse = $response->withJson($todosLosPedidosTarde,200);
       return $newresponse;
   }
   public function TraerEstados($request, $response, $args)
   {
       $ArrayDeParametros = $request->getParsedBody();
       $estado = $ArrayDeParametros['estado'];
       $todosLosPedidosCancelados=detalles::TraerPorEstado($estado);
       $newresponse = $response->withJson($todosLosPedidosCancelados,200);
       return $newresponse;
   }

   
}

?>