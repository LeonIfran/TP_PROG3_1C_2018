<?php 
require_once "AccesoDatos.php";
class encuestas
{
    public $id_encuesta;
    public $cod_mesa;
    public $fecha;
    public $mesa;
    public $restaurante;
    public $mozo;
    public $cocinero;
    public $comentarios;
#region setters y getters
    public function getId_encuesta()
    {
        return $this->id_encuesta;
    }
    public function setId_encuesta($value)
    {
        $this->id_encuesta=$value;
    }
    public function getCod_mesa()
    {
        return $this->cod_mesa;
    }
    public function setCod_mesa($value)
    {
        $this->cod_mesa=$value;
    }
    public function getFecha()
    {
        return $this->fecha;
    }
    public function setFecha($value)
    {
        $this->fecha=$value;
    }
    public function getMesa()
    {
        return $this->mesa;
    }
    public function setMesa($value)
    {
        $this->mesa=$value;
    }
    public function getRestaurante()
    {
        return $this->restaurante;
    }
    public function setRestaurante($value)
    {
        $this->restaurante=$value;
    }
    public function getMozo()
    {
        return $this->mozo;
    }
    public function setMozo($value)
    {
        $this->mozo=$value;
    }
    public function getCocinero()
    {
        return $this->cocinero;
    }
    public function setCocinero($value)
    {
        $this->cocinero=$value;
    }
    public function getComentarios()
    {
        return $this->comentarios;
    }
    public function setComentarios($value)
    {
        $this->comentarios=$value;
    }
#endregion

#region SQL
    public function InsertarEncuesta()
    {
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
            $consulta =$objetoAccesoDato->RetornarConsulta("INSERT into encuestas (cod_mesa, fecha)values(:cod_mesa, :fecha)");
            $consulta->bindValue(':cod_mesa',$this->getCod_mesa(), PDO::PARAM_INT);
            $consulta->bindValue(':fecha', $this->getFecha(), PDO::PARAM_STR);
            $consulta->execute();		
            return $objetoAccesoDato->RetornarUltimoIdInsertado();
    }
    public function ModificarEncuesta()
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
        $consulta =$objetoAccesoDato->RetornarConsulta("
            update encuestas 
            set mesa=:mesa,
            restaurante=:restaurante,
            mozo=:mozo,
            cocinero=:cocinero,
            comentarios=:comentarios
            WHERE cod_mesa=:cod_mesa AND id_encuesta=:id_encuesta");
        $consulta->bindValue(':id_encuesta',$this->getId_encuesta(), PDO::PARAM_INT);
        $consulta->bindValue(':cod_mesa',$this->getCod_mesa(), PDO::PARAM_INT);
        $consulta->bindValue(':mesa',$this->getMesa(), PDO::PARAM_INT);
        $consulta->bindValue(':restaurante', $this->getRestaurante(), PDO::PARAM_INT);
        $consulta->bindValue(':mozo', $this->getMozo(), PDO::PARAM_INT);
        $consulta->bindValue(':cocinero', $this->getCocinero(), PDO::PARAM_INT);
        $consulta->bindValue(':comentarios', $this->getComentarios(), PDO::PARAM_STR);
        
        return $consulta->execute();
    }
#
}

?>