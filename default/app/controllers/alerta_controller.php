<?php
//CRUD de alertas

Load::models('alertas');

class alertaController extends AppController{
	protected function before_filter(){
		$this->aside = null;
		$this->siteTitle = "Sistema de alertas contra la Libre Expresión en Honduras";
		$this->fecha_in = date("Y-m-d H:i");
		$this->fecha_at = date("Y-m-d H:i");
	}

	public function listado(){ //adminController
		view::template('backend');
		$this->alertas = Load::model('alertas')->find();
		$this->i = 1;
	}

	public function callbacks($est, $id){ //adminController
    	$this->id = $id;
    	if($est == 1):	
    		$this->est = 1;
    		$this->municipios = Load::model('municipios')->find("conditions: deptos_id = $this->id");	
    	endif;
	}


	public function detalles($id)
	{
		$this->id = $id;
		$alertas = new alertas();
		$this->alert1 = $alertas->find_by_id($this->id);
		$this->siteTitle = $this->alert1->titulo;
	}

}