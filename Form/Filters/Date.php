<?php
/**
 * Description of filter Date
 * This filter 
 * 
 * @author gullo
 */
class MyFw_Form_Filters_Date extends MyFw_Form_Filters_Abstract
{
    const _MYFORMAT_DATE_DB = "Y-m-d";
    const _MYFORMAT_DATETIME_DB = "Y-m-d H:i:s";
    const _MYFORMAT_DATE_VIEW = "d/m/Y";
    const _MYFORMAT_DATETIME_VIEW = "d/m/Y H:i";
    
    static public function filter($value, array $params=array()) {
        
        // check for parameter CanBeNull
        if( isset($params["canBeNull"]) && $params["canBeNull"] == true && is_null($value) ) {
            return null;
        } else {
        // check for parameter FORMAT
            if( isset($params["format"])) {
                $format = $params["format"];
            } else {
                $format = self::_MYFORMAT_DATE_DB;
            }
        // try to get input parameter
            if(strlen($value) == 10 ) {
                $inputFormat = self::_MYFORMAT_DATE_VIEW;
            } else if(strlen($value) == 16) {
                $inputFormat = self::_MYFORMAT_DATETIME_VIEW;
            } else {
                throw new MyFw_Exception("Invalid Date format in MyFw_Form_Filters_Date!");
            }
            $dt = DateTime::createFromFormat($inputFormat, $value);
            return $dt->format($format);
        }
    }
    
}
