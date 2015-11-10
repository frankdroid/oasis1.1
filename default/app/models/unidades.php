<?php
class Unidades extends ActiveRecord {
	
	protected function initialize(){
            $this->validates_uniqueness_of("unidad", 'message: Esta unidad ya existe');
            //$this->validates_length_of("unidad", "minumum: 2", "too_short: El nombre debe tener al menos 15 caracteres");
        }
        
        
        public function getAll()
	{
            return $this->find('order: unidad asc');
	}
        
        public function getSelect($idunidad=null){
            
            if(($idunidad != null) || ($idunidad != ''))
                return $this->find("$idunidad");
            else
                return $this->find("columns: idunidad,unidad", "order: unidad" );
        }
        
}
?>