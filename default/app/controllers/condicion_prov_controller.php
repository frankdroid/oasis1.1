<?php

Load::models('condicion_prov'); // carga modelo condicion_prov

class CondicionProvController extends AppController {
	
	public $titulo_pagina = 'Oasis Service C.A.- Proveedores'; //titulo de la pagina
	
        
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
            $condicion = new CondicionProv();
            $this->list = $condicion->getAll($page); //getAll();
            View::template(NULL);
            
        }
	
	//funcion identificacion
	public function create() 
	{ 
            $this->titulo = 'Registro de Tipo de Condici&oacute;n para Proveedores'; 
            
            if(Input::hasPost('condicion_prov')){	
                
                $condicion = new CondicionProv(Input::post('condicion_prov'));
                //echo var_dump($condicion);
                
                if($condicion->create()){
                    Flash::valid('Operación exitosa');
                    //recarga la pagina para cargar resultados
                    Router::redirect("condicion_prov/create");               
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
        $this->titulo = 'Incorporaci&oacute;n de CondicionProv'; 
        
    	$condicion = new CondicionProv();
        if($id != null){
            $condicion = $condicion->find((int)$id);
        
            if(Input::hasPost('condicion_prov')){
                
                $request = Input::post('condicion_prov');
               
                if($condicion->update($request)){
                  
                    Router::redirect('condicion_prov/create');
                    //se hacen persistente los datocondicion_prov en el formulario
                    //$this->tipodoc = $this->post('tipo_cliente');
                } else
                    Flash::error('Falló la Operación');


            }else
                $this->condicion_prov = $condicion->find((int)$id);
        }else {
            Flash::error('El id llego null');
        }
        
        //obtiene la lista
        $this->list = $this->getList();
    }
        
    //funcion borrar reistro
    public function borrar($id=null){ 
        if ($id) {
            $condicion = new CondicionProv();

            if (!$condicion->delete($id)) {
                Flash::error('Fallo Operacion al eliminar registro');
            }else{
                Router::redirect("condicion_prov/create");  
            }
        } 
    }
	
    /* Esta funcion devuelve una lista de los tipos de documentos*/
    public function getList(){
        //$page=1;
        $condicion = new CondicionProv();
        $this->list = $condicion->getAll();

        return $this->list;
    }
}