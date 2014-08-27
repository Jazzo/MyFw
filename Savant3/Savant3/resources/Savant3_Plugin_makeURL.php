<?php

class Savant3_Plugin_makeURL extends Savant3_Plugin {
	
	
	function makeURL($controller, $action = null, $params = null) {
        
        // set default URL
        $url = "/$controller/$action";
        // set params
		if (is_array($params) && count($params) > 0) {
            foreach ($params as $key => $value) {
                $url .= "/$key/$value";
            }
        }
		return $url;
	}

}
?>