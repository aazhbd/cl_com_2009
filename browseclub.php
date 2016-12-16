<?php
require_once('config/project.php');
$con = new Project();

$pageName ='Browse Clubs';


$title = "ConveyLive :: $pageName";

getLatestCont($con,"Clubs");

$desc = "Browse all the Clubs of conveylive published by users to share,comment and discuss. Create Your own Clubs to discuss and share your digital possesions like, Photos, Files and text posts.";
$con->tp->assign("descrip", $desc);

$keys = "Clubs, Posts, File, Share, Community, Network, ConveyLive";
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

extract($_GET);

$btitle = "Browse Clubs";
$bsubtitle = "Join clubs to discuss and share your views";

if(isset($sortby) && $sortby != "")
{
    if($sortby == "Latest")
    {
        $btitle = "Browse Latest Clubs";
        $bsubtitle = "All Clubs are in order that are recently created";
        $title = "conveylive.com :: Browse Latest Clubs";
        $selCat = "Latest Clubs";        
    }
}
else
{

    $btitle = "Browse Clubs";
    $bsubtitle = "Browse latest clubs";

    if($gen_id != null)
    {
        $topicHead = $cat;
    }
    else
    {
        $topicHead = "Latest Clubs";
    }

    $catList = getCatListDb($con, "Club");
}

$con->tp->assign('email', $email);
$selCat = "Recently Updated Clubs";
$is_member = false;

for($i = 0; $i < count($catList); $i++)
{
    $list = $con->db->selectData("select count(*) as tot from clubs where admin_perm = 0 and status = 0 and ( privacy = 0 or privacy = 1 )  and category_id = '".$catList[$i]['id']."'");
    if($list != false && $list != array())
        $t = (int)$list[0]['tot'];
    else $err .= $con->db->err;
    if($t > 0)
    {
        $x = $catList[$i]['cname'];
        $x = str_replace(" ", "_", $x );
        $pubList[$i]['linkcat'] = $x;
        $pubList[$i]['cat'] = $catList[$i];
        $pubList[$i]['count'] = $t;
    }
}

for($i = 0; $i < count($catList); $i++)
{
    $list = $con->db->selectData("select count(*) as tot from clubs where status = 0 and category_id = '".$catList[$i]['id']."' and id in ( select club_id from cmembers where user_email = '$email' and status = 0 )");
    if($list != false && $list != array())
        $t = (int)$list[0]['tot'];
    else $err .= $con->db->err;
    if($t > 0)
    {
        $x = $catList[$i]['cname'];
        $x = str_replace(" ", "_", $x );
        $selfList[$i]['linkcat'] = $x;
        $selfList[$i]['cat'] = $catList[$i];
        $selfList[$i]['count'] = $t;
    }
}

$qvar = 'clu';
$sess_name = 'clubs';
$clubs = array();
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
        $j = 0;
        
        foreach($res as $a)
        {
            $clubs[$j] = $a;
            $ue = $clubs[$j]['email'];
            $clubs[$j]['pid'] = getPrifileId($ue, $con);
            $clubs[$j]['user_imgs_id'] = getProfImgId($ue, $con);
            
            $k = $con->db->selectData("select * from cmembers, users where club_id = ".$clubs[$j]['id']." and cmembers.admin_perm = 0 and status = 0 and user_email = email ");
            if($k != false && $k != array())
            {
                for($m =0; $m < count($k) ;$m++)
                {
                    if($k[$m]['user_email'] == $email)
                    {
                        $clubs[$j]['is_member'] = true;
                    }
                }
                $clubs[$j]['mem_count'] = count($k);
            }
            $k = $con->db->selectData("select cname from categorys where id = ".$clubs[$i]['category_id']."");
            if($k != false && $k != array())
            {
                $clubs[$i]['category'] = $k[0]['cname'];
            }
            
            $m = $con->db->selectData("select id, view_count, rating, tothits, neghits, ins_date, upd_date from contstats where media_id = ".$clubs[$i]['id']." and media_type = 'Club' and admin_perm = 0 ");
            if($m != false && $m != array())
            {
                $clubs[$i]['view_count'] = $m[0]['view_count'];
                $clubs[$i]['rating'] = $m[0]['rating'];
                $clubs[$i]['tothots'] = $m[0]['tothots'];
                $clubs[$i]['neghits'] = $m[0]['neghits'];
                $clubs[$i]['stat_ins_date'] = $m[0]['ins_date'];
                $clubs[$i]['stat_upd_date'] = $m[0]['upd_date'];
            }
            $i++;
            $j++;
        }
        $con->tp->assign('clubList', $clubs);
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
$con->tp->assign('topicHead', $topicHead);
$con->tp->assign('pubList', $pubList);
$con->tp->assign('selfList', $selfList);
$con->tp->assign('is_member', $is_member);
$con->tp->assign('bsubtitle', $bsubtitle);
$bbody = $con->tp->fetch('browse_clubs.tpl');


$v = setLoginInfo(trim($email), $con);

$con->tp->assign('islogin',$islogin);

$sideitem = getSideItems(trim($email), $con);

$blogexist = checkBlog($con, $email);

$con->tp->assign('btitle', $btitle);

$con->tp->assign('bbody', $bbody);

$con->tp->assign('sideitem', $sideitem);

$con->tp->assign('rep', $rep);

$con->tp->assign('err', $err);

$con->tp->assign('vad', $vad);

$con->tp->assign('had', $had);

addSiteStat($pageName, $con, '');

$con->tp->display('main.tpl');
?>