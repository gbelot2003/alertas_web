<?php

class acategoria extends ActiveRecord{
		protected function initialize(){
			$this->belongs_to('tipoagresion', 'fk:tipoagresion_id');
			$this->has_many('agresion', 'fk:acategoria_id');
		}	
	}
