<?php
class CondicionPago extends ActiveRecord {
	
	protected function initialize(){
            $this->validates_uniqueness_of("cond_pago", 'message: Esta cond_pago ya existe');
            //$this->validates_length_of("cond_pago", "minumum: 2", "too_short: El nombre debe tener al menos 15 caracteres");
        }
        
        
        public function getAll()
	{
            return $this->find('order: cond_pago asc');
	}
        
        public function getSelect(){
            return $this->find("columns: idcond_pago,cond_pago", "order: cond_pago" );
        }
}
?>