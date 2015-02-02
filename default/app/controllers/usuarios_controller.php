<?php
/**
 * Controlador Usuarios
 * 
 * @category App
 * @package Controllers
 */
Load::model("usuarios");

class UsuariosController extends AdminController{

	protected function before_filter()
	{

	}

	public function index()
	{
		$this->title = "Administración de Usuarios";
		$this->siteTitle = $this->title;
		$cols = "columns: usuarios.id, usuarios.nombre, usuarios.apellido, usuarios.email, rol.rol";
		$join = "join: INNER JOIN rol ON (usuarios.rol_id = rol.id)";
		$this->usuarios = Load::model("usuarios")->find($join, $cols);
		$this->i = 1;
		$this->header = array(
			"nombre" => array(
				"title" => "Nombre",
				"url" => "usuarios/edit/",
				"attr" => "class='edit'",
				),
			"apellido" => array(
				"title" => "Apellido",
				),
			"email" => array(
				"title" => "E-mail",
				),
			"rol" => array(
				"title" => "Rol de Usuario",
				),
			);

	}

	public function add()
	{

	}

	public function edit($id)
	{
		$this->id = (int) $id;
		$this->title = "Editar Usuario";
		$this->siteTitle = $this->title;
		if(Input::hasPost("usuarios")):
			$this->usuarios = new usuarios(Input::post('usuarios'));
			if($this->usuarios->update()):
				Flash::valid("Los cambios se han salvado correctamente");
				return Router::redirect();
			else:
				Flash::error('Ha sucedido un error en al introducción de los datos');
				return Router::redirect();
			endif;
		else:
			$this->usuarios = Load::model("usuarios")->find_by_id($this->id);

		endif;
	}

	public function pass($id){
		$this->id = (int) $id;
		$this->usuarios = Load::model("usuarios")->find_by_id($this->id);
	}

	public function del()
	{

	}

}
