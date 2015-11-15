<?php
class PuntoVenta extends ActiveRecord{	
    
    protected function initialize(){
        //asociaciones
        $this->belongs_to('tipo_punto_venta');
        
        //validaciones
        //$this->validates_uniqueness_of("fe_registro, idreceta", 'message: El tipo de preparacion ya existe');
        //$this->validates_presence_of("idproducto"); 
        $this->validates_presence_of("idtipopuntoventa"); 
        $this->validates_presence_of("precio_sin_iva");  
       
    }
    
    //funcion que retorna las cantidades de platos elaborados para la venta
    public function getElaborados($fecha=null){
            $query = "Select s.fecha, s.idreceta, tp.idtipoprep, tp.tipo_prep preparacion,   s.raciones
                    from surtido_produccion s, recetas r, tipo_preparacion tp
                    where s.idreceta = r.idreceta and r.idtipoprep = tp.idtipoprep ";
                    if($fecha != '')
                        $query .= " and s.fecha = '$fecha' ";
                    
                    $query .= "group by fecha, idreceta, tipo_prep
                    order by preparacion";
                    
            return $this->find_all_by_sql($query);  
    }
    
    //funcion que retorna las cantidades de platos elaborados para la venta disponible en ese punto de venta, y el ultimo precio 
    public function getDetalleElaborados($idproducto=null){
        /*por la fecha mas actual*/
        $query = "select i.idproducto, cant disponible, p.cant_entrada, p.precio_sin_iva, p.fe_surtido from punto_venta p
        right join inventario i on (p.idproducto = i.idproducto)
        where i.idproducto = '$idproducto'";
          
        return $this->find_all_by_sql($query);  
    }
    
    public function getAll()
    {
        $columns = 'r.idreceta,r.idtipoprep,r.cant,r.fe_reg,r.estatus,p.tipo_prep';
        $join = 'r, tipo_preparacion p';
        $where = 'r.idtipoprep = p.idtipoprep';
        
        return $this->find("columns: $columns","$where","join: $join",'order: p.tipo_prep asc');
    }
    
    public function getReceta($idtipoprep){
            $query = "select * from surtido_produccion where idtipoprep=$idtipoprep";
            return $this->find_all_by_sql($query);
            
    }
    
    //funcion que retorna las recetas
    public function getPreparaciones(){
            $query = "select idreceta, tipo_prep preparacion  from vw_surtido_produccion group by idreceta order by tipo_prep";
            return $this->find_all_by_sql($query);  
    }
    
    /*funcion que devuelve los ingredientes de la receta*/
//    public function getIngredienteReceta($idreceta=null){
//            $query = "select * preparacion from vw_surtido_produccion where idreceta = $idreceta";
//            Flash::info($query);
//            
//            return $this->find_all_by_sql($query);  
//    }
//    
    
     public function ingredientesReceta($id=null){
            $query = "select * from vw_surtido_produccion where idreceta = $id";
            //Flash::info($query);
            
            return $this->find_all_by_sql($query);  //("condition: idreceta = $id");  
    }
    
    
    
    
    
    
    public function todos()
    {

            return $this->find();

    }
	
}
?>