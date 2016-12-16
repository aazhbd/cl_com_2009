<?php
if(!isset($_POST['submit'])){ echo "You can not access this page directly."; return; }

require_once('config/project.php');
$con = new Project();

$pageName ='Update Article';


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

//$privacy_type = array("private" => 1, "public" => 2);
//$art_type = array( 1 => "article", 2 => "blog", 3 => "post");

//$con->tp->assign('title', $title);

getLatestCont($con,"Pages");
getTopRatedCont($con,"Pages");
getMostViewedCont($con,"Pages");

if(isset($_SESSION['login'] ) == true)
{
    $l = $_SESSION['login'];
    $islogin = true;
    $email = $l->getEmail();
}
$con->tp->assign('islogin', $islogin);
$blogexist = checkBlog($con, $email);

extract($_POST);

if(isset($_SESSION['article']))
{
    $bodytxt = $_SESSION['article']['bodytxt'];
    $bodytxt = htmlentities($bodytxt);
}
$table = "articles";

$date_pub = date("Y-m-d H:i:s");
$fields = array( "user_email", "title", "sub_title", "body", "remarks", "upd_date", "art_typ","category_id","privacy","admin_perm", "meta_tags", "url");
$values = array( "".$email."","".addslashes($arttitle)."", "".addslashes($subtitle)."", "".addslashes($bodytxt)."", "".addslashes($remarks)."", "".$date_pub."" ,"".$atype."", "".$cat_id."", "".$privacy."", "".$admin_perm."", "".addslashes($keywords)."", "".$arturl."");

$query = "update $table set ";
$i = 0;
foreach($fields as $f)
{
    if($i > 0) $query .= " , ";
    $query .= "".$f." = '".$values[$i]."'";
    $i++;
}

$query .= " where id = $art_id";

$i = $con->db->executeNonQuery($query);

if($i == true)
{
    $art_ins = true;
}
$err .= $con->db->err;

if($art_ins)
{
    $rep = "Your article has been updated.";
}
else
{
    $err .= "We are sorry. Your article was not published. Please try again.";
    $err .= "Could not publish article: ";
}

$retList = view_article($con, $email, $art_id);

$bbody = $retList['bbody'];
$btitle = $retList['btitle'];
$bsubtitle = $retList['bsubtitle'];
$rep .= $retList['rep'];
$err .= $retList['err'];

$con->tp->assign('bbody', $bbody);

$con->tp->assign('btitle', $btitle);

$con->tp->assign('bsubtitle', $bsubtitle);

$v = setLoginInfo(trim($email), $con);

$con->tp->assign('islogin',$islogin);

$sideitem = getSideItems(trim($email), $con);

$con->tp->assign('sideitem', $sideitem);

$con->tp->assign('rep', $rep);

$con->tp->assign('err', $err);

$con->tp->assign('vad', $vad);

$con->tp->assign('had', $had);

addSiteStat($pageName, $con, $email);

$con->tp->display('main.tpl');

?>