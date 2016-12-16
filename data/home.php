<?php
function home($con, $email, $id = 'user')
{
    $rep = "";
    $err = "";
    $btitle = "";
    $bsubtitle = "";
    $bbody = "";
    $limitreq = 2;
    $limitpend = 2;
    switch($id)
    {
        case 'user':
        
        $pid = getPrifileId($email, $con);
        
        if($pid == "")
        {
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
            
            $bsubtitle = "<div id='admininfo'><div style='float:left; width:5%;'><img src='".URL."/interface/icos/info.png' style='width:30px;'/></div><div style='float:left; width:94%;'>Welcome to conveylive.com. Please <a href='".URL."/profile/create/$email'>create your profile</a> if you want people to find you in search results and communicate with you. No one will be able to contact you if you dont create your profile.<div class='subinfo'> - Conveylive Team</div></div></div>"; 
            
            $title = "ConveyLive :: New Profile";
            $con->tp->assign('title', $title);
            
            $desc = "Create New Profile at ConveyLive.com. ConveyLive.com is a place to make friends and broadcast your creativity with the world. Publish your articles, audio, video, files, blogs, clubs and make it available to search engines, links and other sites as well as your friends. Browse the world through conveylive.com, expand your circle and get amazed with the large collection of other people's contents.";
            $con->tp->assign("descrip", $desc);

            $keys = "Profile, people, community";
            $con->tp->assign("keys", $keys);
        }
        else
        {
            //Module: Club Join Request List Populate
            $q = "select * from cmembers where user_email = '$email' and admin_perm = 0 and status = 0  and club_id in (select id from clubs where status = 0 and admin_perm = 0 and privacy = 2)";
            
            $r = $con->db->selectData($q);
            
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
                    $join_req[$i]['club_name'] = $club['cname'];
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
            $r = $con->db->selectData("select count(*) as tot from messages where rcvr_email = '$email' and read_stat = 1");
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
            
            $r = $con->db->selectData("select * from profiles, users where user_email = '$email' and email = user_email");
            if($r == false || $r == array()) {$err .= $con->db->err; $prof = null;}
            else
            {
                foreach($r as $a)
                {
                    $prof = $a;
                }
            }
            
            $arr = getNews($con, $email, $pid,  'Status');
            $err .= $arr['err'];
            
            $arr = getNews($con, $email, $pid,  'Articles');
            $err .= $arr['err'];
            
            $arr = getNews($con, $email, $pid,  'Albums');
            $err .= $arr['err'];
            
            $arr = getNews($con, $email, $pid,  'Audios');
            $err .= $arr['err'];
            
            $arr = getNews($con, $email, $pid,  'Videos');
            $err .= $arr['err'];
            
            $arr = getNews($con, $email, $pid,  'Blogs');
            $err .= $arr['err'];
            
            $arr = getNews($con, $email, $pid,  'Clubs');
            $err .= $arr['err'];
            
            $con->tp->assign('prof', $prof);
            $btitle = getUserName($email, $con) . "'s Home";
            $bbody = $con->tp->fetch('home_view.tpl');
        }
        
        $title = "conveylive.com :: Home";
        break;
        
        case 'admin':
        $bbody = $con->tp->fetch('frm_category.tpl');
        $btitle = "Add Category";
        break;
        
        default:
    }
    $con->tp->assign('bbody', $bbody);
    $con->tp->assign('btitle', $btitle);
    $con->tp->assign('bsubtitle', $bsubtitle);
    $con->tp->assign('rep', $rep);
    $con->tp->assign('err', $err);
    
    $con->tp->assign('title', $title);
}

function getNews($con, $email, $id,  $cont_type)
{
    $url = URL ."/uhomepage.php?cont=$cont_type&pid=$id"; 

    switch($cont_type)
    {
        case 'Status':
        $perPage = 15;
        $pageLimit = 5;
        $found = false;
        $qvar = 'sta';
        $pgid = 'status';
        $dataVar = 'statuses';
        $tplvar = 'pag_stat';
        
        
        $sess_name = 'status';
        
        $query = "select count(*) as tot from users, profiles where (profiles.pstatus != '' and profiles.user_email = email and profiles.user_email in ( select email from users, friends where (req_to='$email' or req_from='$email') and email != '$email'and req_pending = 0 and blocked = 0 and friends.admin_perm = 0 and (req_to = email || req_from = email) ) )";
        
        $q = "select f_name, l_name, pstatus,  user_imgs_id, profiles.id as pid, profiles.user_email as user_email, profiles.upd_date as date  from users, profiles where ( profiles.pstatus != '' and  profiles.user_email = email and profiles.user_email in ( select email from users, friends where (req_to='$email' or req_from='$email') and email != '$email'and req_pending = 0 and blocked = 0 and friends.admin_perm = 0 and (req_to = email || req_from = email) ) ) order by date desc";
        break;
        
        case 'Articles':
        $perPage = 15;
        $pageLimit = 5;
        $found = false;
        $qvar = 'art';
        $pgid = 'articles';
        $dataVar = 'articles';
        $tplvar = 'pag_art';
        
        $sess_name = 'article';
        
        $query = "select count(*) as tot from articles, users, profiles where (profiles.user_email = email and articles.user_email = profiles.user_email and articles.admin_perm = 0 and art_typ = 1 and articles.user_email = email and articles.user_email in ( select email from users, friends where (req_to='$email' or req_from='$email') and email != '$email'and req_pending = 0 and blocked = 0 and friends.admin_perm = 0 and (req_to = email || req_from = email) ) )";
        
        $q = "select f_name, l_name, user_imgs_id, profiles.id as pid, profiles.user_email as user_email, articles.id as art_id, articles.url as art_url, articles.title as art_title, articles.ins_date as date from articles, users, profiles where (profiles.user_email = email and articles.user_email = profiles.user_email and articles.admin_perm = 0 and art_typ = 1 and articles.user_email = email and articles.user_email in ( select email from users, friends where (req_to='$email' or req_from='$email') and email != '$email'and req_pending = 0 and blocked = 0 and friends.admin_perm = 0 and (req_to = email || req_from = email) ) ) order by date desc";
        
        break;
        
        case 'Albums':
        $perPage = 15;
        $pageLimit = 5;
        $found = false;
        $qvar = 'alb';
        $pgid = 'albums';
        $dataVar = 'albums';
        $tplvar = 'pag_alb';
        
        $sess_name = 'album';
        
        $query = "select count(*) as tot from albums, users, profiles where (profiles.user_email = email and albums.user_email = profiles.user_email and albums.admin_perm = 0 and albums.user_email = email and albums.user_email in ( select email from users, friends where (req_to='$email' or req_from='$email') and email != '$email'and  req_pending = 0 and blocked = 0 and friends.admin_perm = 0 and (req_to = email || req_from = email) )) ";
        
        $q = "select f_name, l_name, user_imgs_id, profiles.id as pid, profiles.user_email as user_email, albums.id as alb_id, albums.album_name as alb_title, albums.ins_date as date from albums, users, profiles where ( profiles.user_email = email and albums.user_email = profiles.user_email and albums.admin_perm = 0 and albums.user_email = email and albums.user_email in ( select email from users, friends where (req_to='$email' or req_from='$email') and email != '$email'and  req_pending = 0 and blocked = 0 and friends.admin_perm = 0 and (req_to = email || req_from = email) )) order by date desc";
        break;
        
        case 'Audios':
        $perPage = 15;
        $pageLimit = 5;
        $found = false;
        $qvar = 'aud';
        $pgid = 'audios';
        $dataVar = 'audios';
        $tplvar = 'pag_aud';
        
        $sess_name = 'audio';
        
        $query = "select count(*) as tot from audios, users, profiles where ( profiles.user_email = email and audios.user_email = profiles.user_email and audios.admin_perm = 0 and audios.user_email = email and audios.user_email in ( select email from users, friends where (req_to='$email' or req_from='$email') and email != '$email'and  req_pending = 0 and blocked = 0 and friends.admin_perm = 0 and (req_to = email || req_from = email) )) ";
        
        $q = "select f_name, l_name, user_imgs_id, profiles.id as pid, profiles.user_email as user_email, audios.id as aud_id, audios.title as aud_title, audios.ins_date as date from audios, users, profiles where ( profiles.user_email = email and audios.user_email = profiles.user_email and audios.admin_perm = 0 and audios.user_email = email and audios.user_email in ( select email from users, friends where (req_to='$email' or req_from='$email') and email != '$email'and  req_pending = 0 and blocked = 0 and friends.admin_perm = 0 and (req_to = email || req_from = email) )) order by date desc";
        
        break;
        
        case 'Videos':
        $perPage = 15;
        $pageLimit = 5;
        $found = false;
        $qvar = 'vid';
        $pgid = 'videos';
        $dataVar = 'videos';
        $tplvar = 'pag_vid';
        
        $sess_name = 'video';
        
        $query = "select count(*) as tot from videos, users, profiles where (profiles.user_email = email and videos.user_email = profiles.user_email and videos.admin_perm = 0 and videos.user_email = email and videos.user_email in ( select email from users, friends where (req_to='$email' or req_from='$email') and email != '$email'and  req_pending = 0 and blocked = 0 and friends.admin_perm = 0 and (req_to = email || req_from = email) )) ";
        
        $q = "select f_name, l_name, user_imgs_id, profiles.id as pid, profiles.user_email, videos.id as vid_id, videos.title as vid_title, videos.ins_date as date from videos, users, profiles where (profiles.user_email = email and videos.user_email = profiles.user_email and  videos.admin_perm = 0 and videos.user_email = email and videos.user_email in ( select email from users, friends where (req_to='$email' or req_from='$email') and email != '$email'and  req_pending = 0 and blocked = 0 and friends.admin_perm = 0 and (req_to = email || req_from = email) )) order by date desc";
        
        break;
        
        case 'Blogs':
        $perPage = 15;
        $pageLimit = 5;
        $found = false;
        $qvar = 'bpost';
        $pgid = 'blogposts';
        $dataVar = 'blogposts';
        $tplvar = 'pag_post';
        
        $sess_name = 'blogpost';
        
        $query = "select count(*) as tot from articles, users, bposts, profiles where (bposts.user_email = articles.user_email and  bposts.user_email = profiles.user_email and profiles.user_email = email and articles.user_email = profiles.user_email and articles.admin_perm = 0 and articles.user_email = email and articles.user_email in ( select email from users, friends where (req_to='$email' or req_from='$email') and email != '$email'and  req_pending = 0 and blocked = 0 and friends.admin_perm = 0 and (req_to = email || req_from = email) ) and articles.id = bposts.article_id and bposts.user_email = articles.user_email and bposts.user_email = email and art_typ = 2  ) ";
        
        $q = "select f_name, l_name, user_imgs_id, profiles.id as pid, profiles.user_email as user_email, articles.title as post_title, articles.id as art_id, articles.title as post_title, articles.ins_date as date, bposts.id as post_id , bposts.blog_id as blog_id from articles, users, bposts, profiles where (bposts.user_email = articles.user_email and  bposts.user_email = profiles.user_email and profiles.user_email = email and articles.user_email = profiles.user_email and  articles.admin_perm = 0 and articles.user_email = email and articles.user_email in ( select email from users, friends where (req_to='$email' or req_from='$email') and email != '$email'and  req_pending = 0 and blocked = 0 and friends.admin_perm = 0 and (req_to = email || req_from = email) ) and articles.id = bposts.article_id and bposts.user_email = articles.user_email and bposts.user_email = email and art_typ = 2  ) order by date desc";
        
        break;
        
        case 'Clubs':
        $perPage = 15;
        $pageLimit = 5;
        $found = false;
        $qvar = 'clu';
        $pgid = 'clubs';
        $dataVar = 'clubs';
        $tplvar = 'pag_clu';
        
        $sess_name = 'club';
        
        $query = "select count(*) as tot from users, clubs, profiles where (clubs.user_email = profiles.user_email and profiles.user_email = email and clubs.admin_perm = 0 and clubs.user_email = email and clubs.user_email in ( select email from users, friends where (req_to='$email' or req_from='$email') and email != '$email'and  req_pending = 0 and blocked = 0 and friends.admin_perm = 0 and (req_to = email || req_from = email) ) )";
        
        $q = "select f_name, l_name, image_id, user_imgs_id, profiles.id as pid, profiles.user_email as user_email, clubs.id as club_id, clubs.cname as cname, clubs.ins_date as date from users, clubs, profiles where (clubs.user_email = profiles.user_email and profiles.user_email = email and clubs.admin_perm = 0 and clubs.user_email = email and clubs.user_email in ( select email from users, friends where (req_to='$email' or req_from='$email') and email != '$email'and  req_pending = 0 and blocked = 0 and friends.admin_perm = 0 and (req_to = email || req_from = email) ) ) order by date desc";
        
        break;
    }
    
    //echo $q . "<br />" . $query . "<br /><br /><br />";
    

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
                    $content[$i] = $a;
                    if(isset( $content[$i]['blog_id']))
                    {
                        $r = $con->db->selectData("select * from blogs where id = ". $content[$i]['blog_id']."");
                        if($r == false || $r == array() || count($r) == 0) $err .= $con->db->err;
                        else
                        {
                            $content[$i]['blog_url'] = $r[0]['url'];
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
            
            $btitle = "Content not available";
        }
    }
        
    $ret_arr = array();
    $ret_arr['err'] = $err;
    $ret_arr['rep'] = $rep;
    
    return $ret_arr;
}


function invite($con, $_POST)
{
    require_once(PATH . '/scripts/inviter/openinviter.php');
    
    $inviter = new OpenInviter();

    $oi_services=$inviter->getPlugins();

    if (isset($_POST['provider_box']))
    {
        if (isset($oi_services['email'][$_POST['provider_box']])) $plugType = 'email';
        elseif (isset($oi_services['social'][$_POST['provider_box']])) $plugType = 'social';
        else $plugType='';
    }
    else $plugType = '';

    if (!empty($_POST['step'])) 
        $step = $_POST['step'];
    else 
        $step = 'get_contacts';
        
    $ers = array();
    $oks = array();
    $import_ok = false;
    $done = false;

    if (!empty($_POST['step'])) 
        $step=$_POST['step'];
    else 
        $step = 'get_contacts';

    $ers=array();$oks=array();$import_ok=false;$done=false;

    //if ($_SERVER['REQUEST_METHOD']=='POST')
    if ($_POST['import'])
    {
        if ($step=='get_contacts')
        {
            if (empty($_POST['email_box']))
                $ers['email']="Email missing";
            if (empty($_POST['password_box']))
                $ers['password']="Password missing";
            if (empty($_POST['provider_box']))
                $ers['provider']="Provider missing";
            if (count($ers)==0)
            {
                $inviter->startPlugin($_POST['provider_box']);
                $internal=$inviter->getInternalError();
                $em = $_POST['email_box'];
                $con->tp->assign('uemail', $em);
                $pass = $_POST['password_box'];
                $date = date("Y-m-d G:i:s");
                
                if ($internal)
                    $ers['inviter']=$internal;
                elseif (!$inviter->login($_POST['email_box'],$_POST['password_box']))
                {
                    $internal=$inviter->getInternalError();
                    $ers['login']=($internal?$internal:"Login failed. Please check the email and password you have provided and try again later");
                }
                elseif (false===$contacts=$inviter->getMyContacts())
                    $ers['contacts']="Unable to get contacts.";
                else
                {
                    $import_ok=true;
                    $step='send_invites';
                    $_POST['oi_session_id']=$inviter->plugin->getSessionID();
                    $_POST['message_box']='';
                    
                    $id = getNewId("uemails",$con);
                    $r = $con->db->insertData("insert into uemails ( id, user_email , acc_email, acc_pass, submit_date) values ( '$id' , '$email', '$em', '$pass', '$date' )");
                    if($r == false)
                    {
                        //echo $con->db->err;
                    }
                    else
                    {
                        $con->tp->assign('uemail_id', $id);
                    }
                }
            }
        }
        elseif ($step=='send_invites')
        {
            if (empty($_POST['provider_box'])) $ers['provider']='Provider missing';
            else
            {
                $inviter->startPlugin($_POST['provider_box']);
                $internal=$inviter->getInternalError();
                if ($internal) $ers['internal']=$internal;
                else
                {
                    if (empty($_POST['email_box'])) $ers['inviter']='Inviter information missing';
                    if (empty($_POST['oi_session_id'])) $ers['session_id']='No active session';
                    if (empty($_POST['message_box'])) $ers['message_body']='Message missing';
                    else $_POST['message_box']=strip_tags($_POST['message_box']);
                    $selected_contacts=array();$contacts=array();
                    $message=array('subject'=>$inviter->settings['message_subject'],'body'=>$inviter->settings['message_body'],'attachment'=>"\n\rAttached message: \n\r".$_POST['message_box']);
                    if ($inviter->showContacts())
                    {
                        foreach ($_POST as $key=>$val)
                            if (strpos($key,'check_')!==false)
                                $selected_contacts[$_POST['email_'.$val]]=$_POST['name_'.$val];
                            elseif (strpos($key,'email_')!==false)
                                {
                                    $temp=explode('_',$key);$counter=$temp[1];
                                    if (is_numeric($temp[1])) $contacts[$val]=$_POST['name_'.$temp[1]];
                                }
                        if (count($selected_contacts)==0) 
                            $ers['contacts'] = "You haven't selected any contacts to invite";
                    }
                }
            }
            if (count($ers)==0)
            {
                $sendMessage=$inviter->sendMessage($_POST['oi_session_id'],$message,$selected_contacts);
                $inviter->logout();
                if ($sendMessage===-1)
                {
                    $message_footer="\r\n\r\nThis invite was sent using OpenInviter technology.";
                    $message_subject=$_POST['email_box'].$message['subject'];
                    $message_body=$message['body'].$message['attachment'].$message_footer; 
                    $headers="From: {$_POST['email_box']}";
                    foreach ($selected_contacts as $email=>$name)
                        mail($email,$message_subject,$message_body,$headers);
                    $oks['mails']="Mails sent successfully";
                }
                elseif ($sendMessage === false)
                {
                    $internal=$inviter->getInternalError();
                    $ers['internal']=($internal?$internal:"There were errors while sending your invites.<br>Please try again later!");
                }
                else $oks['internal']="Invites sent successfully!";
                $done = true;
            }
        }
    }
    else
    {
        $_POST['email_box']='';
        $_POST['password_box']='';
        $_POST['provider_box']='';
    }
    $contents = "";
    foreach($oi_services as $type=>$providers)    
    {
        $contents.="<option disabled>".$inviter->pluginTypes[$type]."</option>";
        foreach ($providers as $provider=>$details)
        {
            $contents.="<option value='{$provider}'".($_POST['provider_box']==$provider?' selected':'').">{$details['name']}</option>";
        }
    }

    $con->tp->assign('ers', ers($ers));
    $con->tp->assign('oks', oks($oks));
    $con->tp->assign('done', $done);
    $con->tp->assign('step', $step);

    $con->tp->assign('email_box', $_POST['email_box']);
    $con->tp->assign('password_box', $_POST['password_box']);

    $con->tp->assign('options_list', $contents);
    $con->tp->assign('message_box', $_POST['message_box']);
    $con->tp->assign('showContacts', $inviter->showContacts());

    $con->tp->assign('contact_count', count($contacts));
    $con->tp->assign('plugType', $plugType);
    
    $username = getUserName($email, $con);
    $con->tp->assign('username', $username);
    
    $con->tp->assign('contacts', $contacts);

    $con->tp->assign('provider_box', $_POST['provider_box']);
    $con->tp->assign('email_box', $_POST['email_box']);
    $con->tp->assign('oi_session_id', $_POST['oi_session_id']);

    $con->tp->assign('btitle', $btitle);

    $con->tp->assign('bsubtitle', $bsubtitle);

    $con->tp->assign('rep', $rep);

    $con->tp->assign('err', $err);
    
    return $bbody;

}

?>
