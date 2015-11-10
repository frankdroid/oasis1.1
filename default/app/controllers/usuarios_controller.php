<?php

Load::models('usuarios'); // Carga modelo Usuarios
 
class UsuariosController extends AppController
{

    public $titulo_pagina = 'Oasis Service C.A.- Usuarios'; //titulo de la pagina
	
	public function index($page=1) 
    {
        $usuario = new Usuarios();
        $this->listaUsuarios = $usuario->ver($page);
    }
 
    /**
     * Crea un Registro
     */
    public function create ()
    {
        /**
         * Se verifica si el usuario envio el form (submit) y si ademas 
         * dentro del array POST existe uno llamado "menus"
         * el cual aplica la autocarga de objeto para guardar los 
         * datos enviado por POST utilizando autocarga de objeto
         */
        if(Input::hasPost('usuarios')){
            /**
             * se le pasa al modelo por constructor los datos del form y ActiveRecord recoge esos datos
             * y los asocia al campo correspondiente siempre y cuando se utilice la convención
             * model.campo
             */
            $usuario = new Usuarios(Input::post('usuarios'));
            //En caso que falle la operación de guardar
            if($usuario->create()){
                Flash::valid('Operación exitosa');
                //Eliminamos el POST, si no queremos que se vean en el form
                Input::delete();
                return;               
            }else{
                Flash::error('Falló Operación');
            }
        }
    }
 
    /**
     * Edita un Registro
     *
     * @param int $id (requerido)
     */
    public function edit($id)
    {
        $usuario = new Usuarios();
 
        //se verifica si se ha enviado el formulario (submit)
        if(Input::hasPost('usuarios')){
 
            if($menu->update(Input::post('usuarios'))){
                 Flash::valid('Operación exitosa');
                //enrutando por defecto al index del controller
                return Redirect::to();
            } else {
                Flash::error('Falló Operación');
            }
        } else {
            //Aplicando la autocarga de objeto, para comenzar la edición
            $this->usuarios = $usuario->find_by_id((int)$id);
        }
    }
 
    /**
     * Eliminar un menu
     * 
     * @param int $id (requerido)
     */
    public function del($id)
    {
        $usuario = new Usuarios();
        if ($usuario->delete((int)$id)) {
                Flash::valid('Operación exitosa');
        }else{
                Flash::error('Falló Operación'); 
        }
 
        //enrutando por defecto al index del controller
        return Redirect::to();
    }
	
	public function login()
    {
		View::template('defaultsm');
        if (Input::hasPost("usuario","password")){
				$pwd = Input::post("password");
				$usuario=Input::post("usuario");
	 
				$auth = new Auth("model", "class: usuarios", "usuario: $usuario", "password: $pwd");
				if ($auth->authenticate()) {
					$this->menu = 'menu';
					Router::redirect("index/index");
				} else {
					Flash::error("Falló");
				}
			}
    }
	
	public function logout() {
		View::template('defaultsm');
		Auth::destroy_identity();
	}
	
	
}
