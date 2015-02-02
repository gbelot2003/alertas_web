<?php
/**
 * Controlador Reportes
 * 
 * @category App
 * @package Controllers
 */

Load::models('agredidos');
Load::models('alertas');
Load::lib("libchart/classes/libchart");

class ReportesController extends AppController
{
		public $limit_params = false;
		protected function before_filter()
	{
		$this->siteTitle = "Area de Reportes";
		$this->title = $this->siteTitle;
		$this->reportes = "Class='active'";
    	$this->sidebar = true;
		$this->reportesBar = TRUE;
		$this->anio_actual = Load::model('alertas')->find_first("order: anio DESC", "conditions: publicada_id = 1");
		$this->i = 1;
		$this->action_paht = $this->controller_name ."/".$this->action_name;
		$this->resultado = 0;
		$this->pages  = null;
		$this->rep_menu = array();
		$this->posTilte = array();

	}

	public function index($anios = NULL, $id = NULL)
	{
		$this->rep_menu['inicio'] = 'active';
	}

	public function sujeto_agredido($anios = NULL, $id = NULL){
		$this->siteTitle = "Tipos de Sujeto Agredido";
		$this->title = $this->siteTitle;
		$this->rep_menu['sagredido'] = 'active';
		$this->id = $id;
		$this->posTilte['sujetoAgredido'] = True;

		$this->anios = $anios;
		if($this->anios == NULL):
			$this->anios = $this->anio_actual->anio; 
		endif;

		if($this->id == NULL):
			$cols = "columns: Count(tsagredido.tsagredido) as Contador,tsagredido.tsagredido, tsagredido.id, alertas.anio";
			$join  = "join: INNER JOIN agredidos ON (agredidos.tsagredido_id = tsagredido.id)";
			$join .= "INNER JOIN alertas ON (agredidos.alertas_id = alertas.id)";
			$cond = "conditions: alertas.publicada_id = 1 and alertas.anio = $this->anios";
			$this->model = Load::model('tsagredido')->find($cols, $join, $cond, 'group: tsagredido.id');

			$this->chart = new HorizontalBarChart(900, 450); 
			$this->dataSet = new XYDataSet();
			$this->chart2 = new PieChart(900, 340); 
			$this->dataSet2 = new XYDataSet();
		else:
			$join  = "join: INNER JOIN agredidos ON (agredidos.tsagredido_id = tsagredido.id)";
			$join .= "INNER JOIN alertas ON (agredidos.alertas_id = alertas.id)";
			$cond = "conditions: alertas.publicada_id = 1 and alertas.anio = $this->anios and tsagredido.id = $this->id";
			$cols = "columns: alertas.id, alertas.numero, alertas.titulo, alertas.fecha, tsagredido.tsagredido";
			$this->query = Load::model('tsagredido')->find($join, $cond, $cols);

			$this->header = array(
					'numero' => array(
						'title' => 'No.',
					   'attr' => 'link'
						),
					'titulo' => array(
						'title' => 'Titulo de Alerta',
						'url' => "entrada/",
						'attr' => 'link'
						),
					'fecha' => array(
						'title' => 'Fecha',
                        'attr' => 'link'
                        ),
					'tsagredido' => array(
						'title' => 'Sujeto Agredido',
                        'attr' => 'link'
                    ),
				);
		endif;
	}

	public function sujeto_agredido_genero($anios = NULL, $id = NULL, $gen = NULL){
		$this->siteTitle = "Reporte de Tipo de Sujeto Agredido por Género";
		$this->title = $this->siteTitle;
		$this->rep_menu['genero'] = 'active';
		$this->anios = $anios;
		$this->id = $id;
		$this->gen = $gen;
		if($this->anios == NULL):
			$this->anios = $this->anio_actual->anio; 
		endif; 

		if($this->id == NULL):

			$this->models = Load::model('agredidos')->agresiones_get_genero($this->anios);
			$this->chart = new HorizontalBarChart(900, 500);
		    $this->serie1 = new XYDataSet(); 
		    $this->serie2 = new XYDataSet(); 
		    $this->serie3 = new XYDataSet(); 
		    $this->serie4 = new XYDataSet(); 
		    $this->dataSet = new XYSeriesDataSet();

		    $this->chart2 = new PieChart(900, 500);
		    $this->dataSet2 = new XYDataSet();
		
		elseif((isset($this->id)) && $this->gen == NULL):
			
			$join  = "join: INNER JOIN gen ON (agredidos.gen_id = gen.id)";
			$join .= "INNER JOIN tsagredido ON (agredidos.tsagredido_id = tsagredido.id)";
			$join .= "INNER JOIN alertas ON (agredidos.alertas_id = alertas.id)";
			$cond = "conditions: alertas.publicada_id = 1 and alertas.anio = $this->anios and tsagredido.id = $this->id";
			$cols = "columns: alertas.id, alertas.numero, alertas.titulo, alertas.fecha, gen.gen";
			$this->query = Load::model('agredidos')->find($join, $cond, $cols);

			$this->header = array(
					'numero' => array(
						'title' => 'No.',
                        'attr' => 'link'					
						),
					'titulo' => array(
						'title' => 'Titulo de Alerta',
						'url' => "entrada/",
						'attr' => 'link'),
					'fecha' => array(
						'title' => 'Fecha',
                        'attr' => 'link'
                        ),
                        
					'gen' => array(
						'title' => 'Género del Sujeto Agredido',
                        'attr' => 'link'),
				);

		elseif((isset($this->id)) && (isset($this->gen))):	
			
			$join  = "join: INNER JOIN gen ON (agredidos.gen_id = gen.id)";
			$join .= "INNER JOIN tsagredido ON (agredidos.tsagredido_id = tsagredido.id)";
			$join .= "INNER JOIN alertas ON (agredidos.alertas_id = alertas.id)";
			$cond = "conditions: alertas.publicada_id = 1 and alertas.anio = $this->anios and tsagredido.id = $this->id and gen.id = $this->gen";
			$cols = "columns: alertas.id, alertas.numero, alertas.titulo, alertas.fecha, gen.gen";
			$this->query = Load::model('agredidos')->find($join, $cond, $cols);

			$this->header = array(
					'numero' => array(
						'title' => 'No.',					
						),
					'titulo' => array(
						'title' => 'Titulo de Alerta',
						'url' => "entrada/",
						'attr' => 'link',
						),
					'fecha' => array(
						'title' => 'Fecha',
                        'attr' => 'link'),
					'gen' => array(
						'title' => 'Género del Sujeto Agredido',
                        'attr' => 'link'),
				);
		endif;

	}

	public function medio_sistema($anios = NULL, $string = NULL){

		$this->siteTitle = "Reporte por Medios o Sistemas";
		$this->title = $this->siteTitle;
		$this->rep_menu['medio'] = 'active';
		$this->anios = $anios;
		$this->string = $string;
		if($this->anios == NULL):
			$this->anios = $this->anio_actual->anio; 
		endif; 

		if($this->string == NULL):

			$this->model = Load::model('agredidos')->agresiones_get_medios($this->anios);	
			$this->chart = new HorizontalBarChart(900, 450); 
			$this->dataSet = new XYDataSet();

		elseif(isset($this->string)):

			$join  = "join: INNER JOIN tsagredido ON (agredidos.tsagredido_id = tsagredido.id)";
			$join .= "INNER JOIN alertas ON (agredidos.alertas_id = alertas.id)";
			$cond = "conditions: alertas.publicada_id = 1 and alertas.anio = $this->anios and agredidos.medio LIKE '%$this->string%'";
			$cols = "columns: alertas.id, alertas.numero, alertas.titulo, alertas.fecha, agredidos.medio";
			$this->query = Load::model('agredidos')->find($join, $cond, $cols);

			$this->header = array(
					'numero' => array(
						'title' => 'No.',
                        'attr' => 'link'					
						),
					'titulo' => array(
						'title' => 'Titulo de Alerta',
						'url' => "entrada/",
						'attr' => 'link'),
					'fecha' => array(
						'title' => 'Fecha',
                        'attr' => 'link'
                        ),
					'medio' => array(
						'title' => 'Medio o Sistema',
                        'attr' => 'link',
                        ),
				);
		endif;
	}

	public function tipo_medio_sistema($anios = NULL, $id = NULL){

		$this->siteTitle = "Actos de Agresión a Sistemas, Medios y Grupos Periodisticos";
		$this->title = $this->siteTitle;
		$this->rep_menu['tmedio'] = 'active';
		$this->anios = $anios;
		$this->id = $id;
		if($this->anios == NULL):
			$this->anios = $this->anio_actual->anio; 
		endif; 

		if($this->id == NULL):

			$this->model = Load::model('agredidos')->agresiones_get_tipo_medios($this->anios);	
			$this->chart = new HorizontalBarChart(900, 450); 
			$this->dataSet = new XYDataSet();

		elseif(isset($this->id)):

			$join  = "join: INNER JOIN tipomediosistema ON (agredidos.tipomediosistema_id = tipomediosistema.id)";
			$join .= "INNER JOIN alertas ON (agredidos.alertas_id = alertas.id)";
			$cond = "conditions: alertas.publicada_id = 1 and alertas.anio = $this->anios and tipomediosistema.id = $this->id";
			$cols = "columns: alertas.id, alertas.numero, alertas.titulo, alertas.fecha, agredidos.tipomediosistema_id, tipomediosistema.tipomediosistema";
			$this->query = Load::model('agredidos')->find($join, $cond, $cols);

			$this->header = array(
					'numero' => array(
						'title' => 'No.',
                        'attr' => 'link'					
						),
					'titulo' => array(
						'title' => 'Titulo de Alerta',
						'url' => "entrada/",
						'attr' => 'link'),
					'fecha' => array(
						'title' => 'Fecha',
                        'attr' => 'link'
                        ),
					'tipomediosistema' => array(
						'title' => 'Tipo de Medio o Sistema',
                        'attr' => 'link'
                        ),
				);
		endif;
	}

	public function agresiones_directas($anios = NULL, $id = NULL){

		$this->siteTitle = "Reporte de Agresiondes Directas";
		$this->title = $this->siteTitle;
		$this->rep_menu['adirectas'] = 'active';
		$this->anios = $anios;
		$this->id = $id;
		if($this->anios == NULL):
			$this->anios = $this->anio_actual->anio; 
		endif;

		if($this->id == NULL):
			$this->categorias = Load::model('agredidos')->agresiones_categoria_cabecera($this->anios, 1);
			$this->chart = new PieChart(900, 360);
			$this->dataSet = new XYDataSet();
		else :
			$cols  = "columns: alertas.id, alertas.titulo, alertas.fecha, agresion.agresion";
			$join  = "join: INNER JOIN agresion ON (agredidos.agresion_id = agresion.id)";
			$join .= "INNER JOIN acategoria ON (agresion.acategoria_id = acategoria.id)";
			$join .= "INNER JOIN alertas ON (agredidos.alertas_id = alertas.id)";
			$cond  = "conditions: alertas.publicada_id = 1 AND alertas.anio = $this->anios AND agresion.id = $this->id";
			$this->query = Load::model('agredidos')->find($cols, $cond, $join, "ORDER BY alertas.id");
			$this->controlador = $this->controller_name;
			
			$this->header = array(
				'numero' => array(
					'title' => 'No.',
                    'attr' => 'link'
					),
				'titulo' => array(
					'title' => 'Titulo',
					'url' => "entrada/",
					'attr' => 'link'
					),
				'fecha' => array(
					'title' => 'Fecha',
                    'attr' => 'link'
					),
				'agresion' => array(
					'title' => 'Agresion',
                    'attr' => 'link'
					),
				);

		endif;
	}

	public function agresiones_indirectas($anios = NULL, $id = NULL){

		$this->siteTitle = "Reporte de Agresiondes Indirectas";
		$this->title = $this->siteTitle;
		$this->rep_menu['aindirectas'] = 'active';
		$this->anios = $anios;
		$this->id = $id;
		if($this->anios == NULL):
			$this->anios = $this->anio_actual->anio; 
		endif;

		if($this->id == NULL):
			$this->categorias = Load::model('agredidos')->agresiones_categoria_cabecera($this->anios, 2);
			$this->chart = new PieChart(900, 360);
			$this->dataSet = new XYDataSet();
		else :
			$cols  = "columns: alertas.id, alertas.titulo, alertas.fecha, agresion.agresion";
			$join  = "join: INNER JOIN agresion ON (agredidos.agresion_id = agresion.id)";
			$join .= "INNER JOIN acategoria ON (agresion.acategoria_id = acategoria.id)";
			$join .= "INNER JOIN alertas ON (agredidos.alertas_id = alertas.id)";
			$cond  = "conditions: alertas.publicada_id = 1 AND alertas.anio = $this->anios AND agresion.id = $this->id";
			$this->query = Load::model('agredidos')->find($cols, $cond, $join, "ORDER BY alertas.id");
			$this->controlador = $this->controller_name;
			
			$this->header = array(
				'numero' => array(
					'title' => 'No.',
                    'attr' => 'link'
					),
				'titulo' => array(
					'title' => 'Titulo',
					'url' => "entrada/",
					'attr' => 'link'
					),
				'fecha' => array(
					'title' => 'Fecha',
                    'attr' => 'link'
					),
				'agresion' => array(
					'title' => 'Agresion',
                    'attr' => 'link'
					),
				);
		endif;
	}

	public function agente_agresor($anios = NULL, $id = NULL){
		$this->siteTitle = "Tipos de Agente Agresor a la Libretad de Expresión";
		$this->title = $this->siteTitle;
		$this->rep_menu['agresor'] = 'active';
		$this->anios = $anios;
		$this->id = $id;
		if($this->anios == NULL):
			$this->anios = $this->anio_actual->anio;
		endif;

		if($this->id == NULL):

			$this->model = Load::model('agresores')->agresores_get_tagresor($this->anios);
			$this->chart = new HorizontalBarChart(900, 450);
			$this->dataSet = new XYDataSet();

		elseif(isset($this->id)):
			$join  = "join: INNER JOIN alertas AS alt ON (agresores.alertas_id = alt.id)";
			$join .= "INNER JOIN tagresor AS tag ON (agresores.tagresor_id = tag.id)";
			$cols  = "columns: alt.id, alt.numero, alt.titulo, alt.fecha, tag.tagresor";
			$cond  = "conditions: alt.anio = $this->anios AND alt.publicada_id =1 AND tag.id = $this->id";
			$this->query = Load::model("agresores")->find($cols, $cond, $join, "ORDER BY DESC");
			$this->controlador = $this->controller_name;

			$this->header = array(
				'numero' => array(
					'title' => 'No.',
                    'attr' => 'link'
					),
				'titulo' => array(
					'title' => 'Titulo',
					'url' => "entrada/",
					'attr' => 'link'
					),
				'fecha' => array(
					'title' => 'Fecha',
                    'attr' => 'link'
					),
				'tagresor' => array(
					'title' => 'Tipo de Agresor',
                    'attr' => 'link'
					),
				);
		endif;
	}

	public function locacion($anios = NULL, $id = NULL){
		$this->siteTitle = "Localización por Departamentos de actos de agresión a la Libertad de Expresión";
		$this->title = $this->siteTitle;
		$this->rep_menu['locacion'] = 'active';
		$this->anios = $anios;
		$this->id = $id;
		if($this->anios == NULL):
			$this->anios = $this->anio_actual->anio;
		endif;

		if($this->id == NULL):

			$this->model = Load::model('agredidos')->agresiones_get_deptos($this->anios);
			$this->chart = new HorizontalBarChart(900, 450);
			$this->dataSet = new XYDataSet();
			//Ocurrencias de actos de agresión a la Libertad de Expresión por Mes

		elseif(isset($this->id)):
			$join  = "join: INNER JOIN alertas AS alt ON (agredidos.alertas_id = alt.id)";
			$join .= "INNER JOIN deptos AS dep ON (alt.deptos_id = dep.id)";
			$join .= "INNER JOIN municipios AS mun ON (alt.municipios_id = mun.id)";
			$cols  = "columns: alt.id, alt.numero, alt.titulo, alt.fecha, dep.departamento, mun.municipio";
			$cond  = "conditions: alt.anio = $this->anios AND alt.publicada_id =1 AND dep.id = $this->id";
			$this->query = Load::model("agredidos")->find($cols, $cond, $join, "ORDER BY DESC");
			$this->controlador = $this->controller_name;

			$this->header = array(
				'numero' => array(
					'title' => 'No.',
                    'attr' => 'link'
					),
				'titulo' => array(
					'title' => 'Titulo',
					'url' => "entrada/",
					'attr' => 'link'
					),
				'fecha' => array(
					'title' => 'Fecha',
                    'attr' => 'link'
					),
				'departamento' => array(
					'title' => 'Departamento',
                    'attr' => 'link'
					),
				'municipio' => array(
					'title' => 'municipio',
					'attr' => 'link'
					)
				);

		endif;
	}

	public function ocurrencias_mes($anios = NULL, $id = NULL){

		$this->siteTitle = "Ocurrencias de actos de agresión a la Libertad de Expresión por Mes";
		$this->title = $this->siteTitle;
		$this->rep_menu['mes'] = 'active';
		$this->anios = $anios;
		$this->id = $id;
		if($this->anios == NULL):
			$this->anios = $this->anio_actual->anio; 
		endif; 

		if($this->id == NULL):

			$this->model = Load::model('agredidos')->agresiones_get_meses($this->anios);	
			$this->chart = new HorizontalBarChart(900, 450); 
			$this->dataSet = new XYDataSet();
			//Ocurrencias de actos de agresión a la Libertad de Expresión por Mes

		elseif(isset($this->id)):

			$join  = "join: INNER JOIN alertas AS alt ON (agredidos.alertas_id = alt.id)";
			$join .= "INNER JOIN meses AS mes ON (alt.meses_id = mes.id)";
			$cols  = "columns: alt.id, alt.numero, alt.titulo, alt.fecha, mes.mes";
			$cond  = "conditions: alt.anio = $this->anios AND alt.publicada_id =1 AND mes.id = $this->id";
			$this->query = Load::model("agredidos")->find($cols, $cond, $join, "ORDER BY DESC");
			$this->controlador = $this->controller_name;

			$this->header = array(
				'numero' => array(
					'title' => 'No.'
					),
				'titulo' => array(
					'title' => 'Titulo',
					'url' => "entrada/",
					'attr' => 'link'
					),
				'fecha' => array(
					'title' => 'Fecha'
					),
				'departamento' => array(
					'title' => 'Departamento'
					),
				'mes' => array(
					'title' => 'Meses'
					)
				);

		endif;
	}
}
