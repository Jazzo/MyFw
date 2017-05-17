<?php
/**
 * Abstract class for Form Validators
 * 
 * @author Davide Gullo <gullo at m4ss.net>
 * 
 */
abstract class MyFw_Form_Validators_Abstract {
    
    /**
     * validator value
     * 
     * @param mixed $value
     * @param array $params
     * @return mixed
     */
    static public function validate($value, array $params=array())
    { 
        return false;
    }
    
}
