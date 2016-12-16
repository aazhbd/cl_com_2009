<?php
function album($con, $email, $section,  $id = '')
{
    $rep = "";
    $err = "";
    $btitle = "";
    $bbody = "";
    $subtitle = "";
    $skip = false;
    
    switch($section)
    {
        case 'ratedown':
            $media_type = "Photo";
            
            $media_id = $id;
            
            $upd = rateChange($con, $media_type, $media_id, 'down');

            if($upd != false  )
            {
                $rep = "Photo rating updated";
            }
            $err .= $con->db->err;
            
            $retList = view_photo($con, $email, $id);
            
            $bbody .= $retList['bbody'];
            $btitle .= $retList['btitle'];
            $bsubtitle .= $retList['bsubtitle'];
            //$rep = $retList['rep'];
            //$err .= $retList['err'];
        break;
        
        case 'rateup':
            $media_type = "Photo";
            
            $media_id = $id;
            
            $upd = rateChange($con, $media_type, $media_id, 'up');

            if($upd != false  )
            {
                $rep = "Photo rating updated";
            }
            $err .= $con->db->err;
            
            $retList = view_photo($con, $email, $id);
            
            $bbody .= $retList['bbody'];
            $btitle .= $retList['btitle'];
            $bsubtitle .= $retList['bsubtitle'];
        break;        
        
        case 'setalbumphoto':
            $r = $con->db->selectData("select * from images where id = $id and user_email = '$email' and admin_perm = 0");
            if($r == false || $r == array() || count($r) == 0 )
            {
                $err .= "No such image or error occured.".$con->db->err;
            }
            else
            {
                $album_id = $r[0]['album_id'];
                $r = $con->db->executeNonQuery("update albums set image_id = $id where id = $album_id and user_email = '$email' and admin_perm = 0");
                if($r == false)
                {
                    $err .= "Could not update album".$con->db->err;
                }
                else
                {
                    $rep = "Album Cover Photo has been updated";
                    $btitle = "Album image cover updated";
                }
            }
            $retList = new_album($con, $email, $id);
            
            $bbody = $retList['bbody'];
            $btitle = $retList['btitle'];
            $bsubtitle = $retList['bsubtitle'];
            $rep .= $retList['rep'];
            $err .= $retList['err'];
        break;
        
        case 'setprofilephoto':
            $r = $con->db->selectData("select * from images where id = $id and user_email = '$email' and admin_perm = 0");
            if($r == false || $r == array() || count($r) == 0 )
            {
                $err .= "No such image or error occured.".$con->db->err;
            }
            else
            {
                $query = "update profiles set user_imgs_id = $id where user_email = '$email'";
                
                $r = $con->db->executeNonQuery($query);
                if($r == false)
                {
                    $err .= "Could not update profile photo".$con->db->err;
                }
                else
                {
                    $rep = "Profile Photo has been updated";
                }
            }
            $id = getPrifileId($email, $con);
            
            viewProfile($con, $id, $email);
            $skip = true;
        break;
        
        case 'albumremove':
            $album_del = false;
            $imgs_del = false;
            $no_image = false;
            $com_del = false;
            
            if($id > 0)
            {
                $r = $con->db->selectData("select * from images where album_id = $id and user_email = '$email'");
                if($r == false || $r === array() || count($r) == 0 )
                {
                    $err .= "No image found in album or error occured".$con->db->err;
                    $no_image = true; 
                }
                else
                {
                    foreach($r as $i)
                    {
                        $img_id = $i['id'];
                        $r = $con->db->executeNonQuery("update images set admin_perm = 1 where id = $img_id and user_email = '$email'");
                        if($r == false)
                        {
                            $err .= "Could not delete album images".$con->db->err;
                            $imgs_del = false;
                            break; 
                        }
                        else
                        {
                            $imgs_del = true;
                            $r = $con->db->executeNonQuery("update comments set admin_perm = 1 where media_id = $img_id and mtype = 'Picture' and user_email = '$email'");
                            if($r == false)
                            {
                                $err .= "No commments found and not deleted".$con->db->err;
                                $com_del = false;
                                break;
                            }
                            else
                            {
                                $com_del = true;
                            }
                        }
                    }
                }

                if($imgs_del)
                {
                    $r = $con->db->executeNonQuery("update albums set admin_perm = 1 where id = $id and user_email = '$email'");
                    if($r == false)
                    {
                        $err .= "Could not delete album".$con->db->err;
                        $album_del = false;
                    }
                    else
                    {
                        $album_del = true;
                        $rep = "Album has been deleted";
                        $btitle = "Album Deleted";
                    }
                }
                else
                {
                    if($no_image)
                    {
                        $r = $con->db->executeNonQuery("update albums set admin_perm = 1 where id = $id and user_email = '$email'");
                        if($r == false)
                        {
                            $err .= "Could not delete album".$con->db->err;
                            $album_del = false;
                        }
                        else
                        {
                            $album_del = true;
                            $rep = "Album has been deleted";
                            $btitle = "Album Deleted";
                        }
                     }
                }
            }
            else
            {
                $err .= "Invalid Album: id = ".$id;
            }
            $retList = new_album($con, $email, $id);
            
            $bbody = $retList['bbody'];
            $btitle = $retList['btitle'];
            $bsubtitle = $retList['bsubtitle'];
            $rep .= $retList['rep'];
            $err .= $retList['err'];
        break;
        
        case 'delete':
            $r = $con->db->executeQuery("select * from images where id = $id and stat = 0 and user_email='$email'");
            
            if($r == false || $r == array() && count($r) == 0 ) 
            {
                $err = "Invalid Image. Can not delete.";
                $album_id = -1;
            }
            else
            {
                $album_id = $r[0]['album_id'];
            }
            if($album_id > 0)
            {
                $r = $con->db->executeNonQuery("update images set admin_perm = 1 where id = $id and stat = 0 and user_email = '$email'");
                if($r == true)
                {
                    $r = $con->db->executeQuery("select * from albums where id = $album_id  and user_email = '$email'");
                    if($r == false || $r == array() || count($r) == 0) 
                    {
                        $err .= "Could not select Album or No such album".$con->db->err;
                        $rep = "Your Image has been deleted successfully";
                        $btitle = "Image Deleted";
                    }
                    else
                    {
                        $albumimg_id = $r[0]['albumimg_id'];
                        if($albumimg_id == $id)
                        {
                            $r = $con->db->selectData("select * from images where album_id = $album_id and stat = 0 and user_email = '$email' order by id desc LIMIT 0, 1");
                            $err .= $con->db->err;
                            if($r == false || $r == array() || count($r) == 0) 
                            { 
                                if($err == "" )
                                {
                                    $err .= "Album has no Image";
                                } 
                            }
                            else
                            {
                                $new_imgid = $r[0]['id'];
                                $r = $con->db->executeNonQuery("update albums set image_id = $new_imgid where id = $album_id and user_email = '$email' ");
                                if($r == true)
                                {
                                    $rep = "Your image has been deleted successfully";
                                }
                                else
                                {
                                    $err .= "Could not update album image".$con->db->err;
                                }
                            }
                        }
                        else
                        {
                            $rep = "Your Image has been deleted successfully";
                            $btitle = "Image Deleted";
                        }
                    }
                    $r = $con->db->executeNonQuery("update comments set admin_perm = 1 where media_id = $id and mtype = 'Picture' and user_email = '$email'");
                    if($r == false)
                    {
                        $err .= "No commments found and not deleted".$con->db->err;
                        $com_del = false;
                    }
                    else
                    {
                        $com_del = true;
                    }
                }
                else
                {
                    $err .= "Could not delete image".$con->db->err; 
                }
            }
            else if($album_id == 0)
            {
                $r = $con->db->executeNonQuery("update images set admin_perm = 1 where id = $id and admin_perm = 0 and stat = 0 and user_email = '$email'");
                if($r == true)
                {
                    $rep = "Your Profile Image has been deleted successfully";
                    $btitle = "Image Deleted";
                }
                else
                {
                    $err .= "Could not update album image".$con->db->err;
                }
            }
            $retList = album_view($con, $email, $album_id);
            
            $bbody = $retList['bbody'];
            $btitle = $retList['btitle'];
            $bsubtitle = $retList['bsubtitle'];
            $rep .= $retList['rep'];
            $err .= $retList['err'];
        break;
        
        case 'view':
            $retList = view_photo($con, $email, $id);
            
            $bbody = $retList['bbody'];
            $btitle = $retList['btitle'];
            $bsubtitle = $retList['bsubtitle'];
            $rep = $retList['rep'];
            $err = $retList['err'];
        break;
        
        case 'albumview':
            $retList = album_view($con, $email, $id);
            
            $bbody = $retList['bbody'];
            $btitle = $retList['btitle'];
            $bsubtitle = $retList['bsubtitle'];
            $rep = $retList['rep'];
            $err = $retList['err'];       
        break;
        
        case 'new':
            $retList = new_album($con, $email, $id);
            
            $bbody = $retList['bbody'];
            $btitle = $retList['btitle'];
            $bsubtitle = $retList['bsubtitle'];
            $rep = $retList['rep'];
            $err = $retList['err'];
        break;

        case 'browselatest':
            $btitle = "Browse Latest Albums";
            $bsubtitle = "All Albums are in order that are recently published";
            
            $title = "conveylive.com :: Browse Latest Albums";
            $con->tp->assign('title', $title);
            
            $topicHead = "Latest Albums";
            $con->tp->assign('topicHead', $topicHead);
            
            $desc = "Publish your albums with conveylive. Share Your photos with your friends and family. Browse all the albums published by users of conveylive to share and comment.";
            $con->tp->assign("descrip", $desc);
            
            $keys = "Photos, Albums, Picture, Share, ConveyLive";
            $con->tp->assign("keys", $keys);
            
            $con->tp->assign('email', $email);
            
            $contType = "Album";
            $sortType = "Latest";
            
            $retList = getContList($con, $email, $contType, $sortType);
            
            $bbody = $retList['bbody'];
            $btitle .= $retList['btitle'];
            $bsubtitle .= $retList['bsubtitle'];
            $rep .= $retList['rep'];
            $err .= $retList['err'];
        break;
        
        case 'browse':
            $retList = browse_album($con, $email, $id);
            
            $bbody = $retList['bbody'];
            $btitle = $retList['btitle'];
            $bsubtitle = $retList['bsubtitle'];
            $rep = $retList['rep'];
            $err = $retList['err'];
    }
    if(!$skip)
    {
        $con->tp->assign('bsubtitle', $bsubtitle);
        $con->tp->assign('bbody', $bbody);
        $con->tp->assign('btitle', $btitle);
        $con->tp->assign('rep', $rep);
        $con->tp->assign('err', $err);
    }
}

function view_photo($con, $email, $id)
{
    $mediaLoaded = false;
    $isValid = true;
    $has_album = false;
    $r = $con->db->selectData("select album_id from images where id = $id ");
    
    if($r != false and $r != array())
    {
        $aid = $r[0]['album_id'];
    }
    else
    {
        $err .= "Pictures not available: ". $con->db->err;
    }
    
    if($aid != 0)
    {
        $r = $con->db->selectData("select * from albums where admin_perm = 0 and id in ( select album_id from images where id = $id ) ");
        if($r != false and $r != array())
        {
            foreach($r as $a)
            {
                $album[] = $a;
            }
            $con->tp->assign('album', $album);
            
            $user_email = $album[0]['user_email'];
            
            $is_friend = isFriend($user_email, $email, $con);
            
            $aid = $album[0]['id'];
            
            $album_privacy = $album[0]['privacy'];
            
            if($album_privacy == 4)
            {
                $club = getClubByAlbumId($con, $aid);
                $club_id = $club['id'];
                $is_member = isClubMember($con, $email, $club_id);
            }
            
            $user_name = getUserName($user_email, $con);
            
            $con->tp->assign('user_name', $user_name);
            
            $pid = getPrifileId($user_email, $con);
            
            $img_id = getProfImgId($user_email, $con);
        }
    }
    else
    {
        $user_email = $email;

        $user_name = getUserName($email, $con);

        $pid = getPrifileId($email, $con);

        $img_id = getProfImgId($email, $con);
    }
    
    if($isValid)
    {
        $perPage = 1;
        $pageLimit = 1;
        $found = false;
        
        $query = "select count(*) as tot from images where album_id = $aid and admin_perm = 0 and stat = 0 and user_email = '$user_email'";

        $url = URL ."/picpage.php?id=$id";
        
        $_query = "SELECT * FROM images where admin_perm = 0 and stat = 0 and album_id = $aid and user_email = '$user_email' order by id desc";
        
        SmartyPaginate::disconnect();
        
        SmartyPaginate::reset();
        
        unset($_SESSION['res']);
        
        $_SESSION['pic'] = $_query;
        
        if(!isset($_SESSION['res']))
        {
            SmartyPaginate::connect();
            if(SmartyPaginate::isConnected())
            {
                $found = init_pagination_search($query, $url, $perPage, $pageLimit, $email,  $con);
                $q = "select id from images where admin_perm = 0 and stat = 0 and album_id = $aid and user_email = '$user_email' order by id desc";
                
                $pg = getCurrPgNo($q, $con, $id);
                
                if($pg > -1)
                {
                    $pg = $pg + 1;
                    SmartyPaginate::setCurrentItem($pg);
                }
            }
        }
        $con->tp->assign('email', $email);
        if($found)
        {
            if(isset($_SESSION['res']))
            {
                $prof_aid = getProfileAlbumId($con, $user_email, "Profile");
                $con->tp->assign('prof_aid', $prof_aid);
                if($album_privacy == "2" )
                {
                    $btitle = "$user_name's Profile Photos";
                    
                    $title =  "$user_name's Profile Photos :: conveylive.com";
                    
                    $bsubtitle = "Profile Photos";
                    
                    $album_name = "Profile Photos";
                    
                    $has_perm = true;
                }
                else if($album_privacy == "1" )
                {
                    $btitle = "$user_name's Personal Album - " . $album[0]['album_name'];;
                    
                    $title =  "$user_name's Personal Album - ".$album[0]['album_name'].":: conveylive.com";
                    
                    $bsubtitle = "Profile Photos";
                    
                    $album_name = "Profile Photos";
                    
                    $has_perm = true;
                }
                else if($album_privacy == "0")
                {
                    $btitle = "$user_name's Album - ".$album[0]['album_name'];
                    
                    $title =  "Photo from $user_name's Album - ".$album[0]['album_name'] ." :: conveylive.com";
                    
                    $bsubtitle = $album[0]['remarks'];
                    
                    $album_name = $album[0]['album_name'];
                    
                    $has_perm = true;
                }
                else if($album_privacy == "4" )
                {
                    $btitle = "Club Album - ".$album[0]['album_name'];
                    
                    $title =  "Photos from ".$album[0]['album_name']." Club Album :: conveylive.com";
                    
                    $bsubtitle = $album[0]['remarks'];
                    
                    $album_name = $album[0]['album_name'];
                    
                    $has_perm = true;
                }
                else if($album_privacy == "3" )
                {
                    $btitle = "Video album of $user_name - ".$album[0]['album_name'];
                    
                    $title =  "Photos from ".$album[0]['album_name']." Video Album :: conveylive.com";
                    
                    $bsubtitle = $album[0]['remarks'];
                    
                    $album_name = $album[0]['album_name'];
                    
                    $has_perm = true;
                }
                
                if($has_perm)
                {
                    $currIndex = SmartyPaginate::getCurrentIndex();
                    
                    $limit = SmartyPaginate::getLimit();
                    
                    $l = sprintf(" LIMIT %d, %d", $currIndex, $limit);
                    
                    $query = $_query.$l;
                    
                    $res = paginate_search($query, $con);
                    
                    if(is_array($res) && $res!= false && $res != array() && count($res) > 0)
                    {   
                        $con->tp->assign('aid', $aid);
                        
                        $con->tp->assign('pid', $pid);
                        
                        $con->tp->assign('img_id', $img_id);
                        
                        $con->tp->assign('uname', $user_name);
                        
                        $con->tp->assign('remarks', $album[0]['remarks']);
                        
                        $con->tp->assign('album_name', $album_name);
                        
                        $con->tp->assign('res_list', $res);
                        
                        $con->tp->assign('email', $email);
                        
                        $mediaLoaded = true;
                        
                        SmartyPaginate::assign($con->tp);
                        
                        $con->tp->assign('title', $title);
                        
                        $bbody =  $con->tp->fetch("pic_view.tpl");
                        
                        $mediaid = $con->tp->get_template_vars('media_id');
                        
                        if($user_email != $email)
                        {
                            $pi = getContStats($con, "Photo", $mediaid);
                            if($pi != array())
                            {
                                foreach($pi as $p)
                                {
                                    $ph = $p;
                                }
                                $c = (int)$ph['view_count'] + 1;
                                
                                updateContStats($con, $mediaid, "Photo", $c, "", "", "");
                            }
                        }
                        
                        $imgstats = getContStats($con, "Photo", $mediaid);
                        
                        $con->tp->assign('imgstats', $imgstats[0]);
                        
                        $bbody .= "<br />".$con->tp->fetch('topinfo.tpl'). "<div style='margin-bottom:10px; width:98%;'></div>";
                        
                        $has_album = true;
                    }
                    else
                    {
                        $err .= $res;
                        $err .= "Album not found.";
                        $btitle = "Album not available";
                        $title = "Photo not available";
                    }
                }
                else
                {
                    $err .= $res;
                    $err .= "Album not found.";
                    $btitle = "Album not available";
                    $title = "Photo not available";
                }                
            }
            else
            {
                $err .= "Session is not set. Album not found";
                $btitle = "Album not available";
                $title = "Photo not available";
            }
        }
        else
        {
            $err .= "Album not found.";
            $btitle = "Album not available";
            
            $title = "Photo not available";
        }
        
        if($has_album)
        {
            //Comments
            $mediaid = $con->tp->get_template_vars('media_id');
            $coms = getComList($mediaid, 'Picture', $con);
            if(is_string($coms)) $err .= $coms;
            
            $con->tp->assign('media_id', $mediaid);
            
            $con->tp->assign('coms', $coms);
            //Comments End
            $con->tp->assign('email', $email);                                         
            $keys = $album[0]['album_name'] .", ". $user_name. ", ". $album['file_name'];
            
            $desc = $album[0]['album_name'] ."- Album of $user_name. Publish your albums with conveylive. Share Your photos with your friends and family. Browse all the albums published by users of conveylive to share and comment.";
            $con->tp->assign("descrip", $desc);

            $keys .= " Photos, Albums, Picture, Share, ConveyLive";
            $con->tp->assign("keys", $keys);
            
            $bbody .= $con->tp->fetch('photocmt_form.tpl');
            
            //Content Invite
            $cont_formlabel = "Invite your friends to view this photo";
            $con->tp->assign('cont_formlabel', $cont_formlabel);
            
            $mail_subject = getUserName($email, $con). " invites you to view a photo from the album, \"".$album[0]['album_name'] . "\"";
            $con->tp->assign('mail_subject', $mail_subject);
            
            $mail_subject_general = "You have been invited to view a photo from the album, \"".$album[0]['album_name'] ."\" by your friend ";
            $con->tp->assign('mail_subject_general', $mail_subject_general);            
            
            //$mail_body = "Hi, \r\n";  
            $mail_body .= "I wanted to invite you to view this photo from the album named, \"".$album[0]['album_name'] ."\", published by $user_name.";
            $mail_body .= "You can join in conveylive.com to add comments to this album photos. Go to this link or copy paste it in your browser ";
            $mail_body .= URL . "/picture/view/$mediaid";
            $mail_body .= " and let me know if you liked it.";
            //$mail_body .= "\r\n\r\nRegards";
            $con->tp->assign('mail_body', $mail_body);
            
            $conttype = "photo";
            $con->tp->assign('conttype', $conttype);
            
            if($email !="")
            {
                $bbody .= "<br />".$con->tp->fetch('invitecontent_form.tpl');
            }
        }
        //Content Invite End
    }
    $con->tp->assign('title', $title);
    
    $ret_arr = array();
    $ret_arr['err'] = $err;
    $ret_arr['rep'] = $rep;
    $ret_arr['bbody'] = $bbody;
    $ret_arr['btitle'] = $btitle;
    $ret_arr['bsubtitle'] = $bsubtitle;
    
    return $ret_arr;   
}

function browse_album($con, $email, $id)
{
    $btitle = "Browse Albums";
    $bsubtitle = "Browse latest albums";
    $con->tp->assign('email', $email);
    
    $perPage = 9;
    $pageLimit = 5;
    $found = false;
    
    $query = "select count(*) as tot from albums, users where albums.admin_perm = 0 and albums.privacy = 0 and albums.user_email = email ";
    $url = URL ."/picturebrowse.php";
    $_query = "select f_name, l_name, email, user_email, albums.id as id, album_name, category_id, image_id, privacy, albums.ins_date as ins_date, albums.upd_date as upd_date, albums.admin_perm as admin_perm from albums, users where albums.admin_perm = 0 and albums.privacy = 0 and albums.user_email = email order by RAND()";//"albums.upd_date desc";
    
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
    
    $desc = "Publish your albums with conveylive. Share Your photos with your friends and family. Browse all the albums published by users of conveylive to share and comment.";
    $con->tp->assign("descrip", $desc);
    
    $keys = "Photos, Albums, Picture, Share, ConveyLive";
    $con->tp->assign("keys", $keys);
    
    $title = "ConveyLive :: Browse Albums";
    $con->tp->assign('title', $title);    
    $ret_arr = array();
    $ret_arr['err'] = $err;
    $ret_arr['rep'] = $rep;
    $ret_arr['bbody'] = $bbody;
    $ret_arr['btitle'] = $btitle;
    $ret_arr['bsubtitle'] = $bsubtitle;
    
    return $ret_arr;
}

function album_view($con, $email, $id)
{
    $mediaLoaded = false;
    $isValid = true;
    $title = "Album Not Found :: conveylive.com";
    
    if($id != 0)
    {
        $r = $con->db->selectData("select * from albums where admin_perm = 0 and id = $id");
        if($r != false and $r != array() and count($r) > 0)
        {
            foreach($r as $a)
            {
                $album = $a;
            }
            $user_email = $album['user_email'];
            
            $user_name = getUserName($user_email, $con);
            
            $pid = getPrifileId($user_email, $con);
            
            $img_id = getProfImgId($user_email, $con);
            
            $isValid = true;
        }
        else
        {
            $err .= $con->db->err;
            $isValid = false;
        }
    }
    else
    {
        $user_email = $email;

        $user_name = getUserName($email, $con);

        $pid = getPrifileId($email, $con);

        $img_id = getProfImgId($email, $con);
    }
    
    if($isValid)
    {
        $perPage = 9;
        $pageLimit = 5;
        $found = false;

        $query = "select count(*) as tot from images where album_id = $id and admin_perm = 0 and stat = 0 and user_email = '$user_email' ";
        
        $url = URL ."/albumpage.php?aid=$id";
        
        $_query = "SELECT * FROM images where admin_perm = 0 and stat = 0 and album_id = $id and user_email = '$user_email' order by id desc";
        
        SmartyPaginate::reset();
        
        SmartyPaginate::disconnect();
        
        unset($_SESSION['res']);
        
        $_SESSION['pic'] = $_query;
        
        if(!isset($_SESSION['res']))
        {
            SmartyPaginate::connect();
            if(SmartyPaginate::isConnected())
            {
                $found = init_pagination_search($query, $url, $perPage, $pageLimit, $email,  $con);
            }
        }
        $con->tp->assign('email', $email);
        if($found)
        {
            if(isset($_SESSION['res']))
            {
                $prof_aid = getProfileAlbumId($con, $user_email, "Profile");
                $con->tp->assign('prof_aid', $prof_aid);
                if($id == $prof_aid)
                {
                    $btitle = "$user_name's Profile Photos";
                
                    $bsubtitle = "Profile Photos";
                }
                else
                {
                    $btitle = "$user_name's Album - ".$album['album_name'];
                
                    $bsubtitle = $album['remarks'];
                }
                //$btitle = "$user_name's Album - ".$album[0]['album_name'];
            
                $bsubtitle = $album['remarks'];
                
                $title = $album['album_name'] . " - $user_name's Album :: conveylive.com";
                
                $currIndex = SmartyPaginate::getCurrentIndex();
                
                $limit = SmartyPaginate::getLimit();
                
                $l = sprintf(" LIMIT %d, %d", $currIndex, $limit);
                
                $query = $_query.$l;
                
                $res = paginate_search($query, $con);
                
                if(is_array($res) && $res!= false && $res != array() && count($res) > 0)
                {
                    $i = 0;
                    foreach($res as $a)
                    {
                        $albumpics[$i] = $a;
                        $album_path = $albumpics[$i]['album_id'] . '_'. str_replace(" ", "_", $album['album_name']);
                        $photo_path = $albumpics[$i]['id'] . '_lrg_' . str_replace(" ", "_", $albumpics[$i]['file_name']);
                        $albumpics[$i]['fpath'] = 'directories/albums/'.$album_path . '/'. $photo_path;
                        $i++;
                    }
                    $con->tp->assign('album', $albumpics);
                    
                    $con->tp->assign('aid', $id);
                    
                    $con->tp->assign('pid', $pid);
                    
                    $con->tp->assign('img_id', $img_id);
                    
                    $con->tp->assign('uname', $user_name);
                    
                    SmartyPaginate::assign($con->tp);
                    
                    //Content Invite
                    $cont_formlabel = "Invite your friends to view this album";
                    $con->tp->assign('cont_formlabel', $cont_formlabel);
                    
                    $mail_subject = getUserName($email, $con). " invites you to view an album named, \"".$album['album_name'] . "\"";
                    $con->tp->assign('mail_subject', $mail_subject);
                    
                    $mail_subject_general = "You have been invited to view an album named, \"".$album['album_name'] . "\" by your friend ";
                    $con->tp->assign('mail_subject_general', $mail_subject_general);            
                    
                    //$mail_body = "Hi, \r\n";  
                    $mail_body .= "I wanted to invite you to view this album named, \"".$album['album_name'] ."\", published by $user_name.";
                    $mail_body .= "You can join in conveylive.com to add comments to this album photos. Go to this link or copy paste it in your browser ";
                    $mail_body .= URL . "/picture/albumview/$id";
                    $mail_body .= " and let me know if you liked it.";
                    //$mail_body .= "\r\n\r\nRegards";
                    $con->tp->assign('mail_body', $mail_body);
                    
                    $conttype = "album";
                    $con->tp->assign('conttype', $conttype);
                    //Content Invite End
                    
                    $bbody .=  $con->tp->fetch("album_view.tpl");
                }
                else
                {
                    $err .= $res;
                    $err .= "Album not found.";
                    $btitle = "Album not available";
                    $bbody =  $con->tp->fetch("album_view.tpl");
                }
            }
            else
            {
                $err .= "Session is not set. Album not found";
                $btitle = "Album not available";
                $bbody =  $con->tp->fetch("album_view.tpl");
            }
        }
        else
        {
            $err .= $con->db->err;
            $err .= "Album has no pictures";
            $btitle = "Album Empty";
            $con->tp->assign('aid', $id);

            $con->tp->assign('pid', $pid);

            $con->tp->assign('img_id', $img_id);

            $con->tp->assign('uname', $user_name);
            $bbody =  $con->tp->fetch("album_view.tpl");
        }
    }
    
    $desc = "$btitle. Publish your albums with conveylive. Share Your photos with your friends and family. Browse all the albums published by users of conveylive to share and comment.";
    $con->tp->assign("descrip", $desc);
    
    $keys = "Photos, Albums, Picture, Share, ConveyLive";
    $con->tp->assign("keys", $keys);
    $con->tp->assign('title', $title);
    $ret_arr = array();
    $ret_arr['err'] = $err;
    $ret_arr['rep'] = $rep;
    $ret_arr['bbody'] = $bbody;
    $ret_arr['btitle'] = $btitle;
    $ret_arr['bsubtitle'] = $bsubtitle;
    
    return $ret_arr;
}

function new_album($con, $email, $id)
{
    if(isset($_SESSION['curr_album_id']))
    {
        $aid = $_SESSION['curr_album_id'];
        $con->tp->assign('aid', $aid);
    }
    //Setting Category Id
    $cat = getCatListDb($con, "Album");
    foreach($cat as $c)
    {
        $category_id = $c['id'];
        break;
    }
    if($category_id != null)
    {
        $con->tp->assign('category_id', $category_id);
    }
    
    
    $max_img = 50;
    $max_album = 5;
    $createAlbum = true;
     
    $btitle = "New Photo Albums";
    $bsubtitle = "Create new album and upload images or add new pictures to published albums.";
    
    $title = "conveylive.com :: New Photo Albums";
    
    $con->tp->assign('email', $email);

    $r = $con->db->selectData("select * from albums where user_email = '$email' and admin_perm = 0 and (privacy = 0 or privacy = 1 or privacy = 2) order by ins_date desc");
    if($r != false and $r != array())
    {
        foreach($r as $a)
        {
            $albumList[] = $a;
        }
    }

    $createImage = false;
    for($i=0, $j=0; $i < count($albumList); $i++)
    {
        $query = "select count(*) as tot from images where user_email = '$email' and admin_perm = 0 and stat = 0 and album_id = ".$albumList[$i]['id']."";
        $r = $con->db->selectData($query);
        if($r != false && $r != array())
        {
            $tot = $r[0]['tot'];
            if($tot < $max_img)
            {
                $createImage = true;
                $albumList[$j]['tot'] = $tot;
                $j++;
            }
            
        }
        $err .= $con->db->err;
    }
    $desc = "Publish your albums with conveylive. Share Your photos with your friends and family. Browse all the albums published by users of conveylive to share and comment.";
    $con->tp->assign("descrip", $desc);
    
    $keys = "Photos, Albums, Picture, Share, ConveyLive";
    $con->tp->assign("keys", $keys);
    
    
    $con->tp->assign('createImage', $createImage);
    $con->tp->assign('createAlbum', $createAlbum);
    $con->tp->assign('max_img', $max_img);
    $con->tp->assign('max_album', $max_album);
    $con->tp->assign('albums', $albumList);
    
    $bbody = $con->tp->fetch('album_form.tpl');
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
