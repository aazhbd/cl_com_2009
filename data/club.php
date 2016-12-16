<?php
function club($con, $email, $section,  $id = '', $tmp_id = '')
{
    $rep = "";
    $err = "";
    $btitle = "";
    $bbody = "";
    $bsubtitle = "";
    
    switch($section)
    {
        case 'denyrequest':
        //
        break;
        
        case 'joinrequestlist':
            $btitle = "Club Join Requests";
            $r = $con->db->selectData("select * from cmembers where user_email = '$email' and admin_perm = 0 and status = 0 and club_id in (select id from clubs where status = 0 and admin_perm = 0 and privacy = 2)");
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
                            $club = $t;
                        }
                    }
                    $join_req[$i]['club_name'] = $club['name'];
                    $join_req[$i]['club_id'] = $club['id'];
                    $join_req[$i]['club_img_id'] = $club['club_img_id'];
                    $i++;
                }
                $joinreq_count = $c;
                
            }
            if($joinreq_count > 0) $bsubtitle = "You have club join requests. Please approve your membership to join clubs.";
            
            $con->tp->assign('joinreq_count', $joinreq_count);
            $con->tp->assign('email', $email);
            $con->tp->assign('join_req', $join_req);
            
            $bbody = $con->tp->fetch('clubjoinreq_view.tpl');
            
            $title = "ConveyLive :: Club Join Requests";
            $con->tp->assign('title', $title);
            
            $keys = "Clubs, Join, Friends communicate, share,network,  conveylive";
            $con->tp->assign("keys", $keys);

            $desc = "Send Club Join Requests by Messages and Stay in Touch With Friends. Stay in touch with your friends through conveylive and share your creativity";
            $con->tp->assign("descrip", $desc);
        break;
        
        case 'approve':
            $is_member = false;
            $is_admin = false;
            $is_creator = false;
            
            $r = $con->db->selectData("select id , cname, user_email, image from clubs where admin_perm = 0 and id = $id and status = 0");

            if($r == false || $r == array()) $err .= $con->db->err;
            else
            {
                foreach($r as $c)
                {
                    $club = $c;
                }
                $club_name = $r[0]['name'];

                $club_img_id = $r[0]['club_img_id'];
                
                $is_member = isMember($con, $id, $email);
                
                $is_admin  = isAdmin($con, $id, $email);
                $is_creator = isCreator($con, $id, $email);
            }
            if(!$is_admin)
            {
                $err .= "Sorry, you can not access this page.";
            }
            else
            {
                $r = $con->db->selectData("select admin_perm, email, f_name, l_name from cmembers, users  where id = $tmp_id and club_id = $id and user_email = email");
                
                
                if($r == false || $r == array() || $r == null || count($r) == 0)
                {
                    $err .= $con->db->err;
                }
                else
                {
                    foreach($r as $a)
                    {
                        $mem = $a;
                    }
                    
                    $perm = $r[0]['admin_perm'];
                    if($perm == 0)
                    {
                        $rep .= $mem['f_name'] . " " . $mem['l_name'] ." is already a member of this club";
                        $isvalid = false;
                    }
                    else if($perm == 1)
                    {
                        $isvalid = true;
                    }
                }
                if($isvalid)
                {
                    $r = $con->db->updateData("update cmembers set adin_perm = 0 where id = $tmp_id and club_id = $id");
                    if($r == true)
                    {
                        $rep .= "You have approved the join request of " . $mem['f_name'] . " " . $mem['l_name'] ."";
                    }
                    else
                    {
                        $err .= $con->db->err;
                    }
                }
            }
            $retList = viewClub($con, $email, $id);
            
            $bbody = $retList['bbody'];
            $btitle = $retList['btitle'];
            $bsubtitle = $retList['bsubtitle'];
            $rep .= $retList['rep'];
            $err .= $retList['err'];
        break;
        
        case 'deny':
            $is_member = false;
            $is_admin = false;
            $is_creator = false;
            
            $r = $con->db->selectData("select id , name, user_email, image_id from clubs where admin_perm = 0 and id = $id and status = 0");

            if($r == false || $r == array()) $err .= $con->db->err;
            else
            {
                foreach($r as $c)
                {
                    $club = $c;
                }
                $club_name = $r[0]['name'];

                $club_img_id = $r[0]['image_id'];
                
                $is_member = isMember($con, $id, $email);
                
                $is_admin  = isAdmin($con, $id, $email);
                $is_creator = isCreator($con, $id, $email);
            }
            if(!$is_admin)
            {
                $err .= "Sorry, you can not access this page.";
            }
            else
            {
                $r = $con->db->selectData("select admin_perm, email, f_name, l_name from cmembers, users  where id = $tmp_id and club_id = $id and email = user_email");
                if($r == false || $r == array() || $r == null || count($r) == 0)
                {
                    $err .= $con->db->err;
                }
                else
                {
                    foreach($r as $a)
                    {
                        $mem = $a;
                    }
                    
                    $perm = $r[0]['admin_perm'];
                    if($perm == 0)
                    {
                        $rep .= $mem['f_name'] . " " . $mem['l_name'] ." is already a member of this club";
                        $isvalid = false;
                    }
                    else if($perm == 1)
                    {
                        $isvalid = true;
                    }
                }
                if($isvalid)
                {
                    $r = $con->db->deleteData("delete from cmembers where id = $tmp_id and club_id = $id and admin_perm = 0");
                    if($r == true)
                    {
                        $rep .= "You have denied the join request of " . $mem['f_name'] . " " . $mem['l_name'] ."";
                    }
                    else
                    {
                        $err .= $con->db->err;
                    }
                }
            }
            $retList = viewClub($con, $email, $id);
            
            $bbody = $retList['bbody'];
            $btitle = $retList['btitle'];
            $bsubtitle = $retList['bsubtitle'];
            $rep .= $retList['rep'];
            $err .= $retList['err'];
        break;
        
        case 'topics':
            $is_member = false;
            $is_admin = false;
            $is_creator = false;
            
            $r = $con->db->selectData("select id , cname, user_email, image_id from clubs where admin_perm = 0 and id = $id and status = 0");

            if($r == false || $r == array()) $err .= $con->db->err;
            else
            {
                foreach($r as $c)
                {
                    $club = $c;
                }
                $club_name = $r[0]['cname'];

                $club_img_id = $r[0]['image_id'];
                
                $is_member = isMember($con, $id, $email);
                
                $is_admin  = isAdmin($con, $id, $email);
                $is_creator = isCreator($con, $id, $email);
            }
            
            if(!$is_member)
            {
                $err .= "Sorry, you can not access this page.";
            }
            else
            {
                $query = "select cposts.user_email as user_email, title, media_id, media_type, cposts.id as post_id,  articles.id as aid, f_name, l_name, email, cposts.ins_date as ins_date from cposts, users, articles where club_id = $id and cposts.admin_perm = 0 and media_type = 'Club Post' and cposts.user_email = email and articles.user_email = email and articles.id = media_id and art_typ = 3 order by cposts.ins_date desc";

                $r = $con->db->selectData($query);
                if($r == false || $r == array()) $err .= $con->db->err;
                else
                {
                    $i = 0;
                    foreach($r as $a)
                    {
                        $posts[$i]  = $a;
                        $posts[$i]['pid'] = getPrifileId($a['email'], $con);
                        $posts[$i]['user_imgs_id'] = getProfImgId($a['email'], $con);
                        $i++;
                    } 
                }
            }
            $con->tp->assign("posts", $posts);

            $btitle = $club['cname']." Club - Topic List";
            $bsubtitle = "List of Topics for Discussion";

            $con->tp->assign("is_member", $is_member);
            $con->tp->assign("is_admin", $is_admin);
            $con->tp->assign("is_creator", $is_creator);

            $con->tp->assign('club', $club);
            $bbody = $con->tp->fetch('view_topics.tpl');
            $title = "ConveyLive :: $club_name - Topic List";
            $con->tp->assign('title', $title);
            
            $desc = "$title .View All Topics Of ConveyLive Club. Create Your own Clubs to discuss and share your digital possesions like, Photos, Files and text posts. Browse all the Clubs of conveylive published by users to share,comment and discuss.";
            $con->tp->assign("descrip", $desc);

            $keys = "$club_name, View  Topics posted by members, Add, New Photos, Files, Club, New Clubs, Posts, File, Share, Community, Network, ConveyLive";
            $con->tp->assign("keys", $keys);
        break;
        
        case 'viewmembers':
            $is_member = false;
            $is_admin = false;
            $is_creator = false;

            $r = $con->db->selectData("select id , cname, user_email, image_id from clubs where clubs.admin_perm = 0 and id = $id and status = 0");

            if($r == false || $r == array()) $err .= $con->db->err;
            else
            {
                foreach($r as $c)
                {
                    $club = $c;
                }
                $club_name = $r[0]['name'];
                
                $club_img_id = $r[0]['club_img_id'];
                
                $is_member = isMember($con, $id, $email);
                $is_admin  = isAdmin($con, $id, $email);
                $is_creator = isCreator($con, $id, $email);
            }
            
            if(!$is_member)
            {
                $err .= "Sorry, you can not access this page.";
            }
            else
            {
                $query = "select * from cmembers, users where club_id = $id and cmembers.admin_perm = 0 and status = 0 and user_email = email and ustatus = 1";

                $r = $con->db->selectData($query);
                if($r == false || $r == array()) $err .= $con->db->err;
                else
                {
                    $i = 0;
                    
                    foreach($r as $t)
                    {
                        $members[$i] = $t;
                        
                        $uemail = $members[$i]['user_email'];
                        
                        $query = "select profiles.id as pid , user_imgs_id from profiles where admin_perm = 0 and active = 0 and user_email = '".$uemail."'";

                        $k = $con->db->selectData($query);

                        if($k == false || $k == array() || count($k) == 0) { $err .= $con->db->err; }
                        else
                        {
                            $members[$i]['pid'] = $k[0]['pid'];
                            $members[$i]['user_imgs_id'] = $k[0]['user_imgs_id'];
                        }
                        
                        if($members[$i]['privilege'] == 2)
                        {
                            $members[$i]['rank'] = "Creator";
                        }
                        else if($members[$i]['privilege'] == 1 )
                        {
                            $members[$i]['rank'] = "Admin";
                        }
                        else
                        {
                            $members[$i]['rank'] = "General Member";
                        }
                        $i++;
                    }
                    $btitle = $club['name']." Club - Members";
                    $bsubtitle = "View all members";
                    $con->tp->assign("members", $members);
                    
                    $con->tp->assign("is_member", $is_member);
                    $con->tp->assign("is_admin", $is_admin);
                    $con->tp->assign("is_creator", $is_creator);
                    
                    $con->tp->assign('club', $club);
                    $bbody = $con->tp->fetch('view_mem.tpl');
                }
            }
            $title = "ConveyLive :: $club_name - View Members";
            $con->tp->assign('title', $title);
            
            $desc = "$title .View All Members in ConveyLive Club. Create Your own Clubs to discuss and share your digital possesions like, Photos, Files and text posts. Browse all the Clubs of conveylive published by users to share,comment and discuss.";
            $con->tp->assign("descrip", $desc);

            $keys = "$club_name, View  Members, Add, New Photos, Files, Club, New Clubs, Posts, File, Share, Community, Network, ConveyLive";
            $con->tp->assign("keys", $keys);
        break;
        
        case 'deletefile':
            $is_member = false;
            $is_admin = false;
            
            $file_deleted = false;
            
            $r = $con->db->selectData("select name, user_email, club_img_id, id from clubs where admin_perm = 0 and id = $id and status = 0");

            if($r == false || $r == array()) $err .= $con->db->err;
            else
            {
                $club_name = $r[0]['name'];
                $club_id = $id;
                $club_img_id = $r[0]['image_id'];
                
                foreach($r as $t)
                {
                    $club[] = $t;
                }
                $is_member = isMember($con, $id, $email);
                $is_admin  = isAdmin($con, $id, $email);
                $is_creator = isCreator($con, $id, $email);
            }
            if(!$is_admin)
            {
                $err .= "You do not have access to this page";
            }
            else
            {
                $q = "delete from cposts where club_id = $id and media_id = $tmp_id";
                $r = $con->db->executeNonQuery($q);
                
                if($r == false) $err .= $con->db->err;
                else
                {
                    $q = "select file_path from user_files where club_id = $id and id = $tmp_id";
                    $r = $con->db->executeQuery($q);
                    
                    if($r == false || $r == array() || count($r) == 0 ) $err .= $con->db->err;
                    else
                    {
                        $file_path = $r[0]['file_path'];
                        $path = PATH . "/directories/" . $file_path;
                        
                        $q = "delete from user_files where club_id = $id and id = $tmp_id";
                        $r = $con->db->executeNonQuery($q);
                        
                        if($r == false) $err .= $con->db->err;
                        else
                        {
                            if(file_exists($path))
                            {
                                unlink($path);
                                $file_deleted = true;
                            }
                            else
                            {
                                $err .= "Path do not exist. Contact the administrator for details info";
                            }
                        }
                    }
                }
                
            }
            
            if($file_deleted)
            {
                $rep .= "File has been deleted from club successfully";
            }
            $retList = viewClub($con, $email, $id);
            
            $bbody = $retList['bbody'];
            $btitle = $retList['btitle'];
            $bsubtitle = $retList['bsubtitle'];
            $rep .= $retList['rep'];
            $err .= $retList['err'];
            
            break;
        
        case 'uploadfile':
            $is_member = false;
            $atype = 3;
            
            $r = $con->db->selectData("select cname, user_email, image_id  from clubs where admin_perm = 0 and id = $id and status = 0");

            if($r == false || $r == array()) $err .= $con->db->err;
            else
            {
                $club_name = $r[0]['cname'];
                $club_id = $id;
                $club_img_id = $r[0]['image_id'];
                
                $is_member = isMember($con, $id, $email);
                $is_admin  = isAdmin($con, $id, $email);
                $is_creator = isCreator($con, $id, $email);
            }
            
            if(!$is_member)
            {
                $err .= "You do not have access to this page";
            }
            else
            {
                $category = getCatListDb($con, "File");
                $btitle = "$club_name - Add New File";
                $bsubtitle .= "Upload new files to share with this club";
                $con->tp->assign('club_id', $club_id);
                $con->tp->assign('club_img_id', $club_img_id);
                $con->tp->assign('club_name', $club_name);
                
                $con->tp->assign('email', $email);
                $con->tp->assign('catList', $category);
                $bbody = $con->tp->fetch('upload_file.tpl');
            }
            
            $title = "ConveyLive :: $club_name - New File Upload";
            $con->tp->assign('title', $title);
            
            $desc = "$title .Post New Topic in ConveyLive Club. Create Your own Clubs to discuss and share your digital possesions like, Photos, Files and text posts. Browse all the Clubs of conveylive published by users to share,comment and discuss.";
            $con->tp->assign("descrip", $desc);

            $keys = "$club_name, Members, Add, New Photos, Files, Club, New Clubs, Posts, File, Share, Community, Network, ConveyLive";
            $con->tp->assign("keys", $keys);
        break;
        
        case 'deletecom':
            //Delete comment
            $query = "delete from comments where id = $tmp_id";
            $r = $con->db->executeNonQuery($query);
            if($r == false) $err .= $con->db->err;
            else
            {
                $rep .= "Post Reply has been deleted";
            }
            //Delete comment
            $btitle = "Comment Deleted";
            $bbody = "Click <a href='".URL."/clubs/viewpost/$id'>here</a> to go back to topic's page";
                    
            $title = "Delete Comment - ".$club[0]['name']." club :: ConveyLive";
            $con->tp->assign('title', $title);
                    
            $desc = "$title .Post New Topic in ConveyLive Club. Create Your own Clubs to discuss and share your digital possesions like, Photos, Files and text posts. Browse all the Clubs of conveylive published by users to share,comment and discuss.";
            $con->tp->assign("descrip", $desc);

            $keys = "Delete Comment, Members, Add, New Photos, Files, Club, New Clubs, Posts, File, Share, Community, Network, ConveyLive";
            $con->tp->assign("keys", $keys);
            
            break;
        
        case 'deletepost':        
            $is_member = false;
            $is_admin = flase;
            $r = $con->db->selectData("select name, user_email, club_img_id, id from clubs where admin_perm = 0 and id = $id and status = 0");

            if($r == false || $r == array()) $err .= $con->db->err;
            else
            {
                $club_name = $r[0]['name'];
                $club_id = $id;
                $club_img_id = $r[0]['club_img_id'];
                
                foreach($r as $t)
                {
                    $club[] = $t;
                }
                
                $r = $con->db->selectData("select * from cmembers where admin_perm = 0 and club_id = $id and status = 0 and user_email = '$email'");
                if($r == false || $r == array()) $err .= $con->db->err;
                else
                {
                    if($r[0]['privilege'] == 2 && $r[0]['user_email'] == $email) 
                    {
                        $is_member = true;
                        $is_admin = true;
                        $is_creator = true;
                    }
                    if($r[0]['user_email'] == $email && ($r[0]['privilege'] == 1)) 
                    {
                        $is_member = true;
                        $is_admin = true;
                    }
                }
            }
            if(!$is_admin)
            {
                $err .= "You do not have access to this page";
            }
            else
            {
                //Delete post
                $query = "delete from comments where media_id = $tmp_id and mtype = 'Club Posts'";
                $r = $con->db->executeNonQuery($query);
                if($r == false) $err .= $con->db->err;
                else
                {
                    $rep .= "Post Reply has been deleted";
                    
                    $query = "delete from articles where id = $tmp_id and art_typ = 3";
                    $r = $con->db->executeNonQuery($query);
                    if($r == false) $err .= $con->db->err;
                    else
                    {
                        $rep .= "Post Article has been deleted";
                        $query = "delete from cposts where media_id = $tmp_id ";
                        $r = $con->db->executeNonQuery($query);
                        if($r == false) $err .= $con->db->err;
                        else
                        {
                            $rep .= "Club Post has been deleted successfully";
                        }
                    }
                }
                //Delete post
                $query = "select * from cmembers, users where club_id = $id and admin_perm = 0 and status = 0 and user_email = email";
                //echo $query;
                $r = $con->db->selectData($query);
                if($r == false || $r == array()) $err .= $con->db->err;
                else
                {
                    $i = 0;
                    
                    foreach($r as $t)
                    {
                        $members[$i] = $t;
                        
                        $uemail = $members[$i]['user_email'];
                        $query = "select profiles.id as pid , user_imgs_id from profiles where admin_perm = 0 and active = 0 and user_email = '".$uemail."'";

                        $k = $con->db->selectData($query);

                        if($k == false || $k == array() || count($k) == 0) { $err .= $con->db->err; }
                        else
                        {
                            $members[$i]['pid'] = $k[0]['pid'];
                            $members[$i]['user_imgs_id'] = $k[0]['user_imgs_id'];
                        }
                        
                        if($members[$i]['privilege'] == 2)
                        {
                            $members[$i]['rank'] = "Creator";
                        }
                        else if($members[$i]['privilege'] == 1 )
                        {
                            $members[$i]['rank'] = "Admin";
                        }
                        else
                        {
                            $members[$i]['rank'] = "General Member";
                        }
                        $i++;
                    }
                    $btitle = $club[0]['name']." Club - Edit Members";
                    $bsubtitle = "Change member settings for the club members";
                    $con->tp->assign("members", $members);
                    
                    $con->tp->assign("is_member", $is_member);
                    $con->tp->assign("is_admin", $is_admin);
                    $con->tp->assign("is_creator", $is_creator);
                    
                    $con->tp->assign('club', $club[0]);
                    $bbody = $con->tp->fetch('edit_mem.tpl');
                }
            }
            $title = "Edit Post - ".$club[0]['name']." club :: ConveyLive";
            $con->tp->assign('title', $title);
            
            $desc = "$title .Post New Topic in ConveyLive Club. Create Your own Clubs to discuss and share your digital possesions like, Photos, Files and text posts. Browse all the Clubs of conveylive published by users to share,comment and discuss.";
            $con->tp->assign("descrip", $desc);

            $keys = $club[0]['name'].", Members, Add, New Photos, Files, Club, New Clubs, Posts, File, Share, Community, Network, ConveyLive";
            $con->tp->assign("keys", $keys);
        break;
        
        case 'promotemember':
        
            $is_member = false;
            $is_admin = flase;
            $r = $con->db->selectData("select name, user_email, club_img_id, id from clubs where admin_perm = 0 and id = $id and status = 0");

            if($r == false || $r == array()) $err .= $con->db->err;
            else
            {
                $club_name = $r[0]['name'];
                $club_id = $id;
                $club_img_id = $r[0]['club_img_id'];
                foreach($r as $t)
                {
                    $club[] = $t;
                }
                
                $r = $con->db->selectData("select * from cmembers where admin_perm = 1 and club_id = $id and status = 0 and user_email = '$email'");
                if($r == false || $r == array()) $err .= $con->db->err;
                else
                {
                    if($r[0]['privilege'] == 2 && $r[0]['user_email'] == $email) 
                    {
                        $is_member = true;
                        $is_admin = true;
                        $is_creator = true;
                    }
                    if($r[0]['user_email'] == $email && ($r[0]['privilege'] == 1)) 
                    {
                        $is_member = true;
                        $is_admin = true;
                    }
                }
            }
            if(!$is_admin)
            {
                $err .= "You do not have access to this page";
            }
            else
            {
                //Promote to admin
                $query = "update cmembers set privilege = 1 where id = $tmp_id";
                $r = $con->db->executeNonQuery($query);
                if($r == false) $err .= $con->db->err;
                else
                {
                    $rep = "Selected member has been promoted to admin";
                }
                //Promote to admin  end
                $query = "select * from cmembers, users where club_id = $id and admin_perm = 0 and status = 0 and user_email = email ";
                //echo $query;
                $r = $con->db->selectData($query);
                if($r == false || $r == array()) $err .= $con->db->err;
                else
                {
                    $i = 0;
                    
                    foreach($r as $t)
                    {
                        $members[$i] = $t;
                        
                        $uemail = $members[$i]['user_email'];
                        $query = "select profiles.id as pid , user_imgs_id from profiles where admin_perm = 0 and active = 0 and user_email = '".$uemail."'";

                        $k = $con->db->selectData($query);

                        if($k == false || $k == array() || count($k) == 0) { $err .= $con->db->err; }
                        else
                        {
                            $members[$i]['pid'] = $k[0]['pid'];
                            $members[$i]['user_imgs_id'] = $k[0]['user_imgs_id'];
                        }
                        
                        if($members[$i]['privilege'] == 2)
                        {
                            $members[$i]['rank'] = "Creator";
                        }
                        else if($members[$i]['privilege'] == 1 )
                        {
                            $members[$i]['rank'] = "Admin";
                        }
                        else
                        {
                            $members[$i]['rank'] = "General Member";
                        }
                        $i++;
                    }
                    $btitle = $club[0]['name']." Club - Edit Members";
                    $bsubtitle = "Change member settings for the club members";
                    $con->tp->assign("members", $members);
                    
                    $con->tp->assign("is_member", $is_member);
                    $con->tp->assign("is_admin", $is_admin);
                    $con->tp->assign("is_creator", $is_creator);
                    
                    $con->tp->assign('club', $club[0]);
                    $bbody = $con->tp->fetch('edit_mem.tpl');
                }
            }
            $title = "Edit Members - ".$club[0]['name']." club :: ConveyLive";
            $con->tp->assign('title', $title);
            
            $desc = "$title .Post New Topic in ConveyLive Club. Create Your own Clubs to discuss and share your digital possesions like, Photos, Files and text posts. Browse all the Clubs of conveylive published by users to share,comment and discuss.";
            $con->tp->assign("descrip", $desc);

            $keys = $club[0]['name'].", Members, Add, New Photos, Files, Club, New Clubs, Posts, File, Share, Community, Network, ConveyLive";
            $con->tp->assign("keys", $keys);
        
        break;
        
        case 'deletemember':
            $is_member = false;
            $is_admin = flase;
            $r = $con->db->selectData("select name, user_email, club_img_id, id from clubs where admin_perm = 0 and id = $id and status = 0");

            if($r == false || $r == array()) $err .= $con->db->err;
            else
            {
                $club_name = $r[0]['name'];
                $club_id = $id;
                $club_img_id = $r[0]['club_img_id'];
                
                foreach($r as $t)
                {
                    $club[] = $t;
                }
                
                $r = $con->db->selectData("select * from cmembers where admin_perm = 0 and club_id = $id and status = 0 and user_email = '$email'");
                if($r == false || $r == array()) $err .= $con->db->err;
                else
                {
                    if($r[0]['privilege'] == 2 && $r[0]['user_email'] == $email) 
                    {
                        $is_member = true;
                        $is_admin = true;
                        $is_creator = true;
                    }
                    if($r[0]['user_email'] == $email && ($r[0]['privilege'] == 1)) 
                    {
                        $is_member = true;
                        $is_admin = true;
                    }
                }
            }
            if(!$is_admin)
            {
                $err .= "You do not have access to this page";
            }
            else
            {
                //Member Delete
                $query = "delete from cmembers where id = $tmp_id";
                $r = $con->db->executeNonQuery($query);
                if($r == false) $err .= $con->db->err;
                else
                {
                    $rep = "Selected member has been removed from club but his/her club posts or images will still be with the club";
                }
                //Member Delete  end
                $query = "select * from cmembers, users where club_id = $id and admin_perm = 0 and status = 0 and user_email = email";
                //echo $query;
                $r = $con->db->selectData($query);
                if($r == false || $r == array()) $err .= $con->db->err;
                else
                {
                    $i = 0;
                    
                    foreach($r as $t)
                    {
                        $members[$i] = $t;
                        
                        $uemail = $members[$i]['user_email'];
                        $query = "select profiles.id as pid , user_imgs_id from profiles where admin_perm = 0 and active = 0 and user_email = '".$uemail."'";

                        $k = $con->db->selectData($query);

                        if($k == false || $k == array() || count($k) == 0) { $err .= $con->db->err; }
                        else
                        {
                            $members[$i]['pid'] = $k[0]['pid'];
                            $members[$i]['image_id'] = $k[0]['image_id'];
                        }
                        
                        if($members[$i]['privilege'] == 2)
                        {
                            $members[$i]['rank'] = "Creator";
                        }
                        else if($members[$i]['privilege'] == 1 )
                        {
                            $members[$i]['rank'] = "Admin";
                        }
                        else
                        {
                            $members[$i]['rank'] = "General Member";
                        }
                        $i++;
                    }
                    $btitle = $club[0]['name']." Club - Edit Members";
                    $bsubtitle = "Change member settings for the club members";
                    $con->tp->assign("members", $members);
                    
                    $con->tp->assign("is_member", $is_member);
                    $con->tp->assign("is_admin", $is_admin);
                    $con->tp->assign("is_creator", $is_creator);
                    
                    $con->tp->assign('club', $club[0]);
                    $bbody = $con->tp->fetch('edit_mem.tpl');
                }
            }
            $title = "Edit Members - ".$club[0]['name']." club :: ConveyLive";
            $con->tp->assign('title', $title);
            
            $desc = "$title .Post New Topic in ConveyLive Club. Create Your own Clubs to discuss and share your digital possesions like, Photos, Files and text posts. Browse all the Clubs of conveylive published by users to share,comment and discuss.";
            $con->tp->assign("descrip", $desc);

            $keys = $club[0]['name'].", Members, Add, New Photos, Files, Club, New Clubs, Posts, File, Share, Community, Network, ConveyLive";
            $con->tp->assign("keys", $keys);
        break;
        
        case 'editmembers':
            $is_member = false;
            $is_admin = flase;
            $q = "select cname, user_email, image_id, id from clubs where admin_perm = 0 and id = $id and status = 0";

            $r = $con->db->selectData($q);

            
            if($r == false || $r == array()) $err .= $con->db->err;
            else
            {
                $club_name = $r[0]['cname'];
                $club_id = $id;
                $club_img_id = $r[0]['image_id'];
                foreach($r as $t)
                {
                    $club[] = $t;
                }
                
                $r = $con->db->selectData("select * from cmembers where admin_perm = 0 and club_id = $id and status = 0 and user_email = '$email'");
                if($r == false || $r == array()) $err .= $con->db->err;
                else
                {
                    if($r[0]['privilege'] == 2 && $r[0]['user_email'] == $email) 
                    {
                        $is_member = true;
                        $is_admin = true;
                        $is_creator = true;
                    }
                    if($r[0]['user_email'] == $email && ($r[0]['privilege'] == 1)) 
                    {
                        $is_member = true;
                        $is_admin = true;
                    }
                }
            }
            if(!$is_admin)
            {
                $err .= "You do not have access to this page";
            }
            else
            {
                $query = "select * from cmembers, users where club_id = $id and cmembers.admin_perm = 0 and status = 0 and user_email = email";
                //echo $query;
                $r = $con->db->selectData($query);
                if($r == false || $r == array()) $err .= $con->db->err;
                else
                {
                    $i = 0;
                    
                    foreach($r as $t)
                    {
                        $members[$i] = $t;
                        
                        $uemail = $members[$i]['user_email'];
                        $query = "select profiles.id as pid , user_imgs_id from profiles where admin_perm = 0 and active = 0 and user_email = '".$uemail."'";

                        $k = $con->db->selectData($query);

                        if($k == false || $k == array() || count($k) == 0) { $err .= $con->db->err; }
                        else
                        {
                            $members[$i]['pid'] = $k[0]['pid'];
                            $members[$i]['user_imgs_id'] = $k[0]['user_imgs_id'];
                        }
                        
                        if($members[$i]['privilege'] == 2)
                        {
                            $members[$i]['rank'] = "Creator";
                        }
                        else if($members[$i]['privilege'] == 1 )
                        {
                            $members[$i]['rank'] = "Admin";
                        }
                        else
                        {
                            $members[$i]['rank'] = "General Member";
                        }
                        $i++;
                    }
                    $btitle = $club[0]['cname']." Club - Edit Members";
                    $bsubtitle = "Change member settings for the club members";
                    $con->tp->assign("members", $members);
                    
                    $con->tp->assign("is_member", $is_member);
                    $con->tp->assign("is_admin", $is_admin);
                    $con->tp->assign("is_creator", $is_creator);
                    
                    $con->tp->assign('club', $club[0]);
                    $bbody = $con->tp->fetch('edit_mem.tpl');
                }
            }
            $title = "Edit Members - ".$club[0]['name']." club :: ConveyLive";
            $con->tp->assign('title', $title);
            
            $desc = "$title .Post New Topic in ConveyLive Club. Create Your own Clubs to discuss and share your digital possesions like, Photos, Files and text posts. Browse all the Clubs of conveylive published by users to share,comment and discuss.";
            $con->tp->assign("descrip", $desc);

            $keys = "Members, Add, New Photos, Files, Club, New Clubs, Posts, File, Share, Community, Network, ConveyLive";
            $con->tp->assign("keys", $keys);
        break;
        
        case 'addphotos':
            $is_member = false;
            $atype = 3;
            
            $r = $con->db->selectData("select cname, user_email, image_id from clubs where admin_perm = 0 and id = $id and status = 0");

            if($r == false || $r == array()) $err .= $con->db->err;
            else
            {
                $club_name = $r[0]['cname'];
                $club_id = $id;
                $club_img_id = $r[0]['image_id'];
                
                $r = $con->db->selectData("select * from cmembers where admin_perm = 0 and club_id = $id and status = 0 and user_email = '$email'");
                if($r == false || $r == array()) $err .= $con->db->err;
                else
                {
                    if($r[0]['user_email'] == $email)
                        $is_member = true;
                }
            }
            if(!$is_member)
            {
                $err .= "You do not have access to this page";
            }
            else
            {
                $btitle = "$club_name - Add new Photos";
                $bsubtitle .= "Post new photos for this club";
                $con->tp->assign('club_id', $club_id);
                $con->tp->assign('club_img_id', $club_img_id);
                $con->tp->assign('club_name', $club_name);
                
                $con->tp->assign('email', $email);
                $bbody = $con->tp->fetch('club_photos.tpl');
            }

            $title = $club_name ."Club - Add photos :: ConveyLive";
            $con->tp->assign('title', $title);
            
            $desc = "$title Post New Topic in ConveyLive Club. Create Your own Clubs to discuss and share your digital possesions like, Photos, Files and text posts. Browse all the Clubs of conveylive published by users to share,comment and discuss.";
            $con->tp->assign("descrip", $desc);

            $keys = "Add, New Photos, Club, New Clubs, Posts, File, Share, Community, Network, ConveyLive";
            $con->tp->assign("keys", $keys);
        break;
        
        case 'viewpost':
            $retList = viewPost($con, $email, $id);
            
            $bbody = $retList['bbody'];
            $btitle = $retList['btitle'];
            $bsubtitle = $retList['bsubtitle'];
            $rep = $retList['rep'];
            $err = $retList['err'];
        break;
        
        case 'leave':
            $query = "delete from cmembers where user_email = '$email' and club_id = $id";
            $r = $con->db->executeNonQuery($query);
            if($r == true)
            {
                $rep = "You have left this club succesfullly";
            }
            else
            {
                $err .= $con->db->err;
            }
            $retList = browse_clubs($con, $email, $id, 'order by cllubs.admin_perm desc', '');
            
            $bbody = $retList['bbody'];
            $btitle = $retList['btitle'];
            $bsubtitle = $retList['bsubtitle'];
            $rep = $retList['rep'];
            $err = $retList['err'];
        break;
        
        case 'edit':
            $btitle = "Edit club information";
            $action = "update";
            $r = $con->db->selectData("select * from clubs where id = $id and admin_perm = 0");
            if($r == false || $r == array()) $err .= $con->db->err;
            else
            {
                foreach($r as $s)
                {
                    $club = $s;
                }
            }
            
            $catList = getCatListDb($con, "Club");
            
            $con->tp->assign('club', $club);
            $con->tp->assign('action', $action);
            $con->tp->assign('email', $email);
            $con->tp->assign('catList', $catList);
            $bbody = $con->tp->fetch('edit_club.tpl');
            
            $title = "Edit Club - ".$club['name']." :: conveylive.com";
            $con->tp->assign('title', $title);
            
            $desc = "$title - New Topic. Post New Topic in ConveyLive Club. Create Your own Clubs to discuss and share your digital possesions like, Photos, Files and text posts. Browse all the Clubs of conveylive published by users to share,comment and discuss.";
            $con->tp->assign("descrip", $desc);

            $keys = $club['name'] .", club, New Topic, Send, essage, New Clubs, Posts, File, Share, Community, Network, ConveyLive";
            $con->tp->assign("keys", $keys);
        break;
        
        case 'delete':
            $is_member = false;
            
            $r = $con->db->selectData("select cname, user_email, image_id from clubs where admin_perm = 0 and id = $id and status = 0 and user_email = '$email'");

            if($r == false || $r == array()) $err .= $con->db->err;
            else
            {
                $club_name = $r[0]['name'];
                $club_id = $id;
                $club_img_id = $r[0]['image_id'];
                
                $r = $con->db->selectData("select * from cmembers where admin_perm = 0 and club_id = $id and status = 0 and user_email = '$email'");
                if($r == false || $r == array()) $err .= $con->db->err;
                else
                {
                    if($r[0]['user_email'] == $email)
                        $is_member = true;
                }
            }
            if(!$is_member)
            {
                $err .= "You do not access to this page";
            }
            else
            {
                $query = "update contstats set admin_perm = 1 where media_id = $club_id and media_type = 'Club'";
                $r = $con->db->executeNonQuery($query);
                if($r == true)
                {
                    $query = "update comments set admin_perm = 1 where mtype = 'Club Posts' and media_id in ( select id from cposts where club_id = $id and media_type = 'Club Posts' )";
                    $r = $con->db->executeNonQuery($query);
                    if($r == true)
                    {
                        //$rep .= "All comments of posts for this club deleted";
                        
                        $query = "update articles set admin_perm = 1 where art_typ = 3 and id in ( select media_id from cposts where club_id = $id and media_type = 'Club Post' )";
                        $r = $con->db->executeNonQuery($query);
                        if($r == true)
                        {
                            //$rep .= "All topics for this club deleted";
                            
                            $query = "update albums set admin_perm = 1 where id in ( select media_id from cposts where club_id = $id and media_type = 'Club Album' )";
                            $r = $con->db->executeNonQuery($query);
                            if($r == true)
                            {
                            
                                $query = "update images set admin_perm = 1 where album_id in ( select media_id from cposts where club_id = $id and media_type = 'Club Album')";
                                $r = $con->db->executeNonQuery($query);
                                if($r == true)
                                {
                                    //$rep .= "All Images for this club deleted";    
                                    $query = "update cposts set admin_perm = 1 where club_id = $id and media_type = 'Club Post'";
                                    $r = $con->db->executeNonQuery($query);
                                    if($r == true)
                                    {
                                        //$rep .= "All cposts for this club deleted";
                                        
                                        $query = "update cmembers set admin_perm = 1 where club_id = $id";
                                        $r = $con->db->executeNonQuery($query);
                                        if($r == true)
                                        {
                                            //$rep .= "All memebers for this club deleted";
                                            
                                            $query = "update clubs set admin_perm = 1 where id = $id ";
                                            $r = $con->db->executeNonQuery($query);
                                            if($r == true)
                                            {
                                                $rep .= "Club has been deleted";
                                            }
                                            else
                                            {
                                                $err .= "Club Delete Error: ".$con->db->err;
                                            }
                                        }
                                        else
                                        {
                                            $err .= "Club members Delete Error: ".$con->db->err;
                                        }
                                    }
                                    else
                                    {
                                        $err .= "Club Post Delete Error: ".$con->db->err;
                                    }
                                }
                                else
                                {
                                    $err .= "Club Photos Delete Error: ".$con->db->err;
                                }
                            }
                            else
                            {
                                $err .= "Club Album Delete Error: ".$con->db->err;
                            }
                        }
                        else
                        {
                            $err .= "Club Topics Delete Error: ".$con->db->err;
                        }
                    }
                    else
                    {
                        $err .= "Club Post Comments Delete Error: ".$con->db->err;
                    }
                }
                else
                {
                    $err .= "Club Content Status Delete Error: ".$con->db->err;
                }                
            }
            
            $retList = browse_clubs($con, $email, $id, 'order by clubs.ins_date desc', '');
            
            $bbody = $retList['bbody'];
            $btitle = $retList['btitle'];
            $bsubtitle = $retList['bsubtitle'];
            $rep = $retList['rep'];
            $err = $retList['err'];
        break;
        
        case 'newtopic':
            $is_member = false;
            $atype = 3;
            
            $r = $con->db->selectData("select cname, user_email, image_id from clubs where admin_perm = 0 and id = $id and status = 0");

            if($r == false || $r == array()) $err .= $con->db->err;
            else
            {
                $club_name = stripslashes($r[0]['cname']);
                $club_id = $id;
                $club_img_id = $r[0]['image_id'];
                
                $r = $con->db->selectData("select * from cmembers where admin_perm = 0 and club_id = $id and status = 0 and user_email = '$email'");
                if($r == false || $r == array()) $err .= $con->db->err;
                else
                {
                    if($r[0]['user_email'] == $email)
                        $is_member = true;
                }
            }
            if(!$is_member)
            {
                $err .= "You do not access to this page";
            }
            else
            {
                $btitle = "$club_name - New Topic";
                $bsubtitle .= "Post your new topic for the club";
                $con->tp->assign('club_id', $club_id);
                $con->tp->assign('club_img_id', $club_img_id);
                $con->tp->assign('club_name', $club_name);
                $con->tp->assign('atype', $atype);
                $con->tp->assign('email', $email);
                $bbody = $con->tp->fetch('club_topic.tpl');
            }
            
            $title = "ConveyLive :: New Club Topic";
            $con->tp->assign('title', $title);
            
            $desc = "$club_name - New Topic. Post New Topic in ConveyLive Club. Create Your own Clubs to discuss and share your digital possesions like, Photos, Files and text posts. Browse all the Clubs of conveylive published by users to share,comment and discuss.";
            $con->tp->assign("descrip", $desc);

            $keys = "$club_name , club, New Topic, Send, essage, New Clubs, Posts, File, Share, Community, Network, ConveyLive";
            $con->tp->assign("keys", $keys);
        break;
        
        case 'invite':
            $is_member = false;
            $r = $con->db->selectData("select cname, user_email, id, image_id, privacy from clubs where admin_perm = 0 and id = $id and status = 0");

            if($r == false || $r == array()) $err .= $con->db->err;
            else
            {
                foreach($r as $a)
                {
                    $club = $a;
                }
                $club_name = $r[0]['cname'];
                $club_id = $id;
                if($club['privacy'] == 0)   $clubType = "open";
                if($club['privacy'] == 1)   $clubType = "closed";
                if($club['privacy'] == 2)   $clubType = "secret";
                
                $is_member = isMember($con,$id, $email);
            }
            if(!$is_member)
            {
                $err .= "You do not have access to this page";
            }
            else
            {
                $r = $con->db->selectData("select * from friends, users where (req_from = '$email' or req_to = '$email') and req_pending = 0 and blocked = 0 and friends.admin_perm = 0 and email != '$email' and (req_from = email or req_to = email ) ");
                
                if($r == false || $r == array()) 
                {
                    $err .= $con->db->err;
                    $friends = null;
                }
                else
                {
                    $i = 0;
                    $mem = array();
                    foreach($r as $f)
                    {
                        $friends[$i] = $f;
                        $i++;
                    }
                }
            }
            $btitle .= "Invite friends to join ". $club_name;
            $bsubtitle .= "Invite your friends to join";
            $con->tp->assign('friendList', $friends);
            $con->tp->assign('club_id', $id);
            $con->tp->assign('club_type', $clubType);
            
            $con->tp->assign('club_name', $club_name);
            $con->tp->assign('club', $club);
            $bbody = $con->tp->fetch('invite_club.tpl');
            $title = "ConveyLive :: Invite Friends";
            $con->tp->assign('title', $title);
            
            $desc = "Invite Friends to ConveyLive. Create Your own Clubs to discuss and share your digital possesions like, Photos, Files and text posts. Browse all the Clubs of conveylive published by users to share,comment and discuss.";
            $con->tp->assign("descrip", $desc);

            $keys = "Invite Friends , Club, Message, New Clubs, Posts, File, Share, Community, Network, ConveyLive";
            $con->tp->assign("keys", $keys);
        break;
        
        case 'join':
            $is_member = false;
            $notjoined = true;
            $is_member = isMember($con, $id, $email);
            
            if($is_member == false)
            {
                $r = $con->db->selectData("select * from clubs where admin_perm = 0 and id = $id and status = 0");
                if($r == false || $r == array()) $err .= $con->db->err;
                else
                {
                    $club = $r[0];
                    
                    if($club['privacy'] == 0)   $clubType = "open";
                    if($club['privacy'] == 1)   $clubType = "closed";
                    if($club['privacy'] == 2)   $clubType = "secret";
                }
                if($clubType == "closed")
                {
                    $r = $con->db->selectData("select * from cmembers, users where club_id = $id and user_email = '$email' and email = user_email and status = 0");
                    if($r == false || $r == array() || $r == null) 
                    {
                        $err .= $con->db->err;
                        $notjoined = true;
                    }
                    else if(count($r) > 0)
                    {
                        foreach($r as $a)
                        {
                            $joinList = $a;
                        }
                        $notjoined = false;
                    }
                }
                
                if($notjoined == true)
                {
                    if($clubType == "open" || $clubType == "closed")
                    {
                        $table = "cmembers";
                        $join_date =  date("Y-m-d H:i:s");
                        $status = 0;
                        
                        if($email == $club['user_email']) $privilege = 2;
                        else $privilege = 0;
                        
                        if($clubType == "open")
                        {
                            $permission = 0;
                            $status = 0;
                        }
                        else if($clubType == "closed")
                        {
                            $permission = 0;
                            $status = 1;
                        }
                        $ins_date = date("Y-m-d G:i:s");
                        $mem_id = getNewId($table, $con);
                        $fields = array("id","user_email", "club_id", "join_date", "privilege", "admin_perm", "status", "ins_date", "upd_date");
                        $values = array("'".$mem_id."'", "'".$email."'", "'".$id."'", "'".$join_date."'","'".$privilege."'", "'".$permission."'", "'".$status."'", "'".$ins_date."'", "'".$ins_date."'");

                        $f = implode(",", $fields);
                        $v = implode(",", $values);

                        $query1 = "insert into $table ( $f ) values ( $v )";
                        $i = $con->db->executeNonQuery($query1);
                        if($i == true)
                        {
                            $mem_ins = true;
                        }
                        $err .= $con->db->err;
                        
                        if($mem_ins && $clubType == 'open')
                        {
                            $rep = "You are now a member of ". $club['cname'];
                        }
                        else if($mem_ins && $clubType == 'closed')
                        {
                            $rep = "Your join request to ". $club['name'] ." is sent to its admin for approval. After approval you'll be a member of this group";
                        }
                        else
                        {
                            $err .= "Your join request failed.";
                        }
                    }
                    else if($clubType == "secret")
                    {
                        $r = $con->db->selectData("select * from cmembers, users where club_id = $id and user_email = '$email' and email = user_email and clubs.admin_perm = 0 and status = 0");
                        if($r == false || $r == array() || $r == null) 
                        {
                            $err .= $con->db->err;
                            $rep .= "Sorry ! You do not have access to this page";
                        }
                        else if(count($r) > 0)
                        {
                            foreach($r as $a)
                            {
                                $mem = $a;
                            }
                            if(count($mem) > 0)
                            {
                                $query = "update cmembers set admin_perm = 0 where user_email = '$email' and club_id = $id and admin_perm = 0";
                                $i = $con->db->executeNonQuery($query);
                                if($i == true)
                                {
                                    $mem_upd = true;
                                }
                                $err .= $con->db->err;
                                
                                if($mem_upd)
                                {
                                    $rep .= "You are now a member of ". $club['cname'];
                                }
                                else
                                {
                                    $rep .= "Failed to approve your join response. Please try again";
                                }
                            }
                        }                    
                    }
                    else
                    {
                        $rep .= "Sorry ! You do not have access to this page";
                    }
                }
                else
                {
                    $rep .= "You have already sent your request to join this club. Please wait before your request is approved by the admin. You can also send the admin personal message";
                }
            }
            else
            {
                $rep = "You are already a member of this club";
            }
            $retList = viewClub($con, $email, $id);
            
            $bbody = $retList['bbody'];
            $btitle = $retList['btitle'];
            $bsubtitle = $retList['bsubtitle'];
            $rep .= $retList['rep'];
            $err .= $retList['err'];
        break;
           
        case 'view':
            $retList = viewClub($con, $email, $id);
            
            $bbody = $retList['bbody'];
            $btitle = $retList['btitle'];
            $bsubtitle = $retList['bsubtitle'];
            //$rep = $retList['rep'];
            //$err = $retList['err'];
        break;
        
        case 'clubmessage':
        
            $is_member = false;
            $is_admin = false;
            $is_creator = false;
            
            $r = $con->db->selectData("select id , cname, user_email, image_id from clubs where admin_perm = 0 and id = $id and status = 0");

            if($r == false || $r == array()) $err .= $con->db->err;
            else
            {
                foreach($r as $c)
                {
                    $club = $c;
                }
                $club_name = $r[0]['cname'];

                $club_img_id = $r[0]['image_id'];
                
                $is_member = isMember($con, $id, $email);
                
                $is_admin  = isAdmin($con, $id, $email);
                $is_creator = isCreator($con, $id, $email);
            }
            if(!$is_admin)
            {
                $err .= "Sorry, you can not access this page.";
            }
            else
            {
                $btitle = "Club Message";
                
                $title = "conveylive.com :: Club Message";
                $con->tp->assign('title', $title);
                
                $bsubtitle = "Send a Club Message to all members";
                $is_member = false;
                
                $my_uid = getUserId($email, $con);
                
                $r = $con->db->selectData("select * from cmembers, users where cmembers.admin_perm = 0 and club_id = $id and status = 0 and user_email = email and uid != $my_uid");
                
                if($r == false || $r == array()) $err .= $con->db->err;
                else
                {
                    if($r[0]['user_email'] == $email)
                        $is_member = true;
                    $i = 0;
                    foreach($r as $s)
                    {
                        $members[] = $s;
                        $list[] = $s['f_name'] ." ". $s['l_name'];
                        $idlist[] = $s['uid'];
                    }
                }

                $name_list = implode(",", $list);
                $id_list = implode(",", $idlist);
                
                $con->tp->assign('name_list', $name_list);
                
                $con->tp->assign('id_list', $id_list);
                $con->tp->assign('email', $email);
                $con->tp->assign('club', $club);
                $bbody = $con->tp->fetch('club_message.tpl');
            }
            
            $desc = "Send Club Message in ConveyLive. Create Your own Clubs to discuss and share your digital possesions like, Photos, Files and text posts. Browse all the Clubs of conveylive published by users to share,comment and discuss.";
            $con->tp->assign("descrip", $desc);

            $keys = "Send, Club, Message, New Clubs, Posts, File, Share, Community, Network, ConveyLive";
            $con->tp->assign("keys", $keys);
        break;
                
        case 'new':
            $btitle = "Publish New Club";
            $bsubtitle = "Create a new club and discuss topics of your interest";
            $action = "insert";
            $con->tp->assign('action', $action);
            $con->tp->assign('email', $email);
            
            $catList = getCatListDb($con, "Club");
            
            $con->tp->assign('catList', $catList);
            $bbody = $con->tp->fetch('create_club.tpl');
            
            $title = "conveylive.com :: New Club";
            $con->tp->assign('title', $title);
            
            $desc = "Create Your own Clubs to discuss and share your digital possesions like, Photos, Files and text posts. Browse all the Clubs of conveylive published by users to share,comment and discuss.";
            $con->tp->assign("descrip", $desc);

            $keys = "New Clubs, Posts, File, Share, Community, Network, ConveyLive";
            $con->tp->assign("keys", $keys);
        
        break;

        case 'catbrowse':
            $sId = str_replace("_"," ", $id);
            $catList = getCatListDb($con, "Club");
            
            $selCat = "";
            foreach($catList as $cat)
            {
                if(trim($cat['cname']) == trim($sId) )
                {
                    $selCat = $cat['id'];
                    $selCatName = $cat['cname'];
                    break;
                }
            }

            if($selCat == "")
            {
                 $err = "Sorry, this category do not exist";
            }
            else
            {
                $con->tp->assign('topicHead', $selCatName);
                if(trim($tmp_id) == "self")
                {
                    $retList = browse_clubs($con, $email, $id, 'order by clubs.ins_date desc', " and category_id = '$selCat' and id in (select club_id from cmembers where user_email = '$email' and status = 0 and admin_perm = 0)");
                }
                else
                {
                    $retList = browse_clubs($con, $email, $id, 'order by clubs.ins_date desc', " and category_id = '$selCat'");
                }
                
                
                $bbody .= $retList['bbody'];
                $btitle .= $retList['btitle'];
                $bsubtitle .= $retList['bsubtitle'];
                $rep .= $retList['rep'];
                $err .= $retList['err'];
            }
        break;
        
        case 'browselatest':
            $btitle = "Browse Latest Clubs";
            $bsubtitle = "All Clubs are in order that are recently created";
            
            $title = "conveylive.com :: Browse Latest Clubs";
            $con->tp->assign('title', $title);
            
            $topicHead = "Latest Clubs";
            $con->tp->assign('topicHead', $topicHead);
            
            $desc = "Browse all the Clubs of conveylive published by users to share,comment and discuss. Create Your own Clubs to discuss and share your digital possesions like, Photos, Files and text posts.";
            $con->tp->assign("descrip", $desc);

            $keys = "Clubs, Posts, File, Share, Community, Network, ConveyLive";
            $con->tp->assign("keys", $keys);
            
            $con->tp->assign('email', $email);
            
            $contType = "Club";
            $sortType = "Latest";
            
            $retList = getContList($con, $email, $contType, $sortType);
            
            $bbody = $retList['bbody'];
            $btitle .= $retList['btitle'];
            $bsubtitle .= $retList['bsubtitle'];
            $rep .= $retList['rep'];
            $err .= $retList['err'];
        break;
        
        case 'browse':
            $retList = browse_clubs($con, $email, "", 'order by clubs.ins_date desc', '');
            
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

function isMember($con, $id, $email)
{
    $is_member = false;
    
    $query = "select * from cmembers where admin_perm = 0 and club_id = $id and status = 0 and user_email = '$email'";
    
    $r = $con->db->selectData($query);
    
    if($r == false || $r == array()) $err .= $con->db->err;
    
    else
    {
        if($r[0]['user_email'] == $email and $r[0]['privilege'] == 1)
        {
            $is_member = true;
        }
        else if($r[0]['user_email'] == $email and $r[0]['privilege'] == 2)
        {
            $is_member = true;
        }
        else if($r[0]['user_email'] == $email and $r[0]['privilege'] == 0)
        {
            $is_member = true;
        }
    }
    return $is_member; 
}

function isCreator($con, $id, $email)
{
    $is_creator = false;
    $query = "select * from cmembers where admin_perm = 0 and club_id = $id and status = 0 and user_email = '$email'";
    
    $r = $con->db->selectData($query);
    
    if($r == false || $r == array()) $err .= $con->db->err;
    
    else
    {
        if($r[0]['user_email'] == $email and $r[0]['privilege'] == 2)
        {
            $is_creator = true;
        }
    }
    return $is_creator;    
}

function isAdmin($con, $id, $email)
{
    $is_admin = false;
    
    $query = "select * from cmembers where admin_perm = 0 and club_id = $id and status = 0 and user_email = '$email'";
    
    $r = $con->db->selectData($query);
    
    if($r == false || $r == array()) $err .= $con->db->err;
    
    else
    {
        if($r[0]['user_email'] == $email and $r[0]['privilege'] == 1)
        {
            $is_admin = true;
        }
        else if($r[0]['user_email'] == $email and $r[0]['privilege'] == 2)
        {
            $is_admin = true;
        }
    }
    return $is_admin;
}

function getAllMembers($con, $club_id)
{
    $members = null;
    
    $query = "select * from cmembers, users where cmembers.admin_perm = 0 and club_id = $club_id and status = 1 and user_email = email";
    
    $r = $con->db->selectData($query);
    
    if($r == false || $r == array()) $err .= $con->db->err;
    
    else
    {
        foreach($r as $a)
        {
            $members[] = $a;
        }
    }
    return $members;    
}

function getAllJoinReq($con, $id, $email)
{
    //status = 1 meanes joined but not approved
    $q = "select * from cmembers, users where club_id = $id and cmembers.admin_perm = 0 and status = 1 and email = user_email and email != '$email'";
    
    $r = $con->db->selectData($q);
    if($r == false || $r == array() || count($r) == 0 ) $err .= $con->db->err;
    else
    {
        $i = 0;
        foreach($r as $a)
        {
            $reqList[$i] = $a;
            $reqList[$i]['pid'] = getPrifileId($a['email'], $con);
            $reqList[$i]['user_imgs_id'] = getProfImgId($a['email'], $con);
            $i++;
        }
    }
    if(count($reqList) > 0 )
        return $reqList;
    else
        return null;
}

function viewClub($con, $email = '', $id)
{
    $is_member = false;
    $is_admin = false;
    $is_owner = false;
    
    $btitle = "Club - ";
    $bsubtitle = "";
    
    $q = "select clubs.id as id,  f_name, l_name, email, user_email, category_id, image_id, cname, description, privacy, status, clubs.ins_date, clubs.upd_date from clubs,users where clubs.admin_perm = 0 and id = $id and status = 0 and email = user_email";

    $r = $con->db->selectData($q);
    
    if($r == false || $r == array()) { $err .= $con->db->err; }
    else
    {
        $i = 0;
        foreach($r as $a)
        {
            $club = $a;
            $club['cname'] = stripslashes($club['cname']);
            $club['description'] = stripslashes($club['description']);
            $k = $con->db->selectData("select cname from categorys where id = ".$club['category_id']."");
            
            if($k != false && $k != array())
            {
                $club['category'] = $k[0]['cname'];
            }
            else
            {
                $err .= $con->db->err;
            }
            $m = $con->db->selectData("select id, view_count, rating, tothits, neghits, ins_date, upd_date from contstats where media_id = ".$club['id']." and media_type = 'Club' and admin_perm = 0 ");
            
            if($m != false && $m != array())
            {
                $club['view_count'] = $m[0]['view_count'];
                $club['rating'] = $m[0]['rating'];
                $club['tothots'] = $m[0]['tothots'];
                $club['neghits'] = $m[0]['neghits'];
                $club['stat_ins_date'] = $m[0]['ins_date'];
                $club['stat_upd_date'] = $m[0]['upd_date'];
            }
            else
            {
                $err .= $con->db->err;
            }
            $i++;
            
        }
        
        $btitle .= stripslashes($club['cname']);
        
        $title = "$btitle :: ConveyLive";
        
        if($club['privacy'] == 0)   $clubType = "open";
        if($club['privacy'] == 1)   $clubType = "closed";
        if($club['privacy'] == 2)   $clubType = "secret";
        $club['clubType'] = $clubType;
        
        $qu = "select user_email, privilege, f_name, l_name, cmembers.id as mem_id from cmembers, users where club_id =".$club['id']." and cmembers.admin_perm = 0 and status = 0 and email = cmembers.user_email";
        //echo $qu;
        $t = $con->db->selectData($qu);
        
        
        if($t == false || $t == array() || count($t) == 0) $err .= $con->db->err;
        else
        {
            $pid = getPrifileId($club['user_email'], $con);
            $club['creator']['pid'] = $pid;
            $i = 0;
            $j = 0;
            foreach($t as $ts)
            {
                $mem[$i] = $ts;
                $club['memberList'][$i] = $mem[$i];
                $p = $con->db->selectData("select profiles.id as pid, user_imgs_id from profiles where user_email = '".$mem[$i]['user_email']."' and active = 0 and admin_perm = 0");
                if($p == false || $p == array() || count($p) == 0) $err .= $con->db->err;
                else
                {
                    $mem[$i]['pid'] = $p[0]['pid'];
                    $club['memberList'][$i]['pid'] = $p[0]['pid'];
                    
                    $mem[$i]['user_imgs_id'] = $p[0]['user_imgs_id'];
                    $club['memberList'][$i]['user_imgs_id'] = $p[0]['user_imgs_id'];
                }
                if($mem[$i]['privilege'] == 1)
                {
                    $club['adminList'][$j] = $mem[$i];
                    $j++;
                }
                if($mem[$i]['privilege'] == 2 )
                {
                    $club['adminList'][$j] = $mem[$i];
                    $club['creator'] = $mem[$i];
                    $j++;
                }
                $i++;
            }
            $mem_count = $i;
        }
        
        $is_member = isMember($con, $id, $email);
        $is_admin  = isAdmin($con, $id, $email);
        $is_creator = isCreator($con, $id, $email);
        
        
        if(($is_admin || $is_creator) && $clubType == "closed")
        {
            $reqArr = getAllJoinReq($con, $id, $email);
            $con->tp->assign('reqArr', $reqArr);
        }
        
        $club['mem_count'] = $mem_count;
        
        $err .= pgclubconts($con, $email, $club['id'], 'Member');
        $err .= pgclubconts($con, $email, $club['id'], 'Picture');
        $err .= pgclubconts($con, $email, $club['id'], 'Post');
        $err .= pgclubconts($con, $email, $club['id'], 'File');
        
        $relArt = array();
        $r = $con->db->selectData("select * from clubs where category_id  = '".$club['category_id']."' and clubs.admin_perm = 0 and id != ".$club['id']." order by ins_date desc LIMIT 0, 5");
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
        $r = $con->db->selectData("select * from clubs where ins_date = 0 and privacy != 2 order by upd_date desc LIMIT 0, 5");
        if($r == false || $r === array() || count($r) == 0) 
        { 
            $err .= $con->db->err; 
        }
        else
        {
            foreach($r as $a)
            {
                $latArt[] = $a;
            }
        }
        
        $con->tp->assign('latArt', $latArt);
    }
    $desc = "$btitle. Browse all the Clubs of conveylive published by users to share,comment and discuss. Create Your own Clubs to discuss and share your digital possesions like, Photos, Files and text posts.";
    $con->tp->assign("descrip", $desc);

    $keys = "$btitle, Clubs, Posts, File, Share, Community, Network, ConveyLive";
    $con->tp->assign("keys", $keys);
    
    
    $con->tp->assign('email', $email);
    $con->tp->assign('is_admin', $is_admin);
    $con->tp->assign('is_owner', $is_owner);
    $con->tp->assign('is_member', $is_member);
    $con->tp->assign('clubType', $clubType);
    $con->tp->assign('club', $club);
    $bbody = $con->tp->fetch('club_view.tpl');
    
    $con->tp->assign('title', $title);
    
    $ret_arr = array();
    $ret_arr['err'] = $err;
    $ret_arr['rep'] = $rep;
    $ret_arr['bbody'] = $bbody;
    $ret_arr['btitle'] = $btitle;
    $ret_arr['bsubtitle'] = $bsubtitle;
    
    return $ret_arr;
}

function browse_clubs($con, $email, $id, $groupby = 'order by clubs.ins_date desc', $extraParam = '')
{
    $title = "conveylive.com :: Browse Clubs";
    
    $con->tp->assign('title', $title);
    
    $btitle = "Browse Clubs";
    $bsubtitle = "Join clubs to discuss and share your views";
    $con->tp->assign('email', $email);
    
    $is_member = false;
    $catList = getCatListDb($con, "Club");

    for($i = 0; $i < count($catList); $i++)
    {
        $list = $con->db->selectData("select count(*) as tot from clubs where admin_perm = 0 and status = 0 and ( privacy = 0 or privacy = 1 )  and category_id = '".$catList[$i]['id']."'");
        if($list != false && $list != array())
            $t = (int)$list[0]['tot'];
        else $err .= $con->db->err;
        if($t > 0)
        {
            $x = $catList[$i]['cname'];
            $x = str_replace(" ", "_", $x );
            $pubList[$i]['linkcat'] = $x;
            $pubList[$i]['cat'] = $catList[$i];
            $pubList[$i]['count'] = $t;
        }
    }
    
    for($i = 0; $i < count($catList); $i++)
    {
        $list = $con->db->selectData("select count(*) as tot from clubs where status = 0 and category_id = '".$catList[$i]['id']."' and id in ( select club_id from cmembers where user_email = '$email' and status = 0 )");
        if($list != false && $list != array())
            $t = (int)$list[0]['tot'];
        else $err .= $con->db->err;
        if($t > 0)
        {
            $x = $catList[$i]['cname'];
            $x = str_replace(" ", "_", $x );
            $selfList[$i]['linkcat'] = $x;
            $selfList[$i]['cat'] = $catList[$i];
            $selfList[$i]['count'] = $t;
        }
    }

    
    $perPage = 4;
    $pageLimit = 5;
    $found = false;
    $qvar = 'clu';
    
    $query = "select count(*) as tot from clubs, users where clubs.admin_perm = 0 and status = 0 and email = user_email $extraParam";
    if($id != "")
    {
        $url = URL ."/browseclub.php?cat=$id";
    }
    else
    {
        $url = URL ."/browseclub.php";
    }
    $_query = "select * from clubs, users where clubs.admin_perm = 0 and status = 0 and email = user_email $extraParam order by RAND() "; //$extraParam $groupby ";
    
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
                $j = 0;
                
                $clubs = array();
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
                    //echo $q . "<br />";
                    $m = $con->db->selectData($q);
                    ///print_r($m);
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
    $desc = "Browse all the Clubs of conveylive published by users to share,comment and discuss. Create Your own Clubs to discuss and share your digital possesions like, Photos, Files and text posts.";
    $con->tp->assign("descrip", $desc);

    $keys = "Clubs, Posts, File, Share, Community, Network, ConveyLive";
    $con->tp->assign("keys", $keys);
    
    $con->tp->assign('email', $email);
    
    $con->tp->assign('pubList', $pubList);
    $con->tp->assign('selfList', $selfList);
    $con->tp->assign('is_member', $is_member);
    
    $bbody = $con->tp->fetch('browse_clubs.tpl');
    
    $ret_arr = array();
    $ret_arr['err'] = $err;
    $ret_arr['rep'] = $rep;
    $ret_arr['bbody'] = $bbody;
    $ret_arr['btitle'] = $btitle;
    $ret_arr['bsubtitle'] = $bsubtitle;
    
    return $ret_arr;
}

function viewPost($con, $email, $id)
{
    $is_member = false;
    $is_admin = false;
    $is_creator = false;
    $query = "select * from cposts where cposts.id = $id and admin_perm = 0 ";

    $i = $con->db->selectData($query);
    
    if($i == false || $i == array() || count($i) == 0) $err .= $con->db->err;
    else
    {
        foreach($i as $cp)
        {
            $cposts = $cp;
        }
        $club_id = $i[0]['club_id'];
    }

    $r = $con->db->selectData("select cname, user_email, image_id from clubs where admin_perm = 0 and id = $club_id and status = 0");

    if($r == false || $r == array()) $err .= $con->db->err;
    else
    {
        $club_name = $r[0]['cname'];

        $club_img_id = $r[0]['image_id'];
        
        $is_member = isMember($con, $club_id, $email);
        $is_admin  = isAdmin($con, $club_id, $email);
        $is_creator = isCreator($con, $club_id, $email);
    }
    
    if(!$is_member)
    {
        $err .= "Sorry, you can not access this page.";
    }
    else
    {
        $post_id = $id;
        $query = "select * from cposts, articles where cposts.id = $post_id and cposts.admin_perm = 0 and articles.admin_perm = 0 and media_id = articles.id";

        $i = $con->db->selectData($query);
        
        if($i == false || $i == array() || count($i) == 0) $err .= $con->db->err;
        else
        {
            foreach($i as $s)
            {
                $topic = $s;
            }
            //print_r($topic);
            if($topic['media_type'] == "Club Post")
            {
                $query = "select articles.*, email, f_name, l_name from articles, users where articles.id = ".$topic['media_id']." and articles.admin_perm = 0 and art_typ = 3 and email = articles.user_email";
                $i = $con->db->selectData($query);

                if($i == false || $i == array() || count($i) == 0) { $err .= $con->db->err; }
                else
                {
                    foreach($i as $t)
                    {
                        $post = $t;
                        $body = $post['body'];
                        $body = stripslashes($body);
                        $body = html_entity_decode($body);

                        $title = $post['title'];
                        $keywords = $post['meta_tags'];
                        $post['body'] = $body;
                        $post['title'] = stripslashes($title);
                        $post['meta_tags'] = stripslashes($keywords);
                        
                        $query = "select profiles.id as pid , user_imgs_id from profiles where admin_perm = 0 and active = 0 and user_email = '".$post['email']."'";

                        $i = $con->db->selectData($query);

                        if($i == false || $i == array() || count($i) == 0) { $err .= $con->db->err; }
                        else
                        {
                            $post['pid'] = $i[0]['pid'];
                            $post['user_imgs_id'] = $i[0]['user_imgs_id'];
                        }
                    }
                    $media_type = "Club Posts";
                    //$media_id = $topic['id'];
                    $media_id = $id;
                    
                    //populate comments
                    $query = "select comments.*, email, f_name, l_name from comments, users where mtype = 'Club Posts' and media_id = $post_id and comments.admin_perm = 0 and email = user_email order by comments.ins_date asc";
                    $i = $con->db->selectData($query);

                    if($i == false || $i == array() || count($i) == 0) { $err .= $con->db->err; }
                    else
                    {
                        $m = 0;
                        foreach($i as $t)
                        {
                            $coms[$m] = $t;
                            $uemail = $coms[$m]['email'];
                            $query = "select profiles.id as pid , user_imgs_id from profiles where admin_perm = 0 and user_email = '$uemail'";
                            $r = $con->db->selectData($query);

                            if($r == false || $r == array() || count($r) == 0) { $err .= $con->db->err; }
                            else
                            {
                                $coms[$m]['pid'] = $r[0]['pid'];
                                $coms[$m]['user_imgs_id'] = $r[0]['user_imgs_id'];
                            }
                            $m++;
                        }
                    }

                    $btitle = "$club_name - Topic: ".$post['title'];
                    $bsubtitle .= "Post your reply for this topic";
                    $con->tp->assign('post', $post);
                    $con->tp->assign('media_type', $media_type);
                    $con->tp->assign('media_id', $media_id);
                    $con->tp->assign('is_member', $is_member);
                    $con->tp->assign('is_admin', $is_admin);
                    $con->tp->assign('topic', $topic);
                    $con->tp->assign('coms', $coms);
                    
                    $con->tp->assign('cpost', $cposts); 
                    $con->tp->assign('club_id', $club_id);
                    $con->tp->assign('club_img_id', $club_img_id);
                    $con->tp->assign('club_name', $club_name);
                    $con->tp->assign('atype', $atype);
                    $con->tp->assign('email', $email);
                    $bbody = $con->tp->fetch('club_post_view.tpl');
                }
            }   
        }
    }
    $title = $post['title'] . " - Topic of $club_name club :: ConveyLive";
    $con->tp->assign('title', $title);
    
    $desc = "$title .Post New Topic in ConveyLive Club. Create Your own Clubs to discuss and share your digital possesions like, Photos, Files and text posts. Browse all the Clubs of conveylive published by users to share,comment and discuss.";
    $con->tp->assign("descrip", $desc);

    $keys = $post['title'].", club, New Topic, Send, message, New Clubs, Posts, File, Share, Community, Network, ConveyLive";
    $con->tp->assign("keys", $keys);
    
    $ret_arr = array();
    $ret_arr['err'] = $err;
    $ret_arr['rep'] = $rep;
    $ret_arr['bbody'] = $bbody;
    $ret_arr['btitle'] = $btitle;
    $ret_arr['bsubtitle'] = $bsubtitle;
    
    return $ret_arr;
}

function pgclubconts($con, $email, $club_id, $cont_type)
{
    switch($cont_type)
    {
        case 'Member':
        
        $perPage = 5;
        $pageLimit = 5;
        $found = false;
        
        $query = "select count(*) as tot from cmembers, users where cmembers.admin_perm = 0 and cmembers.user_email = email and club_id = $club_id ";
        $url = URL ."/clubpage.php?ctyp=$cont_type&cid=$club_id";
        $_query = "select * from cmembers, users where cmembers.admin_perm = 0 and cmembers.user_email = email and club_id = $club_id order by join_date desc";
        
        
        $id = 'member';
        $sess_name = 'members';
        SmartyPaginate::disconnect($id);
        unset($_SESSION[$sess_name]);
        SmartyPaginate::reset($id);
        
        $_SESSION['mem'] = $_query;
        
        
        if(!isset($_SESSION[$sess_name]))
        {
            SmartyPaginate::connect($id);
            if(SmartyPaginate::isConnected($id))
            {
                $found = init_pg_multi($query, $url, $perPage, $pageLimit, $email,  $con, $id, $sess_name);
            }
        }
        if($found)
        {
            if(isset($_SESSION[$sess_name]))
            {
                $currIndex = SmartyPaginate::getCurrentIndex($id);
                $limit = SmartyPaginate::getLimit($id);

                $l = sprintf(" LIMIT %d, %d", $currIndex, $limit);
                $query = $_query.$l;

                $res = paginate_search($query, $con);
                $err .= $con->db->err;
                if(is_array($res) && $res!= false && $res != array() && count($res) > 0)
                {
                    for($i = 0; $i < count($res); $i++)
                    {
                        $cdate = $res[$i]['cdate'];
                        $date = new DateTime($cdate);
                        $res[$i]['cdate'] = $date->format("F j, Y, g:i a");
                        
                        $query = "select profiles.id as pid, user_imgs_id from profiles where user_email = '".$res[$i]['user_email']."'";
                        
                        $r = $con->db->selectData($query);
                        
                        if($r == array() || count($r) == 0 || $r == false) $err .= $con->db->err;
                        else
                        {
                            $res[$i]['pid'] = $r[0]['pid'];
                            $res[$i]['user_imgs_id'] = $r[0]['user_imgs_id'];
                        }
                        
                    }
                    $con->tp->assign('members', $res);
                }
                $err .= $con->db->err;
                
                SmartyPaginate::assign($con->tp,'mem_paginate',$id);

            }
            else
            {
                $err .= $con->db->err;
                
                $err .= "Session is not set. Members not found";
                
                $btitle = "Members not available";
            }
        }
        break;
        
        case 'Picture':
        $perPage = 4;
        $pageLimit = 5;
        $found = false;
        
        $album = getClubAlbum($con, $club_id);
        if(count($album) > 0)
        {
            $query = "select count(*) as tot from images, users where images.admin_perm = 0 and user_email = email and album_id = ".$album['id']." and stat = 0";
            $url = URL ."/clubpage.php?ctyp=$cont_type&cid=$club_id";
            $_query = "select id, f_name, l_name, email from images, users where images.admin_perm = 0 and user_email = email and album_id = ".$album['id']." and stat = 0 order by images.ins_date desc";
            
            $id = 'picture';
            $sess_name = 'pictures';
            SmartyPaginate::disconnect($id);
            unset($_SESSION[$sess_name]);
            SmartyPaginate::reset($id);
            $_SESSION['pic'] = $_query;
            
            
            if(!isset($_SESSION[$sess_name]))
            {
                SmartyPaginate::connect($id);
                if(SmartyPaginate::isConnected($id))
                {
                    $found = init_pg_multi($query, $url, $perPage, $pageLimit, $email,  $con, $id, $sess_name);
                }
            }
            if($found)
            {
                if(isset($_SESSION[$sess_name]))
                {
                    $currIndex = SmartyPaginate::getCurrentIndex($id);
                    $limit = SmartyPaginate::getLimit($id);

                    $l = sprintf(" LIMIT %d, %d", $currIndex, $limit);
                    $query = $_query.$l;

                    $res = paginate_search($query, $con);
                    $err .= $con->db->err;
                    if(is_array($res) && $res!= false && $res != array() && count($res) > 0)
                    {
                        $con->tp->assign('pictures', $res);
                    }
                    $err .= $con->db->err;
                    
                    SmartyPaginate::assign($con->tp,'pic_paginate',$id);

                }
                else
                {
                    $err .= $con->db->err;
                    
                    $err .= "Session is not set. Pictures not found";
                    
                    $btitle = "Pictures not available";
                }
            }
        }
        break;
        
        case 'Post':
        $perPage = 10;
        $pageLimit = 5;
        $found = false;
        
        $query = "select count(*) as tot from cposts, articles where club_id = $club_id and cposts.admin_perm = 0 and media_type = 'Club Post' and media_id = articles.id and art_typ = 3 and cposts.admin_perm = 0 ";
        $url = URL ."/clubpage.php?ctyp=$cont_type&cid=$club_id";
        $_query = "select cposts.id as post_id , articles.title as topic from cposts, articles where club_id = $club_id and articles.admin_perm = 0 and media_type = 'Club Post' and media_id = articles.id and art_typ = 3 and cposts.admin_perm = 0 order by cposts.ins_date asc";
        
        $id = 'topic';
        $sess_name = 'topics';
        SmartyPaginate::disconnect($id);
        unset($_SESSION[$sess_name]);
        SmartyPaginate::reset($id);
        $_SESSION['top'] = $_query;
        
        
        if(!isset($_SESSION[$sess_name]))
        {
            SmartyPaginate::connect($id);
            if(SmartyPaginate::isConnected($id))
            {
                $found = init_pg_multi($query, $url, $perPage, $pageLimit, $email,  $con, $id, $sess_name);
            }
        }
        if($found)
        {
            if(isset($_SESSION[$sess_name]))
            {
                $currIndex = SmartyPaginate::getCurrentIndex($id);
                $limit = SmartyPaginate::getLimit($id);

                $l = sprintf(" LIMIT %d, %d", $currIndex, $limit);
                $query = $_query.$l;

                $res = paginate_search($query, $con);
                $err .= $con->db->err;
                if(is_array($res) && $res!= false && $res != array() && count($res) > 0)
                {
                    $con->tp->assign('topics', $res);
                }
                $err .= $con->db->err;
                
                SmartyPaginate::assign($con->tp,'top_paginate',$id);

            }
            else
            {
                $err .= $con->db->err;
                
                $err .= "Session is not set. Topics not found";
                
                $btitle = "Topics not available";
            }
        }
        break;
        
        case 'File':
        $perPage = 10;
        $pageLimit = 5;
        $found = false;
        
        $query = "select count(*) as tot from cposts, user_files, users where user_files.club_id = $club_id and cposts.club_id = $club_id and cposts.admin_perm = 0 and media_type = 'Club File' and media_id = user_files.id and user_files.admin_perm = 0 and email = user_files.user_email and email = cposts.user_email";
        $url = URL ."/clubpage.php?ctyp=$cont_type&cid=$club_id";
        $_query = "select file_ext, f_name, l_name, user_files.ins_date as date , cposts.id as filepost_id , user_files.id as file_id,  user_files.file_name as file_name, user_files.user_email as user_email from cposts, user_files, users where user_files.club_id = $club_id and cposts.club_id = $club_id and cposts.admin_perm = 0 and media_type = 'Club File' and media_id = user_files.id and user_files.admin_perm = 0 and email = user_files.user_email and email = cposts.user_email  order by date desc";
        
        
        $id = 'files';
        $sess_name = 'files';
        SmartyPaginate::disconnect($id);
        unset($_SESSION[$sess_name]);
        SmartyPaginate::reset($id);
        $_SESSION['fil'] = $_query;
        
        
        if(!isset($_SESSION[$sess_name]))
        {
            SmartyPaginate::connect($id);
            if(SmartyPaginate::isConnected($id))
            {
                $found = init_pg_multi($query, $url, $perPage, $pageLimit, $email,  $con, $id, $sess_name);
            }
        }
        if($found)
        {
            if(isset($_SESSION[$sess_name]))
            {
                $currIndex = SmartyPaginate::getCurrentIndex($id);
                $limit = SmartyPaginate::getLimit($id);

                $l = sprintf(" LIMIT %d, %d", $currIndex, $limit);
                $query = $_query.$l;

                $res = paginate_search($query, $con);
                $err .= $con->db->err;
                
                if(is_array($res) && $res!= false && $res != array() && count($res) > 0)
                {
                    for($i = 0; $i < count($res); $i++)
                    {
                        $cdate = $res[$i]['cdate'];
                        $date = new DateTime($cdate);
                        $res[$i]['cdate'] = $date->format("F j, Y, g:i a");
                        
                        $query = "select profiles.id as pid, user_imgs_id from profiles where user_email = '".$res[$i]['user_email']."'";
                        
                        $r = $con->db->selectData($query);
                        
                        if($r == array() || count($r) == 0 || $r == false) $err .= $con->db->err;
                        else
                        {
                            $res[$i]['pid'] = $r[0]['pid'];
                            $res[$i]['user_imgs_id'] = $r[0]['user_imgs_id'];
                        }
                    }
                    $con->tp->assign('files', $res);
                }
                $err .= $con->db->err;
                
                SmartyPaginate::assign($con->tp,'file_paginate',$id);

            }
            else
            {
                $err .= $con->db->err;
                
                $err .= "Session is not set. File not found";
                
                $btitle = "File not available";
            }
        }        
    }
    
    return $err;
}
?>
