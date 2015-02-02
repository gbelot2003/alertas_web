<?php
class logs extends ActiveRecord{
	public function before_save(){
		$this->fecha_in = date("Y-m-d H:i");
	}

    public function getList($page, $ppage=20)
    {

        return $this->paginate("page: $page", "per_page: $ppage", 'order: id desc');

    }

}
