<?php
require_once ('./datos/AccesoDatos.php');
class Usuario
{
	public $nombre;
 	public $apellido;
  	public $usuario;
	public $perfil;
	public $clave;
	public $estado;
	public $id_usuario;
	public $ult_fecha_log;



/*Nuevo metodo*/
 public static function crearUsuario($arrayDeParametros){
        $pdo = AccesoDatos::dameUnObjetoAcceso();
        try{
            $sql =$pdo->RetornarConsulta("INSERT into usuarios (usuario,clave,perfil,nombre,apellido)values(:usuario,:clave,:perfil,:nombre,:apellido)");

            $nombre = ucwords(strtolower($arrayDeParametros['nombre']));
            $apellido = ucwords(strtolower($arrayDeParametros['apellido']));
            

            $sql->bindValue(':usuario', strtoupper(str_split($arrayDeParametros['perfil'],3)[0])."_".strtoupper($arrayDeParametros['apellido']).".".strtoupper(str_split($arrayDeParametros['nombre'],4)[0]), PDO::PARAM_STR);
            $sql->bindValue(':clave', $arrayDeParametros['clave'], PDO::PARAM_STR);
            $sql->bindValue(':perfil', strtolower($arrayDeParametros['perfil']), PDO::PARAM_STR);
            $sql->bindValue(':nombre', $nombre, PDO::PARAM_STR);
            $sql->bindValue(':apellido', $apellido, PDO::PARAM_STR);
            $sql->execute();            
            return $sql->rowCount();
        }
        catch(Exception $e){
            return $e->getMessage();
        }
    }

    public static function traerTodos(){
        $pdo = AccesoDatos::dameUnObjetoAcceso();
        $sql = $pdo->RetornarConsulta("select * from usuarios");
        $sql->execute();

        $resultado = $sql->fetchall(PDO::FETCH_CLASS, "login");       

        return $resultado;
    }
	 
}