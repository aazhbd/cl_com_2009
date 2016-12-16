<?php
require_once('config/project.php');
$con = new Project();

$res = array();
if(isset($_GET["q"]) && isset($_SESSION['login']) == true)
{
    $q = $_GET["q"];
    
    if(isset($_SESSION['login'] ) == true)
    {
        $l = $_SESSION['login'];
        $islogin = true;
        $email = $l->getEmail();
    }
    
    if($q == "")
    {
        return "No Results Found";
    }
    else
    {
        
        mysql_connect("localhost", "conlive_cuser", "mod#8121431");
        mysql_select_db("conlive_clive");
        
        //$l = mysql_connect("localhost", "root", "");
        //mysql_select_db("conlivenew");
        
        $qr = "select uid, f_name, l_name, email, profiles.id as pid, user_imgs_id, friends.id as fid from users, profiles, friends where (req_to='$email' or req_from='$email') and email != '$email'and  req_pending = 0 and blocked = 0 and friends.admin_perm = 0 and (req_to = email || req_from = email)  and profiles.user_email = email and ( f_name LIKE '%$q%' or l_name LIKE '%$q%' )";
        $r = mysql_query($qr);

        $err = mysql_error();
        
        
        if($r != false && $r != array() && count($r) > 0 && $r != null && strlen($err) == 0 )
        {
            while($line = mysql_fetch_assoc($r))
            {
                $res[] = $line;
            }
            
            if(count($res) > 0 )
            {
                $tot = count($res); 
                $json = "[";
                for($i = 0; $i < $tot; $i++)
                {
                    $json .= "{\"id\":\"".$res[$i]['uid']."\",\"name\":\"".$res[$i]["f_name"] . " " . $res[$i]["l_name"]."\"}";
                    if(($i+1) > $tot)
                    {
                        $json .= ",";
                    }
                }
                $json .= "]";
            }
        }
        else
        {
            echo "You have no friends";
        }
    }
    echo $json;
}

?>