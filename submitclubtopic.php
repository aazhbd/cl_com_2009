<?php
if(!isset($_POST['submit'])){ echo "You can not access this page directly."; return; }

require_once('config/project.php');
$con = new Project();

$pageName ='Submit Topic';

$title = "ConveyLive :: Club Topic";
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
$privacy = 0;
$admin_perm = 0;

$bodytxt = $_POST['bodytxt'];
$bodytxt = htmlentities($bodytxt);


$date_pub = date("Y-m-d H:i:s");
$table = "articles";
$id = getNewId($table, $con);
$admin_perm = 0;
$privacy = 0;
$view_count = 0;
$rating = 0;

$fields = array("id", "user_email", "title", "body", "ins_date","upd_date", "art_typ","privacy","admin_perm", "meta_tags");
$values = array("'".$id."'", "'".$email."'","'".addslashes($arttitle)."'","'".addslashes($bodytxt)."'", "'".$date_pub."'", "'".$date_pub."'" ,"'".$atype."'", "'".$privacy."'", "'".$admin_perm."'", "'".$keywords."'");

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

    $fields = array("id", "user_email","club_id" , "media_id", "media_type", "admin_perm", "ins_date", "upd_date");
    $values = array("'".$id."'", "'".$email."'", $club_id, "'".$media_id."'", "'".$media_type."'", "'0'", "'".$date_pub."'", "'".$date_pub."'");

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
$uname = getUserName($email, $con);
$memberList = getAllMembers($con, $club_id);

if($art_ins && $post_ins && count($memberList) > 0 && $memberList != null)
{
    foreach($memberList as $mem)
    {
        $name = getUserName($mem['email'], $con);
        $subject = "A new club topic has been published.";
        $msgBody = "Hello, $name \r\n\r\n";
        $msgBody .= "A new topic has been published by $uname in $club_name club.\r\n\r\n";
        $msgBody .= "To see this topic post, follow the link below: \r\n\r\n http://conveylive.com/clubs/viewpost/$id";
        $msgBody .= "\r\n\r\nThanks\r\n\r\nConveylive Team\r\n\r\n";
        $msgBody .= "-------\r\n\r\nFind people from your address book on Conveylive! Go to: http://conveylive.com/invite.php";
        $msgBody .= "\r\n\r\nThis message was intended for ".$mem['email'];
        
        $fromAr = array( "mail@conveylive.com" => "conveylive.com");
        $toAr = array($mem['email'] => $name );
        
        $isMailSent = simpleMail($con, $msgBody, $subject, $fromAr, $toAr, "text/plain" ,array("mail@conveylive.com" => "Conveylive Team") , 3);
        if($isMailSent)
        {
            $sentAr[] = $mem['f_name'] . " ". $mem['l_name'];
        }
        else
        {
            $failAr[] = $mem['f_name'] . " ". $mem['l_name'];
        }
    }
    if(count($sentAr) == count($memberList) )
    {
        $rep = "Your club topic has been published.";
    }
    else
    {
        $e = implode(",", $failAr);
        $err .= "Failed to send message to : " . $e;
    } 
}
else
{
    $err = "Could not publish post: " .$err;
    $btitle = "Post Publishing failed";
    $bbody = "We are sorry. Your post was not published. Please try again.";
}
$con->tp->assign('islogin',$islogin);
$retList = viewPost($con, $email, $id);

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

$con->tp->assign('vad', $vad);

$con->tp->assign('had', $had);

addSiteStat($pageName, $con, '');

$con->tp->display('main.tpl');
?>