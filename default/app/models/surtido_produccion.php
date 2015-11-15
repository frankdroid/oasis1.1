<?php
class SurtidoProduccion extends ActiveRecord{
	
    
    protected function initialize(){
        //asociaciones
        $this->belongs_to('recetas');
        
        //validaciones
        $this->validates_uniqueness_of("fe_registro, idreceta", 'message: El tipo de preparacion ya existe');
        $this->validates_presence_of("idreceta"); 
        $this->validates_presence_of("raciones"); 
        $this->validates_numericality_of("raciones"); 
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