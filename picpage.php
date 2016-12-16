<?php
require('config/project.php');
$con = new Project();

extract($_GET);

$pageName = "Photos";
$title = "ConveyLive :: ".$pageName;


$rep = "";
$err = "";
$btitle = "";
$bbody = "";
$vad = "";
$had = "";
$sideitem = array();
$islogin = false;
$email = "";

$mediaLoaded = false;

getLatestCont($con,"Albums");

if(isset($_SESSION['login'] ) == true)
{
    $l = $_SESSION['login'];
    $islogin = true;
    $email = $l->getEmail();
}
$con->tp->assign('islogin',$islogin);

$mediaLoaded = false;
$isValid = true;

$r = $con->db->selectData("select album_id from images where id = $id ");
        
if($r != false and $r != array())
{
    $aid = $r[0]['album_id'];
}
else
{
    $err .= "Profile pictures not available: ". $con->db->err;
}
$album = array();
if($aid != 0)
{
    
    $r = $con->db->selectData("select * from albums where admin_perm = 0 and id in ( select album_id from images where id = $id )");
    if($r != false and $r != array())
    {
        foreach($r as $a)
        {
            $album[] = $a;
        }
        $con->tp->assign('album', $album);
        
        $user_email = $album[0]['user_email'];
        
        $is_friend = isFriend($user_email, $email, $con);
        
        $aid = $album[0]['id'];
        
        $album_privacy = $album[0]['privacy'];
        
        if($album_privacy == 4)
        {
            $club = getClubByAlbumId($con, $aid);
            $club_id = $club['id'];
            $is_member = isClubMember($con, $email, $club_id);
        }
        
        $user_name = getUserName($user_email, $con);
        
        $con->tp->assign('user_name', $user_name);
        
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
$pageName = "Album: ". $album['album_name'];
$con->tp->assign('title', $pageName);
$con->tp->assign('email', $email);

if($isValid)
{
    if(isset($_SESSION['res']))
    {    
        $_query = $_SESSION['pic'];
        SmartyPaginate::setCurrentItem($start);

        $prof_aid = getProfileAlbumId($con, $user_email, "Profile");
        $con->tp->assign('prof_aid', $prof_aid);
        if($album_privacy == "2" )
        {
            $btitle = "$user_name's Profile Photos";
            
            $title =  "$user_name's Profile Photos :: conveylive.com";
            
            $bsubtitle = "Profile Photos";
            
            $album_name = "Profile Photos";
            
            $has_perm = true;
        }
        else if($album_privacy == "1" )
        {
            $btitle = "$user_name's Personal Album - " . $album[0]['album_name'];;
            
            $title =  "$user_name's Personal Album - ".$album[0]['album_name'].":: conveylive.com";
            
            $bsubtitle = "Profile Photos";
            
            $album_name = "Profile Photos";
            
            $has_perm = true;
        }
        else if($album_privacy == "0")
        {
            $btitle = "$user_name's Album - ".$album[0]['album_name'];
            
            $title =  "Photo from $user_name's Album - ".$album[0]['album_name'] ." :: conveylive.com";
            
            $bsubtitle = $album[0]['remarks'];
            
            $album_name = $album[0]['album_name'];
            
            $has_perm = true;
        }
        else if($album_privacy == "4" )
        {
            $btitle = "Club Album - ".$album[0]['album_name'];
            
            $title =  "Photos from ".$album[0]['album_name']." Club Album :: conveylive.com";
            
            $bsubtitle = $album[0]['remarks'];
            
            $album_name = $album[0]['album_name'];
            
            $has_perm = true;
        }
        else if($album_privacy == "3" )
        {
            $btitle = "Video album of $user_name - ".$album[0]['album_name'];
            
            $title =  "Photos from ".$album[0]['album_name']." Video Album :: conveylive.com";
            
            $bsubtitle = $album[0]['remarks'];
            
            $album_name = $album[0]['album_name'];
            
            $has_perm = true;
        }
        
        $currIndex = SmartyPaginate::getCurrentIndex();
        $limit = SmartyPaginate::getLimit();
        $l = sprintf(" LIMIT %d, %d", $currIndex, $limit);
        $query = $_query.$l;
        
        $res = paginate_search($query, $con);
        
        if(is_array($res) && $res!= false && $res != array() && count($res) > 0)
        {            
            $con->tp->assign('aid', $aid);

            $con->tp->assign('pid', $pid);

            $con->tp->assign('img_id', $img_id);

            $con->tp->assign('uname', $user_name);
            
            $con->tp->assign('remarks', $album['remarks']);

            $con->tp->assign('album_name', $album_name);
            
            $con->tp->assign('res_list', $res);
            
            $con->tp->assign('email', $email);
            
            $mediaLoaded = true;
            
            SmartyPaginate::assign($con->tp);
            
        }
        else
        {
            $err .= $res;
            $err .= "Album not found.";
            $btitle = "Album not available";
        }
    }
}
else
{
    $err .= "Session is not set. Album not found";
    
    $btitle = "Album not available";
}

$bbody =  $con->tp->fetch("pic_view.tpl");

$mediaid = $con->tp->get_template_vars('media_id');

if($user_email != $email)
{
    $pi = getContStats($con, "Photo", $mediaid);
    if($pi != array())
    {
        foreach($pi as $p)
        {
            $ph = $p;
        }
        $c = (int)$ph['view_count'] + 1;
        
        updateContStats($con, $mediaid, "Photo", $c, "", "", "");
    }
}

$imgstats = getContStats($con, "Photo", $mediaid);

$con->tp->assign('imgstats', $imgstats[0]);

$bbody .= "<br />".$con->tp->fetch('topinfo.tpl'). "<div style='margin-bottom:10px; width:98%;'></div>";

$desc = $album_name ."- Album of $user_name. Publish your albums with conveylive. Share Your photos with your friends and family. Browse all the albums published by users of conveylive to share and comment.";
$con->tp->assign("descrip", $desc);

$keys .= "$album_name , $user_name,  Photos, Albums, Picture, Share, ConveyLive";
$con->tp->assign("keys", $keys);

$mediaid = $con->tp->get_template_vars('media_id');

$coms = getComList($mediaid, 'Picture', $con);
if(is_string($coms)) $err .= $coms;

$con->tp->assign('media_id', $mediaid);
$con->tp->assign('coms', $coms);

$con->tp->assign('email', $email);                                         
$keys = $res['file_name'] .", ". $user_name. ", ". $album['album_name'];
$con->tp->assign('keys', $keys);
$bbody .= $con->tp->fetch('photocmt_form.tpl');

//Content Invite
$cont_formlabel = "Invite your friends to view this photo";
$con->tp->assign('cont_formlabel', $cont_formlabel);

$mail_subject = getUserName($email, $con). " invites you to view a photo from the album, \"".$album[0]['album_name'] . "\"";
$con->tp->assign('mail_subject', $mail_subject);

$mail_subject_general = "You have been invited to view a photo from the album, \"".$album[0]['album_name'] ."\" by your friend ";
$con->tp->assign('mail_subject_general', $mail_subject_general);            

//$mail_body = "Hi, \r\n";  
$mail_body .= "I wanted to invite you to view this photo from the album  named, \"".$album[0]['album_name'] ."\", published by $user_name.";
$mail_body .= "You can join in conveylive.com to add comments to this album photos. Go to this link or copy paste it in your browser ";
$mail_body .= URL . "/picture/view/$mediaid";
$mail_body .= " and let me know if you liked it.";
//$mail_body .= "\r\n\r\nRegards";
$con->tp->assign('mail_body', $mail_body);

$conttype = "photo";
$con->tp->assign('conttype', $conttype);

if($email != "")
{
    $bbody .= "<br />".$con->tp->fetch('invitecontent_form.tpl');
}
//Content Invite End
    
$con->tp->assign('bsubtitle', $bsubtitle);
$con->tp->assign('bbody', $bbody);
$con->tp->assign('btitle', $btitle);
$con->tp->assign('rep', $rep);
$con->tp->assign('err', $err);

if($islogin == true)
{
    $v = setLoginInfo($email, $con);
    $sideitem = getSideItems($email, $con);
    $blogexist = checkBlog($con, $email);
}

addSiteStat($pageName, $con, $email);

$con->tp->assign('title', $title); 
$con->tp->assign('sideitem', $sideitem);    
$con->tp->assign('vad', $vad);
$con->tp->assign('had', $had);
$con->tp->display('main.tpl');
?>