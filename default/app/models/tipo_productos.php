<?php
class TipoProductos extends ActiveRecord {
	
	protected function initialize(){
            $this->validates_uniqueness_of("tipo_prod", 'message: Esta tipo_prod ya existe');
            //$this->validates_length_of("tipo_prod", "minumum: 2", "too_short: El nombre debe tener al menos 15 caracteres");
        }
        
        
        public function getAll()
	{
            return $this->find('order: tipo_prod asc');
	}
        
        public function getSelect(){
            return $this->find("columns: idtipoprod,tipo_prod", "order: tipo_prod" );
        }
}
?>