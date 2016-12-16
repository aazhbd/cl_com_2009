<?php
if(!isset($_POST['submit']) ){ echo "You can not access this page directly."; return; } 

require_once('config/project.php');
$con = new Project();
$pageName ='Delete Profile';


$title = "conveylive.com :: Home";
$rep = "";
$err = "";
$btitle = "";
$bbody = "";
$vad = "";
$had = "";
$sideitem = array();
$islogin = true;

$desc = "ConveyLive - Delete Profile. ConveyLive.com is a place to make friends and broadcast your creativity with the world. Publish your articles, audio, video, files, blogs, clubs and make it available to search engines, links and other sites as well as your friends. Browse the world through conveylive.com, expand your circle and get amazed with the large collection of other people's contents.";
$con->tp->assign("descrip", $desc);

$keys = "Profile,". $pd[0]['f_name'] . $pd[0]['l_name'].", people, community";
$con->tp->assign("keys", $keys);

$blogexist = checkBlog($con, $email);

$con->tp->assign('title', $title);

if(isset($_POST['submit']))
{
    $btitle = "Profile Delete";
    $email = $_POST['email'];
    $r = $con->db->executeNonQuery("update profiles set admin_perm = 1 where user_email = '$email' and admin_perm = 0");
    if($r == false)
    {
        $err = "Could not delete profile information. Please try again with correct fields and valid characters.";
    }
    else
    {
        $rep = "Your profile has been deleted successfully";
    }
    
    home($con, $email);
    
    $v = setLoginInfo($email, $con);

    $sideitem = getSideItems($email, $con);

    $con->tp->assign('sideitem', $sideitem);

    $con->tp->assign('rep', $rep);

    $con->tp->assign('err', $err);

    $con->tp->assign('islogin',$islogin);

    addSiteStat($pageName, $con, $email);

    $con->tp->display('main.tpl');
}
?>
