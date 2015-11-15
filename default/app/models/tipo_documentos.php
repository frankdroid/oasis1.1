<?php
class TipoDocumentos extends ActiveRecord {
    
        //asociaciones        
        protected function initialize(){
            $this->validates_uniqueness_of("tipo_doc");
            $this->validates_length_of("tipo_doc", "minumum: 2", "too_short: El nombre debe tener al menos 15 caracteres");
             
        }
        
        //ANTES DE insertar si ya existe el tipo de documento
        public $before_insert = "aux_before_create";

        public function aux_before_create(){
            if($this->exists("tipo_doc=".$this->tipo_doc)){
                  Flash::error('Este Tipo de Documento ya existe.');
                  return 'cancel';
            }
        }
        
        //esta funcion verifica si el registro existe
        public function isExist($tipo_doc){
            
            if($this->exists("tipo_doc = '$tipo_doc'"))
                return true;
            else
                return false;
        }
        
        
        public function getAll()
	{
            return $this->find('order: tipo_doc asc');
	}
        
        public function getSelect(){
            return $this->find("columns: idtipodoc,tipo_doc", "order: tipo_doc" );
        }
        

        /*
        public function findByTipoDocumento($tipo_doc){
            
           if(isset($tipo_doc) && ($tipo_doc != null)){
              $sqlQuery = "select t.* from tipo_documentos t where t.tipo_doc = '$tipo_doc'"; 
              return $this->find_by_sql($sqlQuery);
              
           }else{
               return 0;
           }  
        }*/
	
	
	
	public function Crear($tipo_doc,$descripcion,$identificador,$comentario,$creado_por) 
	{
		return $this->create("tipo_doc: $tipo_doc",
										"descripcion: $descripcion",
										"identificador: $identificador",
										"comentario: $comentario",
										"creado_por: $creado_por");
	}
		
}
?>