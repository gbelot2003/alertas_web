<?php

class Acciones {

	public static function login($user)
	{
	/* 
	** Obtener usuario y fecha/hora de login
	*/
		$logs = Load::model('logs');
		$logs->usuario = $user;
		$logs->accion = "Login";
		$logs->save();
	}

	public static function logout($user)
	{
	/**
	 * Obtener registro de logout de sistema
	 */

		$logs = Load::model('logs');
		$logs->usuario = $user;
		$logs->accion = "Salir de Sistema";
		$logs->save();
	}

	public static function grabarAccesos($user, $accion, $data)
	{
	/**
	* Grabar la Informacion de ingresos no deseados al sistema
	* @var grabarAccesos
	*/
		$logs = Load::model('logs');
		$logs->usuario = $user;
		$logs->accion = $accion;
		$logs->data = $data;
		$logs->save();

	}
}