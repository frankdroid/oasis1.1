<?php
class TipoPuntoVenta extends ActiveRecord {
    
        //asociaciones        
        protected function initialize(){
            $this->validates_uniqueness_of("tipo_punto_venta");
            //$this->validates_length_of("tipo_punto_venta", "minumum: 2", "too_short: El nombre debe tener al menos 15 caracteres");
             
        }
        
        //ANTES DE insertar si ya existe el tipo de documento
        public $before_insert = "aux_before_create";

        public function aux_before_create(){
            if($this->exists("tipo_punto_venta=".$this->tipo_punto_venta)){
                  Flash::error('Este Tipo de Documento ya existe.');
                  return 'cancel';
            }
        }
        
        //esta funcion verifica si el registro existe
        public function isExist($tipo_punto_venta){
            
            if($this->exists("tipo_punto_venta = '$tipo_punto_venta'"))
                return true;
            else
                return false;
        }
        
        
        public function getAll()
	{
            return $this->find('order: tipo_punto_venta asc');
	}
        
        public function getSelect(){
            return $this->find("columns: idtipopuntoventa,tipo_punto_venta", "order: tipo_punto_venta" );
        }
        	
}
?>