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
/*    public function hacerAlgo($request, $response, $args)
   {
        echo var_dump($request->getParsedBody());
   } */

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

   public function HolaMundo($request, $response, $args)
   {
       //$request->getHeader('token');
       //$request->getBody('token');
       echo "<br>llegue al hola mundo porque todo funciono<br>";
   }
}



?>