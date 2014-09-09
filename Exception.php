<?php
/**
 * Define a custom exception class
 */
class MyFw_Exception extends Exception
{
    // Redefine the exception so message isn't optional
    public function __construct($message, $code = 0, Exception $previous = null) {
        // some code

        // make sure everything is assigned properly
        parent::__construct($message, $code, $previous);
    }

    // custom string representation of object
    public function __toString() {

        $str = "<h1>ERRORE: ".$this->getMessage()."</h1>";
        $str .= "CODE: ".$this->getCode()."<br>";
        $str .= "FILE: ".$this->getFile()."<br>";
        $str .= "LINE: ".$this->getLine()."<br>";
        $str .= "Stack Trace: <pre>".$this->getTraceAsString()."</pre>";
        return $str;
    }

    public function displayError($stop=true) {
        echo $this;
        if($stop) {
            die("<h3>SET TO DIE!</h3>");
        }
    }




}