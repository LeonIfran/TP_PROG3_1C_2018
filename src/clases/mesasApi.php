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
    public function TrearFechas($request, $response, $args)
    {
        $objDelaRespuesta= new stdclass();
        $ArrayDeParametros = $request->getParsedBody();
        $cod = $ArrayDeParametros['cod'];
        $fechaUno = $ArrayDeParametros['fechaUno'];
        $fechaDos = $ArrayDeParametros['fechaDos'];
        $miFacturacion=facturas::TraerRecaudacionFechas($cod,$fechaUno,$fechaDos);
        $total = $miFacturacion[0]->total_recaudado;//tomo el resultado de la suma
        if ($total !=NULL)//si no es null traigo el resultado 
        {
            $objDelaRespuesta->mensaje="Se facturo esto entre las fechas ";
            $objDelaRespuesta->resultado=$miFacturacion;
        }
        else {
            $objDelaRespuesta->mensaje="No se encontraron datos para la mesa $cod en las fechas dadas";
        }
        //$objDelaRespuesta->resultado=$miFacturacion;
        return $response->withJson($objDelaRespuesta, 200);		
    }
    public function TraerComentarios($request, $response, $args)
    {
        $ArrayDeParametros = $request->getParsedBody();
        if ($ArrayDeParametros['opcion']!='mejores' && $ArrayDeParametros['opcion']!='peores' ) 
        {//por defecto va a mostrar peores comentarios
            $opcion='peores';
        }
        else { 
            $opcion = $ArrayDeParametros['opcion'];
         } 
        
        $miFacturacion=mesas::TraerPorComentarios($opcion);
        $objDelaRespuesta= new stdclass();
        $objDelaRespuesta->tarea="Mesa con ".$opcion." comentarios";
        $objDelaRespuesta->resultado=$miFacturacion;
        return $response->withJson($objDelaRespuesta, 200);		
    }
}

?>