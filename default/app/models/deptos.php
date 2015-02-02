<?php

class deptos extends ActiveRecord{
	public function initialize() {
		$this->has_many('municipios');
	}
}
