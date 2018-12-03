<?php 
require_once "encuestas.php";
class encuestasApi extends encuestas
{
    public function AbrirUno($request, $response, $args) {
     	
        $objDelaRespuesta= new stdclass();
        
        $ArrayDeParametros = $request->getParsedBody();
        //var_dump($ArrayDeParametros);
        $cod_mesa= $ArrayDeParametros['cod'];
        $fecha= date('Y-m-d H:i:s');
        
        $miEncuesta = new encuestas();
        $miEncuesta->setCod_mesa($cod_mesa);
        $miEncuesta->setFecha($fecha);
        $miEncuesta->InsertarEncuesta();
        $objDelaRespuesta->respuesta="Se guardo la encuesta para mesa nro: $cod_mesa.";   
        return $response->withJson($objDelaRespuesta, 200);
    }

    public function EncuestaCalificar($request, $response, $args) {
        //$response->getBody()->write("<h1>Modificar  uno</h1>");
        $ArrayDeParametros = $request->getParsedBody();
       //var_dump($ArrayDeParametros);    	
       $miComentario = new encuestas();
       $miComentario->setId_encuesta($ArrayDeParametros['id']);
       $miComentario->setCod_mesa($ArrayDeParametros['cod_mesa']);
       $miComentario->setMesa($ArrayDeParametros['mesa']);
       $miComentario->setRestaurante($ArrayDeParametros['restaurante']);
       $miComentario->setMozo($ArrayDeParametros['mozo']);
       $miComentario->setCocinero($ArrayDeParametros['cocinero']);
       $miComentario->setComentarios($ArrayDeParametros['comentarios']);
       
       $resultado =$miComentario->ModificarEncuesta();
       $objDelaRespuesta= new stdclass();
       //var_dump($resultado);
       $objDelaRespuesta->resultado=$resultado;
       $objDelaRespuesta->tarea="Encuesta para la mesa".$miComentario->getCod_mesa()."completada";
       return $response->withJson($objDelaRespuesta, 200);		
   }
}

?>