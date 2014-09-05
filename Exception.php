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

        echo "<h1>ERRORE: ".$this->getMessage()."</h1>";
        echo "CODE: ".$this->getCode()."<br>";
        echo "Stack Trace: <pre>".$this->getTraceAsString()."</pre>";
        return __CLASS__ . ": [{$this->code}]: --> {$this->message} <--";
    }

    public function displayError($stop=true) {
        echo $this;
        if($stop) {
            die("<h3>SET TO DIE!</h3>");
        }
    }




}