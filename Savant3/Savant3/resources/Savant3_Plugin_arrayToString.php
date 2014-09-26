<?php

class Savant3_Plugin_yesnoToBool extends Savant3_Plugin {
	
	
	function yesnoToBool($val)
	{
		// convert value S,Y on  and N on NO
		if (trim($val) == 'Y' OR trim($val) == 'S') {
			return true;
		} else {
			return false;
		}
	}

}
?>