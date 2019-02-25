<?php
use \Firebase\JWT\JWT;
require_once "./datos/AccesoDatos.php";


class plato{
    public $id;
    public $detalle;
    public $sector;
    public $precio;
    
    //OPERACIONES:
    //-crearPlato($arrayDeParametros)
    //-traerTodos()
    //-traerPorId($id)
    //-traerTodosPorSector()
    //-traerUnoPorDetalle

    public static function crearPlato($arrayDeParametros){ //OK
        $pdo = AccesoDatos::dameUnObjetoAcceso();
        try{
            $sql =$pdo->RetornarConsulta("INSERT into plato (detalle, sector, precio)values(:detalle,:sector,:precio)");

            $sql->bindValue(':detalle', $arrayDeParametros['detalle'], PDO::PARAM_STR);
            $sql->bindValue(':sector', $arrayDeParametros['sector'], PDO::PARAM_STR);
            $sql->bindValue(':precio', $arrayDeParametros['precio'], PDO::PARAM_STR);
            $sql->execute();
            return $pdo->RetornarUltimoIdInsertado();
        }
        catch(Exception $e){
            return $e->getMessage();
        }
    }


    public static function traerTodos(){ //OK
        $pdo = AccesoDatos::dameUnObjetoAcceso();
        $sql = $pdo->RetornarConsulta("select * from plato");
        $sql->execute();

        $resultado = $sql->fetchall(PDO::FETCH_CLASS, "plato");   

        return $resultado;
    }



    public static function traerPorId($id){

        $pdo = AccesoDatos::dameUnObjetoAcceso();
        $sql = $pdo->RetornarConsulta("SELECT * FROM plato WHERE id=:id");
        $sql->bindValue(':id',$id, PDO::PARAM_STR);
        $sql->execute();

        $resultado = $sql->fetchall(PDO::FETCH_CLASS, "plato");
        
        return $resultado;

    }

    public static function traerTodosPorSector(){

        $pdo = AccesoDatos::dameUnObjetoAcceso();
        $sql = $pdo->RetornarConsulta("SELECT distinct 'sector', 'id' FROM 'plato'");
        $sql->execute();

        $resultado = $sql->fetchall(PDO::FETCH_CLASS, "plato");
        
        return $resultado;
    }

    public static function traerUnoPorDetalle($detalle){
      
        $pdo = AccesoDatos::dameUnObjetoAcceso();
        $sql = $pdo->RetornarConsulta("SELECT * FROM plato WHERE detalle=:detalle");
        $sql->bindValue(':detalle',$detalle, PDO::PARAM_STR);
        $sql->execute();

        $resultado = $sql->fetchall(PDO::FETCH_CLASS, "plato");
        
        return $resultado;

    }   

}
?>