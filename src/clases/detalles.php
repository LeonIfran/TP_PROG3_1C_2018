<?php 
require_once "AccesoDatos.php";
class detalles
{
    public $cod_pedido;
    public $item;
    public $area;
    public $estado_pedido;
    public $tiempo_estimado=null;
    public $tiempo_inicio=null;
    public $id=NULL;
    #region setters y getters
    public function getCod_pedido()
    {
        return $this->cod_pedido;
    }

    public function setCod_pedido($value)
    {
        $this->cod_pedido=$value;
    }

    public function getItem()
    {
        return $this->item;
    }

    public function setItem($value)
    {
        $this->item=$value;
    }
    public function getArea()
    {
        return $this->area;
    }

    public function setArea($value)
    {
        $this->area=$value;
    }
    public function getEstado_pedido()
    {
        return $this->estado_pedido;
    }

    public function setEstado_pedido($value)
    {
        $this->estado_pedido=$value;
    }
    public function getTiempo_estimado()
    {
        return $this->tiempo_estimado;
    }

    public function setTiempo_estimado($value)
    {
        $this->tiempo_estimado=$value;
    }
    public function getTiempo_inicio()
    {
        return $this->tiempo_inicio;
    }

    public function setTiempo_inicio($value)
    {
        $this->tiempo_inicio=$value;
    }
    public function getId()
    {
        return $this->id;
    }

    public function setId($value)
    {
        $this->id=$value;
    }
    #endregion


#region SQL
public static function TraerTodosLosDetalles()
{
    $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
    $consulta = $objetoAccesoDato->RetornarConsulta("select * from pedido_detalles");
    $consulta->execute();
    return $consulta->fetchAll(PDO::FETCH_CLASS, "detalles");
}
public static function TraerUnDetalle($codpedido)
{
    $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
    $consulta = $objetoAccesoDato->RetornarConsulta("select * from pedido_detalles WHERE cod_pedido=:cod_pedido");
    $consulta->bindvalue(':cod_pedido',$codpedido, PDO::PARAM_STR);
    $consulta->execute();
    $resultadoConsulta = $consulta->fetchAll(PDO::FETCH_CLASS,'detalles');
    return $resultadoConsulta;
}
public static function TraerUnDetalleCliente($codpedido)
{
    $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
    $consulta = $objetoAccesoDato->RetornarConsulta("select cod_pedido, item, tiempo_estimado, tiempo_inicio from pedido_detalles WHERE cod_pedido=:cod_pedido");
    $consulta->bindvalue(':cod_pedido',$codpedido, PDO::PARAM_STR);
    $consulta->execute();
    $resultadoConsulta = $consulta->fetchAll(PDO::FETCH_CLASS,'detalles');
    return $resultadoConsulta;
}
public static function TraerDetallesArea($area)
{
    $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
    $consulta = $objetoAccesoDato->RetornarConsulta("select * from pedido_detalles WHERE area=:area");
    $consulta->bindvalue(':area',$area, PDO::PARAM_STR);
    $consulta->execute();
    $resultadoConsulta = $consulta->fetchAll(PDO::FETCH_CLASS,'detalles');
    return $resultadoConsulta;
}
public static function TraerDetallesPendientesArea($area)
{
    $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
    $consulta = $objetoAccesoDato->RetornarConsulta("select * from pedido_detalles WHERE area=:area AND estado_pedido=:estado_pedido");
    $consulta->bindvalue(':area',$area, PDO::PARAM_STR);
    $consulta->bindvalue(':estado_pedido','pendiente', PDO::PARAM_STR);
    $consulta->execute();
    $resultadoConsulta = $consulta->fetchAll(PDO::FETCH_CLASS,'detalles');
    return $resultadoConsulta;
}
public function InsertUnDetalle()
{
    $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
    //$consulta = $objetoAccesoDato->RetornarConsulta("INSERT INTO pedido_detalles (cod_pedido, item, area, estado_pedido, tiempo_estimado, tiempo_inicio) VALUES (:cod_pedido, :item, :area, :estado_pedido, :tiempo_estimado, :tiempo_inicio)");
    $consulta = $objetoAccesoDato->RetornarConsulta("INSERT INTO pedido_detalles (cod_pedido, item, area, estado_pedido) VALUES (:cod_pedido, :item, :area, :estado_pedido)");
    $consulta->bindValue(':cod_pedido',$this->getCod_pedido(), PDO::PARAM_STR);
    $consulta->bindValue(':item',$this->getItem(),PDO::PARAM_STR);
    $consulta->bindValue(':area',$this->getArea(),PDO::PARAM_STR);
    $consulta->bindValue(':estado_pedido',$this->getEstado_pedido(),PDO::PARAM_STR);
    //$consulta->bindValue(':tiempo_estimado',$this->getTiempo_estimado(),PDO::PARAM_STR);
    //$consulta->bindValue(':tiempo_inicio',$this->getTiempo_inicio(),PDO::PARAM_STR);
    $consulta->execute();
    return $objetoAccesoDato->RetornarUltimoIdInsertado();
}

public function ModificarEstado()
{
       $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
       $consulta =$objetoAccesoDato->RetornarConsulta("
           update pedido_detalles 
           set estado_pedido=:estado_pedido,
           tiempo_estimado=:tiempo_estimado,
           id=:id
           WHERE cod_pedido=:cod_pedido AND item=:item");
       $consulta->bindValue(':cod_pedido',$this->getCod_pedido(), PDO::PARAM_STR);
       $consulta->bindValue(':estado_pedido',$this->getEstado_pedido(), PDO::PARAM_STR);
       $consulta->bindValue(':tiempo_estimado',$this->getTiempo_estimado(), PDO::PARAM_STR);
       $consulta->bindValue(':id',$this->getId(), PDO::PARAM_INT);
       $consulta->bindValue(':item',$this->getItem(), PDO::PARAM_STR);
       return $consulta->execute();
}
#endregion
}
?>