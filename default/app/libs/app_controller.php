<?php
/**
 * @see Controller nuevo controller
 */
require_once CORE_PATH . 'kumbia/controller.php';

/**
 * Controlador principal que heredan los controladores
 *
 * Todas las controladores heredan de esta clase en un nivel superior
 * por lo tanto los metodos aqui definidos estan disponibles para
 * cualquier controlador.
 *
 * @category Kumbia
 * @package Controller
 */
class AppController extends Controller
{

	public $acl; //variable objeto ACL
	public $menu = 'menu1';
	public $userRol = ""; //variable con el rol del usuario autenticado
	protected $usuario;
	
    final protected function initialize()
    {
       // echo var_dump(Auth);
		if(!Auth::is_valid()){
			if( ($this->controller_name = 'usuarios') && ( $this->action_name != 'login') ) {	
		 		Router::redirect("usuarios/login");
			} 
		 } else {
			 	$this->usuario = Auth::get('usuario');
			 
				$this->nombre_usuario = Auth::get('nombre'); // nombre de usuario
				
				$this->userRol = Auth::get("rol"); // rol del usuario
				
				if ($this->userRol == 2) { $this->menu = 'menu2'; } //menu de usuario
		}
				
				$this->acl = new Acl(); //nuevo objeto ACL

				//Se agregan los roles
				
				$this->acl->add_role(new AclRole("")); // Visitantes
		
				$this->acl->add_role(new AclRole("1")); // Administradores
		
				$this->acl->add_role(new AclRole("2")); // Usuarios

		
				//Se agregan los recursos
		
				$this->acl->add_resource(new AclResource("index"), "index");
				$this->acl->add_resource(new AclResource("usuarios"), 'index','login','create','edit','del','logout');
				$this->acl->add_resource(new AclResource("clientes"), "index");

		
				//Se crean los permisos
		
				 // Inicio
				 
				$this->acl->allow("", "index", array("index"));
		
				$this->acl->allow("1", "index", array("index"));
				
				$this->acl->allow("2", "index", array("index"));
		
				 // Usuarios
				 
				$this->acl->allow("", "usuarios", array("index","login"));
				
				$this->acl->allow("1", "usuarios", array("index","login","logout"));
				
				$this->acl->allow("2", "usuarios", array("logout"));
		
		 
    }

    final protected function finalize()
    {
        
    }
	
	/*protected function before_filter(){

		// Verificando si el rol del usuario actual tiene permisos para la acción a ejecutar

		if(!$this->acl->is_allowed($this->userRol, $this->controller_name, $this->action_name)){

			Flash::error("Acceso negado");

			View::select('denied');
		}

	}*/

}
