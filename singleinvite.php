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

$vad = "";

$had = "";

$sideitem = array();

$islogin = false;



if(isset($_SESSION['login'] ) == true)
{

    $l = $_SESSION['login'];

    $islogin = true;

    $email = $l->getEmail();

}

$msgready = false;

if (isset($_POST['submit']) == true)
{

    $adress = $_POST['email'];

    $subj = $_POST['subj'];
    
    if(isset($_POST['message'])== false || $_POST['message'] == "")
    {
        $uname = getUserName($email, $con);

        $subj = "Hey! come and join conveylive.com";

        $msgBody .= "Hello, \r\n\r\n";

        $msgBody .= "I have been using the site conveylive.com for a while and I really find this one interesting. Here I can post my own articles and blogs in custom formatting and view people's articles, blogs, blog posts and their comments.\r\n\r\n";

        $msgBody .= "Moreover, it has some exclusive collection of photos in the image gallery, and audios and videos published by people from different corners of the world. I hope that you can also join and post your personal collections of albums, audios and videos to share with us.\r\n";

        $msgBody .= "\r\nWe can also join serveral clubs and share files and discuss various current issues. It's really worth being a member of conveylive. So come and join me in conveylive.com.\r\n";

        $msgBody .= "\r\nRegards\r\n$uname";
        
        $msgready = true;
        $html = false;
    }
    else
    {
        $msgBody .= $_POST['message'];
        $msgready = true;
        $html = false;
    }

}


if($msgready)
{
    $result = simpleMail($con, $msgBody, $subj, array($email => $uname), array($adress => $adress), "text/plain", array("mail@conveylive.com" => "conveylive Team"), 3 );

    if($result) 
    {

        $rep = "Your message has been sent successfully.";

    }

    else 
    {

        $err = "Sorry, Could not send your message to your contact. Please try again later.";

    }


}
home($con, $email);



$v = setLoginInfo(trim($email), $con);



$con->tp->assign('islogin',$islogin);



$sideitem = getSideItems(trim($email), $con);



$blogexist = checkBlog($con, $email);



$con->tp->assign('sideitem', $sideitem);



$con->tp->assign('rep', $rep);



$con->tp->assign('err', $err);



$con->tp->assign('vad', $vad);



$con->tp->assign('had', $had);



addSiteStat($pageName, $con, $email);



$con->tp->assign('title', $title);



$con->tp->display('main.tpl');



?>