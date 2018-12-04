<?php 
class facturas
{
    public $num_factura;
    public $cod_mesa;
    public $fecha;
    public $importe;
#region getters y setters
    public function getNum_Factura()
    {
        return $this->num_factura;
    }
    public function setNum_Factura($valor)
    {
        $this->num_factura = $valor;
    }
    public function getCod_mesa()
    {
        return $this->cod_mesa;
    }
    public function setCod_mesa($valor)
    {
        $this->cod_mesa = $valor;
    }
    public function getFecha()
    {
        return $this->fecha;
    }
    public function setFecha($valor)
    {
        $this->fecha = $valor;
    }
    public function getImporte()
    {
        return $this->importe;
    }
    public function setImporte($valor)
    {
        $this->importe = $valor;
    }
#endregion
    public static function TraerTodasLasFacturas()
    {
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
            $consulta =$objetoAccesoDato->RetornarConsulta("select * from facturas");
            $consulta->execute();			
            return $consulta->fetchAll(PDO::FETCH_CLASS, "facturas");		
    }
    public static function TraerMasMenosUsada($opcion)
    {   
        $opcion = strtolower($opcion);
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        if ($opcion=='mas') 
        {
            $consulta = $objetoAccesoDato->retornarConsulta("
            SELECT f.cod_mesa, COUNT(*) as veces_usada
            FROM facturas as f
            GROUP BY f.cod_mesa
            ORDER BY COUNT(*) DESC
            LIMIT 1");
        }
        else 
        {
            $consulta = $objetoAccesoDato->retornarConsulta("
            SELECT f.cod_mesa, COUNT(*) as veces_usada
            FROM facturas as f
            GROUP BY f.cod_mesa
            ORDER BY COUNT(*) ASC
            LIMIT 1");
        }

        $consulta->execute();
        $resultadoConsulta = $consulta->fetchAll(PDO::FETCH_OBJ);
        return $resultadoConsulta;
    }
        public static function TraerMasMenosRecaudado($opcion)
    {   /*dependiendo de la opcion va a ordenar de manera ascendente (para lo que recaudo menos)
        o descendente (para lo que recaudo mas)
        */
        $opcion = strtolower($opcion);
        $orden = 'ASC';
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        if ($opcion=='mas') 
        {
            $orden = 'DESC';
        }
        $consulta = $objetoAccesoDato->retornarConsulta("
        SELECT f.cod_mesa, SUM(f.importe) as total_recaudado
        FROM facturas as f
        GROUP BY f.cod_mesa
        ORDER BY SUM(f.importe) $orden
        LIMIT 1");
        

        $consulta->execute();
        $resultadoConsulta = $consulta->fetchAll(PDO::FETCH_OBJ);
        return $resultadoConsulta;
    }
    public static function TraerMayorMenorFactura($opcion)
    {   /*dependiendo de la opcion va a ordenar de manera ascendente (para lo que recaudo menos)
        o descendente (para lo que recaudo mas)
        */
        $opcion = strtolower($opcion);
        $orden = 'ASC';
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        if ($opcion=='mayor') 
        {
            $orden = 'DESC';
        }
        $consulta = $objetoAccesoDato->retornarConsulta("
        SELECT f.cod_mesa, f.importe
        FROM facturas as f
        ORDER BY f.importe $orden
        LIMIT 3");
        

        $consulta->execute();
        $resultadoConsulta = $consulta->fetchAll(PDO::FETCH_OBJ);
        return $resultadoConsulta;
    }
    public static function TraerRecaudacionFechas($cod,$fechaUno,$fechaDos)
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->retornarConsulta("
        SELECT f.cod_mesa, SUM(f.importe) as total_recaudado
        FROM facturas as f
        WHERE  f.cod_mesa = :cod_mesa AND f.fecha BETWEEN :fechaUno AND :fechaDos");
        $consulta->bindValue(':cod_mesa',$cod, PDO::PARAM_INT);
        $consulta->bindValue(':fechaUno',$fechaUno, PDO::PARAM_STR);
        $consulta->bindValue(':fechaDos',$fechaDos, PDO::PARAM_STR);
        $consulta->execute();
        $resultadoConsulta = $consulta->fetchAll(PDO::FETCH_OBJ);
        return $resultadoConsulta;
    }
    public function InsertarFactura()
    {
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
            $consulta =$objetoAccesoDato->RetornarConsulta("
            INSERT into facturas (cod_mesa, fecha, importe)values(:cod_mesa, :fecha, :importe)");
            $consulta->bindValue(':cod_mesa',$this->getCod_mesa(), PDO::PARAM_INT);
            $consulta->bindValue(':fecha', $this->getFecha(), PDO::PARAM_STR);
            $consulta->bindValue(':importe', $this->getImporte(), PDO::PARAM_STR);
            $consulta->execute();		
            return $objetoAccesoDato->RetornarUltimoIdInsertado();
    }
}

?>