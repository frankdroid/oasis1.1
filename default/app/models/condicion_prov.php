<?php
class CondicionProv extends ActiveRecord {
	
	protected function initialize(){
            $this->validates_uniqueness_of("condicion", 'message: Este registro ya existe');
            //$this->validates_length_of("condicion", "minumum: 2", "too_short: El nombre debe tener al menos 15 caracteres");
        }
        
        
        public function getAll()
	{
            return $this->find('order: condicion asc');
	}
        
        public function getSelect(){
            return $this->find("columns: idcondicion,condicion", "order: condicion" );
        }
}
?>