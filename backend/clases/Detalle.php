<?php
include_once "AccesoDatos.php";
class Detalle
{
	public $id;
	public $id_plato;
  	public $id_comanda;
	public $cantidad;


	//METODOS GETTERS
	public function GetId()
	 {
	     return $this->id;
	 }
	 public function SetId($id)
	 {
	     $this->id = $id;
	 }

	 public function GetIdPlato()
	 {
	     return $this->id_plato;
	 }
	 public function SetIdPlato($id_plato)
	 {
	     $this->id_plato = $id_plato;
	 }

	  public function GetIdComanda()
	 {
	     return $this->id_comanda;
	 }
	 public function SetIdComanda($id_comanda)
	 {
	     $this->id_comanda = $id_comanda;
	 }

	  public function GetCantidad()
	 {
	     return $this->cantidad;
	 }
	 public function SetCantidad($cantidad)
	 {
	     $this->cantidad = $cantidad;
	 }


     public function InsertarDetalle()
	 {
		
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta =$objetoAccesoDato->RetornarConsulta("INSERT into detalle (id_plato, id_comanda, cantidad) VALUES(:id_plato, :id_comanda, :cantidad)");

		$consulta->bindValue(':id_plato',$this->id_plato, PDO::PARAM_STR);
		$consulta->bindValue(':id_comanda', $this->id_comanda, PDO::PARAM_STR);
		$consulta->bindValue(':cantidad', $this->cantidad, PDO::PARAM_STR);
	
		
		 $consulta->execute();

		 return $objetoAccesoDato->RetornarUltimoIdInsertado();			

	 }

	 public function ModificarDetalle()
	 {

			$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			$consulta =$objetoAccesoDato->RetornarConsulta("
				update detalle 
				set id_plato='$this->id_plato',
				id_comanda='$this->id_comanda',
				cantidad='$this->cantidad'
				WHERE id='$this->id'");
				
			return $consulta->execute();

	 }


  	public function BorrarDetalle()
	 {
	 		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			$consulta =$objetoAccesoDato->RetornarConsulta("
				delete 
				from detalle 				
				WHERE id=:id");	
				$consulta->bindValue(':id',$this->id, PDO::PARAM_INT);		
				$consulta->execute();
				return $consulta->rowCount();
	 }


	  public function ModificarDetalleParametros()
	 {
			$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			$consulta =$objetoAccesoDato->RetornarConsulta("
				update detalle 
				set id_plato=:id_plato,
				id_comanda=:id_comanda,
				cantidad=:cantidad			
				WHERE id=:id");
			$consulta->bindValue(':id',$this->id, PDO::PARAM_INT);
			$consulta->bindValue(':id_plato',$this->id_plato, PDO::PARAM_STR);
			$consulta->bindValue(':id_comanda', $this->id_comanda, PDO::PARAM_STR);
			$consulta->bindValue(':cantidad', $this->cantidad, PDO::PARAM_STR);
		
			return $consulta->execute();
	 }


	 public function GuardarDetalle()
	 {

	 	if($this->id>0)
	 		{
	 			$this->ModificarDetalle();
	 		}else {
	 			$this->InsertarDetalle();
	 		}

	 }


  	public static function TraerTodoLosDetalle()
	{
			$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			$consulta =$objetoAccesoDato->RetornarConsulta("SELECT * FROM detalle");
			$consulta->execute();			
			return $consulta->fetchAll(PDO::FETCH_CLASS, "Detalle");		
	}


	public static function TraerUnDetalle($id) 
	{   
			$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			$consulta =$objetoAccesoDato->RetornarConsulta("select * from detalle where id = $id");
			$consulta->execute();
			$detalleBuscado= $consulta->fetchObject('Detalle');
			return $detalleBuscado;				

			
	}

     public function ToString()
    {
             return "id: ".$this->id." - id_plato: ".$this->id_plato." - id_comanda: ".$this->id_comanda." - cantidad: ".$this->cantidad."<br>";
    }


}