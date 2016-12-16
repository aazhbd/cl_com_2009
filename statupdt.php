<?php
if($_POST)
{
    $stat  = addslashes(trim($_POST['stat']));
    $pid = $_POST['pid'];
    
    mysql_connect("localhost", "conlive_cuser", "mod#8121431");
    mysql_select_db("conlive_clive");
    
    //$l = mysql_connect("localhost", "root", "");
    //mysql_select_db("conlivenew");
    
    $date = date("Y-m-d G:i:s");
    $r = mysql_query("update profiles set pstatus = '$stat' , upd_date = '$date' where id = $pid ");

    if(isset($r)) echo "updated";
    else echo "not updated";    
}
else{
    echo "you are not allowed to access this file directly";
}
?>