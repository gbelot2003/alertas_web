<?php

class Messages {

	public static function MsgError($string){
		$msg  = "<div class='alert'>";
		$msg .= "<button type='button' class='close' data-dismiss='alert'>&times;</button>";
		$msg .= "<strong>Advertencia! $string</strong>.";
		$msg .= "</div>";
		flash::error($msg);
	}

}