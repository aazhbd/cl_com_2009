<?php
if(!isset($_GET['e'])) { echo "You can not access this page directly."; return; }

require_once('config/project.php');
$con = new Project();

$pageName = "validate";

$title = "conveylive.com :: Validate";

$desc = "Validate email accounts to become registered users at conveylive.com. conveylive.com is a place to make friends and broadcast your creativity with the world. Publish your articles, audio, video, files, blogs, clubs and make it available to search engines, links and other sites as well as your friends. Browse the world through conveylive.com, expand your circle and get amazed with the large collection of other people's contents.";
$con->tp->assign("descrip", $desc);

$keys = "article, audio, video, photos, club, blog";
$con->tp->assign("keys", $keys);

$con->tp->assign('title', $title);
$rep = "";
$err = "";
$btitle = "";
$bbody = "";
$sideitem = array();
$islogin = false;
$ustatus = "-1";
$alreadyvalid = false;
$blocked = false;
$load_home = false;
$pass = "";
$email = $_GET['e'];
$id = $_GET['id'];

$rs = $con->db->selectData("select validator, ustatus, pass from users where email='$email'");

if($rs == true)
{
    foreach($rs as $r)
    {
        $k = $r['validator'];
        $ustatus = $r['ustatus'];
        $pass = $r['pass'];
    }
    
    if($ustatus == "0")
    {
        $vallowed = true;
    }
    if($ustatus == "1")
    {
        $alreadyvalid = true;
    }
    if($ustatus == "2")
    {
        $blocked = true;
    }
}

if($vallowed == true)
{
    if($k == $id)
    {
        if($con->db->updateData("update users set ustatus='1' where email='$email'"))
        {
            $res = "Validation Successful ! Your email address has been verified and your account has been activated.";
            $load_home = true;
        }
        else
        {
            $bbody = "<div id='pginfo'>Failed to validate your email address. Please contact the administrator at mail@conveylive.com.</div>";
            $err = "DB Error: ".$con->db->err;
        }
    }
    else
    {
        if($rs == false)
        {
            $bbody = "<div id='pginfo'>Validation Failed ! This email address is not registered. Please signup <a href='".URL."/signup'>here</a> to register with conveylive.com. </div>";
            $err .= $con->db->err;
        }
        else
        {
            $bbody = "<div id='pginfo'>Failed to validate your email address. This email address is not validated yet. Please check your email and click the proper validation link provided to validate your email address.</div>";
        }
    }
}
else if($alreadyvalid)
{
    $rep = "Validation Failed ! This email address is already validated.";
    $load_home = true;
}
else if($blocked)
{
    $bbody = "<div id='pginfo'>Validation Failed ! This account is blocked by the administrator. You can not validate conveylive account with this email address. Please contact the administrator for any queries or request to reactivate your account. <a href='mailto:mail@conveylive.com'>mail@conveylive.com</a></div>";
}

$v = setLoginInfo($email, $con);

$sideitem = getSideItems($email, $con);

$con->tp->assign('sideitem', $sideitem);

if($load_home)
{
    
    $l = new Login(trim($email), trim($pass), $con->db);
    
    if(is_object($l))
    {
        if($l->isLoged() && $l != false)
        {
            $islogin = true;
            $_SESSION['login'] = $l;
            $r = $con->db->updateData("update users set last_login_date = '".date("Y-m-d G:i:s")."' where email = '$email'");
            $title = "conveylive.com :: Home";
            $blogexist = checkBlog($con, $email);
        }
    }
    $con->tp->assign('islogin',$islogin);
    
    home($con, $email);
}
else
{
    $con->tp->assign('btitle', $btitle);

    $con->tp->assign('bbody', $bbody);
}

$con->tp->assign('rep', $rep);

$con->tp->assign('err', $err);

addSiteStat($pageName, $con, $email);

$con->tp->display('main.tpl');

?>