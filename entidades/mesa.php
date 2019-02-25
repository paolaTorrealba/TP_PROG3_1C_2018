<?php
use \Firebase\JWT\JWT;
require_once "./datos/AccesoDatos.php";

// OPERACIONES 
//-traerTodos()
//-traerPorid($id)
//-traerPorEstado($estado)
  
  
class mesa{
    public $id;
    public $estado; 


    public static function traerTodos(){
        $pdo = AccesoDatos::dameUnObjetoAcceso();
        $sql = $pdo->RetornarConsulta("SELECT * from  mesa");
        $sql->execute();

        $resultado = $sql->fetchall(PDO::FETCH_CLASS, "mesa");   

        return $resultado;
    }

    public static function traerPorid($id){

        $pdo = AccesoDatos::dameUnObjetoAcceso();
        $sql = $pdo->RetornarConsulta("SELECT * FROM  mesa WHERE id=:id");
        $sql->bindValue(':id',$id, PDO::PARAM_INT);
        $sql->execute();

        $resultado = $sql->fetchall(PDO::FETCH_CLASS, "mesa");
        
        return $resultado;
    }

    public static function traerPorEstado($estado){

        $pdo = AccesoDatos::dameUnObjetoAcceso();
        $sql = $pdo->RetornarConsulta("SELECT * FROM  mesa WHERE estado=:estado");
        $sql->bindValue(':estado',$estado, PDO::PARAM_STR);
        $sql->execute();

        $resultado = $sql->fetchall(PDO::FETCH_CLASS, "mesa");
        
        return $resultado;
    }



    public function traerFacturoMenos($arrayDeParametros){
         $pdo = AccesoDatos::dameUnObjetoAcceso();
        $sql = $pdo->RetornarConsulta("SELECT mesa, SUM(precioFinal) cant FROM pedido  GROUP BY mesa 
                                       ORDER BY cant ASC limit 1;");
      
        $sql->execute();
        $resultado = $sql->fetchall(PDO::FETCH_CLASS, "mesa");
        
        return $resultado;
    }


    public function traerFacturoMas($arrayDeParametros){
        $pdo = AccesoDatos::dameUnObjetoAcceso();
        $sql = $pdo->RetornarConsulta("SELECT mesa,SUM(precioFinal) cant FROM pedido  GROUP BY mesa 
                                       ORDER BY cant DESC limit 1;");
       
        $sql->execute();
        $resultado = $sql->fetchall(PDO::FETCH_CLASS, "mesa");
        
        return $resultado;
    }


    public function traerMasUsada($arrayDeParametros){
        $pdo = AccesoDatos::dameUnObjetoAcceso();
        $sql = $pdo->RetornarConsulta("SELECT mesa, COUNT(mesa) as vecesUsada FROM pedido 
                                       GROUP BY mesa order by vecesUsada DESC limit 1; ");
      
        $sql->execute();
        $resultado = $sql->fetchall(PDO::FETCH_CLASS, "mesa");
        
        return $resultado;
    }


    public function traerMenosUsada($arrayDeParametros){
        $pdo = AccesoDatos::dameUnObjetoAcceso();
        $sql = $pdo->RetornarConsulta("SELECT mesa, COUNT(mesa) as vecesUsada FROM pedido GROUP BY mesa 
                                       order by vecesUsada ASC  limit 1; ");
        $sql->execute();
        $resultado = $sql->fetchall(PDO::FETCH_CLASS, "mesa");
        
        return $resultado;
    }


    public function traerMayorImporte($arrayDeParametros){
       $pdo = AccesoDatos::dameUnObjetoAcceso();
       $sql = $pdo->RetornarConsulta("SELECT p.mesa, p.precioFinal FROM pedido p WHERE 
                                       p.precioFinal = ( SELECT MAX(precioFinal) as precioTotal FROM pedido);");
       $sql->execute();
       $resultado = $sql->fetchall(PDO::FETCH_CLASS, "mesa");
        
        return $resultado;
    }
 
 
    public function traerMenorImporte($arrayDeParametros){
        $pdo = AccesoDatos::dameUnObjetoAcceso();
        $sql = $pdo->RetornarConsulta("SELECT p.mesa, p.precioFinal FROM pedido p WHERE 
                                       p.precioFinal = ( SELECT MIN(precioFinal) as precioTotal FROM pedido);"); 

        $sql->execute();
        $resultado = $sql->fetchall(PDO::FETCH_CLASS, "mesa");
        
        return $resultado;
    }




}
?>