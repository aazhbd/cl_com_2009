<?php
require('config/project.php');
$con = new Project();

extract($_GET);
$pageName = "Profile";
$rep = "";
$err = "";
$btitle = "";
$bbody = "";
$vad = "";
$had = "";
$sideitem = array();
$islogin = false;
$email = "";



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
                $content[] = $a;
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
$prof = $con->db->selectData("select * from users, profiles where email = user_email and email = '$uemail' and active = 0 and profiles.admin_perm = 0 ");
    
if($prof == false || $prof == array() ) $err .= $con->db->err;
else
{
    $con->tp->assign('prof', $prof[0]);
    
    $btitle = $prof[0]['f_name']."'s Profile";
    
    $title = "ConveyLive :: ".$prof[0]['f_name'] ."". $prof[0]['l_name'];
    
    $countryList = getCountryList();
    $relStatusList = getRelStatusList();
    
    $con->tp->assign('user_email', $uemail);
    $con->tp->assign('email', $uemail);
    
    $con->tp->assign('countryList', $countryList);
    $con->tp->assign('relStatusList', $relStatusList);
    
    $title = $prof[0]['f_name'] ." ". $prof[0]['l_name']." :: ConveyLive";
    $con->tp->assign('title', $title);
    
    $desc = "Profile of ".$prof[0]['f_name'] ." ". $prof[0]['l_name']. ". conveylive.com is a place to make friends and broadcast your creativity with the world. Publish your articles, audio, video, files, blogs, clubs and make it available to search engines, links and other sites as well as your friends. Browse the world through conveylive.com, expand your circle and get amazed with the large collection of other people's contents.";
    $con->tp->assign("descrip", $desc);
    
    $keys = "Profile,". $prof[0]['f_name'] ." ,". $prof[0]['l_name'].", people, community";
    $con->tp->assign("keys", $keys);

    $is_article = false;
    $is_album = false;
    $is_audio = false;
    $is_video = false;
    $is_blog = false;
    $is_club = false;
    
    switch($cont)
    {
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
    
    $blog = null;
    $r = $con->db->selectData("select * from blogs where blogs.user_email = '$uemail'");
    if($r == false || count($r) == 0 || $r == array()) $err .= $con->db->err;
    else
    {
        foreach($r as $a)
        {
            $blog = $a;
        }
    }
    $con->tp->assign('blog',$blog);

    $con->tp->assign('email', $email);
    
    $id = getPrifileId($uemail,$con);
    $coms = getComList($id, 'Profile', $con);
    if(is_string($coms)) $err .= $coms;
    if(is_array($coms))
    {
        $com_count = count($coms);
    }
    
    $uemail = getEmail($id, $con);
        
        
    $q = "select count(friends.id) as tot from users, profiles, friends where (req_to='$uemail' or req_from='$uemail') and email != '$uemail'and  req_pending = 0 and blocked = 0 and friends.admin_perm = 0 and (req_to = email || req_from = email)  and profiles.user_email = email";
    
    $t = $con->db->selectData($q);
    if($t == false || $t == array() || $t == null){ $err .= $con->db->err; }
    else
    {
        $tot = $t[0]['tot'];
    }
    
    $q = "select f_name, l_name, email as user_email, profiles.id as pid, user_imgs_id, friends.id as fid from users, profiles, friends where (req_to='$uemail' or req_from='$uemail') and email != '$uemail'and  req_pending = 0 and blocked = 0 and friends.admin_perm = 0 and (req_to = email || req_from = email)  and profiles.user_email = email limit 0, 12";
    
    $t = $con->db->selectData($q);
    
    if($t == false || $t == array() || $t == null)
    {
        $err .= $con->db->err;
    }
    else
    {
        foreach($t as $a)
        {
            $friends[] = $a;
        }
    }
    $con->tp->assign('tot', $tot);
    $con->tp->assign('friends', $friends);
    
    
    $r = $con->db->selectData("select * from albums where user_email = '$uemail' and admin_perm = 0 order by albums.ins_date desc");
    if($r != false and $r != array())
    {
        foreach($r as $a)
        {
            $albumList[] = $a;
        }
    }
    $al = array();
    
    for($i=0, $j=0; $i < count($albumList); $i++)
    {
        $query = "select count(*) as tot from images where user_email = '$uemail' and admin_perm = 0 and stat = 0 and album_id = ".$albumList[$i]['id']."";
        $r = $con->db->selectData($query);
        //print_r($r);
        //echo $query;
        if($r != false && $r != array())
        {
            $albumList[$i]['tot'] = $r[0]['tot']; 
        }
        $err .= $con->db->err;
    }
    $con->tp->assign('albumsList', $albumList);
    
    $con->tp->assign('coms', $coms);
    $bbody = $con->tp->fetch('prof_view.tpl');
}
    
$con->tp->assign('bsubtitle', $bsubtitle);
$con->tp->assign('bbody', $bbody);
$con->tp->assign('btitle', $btitle);
$con->tp->assign('rep', $rep);
$con->tp->assign('err', $err);

$con->tp->assign('title', $title);

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