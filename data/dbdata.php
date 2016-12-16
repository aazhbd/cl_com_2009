<?php

function html2txt($document){
    $search = array('@<script[^>]*?>.*?</script>@si' //,  // Strip out javascript
                   /*
                   '@<[\/\!]*?[^<>]*?>@si',            // Strip out HTML tags
                   '@<style[^>]*?>.*?</style>@siU',    // Strip style tags properly
                   '@<![\s\S]*?--[ \t\n\r]*>@'         // Strip multi-line comments including CDATA
                   */
    );
    $text = preg_replace($search, '', $document);
    return $text;
}
 
function getContList($con, $email, $contType, $sortType)
{
    if($contType == 'Article')
    {
        if($query == "")
        {
            if($sortType == "MostViewed")
            {
                $query = "select count(*) as tot from articles, contstats, users where articles.user_email = contstats.user_email and contstats.media_type = 'Article' and contstats.media_id = articles.id and articles.admin_perm = 0 and articles.privacy = 0 and art_typ = 1  and users.email = articles.user_email and contstats.user_email = users.email ";
                $_query = "select body, url, category_id, articles.id as id, title, sub_title, articles.ins_date as ins_date, articles.upd_date as upd_date, articles.admin_perm, view_count, tothits, rating, f_name, l_name, email, articles.user_email as user_email from articles, contstats, users where articles.user_email = contstats.user_email and contstats.media_type = 'Article' and contstats.media_id = articles.id and articles.admin_perm = 0 and articles.privacy = 0 and art_typ = 1  and users.email = articles.user_email and contstats.user_email = users.email order by contstats.view_count desc";
            }
            else if($sortType == "TopRated")
            {
                $query = "select count(*) as tot from articles, contstats, users where articles.user_email = contstats.user_email and contstats.media_type = 'Article' and contstats.media_id = articles.id and articles.admin_perm = 0 and articles.privacy = 0 and art_typ = 1  and users.email = articles.user_email and contstats.user_email = users.email ";
                $_query = "select body, url, category_id, articles.id as id, title, sub_title, articles.ins_date as ins_date, articles.upd_date as upd_date, articles.admin_perm, view_count, tothits, rating, f_name, l_name, email, articles.user_email as user_email from articles, contstats, users where articles.user_email = contstats.user_email and contstats.media_type = 'Article' and contstats.media_id = articles.id and articles.admin_perm = 0 and articles.privacy = 0 and art_typ = 1  and users.email = articles.user_email and contstats.user_email = users.email order by contstats.rating desc";
            }
            else if($sortType == "Latest")
            {
                $query = "select count(*) as tot from articles, contstats, users where articles.user_email = contstats.user_email and contstats.media_type = 'Article' and contstats.media_id = articles.id and articles.admin_perm = 0 and articles.privacy = 0 and art_typ = 1  and users.email = articles.user_email and contstats.user_email = users.email ";
                $_query = "select body, url, category_id, articles.id as id, title, sub_title, articles.ins_date as ins_date, articles.upd_date as upd_date, articles.admin_perm, view_count, tothits, rating, f_name, l_name, email, articles.user_email as user_email from articles, contstats, users where articles.user_email = contstats.user_email and contstats.media_type = 'Article' and contstats.media_id = articles.id and articles.admin_perm = 0 and articles.privacy = 0 and art_typ = 1  and users.email = articles.user_email and contstats.user_email = users.email order by contstats.ins_date desc";
            }
        }
        
        $perPage = 10;
        $pageLimit = 5;
        $found = false;
        $qvar = 'art';
        
        $url = URL ."/browsearticle.php?sortby=$sortType";
        
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
                        $j = $con->db->selectData("select user_imgs_id, id from profiles where user_email = '$em'");
                        if($j != false && $j != array())
                        {
                            $article[$i]['user_imgs_id'] = $j[0]['user_imgs_id'];
                            $article[$i]['pid'] = $j[0]['id'];
                        }
                        
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
        
        $con->tp->assign('pubList', $pubList);
        $con->tp->assign('selfCatList', $selfList);
        
        $bbody = $con->tp->fetch('browse_art.tpl');
        
        $ret_arr = array();
        $ret_arr['err'] = $err;
        $ret_arr['rep'] = $rep;
        $ret_arr['bbody'] = $bbody;
        $ret_arr['btitle'] = $btitle;
        $ret_arr['bsubtitle'] = $bsubtitle;
        
        return $ret_arr;
    }
    
    else if($contType == 'Audio')
    {
        if($query == "")
        {
            if($sortType == "MostViewed")
            {
                $query = "select count(*) as tot from audios, contstats, users where audios.user_email = contstats.user_email and contstats.media_type = 'Audio' and contstats.media_id = audios.id and audios.admin_perm = 0 and audios.privacy = 0 and users.email = audios.user_email and contstats.user_email = users.email ";
                $_query = "select category_id, audios.id as id, title, artist, audios.ins_date as ins_date, audios.upd_date as upd_date, audios.admin_perm, view_count, tothits, rating, f_name, l_name, email, audios.user_email as user_email from audios, contstats, users where audios.user_email = contstats.user_email and contstats.media_type = 'Audio' and contstats.media_id = audios.id and audios.admin_perm = 0 and audios.privacy = 0 and users.email = audios.user_email and contstats.user_email = users.email order by contstats.view_count desc";
            }
            else if($sortType == "TopRated")
            {
                $query = "select count(*) as tot from audios, contstats, users where audios.user_email = contstats.user_email and contstats.media_type = 'Audio' and contstats.media_id = audios.id and audios.admin_perm = 0 and audios.privacy = 0 and users.email = audios.user_email and contstats.user_email = users.email ";
                $_query = "select category_id, audios.id as id, title, artist, audios.ins_date as ins_date, audios.upd_date as upd_date, audios.admin_perm, view_count, tothits, rating, f_name, l_name, email, audios.user_email as user_email from audios, contstats, users where audios.user_email = contstats.user_email and contstats.media_type = 'Audio' and contstats.media_id = audios.id and audios.admin_perm = 0 and audios.privacy = 0 and users.email = audios.user_email and contstats.user_email = users.email order by contstats.rating desc";
            }
            else if($sortType == "Latest")
            {
                $query = "select count(*) as tot from audios, contstats, users where audios.user_email = contstats.user_email and contstats.media_type = 'Audio' and contstats.media_id = audios.id and audios.admin_perm = 0 and audios.privacy = 0 and users.email = audios.user_email and contstats.user_email = users.email ";
                $_query = "select category_id, audios.id as id, title, artist, audios.ins_date as ins_date, audios.upd_date as upd_date, audios.admin_perm, view_count, tothits, rating, f_name, l_name, email, audios.user_email as user_email from audios, contstats, users where audios.user_email = contstats.user_email and contstats.media_type = 'Audio' and contstats.media_id = audios.id and audios.admin_perm = 0 and audios.privacy = 0 and users.email = audios.user_email and contstats.user_email = users.email order by contstats.ins_date desc";
            }
        }
        
        $perPage = 8;
        $pageLimit = 5;
        $found = false;
        $qvar = 'aud';
        
        $url = URL ."/browseaudio.php?sortby=$sortType";
        
        $sess_name = 'audios';
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
        }
        
        $con->tp->assign('email', $email);
        $con->tp->assign('filename', $filename);
        $con->tp->assign('pubList', $pubList);
        $con->tp->assign('selfList', $selfList);
        
        $bbody = $con->tp->fetch('browse_audio.tpl');
        
        $ret_arr = array();
        $ret_arr['err'] = $err;
        $ret_arr['rep'] = $rep;
        $ret_arr['bbody'] = $bbody;
        $ret_arr['btitle'] = $btitle;
        $ret_arr['bsubtitle'] = $bsubtitle;
        
        return $ret_arr;
    }
    
    else if($contType == 'Video')
    {
        if($query == "")
        {
            if($sortType == "MostViewed")
            {
                $query = "select count(*) as tot from videos, contstats, users where videos.user_email = contstats.user_email and contstats.media_type = 'Video' and contstats.media_id = videos.id and videos.admin_perm = 0 and videos.privacy = 0 and users.email = videos.user_email and contstats.user_email = users.email order by contstats.view_count desc";
                $_query = "select img_id, category_id, videos.id as id, title, artist, videos.ins_date as ins_date, videos.upd_date as upd_date, videos.admin_perm, view_count, tothits, rating, f_name, l_name, email, videos.user_email as user_email from videos, contstats, users where videos.user_email = contstats.user_email and contstats.media_type = 'Video' and contstats.media_id = videos.id and videos.admin_perm = 0 and videos.privacy = 0 and users.email = videos.user_email and contstats.user_email = users.email order by contstats.view_count desc";
            }
            else if($sortType == "TopRated")
            {
                $query = "select count(*) as tot from videos, contstats, users where videos.user_email = contstats.user_email and contstats.media_type = 'Video' and contstats.media_id = videos.id and videos.admin_perm = 0 and videos.privacy = 0 and users.email = videos.user_email and contstats.user_email = users.email order by contstats.view_count desc";
                $_query = "select img_id, category_id, videos.id as id, title, artist, videos.ins_date as ins_date, videos.upd_date as upd_date, videos.admin_perm, view_count, tothits, rating, f_name, l_name, email, videos.user_email as user_email from videos, contstats, users where videos.user_email = contstats.user_email and contstats.media_type = 'Video' and contstats.media_id = videos.id and videos.admin_perm = 0 and videos.privacy = 0 and users.email = videos.user_email and contstats.user_email = users.email order by contstats.rating desc";
            }
            else if($sortType == "Latest")
            {
                $query = "select count(*) as tot from videos, contstats, users where videos.user_email = contstats.user_email and contstats.media_type = 'Video' and contstats.media_id = videos.id and videos.admin_perm = 0 and videos.privacy = 0 and users.email = videos.user_email and contstats.user_email = users.email order by contstats.view_count desc";
                $_query = "select img_id, category_id, videos.id as id, title, artist, videos.ins_date as ins_date, videos.upd_date as upd_date, videos.admin_perm, view_count, tothits, rating, f_name, l_name, email, videos.user_email as user_email from videos, contstats, users where videos.user_email = contstats.user_email and contstats.media_type = 'Video' and contstats.media_id = videos.id and videos.admin_perm = 0 and videos.privacy = 0 and users.email = videos.user_email and contstats.user_email = users.email order by contstats.ins_date desc";
            }
        }
        
        $perPage = 5;
        $pageLimit = 5;
        $found = false;
        $qvar = 'vid';
        
        $url = URL ."/browsevideo.php?sortby=$sortType";
          
        $sess_name = 'videos';
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
        }
        
        $con->tp->assign('topicHead', $selCat);
        $con->tp->assign('pubList', $pubList);
        $con->tp->assign('selfList', $selfList);
        
        $bbody = $con->tp->fetch('browse_video.tpl');
        
        $title = "ConveyLive :: Browse Video";
        $con->tp->assign('title', $title);
        
        $desc = "Browse the huge collection of video at ConveyLive. Watch your favourite video and songs and tutorials publshed by users of ConveyLive and publish your own video for the world to watch.";
        $con->tp->assign("descrip", $desc);
        
        $keys = " Video, Watch, Song, Music, Voice, communicate, share,network,  conveylive";
        $con->tp->assign("keys", $keys);
        
        $ret_arr = array();
        $ret_arr['err'] = $err;
        $ret_arr['rep'] = $rep;
        $ret_arr['bbody'] = $bbody;
        $ret_arr['btitle'] = $btitle;
        $ret_arr['bsubtitle'] = $bsubtitle;
        
        return $ret_arr;
    } 
    
    else if($contType == 'Album')
    {
        if($query == "")
        {
            if($sortType == "Latest")
            {
                $query = "select count(*) as tot from albums, contstats, users where albums.admin_perm = 0 and albums.privacy = 0 and albums.user_email = contstats.user_email and contstats.media_type = 'Album' and contstats.media_id = albums.id and users.email = albums.user_email and contstats.user_email = users.email";
                $_query = "select f_name, l_name, email, albums.user_email as user_email, albums.id as id, album_name, category_id, image_id, privacy, albums.ins_date as ins_date, albums.upd_date as upd_date, albums.admin_perm as admin_perm, view_count, tothits, rating from albums, contstats, users where albums.admin_perm = 0 and albums.privacy = 0 and albums.user_email = contstats.user_email and contstats.media_type = 'Album' and contstats.media_id = albums.id and users.email = albums.user_email and contstats.user_email = users.email order by contstats.ins_date desc";
            }
        }
        
        $perPage = 9;
        $pageLimit = 5;
        $found = false;
        
        $url = URL ."/picturebrowse.php?sortby=$sortType";
        
        SmartyPaginate::disconnect();
        unset($_SESSION['res']);
        SmartyPaginate::reset();
        SmartyPaginate::disconnect();
        $_SESSION['pic'] = $_query;
        
        if(!isset($_SESSION['res']))
        {
            SmartyPaginate::connect();
            if(SmartyPaginate::isConnected())
            {
                $found = init_pagination_search($query, $url, $perPage, $pageLimit, $email,  $con);
            }
        }
        if($found)
        {
            if(isset($_SESSION['res']))
            {
                $currIndex = SmartyPaginate::getCurrentIndex();
                $limit = SmartyPaginate::getLimit();

                $l = sprintf(" LIMIT %d, %d", $currIndex, $limit);
                $query = $_query.$l;

                $res = paginate_search($query, $con);
                $albums = array();
                if(is_array($res) && $res!= false && $res != array() && count($res) > 0)
                {
                    $i = 0;
                    foreach($res as $a)
                    {
                        $albums[$i] = $a;
                        $r = $con->db->selectData("select * from profiles where user_email = '".$albums[$i]['email']."' and admin_perm = 0");
                        if($r == array() || $r == false || count($r) == 0) $err .= $con->db->err;
                        else
                        {
                            $albums[$i]['pid'] = $r[0]['id'];
                        }
                        
                        $r = $con->db->selectData("select count(id) as tot from images where album_id = '".$albums[$i]['id']."' and admin_perm = 0");
                        if($r == array() || $r == false || count($r) == 0) $err .= $con->db->err;
                        else
                        {
                            $albums[$i]['pic_count'] = $r[0]['tot'];
                        }
                        
                        $i++;
                    } 
                }
                $err .= $con->db->err;
                $con->tp->assign('albums', $albums);
                SmartyPaginate::assign($con->tp);
                $bbody .=  $con->tp->fetch("browse_album.tpl");
            }
            else
            {
                $err .= $con->db->err;
                
                $err .= "Session is not set. Album not found";
                
                $btitle = "Album not available";
                
                $bbody =  $con->tp->fetch("browse_album.tpl");
            }
        }
        else
        {
            $err .= $con->db->err;
            
            $btitle = "Browse Albums";
            
            $bbody =  $con->tp->fetch("browse_album.tpl");
        }
        
        //$bbody = $con->tp->fetch('browse_art.tpl');
        
        $ret_arr = array();
        $ret_arr['err'] = $err;
        $ret_arr['rep'] = $rep;
        $ret_arr['bbody'] = $bbody;
        $ret_arr['btitle'] = $btitle;
        $ret_arr['bsubtitle'] = $bsubtitle;
        
        return $ret_arr;
    }
    
    else if($contType == 'Club')
    {
        if($query == "")
        {
            if($sortType == "Latest")
            {
                //$query = "select count(*) as tot from audios, contstats, users where audios.user_email = contstats.user_email and contstats.media_type = 'Audio' and contstats.media_id = audios.id and audios.admin_perm = 0 and audios.privacy = 0 and users.email = audios.user_email and contstats.user_email = users.email ";
                //$query = "select count(*) as tot from clubs, users, contstats where clubs.admin_perm = 0 and status = 0 and clubs.user_email = contstats.user_email and contstats.media_type = 'Club' and contstats.media_id = clubs.id and clubs.privacy = 0 and users.email = clubs.user_email and contstats.user_email = users.email";
                $query = "select count(*) as tot from clubs, users where clubs.admin_perm = 0 and status = 0 and email = user_email";
                
                //$_query = "select category_id, audios.id as id, title, artist, audios.ins_date as ins_date, audios.upd_date as upd_date, audios.admin_perm, view_count, tothits, rating, f_name, l_name, email, audios.user_email as user_email from audios, contstats, users where audios.user_email = contstats.user_email and contstats.media_type = 'Audio' and contstats.media_id = audios.id and audios.admin_perm = 0 and audios.privacy = 0 and users.email = audios.user_email and contstats.user_email = users.email order by contstats.ins_date desc";
                //$_query = "select cname, image_id, description, category_id, clubs.id as id, clubs.ins_date as ins_date, clubs.upd_date as upd_date, clubs.admin_perm, view_count, tothits, rating, f_name, l_name, email, clubs.user_email as user_email from clubs, users, contstats  where clubs.admin_perm = 0 and status = 0 and clubs.user_email = contstats.user_email and contstats.media_type = 'Club' and contstats.media_id = clubs.id and clubs.privacy = 0 and users.email = clubs.user_email and contstats.user_email = users.email order by contstats.ins_date desc";
                
                $_query = "select * from clubs, users where clubs.admin_perm = 0 and status = 0 and email = user_email order by clubs.ins_date desc "; //$extraParam $groupby ";
            }
        }
        
        $perPage = 4;
        $pageLimit = 5;
        $found = false;
        $qvar = 'clu';
        
        $url = URL ."/browseclub.php?sortby=$sortType";
        
        $sess_name = 'clubs';
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
                    $j= 0;
                    
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
                        
                        $k = $con->db->selectData("select cname from categorys where id = ".$clubs[$j]['category_id']."");
                        if($k != false && $k != array())
                        {
                            $clubs[$j]['category'] = $k[0]['cname'];
                        }
                        $q = "select id, view_count, rating, tothits, neghits, ins_date, upd_date from contstats where media_id = ".$clubs[$j]['id']." and media_type = 'Club' and admin_perm = 0 ";
                        $m = $con->db->selectData($q);
                        
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
                
                $err .= "Session is not set. Clubs not found";
                
                $btitle = "Clubs not available";
            }
        }
        
        $con->tp->assign('pubList', $pubList);
        $con->tp->assign('selfList', $selfList);
        $con->tp->assign('is_member', $is_member);
        
        $bbody = $con->tp->fetch('browse_clubs.tpl');
        $con->tp->assign('email', $email);
        
        
        $ret_arr = array();
        $ret_arr['err'] = $err;
        $ret_arr['rep'] = $rep;
        $ret_arr['bbody'] = $bbody;
        $ret_arr['btitle'] = $btitle;
        $ret_arr['bsubtitle'] = $bsubtitle;
        
        return $ret_arr;
    }
    
    if($contType == 'Blog')
    {
        if($query == "")
        {
            if($sortType == "Latest")
            {
                $query = "select count(*) as tot from blogs, users where blogs.admin_perm = 0 and blogs.user_email = email";   
                $_query = "select blogs . * , f_name, l_name, email FROM blogs, users where blogs.admin_perm =0 AND blogs.user_email = email ORDER BY blogs.ins_date desc";
            }
        }
        
        $perPage = 10;
        $pageLimit = 5;
        $found = false;
        //$qvar = 'art';
        
        $url = URL ."/browseblog.php?sortby=$sortType";
        
        SmartyPaginate::disconnect();
        unset($_SESSION['res']);
        SmartyPaginate::reset();
        SmartyPaginate::disconnect();
        $_SESSION['blg'] = $_query;
        
        if(!isset($_SESSION['res']))
        {
            SmartyPaginate::connect();
            if(SmartyPaginate::isConnected())
            {
                $found = init_pagination_search($query, $url, $perPage, $pageLimit, $email,  $con);
            }
        }
        if($found)
        {
            if(isset($_SESSION['res']))
            {
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
                
                $err .= "Session is not set. Blog not found";
                
                $btitle = "Browse Blogs";
                
                $bbody =  $con->tp->fetch("browse_blogs.tpl");
            }
        }
        else
        {
            $err .= $con->db->err;
            
            $btitle = "Browse Blogs";
            
            $bbody =  $con->tp->fetch("browse_blogs.tpl");
        }
        
        $ret_arr = array();
        $ret_arr['err'] = $err;
        $ret_arr['rep'] = $rep;
        $ret_arr['bbody'] = $bbody;
        $ret_arr['btitle'] = $btitle;
        $ret_arr['bsubtitle'] = $bsubtitle;
        
        return $ret_arr;
    }
}
function makeFileNameSafe($unsafefile)
{
    $safestr = "";
    $arr = str_split($unsafefile);
    foreach($arr as $a)
    {
        if (preg_match('/[A-Za-z0-9]/', $a))
        {
            $safestr .= $a;
        }
        else
        {
            $safestr .= "_";
        }
    }
    return $safestr;
}

function getImagePathDB($image_id, $image_type = "sml")
{
    $path = "directories/albums/";
    $q = "select * from images where id = $image_id and admin_perm = 0";

    //$r = $con->db->selectData($q);
    $r = mysql_query($q);
    $err = mysql_error();
    
    if($r == false || $r == array() || $r == null || count($r) == 0 || strlen($err) != 0)
    {
        $retArr['err'] = $err;
        $retArr['img_path'] = null;
        
        return $retArr;
    }
    else
    {
        while($a = mysql_fetch_assoc($r))
        {
           $image = $a; 
        }
        
        if(count($image) > 0)
        {
            if($image['album_id'] != 0)
            {
                $qu = "select * from albums where id = ". $image['album_id'] ;
                
                $s = mysql_query($qu);
                $err = mysql_error();
                
                if($s == false || $s == array() || $s == null || count($s) == 0 || strlen($err) != 0)
                {
                    $retArr['err'] = $err;
                    $retArr['img_path'] = null;
                    
                    return $retArr;
                }
                else
                {
                    while($t = mysql_fetch_assoc($s))
                    {
                       $album = $t; 
                    }                    
                    if(count($album) > 0)
                    {
                        $album_name = str_replace(" ", "_", trim(stripslashes($album['album_name'])));
                        $album_name = str_replace("'", "_", trim($album_name));
                        $album_name = str_replace("`", "_", trim($album_name));
                        $album_name = str_replace(",", "_", trim($album_name));
                        $album_name = makeFileNameSafe($album_name);
                        
                        $album_path = $path . $album['id'] . "_". $album_name;
                        if(is_dir($album_path))
                        {
                            $image_name = str_replace(" ",  "_", trim(stripslashes($image['file_name'])) );
                            $image_name = str_replace(",",  "_", trim($image_name) );
                            $image_name = str_replace("'",  "_", trim($image_name) );
                            $image_name = str_replace("`",  "_", trim($image_name) );
                            
                            $sml_image_path = $album_path . "/" . $image_id . "_sml_". $image_name;
                            
                            $lrg_image_path = $album_path . "/" . $image_id . "_lrg_". $image_name;
                            if($image_type == "sml")
                            {
                                $retArr['err'] = "";
                                $retArr['img_path'] = $sml_image_path;
                                $retArr['file_type'] = $image['file_type'];
                                return $retArr;
                            }
                            else
                            {
                                $retArr['err'] = "";
                                $retArr['img_path'] = $lrg_image_path;
                                $retArr['file_type'] = $image['file_type']; 
                                return $retArr;
                            }
                        }
                        else
                        {
                            $retArr['err'] = "Album do not exist in file system";
                            $retArr['img_path'] = null;

                            return $retArr; 
                        }
                    }
                    else
                    {
                        $retArr['err'] = "Album do not exist in database";
                        $retArr['img_path'] = null;

                        return $retArr;                        
                    }
                }
            }
            else
            {
                $retArr['err'] = "Album id is invalid";
                $retArr['img_path'] = null;

                return $retArr;
            }
        }
        else
        {
            $retArr['err'] = "Image do not exist in database.";
            $retArr['img_path'] = null;

            return $retArr;
        }
    }
}

function getImagePath($con, $image_id, $image_type = "sml")
{
    $path = PATH . "/directories/albums/";
    $q = "select * from images where id = $image_id and admin_perm = 0";
    $r = $con->db->selectData($q);
    if($r == false || $r == array() || $r == null || count($r) == 0)
    {
        $retArr['err'] = $con->db->err;
        $retArr['img_path'] = null;
        
        return $retArr;
    }
    else
    {
        foreach($r as $a)
        {
            $image = $a;
        }
        if(count($image) > 0)
        {
            if($image['album_id'] != 0)
            {
                $qu = "select * from albums where id = ". $image['album_id'] ;
                $s = $con->db->selectData($qu);
                if($s == false || $s == array() || $s == null || count($s) == 0)
                {
                    $retArr['err'] = $con->db->err;
                    $retArr['img_path'] = null;
                    
                    return $retArr;
                }
                else
                {
                    foreach($s as $t)
                    {
                        $album = $t;
                    }
                    if(count($album) > 0)
                    {
                        $album_name = str_replace(" ", "_", $album['album_name']);
                        $album_name = str_replace("'", "_", $album_name);
                        $album_name = str_replace("`", "_", $album_name);
                        $album_name = str_replace(",", "_", $album_name);
                        
                        $album_path = $path . $album['id'] . "_". $album_name;
                        if(is_dir($album_path))
                        {
                            $image_name = str_replace(" ",  "_ ", $image['file_name'] );
                            $image_name = str_replace(",",  "_ ", $image_name );
                            $image_name = str_replace("'",  "_ ", $image_name );
                            $image_name = str_replace("`",  "_ ", $image_name );
                            
                            $sml_image_path = $album_path . "/" . $image_id . "_sml_". $image_name;
                            
                            $lrg_image_path = $album_path . "/" . $image_id . "_lrg_". $image_name;
                            if($image_type == "sml")
                            {
                                $retArr['err'] = "";
                                $retArr['img_path'] = $sml_image_path;
                                $retArr['file_type'] = $image['file_type'];
                                return $retArr;
                            }
                            else
                            {
                                $retArr['err'] = "";
                                $retArr['img_path'] = $lrg_image_path;
                                $retArr['file_type'] = $image['file_type']; 
                                return $retArr;
                            }
                        }
                        else
                        {
                            $retArr['err'] = "Album do not exist in file system";
                            $retArr['img_path'] = null;

                            return $retArr; 
                        }
                    }
                    else
                    {
                        $retArr['err'] = "Album do not exist in database";
                        $retArr['img_path'] = null;

                        return $retArr;                        
                    }
                }
            }
            else
            {
                $retArr['err'] = "Album id is invalid";
                $retArr['img_path'] = null;

                return $retArr;
            }
        }
        else
        {
            $retArr['err'] = "Image do not exist in database.";
            $retArr['img_path'] = null;

            return $retArr;
        }
    }
}

function insertMailDb($con, $msgBody, $subject, $fromAr, $toAr, $msgtype, $replyTo, $priority, $is_sent, $send_count)
{
    $table = "mails";
    $id = getNewId($table, $con);
    $admin_perm = 0;
    $ins_date = date("Y-m-d H:i:s");
    $upd_date = $ins_date;
    
    if(count($fromAr) > 0){
        $fromAr = array_flip($fromAr);
        $fr = implode(",", $fromAr);
    }
    
    if(count($toAr) > 0){
        $toAr = array_flip($toAr);
        $tr = implode(",", $toAr);
    }
    
    if(is_array($replyTo) && count($replyTo) > 0){
        $replyTo = array_flip($replyTo);
        $rp = implode(",", $replyTo);
    }
    
    if( isset($_SESSION['login']) )
    {
        $l = $_SESSION['login'];
        $email = $l->getEmail();
    }
    else
    {
        $email = $tr;
    }    
    
    $fields = array("`id`", "`user_email`", "`to`", "`from`", "`subj`", "`msg`", "`ins_date`", "`upd_date`","`is_sent`", "`send_count`", "`priority`", "`replyto`");
    $values = array("'".$id."'", "'".$email."'","'".$tr."'", "'".$fr."'", "'".addslashes($subject)."'", "'".addslashes($msgBody)."'",  "'".$ins_date."'","'".$upd_date."'" , "'".$is_sent."'", "'".$send_count."'", "'".$priority."'", "'".$rp."'");

    $f = implode(",", $fields);
    $v = implode(",", $values);

    $query = "insert into $table ( $f ) values ( $v )";
    
    $i = $con->db->executeNonQuery($query);
    
    if($i == true)
    {
        return true;
    }
    else
    {
        return false;
    }    
}

function insertContStats($con, $email, $view_count, $tothits, $neghits, $rating, $media_id, $media_type)
{
    $table = "contstats";
    $id = getNewId($table, $con);
    $admin_perm = 0;
    $ins_date = date("Y-m-d H:i:s");
    $upd_date = $ins_date;
    $fields = array("id", "user_email", "view_count", "tothits", "neghits", "rating", "media_id", "media_type","ins_date", "upd_date","admin_perm");
    $values = array("'".$id."'", "'".$email."'","'".$view_count."'", "'".$tothits."'", "'".$neghits."'", "'".$rating."'",  "'".$media_id."'","'".$media_type."'" , "'".$ins_date."'", "'".$upd_date."'", "'".$admin_perm."'");

    $f = implode(",", $fields);
    $v = implode(",", $values);

    $query = "insert into $table ( $f ) values ( $v )";

    $i = $con->db->executeNonQuery($query);
    
    if($i == true)
    {
        return true;
    }
    else
    {
        return false;
    }
}

function updateContStats($con, $media_id, $media_type, $view_count, $tothits, $neghits, $rating)
{
    $view_upd = false;
    $tothits_upd = false;
    $neghits_upd =  false;
    $rating_upd = false;
    
    $table = "contstats";
    $upd_date = date("Y-m-d H:i:s");

    if($view_count != '')
    {
        $query = "update $table set view_count = $view_count, upd_date = '$upd_date' where media_type = '$media_type' and media_id = $media_id ";

        $i = $con->db->executeNonQuery($query);
        
        $view_upd = true;
    }
    if($tothits != '')
    {
        $query = "update $table set tothits = $tothits, upd_date = '$upd_date' where media_type = '$media_type' and media_id = $media_id ";

        $i = $con->db->executeNonQuery($query);
        $tothits_upd = true;
    }
    if($neghits != '')
    {
        $query = "update $table set neghits = $neghits, upd_date = '$upd_date' where media_type = '$media_type' and media_id = $media_id ";

        $i = $con->db->executeNonQuery($query);
        
        $neghits_upd = true;
    }
    if($rating != '')
    {
        $query = "update $table set rating = $rating, upd_date = '$upd_date' where media_type = '$media_type' and media_id = $media_id ";
        $i = $con->db->executeNonQuery($query);

        $rating_upd = true;
    }
    
    if(($view_count != '' && $view_upd == true) || ($tothits != '' && $tothits_upd == true) || ($neghits != '' && $neghits_upd == true) || ($rating != '' && $rating_upd == true))
    {
        return true;
    }
    else
    {
        return false;
    }
}

function getContStats($con, $media_type, $media_id = '')
{
    $extra = "";
    $res = array();
    if($media_id != '')
    {
        $extra = " and media_id = $media_id";
    }
    $q = "select * from contstats where media_type = '$media_type' " . $extra;
    
    $r = $con->db->executeQuery($q);
    
    if($r == false || $r == null || $r == array() )
    {
        $err = $con->db->err;
        return null;
    }
    else
    {
        if(count($r) == 0)
        {
            return "";
        }
        else
        {
            foreach($r as $a)
            {
                $res[] = $a;
            }
            if(count($res) > 0)
            {
                return $res;
            }
        }
    }
    return $res;
}

function delContStats($con, $media_type, $media_id = '')
{
    $query = "update contstats set admin_perm = 1 where media_type = '$media_type' and media_id = $media_id ";

    $i = $con->db->executeNonQuery($query);
    
    if($i == true)
    {
        return true;
    }
    else
    {
        return false;
    }    
}

function getBlogPosts($con, $blog_id)
{
    $r = $con->db->selectData("select * from bposts where blog_id = $blog_id");
    if($r == null || $r == array() || count($r) == 0)
    {
        $err .= $con->db->err; 
        return $err;        
    }
    else
    {
        foreach($r as $a)
        {
            $posts[] = $a;
            break;
        }
        if(count($posts > 0))
        {
            return $posts;
        }
        else
        {
            return null;
        }
    } 
    return null;    
}

function getCatsByName($con, $catName)
{
    $r = $con->db->selectData("select * from categorys where cname = '$catName'");
    if($r == null || $r == array() || count($r) == 0)
    {
        $err .= $con->db->err; 
        return $err;        
    }
    else
    {
        foreach($r as $a)
        {
            $cats = $a;
            break;
        }
        if(count($cats > 0))
        {
            return $cats;
        }
        else
        {
            return null;
        }
    } 
    return null;
}
function getClubByAlbumId($con, $aid)
{
    $r = $con->db->selectData("select * from cposts where media_id = '$aid' and media_type = 'Club Album'");
    if($r == null || $r == array() || count($r) == 0)
    {
        $err .= $con->db->err; 
        return $err;        
    }
    else
    {
        foreach($r as $a)
        {
            $cpost = $a;
        }
        
        if(count($cpost) > 0 )
        {
            $club_id = $cpost['club_id'];
            $s = $con->db->selectData("select * from clubs where id = $club_id");
            if($s == null || $s == array() || count($s) == 0)
            {
                $err .= $con->db->err; 
                return $err;        
            }
            else
            {
                foreach($s as $a)
                {
                    $club = $a;
                }                
            }
            if(count($club) > 0)
            {
                return $club;
            }
            else
            {
                return null;
            }
        }
        else
        {
            return null;
        }
    }    
}

function isClubMember($con, $email, $club_id)
{
    $is_member = false;
    
    $r = $con->db->selectData("select * from cmembers where `club_id` = '$club_id' and `admin_perm` = '0' and `user_email` = '$email'");

    if($r == null || $r == array() || count($r) == 0)
    {
        $err .= $con->db->err; 
        return $err;        
    }
    else
    {
        foreach($r as $a)
        {
            $mems = $a;
        }
        
        if(count($mems) > 0 )
        {
            if($mems['user_email'] == $email)
            {
                $is_member = true;
            }
        }
        else
        {
            return null;
        }
    }
    return $is_member;
    
}

function isFriend($user_email, $email, $con)
{
    $is_friend = false;
    
    $q = "select f_name, l_name, email as user_email, profiles.id as pid, user_imgs_id, friends.id as fid from users, profiles, friends where (req_to='$email' or req_from='$email') and email != '$email' and  req_pending = 0 and blocked = 0 and (req_to = email || req_from = email)  and profiles.user_email = email";
    
    $con->db->selectData($q);
    
    if($r == null || $r == array() || count($r) == 0)
    {
        $err .= $con->db->err; 
        return $err;        
    }
    else
    {
        foreach($r as $a)
        {
            if($a['user_email'] == $user_email)
            {
                $is_friend = true;
                break;
            }
        }
    }
    return $is_friend;
}

function getClubAlbum($con, $club_id)
{
    $r = $con->db->selectData("select * from cposts where club_id = $club_id and media_type = 'Club Album'");
    
    if($r == null || $r == array() || count($r) == 0)
    {
        $err .= $con->db->err; 
        return $err;        
    }
    else
    {
        foreach($r as $a)
        {
            $cpost = $a;
        }
        
        if(count($cpost) > 0 )
        {
            $album_id = $cpost['media_id'];
            $s = $con->db->selectData("select * from albums where id = $album_id");
            if($s == null || $s == array() || count($s) == 0)
            {
                $err .= $con->db->err; 
                return $err;        
            }
            else
            {
                foreach($s as $a)
                {
                    $album = $a;
                }                
            }
            if(count($album) > 0)
            {
                return $album;
            }
            else
            {
                return null;
            }
        }
        else
        {
            return null;
        }
    }
}

function getBlogURLbyId($con, $postid)
{
    $err = "";
    $blog_url = "";
    
    $r = $con->db->selectData("select blog_id from bposts where id = $postid ");

    if($r == null || $r == array() || count($r) == 0)
    {
        $err .= $con->db->err; 
        return $err;
    }
    else
    {
        foreach($r as $a)
        {
            $blog_id = $a['blog_id'];
        }
        $r = $con->db->selectData("select url from blogs where id = $blog_id ");
        
        if($r == null || $r == array() || count($r) == 0)
        {
            $err .= $con->db->err; 
            return $err;
        }
        else
        {
            foreach($r as $a)
            {
                $blog_url = $a['url'];
            }
            
            return $blog_url;
        }
    }
}

function getCatListDb($con, $mediatype)
{
    $err = "";
    $data = array();

    $r = $con->db->selectData("select distinct id, cname, media_type from categorys where media_type = '$mediatype'");

    if($r == null || $r == array() || count($r) == 0)
    {
        $err .= $con->db->err; 
        return $err;
    }
    else
    {
        foreach($r as $a)
        {
            $data[] = $a;
        }
        return $data;
    }    
}

function getCountryListDb($con)
{
    $err = "";
    $data = array();

    $r = $con->db->selectData("select distinct country from profiles where country != ''");

    if($r == null || $r == array() || count($r) == 0)
    {
        $err .= $con->db->err; 
        return $err;
    }
    else
    {
        foreach($r as $a)
        {
            $data[] = $a['country'];
        }
        return $data;
    }
}

function getLangListdb($con)
{
    $err = "";
    $data = array();

    $r = $con->db->selectData("select lang from profiles where lang != '' ");

    if($r == null || $r == array() || count($r) == 0)
    {
        $err .= $con->db->err; 
        return null;
    }
    else
    {
        foreach($r as $a)
        {
            $data[] = $a['lang'];
        }
        return $data;
    }    
}

function getRelStatusListDb($con)
{
    $err = "";
    $data = array();

    $r = $con->db->selectData("select distinct rel_status from profiles where rel_status != ''");

    if($r == null || $r == array() || count($r) == 0)
    {
        $err .= $con->db->err; 
        return $err;
    }
    else
    {
        foreach($r as $a)
        {
            $data[] = $a['rel_status'];
        }
        return $data;
    }
}

function getReligionListDb($con)
{
    $err = "";
    $data = array();

    $r = $con->db->selectData("select distinct religion from profiles where religion != ''");

    if($r == null || $r == array() || count($r) == 0)
    {
        $err .= $con->db->err; 
        return $err;
    }
    else
    {
        foreach($r as $a)
        {
            $data[] = $a['religion'];
        }
        return $data;
    }
}

function getCityListDb($con)
{
    $err = "";
    $data = array();

    $r = $con->db->selectData("select distinct city from profiles where city != ''");

    if($r == null || $r == array() || count($r) == 0)
    {
        $err .= $con->db->err; 
        return $err;
    }
    else
    {
        foreach($r as $a)
        {
            $data[] = $a['city'];
        }
        return $data;
    }
}

function getHTownListDb($con)
{
    $err = "";
    $data = array();

    $r = $con->db->selectData("select distinct home_town from profiles where home_town != ''");

    if($r == null || $r == array() || count($r) == 0)
    {
        $err .= $con->db->err; 
        return $err;
    }
    else
    {
        foreach($r as $a)
        {
            $data[] = $a['home_town'];
        }
        return $data;
    }
}

function getLanguageListDb($con)
{
    $err = "";
    $data = array();
    $dt = array();
    $r = $con->db->selectData("select distinct lang from profiles where lang != ''");

    if($r == null || $r == array() || count($r) == 0)
    {
        $err .= $con->db->err; 
        return $err;
    }
    else
    {
        $j = 0;
        foreach($r as $a)
        {
            $tmpar = explode(",", $a['lang']);
            
            for($i = 0; $i< count($tmpar); $i++)
            {
                $data[$j] = trim($tmpar[$i]);
            }
            $j++;
        }
        $data = array_unique($data);
        for($i = 0; $i< count($data); $i++)
        {
            if($data[$i] != null)
                $dt[$i] = trim($data[$i]);
        }
        $data = $dt;        
        //print_r($data);
        return $data;
    }
}

function getOccupationListDb($con)
{
    $err = "";
    $data = array();

    $r = $con->db->selectData("select distinct occupation from profiles where occupation != '' ");

    if($r == null || $r == array() || count($r) == 0)
    {
        $err .= $con->db->err; 
        return $err;
    }
    else
    {
        foreach($r as $a)
        {
            $data[] = $a['occupation'];
        }
        return $data;
    }
}

function getCatdb($con, $contTyp)
{
    $err = "";
    $cat = array();
    if($contTyp == "Article")
    {
        $r = $con->db->selectData("select distinct category from articles where art_typ = 1");

        if($r == null || $r == array() || count($r) == 0)
        {
            $err .= $con->db->err; 
            return $err;
        }
        else
        {
            foreach($r as $a)
            {
                $cat[] = $a['category'];
            }
        }
        
        return $cat;
    }
    else
    {
        return null;
    }
}

function getLatestCont($con, $contType)
{
    $latCont = array();
    
    if($contType == "Pages")
    {
        $r = $con->db->selectData("select `title`, `id`, `url` from `articles` where `art_typ` = 1 and  `admin_perm` = '0' and `privacy` = '0' order by `ins_date` desc LIMIT 0, 10");
        
        if($r == false || $r === array() || count($r) == 0) $err .= $con->db->err;
        else
        {
            $i = 0;
            foreach($r as $a)
            {
                $latCont[$i] = $a;
                if($a['url'] != null)
                    $latCont[$i]['contURL'] = "a/".$a['url'];
                else
                    $latCont[$i]['contURL'] = "a/".$a['id'];
                $i++;
            }
        }
        $latBrowselink = "article/browselatest";
    }
    
    if($contType == "Audios")
    {
        $r = $con->db->selectData("select `title`, `id` from `audios` where `admin_perm` = '0' and `privacy` = '0' order by `ins_date` desc LIMIT 0, 10");
        
        if($r == false || $r === array() || count($r) == 0) $err .= $con->db->err;
        else
        {
            $i = 0;
            foreach($r as $a)
            {
                $latCont[$i] = $a;
                $latCont[$i]['contURL'] = "audio/listen/".$a['id'];
                $i++;
            }
        }
        $latBrowselink = "audio/browselatest";
    }
    
    if($contType == "Videos")
    {
        $latCont = array();
        
        $r = $con->db->selectData("select `title`, `id` from `videos` where `admin_perm` = '0' and `privacy` = '0' order by `ins_date` desc LIMIT 0, 10");

        if($r == false || $r === array() || count($r) == 0) $err .= $con->db->err;
        else
        {
            $i = 0;
            foreach($r as $a)
            {
                $latCont[$i] = $a;
                $latCont[$i]['contURL'] = "video/watch/".$a['id'];
                $i++;
            }
        }
        $latBrowselink = "video/browselatest";
    }
    
    if($contType == "Clubs")
    {
        $latCont = array();
        
        $r = $con->db->selectData("select cname as title, id from clubs where `admin_perm` = '0' and `privacy` != 2 order by ins_date desc LIMIT 0, 10");
        
        if($r == false || $r === array() || count($r) == 0) $err .= $con->db->err;
        else
        {
            $i = 0;
            foreach($r as $a)
            {
                $latCont[$i] = $a;
                $latCont[$i]['contURL'] = "clubs/view/".$a['id'];
                $i++;
            }
        }
        $latBrowselink = "clubs/browselatest";
    }
    
    if($contType == "Albums")
    {
        $latCont = array();
        
        $r = $con->db->selectData("select album_name as title, id from albums where `admin_perm` = '0' and privacy = 0 order by ins_date desc LIMIT 0, 10");
        
        if($r == false || $r === array() || count($r) == 0) $err .= $con->db->err;
        else
        {
            $i = 0;
            foreach($r as $a)
            {
                $latCont[$i] = $a;
                $latCont[$i]['contURL'] = "picture/albumview/".$a['id'];
                $i++;
            }
        }
        $latBrowselink = "picture/browselatest";
    }
    
    if($contType == "Blogs")
    {
        $latCont = array();
        
        $r = $con->db->selectData("select cname as title, id, url from blogs where `admin_perm` = '0'  order by ins_date desc LIMIT 0, 10");
        
        if($r == false || $r === array() || count($r) == 0) $err .= $con->db->err;
        else
        {
            $i = 0;
            foreach($r as $a)
            {
                $latCont[$i] = $a;
                $latCont[$i]['contURL'] = "b/".$a['url'];
                $i++;
            }
        }
        $latBrowselink = "blog/browselatest";
    }
    
    $con->tp->assign('latBrowselink', $latBrowselink);
    $con->tp->assign('latContTitle', $contType);
    $con->tp->assign('latContList', $latCont);    
}

function getTopRatedCont($con, $contType)
{
    $topCont = array();
    $this_month_num = date("n");
    
    if($contType == "Pages")
    {
        $q = "select title, id, url from articles where art_typ = 1 and `admin_perm` = '0' and privacy = 0 and MONTH(upd_date) = '$this_month_num'";
        
        $r = $con->db->selectData($q);
        
        if($r == false || $r === array() || count($r) == 0) $err .= $con->db->err;
        else
        {
            $i = 0;
            foreach($r as $a)
            {
                $topCont[$i] = $a;
                
                if($a['url'] != null)
                    $topCont[$i]['contURL'] = "a/".$a['url'];
                else
                    $topCont[$i]['contURL'] = "a/".$a['id'];
                $i++;
            }
        }
        
        $totCont = count($topCont);
        if($totCont > 0 )
        {
            $q = "select distinct media_id from contstats where media_type = 'Article' and MONTH(upd_date) = '$this_month_num' order by rating desc LIMIT 0, 10";
            
            $s = $con->db->selectData($q);
            
            if($r == false || $r === array() || count($s) == 0) $err .= $con->db->err;
            else
            {
                $j = 0;
                foreach($s as $c)
                {
                    $cont_stats = $c;
                    for($i = 0; $i < $totCont ; $i++)
                    {
                        if($c['media_id'] == $topCont[$i]['id'])
                        {
                            $cont[$j] = $topCont[$i];
                            $cont[$j]['stats'] = $cont_stats;
                            $j++;
                        }
                    }
                    
                }
            }
        }
        $topBrowselink = "article/browsetoprated";
        $topCont = $cont;
    }
    
    if($contType == "Audios")
    {
        $r = $con->db->selectData("select `title`, `id` from audios where `admin_perm` = '0' and `privacy` = '0' and MONTH(upd_date) = '$this_month_num'");
        
        if($r == false || $r === array() || count($r) == 0) $err .= $con->db->err;
        else
        {
            $i = 0;
            foreach($r as $a)
            {
                $topCont[$i] = $a;
                $topCont[$i]['contURL'] = "audio/listen/".$a['id'];
                $i++;
            }
        }
        
        $totCont = count($topCont);
        
        if($totCont > 0 )
        {
            $q = "select distinct `media_id` from contstats where media_type = 'Audio' and MONTH(upd_date) = '$this_month_num' order by rating desc LIMIT 0, 10";
            
            $s = $con->db->selectData($q);
            
            if($r == false || $r === array() || count($s) == 0) $err .= $con->db->err;
            else
            {
                $j = 0;
                foreach($s as $c)
                {
                    $cont_stats = $c;
                    for($i = 0; $i < $totCont ; $i++)
                    {
                        if($c['media_id'] == $topCont[$i]['id'])
                        {
                            $cont[$j] = $topCont[$i];
                            $cont[$j]['stats'] = $cont_stats;
                            $j++;
                        }
                    }
                    
                }
            }
        }
        $topBrowselink = "audio/browsetoprated";
        $topCont = $cont;        
    }
    
    if($contType == "Videos")
    {
        $r = $con->db->selectData("select `title`, `id` from `videos` where `admin_perm` = '0' and `privacy` = '0' and MONTH(upd_date) = '$this_month_num' ");

        if($r == false || $r === array() || count($r) == 0) $err .= $con->db->err;
        else
        {
            $i = 0;
            foreach($r as $a)
            {
                $topCont[$i] = $a;
                $topCont[$i]['contURL'] = "video/watch/".$a['id'];
                $i++;
            }
        }
        $totCont = count($topCont);
        if($totCont > 0 )
        {
            $q = "select distinct media_id from contstats where media_type = 'Video' and MONTH(upd_date) = '$this_month_num' order by rating desc LIMIT 0, 10";
            
            $s = $con->db->selectData($q);
            
            if($r == false || $r === array() || count($s) == 0) $err .= $con->db->err;
            else
            {
                $j = 0;
                foreach($s as $c)
                {
                    $cont_stats = $c;
                    for($i = 0; $i < $totCont ; $i++)
                    {
                        if($c['media_id'] == $topCont[$i]['id'])
                        {
                            $cont[$j] = $topCont[$i];
                            $cont[$j]['stats'] = $cont_stats;
                            $j++;
                        }
                    }
                    
                }
            }
        }
        $topBrowselink = "video/browsetoprated";
        $topCont = $cont;
    }
    $con->tp->assign('topBrowselink', $topBrowselink);
    $con->tp->assign('topContTitle', $contType);
    $con->tp->assign('topContList', $topCont);    
}

function getMostViewedCont($con, $contType)
{
    $viewCont = array();
    $this_month_num = date("n");
    
    if($contType == "Pages")
    {
        $q = "select `title`, `id`, `url` from `articles` where `art_typ` = '1' and `admin_perm` = '0' and `privacy` = '0' and MONTH(upd_date) = '$this_month_num'";
        
        $r = $con->db->selectData($q);
        
        if($r == false || $r === array() || count($r) == 0) $err .= $con->db->err;
        else
        {
            $i = 0;
            foreach($r as $a)
            {
                $viewCont[$i] = $a;
                if($a['url'] != null)
                    $viewCont[$i]['contURL'] = "a/".$a['url'];
                else
                    $viewCont[$i]['contURL'] = "a/".$a['id'];
                $i++;
            }
        }
        $totCont = count($viewCont);
        if($totCont > 0 )
        {
            $q = "select distinct media_id from contstats where media_type = 'Article' and MONTH(upd_date) = '$this_month_num' order by view_count desc LIMIT 0, 10";
            
            $s = $con->db->selectData($q);
            
            if($r == false || $r === array() || count($s) == 0) $err .= $con->db->err;
            else
            {
                $j = 0;
                foreach($s as $c)
                {
                    $cont_stats = $c;
                    for($i = 0; $i < $totCont ; $i++)
                    {
                        if($c['media_id'] == $viewCont[$i]['id'])
                        {
                            $cont[$j] = $viewCont[$i];
                            $cont[$j]['stats'] = $cont_stats;
                            $j++;
                        }
                    }
                }
            }
        }
        $viewBrowselink = "article/browsemostviewed";
        $viewCont = $cont;        
    }
    
    if($contType == "Audios")
    {
        $r = $con->db->selectData("select `title`, `id` from `audios` where `admin_perm` = '0' and `privacy` = '0' and MONTH(upd_date) = '$this_month_num'");

        if($r == false || $r === array() || count($r) == 0) $err .= $con->db->err;
        else
        {
            $i = 0;
            foreach($r as $a)
            {
                $viewCont[$i] = $a;
                $viewCont[$i]['contURL'] = "audio/listen/".$a['id'];
                $i++;
            }
        }
        $totCont = count($viewCont);
        if($totCont > 0 )
        {
            $q = "select distinct media_id from contstats where media_type = 'Audio' and MONTH(upd_date) = '$this_month_num' order by view_count desc LIMIT 0, 10";
            
            $s = $con->db->selectData($q);
            
            if($r == false || $r === array() || count($s) == 0) $err .= $con->db->err;
            else
            {
                $j = 0;
                foreach($s as $c)
                {
                    $cont_stats = $c;
                    for($i = 0; $i < $totCont ; $i++)
                    {
                        if($c['media_id'] == $viewCont[$i]['id'])
                        {
                            $cont[$j] = $viewCont[$i];
                            $cont[$j]['stats'] = $cont_stats;
                            $j++;
                        }
                    }
                }
            }
        }
        $viewBrowselink = "audio/browsemostviewed";
        $viewCont = $cont;        
    }
    
    if($contType == "Videos")
    {
        $r = $con->db->selectData("select `title`, `id` from `videos` where `admin_perm` = '0' and `privacy` = '0' and MONTH(upd_date) = '$this_month_num' ");

        if($r == false || $r === array() || count($r) == 0) $err .= $con->db->err;
        else
        {
            $i = 0;
            foreach($r as $a)
            {
                $viewCont[$i] = $a;
                $viewCont[$i]['contURL'] = "video/watch/".$a['id'];
                $i++;
            }
        }
        $totCont = count($viewCont);
        if($totCont > 0 )
        {
            $q = "select distinct media_id from contstats where media_type = 'Video' and MONTH(upd_date) = '$this_month_num' order by view_count desc LIMIT 0, 10";
            
            $s = $con->db->selectData($q);
            
            if($r == false || $r === array() || count($s) == 0) $err .= $con->db->err;
            else
            {
                $j = 0;
                foreach($s as $c)
                {
                    $cont_stats = $c;
                    for($i = 0; $i < $totCont ; $i++)
                    {
                        if($c['media_id'] == $viewCont[$i]['id'])
                        {
                            $cont[$j] = $viewCont[$i];
                            $cont[$j]['stats'] = $cont_stats;
                            $j++;
                        }
                    }
                }
            }
        }
        $viewBrowselink = "video/browsemostviewed";
        $viewCont = $cont;        
    }
    $con->tp->assign('viewBrowselink', $viewBrowselink);
    $con->tp->assign('viewContTitle', $contType);
    $con->tp->assign('viewContList', $viewCont);    
}

function getProfileAlbumId($con,$email, $album_name = 'Profile')
{
    $q = "select id from albums where user_email = '$email' and album_name = '$album_name'";

    $r = $con->db->selectData($q);

    if($r == false || $r == array()) $err = $con->db->err;
    else
    {
        foreach($r as $a)
        {
            $id = $a['id'];
            break;
        }
        if($id != null)
        {
            return $id;
        }
        else
        {
            return null;
        }
    }
    
    return $err;
}


function deleteCom($media_id, $media_type, $con)
{
    $coms = array();
    
    $q = "update comments set admin_perm = 1 where media_id = ".$media_id." and mtype = '$media_type'";
    
    $r = $con->db->executeNonQuery($q);
    
    if($r == false )
    {
        return false;
    }
    else
    {
        return true;
    }
}

function getComList($media_id, $media_type, $con)
{
    $coms = array();

    $q = "select comment, comments.id as id, f_name, l_name, email, user_email, comments.ins_date as ins_date, media_id, mtype, privacy, comments.admin_perm as admin_perm from comments, users where media_id = $media_id and mtype = '$media_type' and comments.admin_perm = 0 and email = user_email order by comments.ins_date asc";
    
    //echo $q;
    $r = $con->db->selectData($q);
    
    if($r == false || $r == array() || count($r) == 0)
    {
        $err .= $con->db->err;
        return $err;
    }
    else
    {
        $i = 0;
        foreach($r as $s)
        {
            $coms[$i] = $s;
            $coms[$i]['comment'] = stripslashes($coms[$i]['comment']);
            $coms[$i]['comment'] = strip_tags($coms[$i]['comment']);

            $uemail = $coms[$i]['user_email'];
            $t = $con->db->selectData("select user_imgs_id, id as pid from profiles where user_email = '$uemail'");
            if($t != false && $t != array())
            {
                $coms[$i]['user_imgs_id'] = $t[0]['user_imgs_id'];
                $coms[$i]['pid'] = $t[0]['pid'];
            }
            $err .= $con->db->err;
            $i++;
        }
    }
    
    return $coms;
}

function ers($ers)
{
    if (!empty($ers))
    {
        $contents="<table cellspacing='0' cellpadding='0' style='border:1px solid red;' align='center' class='tbErrorMsgGrad'><tr><td valign='middle' style='padding:3px' valign='middle' class='tbErrorMsg'><img src='/images/ers.gif'></td><td valign='middle' style='color:red;padding:5px;'>";
        foreach ($ers as $key=>$error)
            $contents.="{$error}<br >";
        $contents.="</td></tr></table><br >";
        return $contents;
    }
}

function oks($oks)
{
    if (!empty($oks))
    {
        $contents="<table border='0' cellspacing='0' cellpadding='10' style='border:1px solid #5897FE;' align='center' class='tbInfoMsgGrad'><tr><td valign='middle' valign='middle' class='tbInfoMsg'><img src='/images/oks.gif' ></td><td valign='middle' style='color:#5897FE;padding:5px;'>    ";
        foreach ($oks as $key=>$msg)
            $contents.="{$msg}<br >";
        $contents.="</td></tr></table><br >";
        return $contents;
    }
}

function checkBlog($con, $email)
{
    $hasBlog= false;
    $q = "select user_email, url from blogs where user_email = '$email' and admin_perm = 0";

    $r = $con->db->selectData($q);

    if($r != array() && $r != false && count($r) > 0)
    {
        $hasBlog = true;
        $url = URL ."/b/" .$r[0]['url'];;
        $con->tp->assign('blog_url', $url);
    }
    $con->tp->assign('blogexist', $hasBlog);
    return $hasBlog;
}

function getCurrPgNo($query, $con, $id)
{
    $pg = -1;
    $r = $con->db->selectData($query);
    if($r != array() && $r != false && count($r) > 0)
    {
        $i = 0;
        foreach($r as $a)
        {
            if($a['id'] == $id)
            {
                $pg = $i;
                break;
            }
            $i++;
        }
    }
    return $pg;
}

function getPrifileId($user_email, $con)
{
    if(trim($user_email) == "" || $con == null) 
        return "";
    $id = "";
    
    $r = $con->db->selectData("select id from profiles where user_email = '$user_email' ");

    if($r == false || $r == array()) return "";
    
    foreach($r as $t)
    { 
        $id = $t["id"];
    }
    return $id;
}

function getEmailByid($id, $con)
{
    $r = $con->db->selectData("select email from users where uid = $id");

    if($r == false || $r == array()) return "";
    
    foreach($r as $t)
    { 
        $email = $t["email"];
    }
    return $email;
}

function getUserId($email, $con)
{
    $id = "";

    $r = $con->db->selectData("select uid from users where email = '$email'");

    if($r == false || $r == array()) return "";
    
    foreach($r as $t)
    { 
        $id = $t["uid"];
    }
    return $id;
}

function getEmail($profId, $con)
{
    $id = "";

    $r = $con->db->selectData("select user_email from profiles where id = $profId");

    if($r == false || $r == array()) return "";
    
    foreach($r as $t)
    { 
        $id = $t["user_email"];
    }
    return $id;
}

function getProfImgId($user_email, $con)
{
    if(trim($user_email) == "" || $con == null) 
        return "";
    $img_id = "";
    
    $r = $con->db->selectData("select user_imgs_id from profiles where user_email = '$user_email'");
    if($r == false || $r == array()) return "";
    
    foreach($r as $t)
    { 
        $img_id = $t["user_imgs_id"];
    }
    return $img_id;
}

function getUserName($user_email, $con)
{
    if(trim($user_email) == "" || $con == null) 
        return "";
    $uname = "";
    
    $r = $con->db->selectData("select f_name, l_name from users where email = '$user_email'");
    
    if($r == false || $r == array()) return "";
    
    foreach($r as $t)
    { 
        $uname = $t["f_name"] . " " . $t["l_name"];
    }
    return $uname;
}

function getNewId($table, $con)
{
    $r = $con->db->selectData("select max(id) as max from $table");
    if($r == false || $r == array()) return 0;
    foreach($r as $t)
    { 
        $max = $t["max"];
    }
    return $max + 1;
}

function addSiteStat($pagename, $con, $email)
{
    $ip = $_SERVER['REMOTE_ADDR'];

    $q = "INSERT INTO `sitestats` (`ip_add` , `pg_name` , `ins_date` , `user_email` ) VALUES ('$ip', '$pagename', '". date("Y-m-d H:i:s") ."', '$email')";
    
    return $con->db->executeNonQuery($q);
}

function setLoginInfo($email, $con)
{
    if(isset($email) && $email != '')
    {
        $islogin = true;
        $err = "";
        $fname = "";
        $loginmsg = "";
        $ret = true;
        
        $q = $con->db->selectData("select f_name, last_login_date from users where email = '$email'");
        if($q == false) $ret = false;
        else if($q) 
        {
            $fname = $q[0]['f_name']; 
        }
        
        $loginmsg = "Welcome ".$fname;
        $con->tp->assign('loginmsg',$loginmsg);
        $con->tp->assign('email',$email);
        
        return $ret;
    }
}
?>
