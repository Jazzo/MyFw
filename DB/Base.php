<?php

/**
 * Description of MyFw_DB_Base
 * 
 * @author gullo
 */
class MyFw_DB_Base {
    
    /**
     * It is a PDO instance (extended from MyFw_DB)
     * @var MyFw_DB
     */
    protected $db;
    
    /**
     * Default Fetch mode
     * @var int
     */
    protected $fetchMode = PDO::FETCH_OBJ;

    /**
     * Contrustor
     * Get the PDO instance
     */
    function __construct() {
        $this->db = Zend_Registry::get("db");
        
    }
    
    /**
     * Convert multidimensional array to a Single array by $fKey and $fVal
     * @param array $ar
     * @param string $fKey
     * @param string $fVal
     * @return array
     */
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