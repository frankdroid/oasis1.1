<?php
Load::models('punto_venta'); // carga modelo Ventas
Load::models('ventas'); // carga modelo Ventas
//Load::models('surtido_produccion'); 
//Load::models('receta_prod'); 
Load::models('productos');
//Load::models('unidades');
class VentasController extends AppController {
	
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
                //View::select('vista_resultado');
            }
        } 
        
	
	public function index() 
        {
            //Flash::notice(Input::post('idtipopuntoventa'));
            if(Input::hasPost('idtipopuntoventa')){
                Session::set('idtipopuntoventa', Input::post('idtipopuntoventa'));
                Session::set('puntoventa', Input::post('puntoventa'));
                
                
                Router::toAction("create");
            }
        }
	
        // funcion index
	public function lista($page=1) 
        {
            $Ventas = new Ventas();
            $this->list = $Ventas->getAll($page); //getAll();
            View::template(NULL);
        }
	
       //buscar el ultimo precio y disponibilidad 
       public function getDetalleElaborados() {
           $venta = new Ventas();
            //buscar los productos  elaborados es decir preparados
            $this->existe = false;
            
            $idtipoprep = 4; // Input::post('idtipoprep');
            /*
           $query = "select i.idproducto, cant disponible, p.precio_sin_iva, p.fe_surtido from punto_venta p
                    right join inventario i on (p.idproducto = i.idproducto)
                    where i.idproducto = '$idproducto'";           
           */
           //$this->detalle_elaborados = $venta->getElaborados(Input::post('idreceta'));
           $this->detalle_elaborados = $venta->getDetalleElaborados($idtipoprep);
           //Flash::notice(var_dump($this->detalle_elaborados));            
           
           if(count($this->detalle_elaborados) > 0 ){
               $this->existe = true;
           }           
       }
        
        public function datosCliente()
        {
            
        }
       
        public function create()
        {
            $this->titulo = 'Punto de Venta'; 
            //$fecha = (Input::hasPost('fe_surtido') ? Input::post('fe_surtido') : date('Y-m-d') ); }
            $venta = new Ventas();
            $idtipopuntoventa = Session::get('idtipopuntoventa');
            $this->elaborados = $venta->getElaborados($idtipopuntoventa);
            
            //$producto = new Productos;
            $this->productos =  $venta->getProductosFinal($idtipopuntoventa);
          
            if(Session::has('idtipopuntoventa') && Input::hasPost('cant_row')){   
               
                $valid = false;
                $cant_row = Input::post('cant_row');
                
                for($i=1; $i<=$cant_row; $i++){
                    //if(Input::post("carga$i") == "1"){
                    //guarda los datos del cliente
                    $venta = new Ventas(); 
                    
                    if(Input::post("idcliente") != '')
                        $venta->idcliente = Input::post("idcliente");
                    else    
                        $venta->idcliente = "";
                        
                    $venta->idtipopuntoventa = Session::get('idtipopuntoventa');
                    $venta->idproducto = Input::post("idproducto$i");
                    
                    $venta->precio = Input::post("precio$i");
                     //Flash::notice(Input::post("precio$i"));
                     
                    if(Input::post("ch_efectivo") == "1")
                        $venta->efectivo = Input::post("efectivo");
                    if(Input::post("ch_ticket") == "1")
                        $venta->ticket = Input::post("ticket");
                    if(Input::post("ch_debito") == "1")
                        $venta->debito = Input::post("debito");
                    if(Input::post("ch_tc") == "1")
                        $venta->tc = Input::post("tc");
                    if(Input::post("ch_creadito_oasis") == "1")
                        $venta->creadito_oasis = Input::post("creadito_oasis");
                    
                    $venta->cant = 1;
                    $venta->subtotal = 0;
                    
                    if(substr(Input::post("idproducto$i"), 0, 1) == 'P')
                        $venta->tipo_prod_final = 'P';
                    else
                       $venta->tipo_prod_final = 'R'; 
                    
                    //
                    //$surtido->idusuario = Session::get('idusuario');

                    if($venta->create()){
                        Flash::valid("producto_$i guardado");
                    }else{
                       Flash::error("rerror guardando el producto_$i "); 
                    }
                    //}
                }
                //View::select('vista_resultado');
            }
    }
    
    public function buscar(){
        
        Flash::info('gfododfko');
        //View::template(null);
        $surtido_prod = new Ventas();
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
//                $this->Ventas_productos = $receta_prod->getRecetaProductos((int)$idreceta);
//                //$this->Ventas_productos = $receta->getRecetaProductos($idreceta);
                
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
            $surtido_prod = new Ventas();  
            
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
//                $this->Ventas_productos = $receta_prod->getRecetaProductos((int)$idreceta);
//                //$this->Ventas_productos = $receta->getRecetaProductos($idreceta);
//            }  
       }
    }
    
      
    public function buscarReceta(){
        View::template(NULL);
        $receta = new Ventas();
        $receta_prod = new RecetaProd();
        $this->existe = false;
        //$this->datos = 2; //Input::post('');
        //if(Input::hasPost('idtipoprep')){
            $idtipoprep = Input::post('idtipoprep');
            //$this->query = "select * from Ventas where idtipoprep=$idtipoprep";
                   
            
            $this->Ventas = $receta->getReceta($idtipoprep);
            if(count($this->Ventas) > 0 ) {   
                $this->existe = true;
                
                //busco los productos de la receta
                $idreceta = $receta->idreceta;
                $this->dato = $idreceta;
                
                $this->Ventas_productos = $receta_prod->getRecetaProductos((int)$idreceta);
                //$this->Ventas_productos = $receta->getRecetaProductos($idreceta);
            }
    }
    
    
//    public function edit($id = null)
//    {      
//        $this->titulo = 'Incorporaci&oacute;n de Ventas'; 
//        
//    	$Ventas = new Ventas();
//        if($id != null){
//            $Ventas = $Ventas->find((int)$id);
//        
//            if(Input::hasPost('Ventas')){
//                
//                $request = Input::post('Ventas');
//               
//                if($Ventas->update($request)){
//                  
//                    Router::redirect('Ventas/create');
//                    //se hacen persistente los datoVentas en el formulario
//                    //$this->tipodoc = $this->post('tipo_cliente');
//                } else
//                    Flash::error('Falló la Operación');
//
//
//            }else
//                $this->Ventas = $Ventas->find((int)$id);
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
        $Ventas = new Ventas();
        $this->list = $Ventas->getAll();

        return $this->list;
    }
}