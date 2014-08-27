<?php

class Savant3_Plugin_checkboxField extends Savant3_Plugin {

    /*
     * Other attributes managed by a simple foreach
     */
    public $_attr_other = array(
                        'id',
                        'class'
    );
	/**
	* 
	* Generate an HTML for CHECKBOX field
        * Manage:
            * <checkbox name="$name" value="$value1" ...
              <checkbox name="$name" value="$value2" ...
	* 
	* @access public
	* 
	*/
	
	public function checkboxField($name, $attrs = array())
	{
        $html = "";
        
        // init ID Default Value: INPUT
        if(!isset($attrs["id"])) {
            $attrs["id"] = $name;
        }
        
        // check if ERRORS exists
        $hasError = isset($attrs["error"]) ? true : false;
        if($hasError) {
            $html .= '<div class="error">';
        }
        
        // set LABEL
        $label = isset($attrs["label"]) ? $attrs["label"] : "Set Label...";
        $html .= '<label for="'.$name.'">'.$label.':</label>'; // TODO: improve it with more kind of labels...
        
        // set VALUE if it's defined by attributes
        $value = null;
        if(isset($attrs["value"]) && $attrs["value"] != "") {
            $value = $attrs["value"];
        }
        // echo "Value: $value<br>";

        // DIV BOX
        $html .= '<div class="checkbox_box">';
        
        // set CHECKBOXES with the SAME NAME
        if(isset($attrs["options"]) && is_array($attrs["options"])) {
            if(count($attrs["options"]) > 0 ) {
                foreach ($attrs["options"] as $optKey => $optVal) {
                    
                    // set NAME
                    if(isset($attrs["set_array"])) {
                        $name = $attrs["set_array"].'['.$optKey.']';
                    } else {
                        $name = $optKey;
                    }
                    
                    // SET Default HTML
                    $html .= '<input type="checkbox" value="Y" name="'.$name.'"';
                    
                    // set OTHER ATTRIBUTES 
                    foreach ($this->_attr_other AS $attribute) {
                        if(isset($attrs[$attribute])) {
                            $html .= ' '.$attribute.'="'.$attrs[$attribute].'"';
                        }
                    }
                    
                    // SET selected
                    if(isset($value) && is_array($value) && count($value) > 0) {
                        foreach ($value AS $key => $val) {
                            if($optKey == $key) {
                                $html .= " checked";
                            }
                        }
                    }

                    // CLOSE SELECT tag
                    $html .= ' /> '.$optVal.'<br />';
                }
            }
        } else {
            // SET SINGLE CHECKBOX
            $html .= '<input type="checkbox" value="'.$value.'" name="'.$name.'"';
            // CLOSE SELECT tag
            $html .= ' /><br />';
        }

        $html .= '</div>';
        
        // ERRORS message
        if($hasError) {
            if( is_bool($attrs["error"]) ) {
                if( isset($attrs["errorMessage"]) && $attrs["errorMessage"] != "" ) {
                    $error = $attrs["errorMessage"];
                } else {
                    $error = 'Questo campo è obbligatorio!';
                }
            } else {
                $error = $attrs["error"];
            }
            $html .= "<p>" . $error . "</p></div>";
        }
		
		return $html;
	}
}
?>