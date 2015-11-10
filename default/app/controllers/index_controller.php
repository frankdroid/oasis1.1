<?php

/**
 * Controller por defecto si no se usa el routes
 * 
 */
class IndexController extends AppController
{

    public $titulo_pagina = 'Oasis Service C.A.- Inicio';
	
	protected function before_filter(){

		// Verificando si el rol del usuario actual tiene permisos para la acción a ejecutar

		if(!$this->acl->is_allowed($this->userRol, $this->controller_name, $this->action_name)){

			Flash::error("Acceso negado");

			View::select(NULL);

		}

	}
	
	public function index(){
		
	}
	
	
	
	
}
