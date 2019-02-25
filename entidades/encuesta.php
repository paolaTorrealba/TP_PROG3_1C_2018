<?php
use \Firebase\JWT\JWT;
require_once "./datos/AccesoDatos.php";
require_once './entidades/autentificadorJWT.php';

// ----OPERACIONES---
//-crearEncuesta($arrayDeParametros, $usuario)
//-traerTodos

class encuesta{
    //public $id_comanda;
    public $descripcion;    
    public $puntosMesa;
    public $puntosMozo;
    public $puntosCocinero;
    public $puntosResto;         
    
     //Las encuestas las crea el cusuario liente
    public static function crearEncuesta($arrayDeParametros){
        $pdo = AccesoDatos::dameUnObjetoAcceso();
        try{
            $sql =$pdo->RetornarConsulta("INSERT into encuesta (descripcion, puntosMesa, puntosMozo, puntosResto, puntosCocinero) VALUES (:descripcion, :puntosMesa, :puntosMozo, :puntosResto, :puntosCocinero)");
            
            $codigo = autentificadorJWT::generateRandomString(5);
            
           // $sql->bindValue(':id_comanda', $codigo, PDO::PARAM_INT);
            $sql->bindValue(':descripcion', $arrayDeParametros['descripcion'], PDO::PARAM_STR);            
            $sql->bindValue(':puntosMesa', $arrayDeParametros['puntosMesa'], PDO::PARAM_INT);
            $sql->bindValue(':puntosCocinero', $arrayDeParametros['puntosCocinero'], PDO::PARAM_INT);
            $sql->bindValue(':puntosMozo', $arrayDeParametros['puntosMozo'], PDO::PARAM_INT);
            $sql->bindValue(':puntosResto', $arrayDeParametros['puntosResto'], PDO::PARAM_INT);          

            $sql->execute();
           return "Datos enviados correctamente";
        }
        catch(Exception $e){
            return $e->getMessage();
        }
    }



    public static function traerTodos(){
        $pdo = AccesoDatos::dameUnObjetoAcceso();
        $sql = $pdo->RetornarConsulta("SELECT * from encuesta");
        $sql->execute();

        $resultado = $sql->fetchall(PDO::FETCH_CLASS, "encuesta");   

        return $resultado;

    }

}
?>