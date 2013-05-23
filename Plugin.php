<?php
/**
 * Description of Plugin
 *
 * @author gullo
 */
class MyFw_Plugin {
    
    private $_plugins = array();


    function loadPlugin($p, $ns=null) {
        if(is_null($ns)) {
            $ns = "Plugin_";
        }
        $this->_plugins[] = $ns.$p;
    }

    function getAllPluginsInstances() {
        $inst = null;
        if(count($this->_plugins) > 0) {
            $inst = array();
            foreach($this->_plugins AS $pp) {
                $inst[$pp] = new $pp;
            }
        }
        return $inst;
    }
}
?>
