<?php
class Facturasc extends ActiveRecord{
	
	public function Todos(){
	
			return $this->paginate();
	
	}
		
	public function Ultimo(){
		return $this->find_by_sql("SELECT MAX(idfacturac) AS id FROM facturasc");	
	}
	
	public function Buscar($idfacturac) {
		return $this->find_by_sql("SELECT * 
								   FROM facturasc as f, clientes as c
								   WHERE idfacturac = $idfacturac AND f.idcliente = c.idcliente");
	}
}
?>
