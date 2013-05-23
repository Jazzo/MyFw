<?php
/**
 * Description of Controller
 * 
 * @author gullo
 */
class MyFw_Controller {
    
    protected $view;
    private $_tpl = null;

    function __construct() {
        // call init from subclass
        $this->_init();
        // init view
        $this->view = Zend_Registry::get("view");
    }
    
    protected function _init() {}
    
    
    protected function getParam($param) {
        $fc = MyFw_ControllerFront::getInst()->getParams();
        if(isset($fc[$param])) {
            return $fc[$param];
        }
        return null;
    }
    
    protected function getParams() {
        return MyFw_ControllerFront::getInst()->getParams();
    }
    
    protected function getFrontController() {
        return MyFw_ControllerFront::getInst();
    }
    
    protected function getView() {
        return $this->view;
    }
    
    protected function getDB() {
        return Zend_Registry::get("db");
    }

    protected function setTpl($tpl) {
        $this->_tpl = $tpl;
    }

    

    // init Stadard view with Layout
    public function initContent() {
        // get default tpl if it is null
        if( is_null($this->_tpl) ) {
            $this->_tpl = $this->getDefaultTpl();
        }
        $myTpl = $this->view->fetch($this->_tpl);
        // set content in layout
        $layout = Zend_Registry::get("layout");
        $layout->setContent( $myTpl );
    }
    
    // init Json Response
    protected function initJson() {
        // get default tpl
        $tpl = $this->getDefaultTpl();
        $myTpl = $this->view->fetch($tpl);
        // disable layout
        $layout = Zend_Registry::get("layout");
        $layout->disableDisplay();
        echo json_encode($myTpl);
        exit;
    }



    protected function forward($controller, $action = 'index', $params=array()) {
        $fc = $this->getFrontController();
        $fc->setController($controller);
        $fc->setAction($action);
        $fc->setParams($params);
        $cObj = $fc->invokeControllerAction();
        $cObj->initContent();
    }
    
    protected function redirect($controller, $action = 'index', $params=array()) {
        $paramsURL = "";
        if(is_array($params) && count($params) > 0) {
            foreach ($params as $key => $value) {
                $paramsURL .= '/' . $key . '/' . $value;
            }
        }
        
        header('Location: /'.$controller.'/'.$action . $paramsURL);
        exit;
    }
    
    
    /**
     * Return a Zend_Controller_Request_Http instance
     *
     * @return Zend_Controller_Request_Http
     */
    protected function getRequest()
    {
        return new Zend_Controller_Request_Http();
    }

    
    
    // get Default Tpl
    private function getDefaultTpl() {
        $fc = $this->getFrontController();
        $controller = $fc->getController();
        $action = $fc->getAction();
        // set default tpl
        return strtolower("$controller/$action.tpl.php");
    }

}
