<?php
class Facturasc_det extends ActiveRecord{
	
	public function Todos()
		{
			return $this->paginate();
	
		}
	
	public function Buscar($idfacturac) {
		return $this->find_all_by_sql("SELECT p.cod_producto, p.idproducto, p.descripcion, f.idfacturac, f.cantidad,f.precio_venta,f.importe, f.exento
									   FROM facturasc_det as f, productos as p
									   WHERE idfacturac = $idfacturac AND f.idproducto = p.idproducto");	
	}	
	
		
}
?>