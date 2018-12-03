<?php 
require_once "AccesoDatos.php";
class Personal
{
	#region Atributos
    public $id;
	public $perfil;
	public $usuario;
	private $_pass;
	public $estado;

	#endregion
	#region setters y getters
	public function getId()
	{
		return $this->id;
	}
	public function setId($value)
	{
		$this->id = $value;
	}
	public function getPerfil()
	{
		return $this->perfil;
	}
	public function setPerfil($value)
	{
		$this->perfil = $value;
	}
	public function getUsuario()
	{
		return $this->usuario;
	}
	public function setUsuario($value)
	{
		$this->usuario = $value;
	}
	public function getPass()
	{
		return $this->_pass;
	}
	public function setPass($value)
	{
		$this->_pass = $value;
	}
	public function getEstado()
	{
		return $this->estado;
	}
	public function setEstado($value)
	{
		$this->estado = $value;
	}
	#endregion
    
    public static function TraerUnEmpleado($id) 
	{
			$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			$consulta =$objetoAccesoDato->RetornarConsulta("select id, nombre, usuario, perfil, estado from personal where id = :id");
			$consulta->bindvalue(':id',$id, PDO::PARAM_INT);
			$consulta->execute();
			$cdBuscado= $consulta->fetchObject('personal');
			return $cdBuscado;				
	}

	public function InsertarPersonal()
	{
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta =$objetoAccesoDato->RetornarConsulta("INSERT into personal (usuario,pass,perfil)values(:usuario,:pass,:perfil)");
		$consulta->bindValue(':usuario',$this->getUsuario(), PDO::PARAM_STR);
		$consulta->bindValue(':perfil', $this->getPerfil(), PDO::PARAM_STR);
		$consulta->bindValue(':pass', $this->getPass(), PDO::PARAM_STR);
		//$consulta->bindValue(':estado', $this->getEstado(), PDO::PARAM_STR);
		$consulta->execute();		
		return $objetoAccesoDato->RetornarUltimoIdInsertado();
	}

	public static function Logear($us,$clave)
	{
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
		$consulta = $objetoAccesoDato->RetornarConsulta("select id, usuario, perfil, estado from personal where usuario = :usuario AND pass = :pass");
		$consulta->bindValue(':usuario',$us,PDO::PARAM_STR);
		$consulta->bindValue(':pass',$clave,PDO::PARAM_STR);
		$consulta->execute();
		$EmpleadoLogeado = $consulta->fetchObject('personal');
		return $EmpleadoLogeado;
	}
	public function ModificarPersonal()
	{
		   $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		   $consulta =$objetoAccesoDato->RetornarConsulta("
			   update personal 
			   set usuario=:usuario,
			   pass=:pass,
			   perfil=:perfil,
			   estado=:estado
			   WHERE id=:id");
		   $consulta->bindValue(':id',$this->getId(), PDO::PARAM_INT);
		   $consulta->bindValue(':usuario',$this->getUsuario(), PDO::PARAM_STR);
		   $consulta->bindValue(':perfil', $this->getPerfil(), PDO::PARAM_STR);
		   $consulta->bindValue(':pass', $this->getPass(), PDO::PARAM_STR);
		   $consulta->bindValue(':estado', $this->getEstado(), PDO::PARAM_STR);
		   return $consulta->execute();
	}
	public function ModificarPerfilPersonal()
	{
		   $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		   $consulta =$objetoAccesoDato->RetornarConsulta("
			   update personal 
			   set perfil=:perfil
			   WHERE id=:id");
		   
		   $consulta->bindValue(':perfil', $this->getPerfil(), PDO::PARAM_STR);
		   return $consulta->execute();
	}
	public function ModificarEstadoPersonal()
	{
		   $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		   $consulta =$objetoAccesoDato->RetornarConsulta("
			   update personal 
			   set estado=:estado
			   WHERE id=:id");
		   $consulta->bindValue(':id',$this->getId(), PDO::PARAM_INT);
		   $consulta->bindValue(':estado', $this->getEstado(), PDO::PARAM_STR);
		   return $consulta->execute();
	}
	public function BorrarPersonal()
	{
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
		$consulta =$objetoAccesoDato->RetornarConsulta("
			   delete 
			   from personal 				
			   WHERE id=:id");	
		$consulta->bindValue(':id',$this->getId(), PDO::PARAM_INT);		
		$consulta->execute();
		return $consulta->rowCount();
	}
	
}


?>