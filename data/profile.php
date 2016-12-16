<?php
function viewProfile($con, $id, $email = '')
{
    $rep = "";
    $err = "";
    $btitle = "";
    $bbody = "";
    $action = "";
    $isfriend = false;
    $countryList = array();
    $relStatusList = array();
    $inactive = false;
    
    $hasProfile = false;
    $pid = getPrifileId($email,$con);
    if($pid != "" || $pid != null)
    {
        $hasProfile = true;
    }
    
    $con->tp->assign('hasProfile', $hasProfile);

    $prof = $con->db->selectData("select uid, f_name, l_name, email, users.ins_date as ins_date, last_login_date, birth_date, gender, id, about_me, home_town, rel_status, lookingfor, activities, interests,
                                 favourites, religion, occupation, edu_info, work_info, phone, web_url, addr, city, country, zipcode, pstatus, profiles.upd_date as upd_date, profiles.admin_perm as admin_perm, active, user_email, user_imgs_id
                                 from users, profiles where users.email = profiles.user_email and profiles.id = $id ");

    if($prof == false || $prof == array() ) 
    { 
        $err .= $con->db->err;
    }
    else
    { 
        
        if($prof[0]['active'] == 1 && $prof[0]['admin_perm'] == 1)
        {
            $rep = "This profile has been deactivated";
            $inactive = true;
        }
        else if($prof[0]['active'] == 1 && $prof[0]['admin_perm'] == 0)
        {
            $rep = "This profile has been deactivated";
            $inactive = true;
        }
        else if($prof[0]['active'] == 0 && $prof[0]['admin_perm'] == 1)
        {
            $rep = "This profile has been deactivated";
            $inactive = true;
        }
        else
        {
            $i = 0;
            foreach($prof as $k)
            {
                $prof[$i]['about_me'] = strip_tags (stripslashes($k['about_me']) );
                $prof[$i]['home_town'] = strip_tags (stripslashes($k['home_town']));
                
                $prof[$i]['rel_status'] = stripslashes($k['rel_status']);
                $prof[$i]['lookingfor'] = stripslashes($k['lookingfor']);
                $prof[$i]['activities'] = strip_tags(stripslashes($k['activities']));
                $prof[$i]['interests'] = strip_tags (stripslashes($k['interests']) );
                $prof[$i]['favourites'] = strip_tags (stripslashes($k['favourites']) );
                
                $prof[$i]['religion'] = strip_tags (stripslashes($k['religion']) );
                $prof[$i]['occupation'] = strip_tags (stripslashes($k['occupation']));
                $prof[$i]['edu_info'] = strip_tags (stripslashes($k['edu_info']) );
                $prof[$i]['work_info'] = strip_tags (stripslashes($k['work_info']) );
                $prof[$i]['phone'] = strip_tags( stripslashes($k['phone']) );
                $prof[$i]['web_url'] = strip_tags (stripslashes($k['web_url']));
                $prof[$i]['addr'] = strip_tags (stripslashes($k['addr']));
                $prof[$i]['city'] = strip_tags( stripslashes($k['city']));
                
                $prof[$i]['country'] = stripslashes($k['country']);
                $prof[$i]['zipcode'] = strip_tags(stripslashes($k['zipcode']));
                $prof[$i]['pstatus'] = strip_tags(stripslashes($k['pstatus']));
                
                $i++;
            }
            //print_r($prof);
            $age = calcAge($prof[0]['birth_date']);
            $prof[0]['age'] = $age;             
            
            $e = $prof[0]['user_email'];
            
            $t = $con->db->selectData("select email as f_email, profiles.id as pid from users, profiles where email in ( select email from users, friends where (req_to='$email' or req_from='$email') and (req_to='$e' or req_from='$e')  and req_pending = 0 and blocked = 0 and friends.admin_perm = 0 and email != '$email' and (req_to = email || req_from = email) ) and profiles.user_email = email");
            if($t[0]['f_email'] == $e) $isfriend = true;
            
            $age = calcAge($prof[0]['birth_date']);
            $prof[0]['age'] = $age;
            
            $con->tp->assign('isfriend', $isfriend);
            
            $countryList = getCountryList();
            $relStatusList = getRelStatusList();
            
            $con->tp->assign('user_email', $email);
            $con->tp->assign('email', $email);
            
            $con->tp->assign('countryList', $countryList);
            $con->tp->assign('relStatusList', $relStatusList);
            
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
            
            $arr = getContents($con, $uemail, $id,  'Articles');
            $err .= $arr['err'];
            
            $arr = getContents($con, $uemail, $id,  'Albums');
            $err .= $arr['err'];
            
            $arr = getContents($con, $uemail, $id,  'Audios');
            $err .= $arr['err'];
            
            $arr = getContents($con, $uemail, $id,  'Videos');
            $err .= $arr['err'];
            
            $arr = getContents($con, $uemail, $id,  'Blogs');
            $err .= $arr['err'];
            
            $arr = getContents($con, $uemail, $id,  'Clubs');
            $err .= $arr['err'];
                    
            $r = $con->db->selectData("select * from albums where user_email = '$uemail' and admin_perm = 0 order by ins_date desc");
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

                if($r != false && $r != array())
                {
                    $albumList[$i]['tot'] = $r[0]['tot']; 
                }
                $err .= $con->db->err;
            }
            $con->tp->assign('albumsList', $albumList);
            
            
            $con->tp->assign('coms', $coms);
            
            $u = false;
            
            if($prof[0]['user_email'] != $email) 
            {
                $c = (int)$prof[0]['view_count'] + 1;

                $query = "update contstats set view_count = ".$c." where media_id = ".$prof[0]['id']." and media_type = 'Profile'";
                
                $u = $con->db->executeNonQuery($query);
            }
            else
            {
                $u = true;
            }
        }
    }
    
    $uname = getUserName($prof[0]['user_email'],$con);
    if($inactive)
    {
        $btitle = "Profile Unavailable";
        
        $title = $uname." :: conveylive.com";
        $con->tp->assign('title', $title);
        $prof = null;         
    }
    else
    {
        $btitle = $uname."'s Profile";
        
        $title = $uname." :: conveylive.com";
        $con->tp->assign('title', $title);
        
        $desc = "Profile of ".$uname." ConveyLive.com is a place to make friends and broadcast your creativity with the world. Publish your articles, audio, video, files, blogs, clubs and make it available to search engines, links and other sites as well as your friends. Browse the world through conveylive.com, expand your circle and get amazed with the large collection of other people's contents.";
        $con->tp->assign("descrip", $desc);
        
        $keys = "Profile,".$uname.", people, community";
        $con->tp->assign("keys", $keys);
    }
    
    $con->tp->assign('prof', $prof[0]);
    $bbody = $con->tp->fetch('prof_view.tpl');
    
    $con->tp->assign('bbody', $bbody);
    $con->tp->assign('btitle', $btitle);
    $con->tp->assign('rep', $rep);
    $con->tp->assign('err', $err);
}

function profile($con, $section, $email, $id = 0)
{
    $rep = "";
    $err = "";
    $btitle = "";
    $bbody = "";
    $action = "";
    $countryList = array();
    $relStatusList = array();
    $skip = false;
    
    $executed = false;
    
    switch($section)
    {
        case 'remstat':
            $q = "update profiles set pstatus = '' where user_email = '$email'";
            $r =  $r = $con->db->executeNonQuery($q);
            if($r == true)
            {
                $rep = "Status Removed";
            }
            else
            {
                $err = $con->db->err;
            }
            
            $id = getPrifileId($email, $con);
            $retList = viewProfile($con, $id, $email);
            
            $bbody = $retList['bbody'];
            $btitle = $retList['btitle'];
            $bsubtitle = $retList['bsubtitle'];
            $rep .= $retList['rep'];
        
        break;
        
        case 'profilepicture':
            //Photo album
            $r = $con->db->selectData("select * from albums where user_email = '$email' and admin_perm = 0 order by ins_date desc");
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
                $query = "select count(*) as tot from images where user_email = '$email' and admin_perm = 0 and stat = 0 and album_id = ".$albumList[$i]['id']."";
                
                $r = $con->db->selectData($query);
                //print_r($r);
                //echo $query;
                if($r != false && $r != array())
                {
                    $albumList[$i]['tot'] = $r[0]['tot']; 
                }
                $err .= $con->db->err;
            }
            
            $con->tp->assign('albums', $albumList);
            
            //Image update or new upload
            $action1 = "update";
            $action2 = "create";
            $aid = 0;
            
            $d = $con->db->selectData("select id, user_imgs_id, user_email from profiles where user_email = '$email'");
            
            if($d == false || $d == array() ) 
            {
                $err .= "DB Error: ".$con->db->err;
                $btitle = "Add new profile photo";
                $action = $action2;
            }
            else
            {
                $btitle = "Update profile photo";
                $action = $action1;
                
                foreach($d as $data)
                {
                    $data[] = $d;
                }
                $con->tp->assign('data', $data);
            }
            if($err == "") $executed = true;
            
            $con->tp->assign('action', $action);

            $con->tp->assign('aid', $aid);
            
            $con->tp->assign('user_email', $data['user_email']);
            
            $bbody = $con->tp->fetch('upload_pic_form.tpl');
            
            $title = "ConveyLive :: Profile Photo";
            $con->tp->assign('title', $title);
            
            $desc = "Set Profile Photo. Create New Profile at ConveyLive.com. ConveyLive.com is a place to make friends and broadcast your creativity with the world. Publish your articles, audio, video, files, blogs, clubs and make it available to search engines, links and other sites as well as your friends. Browse the world through conveylive.com, expand your circle and get amazed with the large collection of other people's contents.";
            $con->tp->assign("descrip", $desc);

            $keys = "Photos, Profile, people, community";
            $con->tp->assign("keys", $keys);
        
        break;
        
        case 'create':
            $btitle = "Create Profile";
            $action = "create";

            $countryList = getCountryList();
            $relStatusList = getRelStatusList();
            $langList = getLangList();
            $lookforList = getLookforList();
            
            $con->tp->assign('action', $action);
            $con->tp->assign('user_email', $email);

            $con->tp->assign('lookforList', $lookforList);
            $con->tp->assign('langList', $langList);
            $con->tp->assign('countryList', $countryList);
            $con->tp->assign('relStatusList', $relStatusList);

            $bbody = $con->tp->fetch('prof_form.tpl');
            
            $title = "ConveyLive :: New Profile";
            $con->tp->assign('title', $title);
            
            $desc = "Create New Profile at ConveyLive.com. ConveyLive.com is a place to make friends and broadcast your creativity with the world. Publish your articles, audio, video, files, blogs, clubs and make it available to search engines, links and other sites as well as your friends. Browse the world through conveylive.com, expand your circle and get amazed with the large collection of other people's contents.";
            $con->tp->assign("descrip", $desc);

            $keys = "Profile, people, community";
            $con->tp->assign("keys", $keys);
            
            $executed = true;
        break;
        
        case 'edit':
            $btitle = "Edit Profile";
            $action = "update";
            
            $countryList = getCountryList();
            $relStatusList = getRelStatusList();
            $langList = getLangListdb($con);
            $langList2 = getLangList();
            if($langList != null)
            {
                foreach($langList as $l)
                {
                    $la[] = $l;
                }
            }
            if($langList2 != null)
            {
                foreach($langList2 as $l)
                {
                    $la[] = $l;
                }
            }
            $la = array_unique($la);
            $langList = $la;
            
            $lookforList = getLookforList();
            
            $con->tp->assign('lookforList', $lookforList);
            $con->tp->assign('langList', $langList);
            
            $d = $con->db->selectData("select * from profiles, users where user_email = '$email' and email = user_email");
            
            if($d == false || $d == array() ) $err .= "DB Error: ".$con->db->err;
            else
            {
                foreach($d as $data)
                {
                    $data[] = $d;
                }
                $data['language'] = explode(",", $d[0]['lang']);
                $data['languageList'] = $data['language'];
                $data['lan'] = $data['language'];
                $con->tp->assign('data', $data);
            }
            if($err == "") $executed = true;
            
            $con->tp->assign('action', $action);
            $con->tp->assign('user_email', $data['user_email']);
            
            $con->tp->assign('countryList', $countryList);
            $con->tp->assign('relStatusList', $relStatusList);
            
            $bbody = $con->tp->fetch('prof_form.tpl');
            
            $title = "Edit Profile - ".getUserName($data['user_email'], $con)." :: ConveyLive";
            $con->tp->assign('title', $title);
            
            $desc = "$title. conveylive.com is a place to make friends and broadcast your creativity with the world. Publish your articles, audio, video, files, blogs, clubs and make it available to search engines, links and other sites as well as your friends. Browse the world through conveylive.com, expand your circle and get amazed with the large collection of other people's contents.";
            $con->tp->assign("descrip", $desc);

            $keys = "Profile,". $data['f_name'] . $data['l_name'].", people, community";
            $con->tp->assign("keys", $keys);
        
        break;
        /*
        case 'delete':
            $btitle = "Delete Profile";
            $pd = $con->db->selectData("select f_name, l_name from users where email = '$email' and admin_perm = 0");
            
            if($pd == false || $pd == array()) $err .= $con->db->err;
            else
            {
                $con->tp->assign('fname', $pd[0]['f_name']);
                $con->tp->assign('lname', $pd[0]['l_name']);
            }
            if($err == "") $executed = true;
            $con->tp->assign('email', $email);
            $bbody = $con->tp->fetch('delprof_view.tpl');
            
            $title = "conveylive.com :: Delete Profile - ".$pd[0]['f_name'] . $pd[0]['l_name']."";
            $con->tp->assign('title', $title);

            $desc = "$title. conveylive.com is a place to make friends and broadcast your creativity with the world. Publish your articles, audio, video, files, blogs, clubs and make it available to search engines, links and other sites as well as your friends. Browse the world through conveylive.com, expand your circle and get amazed with the large collection of other people's contents.";
            $con->tp->assign("descrip", $desc);

            $keys = "Profile,". $pd[0]['f_name'] . $pd[0]['l_name'].", people, community";
            $con->tp->assign("keys", $keys);
        break;
        */
        case 'view':
            
            $id = getPrifileId($email, $con);
            
            viewProfile($con, $id, $email);
            $skip = true;
    }
    
    if($skip == false)
    {
        $con->tp->assign('bsubtitle', $bsubtitle);
        $con->tp->assign('bbody', $bbody);
        $con->tp->assign('btitle', $btitle);
        $con->tp->assign('rep', $rep);
        $con->tp->assign('err', $err);
    }
    
    return $executed;
}

function getContents($con, $email, $id,  $cont_type)
{
    $url = URL ."/profilepage.php?cont=$cont_type&pid=$id"; 

    switch($cont_type)
    {
        case 'Articles':
        $perPage = 10;
        $pageLimit = 2;
        $found = false;
        $qvar = 'art';
        $pgid = 'articles';
        $dataVar = 'articles';
        $tplvar = 'pag_art';
        
        $sess_name = 'article';
        $query = "select count(*) as tot from articles, users where (articles.admin_perm = 0 and art_typ = 1 and articles.user_email = email and articles.user_email = '$email') ";
        $q = "select articles.id as art_id, articles.url as art_url, articles.title as art_title, articles.ins_date as date from articles, users where (articles.admin_perm = 0 and art_typ = 1 and articles.user_email = email and articles.user_email = '$email') order by date desc";
        break;
        
        case 'Albums':
        $perPage = 10;
        $pageLimit = 2;
        $found = false;
        $qvar = 'alb';
        $pgid = 'albums';
        $dataVar = 'albums';
        $tplvar = 'pag_alb';
        
        $sess_name = 'album';
        $query = "select count(*) as tot from albums, users where (albums.admin_perm = 0 and albums.user_email = email and albums.user_email = '$email') ";
        $q = "select albums.id as alb_id, albums.album_name as alb_title, albums.ins_date as date from albums, users where (albums.admin_perm = 0 and albums.user_email = email and albums.user_email = '$email') order by date desc";
        break;
        
        case 'Audios':
        $perPage = 10;
        $pageLimit = 2;
        $found = false;
        $qvar = 'aud';
        $pgid = 'audios';
        $dataVar = 'audios';
        $tplvar = 'pag_aud';
        
        $sess_name = 'audio';
        $query = "select count(*) as tot from audios, users where (audios.admin_perm = 0 and audios.user_email = email and audios.user_email = '$email') ";
        $q = "select audios.id as aud_id, audios.title as aud_title, audios.ins_date as date from audios, users where (audios.admin_perm = 0 and audios.user_email = email and audios.user_email = '$email') order by date desc";
        break;
        
        case 'Videos':
        $perPage = 10;
        $pageLimit = 2;
        $found = false;
        $qvar = 'vid';
        $pgid = 'videos';
        $dataVar = 'videos';
        $tplvar = 'pag_vid';
        
        $sess_name = 'video';
        $query = "select count(*) as tot from videos, users where (videos.admin_perm = 0 and videos.user_email = email and videos.user_email = '$email') ";
        $q = "select videos.id as vid_id, videos.title as vid_title, videos.ins_date as date from videos, users where (videos.admin_perm = 0 and videos.user_email = email and videos.user_email = '$email') order by date desc";
        break;
        
        case 'Blogs':
        $perPage = 10;
        $pageLimit = 2;
        $found = false;
        $qvar = 'bpost';
        $pgid = 'blogposts';
        $dataVar = 'blogposts';
        $tplvar = 'pag_post';
        
        $sess_name = 'blogpost';
        $query = "select count(*) as tot from articles, users, bposts where (articles.admin_perm = 0 and articles.user_email = email and articles.user_email = '$email' and articles.id = bposts.article_id and bposts.user_email = articles.user_email and bposts.user_email = email and art_typ = 2  ) ";
        $q = "select articles.title as post_title, articles.id as art_id, articles.title as post_title, articles.ins_date as date, bposts.id as post_id,  bposts.blog_id as blog_id from articles, users, bposts where (articles.admin_perm = 0 and articles.user_email = email and articles.user_email = '$email' and articles.id = bposts.article_id and bposts.user_email = articles.user_email and bposts.user_email = email and art_typ = 2 ) order by date desc";
        break;
        
        case 'Clubs':
        $perPage = 10;
        $pageLimit = 2;
        $found = false;
        $qvar = 'clu';
        $pgid = 'clubs';
        $dataVar = 'clubs';
        $tplvar = 'pag_clu';
        
        $sess_name = 'club';
        $query = "select count(*) as tot from users, clubs where (clubs.admin_perm = 0 and clubs.user_email = email and clubs.user_email = '$email' )";
        $q = "select clubs.id as club_id, clubs.cname as cname, clubs.ins_date as date from users, clubs where (clubs.admin_perm = 0 and clubs.user_email = email and clubs.user_email = '$email') order by date desc";
        break;
    }
    $blog = null;
    $r = $con->db->selectData("select * from blogs where blogs.user_email = '$email'");
    if($r == false || count($r) == 0 || $r == array()) $err .= $con->db->err;
    else
    {
        foreach($r as $a)
        {
            $blog = $a;
        }
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
            if($email = '') $email = getEmail($id,$con);
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
                    $content[] = $a;
                }
                $con->tp->assign($dataVar,$content);
                $con->tp->assign('blog',$blog);
            }
            $err .= $con->db->err;
            
            SmartyPaginate::assign($con->tp, $tplvar, $pgid);

        }
        else
        {
            $err .= $con->db->err;
            
            $err .= "Session is not set. Content not found";
            
            $btitle = "Content not available";
        }
    }
    else
    {
        $err .= "";
        $rep .= "";
    }
        
    $ret_arr = array();
    $ret_arr['err'] = $err;
    $ret_arr['rep'] = $rep;
    
    return $ret_arr;
}
?>
