<?php

Load::models('tipo_preparacion'); // carga modelo 

class TipoPreparacionController extends AppController {
	
	public $titulo_pagina = 'Oasis Service C.A.- Clientes'; //titulo de la pagina
	
        
        public function before_filter(){
            /*if(Session::get('usuario') == false){
                Flash::error('Para poder acceder a los Modulos, debe primero iniciar una sesion.');
                $this->route_to("controller: usuarios", "action: login");
            }*/
        }
        
	// funcion index
	public function index() 
        {
        }
	
        // funcion index
	public function lista($page=1) 
        {
            $tipo_preparacion = new TipoPreparacion();
            $this->list = $tipo_preparacion->getAll($page); //getAll();
            View::template(NULL);
            
        }
	
	//funcion identificacion
	public function create() 
	{ 
            $this->titulo = 'Incorporaci&oacute;n de Tipo de Preparaci&oacute;n'; 
            
            if(Input::hasPost('tipo_preparacion')){	
                
                $tipo_preparacion = new TipoPreparacion(Input::post('tipo_preparacion'));
                //echo var_dump($tipo_preparacion);
                
                if($tipo_preparacion->create()){
                    Flash::valid('Operación exitosa');
                    //recarga la pagina para cargar resultados
                    Router::redirect("tipo_preparacion/create");               
                } else {
                    Flash::error('Falló la Operación');
                }                
            } 
            
            $this->list = $this->getList();
            
	}
        
        /**
     * Edita un Registro
     */
    public function edit($id = null)
    {      
        $this->titulo = 'Incorporaci&oacute;n de Tipo de Preparaci&oacute;n'; 
        
    	$tipo_preparacion = new TipoPreparacion();
        if($id != null){
            $tipo_preparacion = $tipo_preparacion->find((int)$id);
        
            if(Input::hasPost('tipo_preparacion')){
                
                $request = Input::post('tipo_preparacion');
               
                if($tipo_preparacion->update($request)){
                  
                    Router::redirect('tipo_preparacion/create');
                    //se hacen persistente los datotipo_preparacion en el formulario
                    //$this->tipodoc = $this->post('tipo_cliente');
                } else
                    Flash::error('Falló la Operación');


            }else
                $this->tipo_preparacion = $tipo_preparacion->find((int)$id);
        }else {
            Flash::error('El id llego null');
        }
        
        //obtiene la lista
        $this->list = $this->getList();
    }
        
    //funcion borrar reistro
    public function borrar($id=null){ 
        if ($id) {
            $tipo_preparacion = new TipoPreparacion();

            if (!$tipo_preparacion->delete($id)) {
                Flash::error('Fallo Operacion al eliminar registro');
            }else{
                Router::redirect("tipo_preparacion/create");  
            }
        } 
    }
	
    /* Esta funcion devuelve una lista de los tipos de documentos*/
    public function getList(){
        //$page=1;
        $tipo_preparacion = new TipoPreparacion();
        $this->list = $tipo_preparacion->getAll();

        return $this->list;
    }
}