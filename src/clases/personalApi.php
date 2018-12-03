<?php 
require_once "personal.php";
require_once "logeos.php";
require_once "AutentificadorJWT.php";
class PersonalApi extends Personal
{
    public function TraerUno($request, $response, $args) 
    {
        $id=$args['id'];
        $elEmpleado=Personal::TraerUnEmpleado($id);
        $newResponse = $response->withJson($elEmpleado, 200);  
        return $newResponse;
   }
   public function InsertarUno($request, $response, $args)
   {
       $ArrayDeParametros = $request->getParsedBody();
       $usuario = $ArrayDeParametros['usuario'];
       $perfil = $ArrayDeParametros['perfil'];
       $pass = $ArrayDeParametros['pass'];
       //$estado = $ArrayDeParametros['estado'];

       $miPersonal = new Personal();
       $miPersonal->setUsuario($usuario);
       $miPersonal->setPerfil($perfil);
       $miPersonal->setPass($pass);
       //$miEstado->setEstado($estado);
       $miPersonal->InsertarPersonal();
       $response->getBody()->write("se guardo el Personal ".$miPersonal->getUsuario());
   }

   public function LogearUno($request, $response,$args)
   {
       $respuesta= new stdclass();
       $eltoken = NULL;
       $elLogeo = NULL;
       $fechaActual = date('Y-m-d H:i:s');
       $ArrayDeParametros = $request->getParsedBody();
       $usuario=$ArrayDeParametros['usuario'];
       $pass=$ArrayDeParametros['pass'];
       $datosUsuario=Personal::Logear($usuario,$pass);
       
       if ($datosUsuario != NULL) 
       {
           $eltoken = AutentificadorJWT::CrearToken($datosUsuario);
           logeos::InsertarUnLogeo($datosUsuario->id,$fechaActual);
           //echo var_dump($datosUsuario->id);
       }

       //$respuesta = array('Mensaje'=>"Bienvenido: ".$datosUsuario->nombre."Su puesto de hoy es: ".$datosUsuario->perfil,'token'=>$eltoken);  

       return $response->withJson($eltoken,200);
       
   }

   public function TraerLogs($request, $response, $args) 
   {
       $misLogs=logeos::TraerTodosLosLogs();
       $newResponse = $response->withJson($misLogs, 200);  
       return $newResponse;
   }
  public function CambiarEstado($request, $response, $args)
  {
    $ArrayDeParametros = $request->getParsedBody();
    $miPersonal = new personal();
    $miPersonal->setId($ArrayDeParametros['id']);
    $miPersonal->setEstado($ArrayDeParametros['estado']);
    
    $resultado =$miPersonal->ModificarEstadoPersonal($request, $response, $args);
    $objDelaRespuesta= new stdclass();
    $objDelaRespuesta->resultado=$resultado;
    $objDelaRespuesta->tarea="Se cambio el estado del empleado con id:".$miPersonal->getId();
    return $response->withJson($objDelaRespuesta, 200);		
  }
  public function BorrarUno($request, $response, $args) {
    $ArrayDeParametros = $request->getParsedBody();
    $id=$ArrayDeParametros['id'];
    $personal= new personal();
    $personal->setId($id);
    $cantidadDeBorrados=$personal->BorrarPersonal();
    $objDelaRespuesta= new stdclass();
    $objDelaRespuesta->cantidad=$cantidadDeBorrados;
   if($cantidadDeBorrados>0)
       {
            $objDelaRespuesta->resultado="se borro el Personal con ID: $id!!!";
       }
       else
       {
           $objDelaRespuesta->resultado="no Borro nada!!!";
       }
    $newResponse = $response->withJson($objDelaRespuesta, 200);
    return $newResponse;
}
   public function HolaMundo($request, $response, $args)
   {
       //$request->getHeader('token');
       //$request->getBody('token');
       echo "<br>llegue al hola mundo porque todo funciono<br>";
   }
}



?>