<?php

class dblib
{
    var $err;
    var $dbh;

	function dblib($host, $dbname, $user, $pass)
	{
        $this->err = "";
        
        try
        {
            $this->dbh = new PDO('mysql:host='.$host.';dbname='.$dbname.'', $user, $pass);
            $this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->dbh->setAttribute(PDO::ATTR_PERSISTENT, false);
        }
        catch (PDOException $e)
        {
            $this->err = "error occured : " . $e->errorInfo[2];
        }
	}
    
    function executeQuery($query)
    {
        $result = array();
        
        try{
            $st = $this->dbh->prepare($query);
            
            $st->execute();
            
            $r = $st->fetchAll();
            
            foreach ($r as $line)
            {
                $result[] = $line;
            }
        }
        catch(PDOException $e)
        {
            $this->err = "error occured : " . $e->errorInfo[2];
            return false;
        }
        
        return $result;
    }
    
    function executeNonQuery($query)
    {
        try{
            $st = $this->dbh->prepare($query);
            $st->execute();
        }
        catch(PDOException $e)
        {
            $this->err = "error occured : " . $e->errorInfo[2];
            return false;
        }
        
        return true;
    }
    
    function selectData($query)
    {
        $result = array();
        
        $q = trim($query);
        $p = stripos($q, "select");
        if($p === false)
        {
            $this->err = "invalid request";
            return false;
        }
        
        try{
            $st = $this->dbh->prepare($query);
            $st->execute();
            $r = $st->fetchAll();
            foreach ($r as $line)
            {
                $result[] = $line;
            }
        }
        catch(PDOException $e)
        {
            $this->err = "error occured : " . $e->errorInfo[2];
            return false;
        }
        
        return $result;
    }
    
    function insertData($query)
    {
        $q = trim($query);
        $p = stripos($q, "insert");
        if($p === false)
        {
            $this->err = "invalid request";
            return false;
        }
        
        try{
            $st = $this->dbh->prepare($query);
            $st->execute();
        }
        catch(PDOException $e)
        {
            $this->err = "error occured : " . $e->errorInfo[2];
            return false;
        }
        
        return true;
    }
    
    function updateData($query)
    {
        $q = trim($query);
        $p = stripos($q, "update");
        if($p === false)
        {
            $this->err = "invalid request";
            return false;
        }
        
        try{
            $st = $this->dbh->prepare($query);
            $st->execute();
        }
        catch(PDOException $e)
        {
            $this->err = "error occured : " . $e->errorInfo[2];
            return false;
        }
        
        return true;
    }
    
    function deleteData($query)
    {
        $q = trim($query);
        $p = stripos($q, "delete");
        if($p === false)
        {
            $this->err = "invalid request";
            return false;
        }
        
        try{
            $st = $this->dbh->prepare($query);
            $st->execute();
        }
        catch(PDOException $e)
        {
            $this->err = "error occured : " . $e->errorInfo[2];
            return false;
        }
        
        return true;
    }
    
    function closeDB()
    {
        $this->dbh = null;
    }
    
    function insertImage($query, $large_image, $thumb_image, $strparams)
    {
        try
        {
            $stmt = $this->dbh->prepare($query);
            
            for($i=0; $i < (count($strparams)); $i++ )
            {
                $stmt->bindParam($i + 1, $strparams[$i]);
            }
            $stmt->bindParam($i+1, $large_image, PDO::PARAM_LOB);
            $stmt->bindParam($i+2, $thumb_image, PDO::PARAM_LOB);
            
            $this->dbh->beginTransaction();
            $stmt->execute();
            $this->dbh->commit();
        }
        catch(PDOException $e)
        {
            $this->err = "error occured : " . $e->errorInfo[2];
            return false;
        }
        
        return true;
    }
    
    function insertAudio($query, $audio, $strparams)
    {
        try
        {
            $stmt = $this->dbh->prepare($query);
            for($i=0; $i < (count($strparams)); $i++ )
            {
                $stmt->bindParam($i + 1, $strparams[$i]);
            }
            $stmt->bindParam($i+1, $audio, PDO::PARAM_LOB);
            
            $this->dbh->beginTransaction();
            $stmt->execute();
            $this->dbh->commit();
        }
        catch(PDOException $e)
        {
            $this->err = "error occured : " . $e->errorInfo[2];
            return false;
        }
        
        return true;
    }    
}

?> 
