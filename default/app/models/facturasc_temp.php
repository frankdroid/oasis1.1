<?php
class Facturasc_temp extends ActiveRecord{
	
	public function Todos()
		{
	
			return $this->paginate();
	
		}
}
?>
