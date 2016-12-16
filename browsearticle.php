<?php
require_once('config/project.php');
$con = new Project();

$pageName ='Browse Pages';


$title = "conveylive.com :: $pageName";

$desc = "Browse Pages in conveylive.com. Publish articles and writeups and share your views. Get Amazed by the Huge collection of articles in conveylive";
$con->tp->assign("descrip", $desc);

$keys = "Pages, Articles, Writeups, communicate, share,network,  conveylive";
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

getLatestCont($con,"Pages");
getTopRatedCont($con,"Pages");
getMostViewedCont($con,"Pages");

if(isset($_SESSION['login'] ) == true)
{
    $l = $_SESSION['login'];
    $islogin = true;
    $email = $l->getEmail();
}
$con->tp->assign('email', $email);
extract($_GET);

if(isset($sortby) && $sortby != "")
{
    if($sortby == "MostViewed")
    {
        $btitle = "Browse Most Viewed Pages";
        $bsubtitle = "All Pages are in order they were viewed most number of times";
        $title = "conveylive.com :: Browse Most Viewed Pages";
        $selCat = "Most Viewed Pages";
    }
    else if($sortby == "TopRated")
    {
        $btitle = "Browse Top Rated Pages";
        $bsubtitle = "All Pages are in order they were rated highest by the people";
        $title = "conveylive.com :: Browse Top Rated Pages";
        $selCat = "Top Rated Pages";        
    }
    else if($sortby == "Latest")
    {
        $btitle = "Browse Latest Pages";
        $bsubtitle = "All Pages are in order that are recently published";
        $title = "conveylive.com :: Browse Latest Pages";
        $selCat = "Latest Pages";        
    }
}
else
{
    $btitle = "Browse Pages";
    $bsubtitle = "Browse latest pages";
    $selCat = "Latest Pages";

    if(isset($_GET['cat']))
    {
        $selCat = $cat;
    }

    if(isset($_GET['self']))
    {
        if($self == 1)
        {
            $isSelf = true;
        }
    }    
    $catList = getCatListDb($con, "Article");
}


if($catList != null)
{
    for($i = 0; $i < count($catList); $i++)
    {
        $query = "select count(*) as tot from articles where admin_perm = 0 and privacy = 0 and art_typ = 1 and category_id = '".$catList[$i]['id']."'";

        $list = $con->db->selectData($query);
        if($list != false && $list != array())
            $t = (int)$list[0]['tot'];
        else $err .= $con->db->err;
        if($t > 0)
        {
            $x = $catList[$i]['cname'];
            $x = str_replace(" ", "_", $x );
            $pubList[$i]['linkcat'] = $x;
            $pubList[$i]['category'] = $catList[$i]['cname'];
            $pubList[$i]['count'] = $t;
        }
    }
    //print_r($catList);
    for($i = 0; $i < count($catList); $i++)
    {
        $q = "select count(*) as tot from articles where admin_perm = 0 and privacy = 0 and art_typ = 1 and category_id = ".$catList[$i]['id']." and user_email = '$email'";
        
        $list = $con->db->selectData($q);
        if($list != false && $list != array())
            $t = (int)$list[0]['tot'];
        else $err .= $con->db->err;
        if($t > 0)
        {
            $x = $catList[$i]['cname'];
            $x = str_replace(" ", "_", $x );
            $selfList[$i]['linkcat'] = $x;
            $selfList[$i]['category'] = $catList[$i]['cname'];
            $selfList[$i]['count'] = $t;
        }
    }
}

$qvar = 'art';
$sess_name = 'articles';

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
    
    $article = array();
    
    if(is_array($res) && $res!= false && $res != array() && count($res) > 0)
    {
        $i = 0;
        
        foreach($res as $a)
        {
            $article[$i] = $a;
            $body = $article[$i]['body'];
            
            //$body = $a['body'];
            
            $body = stripslashes($body);
            $body = html_entity_decode($body);
            
            $body = strip_tags($body);
            $article[$i]['body'] = $body;
            
            $article[$i]['author'] = $article[$i]['f_name'] . " " . $article[$i]['l_name'];
            
            $em = $article[$i]['email'];
            $j = $con->db->selectData("select user_imgs_id, id from profiles where user_email = '$em'");
            if($j != false && $j != array())
            {
                $article[$i]['user_imgs_id'] = $j[0]['user_imgs_id'];
                $article[$i]['pid'] = $j[0]['id'];
            }
            
            $j = $con->db->selectData("select cname from categorys where id = ".$article[$i]['category_id']."");
            if($j != false && $j != array())
            {
                $article[$i]['category'] = $j[0]['cname'];
            }            
            
            $m = $con->db->selectData("select id, view_count, rating, tothits, neghits, ins_date, upd_date from contstats where media_id = ".$article[$i]['id']." and media_type = 'Article' and admin_perm = 0 ");
            if($m != false && $m != array())
            {
                $article[$i]['view_count'] = $m[0]['view_count'];
                $article[$i]['rating'] = $m[0]['rating'];
                $article[$i]['tothots'] = $m[0]['tothots'];
                $article[$i]['neghits'] = $m[0]['neghits'];
                $article[$i]['stat_ins_date'] = $m[0]['ins_date'];
                $article[$i]['stat_upd_date'] = $m[0]['upd_date'];
            }
            
            $i++;
        }
        
        $con->tp->assign('artList', $article);
    }
    
    $err .= $con->db->err;
    
    SmartyPaginate::assign($con->tp);

}
else
{
    $err .= $con->db->err;
    
    $err .= "Session is not set. Page not found";
    
    $btitle = "Page not available";
}


$con->tp->assign('email', $email);
$con->tp->assign('bsubtitle', $bsubtitle);
$con->tp->assign('topicHead', $selCat);
$con->tp->assign('pubList', $pubList);
$con->tp->assign('selfCatList', $selfList);

$bbody = $con->tp->fetch('browse_art.tpl');


$v = setLoginInfo(trim($email), $con);

$con->tp->assign('islogin',$islogin);

$sideitem = getSideItems(trim($email), $con);

$blogexist = checkBlog($con, $email);

$con->tp->assign('btitle', $btitle);

$con->tp->assign('bbody', $bbody);

$con->tp->assign('sideitem', $sideitem);

$con->tp->assign('rep', $rep);

$con->tp->assign('err', $err);

addSiteStat($pageName, $con, $email);

$con->tp->display('main.tpl');

?>