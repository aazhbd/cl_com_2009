<?php
require('config/project.php');
$con = new Project();

extract($_GET);
$pageName = "Home";
$rep = "";
$err = "";
$btitle = "";
$bbody = "";
$vad = "";
$had = "";
$sideitem = array();
$islogin = false;
$email = "";
$title = "ConveyLive :: Home";
$con->tp->assign('title', $title);

$desc = "ConveyLive.com is a place to make friends and broadcast your creativity with the world. Publish your articles, audio, video, files, blogs, clubs and make it available to search engines, links and other sites as well as your friends. Browse the world through conveylive.com, expand your circle and get amazed with the large collection of other people's contents.";
$con->tp->assign("descrip", $desc);

$keys = "article, audio, video, photos, club, blog";
$con->tp->assign("keys", $keys);


if(isset($_SESSION['login'] ) == true)
{
    $l = $_SESSION['login'];
    $islogin = true;
    $email = $l->getEmail();
}
$con->tp->assign('islogin',$islogin);

function paginate_cont($id, $sess_name, $qsess_id, $pgtpl_id, $ctyp, $tplvar, $con, $start = '', $static_name = 'default')
{
    if(isset($_SESSION[$sess_name]))
    {    
        $_query = $_SESSION[$qsess_id];
        if($static_name == 'default' && $start != '')
        {
            SmartyPaginate::setCurrentItem($start,$id);
        }
        
        $currIndex = SmartyPaginate::getCurrentIndex($id);
        $limit = SmartyPaginate::getLimit($id);
        $l = sprintf(" LIMIT %d, %d", $currIndex, $limit);
        $query = $_query.$l;
        
        $res = paginate_search($query, $con);
        
        if(is_array($res) && $res!= false && $res != array() && count($res) > 0)
        {
            foreach($res as $a)
            {
                $content[$i] = $a;
                if(isset($a['blog_id']))
                {
                    $r = $con->db->selectData("select * from blogs where id = ".$a['blog_id']."");
                    if($r == false || $r == array() || count($r) == 0) $err .= $con->db->err;
                    else
                    {
                        $content[$i]['blog_url'] = $r[0]['url'];
                    }
                }
                $i++;
            }
            $con->tp->assign($tplvar, $content);
            SmartyPaginate::assign($con->tp, $pgtpl_id, $id);
        }
        else
        {
            $err .= $con->db->err;
        }
    }
    return $err;
}

$uemail = getEmail($pid,$con);

//Module: Club Join Request List Populate
$r = $con->db->selectData("select * from cmembers where user_email = '$email' and admin_perm = 0 and status = 1 and club_id in (select id from clubs where status = 0 and admin_perm = 0 and privacy = 2)");
if($r == false || $r == array()) {$err .= $con->db->err; }
else
{
    $i = 0;
    $c = count($r);
    foreach($r as $a)
    {
        $join_req[$i] = $a;
        $join_req[$i]['by'] = getUserName($join_req[$i]['inviter_email'], $con);
        $join_req[$i]['by_pid'] = getPrifileId($join_req[$i]['inviter_email'], $con);
        $join_req[$i]['by_img_id'] = getProfImgId($join_req[$i]['inviter_email'], $con);
       
        $s = $con->db->selectData("select * from clubs where id = ".$join_req[$i]['club_id']."");
        if($s == false || $s == array()) {$err .= $con->db->err;}
        else
        {
            foreach($s as $t)
            {
                $club = $a;
            }
        }
        $join_req[$i]['club_name'] = $club['name'];
        $join_req[$i]['club_id'] = $club['id'];
        $join_req[$i]['club_img_id'] = $club['club_img_id'];
        $i++;
    }
    $joinreq_count = $c;
    $con->tp->assign('joinreq_count', $joinreq_count);
}
//Module: Friend Request List Populate
$req = array();
$r = $con->db->selectData("select count(*) as tot from users, profiles, friends where users.email = profiles.user_email and users.email = friends.req_from and friends.req_to = '$email' and req_pending = 1 and blocked = 0 and friends.admin_perm = 0");
if($r == false || $r == array()) {$err .= $con->db->err; $req['count'] = 0;}
else
{
   $req_count = $r[0]['tot'];
}

$con->tp->assign('email', $email);
$con->tp->assign('req_list', $req);
$con->tp->assign('req_count', $req_count);

//Mail Notification 
$r = $con->db->selectData("select count(*) as tot from messages where rcvr_email = '$email' and read_stat = 1 and messages.admin_perm = 0");
if($r == false || $r == array()) {$err .= $con->db->err; }
else
{
    $i = 0;
    $c = count($r);
    foreach($r as $a)
    {
        $tot = $a['tot'];
    }
    $mail_count = $tot;
    $con->tp->assign('mail_count', $mail_count);
}
//Mail Notification End

$init_invite .= invite($con, $_POST);
$con->tp->assign('init_invite', $init_invite);

$pid = getPrifileId($email, $con);

$r = $con->db->selectData("select * from profiles, users where user_email = '$email' and email = user_email");
if($r == false || $r == array()) {$err .= $con->db->err; $prof = null;}
else
{
    foreach($r as $a)
    {
        $prof = $a;
    }
}

if($prof == null)
{
    $bsubtitle = "Please Create your Profile if you want people to find you in search results and communicate with you. No one will be able to contact you if you dont create your profile.";
    
    $con->tp->assign('bsubtitle', $bsubtitle);
}
    
$con->tp->assign('prof', $prof);    

$is_article = false;
$is_album = false;
$is_audio = false;
$is_video = false;
$is_blog = false;
$is_club = false;

switch($cont)
{
    case 'Status':
    $qvar = 'sta';
    $pgid = 'status';
    $dataVar = 'statuses';
    $tplvar = 'pag_stat';
    $sess_name = 'status';
    $is_status = true;
    break;
    
    case 'Articles':
    $qvar = 'art';
    $pgid = 'articles';
    $dataVar = 'articles';
    $tplvar = 'pag_art';
    $sess_name = 'article';
    $is_article = true;
    break;
    
    case 'Albums':
    $qvar = 'alb';
    $pgid = 'albums';
    $dataVar = 'albums';
    $tplvar = 'pag_alb';
    $sess_name = 'album';
    $is_album = true;
    break;
    
    case 'Audios':
    $qvar = 'aud';
    $pgid = 'audios';
    $dataVar = 'audios';
    $tplvar = 'pag_aud';
    $sess_name = 'audio';
    $is_audio = true;
    break;
    
    case 'Videos':
    $qvar = 'vid';
    $pgid = 'videos';
    $dataVar = 'videos';
    $tplvar = 'pag_vid';
    $sess_name = 'video';
    $is_video = true;
    break;
    
    case 'Blogs':
    $qvar = 'bpost';
    $pgid = 'blogposts';
    $dataVar = 'blogposts';
    $tplvar = 'pag_post';
    $sess_name = 'blogpost';
    $is_blog = true;
    break;
    
    case 'Clubs':
    $qvar = 'clu';
    $pgid = 'clubs';
    $dataVar = 'clubs';
    $tplvar = 'pag_clu';
    $sess_name = 'club';
    $is_club = true;
    break;
}
paginate_cont($pgid, $sess_name, $qvar, $tplvar, $cont, $dataVar, $con, $start);
if(!$is_status)
{
    $qvar = 'sta';
    $pgid = 'status';
    $dataVar = 'statuses';
    $tplvar = 'pag_stat';
    $sess_name = 'status';
    paginate_cont($pgid, $sess_name, $qvar, $tplvar, $cont, $dataVar, $con, '', 'status'); 
}
if(!$is_article)
{
    $qvar = 'art';
    $pgid = 'articles';
    $dataVar = 'articles';
    $tplvar = 'pag_art';
    $sess_name = 'article';
    paginate_cont($pgid, $sess_name, $qvar, $tplvar, $cont, $dataVar, $con, '', 'article'); 
}
if(!$is_album)
{
    $qvar = 'alb';
    $pgid = 'albums';
    $dataVar = 'albums';
    $tplvar = 'pag_alb';
    $sess_name = 'album';
    paginate_cont($pgid, $sess_name, $qvar, $tplvar, $cont, $dataVar, $con, '', 'album'); 
}
if(!$is_audio)
{
    $qvar = 'aud';
    $pgid = 'audios';
    $dataVar = 'audios';
    $tplvar = 'pag_aud';
    $sess_name = 'audio';
    paginate_cont($pgid, $sess_name, $qvar, $tplvar, $cont, $dataVar, $con, '', 'audio'); 
}
if(!$is_video)
{
    $qvar = 'vid';
    $pgid = 'videos';
    $dataVar = 'videos';
    $tplvar = 'pag_vid';
    $sess_name = 'video';
    paginate_cont($pgid, $sess_name, $qvar, $tplvar, $cont, $dataVar, $con, '', 'video'); 
}
if(!$is_blog)
{
    $qvar = 'bpost';
    $pgid = 'blogposts';
    $dataVar = 'blogposts';
    $tplvar = 'pag_post';
    $sess_name = 'blogpost';
    paginate_cont($pgid, $sess_name, $qvar, $tplvar, $cont, $dataVar, $con, '', 'blogpost'); 
}
if(!$is_club)
{
    $qvar = 'clu';
    $pgid = 'clubs';
    $dataVar = 'clubs';
    $tplvar = 'pag_clu';
    $sess_name = 'club';
    paginate_cont($pgid, $sess_name, $qvar, $tplvar, $cont, $dataVar, $con, '', 'club'); 
}


$con->tp->assign('email', $email);

$id = getPrifileId($email,$con);
$coms = getComList($id, 'Profile', $con);
if(is_string($coms)) $err .= $coms;
if(is_array($coms))
{
    $com_count = count($coms);
}

$con->tp->assign('coms', $coms);
$bbody = $con->tp->fetch('home_view.tpl');

$btitle = getUserName($email, $con) . "'s Home";    
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
$con->tp->assign('sideitem', $sideitem);    
$con->tp->assign('vad', $vad);
$con->tp->assign('had', $had);
$con->tp->assign('title', $title);
$con->tp->display('main.tpl');
?>