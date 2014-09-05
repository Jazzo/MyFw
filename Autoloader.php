<?php
class Autoloader
{
	public static function Register() {
		return spl_autoload_register(array('Autoloader', 'autoload'));
	}

	public static function autoload($cName)
	{
        $path = str_replace(array('_', '\\'), DIRECTORY_SEPARATOR, $cName);
		$pObjectFilePath = $path.'.php';
        //echo "<br>Load class: ".$pObjectFilePath; //die;
        if (self::verifyClassExists($pObjectFilePath)) {
            require_once $pObjectFilePath;
        } else {
            throw new MyFw_Exception("The class $pObjectFilePath NON esiste!");
        }
    }

    private static function verifyClassExists($pOFP)
    {
        $arPaths = explode(PATH_SEPARATOR, get_include_path());
        if(count($arPaths) > 0)
        {
            foreach($arPaths AS $path)
            {
                // echo "<br>Path: ".$path;
                if (file_exists($path . DIRECTORY_SEPARATOR . $pOFP)) {
                    return true;
                }
            }
        }
        return false;
    }

}
