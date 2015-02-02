<?php
/**
 * Controlador Categoria
 * 
 * @category App
 * @package Controllers
 */

Load::model('acategoria');
class CategoriaController extends AdminController
{
	public function index(){
		$this->title = "Categorias";
		$this->siteTitle = $this->title;
		$this->acategoria = Load::model('acategoria')->find();
	}

	public function add(){
		$this->title = NULL;
		if(Input::hasPost('acategoria')):
			$this->acategoria = new acategoria(Input::post('acategoria'));
			if($this->acategoria->save()):

				// Script de grabado en registros de Logs -----------
				$data = $this->acategoria->nombre;
				$accion = "Agregar Nueva Categoria";
                Acciones::grabarAccesos($usuario, $accion, $data);
				//---------------------------------------------------->

				Flash::valid('La información se a guardado correctamente !!');
				return Router::redirect();
			else:
				$accion = "Error al agregar Nueva Categoria";
                Acciones::grabarAccesos($usuario, $accion, NULL);

				Flash::error('Ha sucedido un error en al introducción de los datos');
				return Router::redirect();
			endif;
		endif;
	}

	public function edit($id){
		$this->id = (int) $id;
		$this->title = NULL;
		if(Input::hasPost('acategoria')):
			$this->acategoria = new acategoria(Input::post('acategoria'));
			if($this->acategoria->update()):
				Flash::valid('La información se a guardado correctamente !!');
				return Router::redirect();
			else:
				Flash::error('Ha sucedido un error en al introducción de los datos');
				return Router::redirect();
			endif;
		else:
			$this->acategoria = Load::model("acategoria")->find_by_id($this->id);
		endif;
	}

	public function del($id){
		$this->id = (int) $id;
		$acategoria = new acategoria();
		if($acategoria->delete($this->id)):
			Flash::valid('El registro a sido eliminado');
			return Router::redirect();			
		else:
			flash::error("Hubo algun problema con la eliminación del regitro");
			return Router::redirect();		
		endif;		
	}
}
