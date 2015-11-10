<?php
class ProductoProv extends ActiveRecord{
	
    
    protected function invitialize(){
        //asociaciones
        $this->belongs_to('productos');
        $this->belongs_to('proveedores');
        
        //validaciones
        $this->validates_uniqueness_of("idprov,idproducto", 'message: El producto ya existe');
        $this->validates_presence_of("idprov");
        $this->validates_presence_of("idproducto");
        
    }
    
    public function getAll()
    {
        $columns = 'pp.id, p.idproducto, pv.idprov, pv.identificacion, pv.nombre, pv.apellido';
        $join = 'pp, productos p, proveedores pv';
        $where = 'pp.idproducto = p.idproducto and pp.idprov = pv.idprov';
        
        return $this->find("columns: $columns","$where","join: $join",'order: pp.idprov asc');
    }
    
    public function getProductosProveedor($idprov=null, $identificacion=null)
    {
        //if($idprov != null){
            $query = "
            select
              pp.id,
              p.idproducto,p.idmarca, p.idunidad, p.idtipoprod,p.cant_empaque,
              m.idmarca, m.marca,
              tp.tipo_prod,
              pv.idprov,
              pv.identificacion, pv.nombre, pv.apellido, pv.direccion, pv.telefono
            from producto_prov pp, productos p, proveedores pv, marcas m, tipo_productos tp
            where
            pp.idproducto = p.idproducto and
            pp.idprov = pv.idprov and
            p.idmarca = m.idmarca and
            p.idtipoprod = tp.idtipoprod ";
        
            //if($idprov != '')
            $query .= " and pp.idprov = $idprov";
        //}
        if($identificacion != '')
            $query .= " and pv.identificacion = $identificacion";
         
        
        $query .= " order by m.marca";
        
        return $this->find_all_by_sql($query);
        /*
          if($idtipodoc != ''){
            $query .= " and pv.idtipodoc = $idtipodoc ";
           }
           if($identificacion != ''){
            $query .= " and pv.identificacion = $identificacion";
           }
         * 
           
          //pv.identificacion = '1234'and
          //pv.idtipodoc = 5";
        /*$columns = 'pp.id, p.idproducto, pv.idprov, pv.identificacion, pv.nombre, pv.apellido';
        $join = 'pp, productos p, proveedores pv';
        $where = 'pp.idproducto = p.idproducto and pp.idprov = pv.idprov';
         
        if($idprov != ''){
            $where .= " and pp.idprov = $idprov";
        }* 
         */
        //return $this->find("columns: $columns","$where","join: $join",'order: pp.idprov asc');
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