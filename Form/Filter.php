<?php
/**
 * 
 * Class to manage Form Filters
 * 
 * @author Davide Gullo <gullo at m4ss.net>
 * 
 */
class MyFw_Form_Filter {
    
    
    static public function filter($value, $filters) 
    {
        try {
            // check if filters is an array
            if(is_array($filters) && count($filters) > 0) {
                return self::_filterValue($value, $filters);
            }
            // There are not filters set, return the value
            return $value;
        } catch (MyFw_Exception $exc) {
            $exc->displayError();
        }
    }
    
    static private function _filterValue($value, $filters)
    {
        // apply filters to value
        foreach ($filters AS $filter => $filterInfo) {
            // separate filter name from params
            $params = array();
            if (is_string($filterInfo)) {
                $className = "MyFw_Form_Filters_" . ucfirst($filterInfo);
            } else {
                if(is_array($filterInfo)) {
                    $params = $filterInfo;
                }
                $className = "MyFw_Form_Filters_" . ucfirst($filter);
            }
            $filterObj = new $className;
            if(class_exists($className) && $filterObj instanceof MyFw_Form_Filters_Abstract ) {
                // get filter type
                $value = $filterObj::filter($value, $params);
            } else {
                throw new MyFw_Exception("The class '$className' does NOT exists!");                    
            }
        }
        return $value;
    }
    
    
    
}
