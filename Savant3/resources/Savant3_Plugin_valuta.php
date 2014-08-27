<?php

class Savant3_Plugin_valuta extends Savant3_Plugin {
	
	
	function valuta($val)
	{
		// convert val to Valuta String
        return number_format($val, 2, ",", ".") . "&nbsp;&euro;";
	}

}
?>