<?php
//carga el modelo Marca
//public $models=array('marca');
Load::models('marca'); // carga modelo productos


class MarcaController extends AppController {



//controlador para la pagina index
public function index($page=1){
	$marca = new Marca();

	$this->marcas = $marca->paginar($page);
}

//controlador para la funcion crear
public function crear(){
//if($this->has_post('marca')){
if (Input::hasPost('marca')){

$marca = new Marca(Input::post('marca'));
if(!$marca->save()){
Flash::error('Fall� Operaci�n');
$this->marca = $this->post('marca');
}else{
Flash::success('Operaci�n exitosa');
}
}

}

//controlador para la funcion editar
public function editar($id = null){
if($id != null){
$obj_marca = new Marca();

$marca = $obj_marca->find($id);
}
if(Input::hasPost('marca')){
if(!$marca->update($this->post('marca'))){
Flash::error('Fall� Operaci�n');
$marca = $this->post('marca');
}else{
Router::route_to('action: index');
}
}
}

//controlador para la funcion borrar
public function borrar($id=null){ 
if ($id) {
if (!$this->Marca->delete($id)) {
Flash::error('Fall� Operaci�n');
}else{
$this->marcas=$this->Marca->paginar(1);
$this->set_response('view');
}
} 
}

//controlador para la funcion listar
public function listar($page=1){
    $this->marcas=$this->Marca->paginar($page);
}

}

?>