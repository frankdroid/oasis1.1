<?php
Load::models('producto_prov'); 
Load::models('productos'); 
Load::models('proveedores'); // Carga modelo Proveedores
Load::models('tipo_documentos'); // carga modelo tipo de identificacion
Load::models('condicion_prov'); // carga modelo tipo_proveedores

class ProveedoresController extends AppController {
	
    public $titulo_pagina = 'Oasis Service C.A.- Proveedores'; //titulo de la pagina
	
    // funcion index
    public function index() 
    {
		
    }
    
    public function listar($page=1, $per_page=2){
        $proveedor = new Proveedores();
        $this->proveedores = $proveedor->paginate("page: $page", "per_page: $per_page");
        
    }
    
    // funcion crear proveedor
    
    public function guardarProveedor()
    {
        
    }
    public function create ()
    {
        /*if(Session::has('nombre','apellido','identificacion','direccion','telefono'))
            Session::delete('nombre','apellido','identificacion','direccion','telefono');
        */
        $this->productos = $this->getSelect();
        
        if(Input::hasPost('proveedores')){
            /**
             * se le pasa al modelo por constructor los datos del form y ActiveRecord recoge esos datos
             * y los asocia al campo correspondiente siempre y cuando se utilice la convención
             * model.campo
             */
            $proveedor = new Proveedores(Input::post('proveedores'));
            //if(Input::post('digito_rif') != '')
                $proveedor->identificacion = $proveedor->identificacion + "-" + Input::post('digito_rif');
            
            //VERIFICA SI HAY idproveedor entonces actualiza el registro
            //actualiza el registro
            //if(($proveedor->idprov != null) && ($proveedor->idproveedor != '')){
               //actualiza el registro
                if($proveedor->save()){
                     Session::set('nombre',$proveedor->nombre ." ".$proveedor->apellido);
                     Session::set('identificacion',$proveedor->identificacion);
                     Session::set('direccion',$proveedor->direccion);
                     Session::set('telefono',$proveedor->telefono);
                     
                    Flash::valid('Proveedor Actualizado con exito');
                    //$this->valor = 'thiery';
                    
                    //Router::toAction('cargaProdutos/'.$proveedor->idprov);
                    //View::render('proveedores','cargaProdutos');
                    
                }else{
                    Flash::error('Fall&oacute; la Actualizacion de proveedor');
                }
            //}
            /*else{
                //SE CREA UN REGISTRO NUEVO
                if($proveedor->create($proveedor)){
                    Flash::valid('Proveedor Registrado con exito'); 
                    
                }else{
                    Flash::error('Fall&oacute; el registro de proveedor');
                }
            }*/
        }
    }
    
    public function cargaProdutos(){
        Flash::valid($id);
    }
    
    /* function quer permite agregar un proveesor */
    public function actualizarProveedorAAAAAAA(){
        
        //View::template(null);
        //$this->valido = "false";
        //$this->valido = Input::post('idprov');
        //View::response('hola', null);
        //echo "theiriieieie";
        //if((Input::hasPost('idprov')) && (Input::post('idprov') != null) && (Input::post('idprov')) ){
        if(Session::has('idprov'))
            Session::delete ('idprov');
        
        echo var_dump($_POST);
        
        if((Input::hasPost('idprov')) && (Input::hasPost('nombre')) ){
            
            $proveedor = new Proveedores();
            //$idprov = Input::post('idprov');
            
            //$proveedor = $proveedor->find((int)$idprov);
            //$proveedor = $proveedor->find_by_idprov(1);
            $proveedor->idprov = Input::post('idprov');
            $proveedor->idtipodoc = Input::post('idtipodoc');
            $proveedor->identificacion = Input::post('identificacion');
            $proveedor->nombre = Input::post('nombre');
            $proveedor->apellido = Input::post('apellido');
            $proveedor->direccion = Input::post('direccion');
            $proveedor->telefono = Input::post('telefono');
            $proveedor->comentario = Input::post('comentario');
            $proveedor->contacto1 = Input::post('contacto1');
            $proveedor->contacto2 = Input::post('contacto2');
            $proveedor->correo1 = Input::post('correo1');
            $proveedor->correo2 = Input::post('correo2');
            $proveedor->idcondicion = Input::post('idcondicion');
            
            if(Input::post('productos')){
                $productos = Input::post('productos');
                $productos = str_split($productos);
                
            }    
            
            if($proveedor->save()){
                //guardamos los productos
                if(is_array($productos)){
                    for($i=0; $i<count($productos); $i++){
                        if((is_int((int)$productos[$i])) && ((int)$productos[$i] > 0)){
                            $producto_prov = new ProductoProv();
                            
                            //verificamos is existe
                            if(!$producto_prov->exists("idprov=".$proveedor->idprov." and idproducto=".$productos[$i]))
                            {       
                                $producto_prov->idprov = $proveedor->idprov;
                                $producto_prov->idproducto = $productos[$i];

                                //guarda el producto
                                if($producto_prov->save()){
                                    //Flash::valid('producto cargado');
                                }
                            }else{
                                Flash::error("el proveedor ya tiene el producto asociado");
                            }    
                        }
                            
                    }
                }
                
            }else{
                //$this->valido = "false";
                Flash::error("Falló el proceso de carga del proveedor");  
            }
        }else{
            Flash::error("Hay campos vacios");
        }
    }
    
    /* function quer permite agregar un proveesor */
    public function actualizarProveedor(){
        
        //View::template(null);
        //$this->valido = "false";
        //$this->valido = Input::post('idprov');
        //View::response('hola', null);
        //echo "theiriieieie";
        //if((Input::hasPost('idprov')) && (Input::post('idprov') != null) && (Input::post('idprov')) ){
        if(Session::has('idprov'))
            Session::delete ('idprov');
        
        //echo var_dump($_POST['proveedores']['idprov']);
        $request = $_POST['proveedores'];
        
        //if((Input::hasPost('proveedores_idprov')) && (Input::hasPost('proveedores_nombre')) ){
        if(Input::hasPost('proveedores')){
            $proveedor = new Proveedores();
            //$idprov = Input::post('idprov');
            
            //$proveedor = $proveedor->find((int)$idprov);
            //$proveedor = $proveedor->find_by_idprov(1);
            $proveedor->idprov = $request['idprov'];
            $proveedor->idtipodoc = $request['idtipodoc'];
            $proveedor->identificacion = $request['identificacion'];
            $proveedor->nombre = $request['nombre'];
            $proveedor->apellido = $request['apellido'];
            $proveedor->direccion = $request['direccion'];
            $proveedor->telefono = $request['telefono'];
            $proveedor->comentario = $request['comentario'];
            $proveedor->contacto1 = $request['contacto1'];
            $proveedor->contacto2 = $request['contacto2'];
            $proveedor->correo1 = $request['correo1'];
            $proveedor->correo2 = $request['correo2'];
            $proveedor->idcondicion = $request['idcondicion'];
            
            if($_POST['productos_prov']){
                $productos = $request['productos_prov'];
                $productos = str_split($productos);
                
            }    
            
            if($proveedor->save()){
                //guardamos los productos
                if(is_array($productos)){
                    for($i=0; $i<count($productos); $i++){
                        if((is_int((int)$productos[$i])) && ((int)$productos[$i] > 0)){
                            $producto_prov = new ProductoProv();
                            
                            //verificamos is existe
                            if(!$producto_prov->exists("idprov=".$proveedor->idprov." and idproducto=".$productos[$i]))
                            {       
                                $producto_prov->idprov = $proveedor->idprov;
                                $producto_prov->idproducto = $productos[$i];

                                //guarda el producto
                                if($producto_prov->save()){
                                    //Flash::valid('producto cargado');
                                }
                            }else{
                                Flash::error("el proveedor ya tiene el producto asociado");
                            }    
                        }
                            
                    }
                }
                
            }else{
                //$this->valido = "false";
                Flash::error("Falló el proceso de carga del proveedor");  
            }
        }else{
            Flash::error("Hay campos vacios");
        }
    }
    
     
    
    public function getSelect(){
        //return $this->find("columns: idproducto,tipo_cliente", "order: tipo_cliente" );
        
        $producto = new Productos();
        
        $columns = "p.idproducto, m.marca,tp.tipo_prod,p.presentacion";
        $join = 'p, marcas m, tipo_productos tp';
        $where = 'p.idmarca = m.idmarca and p.idtipoprod = tp.idtipoprod';
        
        $rs = $producto->find("columns: $columns","$where","join: $join",'order: m.marca asc');
        
       
       return $rs;
    }
    
    public function buscarProveedor(){
        View::template(null);
        $proveedor = new Proveedores();
        $this->proveedores = null;
        $this->productos_proveedor = null;
        $this->existe = 'false';
        
        //$this->datos = 'idtipodoc='.Input::post('idtipodoc') . ' identificacion='.Input::post('identificacion');
        //echo "sdsdd";
        //exit;
        
        $idtipodoc = Input::post('idtipodoc');
        $identificacion=Input::post('identificacion');
        //Flash::error('Fall&oacute; el registro de producto');
        if($proveedor->exists('idtipodoc='.$idtipodoc,'identificacion='.$identificacion))
        {
             $this->existe = 'true';
             $this->proveedores = $proveedor->getProveedor($idtipodoc, $identificacion);
             $idprov = $proveedor->idprov; 
             
             //obtener lista de los productos asociados al proveedor
             $producto_prov = new ProductoProv();
             $this->productos_proveedor = $producto_prov->getProductosProveedor($idprov,'');
             
             //$query = "Select * from proveedores where idtipodoc=".Input::post("idtipodoc")." and identificacion="."'".Input::post('identificacion')."'";
            
             //$this->proveedores = $proveedor->find_by_sql($query); 
             //$this->proveedores = $proveedor-l>find_by_identificacion(); 
        
        }
        //echo var_dump($this->proveedores);
        //View::partial('proveedores/list_tipo_proveedores');*/Input::post('identificacion')
    }
    
    public function agregarProducto(){
        View::template(null);
        $producto_prov = new ProductoProv();
        //$this->productos = '';
        $this->result = 'false';
        
        if((Input::hasPost("idprov")) || (Input::post("idprod")) || (Input::post("idprov") != '') || (Input::post("idprov") != '') )  //|| (Input::post("identificacion") != '')
        {   
            $idprov = '';
            $idprod = '';
            //$identificacion = '';
            /*
            if(Input::post("idprov") == ''){
                //buscar el id del proveedor por la identificacion 
                
            }*/
            
            
            $idprov = Session::get('idprov'); 
            //Input::post("idprov");
            $idprod = Input::post("idprod");
            $producto_prov->idproducto = $idprod;
            $producto_prov->idprov = $idprov;
            
            
            //f($cliente->exists('idtipodoc='.Input::post('idtipodoc'), 'identificacion='.Input::post('identificacion')))
            //verifica si el producto existe para este proveedor
            //$sql = "select id from producto_prov where idprov=$idprov and idproducto=$idprod";
            //$this->result = $producto_prov->count_by_sql($sql);
            //if($producto_prov->count_by_sql($sql) > 0)   
            if(!$producto_prov->exists("idprov=$idprov and idproducto=$idprod"))
            {
                //$this->result = "idprov=$idprov"."  idproducto=$idprod";
                if(!$producto_prov->create()){
                    Flash::error('Fall&oacute; el registro de producto');
                    //$result = 'false';
                }else
                    $this->result = 'true';
            }else{
                Flash::error('El proveedor ya tiene cargado este producto');
                //$result = 'false';
            }
            
            $this->producto_prov = $producto_prov->getProductosProveedor($idprov);
        }
        else{
            Flash::error('problemas');
            //solo para prueba
            //$this->producto_prov = $producto_prov->find();
        }
        
    }
    
    public function listarProductosProveedor(){
        View::template(null);
        $producto_prov = new ProductoProv();
        $identificacion = 0;
        
        //if(Input::hasPost("idprov"))
        //$idprov = Input::post("idprov");
        
        if(Input::hasPost("identificacion"))
            $identificacion = Input::post("identificacion");
            
        $this->producto_prov = $producto_prov->getProductosProveedor('',$identificacion);
    }
	
}