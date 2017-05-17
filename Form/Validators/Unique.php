<?php

/**
 * Created by PhpStorm.
 * User: gullo
 * Date: 11/04/17
 * Time: 22:38
 */
class MyFw_Form_Validators_Unique extends MyFw_Form_Validators_Abstract
{
    /**
     * validator value
     *
     * @param mixed $value
     * @param array $params
     * @return mixed
     */
    static public function validate($value, array $params=array())
    {
        $return = (object)array(
            'return'        => true,
            'error_msg'     => "OK"
        );

        // get params
        if(isset($params[0]) && isset($params[1])) {
            $table = $params[0];
            $field = $params[1];
        }

        // check for DUPLICATED!
        $db = Zend_Registry::get("db");
        $sth_app = $db->prepare("SELECT * FROM $table WHERE $field = :value");
        $sth_app->execute(array('value' => $value));
        $check = $sth_app->fetch(PDO::FETCH_OBJ);
        if($check !== false) {
            $return->return = false;
            $return->error_msg = "ERROR: campo '$field' esistente!";
        }

        return $return;
    }

}