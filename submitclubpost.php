<?php
if(!isset($_POST['submit'])){ echo "You can not access this page directly."; return; }

require_once('config/project.php');
$con = new Project();

$pageName ='Submit Post';


$title = "ConveyLive :: Club Post";
$con->tp->assign('title', $title);
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

$con->tp->assign('title', $title);

getLatestCont($con,"Clubs");

if(isset($_SESSION['login'] ) == true)
{
    $l = $_SESSION['login'];
    $islogin = true;
    $email = $l->getEmail();
}

extract($_POST);

$rating = 0;
$view_count = 0;
$privacy = 2;
$admin_perm = 1;

$bodytxt = $_POST['bodytxt'];
$bodytxt = htmlentities($bodytxt);


$date_pub = date("Y-m-d H:i:s");
$table = "articles";
$id = getNewId($table, $con);
$admin_perm = 1;
$privacy = 2;
$view_count = 0;
$rating = 0;

$fields = array("id", "user_email", "title", "body", "date_pub", "rating", "view_count","art_typ","privacy","admin_perm", "meta_tags");
$values = array("'".$id."'", "'".$email."'","'".addslashes($arttitle)."'","'".addslashes($bodytxt)."'", "'".$date_pub."'","'".$rating."'" , "'".$view_count."'","'".$atype."'", "'".$privacy."'", "'".$admin_perm."'", "'".$keywords."'");

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
    $media_id = $id;
    $media_type = "Club Post";
    
    $table = "cposts";
    $id = getNewId($table, $con);

    $fields = array("id", "user_email","club_id" , "media_id", "media_type", "permission", "cdate");
    $values = array("'".$id."'", "'".$email."'", $club_id, "'".$media_id."'", "'".$media_type."'", "'1'", "'".$date_pub."'");

    $f = implode(",", $fields);
    $v = implode(",", $values);

    $query = "insert into $table ( $f ) values ( $v )";
    $i = $con->db->executeNonQuery($query);

    if($i == true)
    {
        $post_ins = true;
        $post_id = $id;
    }
    $err .= $con->db->err;
}


if($art_ins && $post_ins)
{
    $rep = "Your post has been published.";
    $btitle = "Post Published";
}
else
{
    $err = "Could not publish post: " .$err;
    $btitle = "Post Publishing failed";
    $bbody = "We are sorry. Your post was not published. Please try again.";
}
$retList = viewClub($con, $email, $club_id);

$bbody = $retList['bbody'];
$btitle = $retList['btitle'];
$bsubtitle = $retList['bsubtitle'];
$rep .= $retList['rep'];
$err .= $retList['err'];


$desc = "$arttitle - Club Post. Post New Topic in ConveyLive Club. Create Your own Clubs to discuss and share your digital possesions like, Photos, Files and text posts. Browse all the Clubs of conveylive published by users to share,comment and discuss.";
$con->tp->assign("descrip", $desc);

$keys = "$arttitle , club, New Topic, Send, essage, New Clubs, Posts, File, Share, Community, Network, ConveyLive";
$con->tp->assign("keys", $keys);

$v = setLoginInfo(trim($email), $con);

$con->tp->assign('islogin',$islogin);

$sideitem = getSideItems(trim($email), $con);

$blogexist = checkBlog($con, $email);

$con->tp->assign('btitle', $btitle);

$con->tp->assign('bbody', $bbody);

$con->tp->assign('sideitem', $sideitem);

$con->tp->assign('rep', $rep);

$con->tp->assign('err', $err);

$con->tp->assign('vad', $vad);

$con->tp->assign('had', $had);

addSiteStat($pageName, $con, '');

$con->tp->display('main.tpl');
?>