<?php
/**
 * Controlador Tsagredido
 * 
 * @category App
 * @package Controllers
 */
class TsagredidoController extends AdminController
{
	public function index(){
		$this->title = "Tipo de Sujeto Agredido";
		$this->siteTitle = $this->title;
		$this->tsagredido = Load::model('tsagredido')->find();
	}

	public function add(){
		$this->title = NULL;
		if(Input::hasPost('tsagredido')):
			$this->tsagredido = new tsagredido(Input::post('tsagredido'));
			if($this->tsagredido->save()):
				Flash::valid('La información se a guardado correctamente !!');
				return Router::redirect();
			else:
				Flash::error('Ha sucedido un error en al introducción de los datos');
				return Router::redirect();
			endif;
		endif;
	}

	public function edit($id){
		$this->title = NULL;
		$this->id = (int) $id;
		if(Input::hasPost('tsagredido')):
			$this->tsagredido = new tagresor(Input::post('tsagredido'));
			if($this->tsagredido->update()):
				Flash::valid('La información se a guardado correctamente !!');
				return Router::redirect();
			else:
				Flash::error('Ha sucedido un error en al introducción de los datos');
				return Router::redirect();
			endif;
		else:
			$this->tsagredido = Load::model("tsagredido")->find_by_id($this->id);
		endif;
	}

	public function del($id){
		$this->id = (int) $id;
		$tsagredido = new tsagredido();
		if($tsagredido->delete($this->id)):
			flash::valid('El registro a sido eliminado');
			return Router::redirect();
		else:
			flash::error("Hubo algun problema con la eliminación del regitro");
			return Router::redirect();		
		endif;		
	}
}
