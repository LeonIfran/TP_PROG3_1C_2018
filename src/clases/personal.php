<?php 
require_once "AccesoDatos.php";
class Personal
{
    public$_id;
    public $_nombre;
    public $_perfil;
    
    public static function TraerUnEmpleado($id) 
	{
			$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			$consulta =$objetoAccesoDato->RetornarConsulta("select id, nombre, perfil from personal where id = $id");
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
}


?>