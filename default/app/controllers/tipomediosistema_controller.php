<?php
/**
 * Controlador Tipomediosistema
 * 
 * @category App
 * @package Controllers
 */

Load::model("tipomediosistema");
class TipomediosistemaController extends AdminController
{
	public function index(){
		$this->title = "Tipo de Medio o Sistema";
		$this->siteTitle = $this->title;
		$this->tipomediosistema = Load::model('tipomediosistema')->find();
	}

	public function add(){
		$this->title = NULL;
		if(Input::hasPost('tipomediosistema')):
			$this->tipomediosistema = new tipomediosistema(Input::post('tipomediosistema'));
			if($this->tipomediosistema->save()):
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
		if(Input::hasPost('tipomediosistema')):
			$this->tipomediosistema = new tipomediosistema(Input::post('tipomediosistema'));
			if($this->tipomediosistema->update()):
				Flash::valid('La información se a guardado correctamente !!');
				return Router::redirect();
			else:
				Flash::error('Ha sucedido un error en al introducción de los datos');
				return Router::redirect();
			endif;
		else:
			$this->tipomediosistema = Load::model("tipomediosistema")->find_by_id($this->id);
		endif;
	}

	public function del($id){
		$this->id = (int) $id;
		$tipomediosistema = new tipomediosistema();
		if($tipomediosistema->delete($this->id)):
			Flash::valid('El registro a sido eliminado');
			return Router::redirect();			
		else:
			flash::error("Hubo algun problema con la eliminación del regitro");
			return Router::redirect();		
		endif;		
	}
}
