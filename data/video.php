<?php
function video($con, $email, $section,  $id = '', $tmp_id = '')
{
    $rep = "";
    $err = "";
    $btitle = "";
    $bbody = "";
    $bsubtitle = "";
    
    switch($section)
    {
        case 'ratedown':
            $media_type = "Video";
            
            $media_id = $id;
            
            $upd = rateChange($con, $media_type, $media_id, 'down');

            if($upd != false  )
            {
                $rep = "Video rating updated";
            }
            $err .= $con->db->err;
            
            $retList = watch_video($con, $email, $id);
            
            $bbody .= $retList['bbody'];
            $btitle .= $retList['btitle'];
            $bsubtitle .= $retList['bsubtitle'];
            $rep .= $retList['rep'];
            $err .= $retList['err'];
        break;
        
        case 'rateup':
            $media_type = "Video";
            
            $media_id = $id;
            
            $upd = rateChange($con, $media_type, $media_id, 'up');

            if($upd != false  )
            {
                $rep = "Video rating updated";
            }
            $err .= $con->db->err;
            
            $retList = watch_video($con, $email, $id);
            
            $bbody .= $retList['bbody'];
            $btitle .= $retList['btitle'];
            $bsubtitle .= $retList['bsubtitle'];
            $rep .= $retList['rep'];
            $err .= $retList['err'];
        break;
        
        case 'delete':
            $r = $con->db->executeNonQuery("update videos set admin_perm = 1 where id = $id and admin_perm = 0 and user_email = '$email'");

            if($r == false  )
            {
                $rep = "Could not delete video.";
            }
            else
            {
                $rep = "Video has been deleted.";
                $isDel = deleteCom($id, "Video", $con);
                if($isDel)
                {
                    $rep = "Video has been deleted.";
                }
                else
                {
                    $rep = "Video has been deleted. But not Comments";
                }
            }
            $err .= $con->db->err;
            $retList = browse_video($con, $email);
            
            $bbody = $retList['bbody'];
            $btitle = $retList['btitle'];
            $bsubtitle = $retList['bsubtitle'];
            $rep .= $retList['rep'];
            $err .= $retList['err'];
        break;
        
        case 'watch':
            $con->tp->assign('email', $email);
            $retList = watch_video($con, $email, $id);
            
            $bbody = $retList['bbody'];
            $btitle = $retList['btitle'];
            $bsubtitle = $retList['bsubtitle'];
            $rep = $retList['rep'];
            $err = $retList['err'];
        break;
        
        case 'new':
            $btitle = "New Video";
            $bsubtitle = "Upload and share your favourite video";
            $action = "insert";
            
            $con->tp->assign('email', $email);
            
            $videoList = getCatListDb($con, "Video");
            
            $con->tp->assign('action', $action);
            $con->tp->assign('videoList', $videoList);
            $bbody = $con->tp->fetch('video_form.tpl');
            
            $title = "ConveyLive :: New Video";
            $con->tp->assign('title', $title);
            
            $desc = "Publish Video and share with your friends. Browse the huge collection of video at ConveyLive. Watch your favourite video and songs and tutorials publshed by users of ConveyLive and publish your own video for the world to watch.";
            $con->tp->assign("descrip", $desc);
            
            $keys = "Video, Watch, Song, Music, Voice, communicate, share,network,  conveylive";
            $con->tp->assign("keys", $keys);
        break;

        case 'browsetoprated':
            $btitle = "Browse Top Rated Videos";
            $bsubtitle = "All Videos are in order they were rated highest by the people";
            
            $title = "conveylive.com :: Browse Top Rated Videos";
            $con->tp->assign('title', $title);
            
            $topicHead = "Top Rated Videos";
            $con->tp->assign('topicHead', $topicHead);
            
            $desc = "Browse the huge collection of videos at conveylive.com. Watch your favourite video and songs and tutorials publshed by users of ConveyLive and publish your own video for the world to watch.";
            $con->tp->assign("descrip", $desc);
            
            $keys = " Video, Watch, Song, Music, Voice, communicate, share,network,  conveylive";
            $con->tp->assign("keys", $keys);
            
            $con->tp->assign('email', $email);
            
            $contType = "Video";
            $sortType = "TopRated";
            
            $retList = getContList($con, $email, $contType, $sortType);
            
            $bbody = $retList['bbody'];
            $btitle .= $retList['btitle'];
            $bsubtitle .= $retList['bsubtitle'];
            $rep .= $retList['rep'];
            $err .= $retList['err'];
        break;
        
        case 'browsemostviewed':
            $btitle = "Browse Most Viewed Videos";
            $bsubtitle = "All Videos are in order they were viewed most number of times";
            
            $title = "conveylive.com :: Browse Most Viewed Videos";
            $con->tp->assign('title', $title);
            
            $topicHead = "Most Viewed Videos";
            $con->tp->assign('topicHead', $topicHead);
            
            $desc = "Browse the huge collection of video at ConveyLive. Watch your favourite video and songs and tutorials publshed by users of ConveyLive and publish your own video for the world to watch.";
            $con->tp->assign("descrip", $desc);
            
            $keys = " Video, Watch, Song, Music, Voice, communicate, share,network,  conveylive";
            $con->tp->assign("keys", $keys);
            
            $con->tp->assign('email', $email);
            
            $contType = "Video";
            $sortType = "MostViewed";
            
            $retList = getContList($con, $email, $contType, $sortType);
            
            $bbody = $retList['bbody'];
            $btitle .= $retList['btitle'];
            $bsubtitle .= $retList['bsubtitle'];
            $rep .= $retList['rep'];
            $err .= $retList['err'];
        break;
        
        case 'browselatest':
            $btitle = "Browse Latest Videos";
            $bsubtitle = "All Videos are in order that are recently published";
            
            $title = "conveylive.com :: Browse Latest Videos";
            $con->tp->assign('title', $title);
            
            $topicHead = "Latest Videos";
            $con->tp->assign('topicHead', $topicHead);
            
            $desc = "Browse the huge collection of video at ConveyLive. Watch your favourite video and songs and tutorials publshed by users of ConveyLive and publish your own video for the world to watch.";
            $con->tp->assign("descrip", $desc);
            
            $keys = " Video, Watch, Song, Music, Voice, communicate, share,network,  conveylive";
            $con->tp->assign("keys", $keys);
            
            $con->tp->assign('email', $email);
            
            $contType = "Video";
            $sortType = "Latest";
            
            $retList = getContList($con, $email, $contType, $sortType);
            
            $bbody = $retList['bbody'];
            $btitle .= $retList['btitle'];
            $bsubtitle .= $retList['bsubtitle'];
            $rep .= $retList['rep'];
            $err .= $retList['err'];
        break;
        
        case 'categorybrowse':
            $btitle = "Browse Video";
            $con->tp->assign('email', $email);
            
            $sId = str_replace("_"," ", $id);
            $videoList = getCatListDb($con,'Video');
            
            $desc = "Browse the huge collection of video at ConveyLive by category. Watch your favourite video and songs and tutorials publshed by users of ConveyLive and publish your own video for the world to watch.";
            $con->tp->assign("descrip", $desc);
            
            $keys = "Video, Watch, Song, Music, Voice, communicate, share,network,  conveylive";
            $con->tp->assign("keys", $keys);
            
            $selCat = "";
            foreach($videoList as $cat)
            {
                if(trim($cat['cname']) == trim($sId) )
                {
                    $selCat = $cat['id'];
                    $topicHead = $cat['cname'];
                    break;
                }
            }
            if($selCat == "")
            {
                 $err .= "Sorry, this video do not exist";
                 $selCat = "No Results Found";
                 $video = null;
            }
            else
            {
                if($tmp_id == 'self')
                {
                    $extraParam = " and category_id = $selCat and user_email = '$email' and user_email != ''";
                    $retList = browse_video($con, $email, $sId, $extraParam, " order by videos.ins_date desc ", $topicHead);
                }
                else
                {
                    $retList = browse_video($con, $email, $sId, " and category_id = $selCat ", "order by videos.ins_date desc " ,$topicHead);
                }
                                
                //$retList = browse_video($con, $email, " and category_id = '$selCat'", " order by videos.ins_date desc ", $selCat);
                $bbody = $retList['bbody'];
                $btitle = $retList['btitle'];
                $bsubtitle = $retList['bsubtitle'];
                $rep = $retList['rep'];
                $err = $retList['err'];
            }
        break;
        
        case 'browse':
            $retList = browse_video($con, $email, '');
            
            $bbody = $retList['bbody'];
            $btitle = $retList['btitle'];
            $bsubtitle = $retList['bsubtitle'];
            $rep = $retList['rep'];
            $err = $retList['err'];
        break;
    }
    $con->tp->assign('bsubtitle', $bsubtitle);
    $con->tp->assign('bbody', $bbody);
    $con->tp->assign('btitle', $btitle);
    $con->tp->assign('rep', $rep);
    $con->tp->assign('err', $err);
}

function watch_video($con, $email, $id)
{
    $r = $con->db->selectData("select id, user_email, img_id, title, category_id, artist, additional, filename, filesize, filetype, file_path, videos.ins_date, videos.admin_perm, meta_tags, f_name, l_name, email, ustatus from videos, users where id = $id and email = user_email");
    if($r == false || $r == array() || count($r) == 0 ) $err .= $con->db->err;
    else
    {
        foreach($r as $t)
        {
            $video = $t;
            $ue = $video['email'];
            
            $video['pid'] = getPrifileId($ue, $con);
            $video['user_imgs_id'] = getProfImgId($ue, $con);
            
            $k = $con->db->selectData("select cname from categorys where id = ".$video['category_id']."");
            if($k != false && $k != array())
            {
                $video['category'] = $k[0]['cname'];
            }
            
            $m = $con->db->selectData("select id, view_count, rating, tothits, neghits, ins_date, upd_date from contstats where media_id = ".$video['id']." and media_type = 'Video' and admin_perm = 0 ");
            if($m != false && $m != array())
            {
                $video['view_count'] = $m[0]['view_count'];
                $video['rating'] = $m[0]['rating'];
                $video['tothits'] = $m[0]['tothits'];
                $video['neghits'] = $m[0]['neghits'];
                $video['stat_ins_date'] = $m[0]['ins_date'];
                $video['stat_upd_date'] = $m[0]['upd_date'];
            }            
        }
    }
    if($video != null)
    {
        if($video['user_email'] != $email)
        {
            $c = (int)$video['view_count'] + 1;
            
            $query = "update contstats set view_count = ".$c." where media_id = ".$video['id']." and media_type = 'Video'";
            $u = $con->db->executeNonQuery($query);
            $video['view_count'] = $c;    
        }
                
        $next = array();
        $q = "select id, title from videos where admin_perm = 0 order by id desc";

        $r = $con->db->selectData($q);
        if($r == false || $r === array() || count($r) == 0) $err .= $con->db->err;
        else
        {
            foreach($r as $a)
            {
                if( $a['id'] < $video['id'] )
                {
                    $next = $a;
                    break;
                }
            }
        }

        $con->tp->assign('next', $next);
        
        $prev = array();
        $q = "select id, title from videos where admin_perm = 0 order by id asc";

        $r = $con->db->selectData($q);
        if($r == false || $r === array() || count($r) == 0) $err .= $con->db->err;
        else
        {
            foreach($r as $a)
            {
                if( $a['id'] > $video['id'] )
                {
                    $prev = $a;
                    break;
                }
            }
        }

        $con->tp->assign('prev', $prev);
        
        $relArt = array();
        $r = $con->db->selectData("select title, id, img_id from videos where category_id  = '".$video['category_id']."' and admin_perm = 0 and id != ".$video['id']." order by ins_date desc LIMIT 0, 5");
        if($r == false || $r === array() || count($r) == 0) $err .= $con->db->err;
        else
        {
            foreach($r as $a)
            {
                $relArt[] = $a;
            }
        }
        
        $con->tp->assign('relArt', $relArt);
    
/*    
    $latArt = array();
    $r = $con->db->selectData("select title, id from videos where admin_perm = 1 and privacy = 2 order by date_pub desc LIMIT 0, 5");
    if($r == false || $r === array() || count($r) == 0) $err .= $con->db->err;
    else
    {
        foreach($r as $a)
        {
            $latArt[] = $a;
        }
    }
    $con->tp->assign('latArt', $latArt);
    
    $popArt = array();
    $r = $con->db->selectData("select title, id from videos where admin_perm = 1 and privacy = 2 order by rating desc LIMIT 0, 5");
    if($r == false || $r === array() || count($r) == 0) $err .= $con->db->err;
    else
    {
        foreach($r as $a)
        {
            $popArt[] = $a;
        }
    }
    $con->tp->assign('popArt', $popArt);
*/
 
        $coms = getComList($video['id'], 'Video', $con);
        if(is_string($coms)) $err .= $coms;

        if(is_array($coms))
        {
            $com_count = count($coms);
        }

        $con->tp->assign('coms', $coms);
        $keys = $video['title'] .", ". $video['author']. ", ". $video['artist']. ", ". $video['category'] . ", ". $video['meta_tags'];
        $con->tp->assign('keys', $keys);
        $con->tp->assign('email', $email);
        $con->tp->assign('com_count', $com_count);
        
        //Content Invite
        $cont_formlabel = "Invite your friends to watch this video";
        $con->tp->assign('cont_formlabel', $cont_formlabel);
        
        $mail_subject = getUserName($email, $con). " invites you to watch a video titled, \"".$video['title'] . "\"";
        $con->tp->assign('mail_subject', $mail_subject);
        
        $mail_subject_general = "You have been invited to watch a video titled, \"".$video['title'] . "\" by your friend ";
        $con->tp->assign('mail_subject_general', $mail_subject_general);
        
        //$mail_body = "Hi, \r\n ";  
        $mail_body .= "I wanted to invite you to view this video titled, \"".$video['title'] ."\", published by ".$video['f_name']." ". $video['l_name'].".";
        $mail_body .= "You can join in conveylive.com to add comments to this video. Go to this link or copy paste it in your browser. ";
        
        $mail_body .= URL . "/video/watch/".$video['id'];
        $mail_body .= " and let me know if you liked it.";
        //$mail_body .= "\r\n\r\nRegards";
        
        $con->tp->assign('mail_body', $mail_body);
        
        $conttype = "video";
        $con->tp->assign('conttype', $conttype);
        //Content Invite End
            
        $btitle = $video['title'];
        $con->tp->assign('video', $video);
        $bbody = $con->tp->fetch('watchvideo.tpl');
        
        $title = $video['title'] ." - Video of ". $video['f_name']." " .$video['l_name'] . " :: conveylive.com";
        $con->tp->assign('title', $title);
        
        $desc = $video['title'] ." by artist, ". $video['artist']." - Published by ". $video['f_name']." " .$video['l_name'] . ", a member of conveylive.com. Watch your favourite video and songs and tutorials publshed by users of ConveyLive and publish your own video for the world to watch.";
        $con->tp->assign("descrip", $desc);
        
        $keys .= trim($video['meta_tags']) .", ". trim($video['title']) .",".$video['f_name']." " .$video['l_name'] .", Video, Watch, Song, Music, Voice, communicate, share,network,  conveylive";
        $con->tp->assign("keys", $keys);
    }
    else
    {
        //header("HTTP/1.1 404 Not Found", true, 404);
        $isinvalid = true;
        $con->tp->assign('isinvalid',$isinvalid);        
        $btitle = "Video Not Avalaiable";
        $title = "Video :: ConveyLive";
        $bbody = $con->tp->fetch('watchvideo.tpl');
    }
    
    $ret_arr = array();
    $ret_arr['err'] = $err;
    $ret_arr['rep'] = $rep;
    $ret_arr['bbody'] = $bbody;
    $ret_arr['btitle'] = $btitle;
    $ret_arr['bsubtitle'] = $bsubtitle;
    
    return $ret_arr;
}

function browse_video($con, $email, $id = '', $exparam = '', $groupby = 'order by videos.ins_date desc', $topicHead = 'Latest Videos' )
{
    $btitle = "Browse Videos";
    $bsubtitle = "Browse latest video and search by category";
    $con->tp->assign('email', $email);
    
    $videoList = getCatListDb($con, "Video");
    
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
    $perPage = 5;
    $pageLimit = 5;
    $found = false;
    $qvar = 'vid';
    
    $query = "select count(*) as tot from videos, users where videos.admin_perm = 0 and privacy = 0 and videos.user_email = email $exparam ";
    
    //$query = "select count(*) as tot from uploaded_videos, users where uploaded_videos.admin_perm = 1 and privacy = 2 and uploaded_videos.user_email = email";
    if($topicHead != "Latest Audios")
    {
        $url = URL ."/browsevideo.php?cat_id=$id";
    }
    else
    {
        $url = URL ."/browsevideo.php";
    }
    $_query = "select id, f_name, l_name, email, user_email, title, artist, img_id, videos.ins_date, videos.upd_date, category_id from videos, users where videos.admin_perm = 0 and privacy = 0 and videos.user_email = email $exparam order by RAND()";//"$exparam  $groupby ";
    //$_query = "select * from uploaded_videos, users where uploaded_videos.admin_perm = 1 and privacy = 2 and uploaded_videos.user_email = email group by date_pub desc ";
      
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
    
    $con->tp->assign('topicHead', $topicHead);
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
?>
