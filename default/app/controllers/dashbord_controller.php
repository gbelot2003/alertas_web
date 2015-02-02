<?php
/**
 * Controlador Dashbord
 * 
 * @category App
 * @package Controllers
 */
class DashbordController extends AdminController
{
	public function index(){	
		$this->siteTitle = "Listado General de Alertas";
		$this->title = $this->siteTitle;
		$this->query = Load::model('alertas')->find();//cambiar por la llamada con JOIN
		$this->header = array(
			'numero' => array(
				'title' => "No."),
			'titulo' => array(
				'title' => "Titulo",
				'url' => 'entrada/',
				'attr' => 'link'
				),
			'fecha' => array(
				'title' => 'Fecha'),
			'publicada_id' => array( //cambiar campo por "publicada"
				'title' => 'Estado'),
			);
	}


}
