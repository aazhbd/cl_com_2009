<?php
if(!isset($_POST['submit'])){ echo "You can not access this page directly."; return; }

require_once('config/project.php');
$con = new Project();

$pageName ='Friend Request Sent';


$title = "conveylive.com :: Home";

$keys = "Invite, friends, communicate, share,network,  conveylive";
$con->tp->assign("keys", $keys);

$desc = "Request Friends to join ConveyLive. Send Messages and Stay in Touch With Friends. Stay in touch with your friends through conveylive and share your creativity";
$con->tp->assign("descrip", $desc);


$rep = "";
$err = "";
$btitle = "";
$bbody = "";
$vad = "";
$had = "";
$sideitem = array();
$islogin = true;
$isMailSent = false;
$is_ins = false;
$message = "";

$con->tp->assign('title', $title);
$blogexist = checkBlog($con, $email);



extract($_POST);

$name = getUserName($email, $con);
$sender_name = getUserName($f_email, $con);
$q = "select * from friends where ( req_to = '$email' and req_from = '$f_email' ) or (req_from = '$email' and req_to = '$f_email' ) and admin_perm = 0";

$r = $con->db->selectData($q);
if($r == false || count($r) == 0 || $r == null) $err .= $con->db->err;
else
{
    foreach($r as $a)
    {
        $friend = $a;
    }
    
    if($friend['admin_perm'] == 1 )
    {
        $message = "You do not have permission to add this friend";
    }
    if($friend['blocked'] == 1 )
    {
        $message = "This person has been blocked from your friendlist.";
    }
    if($friend['req_pending'] == 0 && $friend['admin_perm'] == 0 && $friend['blocked'] == 0)
    {
        $message = "You are already a friend of $sender_name. Can't Send Friend Request to $sender_name";
    }
    if($friend['req_pending'] == 1 && $friend['req_to'] == "$f_email" && $friend['admin_perm'] == 0 && $friend['blocked'] == 0)
    {
        $message = "You have already sent friend request to $sender_name. Can't Send Friend Request to $sender_name";
    }
    if($friend['req_pending'] == 1 && $friend['req_from'] == "$f_email" && $friend['admin_perm'] == 0 && $friend['blocked'] == 0)
    {
        $message = "You have already have a pending friend request from $sender_name. Please approve the friend request from $sender_name to become friends.";
    }
}
if($message != "" )
{
    $rep = $message;
}
else
{
    $table = "friends";
    $id = getNewId($table,$con);

    $fields = array("id", "user_email", "req_to", "req_from", "ins_date",  "upd_date", "date_accept", "req_pending", "blocked", "admin_perm", "req_msg");
    $values = array("'".$id."'","'".trim($email)."'",  "'".trim($f_email)."'", "'".trim($email)."'", "'".date("Y-m-d G:i:s")."'", "'".date("Y-m-d G:i:s")."'", "''", "1", "'0'", "'0'", "'$cont'");

    $f = implode(",", $fields);
    $v = implode(",", $values);
    $query = "insert into $table ( $f ) values ( $v )";

    $i = $con->db->insertData($query);

    if( $i == true )
    {
        $is_ins = true;
    }
    if($is_ins)
    {
        $name = getUserName($email, $con);
        $sender_name = getUserName($f_email, $con);
        $subject = "You have a friend request";
        $msgBody = "Hello, $sender_name \r\n\r\nYou have a friend request from $name. We need to confirm that you know $sender_name in order for you to be friends on conveylive.com \r\n\r\nTo confirm this friend request, follow the link below: \r\n\r\nhttp://conveylive.com/friend/approve/$id";
        $msgBody .= "\r\n\r\nThanks\r\n\r\nConveylive Team\r\n\r\n";
        $msgBody .= "-------\r\n\r\nFind people from your address book on Conveylive.com! Go to: http://conveylive.com/invite.php";
        $msgBody .= "\r\n\r\nThis message was intended for $f_email";
        
        $fromAr = array("mail@conveylive.com" => "Conveylive Team");
        $toAr = $f_email;
        
        $isMailSent = simpleMail($con, $msgBody, $subject, $fromAr, array($toAr => $sender_name), "text/plain", $fromAr, 0);
        if($isMailSent)
        {
            $rep = "Your friend request has been sent! ";
            $rep .= "After confirmation from your friend, he/she  will be added to your friend list!";
        }
        else
        {
            $err .= $isMailSent;
            $rep .= "Your friend request has been sent!  But Mail Not Sent. ";
            $rep .= "After confirmation from your friend, he/she  will be added to your friend list!";
        }
    }
    else
    {
        $err .= "Sorry, your friend request was not sent ! DB Error:".$con->db->err; 
    }
}
    
home($con, $email);

$v = setLoginInfo($email, $con);

$sideitem = getSideItems($email, $con);

$con->tp->assign('sideitem', $sideitem);

$con->tp->assign('rep', $rep);

$con->tp->assign('err', $err);

$con->tp->assign('islogin',$islogin);

addSiteStat($pageName, $con, $email);

$con->tp->display('main.tpl');

?>
