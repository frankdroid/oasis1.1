<?php

Load::models('facturasc'); // Carga modelo Facturas Clientes
Load::models('productos');  // se carga el modelo de productos
Load::models('facturasc_temp'); // se carga el modelo de facturasc_temp
Load::models('facturascdet_temp'); // se carga el modelo de facturascdet_temp

class VentasController extends AppController {

	public $titulo_pagina = 'Oasis Service C.A.- Ventas'; //titulo de la pagina
	
	public function facturac() {
		
		$facturac_temp = new Facturasc_temp();
		$hoy = date("Y-m-d");
		$facturac_temp->create("id_facturactemp: ","creado: $hoy");
		$this->id_facturactemp = $facturac_temp->find_by_sql("SELECT MAX(id_facturactemp) AS id FROM facturasc_temp");
			
		
	
		$producto = new Productos();
		$this->listaProductos = $producto->Todos();
	}
	

		
	public function agregaritem($id_facturactemp,$idproducto) {
		View::template(NULL);
		$productos = new Productos();
		$producto = $productos->Buscar($idproducto);
		
		// cargo en bd el item temporal
		$item = new Facturascdet_temp();
		$item->create(	"idfacturactemp: $id_facturactemp",
						"idproducto: $idproducto",
						"precio_venta: $producto->precio_venta",
						"exento: $producto->exento");

		$this->listaFacturacdet_temp = $item->Buscar($id_facturactemp);
	}
	
		
		
	public function buscarcliente($cedula) {
		
		View::template(NULL); // se carga sin template
		Load::models('clientes');  // se carga el modelo de clientes
		
		$this->msg = "";
		$cliente = new Clientes();
		if($cliente->exists("identificacion=$cedula")) {
			$this->clientes = $cliente->find_by_identificacion($cedula);
		} else {
			$this->msg = "Cliente no existe";
		}
		
	}
	
}
?>