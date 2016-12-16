<?php

function message($con, $section, $email, $id = 0, $boxtype = "inbox")
{
    $rep = "";
    $err = "";
    $btitle = "";
    $bbody = "";
    $box_type = array("inbox" => 1, "outbox" => 2);
    switch ($section)
    {
        case 'delete':
            $r = array();
            $m = array();
            if($boxtype == "inbox")
            {
                $q = "select id  from messages where rcvr_email = '$email' and id = $id and admin_perm = 0 ";
            }
            if($boxtype == "sentbox")
            {
                $q = "select id from messages where user_email = '$email' and id = $id and admin_perm = 0";
            }
            
            $r = $con->db->executeQuery("$q");
            if($r == false || $r == array())
            {
                $err .= $con->db->err;
            }
            else
            {
                foreach($r as $a)
                {
                    $m = $a;
                }
            }

            if($boxtype == "inbox")
            {
                $msg = $con->db->executeNonQuery("update messages set admin_perm = 1 where rcvr_email = '$email' and id = $id");
            }
            if($boxtype == "sentbox")
            {
                $msg = $con->db->executeNonQuery("update messages set admin_perm = 1 where user_email = '$email' and id = $id");
            }
            if($msg == false || $msg == array()) $err .= $con->db->err;
            
            
            if($msg == true && count($m) > 0)
            {
                $rep = "Message deleted successfully !";
            }
            else
            {
                $err = "Message is unavailable";
            }
            
            $con->tp->assign('title', $title);
            if($boxtype == "inbox")
            {
                $retList = mailBox($con, $email, "inbox");    
                $bbody = $retList['bbody'];
                $btitle = $retList['btitle'];
                $bsubtitle = $retList['bsubtitle'];
                $rep .= $retList['rep'];
                $err .= $retList['err'];
            }
            if($boxtype == "sentbox")
            {
                $retList = mailBox($con, $email, "sentbox");    
                $bbody = $retList['bbody'];
                $btitle = $retList['btitle'];
                $bsubtitle = $retList['bsubtitle'];
                $rep .= $retList['rep'];
                $err .= $retList['err'];
            }
            
            $desc = "Remove Sent Messages at ConveyLive. ConveyLive.com is a place to make friends and broadcast your creativity with the world. Publish your articles, audio, video, files, blogs, clubs and make it available to search engines, links and other sites as well as your friends. Browse the world through conveylive.com, expand your circle and get amazed with the large collection of other people's contents.";
            $con->tp->assign("descrip", $desc);

            $keys = "Send Messages, article, audio, video, photos, club, blog";
            $con->tp->assign("keys", $keys);
        break;
        
        case 'reply':
        
            $msg = $con->db->selectData("select * from messages where rcvr_email = '$email' and id = $id and admin_perm = 0" );
            if($msg == false || $msg == array()) $err .= $con->db->err;
            $i = 0;
            
            foreach($msg as $ms)
            {
                $m = $ms;
                $t = $m['content'];
                $t = stripslashes($t);
                $t = html_entity_decode($t);
                $m['content'] = $t;
                if ($m['sender_type'] == 0)
                {
                    $m['rcvr_name'] = getUserName($ms['rcvr_email'], $con);
                    $m['sndr_name'] = getUserName($ms['user_email'], $con);
                }
                if ($m['sender_type'] == 1 || $m['sender_type'] == 2)
                {
                    $m['rcvr_name'] = getUserName($ms['rcvr_email'], $con);
                    $m['sndr_name'] = getUserName($ms['user_email'], $con);
                }            
                $i++;
            }
            $fname = $m['sndr_name'];
            
            $fid = getUserId($m['user_email'], $con);
            $con->tp->assign('fname', $fname);
            $con->tp->assign('fid', $fid);
            
            $con->tp->assign('boxtype', $boxtype);
            $btitle = "Reply to the following message";
            $con->tp->assign('msg', $m);
            $con->tp->assign('email', $email);
            $bbody = $con->tp->fetch('reply_msg.tpl');
            
            $title = "ConveyLive :: Reply to Message";
            $con->tp->assign('title', $title);
            
            $desc = "Reply to Sent Messages at ConveyLive, invite friends, and join clubs. ConveyLive.com is a place to make friends and broadcast your creativity with the world. Publish your articles, audio, video, files, blogs, clubs and make it available to search engines, links and other sites as well as your friends. Browse the world through conveylive.com, expand your circle and get amazed with the large collection of other people's contents.";
            $con->tp->assign("descrip", $desc);

            $keys = "Reply and Send Messages, article, audio, video, photos, club, blog";
            $con->tp->assign("keys", $keys);
            //$bbody .= $con->tp->fetch('newmsg_view.tpl');
        break;
        
        case 'view':
            $msg = array();

            if($boxtype == "inbox")
            {
                $msg = $con->db->selectData("select * from messages where rcvr_email = '$email' and id = '$id' and admin_perm = 0");
                $rec_date = date("Y-m-d G:i:s");
                $p = $con->db->executeNonQuery("update messages set read_stat = 2 where rcvr_email = '$email' and id = '$id' and admin_perm = 0");
                $btitle = "Message from ";
            }
            else if($boxtype == "sentbox")
            {
                $msg = $con->db->selectData("select * from messages where sndr_email = '$email' and id = '$id' and admin_perm = 0");
                $btitle = "Message sent to ";
            }
            if($msg == false || $msg == array()) $err .= $con->db->err;
            $i = 0;
            
            
            foreach($msg as $ms)
            {
                $m = $ms;
                $cont = $m['content'];
                $c = stripcslashes($cont);
                $cont = html_entity_decode($c);
                $m['content'] =  $cont; 
                if ($m['sender_type'] == 0)
                {
                    $m['rcvr_name'] = getUserName($m['rcvr_email'], $con);
                    $m['sndr_name'] = getUserName($m['user_email'], $con);
                }
                if ($m['sender_type'] == 1 || $m['sender_type'] == 2)
                {
                    $m['rcvr_name'] = getUserName($m['rcvr_email'], $con);
                    $m['sndr_name'] = getUserName($m['user_email'], $con);
                }
                $i++;
            }

            if($boxtype == "inbox")
            $btitle .= getUserName($m['user_email'], $con);
            if($boxtype == "sentbox")
            $btitle .= getUserName($m['rcvr_email'], $con);
            
            $bsubtitle = "Subject: ". $m['subj'];
            $con->tp->assign('bsubtitle', $bsubtitle); 
            $con->tp->assign('msg', $m);
            $con->tp->assign('email', $email);
            
            $con->tp->assign('boxtype', $boxtype); 
            $bbody = $con->tp->fetch('msg_view.tpl');
            
            $title = "ConveyLive :: Message";
            $con->tp->assign('title', $title);
            
            $desc = "View and Send Messages at ConveyLive to invite as friends, and join clubs. ConveyLive.com is a place to make friends and broadcast your creativity with the world. Publish your articles, audio, video, files, blogs, clubs and make it available to search engines, links and other sites as well as your friends. Browse the world through conveylive.com, expand your circle and get amazed with the large collection of other people's contents.";
            $con->tp->assign("descrip", $desc);

            $keys = "View, Send,  Messages, article, audio, video, photos, club, blog";
            $con->tp->assign("keys", $keys);
        break;
        
        case 'new':
            $btitle = "New Message";
            $con->tp->assign('email', $email);
            
            $uid = getUserId($email, $con);
            
            $con->tp->assign('uid', $uid);
            $bbody = $con->tp->fetch('newmsg_view.tpl');
            $title = "ConveyLive :: Inbox";
            $con->tp->assign('title', $title);
            
            $desc = "Send New Messages at ConveyLive to invite as friends, and join clubs. ConveyLive.com is a place to make friends and broadcast your creativity with the world. Publish your articles, audio, video, files, blogs, clubs and make it available to search engines, links and other sites as well as your friends. Browse the world through conveylive.com, expand your circle and get amazed with the large collection of other people's contents.";
            $con->tp->assign("descrip", $desc);

            $keys = "Send, New, Messages, article, audio, video, photos, club, blog";
            $con->tp->assign("keys", $keys);
        
        break;
        
        case 'inbox':
            $retList = mailBox($con, $email, "inbox");    
            $bbody = $retList['bbody'];
            $btitle = $retList['btitle'];
            $bsubtitle = $retList['bsubtitle'];
            $rep = $retList['rep'];
            $err = $retList['err'];
        break;
        
        case 'sentmessages':
            $retList = mailBox($con, $email, "sentbox");    
            $bbody = $retList['bbody'];
            $btitle = $retList['btitle'];
            $bsubtitle = $retList['bsubtitle'];
            $rep = $retList['rep'];
            $err = $retList['err'];
               
        break;
    }
    $con->tp->assign('bbody', $bbody);
    $con->tp->assign('btitle', $btitle);
    $con->tp->assign('bsubtitle', $bsubtitle);
    $con->tp->assign('rep', $rep);
    $con->tp->assign('err', $err);
}

function mailBox($con, $email, $boxtype = "inbox")
{
    $res = array();
    if($boxtype == "inbox" )
    {
        $btitle = "Inbox";
        $bsubtitle = "Your list of incoming messages";
        $query = "select count(*) as tot from messages, users where rcvr_email = '$email' and rcvr_email = email and messages.admin_perm = 0";
        $url = URL ."/msgbox.php?boxtype=inbox";
        $_query = "select uid, email, f_name, l_name, messages.* from messages, users where rcvr_email = '$email' and rcvr_email = email and messages.admin_perm = 0 order by ins_date desc ";
        
        $title = "ConveyLive :: Inbox";
        $con->tp->assign('title', $title);
        
        $desc = "Get Messages at ConveyLive to invite friends and join clubs. ConveyLive.com is a place to make friends and broadcast your creativity with the world. Publish your articles, audio, video, files, blogs, clubs and make it available to search engines, links and other sites as well as your friends. Browse the world through conveylive.com, expand your circle and get amazed with the large collection of other people's contents.";
        $con->tp->assign("descrip", $desc);

        $keys = "Send Messages, article, audio, video, photos, club, blog";
        $con->tp->assign("keys", $keys);
    }
    if($boxtype == "sentbox" )
    {
        $btitle = "Sent Messages";
        $bsubtitle = "Your list of outgoing messages";
        $query = "select count(*) as tot from messages, users where user_email = '$email' and user_email = email and messages.admin_perm = 0";
        $url = URL ."/msgbox.php?boxtype=sentbox";
        $_query = "select uid, email, f_name, l_name, messages.*  from messages, users where user_email = '$email' and user_email = email and messages.admin_perm = 0 order by ins_date desc ";

        $title = "ConveyLive :: Sent Messages";
        $con->tp->assign('title', $title);
        
        $desc = "Send Messages at ConveyLive to invite as friends, and join clubs. ConveyLive.com is a place to make friends and broadcast your creativity with the world. Publish your articles, audio, video, files, blogs, clubs and make it available to search engines, links and other sites as well as your friends. Browse the world through conveylive.com, expand your circle and get amazed with the large collection of other people's contents.";
        $con->tp->assign("descrip", $desc);

        $keys = "Send Messages, article, audio, video, photos, club, blog";
        $con->tp->assign("keys", $keys);        
    }
    
    $perPage = 10;
    $pageLimit = 2;
    $found = false;
    $qvar = 'msg';
    $sess_name = 'messages';
    
    SmartyPaginate::disconnect();
    unset($_SESSION[$sess_name]);
    SmartyPaginate::reset();
    
    $_SESSION[$qvar] = $_query;
    if(!isset($_SESSION["$sess_name"]))
    {
        SmartyPaginate::connect();
        if(SmartyPaginate::isConnected())
        {
            $found = init_pg($query, $url, $perPage, $pageLimit, $email,  $con, $sess_name);
        }
    }
    if($found)
    {
        if(isset($_SESSION[$sess_name]))
        {
            $currIndex = SmartyPaginate::getCurrentIndex();
            $limit = SmartyPaginate::getLimit();
            $l = sprintf(" LIMIT %d, %d", $currIndex, $limit);
            $query = $_query.$l;
            $res = paginate_search($query, $con);
            //$err .= $con->db->err;
            $i = 0;
            foreach($res as $a)
            {
                $messages[] = $a;
                if($boxtype == "inbox") $sndr_mail_addr = $a['user_email'];
                if($boxtype == "sentbox") $sndr_mail_addr = $a['rcvr_email'];
                
                
                $sndr_name = getUserName($sndr_mail_addr, $con);
                $sndr_pid = getPrifileId($sndr_mail_addr,$con);
                $sndr_img_id = getProfImgId($sndr_mail_addr, $con);
                

                $messages[$i]['sndr_mail_addr'] = $sndr_mail_addr;
                $messages[$i]['sndr_name'] = $sndr_name;
                $messages[$i]['sndr_pid'] = $sndr_pid;
                $messages[$i]['sndr_img_id'] = $sndr_img_id;
                $i++;
            }
            $con->tp->assign('boxtype', $boxtype);
            $con->tp->assign('messages', $messages);
            
            $con->tp->assign('p', SmartyPaginate::getCurrentIndex());
            $con->tp->assign('x', 1);            
            SmartyPaginate::assign($con->tp);
        }
        else
        {
            $err .= $con->db->err;
        
            $err .= "Session is not set. Messages not found";
        }
    }
    else
    {
        $err .= $con->db->err;
    }

    $bbody = $con->tp->fetch('inbox_view.tpl');
    
    $ret_arr = array();
    $ret_arr['err'] = $err;
    $ret_arr['rep'] = $rep;
    $ret_arr['bbody'] = $bbody;
    $ret_arr['btitle'] = $btitle;
    $ret_arr['bsubtitle'] = $bsubtitle;
    
    return $ret_arr;
}

function init_pagination($table, $perPage, $pageLimit, $email, $con, $boxttype)
{
    $box_type = array("inbox" => 1, "outbox" => 2);
    
    SmartyPaginate::connect();

    SmartyPaginate::setLimit($perPage);
    
    SmartyPaginate::setPageLimit($pageLimit);
    
    $r = $con->db->selectData("select count(*) as tot from $table where sndr_email = '$email' ");
    
    $tot = $r[0]['tot'];
    
    SmartyPaginate::setTotal($tot);
    
    $url = URL ."/msgbox.php?e=$email&box=".$boxttype."";
    
    SmartyPaginate::setUrl($url);
    
    SmartyPaginate::setUrlVar("start");
    
    SmartyPaginate::setFirstText("First");
    
    SmartyPaginate::setLastText("Last");
    
    $_SESSION['msg'] = 'set';
}
?>