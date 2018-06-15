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
       $ArrayDeParametros = $request->getParsedBody();
       $usuario=$ArrayDeParametros['usuario'];
       $pass=$ArrayDeParametros['pass'];
       $elLogeo=Personal::Logear($usuario,$pass);
       $eltoken = NULL;
       //$newResponse = $response->withJson($elLogeo,200);
       if ($elLogeo != NULL) 
       {
            //$datos = $response->withJson($elLogeo, 200);
            $eltoken = AutentificadorJWT::CrearToken($elLogeo);
       }
       //$response->getBody()->write($elLogeo);
       //return $response;
       return $eltoken;

   }
}



?>