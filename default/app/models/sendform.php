<?php    
class SendForm {

     

    	private function reglas() {

     

    		return array(

    			'NombreCompleto' => array(

    				'required'=>array('error'=>'Indique su nombre.'),

    				'alpha' =>array('error'=>'Nombre incompleto o incorrecto.')

    			),

    			'Email' => array(

    				'required'=>array('error'=>'Indique su email.'),

    				'email' => array('error'=>'Email incorrecto.')

    			),

    			'Movil' => array(

    				'required'=>array('error'=>'Indique su teléfono / móvil.'),

    				'length' => array('min'=>'9','max'=>'17','error'=>'Teléfono / móvil incorrecto'),

    				'pattern' => array('regexp'=>'/^\+(?:[0-9] ?){6,14}[0-9]$/','error'=>'Teléfono incorrecto. Formato ejemplo. +34 862929929')

    			),

    			'Asunto' => array(

    				'required'=>array('error'=>'Indique un asunto.'),

    			),

    			'Mensaje' => array(

    				'required'=>array('error'=>'Indique un mensaje.'),

    				'length'=>array('min'=>100, 'error'=>'Si es posible, concrete más en su mensaje.'),

    			)

    		);

     

     

     

    	}

     

     

    	// Envio de datos para generar email

    	public function enviar($datos) {

     

    		$validador = new Validate($datos, $this->reglas() );

    		if (!$validador->exec()) {

    			$validador->flash();

    		} else {

     

    			// Enviar email

     

    		}     
    	}
    }

?>