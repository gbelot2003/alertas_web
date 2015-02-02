<?php
/**
 * @see Controller nuevo controller
 */
require_once CORE_PATH . 'kumbia/controller.php';

/**
 * Controlador para proteger los controladores que heredan
 * Para empezar a crear una convención de seguridad y módulos
 *
 * Todas las controladores heredan de esta clase en un nivel superior
 * por lo tanto los metodos aqui definidos estan disponibles para
 * cualquier controlador.
 *
 * @category Kumbia
 * @package Controller
 */
class AdminController extends Controller
{

    final protected function initialize()
    {
        //Código de auth y permisos
        //Será libre, pero añadiremos uno por defecto en breve
        //Posiblemente se cree una clase abstracta con lo que debe tener por defecto

        //instanciamos a la clase MyAcl , y le indicamos el ini a utlizar
        $acl = new MyAcl('privilegios');  //si no se especifica el archivo a usar, por defecto busca en privilegios.ini
        $modulo = $this->module_name; //obtenermos el modulo actual
        $controlador = $this->controller_name; //obtenemos el controlador actual
        $accion = $this->action_name; //y obtenemos la accion actual

        //Configuraciones desde app_controller
        View::template('bootstrap');
        $this->navbar = true;
        $this->inicio = NULL; // index_controller
        $this->reportes = NULL;
        $this->rep_menu = NULL; // menu en reportes_controller
        $this->title = NULL;
        $this->siteTitle = NULL; 
        ///////////////////////////////////////////////////////

            if(!Auth::is_valid()):
                $this->usuarios_id = NULL;
                $this->usuario = NULL;
            else:
                $this->usuario_id = Auth::get('id');
                $this->usuario = Auth::get('usuario');
            endif;

        // en el ejemplo se obtiene el privilegio del usuario actual a traves de la libreria Auth
        // pero se puede aplicar algun otro método para obtener el privilegio del usuario actual
        $privilegio = Auth::get('rol_id');
        if (!$acl->check($privilegio, $modulo, $controlador, $accion)) 
        {  //verificamos si tiene ó no privilegios
            //Cambiamos el Titulo del sitio
            $this->title = "Error de Permisos";
            // si no posee los privilegios necesarios le enviamos un mensaje indicandoselo
            Flash::error("No posees suficientes PRIVILEGIOS para acceder a: {$modulo}/{$controlador}/{$accion}");
            //no dejamos que entre al contenido de la url si no tiene permisos
            View::select("error/404");
            return false;
    	}
    }

    final protected function finalize()
    {
        if (Input::isAjax()) {
          View::template(NULL);
        }
    }

}
