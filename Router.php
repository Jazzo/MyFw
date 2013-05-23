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

    private function _router() {

        // remove first slash /
        $uri = substr($this->_uri, 1);
    /*
     * set Controller and Action
     */
        // Set Default Values
        $controller = "index";
        $action = "index";

        // TRY to set values by REQUEST_URI
        $pcs = explode("/", $uri);
        if( is_array($pcs) &&
            count($pcs) > 0 &&
            $pcs[0] != ""
        ) {
            $controller = $pcs[0];
            $act = ( isset($pcs[1]) && $pcs[1] != "") ? $pcs[1] : "index";
            // remove query string from action
            $act = str_replace($_SERVER["QUERY_STRING"], "", $act);
            if(substr($act, -1) == "?") {
                $action = substr($act, 0, -1);
            } else {
                $action = $act;
            }
        }

    /*
     * Set Vars
     */
        if(count($pcs) > 2) {
            for($i=2; $i <= count($pcs) ; $i++) {
                if( isset($pcs[$i]) && isset($pcs[$i+1]) ) {
                    $this->_params[$pcs[$i]] = $pcs[$i+1];
                    $i++;
                }
            }
        }

    /*
     * Capitalize some letters of Controllers and Actions
     */
        $this->_controller = $this->capitalizeController($controller);
        $this->_action = $this->capitalizeAction($action);
        //echo "<br>Controller: ". $this->_controller;
        //echo "<br>Action: ". $this->_action;
        //Zend_Debug::dump($this->_params);
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
