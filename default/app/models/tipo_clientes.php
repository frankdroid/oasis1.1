<?php
class TipoClientes extends ActiveRecord {
	
	protected function initialize(){
            $this->validates_uniqueness_of("tipo_cliente", 'message: Este tipo de cliente ya existe');
            //$this->validates_length_of("tipo_cliente", "minumum: 2", "too_short: El nombre debe tener al menos 15 caracteres");
        }
        
        
        public function getAll()
	{
            return $this->find('order: tipo_cliente asc');
	}
        
        public function getSelect(){
            return $this->find("columns: idtipocliente,tipo_cliente", "order: tipo_cliente" );
        }
}
?>