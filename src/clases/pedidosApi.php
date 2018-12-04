<?php 
require_once "pedidos.php";
require_once "generador.php";
class pedidosApi extends pedidos
{
    public function TraerTodos($request, $response, $args)
    {
        $todosLosPedidos=pedidos::TraerTodosLosPedidos();
        $newresponse = $response->withJson($todosLosPedidos,200);
        return $newresponse;
    }
    public function TraerTodosConDetalle($request, $response, $args)
    {
        $todosLosPedidos=pedidos::TraerTodosPedidosConDetalles();
        $newresponse = $response->withJson($todosLosPedidos,200);
        return $newresponse;
    }
    public function TraerUno($request, $response, $args)
    {
        //$cod=$args['cod'];
        
        $ArrayDeParametros= $request->getParsedBody();
        $cod=$ArrayDeParametros['cod'];
        $UnPedido=pedidos::TraerUnPedido($cod);
        $newresponse = $response->withJson($UnPedido,200);
        return $newresponse;
    }
    public function TraerUnoDetalles($request, $response, $args)
    {
        $ArrayDeParametros= $request->getParsedBody();
        $cod=$ArrayDeParametros['cod'];
        $UnPedido=pedidos::TraerUnPedidoConDetalles($cod);
        $newresponse = $response->withJson($UnPedido,200);
        return $newresponse;
    }
    public function CargarUno($request, $response, $args)
    {
        $objDelaRespuesta= new stdclass();
        $ArrayDeParametros = $request->getParsedBody();//tomo los parametros del POST

        //los asigno a variables
        $cod_mesa= $ArrayDeParametros['codmesa'];
        $descpedido= $ArrayDeParametros['descpedido'];
        //$foto= $ArrayDeParametros['foto'];
        $codpedido = generador::randomKey(5);//obtengo el codigo del pedido
        //$codpedido = 'AE89B';
        //creo mi clase
        $miPedido = new pedidos();
        //asigno los atributos
        $miPedido->Setcod_pedido($codpedido);
        $miPedido->Setcod_mesa($cod_mesa);
        $miPedido->Setdesc_pedido($descpedido);
        $miPedido->Setfoto_mesa('Vacio');
        //guardo la foto
        $archivos = $request->getUploadedFiles();
        $destino="src/clases/fotos/";
        //var_dump($archivos);
        //var_dump($archivos['foto']);
        if(isset($archivos['foto']))
        {
            $nombreAnterior=$archivos['foto']->getClientFilename();
            $extension= explode(".", $nombreAnterior)  ;//quito el punto y guardo la extension y el nombre en distintos indices
            //var_dump($nombreAnterior);
            $extension=array_reverse($extension);//doy vuelta el array para que la extension este en el indice 0
            //echo $destino.$cod_mesa.".".$extension[0];
            $pathCompleto = $destino.$cod_mesa."_".$codpedido.".".$extension[0];
            //echo $pathCompleto;
            //$archivos['foto']->moveTo($destino.$cod_mesa.".".$extension[0]);
            $archivos['foto']->moveTo($pathCompleto);

            //$mimedia->foto=$destino.$marca."_".$color.".".$extension[0];
            $miPedido->Setfoto_mesa($pathCompleto);
        }

        $miPedido->InsertUnPedido();
        $objDelaRespuesta->respuesta="Se guardo El pedido $codpedido para la mesa $cod_mesa con foto: ".$miPedido->Getfoto_mesa();   
        return $response->withJson($objDelaRespuesta, 200);
        


    }
}

?>