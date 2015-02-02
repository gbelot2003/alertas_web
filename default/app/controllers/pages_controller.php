<?php
/**
 * Controller para el manejo de páginas estáticas, aunque
 * se puede utilizar como cualquier otro controller haciendo uso
 * de los Templates, Layouts y Partials.
 * los parámetros pasados al metodo show() indican vistas que están en views/pages/
 * manteniendo su estructura en directorios
 * Ejemplo:
 *
 * Ej.
 * dominio.com/pages/show/organizacion/privacidad
 * enseñara la vista views/pages/organizacion/privacidad.phtml
 *
 * dominio.com/pages/show/aviso
 * enseñara la vista views/pages/aviso.phtml
 * 
 * También se puede usar el routes.ini para llamarlo con otro nombre,
 * /aviso = pages/show/aviso
 * Asi al ir a dominio.com/aviso enseñara la vista views/pages/aviso.phtml
 * 
 * /organizacion/* = pages/show/organizacion/*
 * Al ir a dominio.com/organizacion/privacidad enseñará la vista en views/organizacion/privacidad.phtml
 * 
 * Ademas se pueden utilizar Helpers
 * <?php echo link_to('pages/show/aviso', 'Ir Aviso') ?>
 * Mostrara un link que al hacer click ira a dominio.com/pages/show/aviso
 * 
 */
class PagesController extends AppController 
{
	protected function before_filter()
	{
	    $this->limit_params = false;
		// Si es AJAX enviar solo el view
		if (Input::isAjax()) {
		  View::template(NULL);
		}
    }
	
	public function show()
	{
		View::select(implode('/', $this->parameters));
	}

	public function login(){

        $this->navbar = NULL;
		$this->title = "Login de Sistema";
		
		if(Input::hasPost("usuario", "pass")):
			$user = Input::Post('usuario');
			$pw   = Input::Post('pw');
			$pws  = md5($pw);
			$auth = new Auth("model", "class: usuarios", "usuario: $user", "pass: $pws");
			if($auth->authenticate()):
				//Punto de helper
				Router::redirect("dashbord/");
			else:
				Flash::error("<strong>Warning!</strong>");
			endif;
		endif;		
	}

    public function salir(){
        Auth::destroy_identity();
        //punto de helper
        Router::redirect("/");
    }

}
