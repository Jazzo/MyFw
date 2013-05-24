<?php
class Autoloader
{
	public static function Register() {
		return spl_autoload_register(array('Autoloader', 'LoadClass'));
	}

	public static function LoadClass($cName)
	{
        $path = str_replace("_", "/", $cName);
		$pObjectFilePath = $path.'.php';
        //echo "<br>Load class: ".$pObjectFilePath; //die;
        if (self::verifyClassExists($pObjectFilePath)) {
        require_once $pObjectFilePath;
        } else {
            throw new Zend_Exception("ERRORE: $pObjectFilePath NON esiste!");
        }
    }

    private static function verifyClassExists($pOFP)
    {
        $arPaths = explode(":", get_include_path());
        if(count($arPaths) > 0)
        {
            foreach($arPaths AS $path)
            {
                // echo "<br>Path: ".$path;
                if (file_exists($path . "/" . $pOFP)) {
                    return true;
                }
            }
        }
        return false;
    }

}