<?php

class agresores extends ActiveRecord{
	public function initialize() {
		$this->belongs_to('tagresor', 'fk:tagresor_id');
		$this->belongs_to('estadojudicial', 'fk:estadojudicial_id');
	}

	public function before_save(){
		return $this->estadojudicial_id = 1;
	}

	public function agresores_get_tagresor($anios){
		$cols  = "columns: tagresor.id, tagresor.tagresor, Count(agresores.tagresor_id) AS Contador";
		$join  = "join: INNER JOIN alertas ON (agresores.alertas_id = alertas.id)";
		$join .= "INNER JOIN tagresor ON (agresores.tagresor_id = tagresor.id)";
		$cond  = "conditions: alertas.anio = $anios AND alertas.publicada_id = 1";
		$grup  = "group: tagresor.tagresor";

		return $this->find($cols, $join, $cond, $grup);
	}
}