<?php

class agredidos extends ActiveRecord{
	public function initialize() {
		$this->belongs_to('gen', 'pk: gen_id');
		$this->belongs_to('tipomediosistema', 'pk: tipomediosistema_id');
		$this->belongs_to('tsagredido', 'pk: tsagredido_id');
		$this->belongs_to('agresion', 'pk: agresion_id');
		$this->has_many('alertas', 'pk: alertas_id');		
		$this->validates_numericality_of("genero_id");
		$this->validates_numericality_of("id");
		$this->validates_numericality_of("tipomediosistema_id");
		$this->validates_numericality_of("tsagredido_id");
		$this->validates_numericality_of("agresion_id");
	}

	public function agresiones_categoria_cabecera($anio, $tipo){
		$query =" 
		SELECT Count(`agredidos`.`id`) AS `agredidos_total`, `acategoria`.`id` AS `catId`, `acategoria`.`acategoria` AS `categoria`
		FROM `agredidos` Inner Join `alertas` ON `agredidos`.`alertas_id` = `alertas`.`id`
		Inner Join `agresion` ON `agredidos`.`agresion_id` = `agresion`.`id`
		Inner Join `acategoria` ON `agresion`.`acategoria_id` = `acategoria`.`id`
		WHERE `alertas`.`publicada_id` = '1' AND `alertas`.`anio` = '$anio' AND `acategoria`.`tipoagresion_id` = '$tipo'
		GROUP BY `acategoria`.`id`, `acategoria`.`acategoria` ORDER BY `catId` ASC";

		return $this->find_all_by_sql($query);
	}

	public function agresiones_categorias($anios, $catid){
		$query ="
				SELECT Count(`agredidos`.`agresion_id`) AS `cantidad`, `agredidos`.`agresion_id` AS `id`, `agresion`.`agresion` AS `agresion`
				FROM `agredidos`
				Inner Join `alertas` ON `agredidos`.`alertas_id` = `alertas`.`id`
				Inner Join `agresion` ON `agredidos`.`agresion_id` = `agresion`.`id`
				Inner Join `acategoria` ON `agresion`.`acategoria_id` = `acategoria`.`id`
				WHERE `alertas`.`publicada_id` = '1' AND `alertas`.`anio` = '$anios' AND `agresion`.`acategoria_id` = '$catid'
				GROUP BY `agresion`.`agresion`";

		return $this->find_all_by_sql($query);
	}

	public function agresiones_categoria_detalle($anios, $agresion){ //me sirve para directas he indirectas
		$query ="
				SELECT `alertas`.`id`, `alertas`.`titulo`, `alertas`.`fecha`, `agresion`.`agresion`
				FROM `agredidos` 
				Inner Join `agresion` ON `agredidos`.`agresion_id` = `agresion`.`id`
				Inner Join `acategoria` ON `agresion`.`acategoria_id` = `acategoria`.`id`
				Inner Join `alertas` ON `agredidos`.`alertas_id` = `alertas`.`id`
				WHERE `alertas`.`anio` = '$anios' AND `alertas`.`publicada_id` = '1' AND `agresion`.`id` = '$agresion'";

		return $this->find_all_by_sql($query);
	}

	public function agresiones_get_genero($anios){

		$query  = " SELECT tsagredido.id, tsagredido.tsagredido, SUM( IF (agredidos.gen_id = 1, 1, 0) ) m, SUM( IF (agredidos.gen_id = 2, 1, 0) ) f,
					SUM( IF (agredidos.gen_id = 3, 1, 0) ) l, SUM( IF (agredidos.gen_id = 4, 1, 0) ) n 
					FROM agredidos
					INNER JOIN tsagredido ON agredidos.tsagredido_id = tsagredido.id
					INNER JOIN alertas ON agredidos.alertas_id = alertas.id
					WHERE alertas.anio = $anios AND alertas.publicada_id = 1 GROUP BY agredidos.tsagredido_id";

		return $this->find_all_by_sql($query);
	}

	public function agresiones_get_medios($anios){
		$cols = "columns: agredidos.medio AS medio, agredidos.id AS id, Count(agredidos.id) AS Contador";
		$join = "join: INNER JOIN alertas ON (agredidos.alertas_id = alertas.id)";
		$cond = "conditions: alertas.anio = $anios AND alertas.publicada_id = 1";
		$grup = "group: medio";

		return $this->find($cols, $join, $cond, $grup);
	}

	public function agresiones_get_tipo_medios($anios){
		$cols  = "columns: agredidos.tipomediosistema_id AS sistemaId, tipomediosistema.tipomediosistema AS medio, agredidos.id AS id, Count(agredidos.id) AS Contador";
		$join  = "join: INNER JOIN alertas ON (agredidos.alertas_id = alertas.id)";
		$join .= "INNER JOIN tipomediosistema ON (agredidos.tipomediosistema_id = tipomediosistema.id)";
		$cond  = "conditions: alertas.anio = $anios AND alertas.publicada_id = 1";
		$grup  = "group: sistemaId";

		return $this->find($cols, $join, $cond, $grup);
	}

	public function agresiones_get_deptos($anios){
		$cols  = "columns: deptos.zona AS zona, deptos.departamento AS medio, deptos.id AS id, Count(alertas.deptos_id) AS Contador";
		$join  = "join: INNER JOIN alertas ON (agredidos.alertas_id = alertas.id)";
		$join .= "INNER JOIN deptos ON (alertas.deptos_id = deptos.id)";
		$cond  = "conditions: alertas.anio = $anios AND alertas.publicada_id = 1";
		$grup  = "group: deptos.departamento";
		$ord   = "order: Contador DESC";

		return $this->find($cols, $join, $cond, $grup, $ord);
	}

	public function agresiones_get_meses($anios){
		$cols  = "columns: meses.id, meses.mes AS medio, Count(alertas.meses_id) AS Contador";
		$join  = "join: INNER JOIN alertas ON (alertas.id = agredidos.alertas_id)";
		$join .= "INNER JOIN meses ON (alertas.meses_id = meses.id)";
		$cond  = "conditions: alertas.anio = $anios AND alertas.publicada_id = 1";
		$grup  = "group: meses.mes";
		$ord   = "order: Contador DESC";


		return $this->find($cols, $join, $cond, $grup, $ord);

	}

}