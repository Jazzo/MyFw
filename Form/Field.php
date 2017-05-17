<?php
/**
 * Description of Field
 * 
 * @author Davide Gullo <gullo at m4ss.net>
 * 
 */
class MyFw_Form_Field {
    
    private $_name;
    private $_attrs;
    
    /**
     * 
     * @param string $name
     * @param array $attrs
     * 
     * $attrs array example:
     *    array(
            'label'     => 'Valido dal',
            'size'      => 20,
            'readonly'  => true,
            'placeholder' => 'Seleziona data...',
            'filters'   => array('date')
     *      )
     */
    public function __construct($name, array $attrs = array()) {
        $this->_name = $name;
        $this->_attrs = $attrs;
    }
    
    public function hasAttribute($attr)
    {
        return isset($this->_attrs[$attr]);
    }
    
    public function getAttribute($attr)
    {
        return ($this->hasAttribute($attr)) ? $this->_attrs[$attr] : null;
    }
    
    public function setAttribute($attr, $value)
    {
        $this->_attrs[$attr] = $value;
    }
    
    public function setValue($val)
    {
        $this->_attrs["value"] = $val;
    }
    
    public function getValue()
    {
        if( isset($this->_attrs["value"]) ) {
            return MyFw_Form_Filter::filter($this->_attrs["value"], $this->getFilters());
        }
        return null;
    }
    
    public function getUnfilteredValue()
    {
        return isset($this->_attrs["value"]) ? $this->_attrs["value"] : null;
    }
    
    public function getFilters()
    {
        return isset($this->_attrs["filters"]) ? $this->_attrs["filters"] : null;
    }

    public function setOptions(array $options) {
        $this->_attrs["options"] = $options;
    }
    
    public function isRequired()
    {
        return (isset($this->_attrs["required"]) && $this->_attrs["required"] === true);
    }
    
    public function setRequired() 
    {
        $this->_attrs["required"] = true;
    }
    
    public function isDisabled()
    {
        return (isset($this->_attrs["disabled"]) && $this->_attrs["disabled"] === true);
    }
    
    public function setDisabled() 
    {
        $this->_attrs["disabled"] = true;
    }

    public function getError()
    {
        return $this->_attrs["error"];
    }

    public function setError($msg=true) {
        $this->_attrs["error"] = $msg;
    }

    public function setValidators($validators)
    {
        $this->_attrs["validators"] = $validators;
    }

    public function hasValidators()
    {
        return isset($this->_attrs["validators"]);
    }

    public function getValidatorsParams()
    {
        return $this->_attrs["validators"];
    }
    
    public function validate() {
        
        $validators = $this->_attrs["validators"];
        $value = $this->getValue();
        foreach ($validators AS $validator => $params)
        {
            $valObjName = "MyFw_Form_Validators_" . $validator;
            if(class_exists($valObjName)) {
                $valObj = new $valObjName();
                $ret = $valObj->validate($value, $params);
                if($ret->return === false) {
                    $this->setError($ret->error_msg);
                    return false;
                }
            } else {
                $this->setError("ERRORE: Validator NOT exists!");
                return false;
            }

        }
    }
    
    public function getArrayAttributes()
    {
        return (array)$this->_attrs;
    }
    
}
