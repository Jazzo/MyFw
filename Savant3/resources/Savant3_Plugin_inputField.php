<?php

class Savant3_Plugin_inputField extends Savant3_Plugin {

    /*
     * Other attributes managed by a simple foreach
     */
    public $_attr_other = array(
                        'id',
                        'size',
                        'maxlength',
                        'rows',
                        'cols',
                        'class',
                        'onclick',
                        'placeholder'
    );
	/**
	* 
	* Generate an HTML for INPUT field
        * Manage:
            * <input type="$type" ...
            * <input type="hidden" ...
            * <textarea ...
	* 
	* @access public
	* 
	*/
	
	public function inputField($name, $attrs = array())
	{
        $html = "";
        
        // init TYPE Default Value: INPUT
        $type = isset($attrs["type"]) ? $attrs["type"] : "input";

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
        if( $type != "hidden") {
            $label = isset($attrs["label"]) ? $attrs["label"] : "Set Label...";
    		$html .= '<label for="'.$name.'">'.$label.':</label>'; // TODO: improve it with more kind of labels...
        }
        
        // set TYPE (manage also textarea)
        $is_textarea = false;
        if($type == "textarea") {
            $html .= '<textarea ';
            $is_textarea = true;
        } else {
            $html .= '<input type="'.$type.'"';
        }
        
        // set NAME
        if(isset($attrs["set_array"])) {
            $html .= ' name="'.$attrs["set_array"].'['.$name.']"';
        } else {
            $html .= ' name="'.$name.'"';
        }
        
        // set OTHER ATTRIBUTES 
        foreach ($this->_attr_other AS $attribute) {
            if(isset($attrs[$attribute])) {
                $html .= ' '.$attribute.'="'.$attrs[$attribute].'"';
            }
        }
        
        // DISABLED
        if(isset($attrs["disabled"]) && $attrs["disabled"] === true) {
            $html .= ' disabled';
        }

        // READONLY
        if(isset($attrs["readonly"]) && $attrs["readonly"] === true) {
            $html .= ' readonly';
        }
        
        // set VALUE if it's defined by attributes
        $value = null;
        if(isset($attrs["value"]) && $attrs["value"] != "") {
            $value = $attrs["value"];
        }
        // echo "Value: $value<br>";
        
        // CLOSE TAG and SET Value
        if( $is_textarea ) {
            $html .= '>'.$value.'</textarea>';
        } else {
            $html .= !is_null($value) ? ' value="'.$value.'"' : '';
            $html .= ' />';
        }
        
        // NOTE
        if(isset($attrs["note"])) {
            $html .= ' <i>'.$attrs["note"].'</i>';
        }        
        
        $html .= ( $type != "hidden") ? '<br />' : '';
        
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