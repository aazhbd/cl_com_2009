<?php
require('config/project.php');
$con = new Project();

extract($_GET);
$pageName = 'Search Result: '.$token;

$rep = "";
$err = "";
$btitle = "";
$bbody = "";
$vad = "";
$had = "";
$sideitem = array();
$islogin = false;
$email = "";


function paginate_searchcont($id, $sess_name, $qsess_id, $pgtpl_id, $ctyp, $tplvar, $con, $start = '', $static_name = 'default')
{
    if(isset($_SESSION[$sess_name]))
    {    
        $_query = $_SESSION[$qsess_id];
        if($static_name == 'default' || $start != '')
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
                $em = $a['email'];
                $pid = getPrifileId($em,$con);
                $user_imgs_id = getProfImgId($em,$con);
                $content[$i]['pid'] = $pid;
                $content[$i]['user_imgs_id'] = $user_imgs_id;
                
                if($cont_type == "Article")
                {
                    $k = $con->db->selectData("select * from categorys where id = ".$a['category_id']." and media_type = 'Article'");
                    if($k != false && $k != array())
                    {
                        foreach($k as $n)
                        {
                            $cat = $n;
                        }
                        $content[$i]['category'] = $cat['cname'];
                    }
                }
                
                if($cont_type == "Audio")
                {
                    $k = $con->db->selectData("select * from categorys where id = ".$a['category_id']." and media_type = 'Audio'");
                    if($k != false && $k != array())
                    {
                        foreach($k as $n)
                        {
                            $cat = $n;
                        }
                        $content[$i]['category'] = $cat['cname'];
                    }
                }                    
                
                if($cont_type == "Video")
                {
                    $k = $con->db->selectData("select * from categorys where id = ".$a['category_id']." and media_type = 'Video'");
                    if($k != false && $k != array())
                    {
                        foreach($k as $n)
                        {
                            $cat = $n;
                        }
                        $content[$i]['category'] = $cat['cname'];
                    }
                }
                                    
                if($cont_type == "Club")
                {
                    $content[$i]['is_member'] = false;
                    $k = $con->db->selectData("select * from cmembers where club_id = ".$a['id']." and admin_perm = 0 and status = 0");
                    if($k != false && $k != array())
                    {
                        for($m = 0; $m < count($k) ;$m++)
                        {
                            if($a['user_email'] == $email)
                            {
                                $content[$i]['is_member'] = true;
                                break;
                            }
                        }
                        $content[$i]['mem_count'] = count($k);
                    }
                }
                if($cont_type == "Blog")
                {
                    $qe = "select * from blogs where id = ".$a['blog_id']."";
                    $k = $con->db->selectData($qe);
                    if($k != false && $k != array())
                    {
                        foreach($k as $t)
                        {
                            $content[$i]['url'] = $t['url'];
                            $content[$i]['blog_name'] = $t['cname'];
                            break;
                        }
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

if(isset($_SESSION['login'] ) == true)
{
    $l = $_SESSION['login'];
    $islogin = true;
    $email = $l->getEmail();
}

$token = trim($token);
switch($cat)
{
    case '1':
    $searchtype = "People";
    break;
    
    case '2':
    $searchtype = "Article";
    break;
    
    case '3':
    $searchtype = "Album";
    break;
    
    case '4':
    $searchtype = "Audio";
    break;
    
    case '5':
    $searchtype = "Video";
    break;
    
    case '6':
    $searchtype = "Blog";
    break;
    
    case '7':
    $searchtype = "Club";
    break;
    
    default:
}
$tpl = "search_res.tpl";
$btitle = "Search result for : " . $token; 
$title = "$token :: conveylive.com Search";

$desc = "$title. conveylive.com.com is a place to make friends and broadcast your creativity with the world. Publish your articles, audio, video, files, blogs, clubs and make it available to search engines, links and other sites as well as your friends. Browse the world through conveylive.com, expand your circle and get amazed with the large collection of other people's contents.";
$con->tp->assign("descrip", $desc);

$keys = "search, article, audio, video, photos, club, blog";
$con->tp->assign("keys", $keys);


$is_article = false;
$is_album = false;
$is_audio = false;
$is_video = false;
$is_blog = false;
$is_club = false;
$is_people = false;

switch($searchtype)
{
    case 'People':
    $qvar = 'ppl';
    $pgid = 'people';
    $dataVar = 'people';
    $tplvar = 'pag_ppl';
    $sess_name = 'people';
    $is_people = true;
    break;
    
    case 'Article':
    $qvar = 'art';
    $pgid = 'articles';
    $dataVar = 'articles';
    $tplvar = 'pag_art';
    $sess_name = 'article';
    $is_article = true;
    break;
    
    case 'Album':
    $qvar = 'alb';
    $pgid = 'albums';
    $dataVar = 'albums';
    $tplvar = 'pag_alb';
    $sess_name = 'album';
    $is_album = true;
    break;
    
    case 'Audio':
    $qvar = 'aud';
    $pgid = 'audios';
    $dataVar = 'audios';
    $tplvar = 'pag_aud';
    $sess_name = 'audio';
    $is_audio = true;
    break;
    
    case 'Video':
    $qvar = 'vid';
    $pgid = 'videos';
    $dataVar = 'videos';
    $tplvar = 'pag_vid';
    $sess_name = 'video';
    $is_video = true;
    break;
    
    case 'Blog':
    $qvar = 'bpost';
    $pgid = 'blogposts';
    $dataVar = 'blogposts';
    $tplvar = 'pag_post';
    $sess_name = 'blogpost';
    $is_blog = true;
    break;
    
    case 'Club':
    $qvar = 'clu';
    $pgid = 'clubs';
    $dataVar = 'clubs';
    $tplvar = 'pag_clu';
    $sess_name = 'club';
    $is_club = true;
    break;
}
paginate_searchcont($pgid, $sess_name, $qvar, $tplvar, $cont, $dataVar, $con, $start, $sess_name);

if(!$is_people)
{
    $qvar = 'ppl';
    $pgid = 'people';
    $dataVar = 'people';
    $tplvar = 'pag_ppl';
    $sess_name = 'people';    
    paginate_searchcont($pgid, $sess_name, $qvar, $tplvar, $cont, $dataVar, $con, '', 'people'); 
}
if(!$is_article)
{
    $qvar = 'art';
    $pgid = 'articles';
    $dataVar = 'articles';
    $tplvar = 'pag_art';
    $sess_name = 'article';
    paginate_searchcont($pgid, $sess_name, $qvar, $tplvar, $cont, $dataVar, $con, '', 'article'); 
}
if(!$is_album)
{
    $qvar = 'alb';
    $pgid = 'albums';
    $dataVar = 'albums';
    $tplvar = 'pag_alb';
    $sess_name = 'album';
    paginate_searchcont($pgid, $sess_name, $qvar, $tplvar, $cont, $dataVar, $con, '', 'album'); 
}
if(!$is_audio)
{
    $qvar = 'aud';
    $pgid = 'audios';
    $dataVar = 'audios';
    $tplvar = 'pag_aud';
    $sess_name = 'audio';
    paginate_searchcont($pgid, $sess_name, $qvar, $tplvar, $cont, $dataVar, $con, '', 'audio'); 
}
if(!$is_video)
{
    $qvar = 'vid';
    $pgid = 'videos';
    $dataVar = 'videos';
    $tplvar = 'pag_vid';
    $sess_name = 'video';
    paginate_searchcont($pgid, $sess_name, $qvar, $tplvar, $cont, $dataVar, $con, '', 'video'); 
}
if(!$is_blog)
{
    $qvar = 'bpost';
    $pgid = 'blogposts';
    $dataVar = 'blogposts';
    $tplvar = 'pag_post';
    $sess_name = 'blogpost';
    paginate_searchcont($pgid, $sess_name, $qvar, $tplvar, $cont, $dataVar, $con, '', 'blogpost'); 
}
if(!$is_club)
{
    $qvar = 'clu';
    $pgid = 'clubs';
    $dataVar = 'clubs';
    $tplvar = 'pag_clu';
    $sess_name = 'club';
    paginate_searchcont($pgid, $sess_name, $qvar, $tplvar, $cont, $dataVar, $con, '', 'club'); 
}
$tpl = 'search_res.tpl';
$con->tp->assign("token", $token);

$bbody = $con->tp->fetch($tpl);

$con->tp->assign('bbody', $bbody);
$con->tp->assign('btitle', $btitle);
$con->tp->assign('rep', $rep);
$con->tp->assign('err', $err);

addSiteStat($pageName, $con, $email);

if($islogin == true)
{
    $v = setLoginInfo($email, $con);
    $sideitem = getSideItems($email, $con);
}
$blogexist = checkBlog($con, $email);

$con->tp->assign('title', $title);
$con->tp->assign('sideitem', $sideitem);    
$con->tp->assign('vad', $vad);
$con->tp->assign('had', $had);
$con->tp->assign('islogin',$islogin);
$con->tp->display('main.tpl');

?>
