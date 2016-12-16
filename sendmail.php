<?php
if(!isset($_POST['submit'])){ echo "You can not access this page directly."; return; }

require_once('config/project.php');
$con = new Project();

$pageName ='Invite Friends';

$title = "ConveyLive :: $pageName";
$rep = "";
$err = "";
$btitle = "";
$bbody = "";
$sideitem = array();
$islogin = false;

if(isset($_SESSION['login'] ) == true)
{
    $l = $_SESSION['login'];
    $islogin = true;
    $email = $l->getEmail();
    $username = getUserName($email,$con);
}
if (isset($_POST['submit']) == true)
{
    $addr_array = $_POST['chkedemail'];
    $count = 0;
    $uemail = $_POST['uemail'];
    
    foreach($addr_array as $adr)
    {
        $str = $adr;
        $straray = explode(",", $str);
        $adress[$straray[0]] = $straray[1];
                
        $key = $straray[0];
        $value = $straray[1];
        
        $subj = "Your friend $username has invited you to join ConveyLive.com";
        $msgBody = "Hello, $value\r\n\r\n";
        $msgBody .= $_POST['message'];
        $msgBody .= "\r\nFriend's Email: $uemail\r\n\r\n";
        $msgBody .= "-------\r\n\r\nPlease Follow this link http://conveylive.com/signup to signup for a new account in ConveyLive. \r\n\r\nJoin ConveyLive and broadcast your creativity";
        $msgBody .= "\r\n\r\nThis email was intended for <$key>";

        $result = simpleMail($con, $msgBody, $subj, array('mail@conveylive.com' => 'conveylive Team'), array($key => $value), "text/plain", array($uemail => $username), 4);
        if($result)
        {
            $sentList[] = $straray[0];
            $count++;
        }
        else
        {
            $failList[] = $straray[0];
        }
    }
}

if(count($sentList) > 0) 
{
    $rep = "Your messages have been sent successfully. Total $count message(s) sent.";
    $fail = implode(",",$failList);
    $success = implode(",",$sentList);
    //echo "The following email addresses were sent successfully: " . $success;
    //echo "The following email addresses were not sent: " . $fail;
    
    if($islogin)
    {
        $uemail_id = $_POST['uemail_id']; 
        $date = date("Y-m-d G:i:s");
        foreach($adress as $key => $ad)
        {
            $r = $con->db->insertData("insert into contemails ( user_email , uemail_id, uemail, send_date) values ( '$email', '$uemail_id','$key', '$date' )");
            if($r == false)
            {
                //echo $con->db->err;
            }
        }
    }
}
else 
{
    $err = "Sorry, Could not send your message to your contacts. Please try again";
}
if($islogin)
{
    home($con, $email);
}

$v = setLoginInfo(trim($email), $con);

$con->tp->assign('islogin',$islogin);

$sideitem = getSideItems(trim($email), $con);

$blogexist = checkBlog($con, $email);

$con->tp->assign('sideitem', $sideitem);

$con->tp->assign('rep', $rep);

$con->tp->assign('err', $err);

addSiteStat($pageName, $con, $email);

$con->tp->assign('title', $title);

if($islogin)
    $con->tp->display('main.tpl');
else
    $con->tp->display('home.tpl');

?>