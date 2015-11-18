<?php
Load::models('surtido_produccion'); // carga modelo SurtidoProduccion
Load::models('recetas'); 
Load::models('movimientos');
//Load::models('unidades');
class SurtidoProduccionController extends AppController {
	
	public $titulo_pagina = 'Oasis Service C.A.- Centro de Producci&oacute;n'; //titulo de la pagina
	       
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
        
	// funcion index
	public function index() 
        {
        }
	
        // funcion index
	public function lista($page=1) 
        {
            $SurtidoProduccion = new SurtidoProduccion();
            $this->list = $SurtidoProduccion->getAll($page); //getAll();
            View::template(NULL);
            
        }
	
        public function create ()
        {
            $this->titulo = 'Centro de Producci&oacute;n'; 

            $surtido_prod = new SurtidoProduccion();
            $this->recetas = $surtido_prod->getPreparaciones();

            /*
            $producto = new Productos();
            $this->productos = $producto->getSelect();
            */
            //$unidad = new Unidades();
            //$this->unidades = $unidad->getSelect();
        
            if(Input::hasPost('idreceta') && Input::hasPost('raciones')){  
				View::select('vista_resultado');          
                $valid = false;
                $cant_row = Input::post('cant_row');
                $valid = false;
                
                for($i=1; $i<=$cant_row; $i++){
                    Flash::notice(Input::post("simulado$i"));
                    
                    if(floatval (Input::post("simulado$i")) > "0"){
                        $surtido = new SurtidoProduccion(); 
                        if(Input::post("ped$i") != '')
                            $pedido = floatval (Input::post("ped$i"));
                        else
                            $pedido = floatval (Input::post("sug$i"));
                        
                            $surtido->idreceta = Input::post("idreceta");
                            $surtido->raciones = Input::post("raciones");
                            $surtido->pedido = $pedido;
                            $surtido->fecha = Input::post("fecha");
                            $surtido->entregado = floatval (Input::post("ent$i"));
                            //Flash::valid(var_dump($pedido));
                            $surtido->idproducto = Input::post("idproducto$i");
                            $surtido->idtipoprep = Input::post("idtipoprep$i");
                            //$surtido->idusuario = Session::get('idusuario');

                            if($surtido->create()){
                                Flash::valid("receta_$i guardado");
                                $valid = true;    
                            }else{
                               Flash::error("error guardando el producto_$i "); 

                            }
                            
                            
                    }else{
                       Flash::info("no se guardo el producto_$i ya que el simulado da negativo ");  
                    }
               }
               
               if($valid){
                    $movimiento = new Movimientos();       
                    $movimiento->cant_entrada = Input::post("raciones");
                    $movimiento->cant_salida = 0;
                    $movimiento->idproducto = Input::post("idtipoprep1");
                    $movimiento->origen = 'surtido_produccion';
                    
                    if($movimiento->save())
                        Flash::valid ('movimeinto guardado');
                    else
                        Flash::error ('no se guardo movimiento');

                }
                
            }
    }
    
    public function buscar(){
        
        //Flash::info('gfododfko');
        //View::template(null);
        $surtido_prod = new SurtidoProduccion();
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
//                $this->SurtidoProduccion_productos = $receta_prod->getRecetaProductos((int)$idreceta);
//                //$this->SurtidoProduccion_productos = $receta->getRecetaProductos($idreceta);
                
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
            $surtido_prod = new SurtidoProduccion();  
            
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
//                $this->SurtidoProduccion_productos = $receta_prod->getRecetaProductos((int)$idreceta);
//                //$this->SurtidoProduccion_productos = $receta->getRecetaProductos($idreceta);
//            }  
       }
    }
    
      
    public function buscarReceta(){
        View::template(NULL);
        $receta = new SurtidoProduccion();
        $receta_prod = new RecetaProd();
        $this->existe = false;
        //$this->datos = 2; //Input::post('');
        //if(Input::hasPost('idtipoprep')){
            $idtipoprep = Input::post('idtipoprep');
            //$this->query = "select * from SurtidoProduccion where idtipoprep=$idtipoprep";
                   
            
            $this->SurtidoProduccion = $receta->getReceta($idtipoprep);
            if(count($this->SurtidoProduccion) > 0 ) {   
                $this->existe = true;
                
                //busco los productos de la receta
                $idreceta = $receta->idreceta;
                $this->dato = $idreceta;
                
                $this->SurtidoProduccion_productos = $receta_prod->getRecetaProductos((int)$idreceta);
                //$this->SurtidoProduccion_productos = $receta->getRecetaProductos($idreceta);
            }
    }
    
    
//    public function edit($id = null)
//    {      
//        $this->titulo = 'Incorporaci&oacute;n de SurtidoProduccion'; 
//        
//    	$SurtidoProduccion = new SurtidoProduccion();
//        if($id != null){
//            $SurtidoProduccion = $SurtidoProduccion->find((int)$id);
//        
//            if(Input::hasPost('SurtidoProduccion')){
//                
//                $request = Input::post('SurtidoProduccion');
//               
//                if($SurtidoProduccion->update($request)){
//                  
//                    Router::redirect('SurtidoProduccion/create');
//                    //se hacen persistente los datoSurtidoProduccion en el formulario
//                    //$this->tipodoc = $this->post('tipo_cliente');
//                } else
//                    Flash::error('Falló la Operación');
//
//
//            }else
//                $this->SurtidoProduccion = $SurtidoProduccion->find((int)$id);
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
        $SurtidoProduccion = new SurtidoProduccion();
        $this->list = $SurtidoProduccion->getAll();

        return $this->list;
    }
}