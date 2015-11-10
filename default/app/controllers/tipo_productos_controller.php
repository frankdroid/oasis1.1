<?php

Load::models('tipo_productos'); // carga modelo tipo_productos

class TipoProductosController extends AppController {
	
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
            $tipo_productos = new TipoProductos();
            $this->list = $tipo_productos->getAll($page); //getAll();
            View::template(NULL);
            
        }
	
	//funcion identificacion
	public function create() 
	{ 
            $this->titulo = 'Incorporaci&oacute;n de Tipo de Productos'; 
            
            if(Input::hasPost('tipo_productos')){	
                
                $tipo_productos = new TipoProductos(Input::post('tipo_productos'));
                //echo var_dump($tipo_productos);
                
                if($tipo_productos->create()){
                    Flash::valid('Operación exitosa');
                    //recarga la pagina para cargar resultados
                    Router::redirect("tipo_productos/create");               
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
        $this->titulo = 'Incorporaci&oacute;n de TipoProductos'; 
        
    	$tipo_productos = new TipoProductos();
        if($id != null){
            $tipo_productos = $tipo_productos->find((int)$id);
        
            if(Input::hasPost('tipo_productos')){
                
                $request = Input::post('tipo_productos');
               
                if($tipo_productos->update($request)){
                  
                    Router::redirect('tipo_productos/create');
                    //se hacen persistente los datotipo_productos en el formulario
                    //$this->tipodoc = $this->post('tipo_cliente');
                } else
                    Flash::error('Falló la Operación');


            }else
                $this->tipo_productos = $tipo_productos->find((int)$id);
        }else {
            Flash::error('El id llego null');
        }
        
        //obtiene la lista
        $this->list = $this->getList();
    }
        
    //funcion borrar reistro
    public function borrar($id=null){ 
        if ($id) {
            $tipo_productos = new TipoProductos();

            if (!$tipo_productos->delete($id)) {
                Flash::error('Fallo Operacion al eliminar registro');
            }else{
                Router::redirect("tipo_productos/create");  
            }
        } 
    }
	
    /* Esta funcion devuelve una lista de los tipos de documentos*/
    public function getList(){
        //$page=1;
        $tipo_productos = new TipoProductos();
        $this->list = $tipo_productos->getAll();

        return $this->list;
    }
}