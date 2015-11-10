<?php

Load::models('recetas'); // carga modelo Recetas
Load::models('receta_prod'); 
Load::models('productos');
Load::models('unidades');
class RecetasController extends AppController {
	
	public $titulo_pagina = 'Oasis Service C.A.- Preparacion'; //titulo de la pagina
	
        
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
            $recetas = new Recetas();
            $this->list = $recetas->getAll($page); //getAll();
            View::template(NULL);
            
        }
	
        public function create ()
    {
        /*if(Session::has('nombre','apellido','identificacion','direccion','telefono'))
            Session::delete('nombre','apellido','identificacion','direccion','telefono');
        */
        $this->titulo = 'Incorporaci&oacute;n de Recetas'; 
        $producto = new Productos();
        $this->productos = $producto->getSelect();
        
        //$unidad = new Unidades();
        //$this->unidades = $unidad->getSelect();
        
        if(Input::hasPost('recetas') && Input::hasPost('cant_row')){
            //validaciones
            
            //se guarda los datos de la factura
            //$receta->begin();
            $valid = false;
            //$idtiprep = Input::post("idtipoprep");
            $request = Input::post('recetas');
            $idtiprep = $request['idtipoprep']; //Input::post("idtipoprep");
            $receta = new Recetas();
            /*
            if($receta->exists("idtipoprep=$idtiprep")){
              //  Flash::valid('existe');
                //return false;
                $receta = new Recetas();
                if($receta->update())
                    $valid = true;
                
            }else{
                if($receta->create())
                    $valid = true;  
            }*/
            //si se registro la receta
            //if($valid){
            if($receta->save($request)){
                //$receta->commit();
                Flash::valid('la receta se guardo con exito');
                
                //guardamos los productos
                $cant_row = Input::post('cant_row');
                for($i=1; $i<=$cant_row; $i++){
                    $receta_prod = new RecetaProd();
                    $receta_prod->id = Input::post("id$i");
                    $receta_prod->idreceta = $receta->idreceta;
                    $receta_prod->idproducto = Input::post("idproducto$i");
                    $receta_prod->minima = Input::post("minima$i");
                    $receta_prod->maxima = Input::post("maxima$i");
                    $receta_prod->idunidad = Input::post("idunidad$i");
                    
                   
                    if($receta_prod->save()){
                        //Flash::valid(var_dump($receta_prod));
                        Flash::valid("producto_$i guardado");
                    }else{
                       Flash::error("rerror guardando el producto_$i "); 
                       
                    }
                        
                }  
            }else{
                Flash::error("La receta no se guardo ");
                //$receta->rollback();
            }
        }
    }
      
    public function buscarReceta(){
        View::template(NULL);
        $receta = new Recetas();
        $receta_prod = new RecetaProd();
        $this->existe = false;
        //$this->datos = 2; //Input::post('');
        //if(Input::hasPost('idtipoprep')){
            $idtipoprep = Input::post('idtipoprep');
            //$this->query = "select * from recetas where idtipoprep=$idtipoprep";
                   
            
            $this->recetas = $receta->getReceta($idtipoprep);
            if(count($this->recetas) > 0 ) {   
                $this->existe = true;
                
                //busco los productos de la receta
                $idreceta = $receta->idreceta;
                $this->dato = $idreceta;
                
                $this->recetas_productos = $receta_prod->getRecetaProductos((int)$idreceta);
                //$this->recetas_productos = $receta->getRecetaProductos($idreceta);
            }
    }
    
    public function getUnidades(){
        View::template(NULL);
        $producto = new Productos();
        
        //Flash::info(var_dump($producto->getProductoUnidad(Input::post('idproducto'))));
                
        if(Input::hasPost('idproducto'))
            $this->unidades = $producto->getProductoUnidad(Input::post('idproducto'));     
    }
    /**
     * Edita un Registro
     */
    public function edit($id = null)
    {      
        $this->titulo = 'Incorporaci&oacute;n de Recetas'; 
        
    	$recetas = new Recetas();
        if($id != null){
            $recetas = $recetas->find((int)$id);
        
            if(Input::hasPost('recetas')){
                
                $request = Input::post('recetas');
               
                if($recetas->update($request)){
                  
                    Router::redirect('recetas/create');
                    //se hacen persistente los datoRecetas en el formulario
                    //$this->tipodoc = $this->post('tipo_cliente');
                } else
                    Flash::error('Falló la Operación');


            }else
                $this->recetas = $recetas->find((int)$id);
        }else {
            Flash::error('El id llego null');
        }
        
        //obtiene la lista
        $this->list = $this->getList();
    }
        
    //funcion borrar reistro
    public function borrar($id=null){ 
        if ($id) {
            $recetas = new Recetas();

            if (!$recetas->delete($id)) {
                Flash::error('Fallo Operacion al eliminar registro');
            }else{
                Router::redirect("recetas/create");  
            }
        } 
    }
	
    /* Esta funcion devuelve una lista de los tipos de documentos*/
    public function getList(){
        //$page=1;
        $recetas = new Recetas();
        $this->list = $recetas->getAll();

        return $this->list;
    }
}