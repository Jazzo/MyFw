<?php

class Savant3_Plugin_partial extends Savant3_Plugin {
	
	
	function partial($viewScript, $vars = array()) {
        
        $view = new MyFw_View();
        if(count($vars) > 0) {
            foreach ($vars as $key => $value)
            {
                $view->assign($key, $value);
            }
        }
        
        return $view->fetch($viewScript);
	}

}
?>