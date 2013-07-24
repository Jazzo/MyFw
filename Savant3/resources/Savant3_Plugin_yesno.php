<?php

class Savant3_Plugin_yesno extends Savant3_Plugin {
	
	
	function yesno($val)
	{
		// convert value S,Y on  and N on NO
		if (trim($val) == 'Y') {
			return "Yes";
        } else if(trim($val) == 'S') {
            return "Si";
		} else {
			// no 
			return "No";
		}
	}

}
?>