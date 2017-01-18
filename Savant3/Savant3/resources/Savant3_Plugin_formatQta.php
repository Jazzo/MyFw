<?php

class Savant3_Plugin_formatQta extends Savant3_Plugin {
	
	
	function formatQta($val)
	{
        $hasDecimal = is_numeric( $val ) && intval( $val ) != $val;
        return $hasDecimal ? number_format($val, 3, ",", ".") : intval($val);
	}

}