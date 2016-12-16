<?php

if(!isset($_POST['submit']) ){ echo "You can not access this page directly."; return; } 
if(!isset($_POST['denyreq']) ){ echo "You can not access this page directly."; return; }

require_once('config/project.php');
$con = new Project();
$pageName ='Friend Approved';


$title = "ConveyLive :: Home";
$rep = "";
$err = "";
$btitle = "";
$bbody = "";
$vad = "";
$had = "";
$sideitem = array();
$islogin = true;

$con->tp->assign('title', $title);

$approved = false;
$denied = false;

extract($_POST);
$blogexist = checkBlog($con, $email);
if(isset($_POST['submit']))
{
    $r = $con->db->updateData("update friends set date_acccept = '".date("Y-m-d G:i:s")."',  req_pending = 0,  where id = $fid");
    if($r == false) $err .= $con->db->err;
    else
    {
        $approved = true;
    }
}
else if (isset($_POST['denyreq']))
{
    $r = $con->db->deleteData("update friends set admin_perm = 1 where id = $fid");
    if($r == false) $err .= $con->db->err;
    else
    {
        $denied = true;
    }  
}
if($approved)
{ 
    $rep = "You have approved a friend request.";
}
if($denied)
{
    $rep = "You have cancelled a friend request.";
}
home($con,$email);

$v = setLoginInfo($email, $con);

$sideitem = getSideItems($email, $con);
    
$con->tp->assign('btitle', $btitle);

$con->tp->assign('bbody', $bbody);

$con->tp->assign('sideitem', $sideitem);

$con->tp->assign('rep', $rep);

$con->tp->assign('err', $err);

$con->tp->assign('islogin',$islogin);

addSiteStat($pageName, $con, $email);

$con->tp->display('main.tpl');     

?>