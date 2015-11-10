<?php
class FacturaProd extends ActiveRecord{
	
    
    protected function initialize(){
        //asociaciones
        $this->belongs_to('facturas');
        $this->belongs_to('productos');
        
        //validaciones$this->validates_presence_of("no_factura");
        $this->validates_presence_of("idfactura");
        $this->validates_presence_of("idproducto");
        $this->validates_presence_of("no_factura");
        //$this->validates_presence_of("caducidad");
        $this->validates_presence_of("cant");
        $this->validates_presence_of("precio_unidad");
        $this->validates_numericality_of("precio_unidad");
        $this->validates_numericality_of("cant");
        $this->validates_date_in("caducidad");
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