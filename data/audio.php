<?php
function audio($con, $email, $section,  $id = '', $tmp_id = '')
{
    $rep = "";
    $err = "";
    $btitle = "";
    $bbody = "";
    $bsubtitle = "";
    
    switch($section)
    {
        case 'ratedown':
            $media_type = "Audio";
            
            $media_id = $id;
            
            $upd = rateChange($con, $media_type, $media_id, 'down');

            if($upd != false  )
            {
                $rep = "Audio rating updated";
            }
            $err .= $con->db->err;
            
            $retList = play_audio($con, $email, $id);
            
            $bbody .= $retList['bbody'];
            $btitle .= $retList['btitle'];
            $bsubtitle .= $retList['bsubtitle'];
            $rep .= $retList['rep'];
            $err .= $retList['err'];
        break;
        
        case 'rateup':
            $media_type = "Audio";
            
            $media_id = $id;
            
            $upd = rateChange($con, $media_type, $media_id, 'up');

            if($upd != false  )
            {
                $rep = "Audio rating updated";
            }
            $err .= $con->db->err;
            
            $retList = play_audio($con, $email, $id);
            
            $bbody .= $retList['bbody'];
            $btitle .= $retList['btitle'];
            $bsubtitle .= $retList['bsubtitle'];
            $rep .= $retList['rep'];
            $err .= $retList['err'];
        break;
        
        case 'browsegenre':
            $btitle = "Browse Audio by Genre";
            $bsubtitle = "Browse the latest audio by genre";

            $selCat = "Latest Audio by Genre";
            
            $con->tp->assign('topicHead', $selCat);
            
            $retList = browse_audio($con, $email, $id, '', " order by category_id desc", $selCat);
            
            $bbody = $retList['bbody'];
            $rep = $retList['rep'];
            $err = $retList['err'];
            
            $con->tp->assign('topicHead', $selCat);
        break;
        
        case 'browseartist':
            $btitle = "Browse Audio by Artist";
            $bsubtitle = "Browse the latest audio by artist";
            $selCat = "Latest Audio by Artist";
            $con->tp->assign('topicHead', $selCat);
            
            $retList = browse_audio($con, $email, $id, '', " order by artist desc", $selCat);
            
            $bbody = $retList['bbody'];
            $rep = $retList['rep'];
            $err = $retList['err'];
            
            $con->tp->assign('topicHead', $selCat);
        break;
        
        case 'edit':
            $btitle = "Update Audio";
            $bsubtitle = "Edit audio information";
            $action = "update";
            $r = $con->db->selectData("select audios.id as id, category_id, additional, meta_tags, title, artist from audios where audios.id = $id and privacy = 0 and admin_perm = 0 and user_email = '$email'");
            if($r == false || $r == array()) $err .= $con->db->err;
            else
            {
                foreach($r as $s)
                {
                    $audio = $s;
                }
            }
            $genList = getCatListDb($con, 'Audio');
            
            $con->tp->assign('action', $action);
            $con->tp->assign('audio', $audio);
            $con->tp->assign('genreList', $genList);
            $bbody = $con->tp->fetch('update_audio.tpl');
            
            $title = "Edit Audio - ".$audio['title']." conveylive.com";
            
            $con->tp->assign('title', $title);
            
            $desc = "Publish and Edit Information of Audio, Songs, Voice in ConveyLive. Listen to you favourite audio publshed by users of ConveyLive and browse audio";
            $con->tp->assign("descrip", $desc);
        break;
        
        case 'delete':
            $r = $con->db->executeNonQuery("update audios set admin_perm = 1 where id = $id and admin_perm = 0 and user_email = '$email'");

            if($r == false  )
            {
                $err = "Could not delete audio.";
            }
            else
            {
                $rep = "Audio has been deleted.";
                $isDel = deleteCom($id, "Audio", $con);
                if($isDel)
                {
                    $rep = "Audio has been deleted.";
                }
                else
                {
                    $rep = "Audio has been deleted. But not Comments";
                }
            }
            $err .= $con->db->err;
            
            $retList = browse_audio($con, $email, $id);
            
            $bbody .= $retList['bbody'];
            $btitle .= $retList['btitle'];
            $bsubtitle .= $retList['bsubtitle'];
            $rep .= $retList['rep'];
            $err .= $retList['err'];
        break;
        
        case 'listen':
            $retList = play_audio($con, $email, $id);
            
            $bbody = $retList['bbody'];
            $btitle = $retList['btitle'];
            $bsubtitle = $retList['bsubtitle'];
            $rep = $retList['rep'];
            $err = $retList['err'];
        break;
        
        case 'new':
            $btitle = "New Audio";
            $bsubtitle = "Publish your favourite audio, voice, music and share with the world";
            $action = "insert";
            $con->tp->assign('action', $action);
            
            $con->tp->assign('genreList', getCatListDb($con,"Audio"));
            
            $bbody = $con->tp->fetch('audio_form.tpl');
            $title = "conveylive.com :: New Audio";
            
            $desc = "Publish Audio, Songs, Voice in ConveyLive. Listen to you favourite audio publshed by users of ConveyLive and browse audio";
            $con->tp->assign("descrip", $desc);
            
            $keys = "New, Audio, Listen, Song, Music, Voice, communicate, share,network,  conveylive";
            $con->tp->assign("keys", $keys);
            
            $con->tp->assign('title', $title);
        break;
        
        case 'browsetoprated':
            $btitle = "Browse Top Rated Audios";
            $bsubtitle = "All Audios are in order they were viewed most number of times";
            
            $title = "conveylive.com :: Browse Top Rated Audios";
            $con->tp->assign('title', $title);
            
            $topicHead = "Top Rated Audios";
            $con->tp->assign('topicHead', $topicHead);
            
            $desc = "Browse Audio, Songs, Voice published by users of conveylive.com. Listen to you favourite audio publshed by users of ConveyLive and publish your own audio for the world to listen";
            $con->tp->assign("descrip", $desc);
            
            $keys = "Audio, Listen, Song, Music, Voice, communicate, share,network,  conveylive";
            $con->tp->assign("keys", $keys);
            
            $con->tp->assign('email', $email);
            
            $contType = "Audio";
            $sortType = "TopRated";
            
            $retList = getContList($con, $email, $contType, $sortType);
            
            $bbody = $retList['bbody'];
            $btitle .= $retList['btitle'];
            $bsubtitle .= $retList['bsubtitle'];
            $rep .= $retList['rep'];
            $err .= $retList['err'];
        break;
        
        case 'browsemostviewed':
            $btitle = "Browse Most Played Audios";
            $bsubtitle = "All Audios are in order they were played most number of times";
            
            $title = "conveylive.com :: Browse Most Played Audios";
            $con->tp->assign('title', $title);
            
            $topicHead = "Most Played Audios";
            $con->tp->assign('topicHead', $topicHead);
            
            $desc = "Browse Audio, Songs, Voice published by users of conveylive.com. Listen to you favourite audio publshed by users of ConveyLive and publish your own audio for the world to listen";
            $con->tp->assign("descrip", $desc);
            
            $keys = "Audio, Listen, Song, Music, Voice, communicate, share,network,  conveylive";
            $con->tp->assign("keys", $keys);
            
            $con->tp->assign('email', $email);
            
            $contType = "Audio";
            $sortType = "MostViewed";
            
            $retList = getContList($con, $email, $contType, $sortType);
            
            $bbody = $retList['bbody'];
            $btitle .= $retList['btitle'];
            $bsubtitle .= $retList['bsubtitle'];
            $rep .= $retList['rep'];
            $err .= $retList['err'];
        break;

        case 'browselatest':
            $btitle = "Browse Latest Audios";
            $bsubtitle = "All Audios are in order that are recently published";
            
            $title = "conveylive.com :: Browse Latest Audios";
            $con->tp->assign('title', $title);
            
            $topicHead = "Latest Audios";
            $con->tp->assign('topicHead', $topicHead);
            
            $desc = "Browse Audio, Songs, Voice published by users of conveylive.com. Listen to you favourite audio publshed by users of ConveyLive and publish your own audio for the world to listen";
            $con->tp->assign("descrip", $desc);
            
            $keys = "Audio, Listen, Song, Music, Voice, communicate, share,network,  conveylive";
            $con->tp->assign("keys", $keys);
            
            $con->tp->assign('email', $email);
            
            $contType = "Audio";
            $sortType = "Latest";
            
            $retList = getContList($con, $email, $contType, $sortType);
            
            $bbody = $retList['bbody'];
            $btitle .= $retList['btitle'];
            $bsubtitle .= $retList['bsubtitle'];
            $rep .= $retList['rep'];
            $err .= $retList['err'];
        break;        
        
        case 'genrebrowse':
            $sId = str_replace("_"," ", $id);
            $genreList = getCatListDb($con,'Audio');
            
            $selGen = "";
            foreach($genreList as $gen)
            {
                if(trim($gen['cname']) == trim($sId) )
                {
                    $selGen = $gen['id'];
                    $topicHead = $gen['cname'];
                    break;
                }
            }

            if($selGen == "")
            {
                 $err = "Sorry, this genre does not exist";
                 $bbody = "";
                 $btitle = "Invalid Genre";
            }
            else
            {
                if($tmp_id == 'self')
                {
                    $extraParam = " and category_id = $selGen and user_email = '$email' and user_email != ''";
                    $retList = browse_audio($con, $email, $sId, $extraParam, " order by audios.ins_date desc", $topicHead);
                }
                else
                {
                    $retList = browse_audio($con, $email, $sId, " and category_id = $selGen ", "order by audios.ins_date desc " ,$topicHead);
                }

                $bbody .= $retList['bbody'];
                $btitle .= $retList['btitle'];
                $bsubtitle .= $retList['bsubtitle'];
                $rep .= $retList['rep'];
                $err .= $retList['err'];
            }
        break;
        
        case 'browse':
            $retList = browse_audio($con, $email, $id, '');
            
            $bbody = $retList['bbody'];
            $btitle = $retList['btitle'];
            $bsubtitle = $retList['bsubtitle'];
            $rep = $retList['rep'];
            $err = $retList['err'];
        break;
    }
    
    $con->tp->assign('bbody', $bbody);
    $con->tp->assign('btitle', $btitle);
    $con->tp->assign('bsubtitle', $bsubtitle);
    $con->tp->assign('rep', $rep);
    $con->tp->assign('err', $err);
}

function browse_audio($con, $email, $id = '', $extra_param = '', $groupby = 'order by audios.ins_date desc', $topicHead = 'Latest Audios')
{
    $btitle = "Browse Audio";
    $bsubtitle = "Browse latest audio";
    $con->tp->assign('email', $email);
    $selCat = "Latest Audio";
    
    $title = "conveylive.com :: Browse Audio";
    
    $desc = "Browse Audio, Songs, Voice published by users of conveylive.com. Listen to you favourite audio publshed by users of ConveyLive and publish your own audio for the world to listen";
    $con->tp->assign("descrip", $desc);
    
    $keys = "Audio, Listen, Song, Music, Voice, communicate, share,network,  conveylive";
    $con->tp->assign("keys", $keys);
    
    $genreList = getCatListDb($con,"Audio");

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
    
    $perPage = 8;
    $pageLimit = 5;
    $found = false;
    $qvar = 'aud';
    
    $query = "select count(*) as tot from audios, users where audios.admin_perm = 0 and privacy = 0 and audios.user_email = email $extra_param";

    if($topicHead != "Latest Audios")
    {
        $url = URL ."/browseaudio.php?gen_id=$topicHead";
    }
    else
    {
        $url = URL ."/browseaudio.php";
    }
    $_query = "select audios.id as id, f_name, l_name, title, email, user_email, audios.ins_date, audios.upd_date, category_id, audios.admin_perm, privacy, artist  from audios, users where audios.admin_perm = 0 and privacy = 0 and audios.user_email = email $extra_param order by RAND() ";//"$extra_param $groupby";
    
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
    $con->tp->assign('topicHead', $topicHead);
    $con->tp->assign('pubList', $pubList);
    $con->tp->assign('selfList', $selfList);
    
    $bbody = $con->tp->fetch('browse_audio.tpl');
    
    $con->tp->assign('title', $title);
    
    $ret_arr = array();
    $ret_arr['err'] = $err;
    $ret_arr['rep'] = $rep;
    $ret_arr['bbody'] = $bbody;
    $ret_arr['btitle'] = $btitle;
    $ret_arr['bsubtitle'] = $bsubtitle;
    
    return $ret_arr;
}

function play_audio($con, $email, $id)
{
    $aud = $con->db->selectData("select audios.id as id, f_name, l_name, title, email, user_email, audios.ins_date, category_id, audios.admin_perm, privacy, meta_tags, additional, artist from audios, users where audios.admin_perm = 0 and audios.user_email = email and audios.id = $id ");
    if($aud == false || $aud == array()) $err .= $con->db->err;
    else
    {
        $i = 0;
        foreach($aud as $a)
        {
            $audio = $a;
            $audio['author'] = $audio['f_name'] . " " . $audio['l_name'];
                        
            $em = $audio['email'];
            
            $j = $con->db->selectData("select user_imgs_id, id as pid from profiles where user_email = '$em'");
            if($j != false && $j != array())
            {
                $audio['user_imgs_id'] = $j[0]['user_imgs_id'];
                $audio['pid'] = $j[0]['pid'];
            }
            
            $k = $con->db->selectData("select cname from categorys where id = ".$audio['category_id']."");
            if($k != false && $k != array())
            {
                $audio['genre'] = $k[0]['cname'];
            }            
            
            $m = $con->db->selectData("select id, view_count, rating, tothits, neghits, ins_date, upd_date from contstats where media_id = ".$audio['id']." and media_type = 'Audio' and admin_perm = 0 ");
            if($m != false && $m != array())
            {
                $audio['view_count'] = $m[0]['view_count'];
                $audio['rating'] = $m[0]['rating'];
                $audio['tothits'] = $m[0]['tothits'];
                $audio['neghits'] = $m[0]['neghits'];
                $audio['stat_ins_date'] = $m[0]['ins_date'];
                $audio['stat_upd_date'] = $m[0]['upd_date'];
            }
            
            if($audio['user_email'] != $email)
            {
                $c = (int)$audio['view_count'] + 1;
                
                $query = "update contstats set view_count = ".$c." where media_id = ".$audio['id']." and media_type = 'Audio'";
                $u = $con->db->executeNonQuery($query);
                $audio['view_count'] = $c;    
            }
            $i++; 
        }
        $btitle = $audio['title'];
        $bsubtitle = "Artist - " . $audio['artist'];
    }
    
    $next = array();
    $q = "select id, title from audios where admin_perm = 0 order by id desc";

    $r = $con->db->selectData($q);
    if($r == false || $r === array() || count($r) == 0) $err .= $con->db->err;
    else
    {
        foreach($r as $a)
        {
            if( $a['id'] < $audio['id'] )
            {
                $next = $a;
                break;
            }
        }
    }

    $con->tp->assign('next', $next);
    
    $prev = array();
    $q = "select id, title from audios where admin_perm = 0 order by id asc";

    $r = $con->db->selectData($q);
    if($r == false || $r === array() || count($r) == 0) $err .= $con->db->err;
    else
    {
        foreach($r as $a)
        {
            if( $a['id'] > $audio['id'] )
            {
                $prev = $a;
                break;
            }
        }
    }

    $con->tp->assign('prev', $prev);
    
    $title = $audio['title']. " - published by " . $audio['author'] . " :: conveylive.com"; 
    
    $relArt = array();
    $r = $con->db->selectData("select id, title from audios where category_id  = '".$audio['category_id']."' and admin_perm = 0 and id != ".$audio['id']." order by ins_date desc LIMIT 0, 5");
    if($r == false || $r === array() || count($r) == 0) $err .= $con->db->err;
    else
    {
        foreach($r as $a)
        {
            $relArt[] = $a;
        }
    }
    
    $con->tp->assign('relArt', $relArt);
    
    $latArt = array();
    $r = $con->db->selectData("select id, title from audios where admin_perm = 0 and privacy = 0 order by ins_date desc LIMIT 0, 5");
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
    $r = $con->db->selectData("select audios.id as id, title from audios, contstats where audios.id = contstats.media_id and audios.admin_perm = 0 and audios.privacy = 0 order by contstats.rating desc LIMIT 0, 5");
    if($r == false || $r === array() || count($r) == 0) $err .= $con->db->err;
    else
    {
        foreach($r as $a)
        {
            $popArt[] = $a;
        }
    }
    $con->tp->assign('popArt', $popArt);
    
    
    $coms = getComList($audio['id'], 'Audio', $con);
    if(is_string($coms)) $err .= $coms;
    if(is_array($coms))
    {
        $com_count = count($coms);
    }
    
    $con->tp->assign('coms', $coms);
    $keys = trim($audio['meta_tags']) . " , ". trim($audio['title']) .", ". $audio['author']. ", ". $audio['artist'];
    
    $desc = $audio['title'] ." - published by ". $audio['author']. ", Artist: ". $audio['artist']. ", Genre: ". $audio['genre'] .". Listen to you favourite audio publshed by users of ConveyLive and publish your own audio for the world to listen";
    $con->tp->assign("descrip", $desc);
    
    $con->tp->assign('keys', $keys);
    $con->tp->assign('email', $email);
    $con->tp->assign('audio', $audio);
    $con->tp->assign('com_count', $com_count);
    

    //Content Invite
    $cont_formlabel = "Invite your friends to listen to this audio";
    $con->tp->assign('cont_formlabel', $cont_formlabel);
    
    $mail_subject = getUserName($email, $con) . " invites you to listen to this audio titled, \"". $audio['title'] . "\"";
    $con->tp->assign('mail_subject', $mail_subject);
    
    $mail_subject_general = "You have been invited to listen to this audio titled, \"". $audio['title'] . "\" by your friend ";
    $con->tp->assign('mail_subject_general', $mail_subject_general);
    
    //$mail_body = "Hi, \r\n";  
    $mail_body .= "I wanted to invite you to read this audio titled, \"".$audio['title'] ."\", published by ".$audio['author'].". ";
    $mail_body .= "You can join in conveylive.com to add comments to this audio. Go to this link or copy paste it in your browser ";
    
    $mail_body .= URL . "/audio/listen/".$audio['id'];
    
    $mail_body .= " and let me know if you liked it.";
    //$mail_body .= "\r\n\r\nRegards";
    
    $con->tp->assign('mail_body', $mail_body);
    
    $conttype = "audio";
    $con->tp->assign('conttype', $conttype);
    //Content Invite End
    
    $bbody = $con->tp->fetch('play_audio.tpl');
    
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
