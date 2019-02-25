<?php
use \Firebase\JWT\JWT;
require_once "./datos/AccesoDatos.php";
require_once './entidades/autentificadorJWT.php';


// OPERACIONES
//-agregarProducto($json, $codigo)
//-actualizarProductoEnPreparacion($arrayDeParametros, $usuario)
//-actualizarProductoListoParaServir($arrayDeParametros)
//-actualizarProductoServido($arrayDeParametros)
//-traertodos()
//-traerPorCodigo($codigo)
//-traerPlatosPorPerfil($perfil, $idUsuario)
//-traerPorUsuario($usuario)
//-traerListosParaServirPorUsuario($usuario)
//-sumarPrecioPorCodigo($codigo)


class pedido_plato{

    public $codigo;
    public $idPlato; 
    public $estado;
    public $cantidad;
    public $precio;
    public $fechaInicio;
    public $tiempo;
    public $fechaTerminado;


    public function agregarPlato($json, $codigo)
    {
        $pdo = AccesoDatos::dameUnObjetoAcceso();
        try{
            $sql =$pdo->RetornarConsulta("INSERT into pedido_plato (codigo, idPlato, cantidad)values(:codigo,:idPlato,:cantidad)");
            
            $sql->bindValue(':codigo', $codigo, PDO::PARAM_STR);         
            $sql->bindValue(':idPlato', $json->idPlato, PDO::PARAM_INT);
            $sql->bindValue(':cantidad', $json->cantidad, PDO::PARAM_INT);

            $sql->execute();
            return $sql->rowCount();
        }
        catch(Exception $e){
            return $e->getMessage();
        }        
    }


    public function actualizarPlatoEnPreparacion($arrayDeParametros, $usuario)
    {
        $pdo = AccesoDatos::dameUnObjetoAcceso();
        try{
            $sql =$pdo->RetornarConsulta("UPDATE pedido_plato AS pp
            INNER JOIN menu AS m ON pp.idPlato = m.id
            INNER JOIN pedidos AS p ON pp.codigo = p.codigo
            INNER JOIN mesas AS me ON me.id = p.mesa
            SET pp.precio = m.precio*pp.cantidad,
                pp.tiempo = :tiempo,
                pp.fechaTerminado=(pp.fechaInicio + INTERVAL :tiemposuma MINUTE),
                pp.usuario = :usuario,
                me.estado = 2,
                me.limpia = 2,
                pp.estado= 2,
                p.estado= 2,
                p.tiempo = IF(p.tiempo<:tiempoPedido,:tiempoPedido2, p.tiempo),
                p.fechaTerminado = (p.fechaInicio + INTERVAL :tiemposuma2 MINUTE)
            WHERE pp.codigo=:codigo AND pp.idPlato=:idPlato");
            
            $sql->bindValue(':codigo', $arrayDeParametros['codigo'], PDO::PARAM_STR);
            $sql->bindValue(':usuario', $usuario, PDO::PARAM_INT);
            $sql->bindValue(':tiempo', $arrayDeParametros['tiempo'], PDO::PARAM_INT);
            $sql->bindValue(':tiempoPedido', $arrayDeParametros['tiempo'], PDO::PARAM_INT);
            $sql->bindValue(':tiempoPedido2', $arrayDeParametros['tiempo'], PDO::PARAM_INT);
            $sql->bindValue(':tiemposuma', $arrayDeParametros['tiempo'], PDO::PARAM_INT);
            $sql->bindValue(':tiemposuma2', $arrayDeParametros['tiempo'], PDO::PARAM_INT);
            $sql->bindValue(':idPlato', $arrayDeParametros['idPlato'], PDO::PARAM_INT);

            $sql->execute();
            return $sql->rowCount();
        }
        catch(Exception $e){
            return $e->getMessage();
        }
        
    }


    public function actualizarProductoListoParaServir($arrayDeParametros)
    {
        $pdo = AccesoDatos::dameUnObjetoAcceso();
        try{
            $sql =$pdo->RetornarConsulta("UPDATE pedido_plato
            SET  estado= 3
            WHERE codigo=:codigo AND idPlato=:idPlato AND estado=2");
            
            $sql->bindValue(':codigo', $arrayDeParametros['codigo'], PDO::PARAM_STR);
            $sql->bindValue(':idPlato', $arrayDeParametros['idPlato'], PDO::PARAM_INT);

            $sql->execute();
            return $sql->rowCount();
        }
        catch(Exception $e){
            return $e->getMessage();
        }        
    }


    public function actualizarProductoServido($arrayDeParametros)
    {
        $pdo = AccesoDatos::dameUnObjetoAcceso();
        try{
            $sql =$pdo->RetornarConsulta("UPDATE pedido_plato AS pp
            INNER JOIN pedidos AS p ON pp.codigo = p.codigo
            INNER JOIN mesas AS me ON me.id = p.mesa
            SET pp.estado = 4,
                me.estado = 3
            WHERE pp.codigo=:codigo AND pp.idPlato=:idPlato");
            
            $sql->bindValue(':codigo', $arrayDeParametros['codigo'], PDO::PARAM_STR);
            $sql->bindValue(':idPlato', $arrayDeParametros['idPlato'], PDO::PARAM_INT);

            $sql->execute();
            return $sql->rowCount();
        }
        catch(Exception $e){
            return $e->getMessage();
        }
    }


    public static function traerTodos(){
        $pdo = AccesoDatos::dameUnObjetoAcceso();
        $sql = $pdo->RetornarConsulta("select * from pedido_plato");
        $sql->execute();

        $resultado = $sql->fetchall(PDO::FETCH_CLASS, "pedido_plato");   

        return $resultado;
    }    



    public static function traerPorCodigo($codigo){

        $pdo = AccesoDatos::dameUnObjetoAcceso();
        $sql = $pdo->RetornarConsulta("SELECT * FROM pedido_plato WHERE codigo=:codigo");
        $sql->bindValue(':codigo',$codigo, PDO::PARAM_STR);
        $sql->execute();

        $resultado = $sql->fetchall(PDO::FETCH_CLASS, "pedido_plato");
        
        return $resultado;
    }



    public static function traerPlatosPorPerfil($perfil, $idUsuario){
        $pdo = AccesoDatos::dameUnObjetoAcceso();
        $resultado;
        switch ($perfil){
            case "cocinero":
                $sql = $pdo->RetornarConsulta("SELECT pp.codigo, pp.estado, pp.cantidad, pp.idPlato, m.producto FROM pedido_plato AS pp INNER JOIN menu AS m ON pp.idPlato = m.id WHERE pp.estado='pendiente' AND m.sector='cocina' OR m.sector='candy'");
                $sql->execute();
                $resultado = $sql->fetchall(PDO::FETCH_OBJ);
                //echo("Entro en cocinero\n");
                break;
            
            case "bartender":
                $sql = $pdo->RetornarConsulta("SELECT pp.codigo, pp.estado, pp.cantidad, pp.idPlato, m.producto FROM pedido_plato AS pp INNER JOIN menu AS m ON pp.idPlato = m.id WHERE pp.estado='pendiente' AND m.sector='barra'");
                $sql->execute();
                $resultado = $sql->fetchall(PDO::FETCH_OBJ);
                break;

            case "cervecero":
                $sql = $pdo->RetornarConsulta("SELECT pp.codigo, pp.estado, pp.cantidad, pp.idPlato, m.producto FROM pedido_plato AS pp INNER JOIN menu AS m ON pp.idPlato = m.id WHERE pp.estado='pendiente' AND m.sector='cerveza'");
                $sql->execute();
                $resultado = $sql->fetchall(PDO::FETCH_OBJ);
                break;

            case "socio":
                $resultado = self::TraerTodos();
                break;
            
            case "mozo":
                $resultado = self::TraerPorUsuario($idUsuario);
                break;
        }      
        return $resultado;

    }
   


    public static function traerPorUsuario($usuario){
      
        $pdo = AccesoDatos::dameUnObjetoAcceso();
        $sql = $pdo->RetornarConsulta("SELECT pp.codigo, pp.idPlato, pp.cantidad, pp.estado, pp.fechaInicio, p.mesa, p.cliente FROM pedido_plato AS pp INNER JOIN pedido AS p ON pp.codigo = p.codigo WHERE p.usuario=:usuario");
        $sql->bindValue(':usuario',$usuario, PDO::PARAM_STR);
        $sql->execute();

        $resultado = $sql->fetchall(PDO::FETCH_OBJ);
        
        return $resultado;
    }


    public static function traerListosParaServirPorUsuario($usuario){
    
        $pdo = AccesoDatos::dameUnObjetoAcceso();
        $sql = $pdo->RetornarConsulta("SELECT pp.codigo, pp.idPlato, pp.cantidad, pp.fechaTerminado, p.mesa, p.cliente FROM pedido_plato AS pp INNER JOIN pedido AS p ON pp.codigo = p.codigo WHERE pp.estado=3 AND p.usuario=:usuario");
        $sql->bindValue(':usuario',$usuario, PDO::PARAM_STR);
        $sql->execute();

        $resultado = $sql->fetchall(PDO::FETCH_OBJ);
        
        return $resultado;
    }



    public static function sumarPrecioPorCodigo($codigo){

        $pdo = AccesoDatos::dameUnObjetoAcceso();
        $sql = $pdo->RetornarConsulta("SELECT SUM(precio) AS precioFinal FROM pedido_plato WHERE codigo=:codigo");
        $sql->bindValue(':codigo',$codigo, PDO::PARAM_STR);
        $sql->execute();

        $resultado = $sql->fetchall(PDO::FETCH_OBJ);
        
        return $resultado[0]->precioFinal;
    }





    /*

    public static function TraerTodosProductos(){

        $pdo = AccesoDatos::dameUnObjetoAcceso();
        $sql = $pdo->RetornarConsulta("select distinct `estado`, `codigo` FROM `pedidos`");
        $sql->execute();

        $resultado = $sql->fetchall(PDO::FETCH_CLASS, "pedido");
        
        return $resultado;
    }
    */

    
}



?>