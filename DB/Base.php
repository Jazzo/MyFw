<?php

/**
 * Description of MyFw_DB_Base
 * 
 * @author gullo
 */
class MyFw_DB_Base {

    protected $db;
    protected $fetchMode = PDO::FETCH_OBJ;

    function __construct() {
        $this->db = Zend_Registry::get("db");
        
    }
    
    function convertToSingleArray($ar, $fKey, $fVal) {
        $arRes = array();
        if(count($ar) > 0) {
            foreach($ar AS $k => $val) {
                if(is_array($val)) {
                    $arRes[$val[$fKey]] = $val[$fVal];
                } else if(is_object($val)) {
                    $arRes[$val->$fKey] = $val->$fVal;
                }
            }
        }
        return $arRes;
    }
    
}