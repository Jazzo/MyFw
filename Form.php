<?php

/**
 * Description of Form
 * 
 * @author gullo
 */
class MyFw_Form {
    
    protected $view;
    
    protected $_action;
    protected $_fields = array();
    protected $_hasErrors = false;
    

    function __construct() {
        $this->view = Zend_Registry::get("view");
        $this->createFields();
    }
    
    // overwrite it in the subclasses
    function createFields() { }

    function getFields() {
        return $this->_fields;
    }
    
    function getFieldByAttr($at, $val) {
        if(count($this->_fields) > 0) {
            $fields = array();
            foreach( $this->_fields AS $name => $attrs) {
                if( isset($attrs[$at]) && $attrs[$at] == $val) {
                    $fields[$name] = $attrs;
                }
            }
        }
        return (count($fields) > 0) ? $fields : null;
    }

    function addField($name, $attrs = array()) {
        $this->_fields[$name] = $attrs;
    }
    
    function removeField($name) {
        unset($this->_fields[$name]);
    }
    
    function setAction($act) {
        $this->_action = $act;
    }
    
    function getAction() {
        return $this->_action;
    }
    
    function setValues($arVal) {
        if(count($this->_fields) > 0) {
            foreach( $this->_fields AS $name => &$attrs) {
                // set Values for ARRAY
                if(is_array($arVal)) {
                    if( isset($arVal[$name])) {
                        $attrs["value"] = $arVal[$name];
                    }
                }
                // set Values for OBJECT
                if(is_object($arVal)) {
                    if( isset($arVal->$name)) {
                        $attrs["value"] = $arVal->$name;
                    }
                }
            }
        }
    }
    
    function setValue($field, $value) {
        $this->_fields[$field]["value"] = $value;
    }

    function getValue($field) {
        return $this->_fields[$field]["value"];
    }
    
    function getValues() {
        $values = array();
        if(count($this->_fields) > 0) {
            foreach( $this->_fields AS $name => $attrs) {
                $values[$name] = $attrs["value"];
            }
        }
        return $values;
    }

    function setOptions($field, array $options) {
        $this->_fields[$field]["options"] = $options;
    }
    
    
    function setRequired($field) {
        $this->_fields[$field]["required"] = true;
    }
    
    function setError($field, $msg=true) {
        $this->_fields[$field]["error"] = $msg;
        $this->_hasErrors = true;
    }
    
    function hasErrors() {
        return $this->_hasErrors;
    }
    
    function isValid($values) {
        if(count($this->_fields) > 0) {
            foreach( $this->_fields AS $name => &$attrs) {

                // set VALUE in array
                if(isset($values[$name])) {
                    $attrs["value"] = $values[$name];
                }

                // check VALIDATORS
                if(isset($attrs["validators"])) {
                    $error = $this->validate($name);
                    if($error !== false) {
                        $attrs["error"] = $error;
                        $this->_hasErrors = true;
                    }
                }                

                // check REQUIRED
                if(isset($attrs["required"]) && $attrs["required"] === true) {
                //echo "Field: $field<br>";
                    if(!isset($values[$name]) || $values[$name] == "") {
                        $attrs["error"] = true;
                        $this->_hasErrors = true;
                    }
                }
            }
        }
//        Zend_Debug::dump($this->_fields); die;
        // return TRUE if there are errors
        return ($this->hasErrors()) ? false : true;
    }
    
    
    

    function renderField($fieldName) {
        if(isset($this->_fields[$fieldName])) {
            if(isset($this->_fields[$fieldName]["type"])) {
                switch ($this->_fields[$fieldName]["type"]) {
                    case "select":
                        return $this->view->selectField($fieldName, $this->_fields[$fieldName]);

                        break;

                    case "checkbox":
                        return $this->view->checkboxField($fieldName, $this->_fields[$fieldName]);

                        break;

                    case "submit":
                    case "captcha":
                        return "";
                        break;

                    default:
                    case "input":
                    case "textarea":
                    case "hidden":
                        return $this->view->inputField($fieldName, $this->_fields[$fieldName]);
                        break;
                }
            } else {
                // Default Type: INPUT TEXT
                return $this->view->inputField($fieldName, $this->_fields[$fieldName]);
            }
        }
    }
    
    
    
    private function validate($name) {
        
        $validators = $this->_fields[$name]["validators"];
        $value = $this->_fields[$name]["value"];
        
        foreach ($validators as $key => $validator) {
            
            switch ($validator) {
                case "Number":
                        $value = str_replace(",", ".", $value);
                    
                        $this->_fields[$name]["value"] = (double)$value;
                        return is_numeric($value) ? false : "Deve essere in formato numerico. Es: 12,45 o 12.45 (usa la virgola o il punto per i decimali)";
                    break;

                default:
                        return false;
                    break;
            }
        }        
    }
        
    
}