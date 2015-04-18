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
    protected function createFields() { }

    public function addField($name, $attrs = array()) {
        $this->_fields[$name] = new MyFw_Form_Field($name, $attrs);
    }
            
    public function getFields() {
        return $this->_fields;
    }
    
    public function getField($name) {
        return $this->_fields[$name];
    }
    
    public function getFieldByAttr($attr, $val) {
        if(count($this->_fields) > 0) {
            $fields = array();
            foreach( $this->_fields AS $name => $fieldObj) {
                if( $fieldObj->hasAttribute($attr) && $fieldObj->getAttribute($attr) == $val) {
                    $fields[$name] = $fieldObj;
                }
            }
        }
        return (count($fields) > 0) ? $fields : null;
    }

    public function removeField($name) {
        unset($this->_fields[$name]);
    }
    
    public function setAction($act) {
        $this->_action = $act;
    }
    
    public function getAction() {
        return $this->_action;
    }
    
    public function setValues($arVal) {
        if(count($this->_fields) > 0) {
            foreach( $this->_fields AS $name => &$fieldObj) 
            {
                // set Values for ARRAY
                if(is_array($arVal) && isset($arVal[$name])) {
                    $fieldObj->setValue($arVal[$name]);
                }
                // set Values for OBJECT
                if(is_object($arVal) && isset($arVal->$name)) {
                    $fieldObj->setValue($arVal->$name);
                }
            }
        }
    }
    
    public function setValue($field, $value) {
        $this->_fields[$field]->setValue($value);
    }

    public function getValue($field) {
        return $this->_fields[$field]->getValue();
    }

    public function getUnfilteredValue($field) {
        return $this->_fields[$field]->getUnfilteredValue();
    }
    
    public function getValues() {
        $values = array();
        if(count($this->_fields) > 0) {
            foreach( $this->_fields AS $name => $fieldObj) {
                $values[$name] = $fieldObj->getValue();
            }
        }
        return $values;
    }

    public function setError($field, $msg=true) {
        $this->_fields[$field]->setError($msg);
        $this->_hasErrors = true;
    }
    
    public function hasErrors() {
        return $this->_hasErrors;
    }
    
    public function isValid($values) {
        if(count($this->_fields) > 0) {
            foreach( $this->_fields AS $name => &$fieldObj) {
                if(!$fieldObj->isDisabled())
                {
                    // set VALUE in field
                    if(isset($values[$name])) {
                        $fieldObj->setValue($values[$name]);
                    }

                    // check VALIDATORS
                    if($fieldObj->hasValidators()) {
                        $error = $this->validate($name);
                        if($error !== false) {
                            $this->setError($name, $error);
                        }
                    }

                    // check REQUIRED
                    if($fieldObj->isRequired()) {
                        if(!isset($values[$name]) || $values[$name] == "") {
                            $this->setError($name, true);
                        }
                    }
                }
            }
        }
//        Zend_Debug::dump($this->_fields); die;
        // return TRUE if there are errors
        return ($this->hasErrors()) ? false : true;
    }
    
    public function renderField($fieldName) {
        if(isset($this->_fields[$fieldName])) {
            switch ($this->_fields[$fieldName]->getAttribute("type")) {
                case "select":
                    return $this->view->selectField($fieldName, $this->_fields[$fieldName]->getArrayAttributes());

                case "checkbox":
                    return $this->view->checkboxField($fieldName, $this->_fields[$fieldName]->getArrayAttributes());

                case "submit":
                case "captcha":
                    return "";

                default:
                case "input":
                case "textarea":
                case "hidden":
                    return $this->view->inputField($fieldName, $this->_fields[$fieldName]->getArrayAttributes());
            }
        }
        return "";
    }
    
}