<?php
require_once('config/project.php');
$con = new Project();

$pageName ='Browse Video';


$title = "ConveyLive :: $pageName";

getLatestCont($con,"Videos");
getTopRatedCont($con,"Videos");
getMostViewedCont($con,"Videos");

$desc = "Browse the huge collection of video at ConveyLive. Watch your favourite video and songs and tutorials publshed by users of ConveyLive and publish your own video for the world to watch.";
$con->tp->assign("descrip", $desc);

$keys = " Video, Watch, Song, Music, Voice, communicate, share,network,  conveylive";
$con->tp->assign("keys", $keys);

$rep = "";
$err = "";
$btitle = "";
$bbody = "";
$vad = "";
$had = "";
$sideitem = array();
$islogin = false;


$con->tp->assign('title', $title);

if(isset($_SESSION['login'] ) == true)
{
    $l = $_SESSION['login'];
    $islogin = true;
    $email = $l->getEmail();
}
$con->tp->assign('email', $email);
$con->tp->assign('islogin',$islogin);
    
$desc = "Browse the huge collection of video at ConveyLive. Watch your favourite video and songs and tutorials publshed by users of ConveyLive and publish your own video for the world to watch.";
$con->tp->assign("descrip", $desc);

$keys = " Video, Watch, Song, Music, Voice, communicate, share,network,  conveylive";
$con->tp->assign("keys", $keys);

extract($_GET);

if(isset($sortby) && $sortby != "")
{
    if($sortby == "MostViewed")
    {
        $btitle = "Browse Most Viewed Videos";
        $bsubtitle = "All Videos are in order they were viewed most number of times";
        $title = "conveylive.com :: Browse Most Viewed Videos";
        
        $selCat = "Most Viewed Videos";
    }
    else if($sortby == "TopRated")
    {
        $btitle = "Browse Top Rated Videos";
        $bsubtitle = "All Videos are in order they were rated highest by the people";
        $title = "conveylive.com :: Browse Top Rated Videos";
        $selCat = "Top Rated Videos";        
    }
    else if($sortby == "Latest")
    {
        $btitle = "Browse Latest Videos";
        $bsubtitle = "All Videos are in order that are recently published";
        $title = "conveylive.com :: Browse Latest Videos";
        $selCat = "Latest Videos";        
    }
    //$videoList = getCatListDb($con, "Video"); 
}
else
{
    $btitle = "Browse Videos";
    $bsubtitle = "Browse latest video";

    if($cat_id != null)
    {
        $topicHead = $cat_id;
    }
    else
    {
        $topicHead = "Latest Videos";
    }

    $videoList = getCatListDb($con, "Video"); 
}

if($videoList != null)
{
    for($i = 0; $i < count($videoList); $i++)
    {
        $q = "select count(*) as tot from videos where admin_perm = 0 and privacy = 0 and category_id = '".$videoList[$i]['id']."'";
        $list = $con->db->selectData($q);
        
        //$list = $con->db->selectData("select count(*) as tot from uploaded_videos where admin_perm = 1 and privacy = 2 and category = '$videoList[$i]'");
        if($list != false && $list != array())
            $t = (int)$list[0]['tot'];
        else $err .= $con->db->err;
        if($t > 0)
        {
            $x = $videoList[$i]['cname'];
            $x = str_replace(" ", "_", $x );
            $pubList[$i]['linkcat'] = $x;
            $pubList[$i]['cat'] = $videoList[$i];
            $pubList[$i]['count'] = $t;
        }
    }
    
    for($i = 0; $i < count($videoList); $i++)
    {
        $list = $con->db->selectData("select count(*) as tot from videos where admin_perm = 0 and privacy = 0 and category_id = '".$videoList[$i]['id']."' and user_email = '$email'");
        //$list = $con->db->selectData("select count(*) as tot from uploaded_videos where admin_perm = 1 and privacy = 2 and category = '$videoList[$i]' and user_email = '$email'");
        if($list != false && $list != array())
            $t = (int)$list[0]['tot'];
        else $err .= $con->db->err;
        if($t > 0)
        {
            $x = $videoList[$i]['cname'];
            $x = str_replace(" ", "_", $x );
            $selfList[$i]['linkcat'] = $x;
            $selfList[$i]['cat'] = $videoList[$i];
            $selfList[$i]['count'] = $t;
        }
    }
}


$qvar = 'vid';
$sess_name = 'videos';
$video = array();
if(isset($_SESSION[$sess_name]))
{
    SmartyPaginate::setCurrentItem($start);
    
    $currIndex = SmartyPaginate::getCurrentIndex();
    $limit = SmartyPaginate::getLimit();

    $l = sprintf(" LIMIT %d, %d", $currIndex, $limit);
    
    $_query = $_SESSION[$qvar];
    $query = $_query.$l;

    $res = paginate_search($query, $con);
    $err .= $con->db->err;
    if(is_array($res) && $res!= false && $res != array() && count($res) > 0)
    {
        $i = 0;

        foreach($res as $a)
        {
            $video[$i] = $a;
            $video[$i]['videolink'] = "<a href='".URL."/video/watch/".$video[$i]['id']."'>Watch</a>";
            $video[$i]['author'] = $video[$i]['f_name'] . " " . $video[$i]['l_name'];
            
            $em = $video[$i]['email'];
            
            $j = $con->db->selectData("select user_imgs_id, id as pid from profiles where user_email = '$em'");
            if($j != false && $j != array())
            {
                $video[$i]['user_imgs_id'] = $j[0]['user_imgs_id'];
                $video[$i]['pid'] = $j[0]['pid'];
            }
            
            $k = $con->db->selectData("select id, cname from categorys where id = ".$video[$i]['category_id']."");
            if($k != false && $k != array())
            {
                $video[$i]['category'] = $k[0]['cname'];
            }
            
            $m = $con->db->selectData("select id, view_count, rating, tothits, neghits, ins_date, upd_date from contstats where media_id = ".$video[$i]['id']." and media_type = 'Video' and admin_perm = 0 ");
            if($m != false && $m != array())
            {
                $video[$i]['view_count'] = $m[0]['view_count'];
                $video[$i]['rating'] = $m[0]['rating'];
                $video[$i]['tothits'] = $m[0]['tothits'];
                $video[$i]['neghits'] = $m[0]['neghits'];
                $video[$i]['stat_ins_date'] = $m[0]['ins_date'];
                $video[$i]['stat_upd_date'] = $m[0]['upd_date'];
            }                    
            $i++; 
        }
        $con->tp->assign('videoList', $video);
    }
    $err .= $con->db->err;
    
    SmartyPaginate::assign($con->tp);

}
else
{
    $err .= $con->db->err;
    
    $err .= "Session is not set. Videos not found";
    
    $btitle = "Videos not available";
}

$con->tp->assign('topicHead', $topicHead);
$con->tp->assign('pubList', $pubList);
$con->tp->assign('selfList', $selfList);

$bbody = $con->tp->fetch('browse_video.tpl');


$v = setLoginInfo(trim($email), $con);

$con->tp->assign('islogin',$islogin);

$sideitem = getSideItems(trim($email), $con);

$blogexist = checkBlog($con, $email);

$con->tp->assign('bsubtitle', $bsubtitle);

$con->tp->assign('btitle', $btitle);

$con->tp->assign('bbody', $bbody);

$con->tp->assign('sideitem', $sideitem);

$con->tp->assign('rep', $rep);

$con->tp->assign('err', $err);

$con->tp->assign('vad', $vad);

$con->tp->assign('had', $had);

addSiteStat($pageName, $con, $email);

$con->tp->display('main.tpl');
?>