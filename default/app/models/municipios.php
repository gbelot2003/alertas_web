<?php

class municipios extends ActiveRecord{
	public function initialize() {
		$this->belongs_to('deptos', 'fk:deptos_id');
	}
}
