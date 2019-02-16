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

    public static function consultaLogin($arrayDeParametros){     
    echo "consultaLogin";   
        $pdo = AccesoDatos::dameUnObjetoAcceso();
        
        $sql = $pdo->RetornarConsulta("SELECT * FROM usuarios WHERE usuario=:usuario");
        $sql->bindValue(':usuario',$arrayDeParametros['usuario'], PDO::PARAM_STR);
        
        $sql->execute();

        $usuario = $sql->fetchAll(PDO::FETCH_CLASS, 'login');

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