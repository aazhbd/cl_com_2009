<?php
if(!isset($_POST['submit'])){ echo "You can not access this page directly."; return; }

require_once('config/project.php');
$con = new Project();

$pageName ='Club Message';


$title = "ConveyLive :: $pageName";
$rep = "";
$err = "";
$btitle = "";
$bbody = "";
$vad = "";
$had = "";
$sideitem = array();
$islogin = true;

getLatestCont($con,"Clubs");

$read_status = array("unread" => 1, "read" => 2);
$box_type = array("inbox" => 1, "outbox" => 2);
$privacy_type = array("private" => 0, "public" => 1);
$sender_type = array("people" => 0, "club" => 1 );
$ems = array();

$con->tp->assign('title', $title);

if(isset($_SESSION['login'] ) == true)
{
    $l = $_SESSION['login'];
    $islogin = true;
    $email = $l->getEmail();
}
extract($_POST);

$subj = trim($subj);
if($subj == "")
{
    $subj = "<No subject>";
}
$cont = trim($cont);

$id_arr = explode(",", $id_list);
$id_count = count($id_arr);

foreach($id_arr as $uid)
{
    $em = getEmailByid($uid, $con);
    $email_arr[] = $em;
}
$to = implode(",", $email_arr); 
foreach($email_arr as $sndr_email)
{ 
    if($sndr_email != $email)
    {
        $name = getUserName($sndr_email, $con);
        $query = "insert into messages (`subj`, `sndr_email`, `user_email`, `to`, `rcvr_email`, `ins_date`, `upd_date`, `content`, `read_stat`, `privacy`, `sender_type` ) values ('$subj', '$email', '$sndr_email', '$to', '$sndr_email', '".date("Y-m-d G:i:s")."', '".date("Y-m-d G:i:s")."' , '$cont' , '".$read_status['unread']."' , '$privacy' , '".$sender_type['club']."') ";
        $in = $con->db->executeNonQuery($query);
        if($in == false) 
        {
            $ems[] = $sndr_email;
            $err .= "Failed to send message to $name. DB Error: ". $con->db->err;
        }
        else
        {
            $subject = "You have an invitation to join club.";
            $msgBody = "Hello, " . $name . "\r\n\r\nYou have been invited to join the club $club_name\r\n\r\nTo join this club, follow the link below: \r\n\r\n http://conveylive.com/clubs/join/$club_id \r\n\r\n";
            $msgBody .= "\r\n\r\nThanks\r\n\r\nConveyLive Team\r\n\r\n";
            $msgBody .= "-------\r\n\r\nFind people from your address book on comveylive.com! Go to: http://conveylive.com/invite.php";
            $msgBody .= "\r\n\r\nThis message was intended for $sndr_email";

            $fromAr = array( "mail@conveylive.com" => "conveylive.com");
            $toAr = array($sndr_email => $name );
            
            $isMailSent = simpleMail($con, $msgBody, $subject, $fromAr, $toAr, "text/plain", array("mail@conveylive.com" => "Conveylive Team"), 4);
            if($isMailSent)
            {
                $sentAr[] = $sndr_email;
            }
            else
            {
                $err .= "Failed to send email to $name. ";
                $rep = "Club invitation has been sent ! But Mail Not Sent to notify";
            }
        }
    }
}
if($err == "" && $in == true && (count($id_count) == count($sentAr)))
{
    $rep = "Your message has been sent to all club members!";
}

$retList = viewClub($con, $email, $club_id);

$bbody = $retList['bbody'];
$btitle = $retList['btitle'];
$bsubtitle = $retList['bsubtitle'];
$rep .= $retList['rep'];
$err .= $retList['err'];

$desc = "Send Club Message in ConveyLive. Create Your own Clubs to discuss and share your digital possesions like, Photos, Files and text posts. Browse all the Clubs of conveylive published by users to share,comment and discuss.";
$con->tp->assign("descrip", $desc);

$keys = "Send, Club, Message, New Clubs, Posts, File, Share, Community, Network, ConveyLive";
$con->tp->assign("keys", $keys);

$v = setLoginInfo(trim($email), $con);

$con->tp->assign('islogin',$islogin);

$blogexist = checkBlog($con, $email);

$sideitem = getSideItems(trim($email), $con);

$con->tp->assign('btitle', $btitle);

$con->tp->assign('bbody', $bbody);

$con->tp->assign('sideitem', $sideitem);

$con->tp->assign('rep', $rep);

$con->tp->assign('err', $err);

addSiteStat($pageName, $con,$email);

$con->tp->display('main.tpl');

?>