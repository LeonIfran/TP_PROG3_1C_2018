<?php 
require_once "AccesoDatos.php";
class Personal
{
    public$id;
    public $nombre;
	public $perfil;
	public $usuario;
    
    public static function TraerUnEmpleado($id) 
	{
			$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			$consulta =$objetoAccesoDato->RetornarConsulta("select id, nombre, usuario, perfil from personal where id = $id");
			$consulta->execute();
			$cdBuscado= $consulta->fetchObject('personal');
			return $cdBuscado;				
	}

	public function InsertarPersonal()
	{
			   $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			   $consulta =$objetoAccesoDato->RetornarConsulta("INSERT into personal (nombre,perfil)values('$this->_nombre','$this->_perfil')");
			   $consulta->execute();
			   return $objetoAccesoDato->RetornarUltimoIdInsertado();
			   

	}

	public static function Logear($us,$pass)
	{
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
		//$consulta = $objetoAccesoDato->RetornarConsulta("select id, nombre, usuario, perfil from personal where usuario = '$us' AND pass = '$pass'");
		$consulta = $objetoAccesoDato->RetornarConsulta("select id, nombre, usuario, perfil from personal where usuario = :usuario AND pass = :pass");
		$consulta->bindValue(':usuario',$us,PDO::PARAM_STR);
		$consulta->bindValue(':pass',$pass,PDO::PARAM_STR);
		$consulta->execute();
		$EmpleadoLogeado = $consulta->fetchObject('Personal');
		echo var_dump($consulta);
		echo var_dump($EmpleadoLogeado);
		if (isempty($EmpleadoLogeado))
		{
			echo "se logeo<br>";
		}
		return $EmpleadoLogeado;
	}
}


?>