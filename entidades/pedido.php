<?php
use \Firebase\JWT\JWT;
require_once "./datos/AccesoDatos.php";
require_once './entidades/autentificadorJWT.php';

// OPERACIONES
//-crearPedido($arrayDeParametros, $usuario)
//-traerTodos()
//-traerCancelados()
//-traerPorUsuario($usuario)
//-traerPorCodigo($codigo)
//-actualizarPrecioFinal($arrayDeParametros)
//-actualizarPedidoServido($arrayDeParametros) 
//-actualizarPedidoAPagar($arrayDeParametros)
//-actualizarPedidoCerrado($arrayDeParametros)
//-traerMasVendido()
//-traerMenosVendido()

class pedido{

    public $codigo;
    public $usuario;    
    public $estado;
    public $mesa;
    public $precioFinal;    
    public $fechaInicio;
    public $tiempo;
    public $fechaTerminado;
    public $cliente;
    public $imagen;           
    

    public static function crearPedido($arrayDeParametros){
        $pdo = AccesoDatos::dameUnObjetoAcceso();
        try{
            $sql =$pdo->RetornarConsulta("INSERT into pedido (usuario, codigo, mesa, cliente)values(:usuario,:codigo,:mesa,:cliente)");
            
            $codigo = autentificadorJWT::generateRandomString(5);
            
            $sql->bindValue(':codigo', $codigo, PDO::PARAM_STR);
            $sql->bindValue(':usuario', $arrayDeParametros['usuario'], PDO::PARAM_STR);            
            $sql->bindValue(':mesa', $arrayDeParametros['mesa'], PDO::PARAM_INT);
            $sql->bindValue(':cliente', $arrayDeParametros['cliente'], PDO::PARAM_STR);

            $sql->execute();
            return self::traerPorCodigo($codigo);
        }
        catch(Exception $e){
            return $e->getMessage();
        }
    }


   public   function registrarFoto($nombreArchivo, $codigo){
        $pdo = AccesoDatos::dameUnObjetoAcceso();
        try{
            var_dump($nombreArchivo);
            var_dump($codigo);
            $sql =$pdo->RetornarConsulta("UPDATE pedido set imagen='$nombreArchivo'
                                          where codigo='$codigo'");          
            
            $sql->bindValue(':codigo', $codigo, PDO::PARAM_STR);
            var_dump($sql);
            $sql->execute();
            return self::traerPorCodigo($codigo);
        }
        catch(Exception $e){
            return $e->getMessage();
        }
    }


    public static function traerTodos(){
        $pdo = AccesoDatos::dameUnObjetoAcceso();
        $sql = $pdo->RetornarConsulta("select * from  pedido");
        $sql->execute();

        $resultado = $sql->fetchall(PDO::FETCH_CLASS, "pedido");   

        return $resultado;

    }  


    public static function taerPorUsuario($usuario){
        $pdo = AccesoDatos::dameUnObjetoAcceso();
        $sql = $pdo->RetornarConsulta("SELECT * FROM  pedido WHERE usuario=:usuario");
        $sql->bindValue(':usuario',$usuario, PDO::PARAM_STR);
        $sql->execute();

        $resultado = $sql->fetchall(PDO::FETCH_CLASS, "pedido");
        
        return $resultado;

    }


    public static function traerPorCodigo($codigo){

        $pdo = AccesoDatos::dameUnObjetoAcceso();
        $sql = $pdo->RetornarConsulta("SELECT * FROM  pedido WHERE codigo=:codigo");
        $sql->bindValue(':codigo',$codigo, PDO::PARAM_STR);
        $sql->execute();

        $resultado = $sql->fetchall(PDO::FETCH_CLASS, "pedido");
        
        return $resultado;

    }


/*
    public static function traerTodosProductos(){

        $pdo = AccesoDatos::dameUnObjetoAcceso();
        $sql = $pdo->RetornarConsulta("select distinct `estado`, `codigo` FROM ` pedido`");
        $sql->execute();

        $resultado = $sql->fetchall(PDO::FETCH_CLASS, "pedido");
        
        return $resultado;
    }

*/

    public function actualizarPrecioFinalPedido($arrayDeParametros)
    {

        $precioFinal = pedido_producto::sumarPrecioPorCodigo($arrayDeParametros['codigo']);

        $pdo = AccesoDatos::dameUnObjetoAcceso();
        try{
            $sql =$pdo->RetornarConsulta("UPDATE  pedido AS pe
            INNER JOIN pedido_producto AS pprod ON pprod.codigo = pe.codigo
            SET pe.estado= 3,
                pprod.estado=3,
                pe.precioFinal = :precioFinal
            WHERE pe.codigo=:codigo 
            AND pprod.estado='listo para servir' OR pprod.estado='servido'");
            
            $sql->bindValue(':codigo', $arrayDeParametros['codigo'], PDO::PARAM_STR);
            $sql->bindValue(':precioFinal', $precioFinal, PDO::PARAM_INT);

            $sql->execute();
            return $sql->rowCount();
        }
        catch(Exception $e){
            return $e->getMessage();
        }
        
    }



    public function actualizarPedidoServido($arrayDeParametros) {
        $pdo = AccesoDatos::dameUnObjetoAcceso();
        try{
            $sql =$pdo->RetornarConsulta("UPDATE  pedido AS p
            INNER JOIN pedido_producto AS pp ON pp.codigo = p.codigo
            INNER JOIN mesa AS me ON me.id = p.mesa
            SET p.estado= 4,
                me.estado=3,
                pp.estado=4
            WHERE p.codigo=:codigo AND p.estado ='listo para servir' ");
            
            $sql->bindValue(':codigo', $arrayDeParametros['codigo'], PDO::PARAM_STR);
            $sql->execute();
            return $sql->rowCount();
        }
        catch(Exception $e){
            return $e->getMessage();
        }        
    }



    public function actualizarPedidoAPagar($arrayDeParametros){
        $pdo = AccesoDatos::dameUnObjetoAcceso();
        try{
            $sql =$pdo->RetornarConsulta("UPDATE  pedido AS p
            INNER JOIN mesa AS me ON me.id = p.mesa
            SET me.estado=4      
            WHERE p.codigo=:codigo AND me.estado = 3 AND p.estado=4");
            
            $sql->bindValue(':codigo', $arrayDeParametros['codigo'], PDO::PARAM_STR);
            $sql->execute();
            return $sql->rowCount();
        }
        catch(Exception $e){
            return $e->getMessage();
        }        
    }



    public function actualizarPedidoCerrado($arrayDeParametros){
        $pdo = AccesoDatos::dameUnObjetoAcceso();
        try{
            $sql =$pdo->RetornarConsulta("UPDATE  pedido AS p
            INNER JOIN mesa AS me ON me.id = p.mesa
            SET me.estado=1,                
                p.estado = 5
            WHERE p.codigo=:codigo AND me.estado = 4 AND p.estado='pagado'");
            
            $sql->bindValue(':codigo', $arrayDeParametros['codigo'], PDO::PARAM_STR);
            $sql->execute();
            return $sql->rowCount();
        }
        catch(Exception $e){
            return $e->getMessage();
        }        
    }


    public static function traerCancelados(){
        $pdo = AccesoDatos::dameUnObjetoAcceso();
        $sql = $pdo->RetornarConsulta("SELECT * from  pedido where estado='cancelado'");
          $sql->bindValue(':cancelado',$cancelado, PDO::PARAM_STR);
        $sql->execute();

        $resultado = $sql->fetchall(PDO::FETCH_CLASS, "pedido");   

        return $resultado;

    }

    public static function traerMasVendido(){
        $pdo = AccesoDatos::dameUnObjetoAcceso();
        $sql = $pdo->RetornarConsulta("SELECT COUNT(idPlato) as vecesVendido, pedido_producto.* FROM pedido_producto 
                                       GROUP BY idPlato order by vecesVendido DESC limit 1;");
       
        $sql->execute();
        $resultado = $sql->fetchall(PDO::FETCH_CLASS, "pedido");   

        return $resultado;
    }


    public static function traerMenosVendido(){
        $pdo = AccesoDatos::dameUnObjetoAcceso();
        $sql = $pdo->RetornarConsulta("SELECT COUNT(idPlato) as vecesVendido , pedido_producto.* FROM pedido_producto
                                       GROUP BY idPlato order by vecesVendido ASC limit 1;");
       
        $sql->execute();
        $resultado = $sql->fetchall(PDO::FETCH_CLASS, "pedido");   

        return $resultado;
    }
/*
    public static function traerFueraDeTiempo()){
        $pdo = AccesoDatos::dameUnObjetoAcceso();
       
       
        $sql->execute();
        $resultado = $sql->fetchall(PDO::FETCH_CLASS, "pedido");   

        return $resultado;
    }
*/


}
?>