<?php
/**
 * Description of Router
 *
 * @author gullo
 */
class MyFw_Router {

    private $_uri = null;
    private $_controller;
    private $_action;
    private $_params;
    private $_fragment;


    function  __construct($uri) {
        $this->_uri = $uri;
        $this->_router();
    }

    function getController() {
        return $this->_controller;
    }

    function getAction() {
        return $this->_action;
    }

    function getParams() {
        return $this->_params;
    }
    
    function getFragment() {
        return $this->_fragment;
    }

    private function _router() {

        // get the PATH from URL
        $path = parse_url($this->_uri, PHP_URL_PATH);

        // Set Default Values
        $controller = "index";
        $action = "index";
        
        // TRY to set values by REQUEST_URI
        $pcs = explode("/", substr($path, 1));// remove first slash /

        if( is_array($pcs) &&
            count($pcs) > 0 &&
            $pcs[0] != ""
        ) {
            $controller = $pcs[0];
            $action = ( isset($pcs[1]) && $pcs[1] != "") ? $pcs[1] : "index";
        }
        
        // get some VARS in the PATH
        $params = array();
        if(count($pcs) > 2) {
            for($i=2; $i <= count($pcs) ; $i++) {
                if( isset($pcs[$i]) && isset($pcs[$i+1]) ) {
                    $params[$pcs[$i]] = $this->filterParamValue($pcs[$i+1]);
                    $i++;
                }
            }
        }

        // get Vars by QUERY STRING
        $oAr = array();
        parse_str(parse_url($this->_uri, PHP_URL_QUERY), $oAr);
        if(count($oAr) > 0 ) {
            foreach($oAr AS $vName => $vVal) {
                $params[$vName] = $this->filterParamValue($vVal);
            }
        }
        
    /*
     * Capitalize some letters of Controllers and Actions
     */
        $this->_controller = $this->capitalizeController($controller);
        $this->_action = $this->capitalizeAction($action);
        $this->_params = $params;
        $this->_fragment = parse_url($this->_uri, PHP_URL_FRAGMENT);
        //echo "<br>Controller: ". $this->_controller;
        //echo "<br>Action: ". $this->_action;
    }
    
    private function filterParamValue($p)
    {
        if($p == "true" || $p == "false" || $p == "TRUE" || $p == "FALSE")
        {
            return filter_var($p, FILTER_VALIDATE_BOOLEAN);
        }
        return $p;
    }

    private function capitalizeController($t) {
        $t = strtolower($t);
        $ar = explode("-", $t);
        // Zend_Debug::dump($ar);
        if(is_array($ar) && count($ar) > 1) {
            $tt = "";
            for($i=0; $i < count($ar); $i++) {
                $tt .= ucfirst($ar[$i]);
            }
        } else {
            $tt = ucfirst($ar[0]);
        }
        return $tt;
    }

    private function capitalizeAction($t) {
        $t = strtolower($t);
        $ar = explode("-", $t);
        // Zend_Debug::dump($ar);
        if(is_array($ar) && count($ar) > 1) {
            $tt = "";
            for($i=0; $i < count($ar); $i++) {
                $tt .= ucfirst($ar[$i]);
            }
        } else {
            $tt = $ar[0];
        }
        return lcfirst($tt);
    }




}



if ( false === function_exists('lcfirst') ) {
    function lcfirst( $str ) {
        return (string)(strtolower(substr($str,0,1)).substr($str,1));
    }
}

if ( false === function_exists('ucfirst') ) {
    function ucfirst( $str ) {
        return (string)(strtoupper(substr($str,0,1)).substr($str,1));
    }
}
