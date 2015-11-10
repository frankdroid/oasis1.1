<?php

Load::models('clientes'); // Carga modelo Clientes
Load::models('tipo_documentos'); // carga modelo tipo de identificacion
Load::models('tipo_clientes'); // carga modelo tipo_clientes

class ClientesController extends AppController {
	
	public $titulo_pagina = 'Oasis Service C.A.- Clientes'; //titulo de la pagina
	
	// funcion index
	public function index() 
    {
		
    }
    
    public function listar($page=1, $per_page=2){
        $cliente = new Clientes();
        $this->clientes = $cliente->paginate("page: $page", "per_page: $per_page");
        
    }
    
    // funcion crear cliente
    
    public function create ()
    {
        if(Input::hasPost('clientes')){
            /**
             * se le pasa al modelo por constructor los datos del form y ActiveRecord recoge esos datos
             * y los asocia al campo correspondiente siempre y cuando se utilice la convención
             * model.campo
             */
            $cliente = new Clientes(Input::post('clientes'));
            if(Input::post('digito_rif') != '')
                $cliente->identificacion = $cliente->identificacion + "-" + Input::post('digito_rif');
            
            //VERIFICA SI HAY idcliente entonces actualiza el registro
            //actualiza el registro
            if($cliente->save()){
                Flash::valid('Cliente Actualizado con exito');

            }else{
                Flash::error('Fall&oacute; la Actualizacion de cliente');
            }
            /*if(($cliente->idcliente != null) && ($cliente->idcliente != '')){
               //actualiza el registro
                if($cliente->update($cliente)){
                    Flash::valid('Cliente Actualizado con exito');
                    
                }else{
                    Flash::error('Fall&oacute; la Actualizacion de cliente');
                }
            }else{
                //SE CREA UN REGISTRO NUEVO
                if($cliente->create($cliente)){
                    Flash::valid('Cliente Registrado con exito'); 
                    
                }else{
                    Flash::error('Fall&oacute; el registro de cliente');
                }
            }*/
            
            /*
            //En caso que falle la operación de guardar
            if($cliente->create()){
                Flash::valid('Operaci&oacute;n exitosa');
                //Eliminamos el POST, si no queremos que se vean en el form
                //Input::delete();
                //return;               
            }else{
                Flash::error('Fall&oacute; Operaci&oacute;n');
            }*/
        }
        
        //View::partial('clientes/list_tipo_clientes');
    }
	/*
    public function buscarcliente($cedula) {
		
            View::template(NULL); // se carga sin template
            Load::models('clientes');  // se carga el modelo de clientes

            $this->msg = "";
            $cliente = new Clientes();
            if($cliente->exists("identificacion=$cedula")) {
                    $this->clientes = $cliente->Buscar($cedula);
            } else {
                    $this->msg = "Cliente no existe";
            }
		
	}
*/
    public function buscarCliente(){
        View::template(null);
        $cliente = new Clientes();
        $this->clientes = '';
        $this->existe = false;
        if($cliente->exists('idtipodoc='.Input::post('idtipodoc'), 'identificacion='.Input::post('identificacion')))
        {
             $this->existe = true;
             $query = "Select * from clientes where idtipodoc=".Input::post("idtipodoc")." and identificacion="."'".Input::post('identificacion')."'";
             
             $this->clientes = $cliente->find_by_sql($query); 
             //$this->clientes = $cliente-l>find_by_identificacion(); 
        
        }
        //View::partial('clientes/list_tipo_clientes');*/Input::post('identificacion')
    }
	
	
	
	//funcion identificacion
	public function identificacion() 
	{
		// se obtienen los documentos registrados
		$docs = new Identificacion();
		$this->listaDocs = $docs->Todos();
	
         // Se verifica si el usuario envio el form (submit) 
        if(Input::hasPost('tipo_doc')){
			
			$tipo_doc = Input::post('tipo_doc');
			$descripcion = Input::post('descripcion');
			$prefijo = Input::post('prefijo');
			$comentario = Input::post('comentario');
 			$creado_por = $this->usuario;
            
			$identificacion = new Identificacion();
			
            // se verifica la operación
            if($identificacion->Crear($tipo_doc,$descripcion,$prefijo,$comentario,$creado_por)) 
			{
                Flash::valid('Operación exitosa');
                // recarga la pagina para cargar resultados
				Router::redirect("clientes/tipos");               
            } else {
                Flash::error('Falló Operación');
            }
        }
	}
	
	
	
	
	// funcion tipos de clientes
	public function tipos()
	{
            
            echo "<h2> sdsdsdsdsdsdsddsddsddsdsddsd </h2>";
            
            // se obtienen los documentos registrados
            //$tipocliente = new TipoClientes)(;
            $this->listaTipos = $tipocliente->Todos();
    
            // Se verifica si el usuario envio el form (submit) 
            if(Input::hasPost('tipo_clientes')){
		/*	
                $tipo_cliente = Input::post('tipo_cliente');
                $descripcion = Input::post('descripcion');
                $prefijo = Input::post('prefijo');
                $iva = Input::post('iva');
                $suplemento = Input::post('spto');
                $descuento = Input::post('dcto');
                $comentario = Input::post('comentario');
                 * 
                 */
                //$creado_por = $this->usuario;

			
            // se verifica la operación
            if($tipocliente->Crear($tipo_cliente,$descripcion,$prefijo,$iva,$suplemento,$descuento,$comentario,$creado_por)) 
            {
                Flash::valid('Operación exitosa');
                // recarga la pagina para cargar resultados
                Router::redirect("clientes/tipos");
              
            } else {
                Flash::error('Falló Operación');
            }
        }
	}
	
	
	
	//funcion condicion de pago
	public function cond_pago()
	{
		
		
	}




	
	
	
}