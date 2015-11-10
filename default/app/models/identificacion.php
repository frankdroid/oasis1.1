<?php
class Identificacion extends ActiveRecord {
	
	public function Todos() 
	{
		return $this->find();	
	}
	
	
	
	public function Crear($tipo_doc,$descripcion,$prefijo,$comentario,$creado_por) 
	{
		return $this->create("tipo_doc: $tipo_doc",
										"descripcion: $descripcion",
										"prefijo: $prefijo",
										"comentario: $comentario",
										"creado_por: $creado_por");
	}
		
}
?>