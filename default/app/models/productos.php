<?php
class Productos extends ActiveRecord{
	
    
    protected function initialize(){
        //asociaciones
        $this->belongs_to('tipo_productos');
        $this->belongs_to('marcas');
        $this->belongs_to('unidades');
        
        //validaciones
        $this->validates_uniqueness_of("idmarca,idtipoprod", 'message: El producto ya existe');
        $this->validates_presence_of("presentacion");
        $this->validates_presence_of("cant_empaque");
        $this->validates_presence_of("merma_estimada");
        $this->validates_presence_of("idunidad");
        $this->validates_presence_of("idmarca");
        $this->validates_presence_of("idtipoprod");
        
    }
    
    public function getAll()
    {
        $columns = 'p.idproducto,p.idtipoprod,p.idmarca,p.presentacion,p.cant_empaque,p.merma_estimada,p.idunidad,m.marca,tp.tipo_prod';
        $join = 'p, marcas m, tipo_productos tp';
        $where = 'p.idmarca = m.idmarca and p.idtipoprod = tp.idtipoprod';
        
        return $this->find("columns: $columns","$where","join: $join",'order: m.marca asc');
    }
    
    
    public function todos()
    {
        return $this->find();
    }
	
	
    public function getSelect(){
        //return $this->find("columns: idproducto,tipo_cliente", "order: tipo_cliente" );
        
        //$producto = new Productos();
        
        $columns = "p.idproducto, m.marca,tp.tipo_prod,p.presentacion";
        $join = 'p, marcas m, tipo_productos tp';
        $where = 'p.idmarca = m.idmarca and p.idtipoprod = tp.idtipoprod';
        
        $rs = $this->find("columns: $columns","$where","join: $join",'order: m.marca asc');
        
       
       return $rs;
    }
    
    //busca la unidad del producto
    public function getProductoUnidad($idproducto){
        $sql = "select u.unidad, p.idunidad from productos p, unidades u "
                . " where p.idunidad = u.idunidad and p.idproducto = '$idproducto'";
        
        return $this->find_by_sql($sql);
    }
    
    public function Buscar($cedula) 
    {	
            return $this->find_by_identificacion($cedula);
    }
    
    
    public function generarCodProducto() 
    {	
        $sql = "Select max(substring(idproducto from 2 for 6)) from productos";        
        
            return $this->find_by_identificacion($cedula);
    }
    
	
}
?>