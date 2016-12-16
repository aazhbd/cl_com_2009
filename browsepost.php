<?php
require_once('config/project.php');
$con = new Project();

$pageName ='Browse Post';

$rep = "";
$err = "";
$btitle = "";
$bbody = "";
$sideitem = array();
$islogin = false;


$con->tp->assign('title', $title);

getLatestCont($con,"Blogs");

if(isset($_SESSION['login'] ) == true)
{
    $l = $_SESSION['login'];
    $islogin = true;
    $email = $l->getEmail();
}
$con->tp->assign('islogin',$islogin);
extract($_GET);

$r = $con->db->selectData("select * from blogs, users where url = '$b' and blogs.admin_perm = 0 and blogs.user_email = users.email");
if($r == false || $r == array() || count($r) == 0 )
{
    $err .= $con->db->err;
}
else
{
    foreach($r as $rs)
    {
        $blog = $rs;
    }
    $user_email =  $blog['email'];
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
}
$qvar = 'blg';
$sess_name = 'blogs';

if(isset($_SESSION[$sess_name]))
{
    SmartyPaginate::setCurrentItem($start);
    
    $currIndex = SmartyPaginate::getCurrentIndex();
    $limit = SmartyPaginate::getLimit();

    $l = sprintf(" LIMIT %d, %d", $currIndex, $limit);
    
    $_query = $_SESSION[$qvar];
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

$post_count = count($postList);
$con->tp->assign('pcount', $post_count);

$con->tp->assign('blog', $blog);
$btitle = $blog['cname'];
$bsubtitle = "<a href='".URL."/profile/view/".$blog['pid']."'>".$blog['f_name'] . " " . $blog['l_name'] . "</a>'s Blog";


//Content Invite
$cont_formlabel = "Invite your friends to read this blog post";
$con->tp->assign('cont_formlabel', $cont_formlabel);

$mail_subject = getUserName($email, $con) . " invites you to view this blog named, \"". $blog['name'] . "\"";
$con->tp->assign('mail_subject', $mail_subject);

$mail_subject_general = "You have been invited to visit a blog named, \"". $blog['name'] . "\" by your friend ";
$con->tp->assign('mail_subject_general', $mail_subject_general);


//$mail_body = "Hi, \r\n";  
$mail_body .= "I wanted to invite you to read this blog titled, \"".$blog['name'] ."\", published by ".$blog['f_name'] ." ".$blog['l_name'].". ";
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

$title = $blog['name'] . " - Blog of " . getUserName($email, $con)." :: ConveyLive";
$con->tp->assign('title', $title);

$desc = $blog['name'] . " - Blog of ". $blog['f_name'] ." ". $blog['l_name'] .". Share Your Blogs and posts with your friends and family. Browse all the blogs published by users of conveylive to share and comment.";
$con->tp->assign("descrip", $desc);

$keys = $blog['name'] . " , ". $blog['f_name'] ." ,". $blog['l_name'] .", Blogs, Posts, Share, ConveyLive";
$con->tp->assign("keys", $keys);

$v = setLoginInfo(trim($email), $con);

$con->tp->assign('islogin',$islogin);

$sideitem = getSideItems(trim($email), $con);

$blogexist = checkBlog($con, $email);

$con->tp->assign('btitle', $btitle);

$con->tp->assign('bsubtitle', $bsubtitle);

$con->tp->assign('bbody', $bbody);

$con->tp->assign('sideitem', $sideitem);

$con->tp->assign('rep', $rep);

$con->tp->assign('err', $err);

addSiteStat($pageName, $con, $email);

$con->tp->display('main.tpl');
?>