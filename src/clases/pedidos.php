<?php 
require_once "AccesoDatos.php";
class Pedidos
{
    #region Atributos
    public $cod_pedido;
    public $cod_mesa;
    public $desc_pedido;
    public $foto_mesa;
    #endregion

    #region Setters y Getters
    public function Getcod_pedido()
    {
        return $this->cod_pedido;
    }

    public function Setcod_pedido($value)
    {
        $this->cod_pedido = $value;
    }
    public function Getcod_mesa()
    {
        return $this->cod_mesa;
    }

    public function Setcod_mesa($value)
    {
        $this->cod_mesa = $value;
    }
    public function Getdesc_pedido()
    {
        return $this->desc_pedido;
    }

    public function Setdesc_pedido($value)
    {
        $this->desc_pedido = $value;
    }
    public function Getfoto_mesa()
    {
        return $this->foto_mesa;
    }

    public function Setfoto_mesa($value)
    {
        $this->foto_mesa = $value;
    }
    #endregion
    #region Select
    public static function TraerTodosLosPedidos()
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("select cod_pedido, cod_mesa, desc_pedido from pedidos");
        $consulta->execute();
        return $consulta->fetchAll(PDO::FETCH_CLASS, "pedidos");
    }
    public static function TraerTodosPedidosConDetalles()
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("
        select p.cod_pedido, p.cod_mesa, d.item, d.estado_pedido
        from pedido_detalles as d, pedidos as p
        WHERE p.cod_pedido = d.cod_pedido
        ");
        $consulta->execute();
        return $consulta->fetchAll(PDO::FETCH_OBJ);
    }
    public static function TraerUnPedido($codmesa)
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("select * from pedidos WHERE cod_pedido=:cod_pedido");
        $consulta->bindvalue(':cod_pedido',$codmesa, PDO::PARAM_STR);
        $consulta->execute();
        $resultadoConsulta = $consulta->fetchAll(PDO::FETCH_OBJ);
        return $resultadoConsulta;
    }
    public static function TraerUnPedidoConDetalles($codmesa)
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("select p.cod_pedido, p.cod_mesa, d.item, d.estado_pedido, d.tiempo_estimado from pedidos as p, pedido_detalles as d WHERE d.cod_pedido=p.cod_pedido AND p.cod_pedido=:cod_pedido");
        $consulta->bindvalue(':cod_pedido',$codmesa, PDO::PARAM_STR);
        $consulta->execute();
        $resultadoConsulta = $consulta->fetchAll(PDO::FETCH_OBJ);
        return $resultadoConsulta;
    }
    public static function TraerUnPedidoClientes($codPedido)
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("
        SELECT cod_pedido,item,tiempo_inicio,tiempo_estimado ,TIMEDIFF(TIMESTAMP(tiempo_inicio,tiempo_estimado),CURRENT_TIMESTAMP) as tiempo_restante
        FROM `pedido_detalles` 
        WHERE estado_pedido = 'en preparacion' 
        AND
        cod_pedido = :cod_pedido
        AND 
        TIMEDIFF(TIMESTAMP(tiempo_inicio,tiempo_estimado),CURRENT_TIMESTAMP)>0");
        $consulta->bindvalue(':cod_pedido',$codPedido, PDO::PARAM_STR);
        $consulta->execute();
        $resultadoConsulta = $consulta->fetchAll(PDO::FETCH_OBJ);
        return $resultadoConsulta;
    }
    #endregion
    #region insert
    public function InsertUnPedido()
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("INSERT INTO pedidos (cod_pedido, cod_mesa, desc_pedido, foto_mesa) VALUES (:cod_pedido, :cod_mesa, :desc_pedido, :foto_mesa)");
        $consulta->bindValue(':cod_pedido',$this->Getcod_pedido(), PDO::PARAM_STR);
        $consulta->bindValue(':cod_mesa',$this->Getcod_mesa(),PDO::PARAM_INT);
        $consulta->bindValue(':desc_pedido',$this->Getdesc_pedido(),PDO::PARAM_STR);
        $consulta->bindValue(':foto_mesa',$this->Getfoto_mesa(),PDO::PARAM_STR);
        $consulta->execute();
        return $objetoAccesoDato->RetornarUltimoIdInsertado();
    }


    #endregion
}


?>