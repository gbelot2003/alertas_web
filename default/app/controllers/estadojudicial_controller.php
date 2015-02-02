<?php
/**
 * Controlador Estadojudicial
 * 
 * @category App
 * @package Controllers
 */

Load::model("estadojudicial");
class EstadojudicialController extends AdminController
{

	protected function before_filter(){
		$this->tipo = array(
			"resuelto" => "resuelto",
			"Impunidad" => "Impunidad"
			);
	}

	public function index(){
		$this->title = "Estado Judicial";
		$this->siteTitle = $this->title;
		$this->estadojudicial = Load::model('estadojudicial')->find();
	}

	public function add(){
		$this->title = NULL;
		if(Input::hasPost('estadojudicialestadojudicial')):
			$this->estadojudicialestadojudicial = new estadojudicialestadojudicial(Input::post('estadojudicialestadojudicial'));
			if($this->estadojudicialestadojudicial->save()):
				Flash::valid('La información se a guardado correctamente !!');
				return Router::redirect();
			else:
				Flash::error('Ha sucedido un error en al introducción de los datos');
				return Router::redirect();
			endif;
		endif;
	}

	public function edit($id){
		$this->id = (int) $id;
		$this->title = NULL;
		if(Input::hasPost('estadojudicial')):
			$this->estadojudicial = new estadojudicial(Input::post('estadojudicial'));
			if($this->estadojudicial->update()):
				Flash::valid('La información se a guardado correctamente !!');
				return Router::redirect();
			else:
				Flash::error('Ha sucedido un error en al introducción de los datos');
				return Router::redirect();
			endif;
		else:
			$this->estadojudicial = Load::model("estadojudicial")->find_by_id($this->id);
		endif;
	}

	public function del($id){
		$this->id = (int) $id;
		$estadojudicial = new estadojudicial();
		if($estadojudicial->delete($this->id)):
			Flash::valid('El registro a sido eliminado');
			return Router::redirect();			
		else:
			flash::error("Hubo algun problema con la eliminación del regitro");
			return Router::redirect();		
		endif;		
	}
}
