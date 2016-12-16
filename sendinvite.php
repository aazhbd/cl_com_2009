<?php
if(!isset($_POST['submit'])){ echo "You can not access this page directly."; return; }

require_once('config/project.php');
$con = new Project();

$pageName ='Club Message';

$title = "ConveyLive :: Club Message";

$desc = "Invite your Friends and Send Club Message in ConveyLive. Create Your own Clubs to discuss and share your digital possesions like, Photos, Files and text posts. Browse all the Clubs of conveylive published by users to share,comment and discuss.";
$con->tp->assign("descrip", $desc);

$keys = "Invite, Send, Club, Message, New Clubs, Posts, File, Share, Community, Network, ConveyLive";
$con->tp->assign("keys", $keys);

$rep = "";
$err = "";
$btitle = "";
$bbody = "";
$vad = "";
$had = "";
$sideitem = array();
$islogin = true;

$read_status = array("unread" => 1, "read" => 2);
$box_type = array("inbox" => 1, "outbox" => 2);
$privacy_type = array("private" => 0, "public" => 1);
$sender_type = array("people" => 0, "club" => 1);
$ems = array();

$con->tp->assign('title', $title);

if(isset($_SESSION['login'] ) == true)
{
    $l = $_SESSION['login'];
    $islogin = true;
    $email = $l->getEmail();
}
extract($_POST);

for($i = 0; $i < count($inv); $i++)
{
    $q = "select email from users, friends where id = ".$inv[$i]." and email != '$email' and (req_from = '$email' or req_to = '$email' ) and (req_from = email or req_to = email ) and req_pending = 0 and blocked = 0 and friends.admin_perm = 0";
    $r = $con->db->selectData($q);
    
    if($r == false || $r == array() || count($r) == 0) $err .= $con->db->err;
    else
    {
        $em = $r[0]['email'];
        $to_list[$i] = $em;
    }
}
if(count($to_list) > 0)
{
    $to = implode(",",$to_list);

    $subj = "Your friend has invited you to join $club_name";
    $privacy = 0;
    $msg = trim($msg);

    $email_count = count($email_arr);

    foreach($to_list as $sndr_email)
    {
        
        $query = "insert into messages (`subj`, `sndr_email`, `user_email`, `to`, `rcvr_email`, `ins_date`,`upd_date`, `content`, `read_stat`, `privacy`, `sender_type`, `admin_perm` ) values ('$subj', '$email', '$email', '$to', '$sndr_email', '".date("Y-m-d G:i:s")."' ,'".date("Y-m-d G:i:s")."', '$msg' , '".$read_status['unread']."' , '$privacy' , '".$sender_type['club']."', '0') ";
        
        $in = $con->db->executeNonQuery($query);
        if($in == false) 
        {
            $err .= "Failed to send message to the user with email: $sndr_email. DB Error: ". $con->db->err;
        }
        else
        {
            $ins = true;
        }
        
        
        if($club_type == "secret")
        {
            $ins = false;
            $join_date = date("Y-m-d G:i:s");
            $status = 0;
            $privilege = 0;
            $permission = 0;
            
            $query = "insert into cmembers ( `user_email`,`inviter_email` ,`club_id`, `join_date`, `privilege`, `admin_perm`, `status`, `ins_date`, `upd_date` ) values ('$sndr_email','$email', '$club_id', '$join_date', '$privilege', '$permission', '$status' , '".date("Y-m-d G:i:s")."', '".date("Y-m-d G:i:s")."')";

            $in = $con->db->executeNonQuery($query);
            if($in == false) 
            {
                $err .= "Failed to add member to secret club request list: $sndr_email. DB Error: ". $con->db->err;
                $ins = false;
            }
            else
            {
                $ins = true;
            }
        }
        
        if($err == "")
        {    
            if($ins)
            {
                $name = getUserName($sndr_email, $con);
                $subject = "You have an invitation to join club.";
                $msgBody = "Hello, " . $name . "\r\n\r\nYou have been invited to join the club $club_name\r\n\r\nTo join this club, follow the link below: \r\n\r\n http://conveylive.com/clubs/join/$club_id \r\n\r\n";
                $msgBody .= "\r\n\r\nThanks\r\n\r\nConveyLive Team\r\n\r\n";
                $msgBody .= "-------\r\n\r\nFind people from your address book on ConveyLive! Go to: http://conveylive.com/invite.php";
                $msgBody .= "\r\n\r\nThis message was intended for $sndr_email";

                $fromAr = array("mail@conveylive.com" => "conveylive Team");
                $toAr = array($email => $sndr_email);
                
                $isMailSent = simpleMail($con, $msgBody, $subject, $fromAr, $toAr, "text/plain", array("mail@conveylive.com" => "conveylive Team") , 4);
                if($isMailSent)
                {
                    $rep = "Club invitation has been sent !";
                }
                else
                {
                    $err .= $isMailSent;
                    $rep = "Club invitation has been sent ! But Mail Not Sent to notify";
                }
            }
        }
        else
        {
            $err .= $con->db->err;
        }  
    }
}
$retList = viewClub($con, $email, $club_id);

$bbody = $retList['bbody'];
$btitle = $retList['btitle'];
$bsubtitle = $retList['bsubtitle'];
$rep .= $retList['rep'];
$err .= $retList['err'];

$v = setLoginInfo(trim($email), $con);

$con->tp->assign('islogin',$islogin);

$blogexist = checkBlog($con, $email);

$sideitem = getSideItems(trim($email), $con);

$con->tp->assign('btitle', $btitle);

$con->tp->assign('title', $title);

$con->tp->assign('bbody', $bbody);

$con->tp->assign('sideitem', $sideitem);

$con->tp->assign('rep', $rep);

$con->tp->assign('err', $err);

addSiteStat($pageName, $con, $email);

$con->tp->display('main.tpl');

?>