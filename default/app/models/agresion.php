<?php

class agresion extends ActiveRecord{
		protected function initialize(){
			$this->belongs_to('tipoagresion', 'fk:tipoagresion_id');
			$this->belongs_to('acategoria', 'fk:acategoria_id');
			$this->has_many('agredidos', 'fk:agresion_id');
		}	
	}
