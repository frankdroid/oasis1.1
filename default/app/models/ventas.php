<?php
class Ventas extends ActiveRecord{	
    
    protected function initialize(){
        //asociaciones
        $this->belongs_to('tipo_punto_venta');
        
        //validaciones
        //$this->validates_uniqueness_of("fe_registro, idreceta", 'message: El tipo de preparacion ya existe');
        $this->validates_presence_of("idproducto"); 
        $this->validates_presence_of("idtipopuntoventa"); 
        //$this->validates_presence_of("precio");  
        $this->validates_presence_of("cant");  
       
    }
    
    //funcion que buscar los platos cargados en el punto de venta, por defecto retorna los datos por la ultima fecha de surtido, y por tipo depunto de venta
    public function getElaborados($idtipopuntoventa=null,$fecha=null){
        $result = "";
        if($idtipopuntoventa != '') {
            
            $query = "SELECT DATE_FORMAT(pv.fe_surtido,'%d-%m-%Y') as fecha, pv.idproducto, tp.tipo_prep preparacion,pv.tipo_prod_final, pv.idtipopuntoventa, (pv.cant_entrada - pv.cant_salida) as disp,  pv.precio_sin_iva
                    from punto_venta pv,tipo_preparacion tp
                    where pv.idproducto = tp.idtipoprep 
                    and pv.tipo_prod_final = 'R' 
                    and idtipopuntoventa = $idtipopuntoventa
                    GROUP BY pv.idproducto,preparacion,pv.tipo_prod_final, pv.idtipopuntoventa 
                    order by preparacion";
                    
                     //and DATE_FORMAT(fe_surtido,'%d-%m-%Y') between '15-11-2015' and '15-11-2015' 
//                    "Select s.fecha, s.idreceta, tp.idtipoprep, tp.tipo_prep preparacion,   s.raciones
//                    from surtido_produccion s, recetas r, tipo_preparacion tp
//                    where s.idreceta = r.idreceta and r.idtipoprep = tp.idtipoprep ";
//            
//                    if($fecha != '')
//                        $query .= " and s.fecha = '$fecha' ";
//                    
//                    $query .= "group by fecha, idreceta, tipo_prep
//                    order by preparacion";
            $result = $this->find_all_by_sql($query);  
        }  
          
       return $result;     
    }
    
    
    //funcion que buscar los platos cargados en el punto de venta, por defecto retorna los datos por la ultima fecha de surtido, y por tipo depunto de venta
    public function getProductosFinal($idtipopuntoventa=null,$fecha=null){
        $result = "";
        if($idtipopuntoventa != '') {
            
            $query = "SELECT DATE_FORMAT(pv.fe_surtido,'%d-%m-%Y') as fecha,
                    pv.idproducto, m.marca, tp.tipo_prod, p.presentacion,
                    pv.tipo_prod_final, pv.idtipopuntoventa, (sum(pv.cant_entrada) - sum(pv.cant_salida)) as disp,
                    pv.precio_sin_iva
                    from punto_venta pv, productos p, tipo_productos tp, marcas m
                    where pv.idproducto = p.idproducto
                          and pv.idtipopuntoventa = $idtipopuntoventa
                          and p.idtipoprod = tp.idtipoprod
                          and p.idmarca = m.idmarca
                    GROUP BY pv.idtipopuntoventa, idproducto";
                
//
//                    SELECT DATE_FORMAT(pv.fe_surtido,'%d-%m-%Y') as fecha,
//                    pv.idproducto, tp.tipo_prod, p.presentacion,  m.marca,
//                    pv.tipo_prod_final, pv.idtipopuntoventa, (pv.cant_entrada - pv.cant_salida) as disp,  pv.precio_sin_iva
//                    from punto_venta pv, productos p, tipo_productos tp, marcas m
//                    where pv.idproducto = p.idproducto
//                          and pv.idtipopuntoventa = $idtipopuntoventa
//                          and p.idtipoprod = tp.idtipoprod 
//                          and p.idmarca = m.idmarca";
//                

            $result = $this->find_all_by_sql($query);  
        }  
          
       return $result;
           
    }
    
    //funcion que retorna las cantidades de platos elaborados para la venta disponible en ese punto de venta, y el ultimo precio 
    public function getDetalleElaborados($idproducto=null, $idtipopuntoventa=null){
        /*por la fecha mas actual*/
//        $query = "select i.idproducto, cant disponible, p.cant_entrada, p.precio_sin_iva, p.fe_surtido from punto_venta p
//        right join inventario i on (p.idproducto = i.idproducto)
//        where i.idproducto = '$idproducto'";
        $query = "SELECT
                DATE_FORMAT(pv.fe_surtido,'%d-%m-%Y'), pv.precio_sin_iva precio, pv.tipo_prod_final
                from punto_venta pv
                where DATE_FORMAT(pv.fe_surtido,'%d-%m-%Y') = (select max(DATE_FORMAT(fe_surtido,'%d-%m-%Y')) from punto_venta where idproducto = '$idproducto')
                and pv.idproducto = '$idproducto'";

            
//                select DATE_FORMAT(fe_surtido,'%d-%m-%Y'), precio_sin_iva precio
//                from punto_venta
//                where DATE_FORMAT(fe_surtido,'%d-%m-%Y') = (select max(DATE_FORMAT(fe_surtido,'%d-%m-%Y')) from punto_venta where idproducto = '$idproducto')
//                and idproducto = '$idproducto'";
////
//            select pv.idtipopuntoventa, pv.idproducto, (pv.cant_entrada - pv.cant_salida) disponible, p.precio_sin_iva, p.fe_surtido from punto_venta p
//                    right join punto_venta pv on (p.idproducto = pv.idproducto)
//                    where pv.idproducto = '$idproducto'";
        
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
    
    public function todos()
    {

            return $this->find();

    }
	
}
?>