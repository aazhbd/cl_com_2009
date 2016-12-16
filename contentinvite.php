<?php

//if(!isset($_POST['submit'])){ echo "You can not access this page directly."; return; }

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

$sList = array();

$fList = array();

if(isset($_SESSION['login'] ) == true)
{

    $l = $_SESSION['login'];

    $islogin = true;

    $email = $l->getEmail();

}

$msgready = false;
$name = getUserName($email,$con);
if (isset($_POST) == true)
{
    $address = $_POST['email'];
    if(isset($_POST['uname']) && strlen(trim($_POST['uname'])) > 0 && trim($_POST['uname']) != "Type your name")
        $subj = html_entity_decode(stripcslashes($_POST['subj'])). " ". html_entity_decode(stripcslashes($_POST['uname']));
    else
    {
        $subj = html_entity_decode(stripcslashes($_POST['subj']));
    }
    
    $msgBody = "Hi, \r\n";
    $msgBody .= html_entity_decode(stripcslashes($_POST['addmsg']));
    //$msgBody .= html_entity_decode(stripcslashes(trim($_POST['message'])));
    $msgBody .= "\r\n\r\nRegards";
    $msgBody .= "\r\n$name";
    $msgBody .= "\r\n\r\n-------\r\n\r\nFind people from your address book on ConveyLive! Go to: http://conveylive.com/invite.php";
    $msgBody .= "\r\n\r\nNot a Member yet? Please signup to join conveylive today. Click the following link to signup.\r\n\r\nhttp://conveylive.com/signup";
    $msgBody .= "\r\n\r\nIf you have any questions regarding conveylive or facing any problems please email us at mail@conveylive.com";
    $msgready = true;
    $html = false;
}
$issent = true;

if($msgready)
{
    $adrAr = explode(",",$address);
    
    for($i = 0; $i < count($adrAr); $i++)
    {
    
        $ad = $adrAr[$i];
        
        $result = simpleMail($con, $msgBody,$subj,array('mail@conveylive.com' => 'Conveylive Team'),array($ad => $ad), "text/plain" , array("mail@conveylive.com" => "Conveylive Team"), 4 );  //LOW 

        if($result) 
        {
            $sList[] = $ad;
        }
        else 
        {
            $fList[] = $ad;
            $issent = false;
        }
    }
    
    if($issent == true && count($sList)> 0 )
    {
        $rep .= "Your message(s) have been sent successfully.";
    }

    else 
    {
        if(count($sList) > 0)
            $rep .= "Messages were successfully sent to the following address(es): ". implode(", ", $sList );
        if(count($fList) > 0) 
            $rep .= "Sorry, Could not send your message to the following address(es): ". implode(", ", $fList );
        
    }
}
$con->tp->assign('rep', $rep);

$con->tp->assign('err', $err);

home($con, $email);

$con->tp->assign('rep', $rep);

$con->tp->assign('err', $err);

$v = setLoginInfo(trim($email), $con);

$con->tp->assign('islogin',$islogin);

$sideitem = getSideItems(trim($email), $con);

$blogexist = checkBlog($con, $email);

$con->tp->assign('sideitem', $sideitem);

addSiteStat($pageName, $con, $email);

$con->tp->assign('title', $title);

$con->tp->display('main.tpl');

?>