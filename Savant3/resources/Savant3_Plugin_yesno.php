<?php

class Savant3_Plugin_yesno extends Savant3_Plugin {
	
	
	function yesno($val)
	{
		// convert value S,Y on Yes and N on NO
		if (trim($val) == 'Y' || trim($val) == 'Y') {
			return "Yes";
		} else {
			// no 
			return "No";
		}
	}

}
?>