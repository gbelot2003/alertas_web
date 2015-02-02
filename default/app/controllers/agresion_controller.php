<?php
/**
 * Controlador Agresion
 * 
 * @category App
 * @package Controllers
 */

Load::model('agresion');
class AgresionController extends AdminController{
	public function index(){
		$this->siteTitle = "Tipos de Agresiones";
		$this->pageTitle = $this->title;
		$this->agresion = Load::model('agresion')->find("order: acategoria_id ASC");
	}

	public function add(){
		$this->siteTitle = NULL;
		if(Input::hasPost('agresion')):
			$this->agresion = new agresion(Input::post('agresion'));
			if($this->agresion->save()):
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
		$this->siteTitle = NULL;
		if(Input::hasPost('agresion')):
			$this->agresion = new agresion(Input::post('agresion'));
			if($this->agresion->update()):
				Flash::valid('La información se a guardado correctamente !!');
				return Router::redirect();
			else:
				Flash::error('Ha sucedido un error en al introducción de los datos');
				return Router::redirect();
			endif;
		else:
			$this->agresion = Load::model("agresion")->find_by_id($this->id);
		endif;
	}

	public function del($id){
		$this->id = (int) $id;
		$agresion = new agresion();
		if($agresion->delete($this->id)):
			Flash::valid('El registro a sido eliminado');
			return Router::redirect();			
		else:
			flash::error("Hubo algun problema con la eliminación del regitro");
			return Router::redirect();		
		endif;		
	}

}
