<?php
if(!isset($_POST['submit'])){ echo "You can not access this page directly."; return; }

require_once('config/project.php');
$con = new Project();

$pageName ='Submit Post';

$title = $pageName;
$rep = "";
$err = "";
$btitle = "";
$bbody = "";
$vad = "";
$had = "";
$sideitem = array();
$islogin = false;
$art_ins = false;
$art_upd = false;
$post_ins = false;
$post_upd = false;

//$privacy_type = array("private" => 1, "public" => 2);
//$art_type = array( 1 => "article", 2 => "b;og_post", 3 => "club_post");

getLatestCont($con,"Blogs");

$con->tp->assign('title', $title);

if(isset($_SESSION['login'] ) == true)
{
    $l = $_SESSION['login'];
    $islogin = true;
    $email = $l->getEmail();
}

extract($_POST);


switch($action)
{
    case 'create':
        $rating = 0;
        $view_count = 0;
        $privacy = 0;
        $admin_perm = 0;

        $bodytxt = $_POST['bodytxt'];
        $bodytxt = htmlentities($bodytxt);

        $cats = getCatsByName($con,"post");
        if($cats != null)
        {
            $category_id = $cats['id'];
        }
        
        $date_pub = date("Y-m-d H:i:s");
        $table = "articles";
        $id = getNewId($table, $con);

        $fields = array("id", "user_email", "title", "sub_title", "body", "remarks", "ins_date","upd_date" ,"art_typ","category_id","privacy","admin_perm", "meta_tags", "url");
        $values = array("'".$id."'", "'".$email."'","'".addslashes($arttitle)."'", "'".addslashes($subtitle)."'", "'".addslashes($bodytxt)."'", "'".addslashes($remarks)."'", "'".$date_pub."'","'".$date_pub."'" , "'".$atype."'", "'$category_id'", "'".$privacy."'", "'".$admin_perm."'", "'".addslashes($meta_tags)."'", "'".$id."'");

        $f = implode(",", $fields);
        $v = implode(",", $values);

        $query = "insert into $table ( $f ) values ( $v )";

        
        $i = $con->db->executeNonQuery($query);

        if($i == true)
        {
            $art_ins = true;
            $art_id = $id;
        }
        $err .= $con->db->err;

        if($art_ins)
        {
            $table = "bposts";
            
            $id = getNewId($table, $con);

            $fields = array("id", "blog_id" ,"user_email", "article_id", "admin_perm", "ins_date", "upd_date");
            $values = array("'".$id."'", "".$blog_id."", "'".$email."'","".$art_id."", "'0'", "'".$date_pub."'", "'".$date_pub."'");

            $f = implode(",", $fields);
            $v = implode(",", $values);

            $query = "insert into $table ( $f ) values ( $v )";
            $i = $con->db->executeNonQuery($query);

            if($i == true)
            {
                $post_ins = true;
                $post_id = $id;
                
                $view_count = 0;
                $tothits = 0;
                $neghits = 0;
                $rating = 0;
                $media_id = $id;
                $media_type = "Blog";
                
                $contstat_ins = insertContStats($con, $email, $view_count, $tothits, $neghits, $rating, $media_id, $media_type);
                if($contstat_ins)
                {
                    $art_ins = true;
                }
                
                $url = getBlogURLbyId($con, $post_id);            
            }
            $err .= $con->db->err;
        }


        if($art_ins && $post_ins)
        {
            $name = getUserName($email, $con);
            $subject = "Your blog post has been published.";
            $msgBody = "Hello, $name \r\n\r\n";
            $msgBody .= "Your Blog Post has been published.\r\n\r\n";
            $msgBody .= "To see the post, follow the link below: \r\n\r\n $blog_url/$blog_id";
            $msgBody .= "\r\n\r\nThanks\r\n\r\nConveylive Team\r\n\r\n";
            $msgBody .= "-------\r\n\r\nFind people from your address book on ConveyLive! Go to: http://conveylive.com/invite.php";
            $msgBody .= "\r\n\r\nThis message was intended for $email";

            $fromAr = array("mail@conveylive.com" => "conveylive.com");
            $toAr = $email;

            $isMailSent = simpleMail($con, $msgBody, $subject, $fromAr, array($toAr => $name) , "text/plain", $fromAr, 0);
            if($isMailSent)
            {
                $rep = "Post Published";
            }
            else
            {
                $err .= $isMailSent;
                $rep = "Post Published but mail not sent to notify";
            }
            $r = $con->db->selectData("select url from blogs where id = $blog_id and admin_perm = 0");
            if($r == true) $blog_url = $r[0]['url'];
        }
        else
        {
            $err .= "We are sorry. Your post was not published. Please try again.";
            $err .= "Could not publish post. ";
        }
    break;
    
    case 'update':
        $privacy = 0;
        $admin_perm = 0;

        $bodytxt = $_POST['bodytxt'];
        $bodytxt = htmlentities($bodytxt);
        //echo $bodytxt;

        $date_pub = date("Y-m-d H:i:s");
        $table = "articles";
        
        $fields = array("user_email", "title", "sub_title", "body", "remarks", "upd_date","art_typ","category_id","privacy", "meta_tags");
        $values = array("'".$email."'","'".addslashes($arttitle)."'", "'".addslashes($subtitle)."'", "'".addslashes($bodytxt)."'", "'".addslashes($remarks)."'", "'".$date_pub."'","'".$atype."'", "'".$cat_id."'", "'".$privacy."'", "'".addslashes($meta_tags)."'");


        for($i = 0; $i < count($fields); $i++)
        {
            if($i > 0) $setList .= ",";
            $setList .= $fields[$i]. " = " .$values[$i];
        }
        
        $query = "update $table set $setList where id = $id and admin_perm = 0 and art_typ = 2";

        $i = $con->db->executeNonQuery($query);

        if($i == true)
        {
            $art_upd = true;
            $art_id = $id;
        }
        $err .= $con->db->err;

        if($art_upd)
        {
            $table = "bposts";

            $fields = array("blog_id" ,"user_email", "article_id", "admin_perm", "upd_date");
            $values = array($blog_id, "'".$email."'","'".$art_id."'", "'0'", "'".$date_pub."'");
            
            $setList = "";
            for($i = 0; $i < count($fields); $i++)
            {
                if($i > 0) $setList .= ",";
                $setList .= $fields[$i]. " = " .$values[$i];
            }
         
        
            $query = "update $table set $setList  where article_id = $art_id and admin_perm = 0 and id = $post_id";
            
            $i = $con->db->executeNonQuery($query);

            if($i == true)
            {
                $post_upd = true;
                
                $url = getBlogURLbyId($con, $post_id);
            }
            $err .= $con->db->err;
        }


        if($art_upd && $post_upd)
        {
            $rep = "Your post has been updated.";
            
            $r = $con->db->selectData("select url from blogs where id = $blog_id and admin_perm = 0");
            if($r == true) $blog_url = $r[0]['url'];
        }
        else
        {
            $err .= "We are sorry. Your post was not published. Please try again.";
            $err .= "Could not publish post: ";
        }
}
$con->tp->assign('islogin',$islogin);

$con->tp->assign('email', $email);

$retList = bpostview($con, $email, $url, $post_id);

$bbody = $retList['bbody'];
$btitle = $retList['btitle'];
$bsubtitle = $retList['bsubtitle'];
$rep .= $retList['rep'];
$err .= $retList['err'];

$v = setLoginInfo(trim($email), $con);

$sideitem = getSideItems(trim($email), $con);

$blogexist = checkBlog($con, $email);

$con->tp->assign('btitle', $btitle);

$con->tp->assign('bbody', $bbody);

$con->tp->assign('sideitem', $sideitem);

$con->tp->assign('rep', $rep);

$con->tp->assign('err', $err);

addSiteStat($pageName, $con, $email);

$con->tp->display('main.tpl');

?>