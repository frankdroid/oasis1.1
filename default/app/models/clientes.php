<?php
class Clientes extends ActiveRecord{
	
    
    protected function initialize(){
        //asociaciones
        $this->belongs_to('tipo_documentos');
        $this->belongs_to('tipo_clientes');
        
        //validaciones
        //$this->validates_uniqueness_of("identificacion", 'message: El cliente ya existe');
        $this->validates_presence_of("identificacion");
        $this->validates_presence_of("idtipodoc");
        $this->validates_presence_of("idtipocliente");
        $this->validates_presence_of("nombre");
        
        if(!$this->isRif($this->idtipodoc))
          $this->validates_presence_of("apelllido");
        
        $this->validates_presence_of("direccion");
        $this->validates_presence_of("telefono");
        $this->validates_email_in("correo");
        //$this->validates_format_of("correo", "^(+)@((?:[?a?z0?9]+\.)+[a?z]{2,})$");
        //$this->validates_length_of("tipo_cliente", "minumum: 2", "too_short: El nombre debe tener al menos 15 caracteres");
        
    }
    
    public function isRif($idtipodoc = null){
        $existe = false;
        if($idtipodoc != null){
            $tipo_doc = new TipoDocumentos();
            //$sqlQuery = "Select tipo_doc from tipo_documentos where id";
            $rs = $tipo_doc->find((int)$idtipodoc);
            if(strtoupper($rs->tipo_doc)  == 'RIF'){
               $existe = true; 
            }
        }
        return $existe;
    }

    public function todos()
    {

            return $this->find();

    }
	
	
	
	public function Buscar($cedula) 
	{	
		return $this->find_by_identificacion($cedula);
	}
	
}
?>