<?php
class Facturascdet_temp extends ActiveRecord{
	
	public function Todos()
		{
			return $this->paginate();
	
		}
		
	public function Buscar($idfactemp) {
		return $this->find_all_by_sql("SELECT p.cod_producto, p.idproducto, p.descripcion, f.id, f.idfactemp, f.cantidad, f.exento, f.importe
									   FROM facturascdet_temp as f, productos as p
									   WHERE idfactemp = $idfactemp AND f.idproducto = p.idproducto");	
	}
	
	public function Extraer($idfactemp) {
		return $this->find_all_by_idfactemp($idfactemp);	
	}
		
}
?>