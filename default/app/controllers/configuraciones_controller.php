<?php

Load::models('alertas', 'agredidos', 'agresores');

class ConfiguracionesController extends AdminController 
{
	protected function before_filter()
	{
	    $this->limit_params = false;
	    $this->title = NULL;
		$this->siteTitle = $this->title;

		if (Input::isAjax()) {
		  View::template(NULL);
		}
	}

    public function add()
    {
    	permisos::Validador();
		$this->title = "Crear Nueva Alerta";

		if(Input::hasPost('alertas')):
			$alertas = new alertas(Input::post('alertas'));
			if($alertas->save()):
				flash::success('<p>La Alerta a sido guardada, ahora debes ingresar la información necesaria para completar la alerta</p>
				               		<p>Ingresa los datos de los sujetos agredidos y los agresores en las tablas que se describen abajo...</p>');
				$numero = $alertas->numero;
				$info = Load::model('alertas')->find_first("conditions: numero = '$numero'");
				return Router::redirect("configuraciones/edit/$info->id");
			else:
				flash::error('Hubo un error en la introducción de datos');
			endif;
		endif;

    }

    public function edit($id)
    {
    	permisos::Validador();
    	$this->title = "Edición de Alerta";
		$this->est = 1;
		$this->id = (int) $id;
		if(input::hasPost('alertas')):
			$this->alertas = new alertas(Input::post('alertas'));
			if($this->alertas->save()):
				flash::valid('La información de la alerta a sido actualizada exitosamente');
				return Router::redirect("entrada/$this->id");
			else:
				flash::error('Hubo un error en la introducción de datos');
			endif;
		else:
			$this->alertas = Load::model('alertas')->find_by_id($this->id);

		endif;
    }

	public function agredidos_delete($agredidos_id, $alertas_id)//adminController
	{

		$this->id = (int) $agredidos_id;
		$agredidos = new agredidos();
		if($agredidos->delete($this->id)):
			Flash::valid('El registro a sido eliminado');
			return Router::redirect("configuraciones/edit/$alertas_id");
		else:
			flash::error("Hubo algun problema con la eliminación del regitro");
			return Router::redirect("configuraciones/edit/$alertas_id");
		endif;
	}

	public function agredidos_add($alertas_id)
	{
		permisos::Validador();
		$this->alertas_id = (int) $alertas_id;
		if(Input::hasPost('agredidos')):
			$this->agredidos = new agredidos(Input::post('agredidos'));
			if($this->agredidos->save()) :
				Flash::success('La Información se actualizo correctamente');
				return Router::redirect("configuraciones/edit/$alertas_id");
			else:
				Flash::error('Ocurrio algun error en la introducción de datos');
				return Router::redirect("configuraciones/edit/$alertas_id");
			endif;
		endif;
	}

	public function agredidos_edit($id)
	{
		$this->id = (int) $id;
		if(Input::hasPost('agredidos')):
			$this->agredidos = new agredidos(Input::post('agredidos'));
			$alertas_id = $this->agredidos->alertas_id;
			if($this->agredidos->save()) :
				Flash::success('La Información se actualizo correctamente');
				return Router::redirect("configuraciones/edit/$alertas_id");
			else:
				Flash::error('Ocurrio algun error en la introducción de datos');
				return Router::redirect("configuraciones/edit/$alertas_id");
			endif;
		else:
			$this->agredidos = Load::model('agredidos')->find_by_id($this->id);
		endif;


	}

	public function agresores_delete($agresores_id, $alertas_id)
	{
		$this->id = (int) $agresores_id;
		$agresores = new agresores();
		if($agresores->delete($this->id)):
			Flash::valid('El registro a sido eliminado');
			return Router::redirect("configuraciones/edit/$alertas_id");
		else:
			flash::error("Hubo algun problema con la eliminación del regitro");
			return Router::redirect("configuraciones/edit/$alertas_id");
		endif;
	}

	public function agresores_add($alertas_id)
	{
		permisos::Validador();
		$this->alertas_id = (int) $alertas_id;
		if(Input::hasPost('agresores')):
			$this->agresores = new agresores(Input::post('agresores'));
			if($this->agresores->save()) :
				Flash::success('La Información se actualizo correctamente');
				return Router::redirect("configuraciones/edit/$alertas_id");
			else:
				Flash::error('Ocurrio algun error en la introducción de datos');
				return Router::redirect("configuraciones/edit/$alertas_id");
			endif;
		endif;
	}

	public function agresores_edit($id)
	{
		$this->id = (int) $id;

		if(Input::hasPost('agresores')):
			$this->agresores = new agresores(Input::post('agresores'));
			$alertas_id = $this->agresores->alertas_id;
			if($this->agresores->save()) :
				Flash::success('La Información se actualizo correctamente');
				return Router::redirect("configuraciones/edit/$alertas_id");
			else:
				Flash::error('Ocurrio algun error en la introducción de datos');
				return Router::redirect("configuraciones/edit/$alertas_id");
			endif;
		else:
			$this->agresores = Load::model('agresores')->find_by_id($this->id);
		endif;
	}


	public function otras(){
		$siteTitle = "Otras Configuraciones";
		$this->title = $siteTitle;
	}
}