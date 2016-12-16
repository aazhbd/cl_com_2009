<?php
function article($con, $email, $section,  $id = '', $tmp_id = '')
{
    $rep = "";
    $err = "";
    $btitle = "";
    $bbody = "";
    $bsubtitle = "";
    $skip = false;
    
    switch($section)
    {
        case 'ratedown':
            $media_type = "Article";
            
            $media_id = $id;
            
            $upd = rateChange($con, $media_type, $media_id, 'down');

            if($upd != false  )
            {
                $rep = "Page rating updated";
            }
            $err .= $con->db->err;
            
            $retList = view_article($con, $email, $id);
            
            $bbody .= $retList['bbody'];
            $btitle .= $retList['btitle'];
            $bsubtitle .= $retList['bsubtitle'];
            $rep .= $retList['rep'];
            $err .= $retList['err'];
        break;
        
        case 'rateup':
            $media_type = "Article";
            
            $media_id = $id;
            
            $upd = rateChange($con, $media_type, $media_id, 'up');

            if($upd != false  )
            {
                $rep = "Page rating updated";
            }
            $err .= $con->db->err;
            
            $retList = view_article($con, $email, $id);
            
            $bbody .= $retList['bbody'];
            $btitle .= $retList['btitle'];
            $bsubtitle .= $retList['bsubtitle'];
            $rep .= $retList['rep'];
            $err .= $retList['err'];
        break;
        
        case 'delete':
        
            $r = $con->db->executeNonQuery("update articles set admin_perm = 1 where id = $id and user_email = '$email'");

            if($r != false  )
            {
                $isDel = deleteCom($id, "Article", $con);
                if($isDel)
                {
                    $rep = "Article has been deleted.";
                }
                else
                {
                    $rep = "Page has been deleted. But not Comments";
                }
            }
            else
            {
                $err = "You can not delete this Page. ";
            }
            $err .= $con->db->err;
            
            $retList = browse_articles($con, $email, $id);
            
            $bbody .= $retList['bbody'];
            $btitle .= $retList['btitle'];
            $bsubtitle .= $retList['bsubtitle'];
            $rep .= $retList['rep'];
            $err .= $retList['err'];
        break;
        
        case 'edit':
            //setFckCookie($email);
            
            $desc = "Publish your new writeups in custom format and edit them anytime. Browse articles and writeups in conveylive and share your views. Get Amazed by the Huge collection of articles in conveylive";
            $con->tp->assign("descrip", $desc);
            
            $keys = "Page, Articles, Writeups, communicate, share,network,  conveylive";
            $con->tp->assign("keys", $keys);
            
            if($id == "current" )
            {
                if(isset($_SESSION['article']))
                {
                    $ac = $_SESSION['article']['action'];
                    if($ac == "add")
                    {
                        $action = "add";
                    }
                    else
                    {
                        $action = "edit";
                    }
                }
            }
            else
            {
                $action = "edit";
                unset($_SESSION['article']);
            }
            $art = array();
            $btitle = "Edit Page";
            $bsubtitle = "Edit your published writeups";
            
            $catList = getCatList();
            
            if(isset($_SESSION['article']))
            {
                $art['id'] = $_SESSION['article']['id'];
                $art['title'] = $_SESSION['article']['arttitle'];
                $art['sub_title'] = $_SESSION['article']['subtitle'];
                $art['category_id'] = $_SESSION['article']['cat'];
                $art['url'] = $_SESSION['article']['arturl'];
                $art['remarks'] = $_SESSION['article']['remarks'];
                $art['meta_tags'] = $_SESSION['article']['keywords'];
                $art['body'] = $_SESSION['article']['bodytxt'];
                $con->tp->assign('art', $art);
            }
            else
            {
                $q = "select * from articles where id = $id and admin_perm = 0 and user_email = '$email'";
                $r = $con->db->selectData($q);
                
                if($r == false || $r == array() || count($r) <= 0) $err = $con->db->err;
                else{
                    $i =0;
                    foreach($r as $a)
                    {
                        $art = $a;
                        $body = $art['body'];
                        $body = stripcslashes($body);
                        $body = html_entity_decode($body);
                        $art['body'] = $body;
                        
                        $title = $art['title'];
                        $subtitle = $art['sub_title'];
                        $remarks = $art['remarks'];
                        $keywords = $art['meta_tags'];
                        
                        $art['title'] = stripslashes($title);
                        $art['sub_title'] = stripslashes($subtitle);
                        $art['remarks'] = stripslashes($remarks);
                        $art['meta_tags'] = stripslashes($keywords);
                        $i++;
                    }
                }
                
                $con->tp->assign('art', $art);
            }
            $catList = getCatListDb($con, 'Article');
            $con->tp->assign('email', $email);
            
            $fckEditor = loadFckEditMode($con, $art['body']); 
            
            $con->tp->assign('fckEditor', $fckEditor);
            
            $coneditor_js = "subtpl/coneditor_js.tpl";
            $con->tp->assign('bsubtitle', $bsubtitle);
            $con->tp->assign('coneditor_js', $coneditor_js);
            $con->tp->assign('catList', $catList);
            $con->tp->assign('action', $action);
            $bbody = $con->tp->fetch('article_form.tpl');
            
            $title = "conveylive.com :: Edit Page";
            $con->tp->assign('title', $title);
        break;
        
        case 'view':
            $retList = view_article($con, $email, $id);
            
            $bbody = $retList['bbody'];
            $btitle = $retList['btitle'];
            $bsubtitle = $retList['bsubtitle'];
            $rep = $retList['rep'];
            $err = $retList['err'];
            break;
        
        case 'new':
            unset($_SESSION['article']);
            $action = "add";
            $btitle = "New Page";
            $bsubtitle = "Publish your new writeups in custom format";
            
            $desc = "Publish your new writeups in custom format. Publish articles and writeups in conveylive and share your views. Get Amazed by the Huge collection of articles in conveylive";
            $con->tp->assign("descrip", $desc);
            
            $keys = "Articles, Writeups, communicate, share,network,  conveylive";
            $con->tp->assign("keys", $keys);
            
            
            $con->tp->assign('email', $email);
            
            $catList = getCatListDb($con, 'Article');
            
            $coneditor_js = "subtpl/coneditor_js.tpl";
            $con->tp->assign('bsubtitle', $bsubtitle);
            $con->tp->assign('coneditor_js', $coneditor_js);
            $con->tp->assign('catList', $catList);
            $con->tp->assign('action', $action);
            $bbody = $con->tp->fetch('article_form.tpl');
            
            $title = "conveylive :: New Article";
            $con->tp->assign('title', $title);
        break;

        case 'browsetoprated':
            $btitle = "Browse Top Rated Pages";
            $bsubtitle = "All Pages are in order they were rated highest by the people";
            
            $title = "conveylive.com :: Browse Most Viewed Pages";
            $con->tp->assign('title', $title);
            
            $topicHead = "Top Rated Pages";
            $con->tp->assign('topicHead', $topicHead);
            
            $keys = "Pages, Articles, Writeups, communicate, share,network,  conveylive";
            $con->tp->assign("keys", $keys);
            
            $desc = "Browse Pages in conveylive.com. Publish , page, articles and writeups and share your views. Get Amazed by the Huge collection of articles in conveylive";
            $con->tp->assign("descrip", $desc);
            
            $con->tp->assign('email', $email);
            
            $contType = "Article";
            $sortType = "TopRated";
            
            $retList = getContList($con, $email, $contType, $sortType);
            
            $bbody = $retList['bbody'];
            $btitle .= $retList['btitle'];
            $bsubtitle .= $retList['bsubtitle'];
            $rep .= $retList['rep'];
            $err .= $retList['err'];
        break;
        
        case 'browsemostviewed':
            $btitle = "Browse Most Viewed Pages";
            $bsubtitle = "All Pages are in order they were viewed most number of times";
            
            $title = "conveylive.com :: Browse Most Viewed Pages";
            $con->tp->assign('title', $title);
            
            $topicHead = "Most Viewed Pages";
            $con->tp->assign('topicHead', $topicHead);
            
            $keys = "Pages, Articles, Writeups, communicate, share,network,  conveylive";
            $con->tp->assign("keys", $keys);
            
            $desc = "Browse Pages in conveylive.com. Publish , page, articles and writeups and share your views. Get Amazed by the Huge collection of articles in conveylive";
            $con->tp->assign("descrip", $desc);
            
            $con->tp->assign('email', $email);
            
            $contType = "Article";
            $sortType = "MostViewed";
            
            $retList = getContList($con, $email, $contType, $sortType);
            
            $bbody = $retList['bbody'];
            $btitle .= $retList['btitle'];
            $bsubtitle .= $retList['bsubtitle'];
            $rep .= $retList['rep'];
            $err .= $retList['err'];
        break;

        case 'browselatest':
            $btitle = "Browse Latest Pages";
            $bsubtitle = "All Pages are in order that are recently published";
            
            $title = "conveylive.com :: Browse Latest Pages";
            $con->tp->assign('title', $title);
            
            $topicHead = "Latest pages";
            $con->tp->assign('topicHead', $topicHead);
            
            $keys = "Pages, Articles, Writeups, communicate, share,network,  conveylive";
            $con->tp->assign("keys", $keys);
            
            $desc = "Browse Pages in conveylive.com. Publish , page, articles and writeups and share your views. Get Amazed by the Huge collection of articles in conveylive";
            $con->tp->assign("descrip", $desc);
            
            $con->tp->assign('email', $email);
            
            $contType = "Article";
            $sortType = "Latest";
            
            $retList = getContList($con, $email, $contType, $sortType);
            
            $bbody = $retList['bbody'];
            $btitle .= $retList['btitle'];
            $bsubtitle .= $retList['bsubtitle'];
            $rep .= $retList['rep'];
            $err .= $retList['err'];
        break;        
        
        case 'categorybrowse':
            $btitle = "Browse Pages";
            $bsubtitle = "Browse latest Pages";
            $con->tp->assign('email', $email);
            
            $sId = str_replace("_"," ", $id);
            $catList = getCatListDb($con, "Article");
            
            $selCatName = "";
            foreach($catList as $cat)
            {
                if(trim($cat['cname']) == trim($sId) )
                {
                    $selCatName = $cat['cname'];
                    $selCatId = $cat['id'];
                    break;
                }
            }

            if($selCatName == "")
            {
                 $err = "Sorry, this topic do not exist";
                 $selCat = "No Results Found";
                 $article = null;
            }
            else
            {
                if($tmp_id == 'self')
                {
                    $extraParam = " and category_id = $selCatId and user_email = '$email' and user_email != '' ";
                    $retList = browse_articles($con, $email, $id, $extraParam, $selCatName, true);
                }
                else
                {
                    $retList = browse_articles($con, $email, $id, " and category_id = $selCatId ", $selCatName);
                }
                //print_r($retList);
                $bbody = $retList['bbody'];
                $btitle = $retList['btitle'];
                $bsubtitle = $retList['bsubtitle'];
                $rep .= $retList['rep'];
                $err .= $retList['err'];
                
                $con->tp->assign('topicHead', $selCatName);
            }
        break;
        
        case 'browse':
            $retList = browse_articles($con, $email, $id);
            
            $bbody = $retList['bbody'];
            $btitle = $retList['btitle'];
            $bsubtitle = $retList['bsubtitle'];
            $rep = $retList['rep'];
            $err = $retList['err'];
        
        break;
    }
    
    if($skip == false)
    {
        $con->tp->assign('bbody', $bbody);
        $con->tp->assign('btitle', $btitle);
        $con->tp->assign('bsubtitle', $bsubtitle);
    }
    $con->tp->assign('rep', $rep);
    $con->tp->assign('err', $err);
}

function browse_articles($con, $email, $id, $extraParam = '', $cat = '', $isSelf = false)
{
    $btitle = "Browse Pages";
    $bsubtitle = "Browse latest Pages";
    $con->tp->assign('email', $email);
    
    if($cat == '')
    {
        $selCat = "Latest Pages";
    }
    else
    {
        $selCat = $cat;
    }
    
    $title = "conveylive.com :: Browse Pages";
    
    $keys = "Pages, Articles, Writeups, communicate, share,network,  conveylive";
    $con->tp->assign("keys", $keys);
    
    $desc = "Browse Pages in conveylive.com. Publish , page, articles and writeups and share your views. Get Amazed by the Huge collection of articles in conveylive";
    $con->tp->assign("descrip", $desc);
    
    $catList = getCatListDb($con, "Article");
    
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
    $perPage = 10;
    $pageLimit = 5;
    $found = false;
    $qvar = 'art';
    
    $query = "select count(*) as tot from articles, users where articles.admin_perm = 0 and privacy = 0 and art_typ = 1 and articles.user_email = email $extraParam ";
    
    if($cat == '' && $isSelf == false)
        $url = URL ."/browsearticle.php";
    if($cat != '' && $isSelf == false)
        $url = URL ."/browsearticle.php?cat=$cat";
    if($cat != '' && $isSelf == true)
        $url = URL ."/browsearticle.php?cat=$cat&self=1";
    
    
    $_query = "select f_name, l_name, articles.id as id, title, sub_title, articles.ins_date, articles.upd_date, category_id, body, url, art_typ, articles.privacy, articles.admin_perm, user_email, email  from articles, users where articles.admin_perm = 0 and privacy = 0 and art_typ = 1 and articles.user_email = email $extraParam order by RAND()";//articles.ins_date desc ";
    
    $sess_name = 'articles';
    SmartyPaginate::disconnect();
    unset($_SESSION[$sess_name]);
    SmartyPaginate::reset();
    
    $_SESSION[$qvar] = $_query;
    
    
    if(!isset($_SESSION[$sess_name]))
    {
        SmartyPaginate::connect();
        if(SmartyPaginate::isConnected())
        {
            $found = init_pg($query, $url, $perPage, $pageLimit, $email,  $con, $sess_name);
        }
    }
    if($found)
    {
        if(isset($_SESSION[$sess_name]))
        {
            $currIndex = SmartyPaginate::getCurrentIndex();
            $limit = SmartyPaginate::getLimit();

            $l = sprintf(" LIMIT %d, %d", $currIndex, $limit);
            $query = $_query.$l;
             
            $res = paginate_search($query, $con);
            $err .= $con->db->err;
            if(is_array($res) && $res!= false && $res != array() && count($res) > 0)
            {
                $i = 0;
                foreach($res as $a)
                {
                    $article[$i] = $a;
                    $body = $article[$i]['body'];
                    $body = stripslashes($body);
                    $body = html_entity_decode($body);
                    
                    $body = strip_tags($body);
                    $article[$i]['body'] = $body;
                    
                    $article[$i]['author'] = $article[$i]['f_name'] . " " . $article[$i]['l_name'];
                    
                    $em = $article[$i]['email'];
                    $pid = getPrifileId($em, $con);
                    $img_id = getProfImgId($em, $con);
                    
                    $article[$i]['user_imgs_id'] = $img_id;
                    $article[$i]['pid'] = $pid;
                    
                    $k = $con->db->selectData("select cname from categorys where id = ".$article[$i]['category_id']."");
                    if($k != false && $k != array())
                    {
                        $article[$i]['category'] = $k[0]['cname'];
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
    }
    
    $con->tp->assign('topicHead', $selCat);
    $con->tp->assign('pubList', $pubList);
    $con->tp->assign('selfCatList', $selfList);
    
    $bbody = $con->tp->fetch('browse_art.tpl');
    
    $con->tp->assign('title', $title);
    
    $ret_arr = array();
    $ret_arr['err'] = $err;
    $ret_arr['rep'] = $rep;
    $ret_arr['bbody'] = $bbody;
    $ret_arr['btitle'] = $btitle;
    $ret_arr['bsubtitle'] = $bsubtitle;
    
    return $ret_arr;
}

function view_article($con, $email, $id)
{
    $r = array();
    $id = trim($id);
    $pageName = "Article - Unavailable";
    
    if($id != "")
    {
        if(ctype_digit($id))
        {
            $r = $con->db->selectData("select category_id, articles.id as id, title, sub_title, body, user_email, remarks, meta_tags, articles.ins_date as ins_date, f_name, l_name, email, articles.privacy, articles.admin_perm as admin_perm, articles.upd_date as upd_date from articles, users where user_email = email and id = $id and articles.admin_perm = 0 and art_typ = 1");
        }
        else
        {
            $r = $con->db->selectData("select category_id, articles.id as id, title, sub_title, body, user_email, remarks, meta_tags, articles.ins_date as ins_date, f_name, l_name, email, articles.privacy, articles.admin_perm as admin_perm, articles.upd_date as upd_date from articles, users where user_email = email and url = '$id' and articles.admin_perm = 0 and art_typ = 1"); 
        }
    }
    else
    {
        $err .= "No Page available";
    }
    //echo  $con->db->err;
    //print_r($r);
    
    if($r != false && $r != array())
    {
        if($r[0]['privacy'] == 0 || ($r[0]['privacy'] == 1 && $r[0]['user_email'] == $email))
        {
            $btitle = $r[0]['title'];
            $bsubtitle = $r[0]['sub_title'];
            
            foreach($r as $t)
            {
                $article = $t;
                
                $body = $article['body'];
                $body = stripslashes($body);
                $body = html_entity_decode($body);
                
                $desc = strip_tags($body);
                $desc = substr($desc,0, 300);
                $desc = trim($desc);
                
                $article['body'] = $body;
                
                $title = $article['title'];
                $subtitle = $article['sub_title'];
                $remarks = $article['remarks'];
                $keywords = $article['meta_tags'];
                
                $article['title'] = stripslashes($title);
                $article['sub_title'] = stripslashes($subtitle);
                $article['remarks'] = stripslashes($remarks);
                $article['meta_tags'] = stripslashes($keywords);
                
                 
                $article['name'] = $article['f_name']." ".$article['l_name'];
                $dt = new DateTime($article['ins_date']);
                $date = $dt->format('F j, Y, g:i a');
                $article['ins_date'] = $date;
                
                $q = "select id as pid, user_imgs_id from profiles where user_email = '".$article['user_email']."'";
                $r = $con->db->selectData($q);
                if($r == array() || $r == false || count($r)== 0) $err .= $con->db->err;
                else
                {
                    $article['pid'] = $r[0]['pid'];
                    $article['user_imgs_id'] = $r[0]['user_imgs_id'];
                }
                
                $k = $con->db->selectData("select cname from categorys where id = ".$article['category_id']."");
                if($k != false && $k != array())
                {
                    $article['category'] = $k[0]['cname'];
                }
                
                $m = $con->db->selectData("select id, view_count, rating, tothits, neghits, ins_date, upd_date from contstats where media_id = ".$article['id']." and media_type = 'Article' and admin_perm = 0 ");
                
                if($m != false && $m != array())
                {
                    $article['view_count'] = $m[0]['view_count'];
                    $article['rating'] = $m[0]['rating'];
                    $article['tothits'] = $m[0]['tothits'];
                    $article['neghits'] = $m[0]['neghits'];
                    $article['stat_ins_date'] = $m[0]['ins_date'];
                    $article['stat_upd_date'] = $m[0]['upd_date'];
                }
            }
            if($article['user_email'] != $email)
            {
                $c = (int)$article['view_count'] + 1;
                
                $query = "update contstats set view_count = ".$c." where media_id = ".$article['id']." and media_type = 'Article'";
                $u = $con->db->executeNonQuery($query);
                $article['view_count'] = $c;    
            }
            
            
            $next = array();
            $q = "select id, url, title from articles where admin_perm = 0 and art_typ = 1 order by id desc";

            $r = $con->db->selectData($q);
            if($r == false || $r === array() || count($r) == 0) $err .= $con->db->err;
            else
            {
                foreach($r as $a)
                {
                    if( $a['id'] < $article['id'] )
                    {
                        $next = $a;
                        break;
                    }
                }
            }

            $con->tp->assign('next', $next);
            
            $prev = array();
            $q = "select id, url, title from articles where admin_perm = 0 and art_typ = 1 order by id asc";

            $r = $con->db->selectData($q);
            if($r == false || $r === array() || count($r) == 0) $err .= $con->db->err;
            else
            {
                foreach($r as $a)
                {
                    if( $a['id'] > $article['id'] )
                    {
                        $prev = $a;
                        break;
                    }
                }
            }

            $con->tp->assign('prev', $prev);
                        
            $relArt = array();
            $r = $con->db->selectData("select * from articles where art_typ = 1 and category_id  = '".$article['category_id']."' and admin_perm = 0 and id != ".$article['id']." order by ins_date desc LIMIT 0, 5");
            if($r == false || $r === array() || count($r) == 0) $err .= $con->db->err;
            else
            {
                foreach($r as $a)
                {
                    $relArt[] = $a;
                }
            }
            
            $con->tp->assign('relArt', $relArt);
            
            $coms = getComList($article['id'], 'Article', $con);
            if(is_string($coms)) $err .= $coms;
            if(is_array($coms))
            {
                $com_count = count($coms);
            }

            $pageName = $article['title'];
            
            $sub = strip_tags($article['sub_title']);
            $sub = substr($sub,0, 40);
            $sub = trim($sub);
            
            $d = strip_tags($desc);
            $d = substr($d,0, 40);
            $d = trim($d);
             
            $keys = trim($article['meta_tags']) . ", " . trim($article['title']) .", ". $sub . ", ". $d;
            
            $desc = trim($article['title']) ." , ". trim($article['sub_title'])." - ". $desc;
            $con->tp->assign("descrip", $desc);
            
            $con->tp->assign('keys', $keys);
            $con->tp->assign('com_count', $com_count);
            $con->tp->assign('coms', $coms);
            $con->tp->assign('article', $article);
            $con->tp->assign('email', $email);
            
            
            //Content Invite
            $cont_formlabel = "Invite your friends to read this page";
            $con->tp->assign('cont_formlabel', $cont_formlabel);
            
            $mail_subject = getUserName($email, $con) . " invites you to view this page, \"". $article['title'] . "\"";
            $con->tp->assign('mail_subject', $mail_subject);
            
            $mail_subject_general = "You have been invited to view this page, \"". $article['title'] . "\" by your friend ";
            $con->tp->assign('mail_subject_general', $mail_subject_general);
            
            //$mail_body = "Hi, \r\n";  
            $mail_body .= "I wanted to invite you to read this page called, \"".$article['title'] ."\", published by ".$article["name"]. ". ";
            $mail_body .= "You can join in conveylive.com to add comments to this page. Go to this link or copy paste it in your browser ";
            
            if($article['url'] != "" || $article['url'] != null)
            {
                $mail_body .= URL . "/a/".$article['url'];
            }
            else
            {
                $mail_body .= URL . "/a/".$article['id'];
            }
            $mail_body .= " and let me know if you liked it.";
            //$mail_body .= "\r\n\r\nRegards";
            
            $con->tp->assign('mail_body', $mail_body);
            
            $conttype = "article";
            $con->tp->assign('conttype', $conttype);
            //Content Invite End
            
            $bbody = $con->tp->fetch('art_view.tpl');
        }
        else
        {
            $err = "This page can not be shown.";
            $btitle = "Page - Unavailable";
            $pageName = $btitle;
            $bbody = "You do not have permission to view this page";
        }
    }
    else
    {
        $err .= $con->db->err;
    }
    
    $title = "$pageName :: conveylive.com";
    $con->tp->assign('title', $title);
    
    $ret_arr = array();
    $ret_arr['err'] = $err;
    $ret_arr['rep'] = $rep;
    $ret_arr['bbody'] = $bbody;
    $ret_arr['btitle'] = $btitle;
    $ret_arr['bsubtitle'] = $bsubtitle;
    
    return $ret_arr;
}
?>
