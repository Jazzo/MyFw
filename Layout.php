<?php

/**
 * Description of Layout
 * 
 * @author gullo
 */
class MyFw_Layout {
    
    private $hasToDisplay = true;
    private $tpl;
    private $arContents = array();
    private $contentName = "content";
    
    function __construct() {
        
        $appConfig = Zend_Registry::get('appConfig');
        $this->tpl = new MyFw_View(array('template_path' => $appConfig->template->path_layout));
    }
    
    function setContentByName($name, $tpl) {
        $this->arContents[$name] = $tpl;
    }

    function setContent($tpl) {
        $this->setContentByName($this->contentName, $tpl);
    }
    
    function disableDisplay() {
        $this->hasToDisplay = false;
    }
    
    function display() {
        // check if has to display
        if($this->hasToDisplay) {
            // set some other tpl contents...
            if( count($this->arContents) > 0) {
                foreach ($this->arContents AS $name => $tpl) {
                    $this->tpl->assign($name, $tpl);
                }
            }
            // Display the LAYOUT template using the assigned values
            $this->tpl->display('layout.tpl.php');
        }
    }
}