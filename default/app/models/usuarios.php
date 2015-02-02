<?php
	class usuarios extends ActiveRecord
	{	//ya quedan filtrados los campos de esta tabla al instrducir
		
		protected function initialize()
		{
			$this->belongs_to('rol', 'fk:rol_id');
			$this->validates_numericality_of("rol_id");
			$this->validates_email_in("email");
			$this->validates_presence_of("usuario");
			$this->validates_presence_of("pass");
			$this->validates_presence_of("rol_id");
			$this->validates_uniqueness_of("usuario");
		}
	}
