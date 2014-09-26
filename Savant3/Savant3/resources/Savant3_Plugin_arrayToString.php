<?php

class Savant3_Plugin_arrayToString extends Savant3_Plugin {
	
	
	function arrayToString(array $ar, $noVal="Nessuno")
	{
        echo (count($ar) > 0) ? implode(", ", $ar) : $noVal;
	}

}