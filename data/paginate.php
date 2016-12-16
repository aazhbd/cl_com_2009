<?php
function paginate_friend($email, $con, $myFriends = null)
{
    $res_list = array();
    $err = "";
    $currIndex = SmartyPaginate::getCurrentIndex();

    $limit = SmartyPaginate::getLimit();
    
    $query = "select f_name, l_name, email as user_email, profiles.id as pid, user_imgs_id, friends.id as fid from users, profiles, friends where (req_to='$email' or req_from='$email') and email != '$email'and  req_pending = 0 and blocked = 0 and friends.admin_perm = 0 and (req_to = email || req_from = email)  and profiles.user_email = email LIMIT $currIndex, $limit";

    $db_results = $con->db->selectData($query);
        if($db_results == false || count($db_results) == 0) $err .= $con->db->err;
    if(count($db_results) > 0)
    {
        $i = 0;
        foreach($db_results as $s)
        {
            $frnd[$i] = $s;
            $frnd[$i]['name'] = $frnd[$i]['f_name']." ".$frnd[$i]['l_name']; 
            if($myFriends != null)
            {
                if(count($myFriends) > 0)
                {
                    foreach($myFriends as $f)
                    {
                        if(trim($frnd[$i]['user_email']) == $f['user_email'])
                        {
                            $frnd[$i]['isfriend'] = true;
                            break;
                        }
                        else
                        {
                            $frnd[$i]['isfriend'] = false;
                        }
                    }
                }
            }
            $i++;
        }
    }
    
    $con->tp->assign('frnd_list', $frnd);
    
    return $err; 
}

function paginate_search($query, $con)
{
    $res_list = array();
    $err = "";
    $db_results = $con->db->selectData($query);
    if($db_results != false && $db_results != array())
    {
        if(count($db_results) > 0)
        {
            $i = 0;
            foreach($db_results as $s)
            {
                $res_list[$i] = $s;
                $i++;
            }
        }
        return $res_list;
    }
    return $err; 
}

function init_pg_multi($query, $url,  $perPage, $pageLimit, $email, $con, $id = 'default', $sess_name = 'res')
{
    SmartyPaginate::connect($id);

    SmartyPaginate::setLimit($perPage,$id);
    
    SmartyPaginate::setPageLimit($pageLimit, $id);
    
    $r = $con->db->selectData($query);
    
    $tot = $r[0]['tot'];

    if((int)$tot > 0)
    {
        SmartyPaginate::setTotal($tot,$id);

        SmartyPaginate::setUrl($url, $id);

        SmartyPaginate::setUrlVar("start",$id);

        SmartyPaginate::setFirstText("First",$id);

        SmartyPaginate::setLastText("Last",$id);
        
        SmartyPaginate::setNextText("Next",$id);
        
        SmartyPaginate::setPrevText("Previous",$id);

        $_SESSION[$sess_name] = 'set';
        
        return true;
    }
    else
    {
        return false;
    }
}

function init_pg($query, $url,  $perPage, $pageLimit, $email, $con, $sess_name = 'res')
{
    SmartyPaginate::connect();

    SmartyPaginate::setLimit($perPage);
    
    SmartyPaginate::setPageLimit($pageLimit);

    $r = $con->db->selectData($query);
    
    $tot = $r[0]['tot'];
    
    if((int)$tot > 0)
    {
        SmartyPaginate::setTotal($tot);

        SmartyPaginate::setUrl($url);

        SmartyPaginate::setUrlVar("start");

        SmartyPaginate::setFirstText("First");

        SmartyPaginate::setLastText("Last");
        
        SmartyPaginate::setNextText("Next");
        
        SmartyPaginate::setPrevText("Previous");

        $_SESSION[$sess_name] = 'set';
        
        return true;
    }
    else
    {
        return false;
    }
}

function init_pagination_search($query, $url,  $perPage, $pageLimit, $email, $con)
{
    SmartyPaginate::connect();

    SmartyPaginate::setLimit($perPage);
    
    SmartyPaginate::setPageLimit($pageLimit);

    $r = $con->db->selectData($query);
    
    $tot = $r[0]['tot'];

    if((int)$tot > 0)
    {
        SmartyPaginate::setTotal($tot);

        SmartyPaginate::setUrl($url);

        SmartyPaginate::setUrlVar("start");

        SmartyPaginate::setFirstText("First");

        SmartyPaginate::setLastText("Last");
        
        SmartyPaginate::setNextText("Next");
        
        SmartyPaginate::setPrevText("Previous");

        $_SESSION['res'] = 'set';
        
        return true;
    }
    else
    {
        return false;
    }
}

function paginate($table, $email, $boxtype, $con)
{   
    $msg_list = array();
    $err = "";
    $currIndex = SmartyPaginate::getCurrentIndex();

    $limit = SmartyPaginate::getLimit();

    $db_results = get_db_results($currIndex, $limit, $table, $email, $boxtype, $con);

    if($db_results == false  || $db_results == array()) $err = $con->db->err;

    if(count($db_results) > 0)
    {
        $i = 0;
        foreach($db_results as $s)
        {
            $msg_list[$i] = $s;
            $query = "select f_name, l_name, email from users where email = '".trim($msg_list[$i]['rcvr_email'])."';";
            
            $r = $con->db->selectData($query);
            if( trim($r[0]['f_name']) != "" &&  trim($r[0]['l_name']) != "")
                $msg_list[$i]['name'] = trim($r[0]['f_name'])." ".trim($r[0]['l_name']);
            else
                $msg_list[$i]['name'] = trim($r[0]['email']);
            
            $msg_list[$i]['checked'] = false;
            if($msg_list[$i]['box_type'] == 1) //inbox
            {
                $query1 = "select profiles.user_imgs_id as img_id, profiles.user_email as uemail from profiles, user_imgs where user_imgs.id = profiles.user_imgs_id and profiles.user_email = '".trim($msg_list[$i]['sndr_email'])."'";
            }
            else if($msg_list[$i]['box_type'] == 2)   //outbox
            {
                $query1 = "select profiles.user_imgs_id as img_id, profiles.user_email as uemail from profiles, user_imgs where user_imgs.id = profiles.user_imgs_id and profiles.user_email = '".trim($msg_list[$i]['rcvr_email'])."'";
            }
            $t = $con->db->selectData($query1);
            if($t != false && $t != array())
            {
               $msg_list[$i]['img_id'] = trim($t[0]['img_id']);
               $msg_list[$i]['uemail'] = trim($t[0]['uemail']);
            }
            else
            {
                $msg_list[$i]['img_id'] = 0;
                $msg_list[$i]['uemail'] = "";
            }
            
            $i++; 
        }
    }
    $con->tp->assign('msg_list', $msg_list);
    return $err;
}

function get_db_results($currIndex, $limit, $table, $email, $boxtype, $con)
{
    $_query = sprintf("SELECT id, subj, rcvr_email, sndr_email, send_date, read_stat FROM $table where sndr_email = '$email' order by send_date desc LIMIT %d,%d", $currIndex, $limit);
    $_data = $con->db->selectData($_query);
    return $_data;
}
?>
