<?php
if(!isset($_POST['submit'])){ echo "You can not access this page directly."; return; }

require_once('config/project.php');
$con = new Project();

$pageName ='Message Sent';


$title = "ConveyLive :: Home";

$desc = "Send New Messages at ConveyLive to invite as friends, and join clubs. ConveyLive.com is a place to make friends and broadcast your creativity with the world. Publish your articles, audio, video, files, blogs, clubs and make it available to search engines, links and other sites as well as your friends. Browse the world through conveylive.com, expand your circle and get amazed with the large collection of other people's contents.";
$con->tp->assign("descrip", $desc);

$keys = "Send, New, Messages, article, audio, video, photos, club, blog";
$con->tp->assign("keys", $keys);

$rep = "";
$err = "";
$btitle = "";
$bbody = "";
$vad = "";
$had = "";
$sideitem = array();
$islogin = true;

$read_arr = array("unread" => 1, "read" => 2);
//$box_type = array("inbox" => 1, "outbox" => 2);
$privacy_arr = array("private" => 0, "public" => 1);
$sender_arr = array("people" => 0, "club" => 1 );
$ems = array();
$sent = array();

$con->tp->assign('title', $title);

if(isset($_SESSION['login'] ) == true)
{
    $l = $_SESSION['login'];
    $islogin = true;
    $email = $l->getEmail();
}
extract($_POST);


$dbPrivacy_type = $privacy_arr["$privacy_type"];
$dbSender_type = $sender_arr["$sender_type"];
$dbRead_status = $read_arr["unread"];

if(isset($fid))
{
    $femail = getEmailByid($fid, $con);
    $email_arr = array($femail);
    $to_list = $femail;
    $sndr_email = $email;
    
    $subj = trim($subj);

    if($subj == "") $subj = "&lt; No subject &gt;";

    $cont = trim($cont);
    $c = htmlentities($cont);
    $c = addslashes($c);
    $cont = $c;
}
else
{
    $to_list = trim($to);

    $subj = trim($subj);

    if($subj == "") $subj = "&lt; No subject &gt;";

    $cont = trim($cont);
    $c = htmlentities($cont);
    $c = addslashes($c);
    $cont = $c;

    $id_arr = explode(",", $to_list);

    foreach($id_arr as $id)
    {
        $fem = getEmailByid($id, $con);
        if(trim($fem) != "")
        $email_arr[] = $fem;
    }
    $to_list = implode(",", $email_arr);

    $email_count = count($email_arr);

    $sndr_email = $email;
}

$user_email = $sndr_email;

foreach($email_arr as $rcvr_email)
{
    $s = trim($rcvr_email); 
        
    $id = getNewId('messages', $con);
    $query = "insert into messages (`id`, `user_email`,`subj`, `sndr_email`, `to`, `rcvr_email`, `ins_date`, `upd_date`, `content`, `read_stat`, `privacy`, `sender_type` )
              values ('$id','$user_email', '$subj', '$sndr_email', '$to_list', '$rcvr_email','".date("Y-m-d G:i:s")."' ,'".date("Y-m-d G:i:s")."',  '$cont' , '".$dbRead_status."' , '".$dbPrivacy_type."' , '".$dbSender_type."') ";
    $in = $con->db->executeNonQuery($query);
    
    //echo $query;
    if($in == false || $in == array()) 
    {
        $err .= $con->db->err;
        $ems[] = $s;
        break;
    }
    else
    {
        $sent[] = $s;
    }
}
$e = implode(",", $ems);
if($ems != array() && $err != "" )
{
    $err .= "These email(s): $e is/are invalid. No user(s) with such email(s) exist(s) at ConveyLive.com.";
}
else if($err == "" && count($sent) > 0 )
{
    $name = getUserName($email,$con);
    $newmsg = html_entity_decode($cont);
    $newmsg = strip_tags($newmsg);

    foreach($sent as $em)
    {
        $reciepient = getUserName(trim($em), $con);
        $subject = "You have a new message from $name.";
        $msgBody = "Hello, $reciepient \r\n";
        $msgBody .= "You have a new message from $name.\r\n\r\n";
        $msgBody .= "$name wrote:\r\n\r\n\"$newmsg\" \r\n\r\n To reply to this message please follow the link below: \r\n\r\n http://localhost/conlive_0921w/site/message/reply/$id";
        $msgBody .= "\r\n\r\nThanks\r\n\r\nConveyLive Team\r\n\r\n";
        $msgBody .= "-------\r\n\r\nFind people from your address book on ConveyLive! Go to: http://conveylive.com/invite.php";
        $msgBody .= "\r\n\r\nThis message was intended for $em";

        $fromAr = "ConveyLive <mail@conveylive.com>";
        $toAr = $em ;
        $isMailSent = simpleMail($con, $msgBody, $subject, $fromAr, $toAr);
    }
    
    if($isMailSent)
    {
        $rep = "Your message has been sent!";
    }
    else
    {
        $rep = "Your message has been sent! But Mail not sent to notify";
    }
}

$retList = mailBox($con, $email, "sentbox");    
$bbody = $retList['bbody'];
$btitle = $retList['btitle'];
$bsubtitle = $retList['bsubtitle'];
//$rep .= $retList['rep'];
//$err .= $retList['err'];

$con->tp->assign('bbody', $bbody);

$con->tp->assign('btitle', $btitle);

$con->tp->assign('bsubtitle', $bsubtitle);

$v = setLoginInfo(trim($email), $con);

$con->tp->assign('islogin',$islogin);

$blogexist = checkBlog($con, $email);

$sideitem = getSideItems(trim($email), $con);

$con->tp->assign('sideitem', $sideitem);

$con->tp->assign('rep', $rep);

$con->tp->assign('err', $err);

addSiteStat($pageName, $con, $email);

$con->tp->display('main.tpl');

?>