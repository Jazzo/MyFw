<?php
/**
 * Description of ControllerFront
 *
 * @author gullo
 */
class MyFw_ControllerFront {
    
    static private $instance = null;
    
    private $_controller;
    private $_action;
    private $_params;
    private $_router;
    
    private $_app_env;
    private $_app_config;
    
    function __construct($env, $config) {
        $this->_app_env = $env;
        $this->_app_config = $config;
        
        // include and start autoloader
        include_once("Autoloader.php");
        Autoloader::Register();

        // set Instance
        self::$instance = $this;

        // start Router class
        $this->_router = new MyFw_Router(filter_input(INPUT_SERVER, "REQUEST_URI"));
        
    }
    
    // SINGLETON
    static public function getInst() {
        if( is_null(self::$instance) ) {
            throw new MyFw_Exception("You need to create the FIRST INSTANCE of ControllerFront!");
        }
        return self::$instance;
    }
    
    public function setRouter($router) {
        $this->_router = $router;
    }
    
    
    public function bootstrap() {
        $bs = new Bootstrap();
        $bs->run();
        return $this;
    }

    public function bootstrap_api() {
        $bs = new Bootstrap();
        $bs->run_api();
        return $this;
    }

    public function run() {
        $this->_controller = $this->_router->getController();
        $this->_action = $this->_router->getAction();
        $this->_params = $this->_router->getParams();
        $this->invokePluginsMethods('preDispatch');
        $this->_dispatch();
        $this->invokePluginsMethods('postDispatch');
        $layout = Zend_Registry::get("layout");
        $layout->display();
    }
    
    public function getController() {
        return $this->_controller;
    }
    
    public function getAction() {
        return $this->_action;
    }

    public function getParams() {
        return $this->_params;
    }


    public function setController($c) {
        $this->_controller = $c;
    }

    public function setAction($a) {
        $this->_action = $a;
    }

    public function setParams($arP) {
        $this->_params = $arP;
    }
    


    private function _dispatch() {
        $cObj = $this->invokeControllerAction();
        if($cObj instanceof MyFw_Controller) {
            $cObj->initContent();
        } else {
            throw new MyFw_Exception("ERROR: Controller is NOT an object!");
        }
    }
    
    
    function invokeControllerAction()
    {
        try {
            $controllerName = "Controller_".$this->_controller;
            if(class_exists($controllerName)) {
                $controllerObj = new $controllerName;
                $actionName = $this->_action."Action";
                //echo "<br>ActionController call -> $controllerName :: $actionName";
                // Invoke Action and return the Controller Object
                if(method_exists($controllerObj, $actionName)) {
                    $controllerObj->$actionName();
                    return $controllerObj;
                }
            }
        } catch (MyFw_Exception $exc) {
            $exc->displayError();
        }

        // ERROR 404
        $this->_controller = 'Index';
        $this->_action = 'error';
        $this->_params = array("code" => 404);
        return $this->invokeControllerAction();
    }



    private function invokePluginsMethods($method) {
        $plugin = Zend_Registry::get('plugin');
        $ppObj = $plugin->getAllPluginsInstances();
        if(!is_null($ppObj)) {
            foreach($ppObj AS $name => $instance) {
                $instance->$method($this);
            }
        }
    }
        
}