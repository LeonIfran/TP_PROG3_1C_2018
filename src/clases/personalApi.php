<?php 
require_once "personal.php";
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
       $nombre = $ArrayDeParametros['nombre'];
       $perfil = $ArrayDeParametros['perfil'];


       $miPersonal = new Personal();
       $miPersonal->_nombre = $nombre;
       $miPersonal->_perfil = $perfil;
       $miPersonal->InsertarPersonal();
       $response->getBody()->write("se guardo el Personal");
   }

   public function LogearUno($request, $response,$args)
   {
       $respuesta= new stdclass();
       $eltoken = NULL;
       $elLogeo = NULL;

       $ArrayDeParametros = $request->getParsedBody();
       $usuario=$ArrayDeParametros['usuario'];
       $pass=$ArrayDeParametros['pass'];
       $datosUsuario=Personal::Logear($usuario,$pass);
       
       if ($datosUsuario != NULL) 
       {
           $eltoken = AutentificadorJWT::CrearToken($datosUsuario);
       }

       $respuesta = array('datos'=>$datosUsuario,'token'=>$eltoken);  
       //guardo el token en el header

       //$newresponse=$response->withAddedHeader('token', $eltoken);

       //$newresponse=$response->withAddedHeader('token', $eltoken);
       //echo var_dump($response->getHeader('token'));
       //$response->getBody()->write('{"valido":"true","empleado":'.json_encode($empleado).',"token":"'.$jwt.'"}');
       //$newResponse=$response->getBody()->write('{"Valido":"true","token":"'.$eltoken.'"}');
       //echo var_dump($response->getBody());
       return $response->withJson($respuesta,200);
       //return $newResponse;
       
   }

   public function HolaMundo($request, $response, $args)
   {
       //$request->getHeader('token');
       //$request->getBody('token');
       echo "<br>llegue al hola mundo porque todo funciono<br>";
   }
}



?>