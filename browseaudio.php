<?php
require_once('config/project.php');
$con = new Project();

$pageName ='Browse Audio';


$title = $title = "ConveyLive :: $pageName";

$desc = "Browse Audio, Songs, Voice published by users of ConveyLive. Listen to you favourite audio publshed by users of ConveyLive and publish your own audio for the world to listen";
$con->tp->assign("descrip", $desc);

$keys = "Audio, Listen, Song, Music, Voice, communicate, share,network,  conveylive";
$con->tp->assign("keys", $keys);

$rep = "";
$err = "";
$btitle = "";
$bbody = "";
$vad = "";
$had = "";
$sideitem = array();
$islogin = false;

getLatestCont($con,"Audios");
getTopRatedCont($con,"Audios");
getMostViewedCont($con,"Audios");

$con->tp->assign('title', $title);

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
        $btitle = "Browse Most Played Audios";
        $bsubtitle = "All Audios are in order they were viewed most number of times";
        $title = "conveylive.com :: Browse Most Played Audios";
        $selCat = "Most Played Audios";
    }
    else if($sortby == "TopRated")
    {
        $btitle = "Browse Top Rated Audios";
        $bsubtitle = "All Audios are in order they were rated highest by the people";
        $title = "conveylive.com :: Browse Top Rated Audios";
        $selCat = "Top Rated Audios";        
    }
    else if($sortby == "Latest")
    {
        $btitle = "Browse Latest Audios";
        $bsubtitle = "All Audios are in order that are recently published";
        $title = "conveylive.com :: Browse Latest Audios";
        $selCat = "Latest Audios";        
    }
}
else
{

    $btitle = "Browse Audio";
    $bsubtitle = "Browse latest audio";

    if($gen_id != null)
    {
        $topicHead = $gen_id;
    }
    else
    {
        $topicHead = "Latest Audios";
    }

    $genreList = getCatListDb($con, "Audio");
}

if($genreList != null)
{
    for($i = 0; $i < count($genreList); $i++)
    {
        $list = $con->db->selectData("select count(*) as tot from audios where admin_perm = 0 and privacy = 0 and category_id = '".$genreList[$i]['id']."'");
        if($list != false && $list != array())
            $t = (int)$list[0]['tot'];
        else $err .= $con->db->err;
        if($t > 0)
        {
            $x = $genreList[$i]['cname'];
            $x = str_replace(" ", "_", $x );
            $pubList[$i]['linkgenre'] = $x;
            $pubList[$i]['genre'] = $genreList[$i];
            $pubList[$i]['count'] = $t;
        }
    }

    for($i = 0; $i < count($genreList); $i++)
    {
        $list = $con->db->selectData("select count(*) as tot from audios where admin_perm = 0 and privacy = 0 and category_id = '".$genreList[$i]['id']."' and user_email = '$email'");
        if($list != false && $list != array())
            $t = (int)$list[0]['tot'];
        else $err .= $con->db->err;
        if($t > 0)
        {
            $x = $genreList[$i]['cname'];
            $x = str_replace(" ", "_", $x );
            $selfList[$i]['linkgenre'] = $x;
            $selfList[$i]['genre'] = $genreList[$i];
            $selfList[$i]['count'] = $t;
        }
    }
}
$audio = array();
$qvar = 'aud';
$sess_name = 'audios';

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
            $audio[$i] = $a;
            $audio[$i]['audiolink'] = "<a href='".URL."/audio/listen/".$audio[$i]['id']."'>Listen</a>";
            $audio[$i]['author'] = $audio[$i]['f_name'] . " " . $audio[$i]['l_name'];
                        
            $em = $audio[$i]['email'];
            
            $j = $con->db->selectData("select user_imgs_id, id as pid from profiles where user_email = '$em'");
            if($j != false && $j != array())
            {
                $audio[$i]['user_imgs_id'] = $j[0]['user_imgs_id'];
                $audio[$i]['pid'] = $j[0]['pid'];
            }
            $k = $con->db->selectData("select cname from categorys where id = ".$audio[$i]['category_id']."");
            if($k != false && $k != array())
            {
                $audio[$i]['genre'] = $k[0]['cname'];
            }
            
            $m = $con->db->selectData("select id, view_count, rating, tothits, neghits, ins_date, upd_date from contstats where media_id = ".$audio[$i]['id']." and media_type = 'Audio' and admin_perm = 0 ");
            if($m != false && $m != array())
            {
                $audio[$i]['view_count'] = $m[0]['view_count'];
                $audio[$i]['rating'] = $m[0]['rating'];
                $audio[$i]['tothits'] = $m[0]['tothits'];
                $audio[$i]['neghits'] = $m[0]['neghits'];
                $audio[$i]['stat_ins_date'] = $m[0]['ins_date'];
                $audio[$i]['stat_upd_date'] = $m[0]['upd_date'];
            }            
            $i++; 
        }
        $con->tp->assign('audioList', $audio);
    }
    $err .= $con->db->err;
    
    SmartyPaginate::assign($con->tp);

}
else
{
    $err .= $con->db->err;
    
    $err .= "Session is not set. Audios not found";
    
    $btitle = "Audios not available";
}


$con->tp->assign('email', $email);
$con->tp->assign('filename', $filename);
$con->tp->assign('topicHead', $topicHead);
$con->tp->assign('pubList', $pubList);
$con->tp->assign('selfList', $selfList);
$con->tp->assign('bsubtitle', $bsubtitle);

$bbody = $con->tp->fetch('browse_audio.tpl');


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