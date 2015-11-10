<?php

Load::models('unidades'); // carga modelo unidades

class UnidadesController extends AppController {
	
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
            $unidades = new Unidades();
            $this->list = $unidades->getAll($page); //getAll();
            View::template(NULL);
            
        }
	
	//funcion identificacion
	public function create() 
	{ 
            $this->titulo = 'Incorporaci&oacute;n de Unidades de Medida'; 
            
            if(Input::hasPost('unidades')){	
                
                $unidades = new Unidades(Input::post('unidades'));
                //echo var_dump($unidades);
                
                if($unidades->create()){
                    Flash::valid('Operación exitosa');
                    //recarga la pagina para cargar resultados
                    Router::redirect("unidades/create");               
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
        $this->titulo = 'Incorporaci&oacute;n de Unidades'; 
        
    	$unidades = new Unidades();
        if($id != null){
            $unidades = $unidades->find((int)$id);
        
            if(Input::hasPost('unidades')){
                
                $request = Input::post('unidades');
               
                if($unidades->update($request)){
                  
                    Router::redirect('unidades/create');
                    //se hacen persistente los datounidades en el formulario
                    //$this->tipodoc = $this->post('tipo_cliente');
                } else
                    Flash::error('Falló la Operación');


            }else
                $this->unidades = $unidades->find((int)$id);
        }else {
            Flash::error('El id llego null');
        }
        
        //obtiene la lista
        $this->list = $this->getList();
    }
        
    //funcion borrar reistro
    public function borrar($id=null){ 
        if ($id) {
            $unidades = new Unidades();

            if (!$unidades->delete($id)) {
                Flash::error('Fallo Operacion al eliminar registro');
            }else{
                Router::redirect("unidades/create");  
            }
        } 
    }
	
    /* Esta funcion devuelve una lista de los tipos de documentos*/
    public function getList(){
        //$page=1;
        $unidades = new Unidades();
        $this->list = $unidades->getAll();

        return $this->list;
    }
}