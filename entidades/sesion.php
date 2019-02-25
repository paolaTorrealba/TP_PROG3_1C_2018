<?php
require_once ('./datos/AccesoDatos.php');

// OPERACIONES
//-registrarSesion($arrayDeParametros)
//-traerTodos()

class sesion
{

	public $id;
  	public $usuario;
	public $fechaHora;	

   

    public static function registrarSesion($arrayDeParametros){
  
        $pdo = AccesoDatos::dameUnObjetoAcceso();
        try{
            $sql =$pdo->RetornarConsulta("INSERT into sesion (usuario,fechaHora)values(:usuario,CURRENT_TIMESTAMP)");
            $sql->bindValue(':usuario',$arrayDeParametros['usuario'], PDO::PARAM_STR);          
            $sql->execute();        

            return $sql->rowCount();
        }
        catch(Exception $e){
            return $e->getMessage();
        }
    }

    public static function traerTodos(){

        $pdo = AccesoDatos::dameUnObjetoAcceso();
        $sql = $pdo->RetornarConsulta("select * from sesion");
        $sql->execute();

        $resultado = $sql->fetchall(PDO::FETCH_CLASS, "sesion");       

        return $resultado;
    }
   
	 
}