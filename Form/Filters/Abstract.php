<?php
/**
 * Abstract class for Form Filters
 * 
 * @author Davide Gullo <gullo at m4ss.net>
 * 
 */
abstract class MyFw_Form_Filters_Abstract {
    
    /**
     * filter value
     * 
     * @param mixed $value
     * @param array $params
     * @return mixed
     */
    static public function filter($value, array $params=array()) 
    { 
        return $value;
    }
    
}
