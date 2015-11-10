<?php

Load::models('tipo_documentos'); // carga modelo tipo_clientes

class TiposDocumentosController extends AppController {
	
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
            $tipoDocumentos = new TipoDocumentos();
            $this->list = $tipoDocumentos->getAll($page); //getAll();
            View::template(NULL);
            
        }
	
	//funcion identificacion
	public function create() 
	{ 
            //echo var_dump(Input::);
            
            //echo var_dump(Input::hasPost('tipo_doc'));
            /*if(Input::hasPost('tipo_documentos')){
                echo "oasloaslasl";
            }*/
            
            if(Input::hasPost('tipo_doc')){	
                $tipo_doc = Input::post('tipo_doc');
                $descripcion = Input::post('descripcion');
                $identificador = Input::post('identificador');
                $comentario = Input::post('comentario');
                $creado_por = $this->usuario;

                $tipoDoc = new TipoDocumentos();
                
                // se verifica la operación
                if(!$tipoDoc->isExist($tipo_doc))
                {
                    if($tipoDoc->Crear($tipo_doc,$descripcion,$identificador,$comentario,$creado_por)) 
                    {
                        Flash::valid('Operación exitosa');
                        // recarga la pagina para cargar resultados
                        Router::redirect("tipos_documentos/create");               
                    } else {
                        Flash::error('Falló la Operación');
                    }
                }else{
                    Flash::error('El tipo de documento ya existe');
                }    
                
            } 
            
            $this->list = $this->getList();
            
	}
        
        /**
     * Edita un Registro
     */
    public function edit($id = null)
    {
        
    	$tipoDoc = new TipoDocumentos();
        
        
        if(Input::hasPost('tipodoc')){
            $tipo_doc = Input::post('tipo_doc');
            /*
            $descripcion = Input::post('descripcion');
            $identificador = Input::post('identificador');
            $comentario = Input::post('comentario');*/
            //$creado_por = $this->usuario;
            //echo "asass";
            
            if(!$tipoDoc->isExist($tipo_doc))
            {
                    if(!$tipoDoc->update(Input::post('tipodoc'))){
                        Flash::error('Falló la Operación');
                        //se hacen persistente los datotipo_docs en el formulario
                        //$this->tipodoc = $this->post('tipo_doc');
                    } else{
                        Router::redirect('tipos_documentos/create');
                    }
            }else{
                Flash::error('El tipo de documento ya existe');
            } 
        }else
            $this->tipodoc = $tipoDoc->find((int)$id);
        //la lista
        $this->list = $this->getList();
    }
    
     public function edit1($id)
    {
        $menu = new Menus();
 
        //se verifica si se ha enviado el formulario (submit)
        if(Input::hasPost('menus')){
 
            if($menu->update(Input::post('menus'))){
                 Flash::valid('Operación exitosa');
                //enrutando por defecto al index del controller
                return Redirect::to();
            } else {
                Flash::error('Falló Operación');
            }
        } else {
            //Aplicando la autocarga de objeto, para comenzar la edición
            $this->menus = $menu->find_by_id((int)$id);
        }
    }

        
        //controlador para la funcion borrar
        public function borrar($id=null){ 
            if ($id) {
                $tipoDoc = new TipoDocumentos();
                
                if (!$tipoDoc->delete($id)) {
                    Flash::error('Fallo Operacion');
                }else{
                    Router::redirect("tipos_documentos/create"); 
                    /*
                    $this->list = getList; //$tipoDoc->paginar(1);
                    $this->set_response('view');
                     * */
                     
                }
            } 
        }
	
	/* Esta funcion devuelve una lista de los tipos de documentos*/
        public function getList(){
            //$page=1;
            $tipoDocumentos = new TipoDocumentos();
            $this->list = $tipoDocumentos->getAll();
            
            return $this->list;
        }
	
	// funcion tipos de clientes
	public function tipos()
	{
		// se obtienen los documentos registrados
		$tipocliente = new Tipo_clientes();
		$this->listaTipos = $tipocliente->Todos();
	
         // Se verifica si el usuario envio el form (submit) 
        if(Input::hasPost('tipo_cliente')){
			
			$tipo_cliente = Input::post('tipo_cliente');
			$descripcion = Input::post('descripcion');
			$identificador = Input::post('identificador');
			$iva = Input::post('iva');
			$suplemento = Input::post('spto');
			$descuento = Input::post('dcto');
			$comentario = Input::post('comentario');
 			$creado_por = $this->usuario;

			
            // se verifica la operación
            if($tipocliente->Crear($tipo_cliente,$descripcion,$identificador,$iva,$suplemento,$descuento,$comentario,$creado_por)) 
			{
                Flash::valid('Operación exitosa');
				// recarga la pagina para cargar resultados
				Router::redirect("clientes/tipos");
              
            } else {
                Flash::error('Falló Operación');
            }
        }
	}
	
	
	
	//verifica si un valor existe de acuerdo al campo
        public function isExist($key, $value){
            
        }



	
}