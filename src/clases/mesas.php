<?php 
require_once "AccesoDatos.php";
class mesas
{
    public $cod_mesa;
    public $estado_mesa;

#region setters y getters
    public function getCod_mesa()
    {
        return $this->cod_mesa;
    }

    public function setCod_mesa($value)
    {
        $this->cod_mesa;
    }

    public function getEstado_mesa()
    {
        return $this->estado_mesa;
    }

    public function setEstado_mesa($value)
    {
        $this->estado_mesa;
    }
#endregion

#region SQL
public static function TraerTodoLosMesas()
{
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
        $consulta =$objetoAccesoDato->RetornarConsulta("select * from mesas");
        $consulta->execute();			
        return $consulta->fetchAll(PDO::FETCH_CLASS, "mesas");		
}

public function ModificarMesasParametros()
{
       $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
       $consulta =$objetoAccesoDato->RetornarConsulta("
           update mesas
           set estado_mesa=:estado_mesa,
           WHERE cod_mesa=:cod_mesa");
       $consulta->bindValue(':cod_mesa',$this->getCod_mesa(), PDO::PARAM_INT);
       $consulta->bindValue(':estado_mesa',$this->getEstado_mesa(), PDO::PARAM_STR);
       return $consulta->execute();
}
public static function TraerPorComentarios($opcion)
{
        $opcion = strtolower($opcion);
        $orden = 'ASC';
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        if ($opcion=='mejores') 
        {
            $orden = 'DESC';
        } 
        $consulta =$objetoAccesoDato->RetornarConsulta("
        SELECT m.cod_mesa, SUM(e.mesa) as puntaje_total
        FROM mesas as m, encuestas as e
        WHERE m.cod_mesa = e.cod_mesa
        GROUP BY m.cod_mesa
        ORDER BY SUM(e.mesa) $orden
        LIMIT 1
        ");
        $consulta->execute();			
        return $consulta->fetchAll(PDO::FETCH_OBJ);		
}
#endregion
}

?>