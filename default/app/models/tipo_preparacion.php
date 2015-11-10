<?php
class TipoPreparacion extends ActiveRecord {
	
	protected function initialize(){
            $this->validates_uniqueness_of("tipo_prep", 'message: El tipo de preparacion ya existe');
            //$this->validates_length_of("tipo_prep", "minumum: 2", "too_short: El nombre debe tener al menos 15 caracteres");
        }
        
        public function getAll()
	{
            return $this->find('order: tipo_prep asc');
	}
        
        public function getSelect(){
            return $this->find("columns: idtipoprep,tipo_prep", "order: tipo_prep" );
        }
}
?>