<?php 
require_once "AccesoDatos.php";
class logeos
{
    public $id;
    public $fecha_logeo;

    public function getId()
	{
		return $this->id;
	}
	public function setId($value)
	{
		$this->id = $value;
    }
    public function getFecha_logeo()
	{
		return $this->fecha_logeo;
	}
	public function setFecha_logeo($value)
	{
		$this->fecha_logeo = $value;
    }
    public function InsertarLogeo()
	{
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta =$objetoAccesoDato->RetornarConsulta("INSERT into logeos (id,fecha_logeo)values(:id,:fecha_logeo)");
		$consulta->bindValue(':id',$this->getId(), PDO::PARAM_INT);
		$consulta->bindValue(':fecha_logeo', $this->getFecha_logeo(), PDO::PARAM_STR);
		$consulta->execute();		
		return $objetoAccesoDato->RetornarUltimoIdInsertado();
    }
    public static function InsertarUnLogeo($Id,$fecha)
	{
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta =$objetoAccesoDato->RetornarConsulta("INSERT into logeos (id,fecha_logeo)values(:id,:fecha_logeo)");
		$consulta->bindValue(':id',$Id, PDO::PARAM_INT);
		$consulta->bindValue(':fecha_logeo', $fecha, PDO::PARAM_STR);
		$consulta->execute();		
		return $objetoAccesoDato->RetornarUltimoIdInsertado();
	}
	public static function TraerTodosLosLogs()
	{
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
		$consulta = $objetoAccesoDato->retornarConsulta("SELECT L.id, P.usuario, L.fecha_logeo FROM logeos AS L, personal AS P WHERE L.id=P.id");
		$consulta->execute();
		return $consulta->fetchAll(PDO::FETCH_OBJ);
	}
}

?>