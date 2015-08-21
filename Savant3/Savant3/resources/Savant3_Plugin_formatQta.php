<?php

class Savant3_Plugin_formatQta extends Savant3_Plugin {
	
	
	function formatQta($val, $udm="")
	{
        $hasDecimal = is_numeric( $val ) && floor( $val ) != $val;
        return $hasDecimal ? (number_format($val, 3, ",", ".") . " " . $udm) : floor($val);
	}

}