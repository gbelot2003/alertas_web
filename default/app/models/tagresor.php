<?php

	class tagresor extends ActiveRecord{
		protected function initialize(){
			$this->validates_presence_of("tagresor");
			$this->validates_uniqueness_of("tagresor");
			$this->has_many('agresores', 'fk:tagresor_id');
		}	
	}
