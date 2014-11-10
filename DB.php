<?php

/**
 * Description of DB
 * 
 * @author gullo
 */
class MyFw_DB extends PDO {
    

    function __construct() {
        // get Config Application
        $appConfig = Zend_Registry::get('appConfig');
        $dbParams = $appConfig->database->params;
        $dsn = 'mysql:host='.$dbParams->host.';dbname='.$dbParams->dbname;
        $options = array();
        parent::__construct($dsn, $dbParams->username, $dbParams->password, $options);
        $this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
    }

/**
 *  Prepare SQL and execute UPDATE Query
 * 
 *  @param $tableName string
 *  @param $idFieldName mixed (string|array)
 *  @param $fields array
 */    
    function makeUpdate($tableName, $idFieldName, $fields) {
        
        if(count($fields) > 0) {
            $sth = $this->prepareUpdateQueryByParams($tableName, $idFieldName, $fields);
            $sth->execute($fields);
            echo $sth->errorCode()."--<br>";
/*            echo "<pre>";
            Zend_Debug::dump($sth->errorCode());
            echo "<pre>";
            die; */
        } else {
            throw new MyFw_Exception("SQL UPDATE ERROR: No Fields!");
        }
    }
    
    /**
     * @return PDOStatement
     */    
    function prepareUpdateQueryByParams($tableName, $idFieldName, $fields)
    {
        if(count($fields) > 0) {
            $sql = "UPDATE $tableName SET";
            foreach ($fields as $field => $value) {
                if( $field != $idFieldName ) {
                    $sql .= " $field= :$field,";
                }
            }
            $sql = substr($sql, 0, -1);
            $sql .= " WHERE ";
            if(is_string($idFieldName)) {
                $sql .= "$idFieldName= :$idFieldName";
            } else if(is_array($idFieldName) && count($idFieldName) > 0) {
                foreach ($idFieldName as $key => $fieldName) {
                    $sql .= "$fieldName= :$fieldName AND ";
                }
                $sql = substr($sql, 0, -4);
            }
            return $this->prepare($sql);
        }
        return null;
    }
    
/**
 *  Prepare SQL and execute INSERT Query
 * 
 *  @param $tableName string
 *  @param $fields array
 */    
    function makeInsert($tableName, $fields) {
        
        if(count($fields) > 0) {
            $sth = $this->prepareInsertQueryByParams($tableName, $fields);
            $sth->execute($fields);
            return $this->lastInsertId();
/*            echo "<pre>";
            Zend_Debug::dump($sth->errorCode());
            echo "<pre>";
            die; */
        } else {
            throw new MyFw_Exception("SQL UPDATE ERROR: No Fields!");
        }
    }
    
    /**
     * @return PDOStatement
     */
    function prepareInsertQueryByParams($tableName, $fields)
    {
        if(count($fields) > 0) {
            $sql = "INSERT $tableName SET";
            foreach ($fields as $field => $value) {
                $sql .= " $field= :$field, ";
            }
            $sql = substr($sql, 0, -2);
            return $this->prepare($sql);
        }
        return null;
    }
    
}