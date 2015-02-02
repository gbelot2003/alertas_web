<?php
/**
 * Controlador Tagresor
 * 
 * @category App
 * @package Controllers
 */

Load::model("tagresor");
class TagresorController extends AdminController
{

	protected function after_filter()
	{

	}

	public function index(){
		$this->title = "Tipos de Agresor";
		$this->siteTitle = $this->title;
		$this->tagresor = Load::model('tagresor')->find();
	}

	public function add(){
		$this->title = NULL;
		if(Input::hasPost('tagresor')):
			$this->tagresor = new tagresor(Input::post('tagresor'));
			if($this->tagresor->save()):
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
		if(Input::hasPost('tagresor')):
			$this->tagresor = new tagresor(Input::post('tagresor'));
			if($this->tagresor->update()):
				Flash::valid('La información se a guardado correctamente !!');
				return Router::redirect();
			else:
				Flash::error('Ha sucedido un error en al introducción de los datos');
				return Router::redirect();
			endif;
		else:
			$this->tagresor = Load::model("tagresor")->find_by_id($this->id);
		endif;
	}

	public function del($id){
		$this->id = (int) $id;
		$tagresor = new tagresor();
		if($tagresor->delete($this->id)):
			Flash::valid('El registro a sido eliminado');
			return Router::redirect();			
		else:
			flash::error("Hubo algun problema con la eliminación del regitro");
			return Router::redirect();		
		endif;		
	}
}
