<?php

require_once('config/project.php');
$con = new Project();

$pageName ='Search Result';

$title = "ConveyLive :: ".$pageName;

$desc = "ConveyLive.com is a place to make friends and broadcast your creativity with the world. Publish your articles, audio, video, files, blogs, clubs and make it available to search engines, links and other sites as well as your friends. Browse the world through conveylive.com, expand your circle and get amazed with the large collection of other people's contents.";
$con->tp->assign("descrip", $desc);

$keys = "article, audio, video, photos, club, blog";
$con->tp->assign("keys", $keys);


$rep = "";
$err = "";
$btitle = "";
$bbody = "";
$vad = "";
$had = "";
$sideitem = array();
$islogin = false;

if(isset($_SESSION['login'] ) == true)
{
    $l = $_SESSION['login'];
    $islogin = true;
    $email = $l->getEmail();
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

addSiteStat($pageName, $con, '');

$con->tp->assign('title', $title);

$con->tp->display('googleres.tpl');