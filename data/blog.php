<?php
function blogview($con, $email, $section)
{
    $rep = "";
    $err = "";
    $btitle = "";
    $bbody = "";
    $bsubtitle = "";
    
    $r = $con->db->selectData("select * from blogs, users where url = '$section' and blogs.admin_perm = 0 and blogs.user_email = users.email");
    
    if($r == false || $r == array() || count($r) == 0 )
    {
        $err .= $con->db->err;
        return null;
    }
    else
    {
        foreach($r as $rs)
        {
            $blog = $rs;
        }
        
        $user_email =  $r[0]['email'];
        $r = $con->db->selectData("select id, user_imgs_id from profiles where user_email = '$user_email' and admin_perm = 0 and active = 0");
        if($r == false || $r == array() || count($r) == 0 )
        {
            $err .= $con->db->err;
        }
        else
        {
            $pid = $r[0]['id'];
            $img_id = $r[0]['user_imgs_id'];
        }
        
        $blog['pid'] = $pid;
        $blog['img_id'] = $img_id;
        
        $blog_id = $blog['id'];
                
        $perPage = 10;
        $pageLimit = 10;
        $found = false;
        $qvar = 'blg';
        
        $query = "select count(*) as tot from articles, bposts where blog_id = $blog_id and bposts.admin_perm = 0 and articles.user_email = bposts.user_email and bposts.article_id = articles.id and articles.art_typ = 2";
        $url = URL ."/browsepost.php?b=$section";
        $_query = "select articles.*, bposts.id as post_id, bposts.ins_date as cdate from articles, bposts where blog_id = $blog_id and bposts.admin_perm = 0 and articles.user_email = bposts.user_email and bposts.article_id = articles.id and articles.art_typ = 2 order by bposts.ins_date desc ";
        
        $sess_name = 'blogs';
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

                    foreach($res as $rs)
                    {
                        $postList[$i] = $rs;
                        $body = $postList[$i]['body'];
                        $body = html_entity_decode($body);
                        
                        $body = strip_tags($body);
                        
                        $postList[$i]['body'] = $body;
                        
                        $post_id = $postList[$i]['post_id'];
                        
                        $coms = getComList($post_id, 'Blog Post', $con);
                        if(is_array($coms) && count($coms) > 0)
                        {
                            $postList[$i]['com_count'] = count($coms);
                        }
                        
                        $m = $con->db->selectData("select id, view_count, rating, tothits, neghits, ins_date, upd_date from contstats where media_id = ".$post_id." and media_type = 'Blog' and admin_perm = 0 ");
                        if($m != false && $m != array())
                        {
                            $postList[$i] ['view_count'] = $m[0]['view_count'];
                            $postList[$i] ['rating'] = $m[0]['rating'];
                            $postList[$i] ['tothits'] = $m[0]['tothits'];
                            $postList[$i] ['neghits'] = $m[0]['neghits'];
                            $postList[$i] ['stat_ins_date'] = $m[0]['ins_date'];
                            $postList[$i] ['stat_upd_date'] = $m[0]['upd_date'];
                        }

                        $i++;
                    }
                    $con->tp->assign('postList', $postList);
                }
                $err .= $con->db->err;
                
                SmartyPaginate::assign($con->tp);

            }
            else
            {
                $err .= $con->db->err;
                
                $err .= "Session is not set. Blog not found";
                
                $btitle = "Blog not available";
            }
        }
        $post_count = count($postList);
        $con->tp->assign('pcount', $post_count);
        
        $con->tp->assign('blog', $blog);
        $btitle = $blog['cname'];
        $bsubtitle = "<a href='".URL."/profile/view/".$blog['pid']."'>".$blog['f_name'] . " " . $blog['l_name'] . "</a>'s Blog";
    }
    //Content Invite
    $cont_formlabel = "Invite your friends to read this blog post";
    $con->tp->assign('cont_formlabel', $cont_formlabel);
    
    $mail_subject = getUserName($email, $con) . " invites you to view this blog named, \"". $blog['cname'] . "\"";
    $con->tp->assign('mail_subject', $mail_subject);
    
    $mail_subject_general = "You have been invited to visit a blog named, \"". $blog['cname'] . "\" by your friend ";
    $con->tp->assign('mail_subject_general', $mail_subject_general);
    
    
    //$mail_body = "Hi, \r\n";  
    $mail_body .= "I wanted to invite you to read this blog titled, \"".$blog['cname'] ."\", published by ".$blog['f_name'] ." ".$blog['l_name'].". ";
    $mail_body .= "You can join in conveylive.com to add comments to this blog posts. Go to this link or copy paste it in your browser ";
    $mail_body .= URL . "/b/".$blog['url'] ;
    $mail_body .= " and let me know if you liked it.";
    //$mail_body .= "\r\n\r\nRegards";
    $con->tp->assign('mail_body', $mail_body);
    
    $conttype = "blog_list";
    $con->tp->assign('conttype', $conttype);
    //Content Invite End
    
    $con->tp->assign('email', $email);
    $bbody = $con->tp->fetch('blog_view.tpl');
    
    $title = $blog['cname'] . " - Blog of ". $blog['f_name'] ." ". $blog['l_name'] . " :: ConveyLive";
    $con->tp->assign('title', $title);
    
    $desc = $blog['cname'] . " - Blog of ". $blog['f_name'] ." ". $blog['l_name'] .". Share Your Blogs and posts with your friends and family. Browse all the blogs published by users of conveylive to share and comment.";
    $con->tp->assign("descrip", $desc);
    
    $keys = $blog['cname'] . " , ". $blog['f_name'] ." ,". $blog['l_name'] .", Blogs, Posts, Share, ConveyLive";
    $con->tp->assign("keys", $keys);
    
    $con->tp->assign("email", $email);
    
    $ret_arr = array();
    $ret_arr['err'] = $err;
    $ret_arr['rep'] = $rep;
    $ret_arr['bbody'] = $bbody;
    $ret_arr['btitle'] = $btitle;
    $ret_arr['bsubtitle'] = $bsubtitle;
    
    return $ret_arr;
}

function bpostview($con, $email, $section, $post_id = '')
{
    if(!is_numeric($post_id))
    {
        return null;
    }
    $q = "select * from bposts where id = $post_id and bposts.admin_perm = 0";

    $r = $con->db->selectData($q);
    
    if($r == false || $r == array() || count($r) == 0 )
    {
        $err .= $con->db->err;
    }
    else
    {
        foreach($r as $a)
        {
            $bpost = $a;
        }
    }

    $q = "select * from blogs, users where id = ".$bpost['blog_id']." and blogs.url = '$section' and user_email = email";

    $r = $con->db->selectData($q);
    if($r == false || $r == array() || count($r) == 0 )
    {
        $err .= $con->db->err;
    }
    else
    {
        foreach($r as $a)
        {
            $blog = $a;
        }
        
        $r = $con->db->selectData("select id, user_imgs_id from profiles where user_email = '".$blog['user_email']."' and admin_perm = 0 and active = 0");
        if($r == false || $r == array() || count($r) == 0 )
        {
            $err .= $con->db->err;
        }
        else
        {
            foreach($r as $a)
            {
                $prof = $a;
            }
        }
        if(count($prof) > 0)
        {
            $blog['pid'] = $prof['id'];
            $blog['user_imgs_id'] = $prof['user_imgs_id'];
        }
        else
        {
            $blog['pid'] = "";
            $blog['user_imgs_id'] = "";
        }
    }
    $article_id = $bpost['article_id'];
    
    $r = $con->db->selectData("select * from articles where id = ".$article_id." and admin_perm = 0 and art_typ = 2");
    if($r == false || $r == array() || count($r) == 0 )
    {
        $err .= $con->db->err;
    }
    else
    {
        $post = array();
        foreach($r as $a)
        {
            $post = $a;
            $body = $post['body'];
            $body = stripcslashes($body);
            $body = html_entity_decode($body);;
            $post['body'] = $body;
            $dt = $post['upd_date'];
            $date = new DateTime($dt);
            $post['upd_date'] = $date->format("l, F j, Y, g:i a");
            
            $post['post_id'] = $post_id;
            
            $m = $con->db->selectData("select id, view_count, rating, tothits, neghits, ins_date, upd_date from contstats where media_id = ".$post_id." and media_type = 'Blog' and admin_perm = 0 ");
            if($m != false && $m != array())
            {
                $post['view_count'] = $m[0]['view_count'];
                $post['rating'] = $m[0]['rating'];
                $post['tothits'] = $m[0]['tothits'];
                $post['neghits'] = $m[0]['neghits'];
                $post['stat_ins_date'] = $m[0]['ins_date'];
                $post['stat_upd_date'] = $m[0]['upd_date'];
            }            
        }
    }
        
    $latArt = array();
    $r = $con->db->selectData("select * from blogs where admin_perm = 0  order by ins_date desc LIMIT 0, 5");
    if($r == false || $r === array() || count($r) == 0) $err .= $con->db->err;
    else
    {
        foreach($r as $a)
        {
            $latArt[] = $a;
        }
    }
    
    $con->tp->assign('latArt', $latArt);
    
    //Update View
    if($email != $post['user_email'])
    {
        $c = (int)$post['view_count'] + 1;
        
        $query = "update contstats set view_count = $c where media_id = $post_id and media_type = 'Blog' ";
        
        $u = $con->db->executeNonQuery($query);
        
        $post['view_count'] = $c;
    }
    
    //Comments
    $coms = getComList($post_id, 'Blog Post', $con);
    //print_r($coms);
    if(is_string($coms)) $err .= $coms;
    if(is_array($coms) )
    {
        $post['com_count'] = count($coms);
    }
    $con->tp->assign('coms', $coms);
    
    //Next and Prev
    $next = array();
    $q = "select bposts.id as post_id, title from bposts, articles where art_typ = 2 and articles.id = bposts.article_id and articles.user_email = bposts.user_email and articles.admin_perm = 0 and bposts.admin_perm = 0 and blog_id = ".$bpost['blog_id']."  order by bposts.id desc";

    $r = $con->db->selectData($q);
    if($r == false || $r === array() || count($r) == 0) $err .= $con->db->err;
    else
    {
        foreach($r as $a)
        {
            if( $a['post_id'] < $post_id )
            {
                $next = $a;
                break;
            }
        }
    }

    $con->tp->assign('next', $next);
    
    $prev = array();
    $q = "select bposts.id as post_id, title from bposts, articles where art_typ = 2 and articles.id = bposts.article_id and articles.user_email = bposts.user_email and articles.admin_perm = 0 and bposts.admin_perm = 0 and blog_id = ".$bpost['blog_id']." order by  bposts.id asc";

    $r = $con->db->selectData($q);
    if($r == false || $r === array() || count($r) == 0) $err .= $con->db->err;
    else
    {
        foreach($r as $a)
        {
            if($a['post_id'] > $post_id )
            {
                $prev = $a;
                break;
            }
        }
    }

    $con->tp->assign('prev', $prev);
    
    //Post List
    $postList = array();
    $q = "select bposts.id as post_id, title from bposts, articles where art_typ = 2 and articles.id = bposts.article_id and articles.user_email = bposts.user_email and articles.admin_perm = 0 and bposts.admin_perm = 0 and blog_id = ".$bpost['blog_id']." order by  bposts.ins_date asc LIMIT 0, 10";

    $r = $con->db->selectData($q);
    if($r == false || $r === array() || count($r) == 0) $err .= $con->db->err;
    else
    {
        foreach($r as $a)
        {
            $postList[] = $a;
        }
    }

    $con->tp->assign('postList', $postList);
    
    $keys = $post['title'] .", ". $blog['f_name'].", " .$blog['l_name']. ", ". $post['category_id']. ", ". $post['meta_tags'];
    $con->tp->assign('keys', $keys);
    
    $btitle = $blog['cname'];
    $bsubtitle = "<a href='".URL."/profile/view/".$blog['pid']."'>".$blog['f_name'] . " " . $blog['l_name'] . "</a>'s Blog";
    $con->tp->assign('email', $email);
    $con->tp->assign('post', $post);
    $con->tp->assign('blog', $blog);

    //Content Invite
    $cont_formlabel = "Invite your friends to read this blog post";
    $con->tp->assign('cont_formlabel', $cont_formlabel);
    
    $mail_subject = getUserName($email, $con) . " invites you to view this blog post named, \"". $post["title"] . "\"";
    $con->tp->assign('mail_subject', $mail_subject);
    
    $mail_subject_general = "You have been invited to visit a blog post named, \"". $post["title"] . "\" by your friend ";
    $con->tp->assign('mail_subject_general', $mail_subject_general);
    
    
    //$mail_body = "Hi, \r\n";  
    $mail_body .= "I wanted to invite you to read this blog post titled, \"".$post["title"] ."\", published by ".$blog['f_name'] ." ".$blog['l_name'].". ";
    $mail_body .= "You can join in conveylive.com to add comments to this blog post. Go to this link or copy paste it in your browser ";
    $mail_body .= URL . "/b/".$blog['url'] . "/".$post_id;
    $mail_body .= " and let me know if you liked it.";
    //$mail_body .= "\r\n\r\nRegards";
    $con->tp->assign('mail_body', $mail_body);
    
    $conttype = "blog_post";
    $con->tp->assign('conttype', $conttype);
    //Content Invite End
    
    $con->tp->assign('post_id', $post_id);
    $bbody = $con->tp->fetch('post_view.tpl');
    
    $title = $post['title'] . " - Post from ". $blog['cname'] . " - Blog of ". $blog['f_name'] ." ". $blog['l_name'] . " :: ConveyLive";
    $con->tp->assign('title', $title);
    
    $desc =  $post['title'] . " - Post from ". $blog['cname'] . " - Blog of ". $blog['f_name'] ." ". $blog['l_name'] .". Share Your Blogs and posts with your friends and family. Browse all the blogs published by users of conveylive to share and comment.";
    $con->tp->assign("descrip", $desc);
    
    $sub = strip_tags($post['sub_title']);
    $sub = substr($sub,0, 40);
    $sub = trim($sub);
    
    $d = strip_tags($post['body']);
    $d = substr($d,0, 40);
    $d = trim($d);
    
    $keys = trim($post['meta_tags']). ", " .trim($post['title']) . "," .trim($sub) .", Post ,". $blog['cname'] . ", Blog ,  ". $blog['f_name'] ." ". $blog['l_name'] .", Blogs, Posts, Share, ConveyLive";
    $con->tp->assign("keys", $keys);
    
    $ret_arr = array();
    $ret_arr['err'] = $err;
    $ret_arr['rep'] = $rep;
    $ret_arr['bbody'] = $bbody;
    $ret_arr['btitle'] = $btitle;
    $ret_arr['bsubtitle'] = $bsubtitle;
    
    return $ret_arr;
}

function blog($con, $email, $section,  $id = '')
{
    $rep = "";
    $err = "";
    $btitle = "";
    $bbody = "";
    $subtitle = "";
    $skip = false;
    
    switch($section)
    {   
        case 'rateup':
            $media_type = "Blog";
            
            $media_id = $id;
            
            $upd = rateChange($con, $media_type, $media_id, 'up');

            if($upd != false  )
            {
                $rep = "Blog post rating updated";
            }
            $err .= $con->db->err;
            
            
            $section = getBlogURLbyId($con,$id);
            
            $retList = bpostview($con, $email, $section, $id);
            
            $bbody = $retList['bbody'];
            $btitle = $retList['btitle'];
            $bsubtitle = $retList['bsubtitle'];
            $rep .= $retList['rep'];
            $err .= $retList['err'];
        break;
        
        case 'ratedown':
            $media_type = "Blog";
            
            $media_id = $id;
            
            $upd = rateChange($con, $media_type, $media_id, 'down');

            if($upd != false  )
            {
                $rep = "Blog post rating updated";
            }
            $err .= $con->db->err;
            
            
            $section = getBlogURLbyId($con,$id);
            
            $retList = bpostview($con, $email, $section, $id);
            
            $bbody = $retList['bbody'];
            $btitle = $retList['btitle'];
            $bsubtitle = $retList['bsubtitle'];
            $rep .= $retList['rep'];
            $err .= $retList['err'];
        break;
        
        case 'deletepost':
            $r = $con->db->selectData("select article_id from bposts where bposts.id = $id");
            if($r != false && count($r) > 0 && $r != array()) 
                $art_id = $r[0]['article_id'];
            else
            {
                $err .= "Could not select art_id".$con->db->err;
            }
            if(isset($art_id))
            {
                $r = $con->db->executeNonQuery("update articles set admin_perm = 1 where articles.user_email = '$email' and art_typ = 2 and articles.admin_perm = 0 and articles.id = $art_id; ");
                if($r != false  )
                {
                    $r = $con->db->executeNonQuery("update comments set admin_perm = 1 where user_email = '$email' and media_id = $art_id and mtype = 'Blog Post' ");
                    if($r != false  )
                    {
                        $r = $con->db->executeNonQuery("update bposts set admin_perm = 1 where user_email = '$email' and article_id = $art_id");
                        if($r != false  )
                        {
                            $rep = "Your post has been deleted.";
                            $btitle = "Post Deleted";
                        }
                        else
                        {
                            $err .= "Could not delete post.".$con->db->err;
                        }
                    }
                    else
                    {
                        $err .= "Could not delete comment.".$con->db->err;
                    }
                }
            }
            else
            {
                $err .= "Could not delete post".$con->db->err;
            }
            $r = $con->db->selectData("select user_email, url from blogs where user_email = '$email'");
            if($r != array() && $r != false && count($r) > 0)
            {
                $blog_url = $r[0]['url'];
            }
            
            $retList = blogview($con, $email, $blog_url);
            
            $bbody = $retList['bbody'];
            $btitle = $retList['btitle'];
            $bsubtitle = $retList['bsubtitle'];
            $rep .= $retList['rep'];
            $err .= $retList['err'];
            
        break;
        
        case 'deleteblog':
            $isdel = false;
            $cat = getCatsByName($con, "post");
            if(count($cat) > 0)
            {
                $cat_id = $cat['id'];
            }
            $r = $con->db->executeNonQuery("update articles set admin_perm = 1 where category_id = '$cat_id' and user_email='$email'");
            if($r != false  )
            {
                $posts = getBlogPosts($con, $id);
                foreach($posts as $p)
                {
                    $has_del = deleteCom($p['id'], "Blog Post", $con);
                    if($has_del)
                    {
                        $del_row[] = $p;
                    }
                }
                if(count($del_row) == count($posts))
                {
                    $isdel = true;
                }
                if($isdel)
                {
                    $r = $con->db->executeNonQuery("update bposts set admin_perm = 1 where user_email = '$email' and blog_id = $id");
                    if($r != false  )
                    {
                        $r = $con->db->executeNonQuery("update blogs set admin_perm = 1 where id = $id and user_email = '$email'");

                        if($r != false  )
                        {
                            $rep = "Your Blog has been deleted.";
                            $btitle = "Blog Deleted";
                        }
                        else
                        {
                            $err .= "Could not delete blog. ".$con->db->err;
                        }
                    }
                    else
                    {
                         $err .= "Could not delete bposts".$con->db->err;
                    }
                }
                else
                {
                     $err .= "Could not delete comments".$con->db->err;
                }                
            }
            else
            {
                 $err .= "Could not delete posts".$con->db->err;
            }
            checkBlog($con, $email);
            home($con,$email, 'user');
            $skip = true;
        break;
        
        case 'editblog':
            $btitle = "Edit Blog";
            $bsubtitle = "Edit your blog info to chose a different name and url.";
            $action = "update";
            $r =$con->db->selectData("select * from blogs where id = $id and admin_perm = 0");
            if($r == false || $r == array() || count($r) == 0) $err .= $con->db->err;
            else{
                foreach($r as $a)
                {
                    $blog = $r;
                }
            }
            $con->tp->assign('action', $action);
            $con->tp->assign('blog', $blog[0]);
            $con->tp->assign('email', $email);
            $bbody = $con->tp->fetch('create_blog.tpl');
            
            $title = $blog[0]['cname'] . " - Blog of ". getUserName($email,$con) . " :: conevylive.com";
            $con->tp->assign('title', $title);
            
            $desc = $blog[0]['cname'] . " - Blog of ". getUserName($email,$con). ". Browse Blogs and Share Your Blogs and posts with your friends and family. Browse all the blogs published by users of conveylive to share and comment.";
            $con->tp->assign("descrip", $desc);
            
            $keys = $blog[0]['cname'] . " , ". getUserName($email,$con). "Blogs, Posts, Share, ConveyLive";
            $con->tp->assign("keys", $keys);
        break;
        
        case 'editpost':
            $atype = 2;
            $blog_id = 0;
            $bsubtitle = "Edit your posts.";
            $action = "update";
            $art = array();
            $btitle = "Edit post";
            $bsubtitle = "Edit your post";
            $con->tp->assign('email', $email);
            
            $coneditor_js = "subtpl/coneditor_js.tpl";
            $con->tp->assign('coneditor_js', $coneditor_js);
            
            $r = $con->db->selectData("select id from blogs where user_email = '$email' and admin_perm = 0");
            if($r == array() || $r == false || count($r) == 0)
            {
                $err .= $con->db->err;
            }
            $blog_id = $r[0]['id'];
            $r = $con->db->selectData("select category_id, articles.id as id, bposts.id as post_id, body, title, sub_title, remarks, meta_tags, blog_id   from articles, bposts where bposts.id = $id and bposts.article_id = articles.id and bposts.admin_perm = 0 and bposts.blog_id = $blog_id and articles.admin_perm = 0 and articles.user_email = '$email' and bposts.user_email ='$email'");
            
            if($r == false || $r == array() || count($r) <= 0) $err = $con->db->err;
            else{
                $i =0;
                foreach($r as $a)
                {
                    $art = $a;
                    $body = $art['body'];
                    
                    $body = stripslashes($body);
                    $body = html_entity_decode($body);
                    $title = $art['title'];
                    $subtitle = $art['sub_title'];
                    $remarks = $art['remarks'];
                    $keywords = $art['meta_tags'];
                    $cat_id = $art['category_id'];
                    $art['body'] = $body;
                    
                    $art['title'] = stripslashes($title);
                    $art['sub_title'] = stripslashes($subtitle);
                    $art['remarks'] = stripslashes($remarks);
                    $art['meta_tags'] = stripslashes($keywords);
                    $i++;
                }
            }
            
            $blog = array();
            $r = $con->db->selectData("select user_email, url, cname from blogs where user_email = '$email'");
            if($r != array() && $r != false && count($r) > 0)
            {
                foreach($r as $a)
                {
                    $blog = $a;
                }
            }
            
            $fckEditor = loadFckEditMode($con, $art['body']); 
            
            $con->tp->assign('fckEditor', $fckEditor);
            
            $con->tp->assign('cat_id', $cat_id);
            $con->tp->assign('post_id', $id);
            $con->tp->assign('blog_id', $blog_id);
            $con->tp->assign('atype', $atype);
            $con->tp->assign('bsubtitle', $bsubtitle);
            $con->tp->assign('art', $art);
            $con->tp->assign('catList', $catList);
            $con->tp->assign('action', $action);
            $bbody = $con->tp->fetch('blogpost_form.tpl');
            
            $title = "Edit Post: ".$art['title'] ." from ". $blog['cname'] . " - Blog of ". getUserName($email,$con) . " :: ConveyLive";
            
            $desc = "Edit Post: ".$art['title'] ." from ". $blog['cname'] . " - Blog of ". getUserName($email,$con). ". Browse Blogs and Share Your Blogs and posts with your friends and family. Browse all the blogs published by users of conveylive to share and comment.";
            $con->tp->assign("descrip", $desc);
            
            $keys = "Edit Post: ".$art['title'] ." , ". $blog['cname'] . " Blog , ". getUserName($email,$con). "Blogs, Posts, Share, ConveyLive";
            $con->tp->assign("keys", $keys);
            
            $con->tp->assign('title', $title);
        break;
        
        case 'new':
            $atype = 2;
            $blog_id = 0;
            $bsubtitle = "Write somethng to share your views";
            $action = "create";
            
            $coneditor_js = "subtpl/coneditor_js.tpl";
            $con->tp->assign('coneditor_js', $coneditor_js);
            
            $r = $con->db->selectData("select id, cname, url from blogs where user_email = '$email'");
            if($r == array() || $r == false || count($r) == 0)
            {
                $err .= $con->db->err;
            }
            else
            {
                $blog_id = $r[0]['id'];
                $blog_name = $r[0]['cname'];
                $blog_url = URL . "/b/".$r[0]['url'];
            }
            $btitle = $blog_name ." - New Blog Post";
            $con->tp->assign('blog_id', $blog_id);
            $con->tp->assign('blog_url', $blog_url);
            $con->tp->assign('atype', $atype);
            $con->tp->assign('action', $action);
            $con->tp->assign('email', $email);
            $bbody = $con->tp->fetch('blogpost_form.tpl');
            
            $title = "conveylive :: New Blog Post";
            $con->tp->assign('title', $title);
            
            $desc = "Publish a new Blog Post. Browse Blogs and Share Your Blogs and posts with your friends and family. Browse all the blogs published by users of conveylive to share and comment.";
            $con->tp->assign("descrip", $desc);

            $keys = "Blogs, Posts, Share, ConveyLive";
            $con->tp->assign("keys", $keys);
            break;
            
        case 'create':
            $btitle = "Create a New Blog";
            $bsubtitle = "Create your own blog and discuss with your friends ";
            $action = "create";
            $con->tp->assign('action', $action);
            $con->tp->assign('email', $email);
            $bbody = $con->tp->fetch('create_blog.tpl');
            
            $title = "conveylive :: Create New Blog";
            $con->tp->assign('title', $title);
            
            $desc = "Create Your Own Blog - The most User Friendly Blog Ever. Browse Blogs and Share Your Blogs and posts with your friends and family. Browse all the blogs published by users of conveylive to share and comment.";
            $con->tp->assign("descrip", $desc);

            $keys = "Blogs, Posts, Share, ConveyLive";
            $con->tp->assign("keys", $keys);
        break;
        
        case 'browselatest':
            $btitle = "Browse Latest Blogs";
            $bsubtitle = "All Blogs are in order that are recently published";
            
            $title = "conveylive.com :: Browse Latest Blogs";
            $con->tp->assign('title', $title);
            
            $topicHead = "Latest Blogs";
            $con->tp->assign('topicHead', $topicHead);
            
            $desc = "Browse Blogs and Share Your Blogs and posts with your friends and family. Browse all the blogs published by users of conveylive to share and comment.";
            $con->tp->assign("descrip", $desc);
            
            $keys = "Blogs, Posts, Share, ConveyLive";
            $con->tp->assign("keys", $keys);
            
            $con->tp->assign('email', $email);
            
            $contType = "Blog";
            $sortType = "Latest";
            
            $retList = getContList($con, $email, $contType, $sortType);
            
            $bbody = $retList['bbody'];
            $btitle .= $retList['btitle'];
            $bsubtitle .= $retList['bsubtitle'];
            $rep .= $retList['rep'];
            $err .= $retList['err'];
        break;
            
        case 'browseall':
            $retList = browse_blogs($con, $email);
            
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
    }
    $con->tp->assign('bsubtitle', $bsubtitle);
    $con->tp->assign('rep', $rep);
    $con->tp->assign('err', $err);
}

function browse_blogs($con, $email)
{
    $btitle = "Browse Blogs";
    $bsubtitle = "Browse latest blogs";
    $con->tp->assign('email', $email);
    $topicHead = "<a href='".URL."/blog/browseall'>Latest Blogs</a>";
                    
    $perPage = 10;
    $pageLimit = 5;
    $found = false;
    
    $query = "select count(*) as tot from blogs, users where blogs.admin_perm = 0 and blogs.user_email = email";
    $url = URL ."/browseblog.php";
    $_query = "select blogs.* , f_name, l_name, email from blogs, users where blogs.admin_perm = 0 and blogs.user_email = email order by RAND() ";
    
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
    
    $title = "ConveyLive :: Browse Blogs";
    $con->tp->assign('title', $title);
    
    $desc = "Browse Blogs and Share Your Blogs and posts with your friends and family. Browse all the blogs published by users of conveylive to share and comment.";
    $con->tp->assign("descrip", $desc);
    
    $keys = "Blogs, Posts, Share, ConveyLive";
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
