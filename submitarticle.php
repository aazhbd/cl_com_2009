<?php
if(!isset($_POST['submit'])){ echo "You can not access this page directly."; return; }

require_once('config/project.php');
$con = new Project();

if(!isset($_SESSION['login'])){ echo "You can not access this page directly. Sorry your session has expired. Please try to <a href='".URL."'>login</a> again and access this page."; return; }

$pageName ='Submit Article';

$desc = "Publish your new writeups in custom format. Publish articles and writeups in conveylive and share your views. Get Amazed by the Huge collection of articles in conveylive";
$con->tp->assign("descrip", $desc);

$keys = "Articles, Writeups, communicate, share,network,  conveylive";
$con->tp->assign("keys", $keys);

$title = "ConveyLive :: Article";
$con->tp->assign('title', $title);

getLatestCont($con,"Pages");
getTopRatedCont($con,"Pages");
getMostViewedCont($con,"Pages");

$rep = "";
$err = "";
$btitle = "Sorry, Your page can not be published!";
$bbody = "Please fix the error to publish your page.";
$sideitem = array();
$islogin = false;
$art_ins = false;

//$privacy_type = array("private" => 1, "public" => 2);
//$art_type = array( 1 => "article", 2 => "blog", 3 => "post");

$con->tp->assign('title', $title);

if(isset($_SESSION['login'] ) == true)
{
    $l = $_SESSION['login'];
    $islogin = true;
    $email = $l->getEmail();
}

extract($_POST);

//Check unique url
$d = $con->db->selectData("select url from articles where url = '".$arturl."'");
if(count($d) > 0)
    $url_duplicate = true;
//end check

if($email == "")
    $err .= "Your Sesion has expired. Please try to login again.";
else if($url_duplicate)
    $err .= "Your URL is duplicate of an existing URL. Please chose another URL for your article. Click <a href='".URL."/article/new'>here</a> to go back.";    

$con->tp->assign('islogin',$islogin);

if(isset($_SESSION['article']))
{
    $bodytxt = $_SESSION['article']['bodytxt'];
    $bodytxt = htmlentities($bodytxt);
}

$table = "articles";
$id = getNewId($table, $con);

$ins_date = date("Y-m-d H:i:s");
$fields = array("id", "user_email", "title", "sub_title", "body", "remarks", "ins_date", "upd_date", "art_typ","category_id","privacy","admin_perm", "meta_tags", "url");
$values = array("'".$id."'", "'".$email."'","'".addslashes($arttitle)."'", "'".addslashes($subtitle)."'", "'".addslashes($bodytxt)."'", "'".addslashes($remarks)."'",  "'".$ins_date."'","'".$ins_date."'" , "'".$atype."'", "'".$cat_id."'", "'".$privacy."'", "'".$admin_perm."'", "'".addslashes($keywords)."'", "'".addslashes($arturl)."'");

$f = implode(",", $fields);
$v = implode(",", $values);

$query = "insert into $table ( $f ) values ( $v )";

if($err == "")
    $i = $con->db->executeNonQuery($query);

if($i == true)
{
    $view_count = 0;
    $tothits = 0;
    $neghits = 0;
    $rating = 0;
    $media_id = $id;
    $media_type = "Article";
    
    $contstat_ins = insertContStats($con, $email, $view_count, $tothits, $neghits, $rating, $media_id, $media_type);
    if($contstat_ins)
        $art_ins = true;
        
    //updateContStats($con, $email, $view_count, $tothits, $neghits, $rating, $media_id, $media_type, $ins_date, $upd_date, $admin_perm);
    //getContStats($con, $media_type, $media_id);    
}
$err .= $con->db->err;

if($art_ins)
    $rep = "Your article has been published.";
else
    $err = "We are sorry. Your article was not published. " . $err;

if($err == "")
    $retList = view_article($con, $email, $id);

$bbody = $retList['bbody'];
$btitle = $retList['btitle'];
$bsubtitle = $retList['bsubtitle'];
$rep .= $retList['rep'];
$err .= $retList['err'];

$v = setLoginInfo(trim($email), $con);

$con->tp->assign('islogin',$islogin);

$sideitem = getSideItems(trim($email), $con);

$blogexist = checkBlog($con, $email);

$con->tp->assign('sideitem', $sideitem);

$con->tp->assign('rep', $rep);

$con->tp->assign('bbody', $bbody);

$con->tp->assign('bsubtitle', $bsubtitle);

$con->tp->assign('btitle', $btitle);

$con->tp->assign('err', $err);

addSiteStat($pageName, $con, $email);

$con->tp->display('main.tpl');

?>