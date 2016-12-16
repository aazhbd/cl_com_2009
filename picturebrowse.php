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

getLatestCont($con,"Albums");

if(isset($_SESSION['login'] ) == true)
{
    $l = $_SESSION['login'];
    $islogin = true;
    $email = $l->getEmail();
}

$pageName = "Browse Albums";
$title = "conveylive.com :: $pageName";

$desc = "$title. Publish your albums with conveylive. Share Your photos with your friends and family. Browse all the albums published by users of conveylive to share and comment.";
$con->tp->assign("descrip", $desc);

$keys = "Photos, Albums, Picture, Share, ConveyLive";
$con->tp->assign("keys", $keys);

$con->tp->assign('email', $email);
$con->tp->assign('title', $title);

if(isset($sortby) && $sortby != "")
{
    if($sortby == "Latest")
    {
        $btitle = "Browse Latest Albums";
        $bsubtitle = "All Albums are in order that are recently published";
        $title = "conveylive.com :: Browse Latest Albums";
        $selCat = "Latest Albums";        
    }
}
else
{
    $btitle = "Browse Albums";
    $bsubtitle = "Browse latest albums";

    if($gen_id != null)
    {
        $topicHead = $gen_id;
    }
    else
    {
        $topicHead = "Latest Albums";
    }
}

if(isset($_SESSION['res']))
{    
    $_query = $_SESSION['pic'];
    SmartyPaginate::setCurrentItem($start);
    
    $currIndex = SmartyPaginate::getCurrentIndex();
    $limit = SmartyPaginate::getLimit();
    $l = sprintf(" LIMIT %d, %d", $currIndex, $limit);
    $query = $_query.$l;

    $res = paginate_search($query, $con);
    $albums = array();
    if(is_array($res) && $res!= false && $res != array() && count($res) > 0)
    {
        $i = 0;
        foreach($res as $a)
        {
            $albums[$i] = $a;
            
            $r = $con->db->selectData("select * from profiles where user_email = '".$albums[$i]['email']."' and admin_perm = 0");
            if($r == array() || $r == false || count($r) == 0) $err .= $con->db->err;
            else
            {
                $albums[$i]['pid'] = $r[0]['id'];
            }
            
            $r = $con->db->selectData("select count(id) as tot from images where album_id = '".$albums[$i]['id']."' and admin_perm = 0");
            if($r == array() || $r == false || count($r) == 0) $err .= $con->db->err;
            else
            {
                $albums[$i]['pic_count'] = $r[0]['tot'];
            }
            $i++;
        }
        $con->tp->assign('albums', $albums); 
        SmartyPaginate::assign($con->tp);
        $bbody .=  $con->tp->fetch("browse_album.tpl");
    }
    else
    {
        $err .= $con->db-> err;
        
        $err .= "Session is not set. Album not found";

        $btitle = "Album not available";
        
        $bbody =  $con->tp->fetch("browse_album.tpl");
    }
}
else
{
    $err .= "Session is not set. Album not found";
    
    $btitle = "Album not available";
    
    $bbody =  $con->tp->fetch("browse_album.tpl");
}
    
$con->tp->assign('bsubtitle', $bsubtitle);
$con->tp->assign('bbody', $bbody);
$con->tp->assign('btitle', $btitle);
$con->tp->assign('rep', $rep);
$con->tp->assign('err', $err);

if($islogin == true)
{
    $v = setLoginInfo($email, $con);
    $sideitem = getSideItems($email, $con);
}
$blogexist = checkBlog($con, $email);
addSiteStat($pageName, $con, $email);
$con->tp->assign('sideitem', $sideitem);    
$con->tp->assign('vad', $vad);
$con->tp->assign('had', $had);
$con->tp->assign('islogin',$islogin);
$con->tp->display('main.tpl');
?>