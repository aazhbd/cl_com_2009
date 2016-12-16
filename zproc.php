<?php
if($_POST)
{
    $url = $_POST['name'];
    
    mysql_connect("localhost", "conlive_cuser", "mod#8121431");
	mysql_select_db("conlive_clive");
	
	//$l = mysql_connect("localhost", "root", "");
    //mysql_select_db("conlivenew");
    
    if(!isset($_POST['$type']))
    {
        $r = mysql_query("select * from blogs where url = '$url'");

        $c = 0;
        $c = mysql_num_rows($r);

        if($c > 0) echo "not available";
        else echo "available";
    }
    else
    {
        extract($_POST);
        if($type == 'art')
        {
            $r = mysql_query("select * from articles where url = '$url'");

            $c = 0;
            $c = mysql_num_rows($r);

            if($c > 0) echo "not available";
            else echo "available";
        }
    }    
}
else{
    echo "you are not allowed to access this file directly";
}
?>