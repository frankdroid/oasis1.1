<?php

Load::models('facturasc'); // Carga modelo Facturas Clientes
Load::models('facturasc_det'); // Carga modelo Detalles Facturas Clientes
Load::models('productos');  // se carga el modelo de productos
Load::models('facturasc_temp'); // se carga el modelo de facturasc_temp
Load::models('facturascdet_temp'); // se carga el modelo de facturascdet_temp

class VentasController extends AppController {

	public $titulo_pagina = 'Oasis Service C.A.- Ventas'; //titulo de la pagina
	
	
	public function facturac() {
		$hoy = date("Y-m-d");
		if (Input::hasPost("nombres","total")){
			$idfactemp = Input::post("idfactemp");
			$idcliente = Input::post("idcliente");
			$total = Input::post("total");
			$iva = Input::post("iva");
			$efe = Input::post("efe");
			$tdd = Input::post("tdd");
			$tdc = Input::post("tdc");
			$tae = Input::post("tae");
			$taf = Input::post("taf");
			
			$facturac = new Facturasc();
			$facturac->create("idcliente: $idcliente",
							  "monto: $total",
							  "iva: $iva",
							  "efe: $efe",
							  "tdd: $tdd",
							  "tdc: $tdc",
							  "tae: $tae",
							  "taf: $taf",
							  "creado: $hoy",
							  "modificado: $hoy");
							  
			$idfacturac = $facturac->Ultimo(); // obtener el idfacturac	
				  
			$itemfactemp = new Facturascdet_temp();
			$detallesFactemp = $itemfactemp->Extraer($idfactemp); // extraer los items a los detalles de factura
			
			
			foreach($detallesFactemp as $items => $detalle): 
			
				$itemfact = new Facturasc_det();
				$itemfact->create("idfacturac: $idfacturac->id",
								  "idproducto: $detalle->idproducto",
								  "cantidad: $detalle->cantidad",
								  "precio_venta: $detalle->precio_venta",
								  "importe: $detalle->importe",
								  "exento: $detalle->exento");
			endforeach;	
			Router::toAction("imprimir/$idfacturac->id");	
			//Router::toAction("cargarpago/$idfacturac->id");	
		}
		// si no se ha guardado la factura
		$facturac_temp = new Facturasc_temp();
		$facturac_temp->create("idfactemp: ","creado: $hoy");
		$this->idfactemp = $facturac_temp->find_by_sql("SELECT MAX(idfactemp) AS id FROM facturasc_temp");
		
		$producto = new Productos();
		$this->listaProductos = $producto->Todos();
	}
	
	
	// Para cargar la forma de pago
	public function imprimir($idfacturac) {
		
		$facturac = new Facturasc();
		$this->datosFacturac = $facturac->Buscar($idfacturac);
		
		$facturacdet = new Facturasc_det();
		$this->listaItems = $facturacdet->Buscar($idfacturac);
	}
	

		
	public function buscaritem($idproducto) {
		View::template(NULL);
		$producto = new Productos();
		$this->productos = $producto->Buscar($idproducto);
	}
	
	
	public function cargaritem($idfactemp,$idproducto,$cantidad) {
		View::template(NULL);
		$productos = new Productos();
		$producto = $productos->Buscar($idproducto);
		$importe = $producto->precio_venta * $cantidad;
		
		// cargo en bd el item temporal
		$item = new Facturascdet_temp();
		$item->create(	"idfactemp: $idfactemp",
						"idproducto: $idproducto",
						"cantidad: $cantidad",
						"precio_venta: $producto->precio_venta",
						"exento: $producto->exento",
						"importe: $importe");

		$this->listaDetalles = $item->Buscar($idfactemp);	
	}
	
	
	public function borraritem($id,$idfactemp) {
		View::template(NULL);
		$item = new Facturascdet_temp();
		$item->delete((int)$id);
		
		$this->listaDetalles = $item->Buscar($idfactemp);	
	}
	
		
		
	public function buscarcliente($cedula) {
		
            View::template(NULL); // se carga sin template
            Load::models('clientes');  // se carga el modelo de clientes

            $this->msg = "";
            $cliente = new Clientes();
            if($cliente->exists("identificacion=$cedula")) {
                    $this->clientes = $cliente->Buscar($cedula);
            } else {
                    $this->msg = "Cliente no existe";
            }
		
	}
	
}
?>