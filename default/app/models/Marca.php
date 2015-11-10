<?php
class Marca extends ActiveRecord {

//retorna un array de objetos cuyos campos son los mismos de la tabla Marca
//$page : es el numero o indice de pagina
//$ppage: es el numero de filas o registro por pagina

public function paginar($page, $ppage=10){
//order: permite especificar el campor por el cual se quiere se ordene el resultado
return $this->paginate("order: 2 ASC", "page: $page", "per_page: $ppage");
}

/*
retorna todos los elementos de la tabla ordenados por el campo de ordinal 2, en este caso nombre
*/
public function listar(){
return $this->find("order: 2 asc");
}

}

?>