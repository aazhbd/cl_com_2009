<?php
function friends($con, $section, $id, $email)
{
    $rep = "";
    $err = "";
    $btitle = "";
    $bbody = "";
    $skip = false;
    
    switch($section)
    {
        case 'viewfriends':
            $perPage = 10;
            $pageLimit = 5;
            unset($_SESSION['frnd']);
            SmartyPaginate::reset();
            
            $myFriends = array();
            if($email != "")
            {
                $q = "select f_name, l_name, email as user_email, profiles.id as pid, user_imgs_id, friends.id as fid from users, profiles, friends where (req_to='$email' or req_from='$email') and email != '$email'and  req_pending = 0 and blocked = 0 and friends.admin_perm = 0 and (req_to = email || req_from = email)  and profiles.user_email = email";
                
                $r = $con->db->selectData($q);
                
                if($r == false || $r == array() || count($r) == 0)
                {
                    $err .= $con->db->err;
                }
                else
                {
                    foreach($r as $a)
                    {
                        $myFriends[] = $a;
                    }
                }
            }
            
            $frnd = array();
            if(!isset($_SESSION['frnd']))
            {
                SmartyPaginate::connect();
                $uemail = getEmail($id, $con);
                $uname = getUserName($uemail, $con);
                
                if($uemail == $email)
                {
                    $btitle = "Your Friends";
                }
                else
                {
                    if($uname == "")
                    {
                        $btitle = "Your Friends";
                    }
                    else
                    {
                        $btitle = "Friends of ". $uname;
                    }
                }
                if(SmartyPaginate::isConnected())
                {
                    $url = URL ."/friendlist.php?id=$id";
                    $err .= init_pagination_friend($perPage, $pageLimit, $uemail, $con, $url);
                }
            }
            if(isset($_SESSION['frnd']))
            {    
                $err = paginate_friend($uemail, $con, $myFriends);
            }
            else
            {
                $err .= "Session Not Set";
            }
            $con->tp->assign('p', SmartyPaginate::getCurrentIndex());
            $con->tp->assign('x', 1);
            SmartyPaginate::assign($con->tp);
            
            $bbody .= $con->tp->fetch('friendlist_view.tpl');
            $title = "ConveyLive :: Friends";
            $con->tp->assign('title', $title);
            
            $keys = "friends, communicate, share,network,  conveylive";
            $con->tp->assign("keys", $keys);

            $desc = "ConveyLive - Friends. Stay in touch with your friends through conveylive and share your creativity";
            $con->tp->assign("descrip", $desc);
        
        break;
        
        case 'report':
            $btitle = "Report User";
            $r = $con->db->selectData("select f_name, l_name, email from users, profiles where profiles.id = $id and profiles.user_email = users.email");
            if($r != false && $r != array())
                $con->tp->assign("report", $r[0]);
            else
                $err .= $con->db->err;
            $con->tp->assign("user_email",$email);
            $bbody = $con->tp->fetch('report_user.tpl');
            
            $keys = "friends, communicate, share,network,  conveylive";
            $con->tp->assign("keys", $keys);

            $desc = "Send Messages and Stay in Touch With Friends. Stay in touch with your friends through conveylive and share your creativity";
            $con->tp->assign("descrip", $desc);    
            break;
            
        case 'remove':
            $r = $con->db->executeNonQuery("update friends set admin_perm = 1 where id = $id");
            if($r != false  )
            {
                $rep = "Friend has been removed from your friend list.";
            }
            else
            {
                $err .= $con->db->err;
            }
            home($con,$email, 'user');
            $skip = true;
        break;
        
        break;
        
        case 'approve':
            $femail = "";
            $r = $con->db->updateData("update friends set date_accept = '".date("Y-m-d G:i:s")."',  req_pending = 0  where id = $id");
            if($r == false) $err .= $con->db->err;
            else
            {
                $approved = true;
            }
            if($approved)
            {
                $r = $con->db->selectData("select req_from, f_name, l_name from friends, users where id = $id and email = req_from");
                if($r == false || $r == array()) $err .= $con->db->err;
                else
                {
                    $femail = $r[0]['req_from'];
                    $fname = getUserName($femail,$con);
                }
                
                //mail
                $name = getUserName($email, $con);
                $sender_name = getUserName($email, $con);
                $subject = "$sender_name has approved your friend request.";
                $msgBody = "Hello, " . $fname . "\r\n$sender_name has approved your friend request. You are now friends with $sender_name. Please login to conveylive.com to communicate with your friends.";
                $msgBody .= "\r\n\r\nThanks\r\n\r\nConveyLive Team\r\n\r\n";
                $msgBody .= "-------\r\n\r\nFind people from your address book on conveylive.com! Go to: http://conveylive.com/invite.php";
                $msgBody .= "\r\n\r\nThis message was intended for $femail";
                
                $fromAr = array("mail@conveylive.com" => "Conveylive Team");
                
                $toAr = $femail;
                
                $isMailSent = simpleMail($con, $msgBody, $subject, $fromAr, array($toAr => $fname), "text/plain", $fromAr, 0 );
                
                if($isMailSent)
                {
                    $rep = "You approved a friend request from $fname";
                }
                else
                {
                    $rep = "You have approved a friend request from $fname.";
                    $rep .= "Could not send notification email ";
                }
            }
            $skip = true;
            home($con,$email, 'user');
            
            $title = "conveylive.com :: Home";
            $con->tp->assign('title', $title);
            
            $keys = "friends, communicate, share,network,  conveylive";
            $con->tp->assign("keys", $keys);

            $desc = "Send Messages and Stay in Touch With Friends. Stay in touch with your friends through conveylive and share your creativity";
            $con->tp->assign("descrip", $desc);
        
        break;
        
        case 'denyrequest':
            $r = $con->db->deleteData("update friends set admin_perm = 1; where id = $id");
            if($r == false) $err .= $con->db->err;
            else
            {
                $denied = true;
            }
            home($con,$email, 'user');
            if($denied)
            {
                $rep = "You cancelled a friend request.";
            }
            $skip = true;
            
            $title = "ConveyLive :: Home";
            $con->tp->assign('title', $title);
            
            $keys = "friends, communicate, share,network,  conveylive";
            $con->tp->assign("keys", $keys);

            $desc = "Send Messages and Stay in Touch With Friends. Stay in touch with your friends through conveylive and share your creativity";
            $con->tp->assign("descrip", $desc);
        break;
        
        case 'viewrequest':
            $frnd = array();
            $btitle = "Friend Request";
            $r = $con->db->selectdata("select email, f_name, l_name, user_imgs_id, profiles.id as pid, req_msg, date_added, friends.id as fid from users, profiles, friends where friends.id = $id and req_pending = 1 and blocked = 0 and profiles.admin_perm = 0 and friends.admin_perm = 0 and req_from = email and user_email = email");
            
            if($r == false || $r == array()) $err .= $con->db->err;
            else
            {
                $i = 0;
                foreach($r as $p)
                {
                    $frnd[$i] = $p;
                    $frnd[$i]['name'] = $frnd[$i]['f_name']." ".$frnd[$i]['l_name'];
                    $i++;
                }
            }
            $r[0]['name'] = $r[0]['f_name']." ".$r[0]['l_name'];

            $con->tp->assign('frnd', $r[0]);
            $con->tp->assign('email', $email);
            $bbody = $con->tp->fetch('frnd_aprov_form.tpl');
            
            $title = "ConveyLive :: Friends Requests";
            $con->tp->assign('title', $title);
            
            $keys = "friends, communicate, share,network,  conveylive";
            $con->tp->assign("keys", $keys);

            $desc = "Send Messages and Stay in Touch With Friends. Stay in touch with your friends through conveylive and share your creativity";
            $con->tp->assign("descrip", $desc);
        
        break;
        
        case 'request':
            $prof = array();
            $btitle = "Add as friend";
            $r = $con->db->selectData("select * from users, profiles where profiles.id = $id and profiles.user_email = users.email");

            if($r == false || $r == array()) $err .= $con->db->err;
            else
            {
                $i = 0;
                foreach($r as $p)
                {
                    $prof[] = $p;
                }
            }
            $prof[0]['name'] = $prof[0]['f_name']." ".$prof[0]['l_name']; 
            $con->tp->assign('email', $email);
            $con->tp->assign('prof', $prof[0]);
            $bbody = $con->tp->fetch('friendreq_form.tpl');
            
            $title = "ConveyLive :: Add as friends";
            $con->tp->assign('title', $title);
            
            $keys = "friends, communicate, share,network,  conveylive";
            $con->tp->assign("keys", $keys);

            $desc = "Request Friends to join ConveyLive. Send Messages and Stay in Touch With Friends. Stay in touch with your friends through conveylive and share your creativity";
            $con->tp->assign("descrip", $desc);
        break;
        
        case 'requestlist':
            $btitle = "Friend Requests";
            $req = array();
            $r = $con->db->selectData("select email, f_name, l_name, friends.user_email as user_email, user_imgs_id, profiles.id as pid, req_msg, friends.ins_date as ins_date, friends.id as fid from users, profiles, friends where users.email = profiles.user_email and users.email = friends.req_from and friends.req_to = '$email' and req_pending = 1 and blocked = 0 and friends.admin_perm = 0 ");
            
            if($r == false || $r == array()) {$err .= $con->db->err; $req['count'] = 0;}
            else
            {
                $i = 0;
                foreach($r as $s)
                {
                    $req[$i] = $s;
                    $req[$i]['name'] = $req[$i]['f_name']." ".$req[$i]['l_name'];
                    $i++;
                }
               $req_count = count($req);
            }
            if($req_count > 0) $bsubtitle = "You have friend requests. Please confirm your friends.";
            $con->tp->assign('email', $email);
            $con->tp->assign('req_list', $req);
            $bbody = $con->tp->fetch('friendreq_view.tpl');
            
            $title = "ConveyLive :: Friends Requests";
            $con->tp->assign('title', $title);
            
            $keys = "friends, communicate, share,network,  conveylive";
            $con->tp->assign("keys", $keys);

            $desc = "Send Friend Requests by Messages and Stay in Touch With Friends. Stay in touch with your friends through conveylive and share your creativity";
            $con->tp->assign("descrip", $desc);
        
        break;
        
        case 'sendmessage':
        
            $msg = $con->db->selectData("select uid, f_name, l_name, email, user_imgs_id from users, profiles where profiles.id = $id and email = user_email");
            if($msg == false || $msg == array()) $err .= $con->db->err;
            foreach($msg as $ms)
            {
                $m = $ms;
            }
            $i = 0;
            
            $fname = $m['f_name'] ." ".$m['l_name'];
            
            $fid = getUserId($m['email'], $con);
            $con->tp->assign('fname', $fname);
            $con->tp->assign('fid', $fid);
            
            $con->tp->assign('boxtype', $boxtype);
            
            
            $btitle = "Send a message to your friend";

            $con->tp->assign('email', $email);
            $con->tp->assign('f_email', $m[0]['email']);
            $con->tp->assign('msg', $m);
            $con->tp->assign('email', $email);
            $bbody .= $con->tp->fetch('friend_message.tpl');
            
            $title = "ConveyLive :: Send Message";
            $con->tp->assign('title', $title);
            
            $keys = "friends, communicate, share,network,  conveylive";
            $con->tp->assign("keys", $keys);

            $desc = "Send Messages and Stay in Touch With Friends. Stay in touch with your friends through conveylive and share your creativity";
            $con->tp->assign("descrip", $desc);
        break;
        
        case 'view':
            $btitle = "Friends";
            $perPage = 3;
            $pageLimit = 10;
            unset($_SESSION['frnd']);
            SmartyPaginate::reset();
            $frnd = array();
            if(!isset($_SESSION['frnd']))
            {
                SmartyPaginate::connect();
                if(SmartyPaginate::isConnected())
                {
                    $id = getPrifileId($email, $con);
                    $url = URL ."/friendlist.php?id=$id";
                    $err .= init_pagination_friend($perPage, $pageLimit, $email, $con, $url);
                }
            }
            if(isset($_SESSION['frnd']))
            {
                $err = paginate_friend($email, $con);
            }
            
            else
            {
                $i = 0;
                foreach($r as $s)
                {
                    $frnd[$i] = $s;
                    $frnd[$i]['name'] = $frnd[$i]['f_name']." ".$frnd[$i]['l_name'];
                }
                
                $con->tp->assign('frnd_list', $frnd);
                $bbody .= $con->tp->fetch('friendlist_view.tpl');
            }
            $con->tp->assign('p', SmartyPaginate::getCurrentIndex());
            $con->tp->assign('x', 1);
            SmartyPaginate::assign($con->tp);
            
            $bbody .= $con->tp->fetch('friendlist_view.tpl');
            
            $title = "ConveyLive :: Friends";
            $con->tp->assign('title', $title);
            
            $keys = "friends, communicate, share,network,  conveylive";
            $con->tp->assign("keys", $keys);

            $desc = "ConveyLive - Friends. Stay in touch with your friends through conveylive and share your creativity";
            $con->tp->assign("descrip", $desc);
        break;
    }
    if($skip == false)
    {
        $con->tp->assign('bbody', $bbody);
        $con->tp->assign('btitle', $btitle);
    }
    $con->tp->assign('bsubtitle', $bsubtitle);
    $con->tp->assign('rep', $rep);
    $con->tp->assign('err', $err);    
}

function init_pagination_friend($perPage, $pageLimit, $email, $con, $nurl = '')
{    
    SmartyPaginate::connect();

    SmartyPaginate::setLimit($perPage);
    
    SmartyPaginate::setPageLimit($pageLimit);
    
    $r = $con->db->selectData("select count(*) as tot from users, profiles, friends where (req_to='$email' or req_from='$email') and email != '$email'and  req_pending = 0 and blocked = 0 and friends.admin_perm = 0 and (req_to = email || req_from = email)  and profiles.user_email = email");
    
    $tot = $r[0]['tot'];
    
    SmartyPaginate::setTotal($tot);
    
    $url = $nurl;
    
    SmartyPaginate::setUrl($url);
    
    SmartyPaginate::setUrlVar("start");
    
    SmartyPaginate::setFirstText("First");
    
    SmartyPaginate::setLastText("Last");
    
    $_SESSION['frnd'] = 'set';
    
    return $err;
}
?>
