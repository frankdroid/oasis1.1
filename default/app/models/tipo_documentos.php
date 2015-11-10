<?php
class TipoDocumentos extends ActiveRecord {
    
        //asociaciones        
        protected function initialize(){
            $this->validates_uniqueness_of("tipop_doc");
            $this->validates_length_of("tipop_doc", "minumum: 2", "too_short: El nombre debe tener al menos 15 caracteres");
             
            
            //$this->validates_presence_of("cedula");
            
            /*
            $this->validates_length_of("tipop_doc", "minumum: 1", "too_short: El nombre debe tener al menos 15 caracteres");
            $this->validates_length_of("nombre", "maximum: 40", "too_long: El nombre debe tener maximo 40 caracteres");
            $this->validates_length_of("nombre", "in: 15:40", 
                "too_short: El nombre debe tener al menos 15 caracteres",
                "too_long: El nombre debe tener maximo 40 caracteres"
            );
             $this->validates_numericality_of("precio");
             $this->validates_email_in("correo");
             $this->validates_uniqueness_of("cedula");
             $this->validates_date_in("fecha_registro");
             $this->validates_format_of("email", "^(+)@((?:[?a?z0?9]+\.)+[a?z]{2,})$");
             $this->validates_format_of("email", "^(+)@((?:[?a?z0?9]+\.)+[a?z]{2,})$"); 
             * * 
             * 
             */
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
        
            
	
        public function getAll1($page, $ppage=1)
	{
		return $this->paginate("page: $page", "per_page: $ppage", 'order: tipo_doc asc');
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