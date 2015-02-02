<?php

class alertas extends ActiveRecord{
	public function initialize() 
	{
		//relaciones
		$this->has_many('agresores');
		$this->has_many('agredidos');
		$this->belongs_to('departamentos', 'fk:deptos_id');
		$this->belongs_to('municipios', 'fk:municipios_id');
		$this->belongs_to('publicada', 'fk:publicada_id');
		//comprobaciones
		$this->validates_presence_of('titulo');
		$this->validates_presence_of('numero');
		$this->validates_presence_of('created_at');
		$this->validates_presence_of('fecha');
		$this->validates_presence_of('municipios_id');
		$this->validates_presence_of('relato');
		$this->validates_presence_of('publicada');
		//validacion para numero, solo 8 caracteres

		$this->validates_numericality_of("municipios_id");
		$this->validates_numericality_of("publicada");
		$this->validates_uniqueness_of("numero");
		$this->validates_date_in("fecha");
	}
    

	
    
    public $before_delete = "no_borrar_activos";
 	
 	public function before_save() {
 		$rs = explode("-", $this->fecha);

 		$this->anio = $rs[0];
 		$this->meses_id = $rs[1];
 		$this->estadojudicial = "Impune";
 		return;
 	}

 	public function before_update(){
 		$rs = explode("-", $this->fecha);
 		$this->anio = $rs[0];
 		$this->meses_id = $rs[1];
 		return;
 	}
	
    public function no_borrar_activos(){    	
        if($this->publicada == 1):
          Flash::error("No se puede Borrar una alerta activa");
          return ‘cancel’;
        endif;
     }

    public function after_delete(){
    	
    	Flash::success("Se borro correctamente la alerta $this->nombre");
    
    }

 	public function getAnios()//Conseguimos listado anual
	{
		return $this->find_all_by_sql("SELECT alertas.anio FROM alertas WHERE publicada_id = 1 GROUP BY alertas.anio ORDER BY alertas.anio DESC");
	}

}