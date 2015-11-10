<?php
class Marcas extends ActiveRecord {
	
	protected function initialize(){
            $this->validates_uniqueness_of("marca", 'message: Esta marca ya existe');
            //$this->validates_length_of("marca", "minumum: 2", "too_short: El nombre debe tener al menos 15 caracteres");
        }
        
        
        public function getAll()
	{
            return $this->find('order: marca asc');
	}
        
        public function getSelect(){
            return $this->find("columns: idmarca,marca", "order: marca" );
        }
}
?>