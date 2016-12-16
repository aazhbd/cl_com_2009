<?php
require('config/project.php');
$con = new Project();

extract($_GET);
$pageName = $boxtype;

$rep = "";
$err = "";
$btitle = "";
$bbody = "";
$vad = "";
$had = "";
$sideitem = array();
$islogin = false;
$email = "";

$box_type = array("inbox" => 1, "outbox" => 2);

if($boxtype == "inbox" )
{
    $btitle = "Inbox";
    $bsubtitle = "Your list of incoming messages";
    
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
    
    $title = "ConveyLive :: Sent Messages";
    $con->tp->assign('title', $title);
    
    $desc = "Send Messages at ConveyLive to invite as friends, and join clubs. ConveyLive.com is a place to make friends and broadcast your creativity with the world. Publish your articles, audio, video, files, blogs, clubs and make it available to search engines, links and other sites as well as your friends. Browse the world through conveylive.com, expand your circle and get amazed with the large collection of other people's contents.";
    $con->tp->assign("descrip", $desc);

    $keys = "Send Messages, article, audio, video, photos, club, blog";
    $con->tp->assign("keys", $keys);        
}

$qvar = 'msg';
$sess_name = 'messages';

if(isset($_SESSION['login'] ) == true)
{
    $l = $_SESSION['login'];
    $islogin = true;
    $email = $l->getEmail();
    
    $title = "ConveyLive :: $btitle";
    
    $res = array();
    if(isset($_SESSION[$sess_name]))
    {    
        SmartyPaginate::setCurrentItem($start);
        $currIndex = SmartyPaginate::getCurrentIndex();
        $limit = SmartyPaginate::getLimit();
        $lm = sprintf(" LIMIT %d, %d", $currIndex, $limit);
        
        $query = $_SESSION["$qvar"];
        $query = $query.$lm;
        
        $res = paginate_search($query, $con);
        $err .= $con->db->err;
        $i = 0;
        foreach($res as $a)
        {
            $messages[] = $a;
            if($boxtype == "inbox") $sndr_mail_addr = $a['sndr_email'];
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
        //print_r($messages);
        $con->tp->assign('boxtype', $boxtype);
        $con->tp->assign('messages', $messages);
        
        $con->tp->assign('p', SmartyPaginate::getCurrentIndex());
        $con->tp->assign('x', 1);            
        SmartyPaginate::assign($con->tp);
    }
}
else
{
    $err = "Session Not set. You can not access this page";
}
$bbody = $con->tp->fetch('inbox_view.tpl'); 

$con->tp->assign('bbody', $bbody);
$con->tp->assign('btitle', $btitle);
$con->tp->assign('bsubtitle', $bsubtitle);
$con->tp->assign('rep', $rep);
$con->tp->assign('err', $err);

addSiteStat($pageName, $con, $email);

if($islogin == true)
{
    $v = setLoginInfo($email, $con);
    $sideitem = getSideItems($email, $con);
    $blogexist = checkBlog($con, $email);
}
$con->tp->assign('sideitem', $sideitem);    
$con->tp->assign('vad', $vad);
$con->tp->assign('had', $had);
$con->tp->assign('islogin',$islogin);

$con->tp->assign('title', $title);
$con->tp->display('main.tpl');
?>
