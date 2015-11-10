<?php
class Recetas extends ActiveRecord{
	
    
    protected function initialize(){
        //asociaciones
        $this->belongs_to('tipo_preparacion');
        
        //validaciones
        $this->validates_uniqueness_of("idtipoprep", 'message: El tipo de preparacion ya existe');
        $this->validates_presence_of("cant"); 
        $this->validates_numericality_of("cant");
    }
    
    public function getAll()
    {
        $columns = 'r.idreceta,r.idtipoprep,r.cant,r.fe_reg,r.estatus,p.tipo_prep';
        $join = 'r, tipo_preparacion p';
        $where = 'r.idtipoprep = p.idtipoprep';
        
        return $this->find("columns: $columns","$where","join: $join",'order: p.tipo_prep asc');
    }
    
    public function getReceta($idtipoprep){
            $query = "select * from recetas where idtipoprep=$idtipoprep";
            //Flash::info($query);
            return $this->find_by_sql($query);
            
    }
    
    
    
    
    public function todos()
    {

            return $this->find();

    }
	
}
?>