<?php

Load::models('marcas'); // carga modelo marcas

class MarcasController extends AppController {
	
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
            $marcas = new Marcas();
            $this->list = $marcas->getAll($page); //getAll();
            View::template(NULL);
            
        }
	
	//funcion identificacion
	public function create() 
	{ 
            $this->titulo = 'Incorporaci&oacute;n de Marcas'; 
            
            if(Input::hasPost('marcas')){	
                
                $marcas = new Marcas(Input::post('marcas'));
                //echo var_dump($marcas);
                
                if($marcas->create()){
                    Flash::valid('Operación exitosa');
                    //recarga la pagina para cargar resultados
                    Router::redirect("marcas/create");               
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
        $this->titulo = 'Incorporaci&oacute;n de Marcas'; 
        
    	$marcas = new Marcas();
        if($id != null){
            $marcas = $marcas->find((int)$id);
        
            if(Input::hasPost('marcas')){
                
                $request = Input::post('marcas');
               
                if($marcas->update($request)){
                  
                    Router::redirect('marcas/create');
                    //se hacen persistente los datomarcas en el formulario
                    //$this->tipodoc = $this->post('tipo_cliente');
                } else
                    Flash::error('Falló la Operación');


            }else
                $this->marcas = $marcas->find((int)$id);
        }else {
            Flash::error('El id llego null');
        }
        
        //obtiene la lista
        $this->list = $this->getList();
    }
        
    //funcion borrar reistro
    public function borrar($id=null){ 
        if ($id) {
            $marcas = new Marcas();

            if (!$marcas->delete($id)) {
                Flash::error('Fallo Operacion al eliminar registro');
            }else{
                Router::redirect("marcas/create");  
            }
        } 
    }
	
    /* Esta funcion devuelve una lista de los tipos de documentos*/
    public function getList(){
        //$page=1;
        $marcas = new Marcas();
        $this->list = $marcas->getAll();

        return $this->list;
    }
}