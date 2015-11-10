<?php
class SaludoController extends AppController{
    public function hola($nombre){
        Load::lib('jquery4php');
        $this->fecha = date("Y-m-d H:i");
        $this->nombre = $nombre;
    }
    
}
/* 
* To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

