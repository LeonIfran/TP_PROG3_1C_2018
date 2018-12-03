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
        $unDetalle=detalles::TraerUnDetalleCliente($codP);
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
}

?>