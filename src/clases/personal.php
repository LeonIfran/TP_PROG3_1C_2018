<?php 
require_once "AccesoDatos.php";
class Personal
{
	#region Atributos
    public $id;
    public $nombre;
	public $perfil;
	public $usuario;
	public $fecha_alta;
	public $operaciones;
	#endregion
	#region setters y getters
	public function getFecha()
	{
		return $this->fecha_alta;
	}
	public function getOperaciones()
	{
		return $this->operaciones;
	}
	public function setOperaciones($value)
	{
		$this->operaciones = $value;
	}
	#endregion
    
    public static function TraerUnEmpleado($id) 
	{
			$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			$consulta =$objetoAccesoDato->RetornarConsulta("select id, nombre, usuario, perfil, fecha_alta, operaciones from personal where id = :id");
			$consulta->bindvalue(':id',$id, PDO::PARAM_INT);
			$consulta->execute();
			$cdBuscado= $consulta->fetchObject('personal');
			return $cdBuscado;				
	}

	public function InsertarPersonal()
	{
			   $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			   $consulta =$objetoAccesoDato->RetornarConsulta("INSERT into personal (nombre,perfil, usuario, pass)values(:nombre, :perfil,)");
			   $consulta->execute();
			   return $objetoAccesoDato->RetornarUltimoIdInsertado();
			   

	}

	public static function Logear($us,$clave)
	{
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
		$consulta = $objetoAccesoDato->RetornarConsulta("select id, nombre, usuario, perfil from personal where usuario = :usuario AND pass = :pass");
		$consulta->bindValue(':usuario',$us,PDO::PARAM_STR);
		$consulta->bindValue(':pass',$clave,PDO::PARAM_STR);
		$consulta->execute();
		$EmpleadoLogeado = $consulta->fetchObject('personal');
		return $EmpleadoLogeado;
	}
}


?>