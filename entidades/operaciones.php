<?php
require_once ('./datos/AccesoDatos.php');

// OPERACIONES
//-crearUsuario($arrayDeParametros)
//-borrarUsuario($arrayDeParametros)
//-modificarUsuario($arrayDeParametros)
//-traerTodos()

class operaciones
{
	public $usuario;
	public $operaciones;

 
   
    public function traerOperacionesPorSector(){
        $pdo = AccesoDatos::dameUnObjetoAcceso();
        $sql = $pdo->RetornarConsulta("SELECT plato.sector, sum(cantidad) as operaciones 
        	                           FROM `pedido_producto`inner join plato on pedido_producto.idPlato=plato.id
                                       group by plato.sector");
        $sql->execute();
        $resultado = $sql->fetchall(PDO::FETCH_CLASS, "operaciones");  
        return $resultado;
    }

    public function traerOperacionesPorSectorYEmpl(){
         $pdo = AccesoDatos::dameUnObjetoAcceso();
        $sql = $pdo->RetornarConsulta("SELECT  pedido_producto.usuario, plato.sector, sum(cantidad) as operaciones 
        	                           FROM `pedido_producto`inner join plato on pedido_producto.idPlato=plato.id
                                       group by  pedido_producto.usuario order by plato.sector");
        $sql->execute();
        $resultado = $sql->fetchall(PDO::FETCH_CLASS, "operaciones");       

        return $resultado;
    }

    public function traerCantidadOperacionesPorEmpl(){
        $pdo = AccesoDatos::dameUnObjetoAcceso();
        $sql = $pdo->RetornarConsulta("SELECT  pedido_producto.usuario, sum(cantidad) as operaciones
                                       FROM `pedido_producto` group by  pedido_producto.usuario ");
        $sql->execute();
        $resultado = $sql->fetchall(PDO::FETCH_CLASS, "operaciones");       

        return $resultado;
    }
	 
}