<?php

Load::models('facturasc'); // Carga modelo Facturas Clientes
Load::models('facturasc_det'); // Carga modelo Detalles Facturas Clientes
Load::models('productos');  // se carga el modelo de productos
Load::models('facturasc_temp'); // se carga el modelo de facturasc_temp
Load::models('facturascdet_temp'); // se carga el modelo de facturascdet_temp

class PruebasController extends AppController {

	public $titulo_pagina = 'Oasis Service C.A.- Ventas'; //titulo de la pagina
	
        public function index() {
            $this->productos = $this->getSelect();
		
            //View::template(NULL); // se carga sin template
            /*Load::models('clientes');  // se carga el modelo de clientes

            $this->msg = "";
            $cliente = new Clientes();
            if($cliente->exists("identificacion=$cedula")) {
                    $this->clientes = $cliente->Buscar($cedula);
            } else {
                    $this->msg = "Cliente no existe";
            }*/
		
	}
        
        public function getSelect(){
        //return $this->find("columns: idproducto,tipo_cliente", "order: tipo_cliente" );
        
        $producto = new Productos();
        
        $columns = "p.idproducto, m.marca,tp.tipo_prod,p.presentacion";
        $join = 'p, marcas m, tipo_productos tp';
        $where = 'p.idmarca = m.idmarca and p.idtipoprod = tp.idtipoprod';
        
        $rs = $producto->find("columns: $columns","$where","join: $join",'order: m.marca asc');
        
       
       return $rs;
    }
	
}
?>