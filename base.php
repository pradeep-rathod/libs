<?php

class DB extends PDO
{
    private $objPDO;
    
    function __construct($strHost, $strDBName, $strUser="", $strPass=""){
        $this->objPDO = new PDO("mysql:host=".$strHost.";dbname=".$strDBName.";charset=UTF-8", $strUser, $strPass);
        
    }
    
    function getAll($strSQL)
    {
        try
        {
            if(trim($strSQL) != "")
            {
                $objStmt = $this->prepare($strSQL);
                $objStmt->execute();
                return $objStmt->fetchAll(PDO::FETCH_ASSOC);
            }
        }
        catch(Exception $objException)
        {
            echo $objException->getMessage();exit;
        }
    }
    
    function getRows($strTableName, $strFields, $strWhere="", $strOrder="", $strLimit="")
    {
        $strSQL = "";
        try
        {
            $strSQL = $this->getSQL($strTableName, $strFields, $strWhere, $strOrder, $strLimit);
            return $this->getAll($strSQL);
        }
        catch(Exception $objException)
        {
            echo $objException->getMessage();exit;
        }
            
    }
    
    private function getSQL($strTableName, $strFields, $strWhere="", $strOrder="", $strLimit="")
    {
        try
        {
            if(trim($strTableName) != "")
            {
                $strSQL = "SELECT ";
                
                if(is_array($strFields))
                {
                    $strField = @implode(", ", $strFields);
                    $strSQL .= $strField;
                }
                else
                {
                    $strSQL .= $strFields;
                }
                
                $strSQL .= " FROM ".$strTableName;
                
                if(trim($strWhere)!= "")
                {
                    $strSQL .= " WHERE ".$strWhere;
                }
                if(trim($strOrder) != "")
                {
                    $strSQL .= " ORDER BY ".$strOrder;
                }
                if(trim($strLimit) != "")
                {
                    $strSQL .= " LIMIT ".$strLimit;
                }
            }
        }
        catch(Exception $objException)
        {
            echo $objException->getMessage();exit;
        }
    }
}
//$objDB = new DB("localhost", "dbdn", "root", "root");
?>
