<?php
use \Firebase\JWT\JWT;
require_once "./datos/AccesoDatos.php";

class login{

    public $usuario;
    public $clave;
    public $perfil;
    public $nombre;
    public $apellido;
    public $estado;

   //  OPERACIONES
    //-consultaLogin($arrayDeParametros)


    public static function consultaLogin($arrayDeParametros){     
    
        $pdo = AccesoDatos::dameUnObjetoAcceso();
        
        $sql = $pdo->RetornarConsulta("SELECT * FROM usuario WHERE usuario=:usuario");
        $sql->bindValue(':usuario',$arrayDeParametros['usuario'], PDO::PARAM_STR);
        
        $sql->execute();

        $usuario = $sql->fetchAll(PDO::FETCH_CLASS, 'login');

         /*registro el ingreso al sistema*/
         $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
         $consulta =$objetoAccesoDato->RetornarConsulta("UPDATE usuario set ult_fecha_log=CURRENT_TIMESTAMP where usuario=:usuario");
         $consulta->bindValue(':usuario',$arrayDeParametros['usuario'], PDO::PARAM_STR);
         $consulta->execute();

        if($usuario!=NULL){
            if($usuario[0]->clave == $arrayDeParametros['clave']){
                if($usuario[0]->estado ==1 || $usuario[0]->estado =="activo"){
                    $resultado = $usuario;
                   
                }
                else{
                    $resultado="El usuario no esta activo";
                }                
            }
            else{
                $resultado="Clave no valida";
            }
        }
        else{
            $resultado = "Usuario no valido";
        }      

        return $resultado;
    }
}



?>