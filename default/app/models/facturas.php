<?php
class Facturas extends ActiveRecord{
	
    
    protected function initialize(){
        //asociaciones
        $this->belongs_to('proveedores');
        $this->belongs_to('condicion_pago');
        
        //validaciones$this->validates_presence_of("no_factura");
        $this->validates_presence_of("fe_emision");
        $this->validates_presence_of("fe_vencimiento");
        $this->validates_presence_of("idprov");
        
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