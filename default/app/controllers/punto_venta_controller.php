<?php
Load::models('punto_venta'); // carga modelo PuntoVenta
Load::models('surtido_produccion'); 
//Load::models('receta_prod'); 
Load::models('productos');
//Load::models('unidades');
class PuntoVentaController extends AppController {
	
	public $titulo_pagina = 'Oasis Service C.A.- Puntos de Ventas'; //titulo de la pagina
	       
        public function before_filter(){
            /*if(Session::get('usuario') == false){
                Flash::error('Para poder acceder a los Modulos, debe primero iniciar una sesion.');
                $this->route_to("controller: usuarios", "action: login");
            }
             */
        }
        
        protected function after_filter() {
            //parent::after_filter();
            if(Input::isAjax()){
                View::template(null);
            }
        } 
        
	// funcion index
	public function index() 
        {
        }
	
        // funcion index
	public function lista($page=1) 
        {
            $PuntoVenta = new PuntoVenta();
            $this->list = $PuntoVenta->getAll($page); //getAll();
            View::template(NULL);
            
        }
	
       //buscar el ultimo precio y disponibilidad 
       public function getDetalleElaborados() {
           $punto_venta = new PuntoVenta();
            //buscar los productos  elaborados es decir preparados
            $this->existe = false;
            
            $idtipoprep = Input::post('idtipoprep');
            /*
           $query = "select i.idproducto, cant disponible, p.precio_sin_iva, p.fe_surtido from punto_venta p
                    right join inventario i on (p.idproducto = i.idproducto)
                    where i.idproducto = '$idproducto'";           
           */
           //$this->detalle_elaborados = $punto_venta->getElaborados(Input::post('idreceta'));
           $this->detalle_elaborados = $punto_venta->getDetalleElaborados($idtipoprep);
           //Flash::notice(var_dump($this->detalle_elaborados));            
           
           if(count($this->detalle_elaborados) > 0 ){
               $this->existe = true;
           }           
       }
        
        public function create()
        {
            $this->titulo = 'Punto de Venta'; 
            
            $fecha = (Input::hasPost('fe_surtido') ? Input::post('fe_surtido') : date('Y-m-d') ); 
            
            $punto_venta = new PuntoVenta();
            $this->elaborados = $punto_venta->getElaborados($fecha);
            
            $producto = new Productos;
            $this->productos =  $producto->getAll();
            
           
            if(Input::hasPost('idtipopuntoventa')){   
                //Flash::notice(date('Y-m-d'));
                
                $valid = false;
                $cant_row = Input::post('cant_row');
                
                for($i=1; $i<=$cant_row; $i++){
                    if(Input::post("carga$i") == "1"){
                        $punto_venta = new PuntoVenta(); 

                        $punto_venta->idtipopuntoventa = Input::post("idtipopuntoventa");
                        $punto_venta->idproducto  = Input::post("idproducto$i");
                        $punto_venta->precio_sin_iva = (Input::post("precio$i") > 0 ? Input::post("precio$i") :  Input::post("ultimo_precio$i")) ;
                        $punto_venta->cant_entrada = Input::post("surtido$i");
                        $punto_venta->cant_salida = "0";
                        $punto_venta->fecha = date('Y-m-d');
                        //$surtido->idusuario = Session::get('idusuario');

                        if($punto_venta->save()){
                            Flash::valid("producto_$i guardado");
                        }else{
                           Flash::error("rerror guardando el producto_$i "); 
                        }
                    }
                } 
                
            }
    }
    
    public function buscar(){
        
        Flash::info('gfododfko');
        //View::template(null);
        $surtido_prod = new PuntoVenta();
        //$receta_prod = new RecetaProd();
        $this->existe = false;
        //$this->datos = 2; //Input::post('');
        //if(Input::hasPost('idreceta')){
            $idreceta = Input::post('idreceta');
            
            $this->ingredientes = $surtido_prod->getIngredienteReceta((int)$idreceta);
            if(count($this->ingredientes) > 0 ) {   
                $this->existe = true;
                

//                
//                //busco los productos de la receta
//                $idreceta = $receta->idreceta;
//                $this->dato = $idreceta;
//                
//                $this->PuntoVenta_productos = $receta_prod->getRecetaProductos((int)$idreceta);
//                //$this->PuntoVenta_productos = $receta->getRecetaProductos($idreceta);
                
            }  
        //}
    }
    
    public function buscarIngredienteReceta(){
        //View::template(NULL);
        
        //$receta_prod = new RecetaProd();
        $this->existe = false;
        //$this->datos = 2; //Input::post('');
        
                
        if(Input::hasPost('idreceta')){
            $idreceta = Input::post('idreceta');
            $surtido_prod = new PuntoVenta();  
            
            $this->surtido_prod = $surtido_prod->ingredientesReceta(Input::post('idreceta'));
             if(count($surtido_prod) > 0 ) {   
                $this->existe = true; 
             }
             
            //Flash::notice(var_dump($surtido_prod)); //Input::post('idreceta'));
            
//            if(count($surtido_prod) > 0 ) {   
//                $this->existe = true;
//                
//                //busco los productos de la receta
//                $idreceta = $receta->idreceta;
//                //$this->dato = $idreceta;
//                
//                $this->PuntoVenta_productos = $receta_prod->getRecetaProductos((int)$idreceta);
//                //$this->PuntoVenta_productos = $receta->getRecetaProductos($idreceta);
//            }  
       }
    }
    
      
    public function buscarReceta(){
        View::template(NULL);
        $receta = new PuntoVenta();
        $receta_prod = new RecetaProd();
        $this->existe = false;
        //$this->datos = 2; //Input::post('');
        //if(Input::hasPost('idtipoprep')){
            $idtipoprep = Input::post('idtipoprep');
            //$this->query = "select * from PuntoVenta where idtipoprep=$idtipoprep";
                   
            
            $this->PuntoVenta = $receta->getReceta($idtipoprep);
            if(count($this->PuntoVenta) > 0 ) {   
                $this->existe = true;
                
                //busco los productos de la receta
                $idreceta = $receta->idreceta;
                $this->dato = $idreceta;
                
                $this->PuntoVenta_productos = $receta_prod->getRecetaProductos((int)$idreceta);
                //$this->PuntoVenta_productos = $receta->getRecetaProductos($idreceta);
            }
    }
    
    
//    public function edit($id = null)
//    {      
//        $this->titulo = 'Incorporaci&oacute;n de PuntoVenta'; 
//        
//    	$PuntoVenta = new PuntoVenta();
//        if($id != null){
//            $PuntoVenta = $PuntoVenta->find((int)$id);
//        
//            if(Input::hasPost('PuntoVenta')){
//                
//                $request = Input::post('PuntoVenta');
//               
//                if($PuntoVenta->update($request)){
//                  
//                    Router::redirect('PuntoVenta/create');
//                    //se hacen persistente los datoPuntoVenta en el formulario
//                    //$this->tipodoc = $this->post('tipo_cliente');
//                } else
//                    Flash::error('Falló la Operación');
//
//
//            }else
//                $this->PuntoVenta = $PuntoVenta->find((int)$id);
//        }else {
//            Flash::error('El id llego null');
//        }
//        
//        //obtiene la lista
//        $this->list = $this->getList();
//    }
        
    
    /* Esta funcion devuelve una lista de los tipos de documentos*/
    public function getList(){
        //$page=1;
        $PuntoVenta = new PuntoVenta();
        $this->list = $PuntoVenta->getAll();

        return $this->list;
    }
}