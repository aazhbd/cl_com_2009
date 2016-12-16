<?php
function dbConn()
{
    $r = fopen("C://fp.txt","w+");
    $con = mysql_connect("localhost", "root", "") 
    or /*fprintf($r, "\n\nerror occured %s", mysql_error());*/ die('Error occured: '.mysql_error());
    mysql_select_db("conlive") or die('Error occured: '.mysql_error());
}

function insertData($table, $fields, $values)
{
    $n = count($fields);
    $m = count($values);
    
    if($n != $m) return false;
    
    for($i = 0; $i < $m ; $i++)
    {
        $values[$i] = mysql_real_escape_string($values[$i]);
    }
    
    $query = "insert into `" . $table . "`(";

    for($i = 0; $i < $n; $i++)
    {
        $query .= "`" . $fields[$i] . "`";
        if($i != ($n - 1)) $query .= ",";
    }
    
    $query .= ") values(";
    
    for($i = 0; $i < $m; $i++)
    {
        $query .= "'" . $values[$i] . "'";
        if($i != ($m - 1)) $query .= ",";
    }
    $query .= ")";
    
    if($r = mysql_query($query))
    {
        return true;
    }
    else
    {
        return mysql_error();
    }
}

function selectData($query)
{
    $result = array();
    $q = stripslashes(mysql_real_escape_string($query));
    
    if($r = mysql_query($q))
    {
        while($line = mysql_fetch_array($r, MYSQL_ASSOC))
        {
            $result[] = $line;
        }
        
        return $result;
    }
    else
    {
        return mysql_error();
    }
}
?>
