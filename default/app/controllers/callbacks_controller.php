<?php
/**
 * Controlador Callbacks
 * 
 * @category App
 * @package Controllers
 */
class CallbacksController extends AdminController
{	
	public function municipios($id)
	{
		View::template(NULL);
		$mid = (int) $id;
		$this->municipios = Load::model("municipios")->find("conditions: deptos_id = $mid");
	}
}
