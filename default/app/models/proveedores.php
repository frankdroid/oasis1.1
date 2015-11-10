<?php
class Proveedores extends ActiveRecord{
	
    
    protected function initialize(){
        //asociaciones
        $this->belongs_to('tipo_documentos');
        $this->belongs_to('condicion_prov');
        
        //validaciones
        $this->validates_uniqueness_of("identificacion", 'message: El Proveedor ya existe');
        $this->validates_presence_of("identificacion");
        $this->validates_presence_of("idtipodoc");
        $this->validates_presence_of("idcondicion");
        $this->validates_presence_of("nombre");
        
        if(!$this->isRif($this->idtipodoc))
          $this->validates_presence_of("apellido");
        
        $this->validates_presence_of("direccion");
        $this->validates_presence_of("telefono");
        $this->validates_email_in("correo1");
        $this->validates_email_in("correo2");
        
        //$this->validates_format_of('correo1', "^(+)@((?:[?a?z0?9]+\.)+[a?z]{2,})$");
        //$this->validates_format_of("correo2", "^(+)@((?:[?a?z0?9]+\.)+[a?z]{2,})$");
        //$this->validates_length_of("tipo_cliente", "minumum: 2", "too_short: El nombre debe tener al menos 15 caracteres");        
    }
    
    public function getProveedor($idtipodoc, $identificacion){
             
        $query = "Select * from proveedores where idtipodoc=".$idtipodoc." and identificacion="."'".$identificacion."'";
            
        return $this->find_by_sql($query); 
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
	
    public function getSelect(){
        return $this->find("columns: idprov,nombre", "order: nombre" );
    }
	
    public function Buscar($cedula) 
    {	
            return $this->find_by_identificacion($cedula);
    }
	
}
?>