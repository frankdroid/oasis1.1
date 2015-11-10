<?php
class RecetaProd extends ActiveRecord{
	
    
    protected function initialize(){
        //asociaciones
        $this->belongs_to('recetas');
        $this->belongs_to('productos');
        $this->belongs_to('unidades');
        
        //validaciones$this->validates_presence_of("no_factura");
        $this->validates_presence_of("idreceta");
        $this->validates_presence_of("idunidad");
        $this->validates_presence_of("idproducto");
        $this->validates_presence_of("minima");
        $this->validates_presence_of("maxima");
        $this->validates_numericality_of("minima");
        $this->validates_numericality_of("maxima");
        
    }
    
    //get los productos de la receta
    public function getRecetaProductos($idreceta){
        //if($idreceta != ''){
        
            $query = "select rp.id, rp.idproducto,rp.minima, rp.maxima, rp.idunidad, m.marca, t.tipo_prod, u.unidad, p.presentacion, p.cant_empaque, p.merma_estimada, p.producto from receta_prod rp, productos p, marcas m, tipo_productos t, unidades u
                where
                rp.idproducto = p.idproducto and
                p.idmarca =m.idmarca and
                p.idtipoprod = t.idtipoprod and
                rp.idunidad = u.idunidad and
                rp.idreceta=$idreceta";
                    
            return $this->find_all_by_sql($query);
        /*}else
            return null;
         * 
         */
    }

    public function todos()
    {

            return $this->find();

    }
	
	
}
?>