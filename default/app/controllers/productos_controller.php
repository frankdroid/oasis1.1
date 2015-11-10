<?php

Load::models('productos'); // carga modelo productos

class ProductosController extends AppController {
	
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
            $productos = new Productos();
            $this->list = $productos->getAll($page); //getAll();
            View::template(NULL);
            
        }
	
	//funcion identificacion
	public function create() 
	{ 
            $this->titulo = 'Incorporaci&oacute;n de Productos'; 
            
            if(Input::hasPost('productos')){	
                
                $productos = new Productos(Input::post('productos'));
                //echo var_dump($productos);
                //$prod = $item->marca."/".$item->tipo_prod."/".$item->presentacion;
                
                if($productos->create()){
                    Flash::valid('Operación exitosa');
                    //recarga la pagina para cargar resultados
                    Router::redirect("productos/create");               
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
        $this->titulo = 'Incorporaci&oacute;n de Productos'; 
        
    	$productos = new Productos();
        if($id != null){
            $productos = $productos->find((int)$id);
        
            if(Input::hasPost('productos')){
                
                $request = Input::post('productos');
               
                if($productos->update($request)){
                  
                    Router::redirect('productos/create');
                    //se hacen persistente los datoproductos en el formulario
                    //$this->tipodoc = $this->post('tipo_cliente');
                } else
                    Flash::error('Falló la Operación');


            }else
                $this->productos = $productos->find((int)$id);
        }else {
            Flash::error('El id llego null');
        }
        
        //obtiene la lista
        $this->list = $this->getList();
    }
        
    //funcion borrar reistro
    public function borrar($id=null){ 
        if ($id) {
            $productos = new Productos();

            if (!$productos->delete($id)) {
                Flash::error('Fallo Operacion al eliminar registro');
            }else{
                Router::redirect("productos/create");  
            }
        } 
    }
	
    
    
    /* Esta funcion devuelve una lista de los tipos de documentos*/
    public function getList(){
        //$page=1;
        $productos = new Productos();
        $this->list = $productos->getAll();

        return $this->list;
    }
}