<?php 
require_once "mesas.php";
require_once "facturas.php";

class mesasApi extends mesas
{
    public function ModificarUna($request, $response, $args) 
    {
       $ArrayDeParametros = $request->getParsedBody();
       $miMesa = new media();
       $miMesa->setCod_mesa($ArrayDeParametros['cod']);
       $miMesa->setEstado_mesa($ArrayDeParametros['estado']);
       $resultado =$miMesa->ModificarMesasParametros();
       $objDelaRespuesta= new stdclass();
       //var_dump($resultado);
       $objDelaRespuesta->resultado=$resultado;
       $objDelaRespuesta->tarea="Mesa". $miMesa->getCod_mesa();
       return $response->withJson($objDelaRespuesta, 200);		
   }
   public function ModificarEsperando($request, $response, $args) 
   {
      $ArrayDeParametros = $request->getParsedBody();
      $miMesa = new media();
      $miMesa->setCod_mesa($ArrayDeParametros['cod']);
      $miMesa->setEstado_mesa("con clientes esperando");
      $resultado =$miMesa->ModificarMesasParametros();
      $objDelaRespuesta= new stdclass();
      $objDelaRespuesta->resultado=$resultado;
      $objDelaRespuesta->tarea="Mesa ". $miMesa->getCod_mesa()." pedido tomado";
      return $response->withJson($objDelaRespuesta, 200);		
  }
   public function ModificarServir($request, $response, $args) 
   {
      $ArrayDeParametros = $request->getParsedBody();
      $miMesa = new media();
      $miMesa->setCod_mesa($ArrayDeParametros['cod']);
      $miMesa->setEstado_mesa("con clientes comiendo");
      $resultado =$miMesa->ModificarMesasParametros();
      $objDelaRespuesta= new stdclass();
      $objDelaRespuesta->resultado=$resultado;
      $objDelaRespuesta->tarea="Mesa ". $miMesa->getCod_mesa()." Servida";
      return $response->withJson($objDelaRespuesta, 200);		
  }
  public function ModificarCuenta($request, $response, $args) 
  {
     $ArrayDeParametros = $request->getParsedBody();
     $miMesa = new media();
     $miMesa->setCod_mesa($ArrayDeParametros['cod']);
     $miMesa->setEstado_mesa("con clientes pagando");
     $resultado =$miMesa->ModificarMesasParametros();
     $objDelaRespuesta= new stdclass();
     //var_dump($resultado);
     $objDelaRespuesta->resultado=$resultado;
     $objDelaRespuesta->tarea="Mesa ". $miMesa->getCod_mesa()." cuenta recibida";
     return $response->withJson($objDelaRespuesta, 200);		
 }
 public function ModificarCerrar($request, $response, $args) 
 {
    $ArrayDeParametros = $request->getParsedBody();
    $miMesa = new media();
    $miMesa->setCod_mesa($ArrayDeParametros['cod']);
    $miMesa->setEstado_mesa("cerrada");
    $resultado =$miMesa->ModificarMesasParametros();
    $objDelaRespuesta= new stdclass();
    //var_dump($resultado);
    $objDelaRespuesta->resultado=$resultado;
    $objDelaRespuesta->tarea="Mesa ". $miMesa->getCod_mesa()." Cerrada";
    return $response->withJson($objDelaRespuesta, 200);		
}
public function TraerFacturados($request, $response, $args)
{
    $ArrayDeParametros = $request->getParsedBody();
    $opcion = $ArrayDeParametros['opcion'];
    $miFacturacion=facturas::TraerMasMenosRecaudado($opcion);
    $objDelaRespuesta= new stdclass();
    $objDelaRespuesta->tarea="Mesa con ".$opcion." Facturacion!";
    $objDelaRespuesta->resultado=$miFacturacion;
    return $response->withJson($objDelaRespuesta, 200);		
}
public function TraerFacturaMayorMenor($request, $response, $args)
{
    $ArrayDeParametros = $request->getParsedBody();
    $opcion = $ArrayDeParametros['opcion'];
    $miFacturacion=facturas::TraerMayorMenorFactura($opcion);
    $objDelaRespuesta= new stdclass();
    $objDelaRespuesta->tarea="Mesas con ".$opcion." facturas!";
    $objDelaRespuesta->resultado=$miFacturacion;
    return $response->withJson($objDelaRespuesta, 200);		
}
}

?>