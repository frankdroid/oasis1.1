<?php

Load::models('condicion_pago'); // carga modelo CondicionPago

class CondicionPagoController extends AppController {
	
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
            $condicionPago = new CondicionPago();
            $this->list = $condicionPago->getAll($page); //getAll();
            View::template(NULL);
            
        }
	
	//funcion identificacion
	public function create() 
	{ 
            $this->titulo = 'Incorporaci&oacute;n de Condición Pago'; 
            
            if(Input::hasPost('condicionPago')){	
                
                $condicionPago = new CondicionPago(Input::post('condicionPago'));
                //echo var_dump($condicionPago);
                
                if($condicionPago->create()){
                    Flash::valid('Operación exitosa');
                    //recarga la pagina para cargar resultados
                    Router::redirect("condicion_pago/create");               
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
        $this->titulo = 'Incorporaci&oacute;n de Condicion Pago';
        
    	$condicionPago = new CondicionPago();
        if($id != null){
            $condicionPago = $condicionPago->find((int)$id);
        
            if(Input::hasPost('condicionPago')){
                
                $request = Input::post('condicionPago');
               
                if($condicionPago->update($request)){
                  
                    Router::redirect('condicion_pago/create');
                    //se hacen persistente los datoCondicionPago en el formulario
                    //$this->tipodoc = $this->post('tipo_cliente');
                } else
                    Flash::error('Falló la Operación');


            }else
                $this->condicionPago = $condicionPago->find((int)$id);
        }else {
            Flash::error('El id llego null');
        }
        
        //obtiene la lista
        $this->list = $this->getList();
    }
        
    //funcion borrar reistro
    public function borrar($id=null){ 
        if ($id) {
            $condicionPago = new CondicionPago();

            if (!$condicionPago->delete($id)) {
                Flash::error('Fallo Operacion al eliminar registro');
            }else{
                Router::redirect("condicion_pago/create");  
            }
        } 
    }
	
    /* Esta funcion devuelve una lista de los tipos de documentos*/
    public function getList(){
        //$page=1;
        $condicionPago = new CondicionPago();
        $this->list = $condicionPago->getAll();

        return $this->list;
    }
}