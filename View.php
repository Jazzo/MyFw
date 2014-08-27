<?php

/**
 * Description of MyFw_View
 * Is a simple View pattern based on Savant3
 * 
 * @author gullo
 */
include_once 'Savant3/Savant3.php';
class MyFw_View extends Savant3 {
    
    function __construct($config = null) {
        parent::__construct($config);
    /*
     * Set Template Directory
     */
        $appConfig = Zend_Registry::get('appConfig');
        $this->setPath('template', $appConfig->template->path_view);
        
    /*
     * Set Date Configurations
     */
        $conf = array(
            'custom' => array(
                'mydate' => '%b %d, %Y',
                'mytime' => '%R'
            )
        );
        $this->setPluginConf('date', $conf);

    }
    
}