<?php

class Savant3_Plugin_createLabelCondivisione extends Savant3_Plugin {
	
	
	function createLabelCondivisione($c)
	{
        switch ($c) {
            case "PRI":
                echo '<span class="label label-default">PRIVATO</span>';
                break;
            case "SHA":
                echo '<span class="label label-warning">CONDIVISO</span>';
                break;
            case "PUB":
                echo '<span class="label label-primary">PUBBLICO</span>';
                break;
        }

	}

}