<?php
if(!isset($_POST['token'])){ echo "You can not access this page directly."; return; }

require('config/project.php');
$con = new Project();

$rep = "";
$err = "";
$btitle = "";
$bbody = "";
$islogin = false;
$email = "";

if(isset($_SESSION['login'] ) == true)
{
    $l = $_SESSION['login'];
    $islogin = true;
    $email = $l->getEmail();
}

function getSearchPageData($con, $email, $id,  $cont_type, $query, $q, $url)
{
    switch($cont_type)
    {
        case 'People':
        $perPage = 15;
        $pageLimit = 5;
        $found = false;
        $qvar = 'ppl';
        $pgid = 'people';
        $dataVar = 'people';
        $tplvar = 'pag_ppl';
        
        $sess_name = 'people';
        
        break;
        
        case 'Article':
        $perPage = 15;
        $pageLimit = 5;
        $found = false;
        $qvar = 'art';
        $pgid = 'articles';
        $dataVar = 'articles';
        $tplvar = 'pag_art';
        
        $sess_name = 'article';
        
        break;
        
        case 'Album':
        $perPage = 15;
        $pageLimit = 5;
        $found = false;
        $qvar = 'alb';
        $pgid = 'albums';
        $dataVar = 'albums';
        $tplvar = 'pag_alb';
        
        $sess_name = 'album';
        break;
        
        case 'Audio':
        $perPage = 15;
        $pageLimit = 5;
        $found = false;
        $qvar = 'aud';
        $pgid = 'audios';
        $dataVar = 'audios';
        $tplvar = 'pag_aud';
        
        $sess_name = 'audio';
        
        break;
        
        case 'Video':
        $perPage = 15;
        $pageLimit = 5;
        $found = false;
        $qvar = 'vid';
        $pgid = 'videos';
        $dataVar = 'videos';
        $tplvar = 'pag_vid';
        
        $sess_name = 'video';
        
        break;
        
        case 'Blog':
        $perPage = 15;
        $pageLimit = 5;
        $found = false;
        $qvar = 'bpost';
        $pgid = 'blogposts';
        $dataVar = 'blogposts';
        $tplvar = 'pag_post';
        
        $sess_name = 'blogpost';
        
        break;
        
        case 'Club':
        $perPage = 15;
        $pageLimit = 5;
        $found = false;
        $qvar = 'clu';
        $pgid = 'clubs';
        $dataVar = 'clubs';
        $tplvar = 'pag_clu';
        
        $sess_name = 'club';
        break;
    }
    

    SmartyPaginate::disconnect($pgid);
    unset($_SESSION[$sess_name]);
    SmartyPaginate::reset($pgid);

    $_SESSION[$qvar] = $q;
    
    if(!isset($_SESSION[$sess_name]))
    {
        SmartyPaginate::connect($pgid);
        if(SmartyPaginate::isConnected($pgid))
        {
            $found = init_pg_multi($query, $url, $perPage, $pageLimit, $email,  $con, $pgid, $sess_name);
        }
    }
    
    if($found)
    {
        if(isset($_SESSION[$sess_name]))
        {
            $currIndex = SmartyPaginate::getCurrentIndex($pgid);
            $limit = SmartyPaginate::getLimit($pgid);

            $l = sprintf(" LIMIT %d, %d", $currIndex, $limit);
            $query = $q.$l;

            $res = paginate_search($query, $con);
            $err .= $con->db->err;
            
            if(is_array($res) && $res!= false && $res != array() && count($res) > 0)
            {
                $i = 0;

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
                $con->tp->assign($dataVar,$content);
            }
            $err .= $con->db->err;
            
            SmartyPaginate::assign($con->tp, $tplvar, $pgid);

        }
        else
        {
            $err .= $con->db->err;
            $err .= "Session is not set. Content not found";
        }
    }
    else
    {
        $con->tp->assign('searchtype', "");
        //$rep = "Sorry, search returned 0 results.";
    }
        
    $ret_arr = array();
    $ret_arr['err'] = $err;
    $ret_arr['rep'] = $rep;
    
    return $ret_arr;
}


extract($_POST);

$pageName = 'Search Result: '.$token;

$btitle = "Search result for : " . $token; 
$title = "$token :: conveylive.com Search";

$desc = "$title. conveylive.com is a place to make friends and broadcast your creativity with the world. Publish your articles, audio, video, files, blogs, clubs and make it available to search engines, links and other sites as well as your friends. Browse the world through conveylive.com, expand your circle and get amazed with the large collection of other people's contents.";
$con->tp->assign("descrip", $desc);

$keys = "search, pages, audio, video, photos, club, blog";
$con->tp->assign("keys", $keys);


$found = false;
$token = trim($token);

if($token != "")
{
    for($i = 0; $i < 7; $i++ )
    {
        $category = $i + 1;
        
        switch($category)
        {
            case '1':
            $query = "select count(*) as tot from users, profiles where user_email = email and ( email = '$token' or f_name LIKE '%$token%' or l_name LIKE '%$token%' )";
            
            $_query = "SELECT email, f_name, l_name, user_imgs_id, id FROM users, profiles where email = user_email and (email = '$token' or f_name LIKE '%$token%' or l_name LIKE '%$token%' ) order by users.f_name "; 
            
            $url = URL ."/searchpage.php?cat=".$category."&token=$token";
            $tpl = "search_res.tpl";
            $searchtype = "People";
            break;
            
            case '2':
            $query = "select count(*) as tot from articles, users, contstats where articles.admin_perm = 0 and privacy = 0 and articles.art_typ = 1 and contstats.media_id = articles.id and contstats.media_type = 'Article' and contstats.user_email = articles.user_email and contstats.user_email = users.email and
                     
                     ( category_id in ( select id from categorys where cname LIKE '%$token%' and media_type = 'Article') or 
                     
                     f_name LIKE '%$token%' or l_name LIKE '%$token%' or email = '$token' or title LIKE '%$token%' 
                     
                     or sub_title LIKE '%$token%' or body LIKE '%$token%') and email = articles.user_email";
            ;
            $_query = "select articles.id as id, articles.url as url, email, articles.user_email as user_email, title, sub_title, articles.ins_date as ins_date, f_name, l_name, category_id, rating, tothits, view_count 
                        from articles, users , contstats
                        where articles.admin_perm = 0 and privacy = 0 and articles.art_typ = 1 and contstats.media_id = articles.id and contstats.media_type = 'Article' and contstats.user_email = articles.user_email and contstats.user_email = users.email and
                        
                        ( category_id in ( select id from categorys where cname LIKE '%$token%' and media_type = 'Article') or f_name LIKE '%$token%' or l_name LIKE '%$token%' 
                        or email = '$token' or title LIKE '%$token%' or sub_title LIKE '%$token%' or body LIKE '%$token%') and email = articles.user_email order by 
                        articles.ins_date desc ";
            
            $url = URL ."/searchpage.php?cat=".$category."&token=$token";
            $tpl = "search_res.tpl";
            $searchtype = "Article";
            break;
            
            case '3':
            $query = "select count(*) as tot from albums, users where albums.admin_perm = 0 and privacy = 0 and (album_name LIKE '%$token%' or 
                     f_name LIKE '%$token%' or l_name LIKE '%$token%' or email = '$token') and email = albums.user_email";

            $_query = "select id,  email, user_email, albums.ins_date as ins_date, f_name, l_name, album_name, remarks, image_id
                        from albums, users
                        where albums.admin_perm = 0 and privacy = 0 and
                        
                        ( album_name LIKE '%$token%' or f_name LIKE '%$token%' or l_name LIKE '%$token%' 
                        or email = '$token' ) and email = albums.user_email order by 
                        albums.ins_date desc ";
            
            $url = URL ."/searchpage.php?cat=".$category."&token=$token";
            $tpl = "search_res.tpl";
            $searchtype = "Album";
            break;
            
            case '4':
            $query = "select count(*) as tot from audios, users, contstats where audios.admin_perm = 0 and privacy = 0 and contstats.media_id = audios.id and contstats.media_type = 'Audio' and contstats.user_email = audios.user_email and contstats.user_email = users.email and
                        
                        ( category_id in ( select id from categorys where cname LIKE '%$token%' and media_type = 'Audio')or f_name LIKE '%$token%' or l_name LIKE '%$token%' or email = '$token' or title LIKE '%$token%' or artist LIKE '%$token%' 
                        or additional LIKE '%$token%' or filename LIKE '%$token%' or meta_tags LIKE '%$token%') 
                        
                        and email = audios.user_email ";
                         
            $_query = "select audios.id as id, email, audios.user_email as user_email, title, category_id in ( select id from categorys where cname LIKE '%$token%') , audios.ins_date as ins_date, category_id, f_name, l_name, rating, tothits, view_count
                        from audios, users, contstats where audios.admin_perm = 0 and privacy = 0 and contstats.media_id = audios.id and contstats.media_type = 'Audio' and contstats.user_email = audios.user_email and contstats.user_email = users.email and
                        
                        ( category_id in ( select id from categorys where cname LIKE '%$token%' and media_type = 'Audio') or f_name LIKE '%$token%' or l_name LIKE '%$token%' or email = '$token' or title LIKE '%$token%' or artist LIKE '%$token%' 
                        or additional LIKE '%$token%' or filename LIKE '%$token%' or meta_tags LIKE '%$token%') 
                        
                        and email = audios.user_email order by audios.ins_date desc";
            $url = URL ."/searchpage.php?cat=".$category."&token=$token";
            $tpl = "search_res.tpl";
            $searchtype = "Audio";
            break;
            
            case '5':
            $query = "select count(*) as tot from videos, users, contstats where videos.admin_perm = 0 and privacy = 0 and contstats.media_id = videos.id and contstats.media_type = 'Video' and contstats.user_email = videos.user_email and contstats.user_email = users.email and
                        
                        ( category_id in ( select id from categorys where cname LIKE '%$token%' and media_type = 'Video') or f_name LIKE '%$token%' or l_name LIKE '%$token%' or email = '$token' or title LIKE '%$token%' or artist LIKE '%$token%' 
                        or additional LIKE '%$token%' or filename LIKE '%$token%' or meta_tags LIKE '%$token%') 
                        
                        and email = videos.user_email ";
                                     
            $_query = "select videos.id as id, email, videos.user_email as user_email, title, category_id, videos.ins_date, f_name, l_name, meta_tags, additional, img_id , category_id, rating, tothits, view_count
                        from videos, users, contstats where videos.admin_perm = 0 and privacy = 0 and contstats.media_id = videos.id and contstats.media_type = 'Video' and contstats.user_email = videos.user_email and contstats.user_email = users.email and
                        
                        ( category_id in ( select id from categorys where cname LIKE '%$token%' and media_type = 'Video') or f_name LIKE '%$token%' or l_name LIKE '%$token%' or email = '$token' or title LIKE '%$token%' or artist LIKE '%$token%' 
                        or additional LIKE '%$token%' or filename LIKE '%$token%' or meta_tags LIKE '%$token%')
                        
                        and email = videos.user_email  order by videos.ins_date desc";
            
            $url = URL ."/searchpage.php?cat=".$category."&token=$token";
            $tpl = "search_res.tpl";
            $searchtype = "Video";
            break;
            
            case '6':
            $query = "select count(*) as tot from users, bposts, articles where bposts.admin_perm = 0  and articles.admin_perm = 0 
                        
                        and users.email = bposts.user_email and articles.user_email = bposts.user_email and articles.user_email = users.email and article_id = articles.id and art_typ = 2 and
                        
                        ( f_name LIKE '%$token%' or l_name LIKE '%$token%' or email = '$token' or  title LIKE '%$token%' or sub_title LIKE '%$token%'  or  body LIKE '%$token%' or  remarks LIKE '%$token%' or  meta_tags LIKE '%$token%' )
                        
                        and email = bposts.user_email order by bposts.ins_date desc";

            $_query = "select email,  f_name, l_name, bposts.user_email as user_email, blog_id, article_id, bposts.ins_date as ins_date, articles.id as art_id, bposts.id as post_id, art_typ, title, sub_title, bposts.ins_date as ins_date
                        
                        from users, bposts, articles where bposts.admin_perm = 0  and articles.admin_perm = 0
                        
                        and users.email = bposts.user_email and articles.user_email = bposts.user_email and articles.user_email = users.email and article_id = articles.id and art_typ = 2 and
                        
                        ( f_name LIKE '%$token%' or l_name LIKE '%$token%' or email = '$token' or  title LIKE '%$token%' or sub_title LIKE '%$token%'  or  body LIKE '%$token%' or  remarks LIKE '%$token%' or  meta_tags LIKE '%$token%' )
                        
                        and email = bposts.user_email order by bposts.ins_date desc";
            
            $url = URL ."/searchpage.php?cat=".$category."&token=$token";
            $tpl = "search_res.tpl";
            $searchtype = "Blog";
            break;
            
            case '7':
            $query = "select count(*) as tot from clubs, users where clubs.admin_perm = 0 and  status = 0 and
                        
                        ( f_name LIKE '%$token%' or l_name LIKE '%$token%' or email = '$token' or  name LIKE '%$token%' or description LIKE '%$token%' 
                        or category_id in ( select id from categorys where cname LIKE '%$token%' and media_type = 'Club') ) 
                        
                        and email = user_email ";
                        
            $_query = "select image_id, privacy, email, f_name, l_name, user_email, id, cname, category_id, clubs.ins_date from clubs, users where clubs.admin_perm = 0 and  status = 0 and
                        
                        ( f_name LIKE '%$token%' or l_name LIKE '%$token%' or email = '$token' or  name LIKE '%$token%' or description LIKE '%$token%' 
                        or category_id in ( select id from categorys where cname LIKE '%$token%' and media_type = 'Club') ) 
                        
                        and email = user_email order by clubs.ins_date desc";
            
            $url = URL ."/searchpage.php?cat=".$category."&token=$token";
            $tpl = "search_res.tpl";
            $searchtype = "Club";
            break;
            
            default:
        }
        
        $arr = getSearchPageData($con, $email, $id,  $searchtype, $query, $_query, $url);
        $err .= $arr['err'];
        $rep .= $arr['rep'];
    }
    $con->tp->assign('token', $token);
    $bbody = $con->tp->fetch($tpl);
}
else
{
    $con->tp->assign('searchtype', "");
    $rep = "Sorry, search returned 0 results.";
}

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
$con->tp->assign('islogin',$islogin);
$con->tp->display('main.tpl');
?>