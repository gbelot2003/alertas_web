<?php
/**
 * Controlador Logs
 * 
 * @category App
 * @package Controllers
 */

Load::model('logs');
class LogsController extends AdminController
{
	public function index($page=1){
		$this->title = "Registro de Logs del Sistema";
		$this->pageTitle = $this->title;
		$logs = new logs();
		$this->listItems = $logs->getList($page);
		
	}
}
