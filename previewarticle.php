<?php
if(!isset($_POST['submit'])){ echo "You can not access this page directly."; return; }

require_once('config/project.php');
$con = new Project();

if(!isset($_SESSION['login'])){ echo "You can not access this page directly. Sorry your session has expired. Please try to <a href='".URL."'>login</a> again and access this page."; return; }

$pageName ='Preview Article';


$title = "ConveyLive :: $pageName";

getLatestCont($con,"Pages");
getTopRatedCont($con,"Pages");
getMostViewedCont($con,"Pages");

$desc = "Publish your new writeups in custom format and edit them anytime. Browse articles and writeups in conveylive and share your views. Get Amazed by the Huge collection of articles in conveylive";
$con->tp->assign("descrip", $desc);

$keys = "Articles, Writeups, communicate, share,network,  conveylive";
$con->tp->assign("keys", $keys);


$rep = "";
$err = "";
$btitle = "Sorry, Your page can not be published!";
$bbody = "Please fix the error to publish your page.";
$vad = "";
$had = "";
$sideitem = array();
$islogin = false;

$privacy_type = array("public" => 0, "private" => 1);
$art_type = array( "article" => 1, "blog" => 2 , "post" => 3);

$con->tp->assign('title', $title);

if(isset( $_SESSION['login']) == true)
{
    $l = $_SESSION['login'];
    $islogin = true;
    $email = $l->getEmail();
}

$_SESSION['article'] =  $_POST;

//Check unique url
$d = $con->db->selectData("select id, url from articles where url = '".$_POST['arturl']."'");
if(count($d) > 0 && $_POST['id'] > 0){
    if($_POST['id'] != $d[0]['id'])
        $url_duplicate = true;
}
//end check

if($email == "")
    $err .= "Please try to login again.";
else if($url_duplicate)
    $err .= "You can not publish this article. Your URL is duplicate of an existing URL. Please chose another URL for your article. ";
else{
    $date_pub = date("Y-m-d H:i:s");

    $rating = 0;
    $view_count = 0;
    $a_type = $art_type["article"];
    $privacy = $privacy_type["public"];
    $admin_perm = 0;

    $r = $con->db->selectData("select f_name, l_name from users where email = '$email'");
    $name = $r[0]['f_name']." ".$r[0]['l_name'];

    $art_data['article'] = array();

    $bodytxt =  ($_POST['bodytxt']);

    $con->tp->assign('action', $_POST['action']);
    $con->tp->assign('arttitle', $_POST['arttitle']);
    $con->tp->assign('subtitle', $_POST['subtitle']);

    $cat_id = $_POST['cat_id'];

    $catList = getCatListDb($con, 'Article');

    foreach($catList as $c)
    {
        if($c['id'] == $cat_id )
        {
            $cat = $c['cname'];
            break;
        }
    }
    if($cat != null)
    {
        $con->tp->assign('cat', $cat);
    }
    $con->tp->assign('cat_id', $cat_id);

    $con->tp->assign('txt', $_POST['bodytxt']);
    $con->tp->assign('bodytxt', $_POST['bodytxt']);
    $con->tp->assign('arturl', $_POST['arturl']);
    $con->tp->assign('id', $_POST['id']);
    $con->tp->assign('url', $_POST['arturl']);

    $con->tp->assign('remarks', $_POST['remarks']);
    $con->tp->assign('keywords', $_POST['keywords']);
    $con->tp->assign('date_pub', $date_pub);
    $con->tp->assign('rating', $rating);
    $con->tp->assign('view_count', $view_count);
    $con->tp->assign('name', $name);
    $con->tp->assign('atype',$a_type);
    $con->tp->assign('privacy',$privacy);
    $con->tp->assign('admin_perm', $admin_perm);

    $btitle = "Preview of Article";

    $bbody = $con->tp->fetch('preview_art.tpl');
    
    $previewloaded = true;
}

if( $previewloaded == false && isset($_SESSION['article']) )
{
    $ac = $_SESSION['article']['action'];
    if($ac == "add")
        $action = "add";
    else
        $action = "edit";
    
    $art = array();
    $btitle = "Edit Page";
    $bsubtitle = "Edit your published writeups";

    $catList = getCatList();

    if(isset($_SESSION['article']))
    {
        $art['id'] = $_POST['id'];
        $art['title'] = $_POST['arttitle'];
        $art['sub_title'] = $_POST['subtitle'];
        $art['category_id'] = $_POST['cat'];
        $art['url'] = $_POST['arturl'];
        $art['remarks'] = $_POST['remarks'];
        $art['meta_tags'] = $_POST['keywords'];
        $art['body'] = $_POST['bodytxt'];
        $con->tp->assign('art', $art);
    }
    else
    {
        $q = "select * from articles where id = $id and admin_perm = 0 and user_email = '$email'";
        $r = $con->db->selectData($q);
        
        if($r == false || $r == array() || count($r) <= 0) $err = $con->db->err;
        else{
            $i =0;
            foreach($r as $a)
            {
                $art = $a;
                $body = $art['body'];
                $body = stripcslashes($body);
                $body = html_entity_decode($body);
                $art['body'] = $body;
                
                $title = $art['title'];
                $subtitle = $art['sub_title'];
                $remarks = $art['remarks'];
                $keywords = $art['meta_tags'];
                
                $art['title'] = stripslashes($title);
                $art['sub_title'] = stripslashes($subtitle);
                $art['remarks'] = stripslashes($remarks);
                $art['meta_tags'] = stripslashes($keywords);
                $i++;
            }
        }
        
        $con->tp->assign('art', $art);
    }
    $con->tp->assign('err', $err);
    $catList = getCatListDb($con, 'Article');
    $con->tp->assign('email', $email);

    $fckEditor = loadFckEditMode($con, $art['body']); 

    $con->tp->assign('fckEditor', $fckEditor);

    $coneditor_js = "subtpl/coneditor_js.tpl";
    $con->tp->assign('bsubtitle', $bsubtitle);
    $con->tp->assign('coneditor_js', $coneditor_js);
    $con->tp->assign('catList', $catList);
    $con->tp->assign('action', $action);
    $bbody = $con->tp->fetch('article_form.tpl');

    $title = "conveylive.com :: Edit Page";
    $con->tp->assign('title', $title);
}

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

addSiteStat($pageName, $con, $email);

$con->tp->display('main.tpl');

?>