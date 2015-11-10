<?php

Load::models('tipo_clientes'); // carga modelo tipo_clientes

class TiposClientesController extends AppController {
	
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
            $tipo_clientesumentos = new TipoDocumentos();
            $this->list = $tipo_clientesumentos->getAll($page); //getAll();
            View::template(NULL);
            
        }
	
	//funcion identificacion
	public function create() 
	{ 
            if(Input::hasPost('tipo_clientes')){	
                
                $tipo_clientes = new TipoClientes(Input::post('tipo_clientes'));
                
                if($tipo_clientes->iva == '')
                    $tipo_clientes->iva = '0';
                
                if($tipo_clientes->suplemento == '')
                    $tipo_clientes->suplemento = '0';
                
                if($tipo_clientes->descuento == '')
                    $tipo_clientes->descuento = '0';
                
                if($tipo_clientes->create()){
                    Flash::valid('Operación exitosa');
                    //recarga la pagina para cargar resultados
                    Router::redirect("tipos_clientes/create");               
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
    	$tipo_clientes = new TipoClientes();
        if($id != null){
            $tipo_clientes = $tipo_clientes->find((int)$id);
        
            if(Input::hasPost('tipo_clientes')){
                
                $request = Input::post('tipo_clientes');
               
                if((isset($request['iva']) && ($request['iva'] == '')))
                        $request['iva'] = '0';
                
                if((isset($request['suplemento']) && ($request['suplemento'] == '')))
                        $request['suplemento'] = '0';
                
                if((isset($request['descuento']) && ($request['descuento'] == '')))
                        $request['descuento'] = '0';

                if($tipo_clientes->update($request)){
                  
                    Router::redirect('tipos_clientes/create');
                    //se hacen persistente los datotipo_clientes en el formulario
                    //$this->tipodoc = $this->post('tipo_cliente');
                } else
                    Flash::error('Falló la Operación');


            }else
                $this->tipo_clientes = $tipo_clientes->find((int)$id);
        }else {
            Flash::error('El id llego null');
        }
        
        //obtiene la lista
        $this->list = $this->getList();
    }
        
    //funcion borrar reistro
    public function borrar($id=null){ 
        if ($id) {
            $tipo_clientes = new TipoClientes();

            if (!$tipo_clientes->delete($id)) {
                Flash::error('Fallo Operacion al eliminar registro');
            }else{
                Router::redirect("tipos_clientes/create");  
            }
        } 
    }
	
    /* Esta funcion devuelve una lista de los tipos de documentos*/
    public function getList(){
        //$page=1;
        $tipocliente = new TipoClientes();
        $this->list = $tipocliente->getAll();

        return $this->list;
    }
}