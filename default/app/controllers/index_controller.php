<?php

/**
 * Controller por defecto si no se usa el routes
 * 
 */
class IndexController extends AppController
{
	protected function before_filter()
	{
		$this->inicio = "Class='active'";
	}

    public function index()
    {
    	$this->sidebar = true;
        $this->estadisticas = true;

        //$this->estadisticas = TRUE;
        $this->query = Load::model('alertas')->find("conditions: publicada_id = 1", "order: alertas.id DESC", "limit: 15");
        $this->header = array(
        	'numero' => array(
        		'title' => 'No.',
                'attr' => NULL,
                ),
        	'titulo'=> array(
        		'title' => "Titulo de Alerta",
                'url' => "entrada/",
                'attr' => 'link',
                ),
        	'fecha' => array('title' => 'Fecha de Alerta',
            'attr' => NULL,
                ),
        );
    }
  

}
