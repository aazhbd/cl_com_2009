<?php
require('config/project.php');
$con = new Project();

extract($_GET);

$rep = "";
$err = "";
$btitle = "";
$bbody = "";
$vad = "";
$had = "";
$sideitem = array();
$islogin = false;
$email = "";

$albumtbl = array();

if(isset($_SESSION['login'] ) == true)
{
    $l = $_SESSION['login'];
    $islogin = true;
    $email = $l->getEmail();
}
$con->tp->assign('islogin',$islogin);
$blogexist = checkBlog($con, $email); 

$isValid = true;

if($aid != 0)
{
    $r = $con->db->selectData("select * from albums where admin_perm = 0 and id = $aid");
    if($r != false and $r != array())
    {
        foreach($r as $a)
        {
            $album = $a;
        }
        $user_email = $album['user_email'];
        
        $user_name = getUserName($user_email, $con);
        
        $pid = getPrifileId($user_email, $con);
        
        $img_id = getProfImgId($user_email, $con);
    }
}
else
{
    $user_email = $email;

    $user_name = getUserName($email, $con);

    $pid = getPrifileId($email, $con);

    $img_id = getProfImgId($email, $con);
}

$prof_aid = getProfileAlbumId($con, $user_email, "Profile");
$con->tp->assign('prof_aid', $prof_aid);
if($aid == $prof_aid)
{
    $pageName = "$user_name's Profile Photos";
    
    $title = "$user_name's Profile Photos :: ConveyLive";
}
else
{
    $pageName = "Album: ". $album['album_name'];
    
    $title = $album['album_name'] . " - $user_name's Album :: ConveyLive";
}

$con->tp->assign('title', $title);
$con->tp->assign('email', $email);

if(isset($_SESSION['res']))
{    
    $_query = $_SESSION['pic'];
    SmartyPaginate::setCurrentItem($start);

    if($aid == $prof_aid)
    {
        $btitle = "$user_name's Profile Photos";
    
        $bsubtitle = "Profile Photos";
    }
    else
    {
        $btitle = "$user_name's Album - ".$album['album_name'];
    
        $bsubtitle = $album['remarks'];
    }
    
    $currIndex = SmartyPaginate::getCurrentIndex();
    $limit = SmartyPaginate::getLimit();
    $l = sprintf(" LIMIT %d, %d", $currIndex, $limit);
    $query = $_query.$l;
    
    $res = paginate_search($query, $con);
    if(is_string($res)) $err .= $con->db-> err;
    else if(is_array($res))
    {
        $i = 0;
        foreach($res as $a)
        {
            $albumpics[$i] = $a;
            $album_path = $albumpics[$i]['album_id'] . '_'. str_replace(" ", "_", $album['album_name']);
            $photo_path = $albumpics[$i]['id'] . '_lrg_' . str_replace(" ", "_", $albumpics[$i]['file_name']);
            $albumpics[$i]['fpath'] = 'directories/albums/'.$album_path . '/'. $photo_path;
            $i++;
        }
        $con->tp->assign('album', $albumpics);
    }
    $con->tp->assign('aid', $aid);

    $con->tp->assign('pid', $pid);

    $con->tp->assign('img_id', $img_id);

    $con->tp->assign('uname', $user_name);
    
    //Content Invite
    $cont_formlabel = "Invite your friends to view this album";
    $con->tp->assign('cont_formlabel', $cont_formlabel);
    
    $mail_subject = getUserName($email, $con). " invites you to view an album named, \"".$album['album_name'] . "\"";
    $con->tp->assign('mail_subject', $mail_subject);
    
    $mail_subject_general = "You have been invited to view an album named, \"".$album['album_name'] . "\" by your friend ";
    $con->tp->assign('mail_subject_general', $mail_subject_general);            
    
    //$mail_body = "Hi, \r\n";  
    $mail_body .= "I wanted to invite you to view this album named, \"".$album['album_name'] .".\", published by $user_name.";
    $mail_body .= "You can join in conveylive.com to add comments to this album photos. Go to this link or copy paste it in your browser ";
    $mail_body .= URL . "/picture/albumview/$aid";
    $mail_body .= " and let me know if you liked it.";
    //$mail_body .= "\r\n\r\nRegards";
    $con->tp->assign('mail_body', $mail_body);
    
    $conttype = "album";
    $con->tp->assign('conttype', $conttype);
    //Content Invite End
    
    SmartyPaginate::assign($con->tp);
    $bbody =  $con->tp->fetch("album_view.tpl");
}
else
{
    $err .= "Session is not set. Album not found";
    
    $btitle = "Album not available";
    
    $bbody =  $con->tp->fetch("album_view.tpl");
}

$desc = "$btitle. Publish your albums with conveylive. Share Your photos with your friends and family. Browse all the albums published by users of conveylive to share and comment.";
$con->tp->assign("descrip", $desc);

$keys = "Photos, Albums, Picture, Share, ConveyLive";
$con->tp->assign("keys", $keys);
    
$con->tp->assign('bsubtitle', $bsubtitle);
$con->tp->assign('bbody', $bbody);
$con->tp->assign('btitle', $btitle);
$con->tp->assign('rep', $rep);
$con->tp->assign('err', $err);

getLatestCont($con,"Albums");

if($islogin == true)
{
    $v = setLoginInfo($email, $con);
    $sideitem = getSideItems($email, $con);
}

addSiteStat($pageName, $con, $email);
$con->tp->assign('sideitem', $sideitem);    
$con->tp->assign('vad', $vad);
$con->tp->assign('had', $had);
$con->tp->display('main.tpl');
?>