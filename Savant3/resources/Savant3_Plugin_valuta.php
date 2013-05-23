<?php

class Savant3_Plugin_valuta extends Savant3_Plugin {
	
	
	function valuta($val)
	{
		// convert value S,Y on Yes and N on NO
        return number_format($val, 2, ",", ".") . "&nbsp;&euro;";
	}

}
?>