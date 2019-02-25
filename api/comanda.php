<?php
require_once ('./datos/AccesoDatos.php');
class comanda
{
	public $id_mesa;
 	public $id_usaurio;
 	public $id_plato;
 	public $id_pedido;
  	public $foto_mesa;
	public $nombre_cliente;
	public $precio_final
	public $tiempo_total;
	public $estado

	public function TomarPedido($arrayDeParametros, $platos){
		$fecha=date("Y-m-d");
		$hora_inicio=date("H:i:s");
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();   

		$consulta =$objetoAccesoDato->RetornarConsulta("SELECT id_usuario FROM comanda.usuario where usuario=:usuario");
        $consulta->bindValue(':usuario', $arrayDeParametros['usuario'], PDO::PARAM_STR);
		$consulta->execute();

		$UsuarioBuscado= $consulta->fetchObject('Comanda');

        $consulta =$objetoAccesoDato->RetornarConsulta("INSERT into comanda.comanda (id_comanda, 
        	 																		 id_mesa,
        	 																		 id_usuario,
        	 																		 foto_mesa, 
        	 																		 nombre_cliente,
        	 																		 hora_inicio,
        	 																		 fecha) 
        	 																		 values (:id_comanda,
        	 																		         :id_mesa,
        	 																		         $UsuarioBuscado->id_usuario, 
        	 																		         :foto_mesa,
        	 																		         :nombre_cliente, 
        	 																		         '$hora_inicio',
        	 																		         '$fecha')");
		$consulta->bindValue(':id_comanda', $arrayDeParametros['id_comanda'], PDO::PARAM_STR);
		$consulta->bindValue(':id_mesa',$arrayDeParametros['id_mesa'], PDO::PARAM_STR);
		$consulta->bindValue(':foto_mesa',$arrayDeParametros['foto_mesa'], PDO::PARAM_STR);
		$consulta->bindValue(':nombre_cliente', $arrayDeParametros['nombre_cliente'], PDO::PARAM_STR);	
		$consulta->bindValue(':hora_inicio', $arrayDeParametros['hora_inicio'], PDO::PARAM_STR);
			
		$consulta->execute();			
		
		for ($i=0; $i <sizeof($platos) ; $i++) { 
			$platosComanda = $objetoAccesoDato->RetornarConsulta("INSERT into comanda.platoxcomanda (id_plato, id_comanda, cantidad) values (:id_plato, :id_comanda, :cantidad);");
			$platosComanda->bindValue(':id_item', $platos[$i]['item'], PDO::PARAM_INT);
			$platosComanda->bindValue(':id_comanda', $arrayDeParametros['id_comanda'], PDO::PARAM_STR);
			$platosComanda->bindValue(':cantidad', $platos[$i]['cantidad'], PDO::PARAM_INT);
			$platosComanda->execute();
		}
		
	}

	public function ConsultarPedido($codigo)
	{
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta =$objetoAccesoDato->RetornarConsulta("SELECT foto_mesa, tiempo_cocina, estado_cocina, tiempo_barra, estado_barra, tiempo_cerveza, estado_cerveza FROM id6145613_final.comandas WHERE id_comanda='$codigo'");
		$consulta->execute();
		$pedidoBuscado= $consulta->fetchObject('Comanda');
		return $pedidoBuscado;

	}

	public function CancelarPedido(){
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta =$objetoAccesoDato->RetornarConsulta("UPDATE id6145613_final.comandas set estado='cancelado' where id_comanda=:id_comanda");
		$consulta->bindValue(':id_comanda',$this->codigoAlfa, PDO::PARAM_STR);
		$consulta->execute();
	}
	
	public function CargarHoraFin($id){
		$hora=date("H:i:s");
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
		$fecha_fin=$objetoAccesoDato->RetornarConsulta("UPDATE id6145613_final.comandas SET hora_fin='$hora', estado='Terminado' WHERE id_mesa=$id");
		$fecha_fin->execute();
	}
}