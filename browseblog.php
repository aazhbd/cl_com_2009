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

getLatestCont($con,"Blogs");

if(isset($_SESSION['login'] ) == true)
{
    $l = $_SESSION['login'];
    $islogin = true;
    $email = $l->getEmail();
}
$blogexist = checkBlog($con, $email);

$pageName = "Browse Blogs";
$title = "ConveyLive :: $pageName";

$desc = "Browse Blogs and Share Your Blogs and posts with your friends and family. Browse all the blogs published by users of conveylive to share and comment.";
$con->tp->assign("descrip", $desc);

$keys = "Blogs, Posts, Share, ConveyLive";
$con->tp->assign("keys", $keys);

$btitle = $pageName;
$bsubtitle = "Browse latest blogs";

if(isset($sortby) && $sortby != "")
{
    if($sortby == "Latest")
    {
        $btitle = "Browse Latest Blogs";
        $bsubtitle = "All Blogs are in order that are recently published";
        $title = "conveylive.com :: Browse Latest Blogs";
        $selCat = "Latest Blogs";        
    }
}
else
{

    $btitle = "Browse Blogs";
    $bsubtitle = "Browse latest blogs";

    $topicHead = "Latest Blogs";
}

$con->tp->assign('email', $email);
$con->tp->assign('title', $title);


if(isset($_GET['cat']))
{
    $c = str_replace(" ", "_", $cat);
    $topicHead = "<a href='".URL."/blog/category/$cat'>$c</a>";
}
else
{
    $topicHead = "<a href='".URL."/blog/browseall'>Latest Blogs</a>";
}

if(isset($_SESSION['res']))
{    
    $_query = $_SESSION['blg'];
    SmartyPaginate::setCurrentItem($start);
    
    $currIndex = SmartyPaginate::getCurrentIndex();
    $limit = SmartyPaginate::getLimit();
    $l = sprintf(" LIMIT %d, %d", $currIndex, $limit);
    $query = $_query.$l;

    $res = paginate_search($query, $con);
    
    if(is_array($res) && $res!= false && $res != array() && count($res) > 0)
    {
        for($i = 0; $i < count($res); $i++)
        {
            $cdate = $res[$i]['ins_date'];
            $date = new DateTime($cdate);
            $res[$i]['ins_date'] = $date->format("F j, Y, g:i a");
            
            $uemail = $res[$i]['email'];
            $res[$i]['pid'] = getPrifileId($uemail,$con);
            $res[$i]['user_imgs_id'] = getProfImgId($uemail,$con);
            
            $q = "select bposts.id as post_id, articles.id as art_id, title, bposts.upd_date as upd_date from bposts, articles where bposts.blog_id = ".$res[$i]['id']." and articles.user_email = bposts.user_email and art_typ = 2 and bposts.admin_perm =  0 and bposts.article_id = articles.id order by bposts.upd_date desc LIMIT 0, 5";
            $posts = paginate_search($q, $con);
            if(count($posts) > 0)
            {
                $res[$i]['posts'] = $posts;
            }
            
        }
        $con->tp->assign('blogs', $res);
    }
    $err .= $con->db->err;
    
    SmartyPaginate::assign($con->tp);
    $con->tp->assign('pubList', $pubList);
    $con->tp->assign('topicHead', $topicHead); 
    $bbody .=  $con->tp->fetch("browse_blogs.tpl");
    $con->tp->assign('Latest Blogs', $topicHead);
}
else
{
    $err .= $con->db->err;

    $err .= "Session is not set. Album not found";

    $btitle = "Blogs not available";

    $bbody =  $con->tp->fetch("browse_blogs.tpl");
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

addSiteStat($pageName, $con, $email);
$con->tp->assign('sideitem', $sideitem);    
$con->tp->assign('vad', $vad);
$con->tp->assign('had', $had);
$con->tp->assign('islogin',$islogin);
$con->tp->display('main.tpl');
?>