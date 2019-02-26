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
        	                           FROM `pedido_plato`inner join plato on pedido_plato.idPlato=plato.id
                                       group by plato.sector");
        $sql->execute();
        $resultado = $sql->fetchall(PDO::FETCH_CLASS, "operaciones");  
        return $resultado;
    }

    public function traerOperacionesPorSectorYEmpl(){
         $pdo = AccesoDatos::dameUnObjetoAcceso();
        $sql = $pdo->RetornarConsulta("SELECT  pedido_plato.usuario, plato.sector, sum(cantidad) as operaciones 
        	                           FROM `pedido_plato`inner join plato on pedido_plato.idPlato=plato.id
                                       group by  pedido_plato.usuario order by plato.sector");
        $sql->execute();
        $resultado = $sql->fetchall(PDO::FETCH_CLASS, "operaciones");       

        return $resultado;
    }

    public function traerCantidadOperacionesPorEmpl(){
        $pdo = AccesoDatos::dameUnObjetoAcceso();
        $sql = $pdo->RetornarConsulta("SELECT  pedido_plato.usuario, sum(cantidad) as operaciones
                                       FROM `pedido_plato` group by  pedido_plato.usuario ");
        $sql->execute();
        $resultado = $sql->fetchall(PDO::FETCH_CLASS, "operaciones");       

        return $resultado;
    }
	 
}