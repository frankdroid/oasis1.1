<?php
Load::models('facturas');
Load::models('factura_prod');
Load::models('productos'); 
Load::models('proveedores'); // Carga modelo Proveedores
Load::models('condicion_pago'); // carga modelo tipo_proveedores

class FacturasController extends AppController {
	
    public $titulo_pagina = 'Oasis Service C.A.- Facturas'; //titulo de la pagina
	
    protected function after_filter() {
        //parent::after_filter();
        if(Input::isAjax()){
            View::template(null);
        }
    } 
   
    public function create ()
    {
        /*if(Session::has('nombre','apellido','identificacion','direccion','telefono'))
            Session::delete('nombre','apellido','identificacion','direccion','telefono');
        */
        $this->titulo = 'Ingreso de Factura y Producto';
        
        $this->productos = $this->getSelect();
        
        if(Input::hasPost('facturas') && Input::hasPost('cant_row')){
            $factura = new Facturas(Input::post('facturas'));
            //se guarda los datos de la factura
            $factura->begin();
            if($factura->create()){
                $factura->commit();
                //Flash::valid(var_dump($factura));
                
                //guardamos los productos
                $cant_row = Input::post('cant_row');
                for($i=1; $i<=$cant_row; $i++){
                    $factura_prod = new FacturaProd();
                    $factura_prod->idfactura = $factura->idfactura;
                    $factura_prod->no_factura = $factura->no_factura;
                    $factura_prod->idproducto = Input::post("idproducto$i");
                    $factura_prod->caducidad = Input::post("caducidad$i");
                    $factura_prod->cant = Input::post("cant$i");
                    $factura_prod->precio_unidad = Input::post("precio$i");
                    $factura_prod->descuento = Input::post("des$i");
                    $factura_prod->sup = Input::post("sup$i");
                    $factura_prod->iva = Input::post("iva$i");
                    $factura_prod->total = Input::post("total$i");
                   
                    if($factura_prod->create()){
                        //Flash::valid(var_dump($factura_prod));
                        Flash::valid("producto_$i guardado");
                    }else{
                       Flash::error("rerror guardando el producto_$i "); 
                       
                    }
                        
                }  
            }else{
                $factura->rollback();
            }
        }
    }
    
    public function cargaProdutos(){
        Flash::valid($id);
    }
    
    /* function quer permite agregar un proveesor */
    public function actualizarProveedor(){
        
        View::template(null);
        //$this->valido = "false";
        //$this->valido = Input::post('idprov');
        //View::response('hola', null);
        //echo "theiriieieie";
        //if((Input::hasPost('idprov')) && (Input::post('idprov') != null) && (Input::post('idprov')) ){
        if(Session::has('idprov'))
            Session::delete ('idprov');
            
        if((Input::hasPost('idprov')) && (Input::hasPost('nombre')) ){
            
            $proveedor = new Proveedores();
            //$idprov = Input::post('idprov');
            
            //$proveedor = $proveedor->find((int)$idprov);
            //$proveedor = $proveedor->find_by_idprov(1);
            $proveedor->idprov = Input::post('idprov');
            $proveedor->idtipodoc = Input::post('idtipodoc');
            $proveedor->identificacion = Input::post('identificacion');
            $proveedor->nombre = Input::post('nombre');
            $proveedor->apellido = Input::post('apellido');
            $proveedor->direccion = Input::post('direccion');
            $proveedor->telefono = Input::post('telefono');
            $proveedor->comentario = Input::post('comentario');
            $proveedor->contacto1 = Input::post('contacto1');
            $proveedor->contacto2 = Input::post('contacto2');
            $proveedor->correo1 = Input::post('correo1');
            $proveedor->correo2 = Input::post('correo2');
            $proveedor->idcondicion = Input::post('idcondicion');
            
            if(Input::post('productos')){
                $productos = Input::post('productos');
                $productos = str_split($productos);
                
            }    
            
            if($proveedor->save()){
                //guardamos los productos
                if(is_array($productos)){
                    for($i=0; $i<count($productos); $i++){
                        if((is_int((int)$productos[$i])) && ((int)$productos[$i] > 0)){
                            $producto_prov = new ProductoProv();
                            
                            //verificamos is existe
                            if(!$producto_prov->exists("idprov=".$proveedor->idprov." and idproducto=".$productos[$i]))
                            {       
                                $producto_prov->idprov = $proveedor->idprov;
                                $producto_prov->idproducto = $productos[$i];

                                //guarda el producto
                                if($producto_prov->save()){
                                    //Flash::valid('producto cargado');
                                }
                            }else{
                                Flash::error("el proveedor ya tiene el producto asociado");
                            }    
                        }
                            
                    }
                }
                
            }else{
                //$this->valido = "false";
                Flash::error("Falló el proceso de carga del proveedor");  
            }
        }else{
            Flash::error("Hay campos vacios");
        }
    }
    
            
    
	/*
    public function buscarproveedor($cedula) {
		
            View::template(NULL); // se carga sin template
            Load::models('proveedores');  // se carga el modelo de proveedores

            $this->msg = "";
            $proveedor = new Proveedores();
            if($proveedor->exists("identificacion=$cedula")) {
                    $this->proveedores = $proveedor->Buscar($cedula);
            } else {
                    $this->msg = "Proveedor no existe";
            }
		
	}
    */
    
    public function getSelect(){
        //return $this->find("columns: idproducto,tipo_cliente", "order: tipo_cliente" );
        
        $producto = new Productos();
        
        $columns = "p.idproducto, m.marca,tp.tipo_prod,p.presentacion";
        $join = 'p, marcas m, tipo_productos tp';
        $where = 'p.idmarca = m.idmarca and p.idtipoprod = tp.idtipoprod';
        
        $rs = $producto->find("columns: $columns","$where","join: $join",'order: m.marca asc');
        
       
       return $rs;
    }
    
    public function buscarProveedor(){
        View::template(null);
        $proveedor = new Proveedores();
        $this->proveedores = null;
        $this->productos_proveedor = null;
        $this->existe = 'false';
        
        //$this->datos = 'idtipodoc='.Input::post('idtipodoc') . ' identificacion='.Input::post('identificacion');
        //echo "sdsdd";
        //exit;
        
        $idtipodoc = Input::post('idtipodoc');
        $identificacion=Input::post('identificacion');
        //Flash::error('Fall&oacute; el registro de producto');
        if($proveedor->exists('idtipodoc='.$idtipodoc,'identificacion='.$identificacion))
        {
             $this->existe = 'true';
             $this->proveedores = $proveedor->getProveedor($idtipodoc, $identificacion);
             $idprov = $proveedor->idprov; 
             
             //obtener lista de los productos asociados al proveedor
             $producto_prov = new ProductoProv();
             $this->productos_proveedor = $producto_prov->getProductosProveedor($idprov,'');
             
             //$query = "Select * from proveedores where idtipodoc=".Input::post("idtipodoc")." and identificacion="."'".Input::post('identificacion')."'";
            
             //$this->proveedores = $proveedor->find_by_sql($query); 
             //$this->proveedores = $proveedor-l>find_by_identificacion(); 
        
        }
        //echo var_dump($this->proveedores);
        //View::partial('proveedores/list_tipo_proveedores');*/Input::post('identificacion')
    }
    
    public function agregarProducto(){
        View::template(null);
        $producto_prov = new ProductoProv();
        //$this->productos = '';
        $this->result = 'false';
        
        if((Input::hasPost("idprov")) || (Input::post("idprod")) || (Input::post("idprov") != '') || (Input::post("idprov") != '') )  //|| (Input::post("identificacion") != '')
        {   
            $idprov = '';
            $idprod = '';
            //$identificacion = '';
            /*
            if(Input::post("idprov") == ''){
                //buscar el id del proveedor por la identificacion 
                
            }*/
            
            
            $idprov = Session::get('idprov'); 
            //Input::post("idprov");
            $idprod = Input::post("idprod");
            $producto_prov->idproducto = $idprod;
            $producto_prov->idprov = $idprov;
            
            
            //f($cliente->exists('idtipodoc='.Input::post('idtipodoc'), 'identificacion='.Input::post('identificacion')))
            //verifica si el producto existe para este proveedor
            //$sql = "select id from producto_prov where idprov=$idprov and idproducto=$idprod";
            //$this->result = $producto_prov->count_by_sql($sql);
            //if($producto_prov->count_by_sql($sql) > 0)   
            if(!$producto_prov->exists("idprov=$idprov and idproducto=$idprod"))
            {
                //$this->result = "idprov=$idprov"."  idproducto=$idprod";
                if(!$producto_prov->create()){
                    Flash::error('Fall&oacute; el registro de producto');
                    //$result = 'false';
                }else
                    $this->result = 'true';
            }else{
                Flash::error('El proveedor ya tiene cargado este producto');
                //$result = 'false';
            }
            
            $this->producto_prov = $producto_prov->getProductosProveedor($idprov);
        }
        else{
            Flash::error('problemas');
            //solo para prueba
            //$this->producto_prov = $producto_prov->find();
        }
        
    }
    
    public function listarProductosProveedor(){
        View::template(null);
        $producto_prov = new ProductoProv();
        $identificacion = 0;
        
        //if(Input::hasPost("idprov"))
        //$idprov = Input::post("idprov");
        
        if(Input::hasPost("identificacion"))
            $identificacion = Input::post("identificacion");
            
        $this->producto_prov = $producto_prov->getProductosProveedor('',$identificacion);
    }
	
}