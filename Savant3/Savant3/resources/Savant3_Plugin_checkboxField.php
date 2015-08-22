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
        if(isset($attrs["label"])) 
        {
            $html .= '<label for="'.htmlspecialchars($name).'">'.htmlspecialchars($attrs["label"]).':</label>'; // TODO: improve it with more kind of labels...
        }
        
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
                    
                    // SET Default HTML
                    $html .= '<input type="checkbox" value="'.htmlspecialchars($optKey).'" name="'.htmlspecialchars($name).'[]"';
                    
                    // set OTHER ATTRIBUTES 
                    foreach ($this->_attr_other AS $attribute) {
                        if(isset($attrs[$attribute])) {
                            $html .= ' '.htmlspecialchars($attribute).'="'.htmlspecialchars($attrs[$attribute]).'"';
                        }
                    }
                    
                    // SET selected
                    if(isset($value) && is_array($value) && count($value) > 0) {
                        if(in_array($optKey, $value)) {
                                $html .= " checked";
                        }
                    }
                    
                    // SET DISABLED
                    if(isset($attrs["disabled"]) && $attrs["disabled"] === true) {
                        $html .= " disabled";
                    }

                    // CLOSE SELECT tag
                    $html .= ' /> '.htmlspecialchars($optVal).'<br />';
                }
            }
        } else {
            // SET SINGLE CHECKBOX
            $html .= '<input type="checkbox" value="'.htmlspecialchars($value).'" name="'.htmlspecialchars($name).'"';
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