<?php
if(!isset($_POST['submit'])){ echo "You can not access this page directly."; return; }

require_once('config/project.php');
$con = new Project();
$pageName = 'Login';

$title = "conveylive.com :: $pageName";

$desc = "conveylive.com is a place to make friends and broadcast your creativity with the world. Publish your articles, audio, video, files, blogs, clubs and make it available to search engines, links and other sites as well as your friends. Browse the world through conveylive.com, expand your circle and get amazed with the large collection of other people's contents.";
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
$ckname = 'ZakirCookie';

if(isset($_SESSION['validreqest'])) 
    unset($_SESSION['validreqest']);

extract($_POST);

$l = new Login(trim($email), trim($pass), $con->db);

if(is_object($l))
{
    if($l->isLoged() && $l != false)
    {
        $islogin = true;
        
        $_SESSION['login'] = $l;
        
        /*
            Setting Remember Me cookie
        */
        $rem = $remember[0];
        
        if($rem == 1)
        {
            $exptime = mktime(). time()+60*60*24*4;//4days
            $value= $l->getValidator();
            setcookie($ckname, $value, $exptime);
        }
        
        /*
            Update Last login date
        */
        $r = $con->db->updateData("update users set last_login_date = '".date("Y-m-d G:i:s")."' where email = '$email'");
        
        /*
            Loading user home after login
        */
        $title = "conveylive.com :: Home";
        
        $blogexist = checkBlog($con, $email);

        if($l->utype == 2)
        {
            $uid = "admin";
        }
        else
        {
            $uid = "user";
        }

        home($con,$email, $uid);
        
        setLoginInfo($l->getEmail(), $con);
        
        $sideitem = getSideItems($email, $con);
    }
    else if ($l->msg != "")
    {
        $islogin = false;
        
        $btitle = "Login Failed";
        
        $bbody = "<div id='pginfo'>".$l->msg."</div>";
        
        $_SESSION['validreqest'] = "valid";
        
        $bbody .= "<a href='".URL."/resendvmail/".$l->getEmail()."'>Resend Validation Email</a>";
        
        $con->tp->assign('bbody', $bbody);
        
        $con->tp->assign('btitle', $btitle);
        
        $con->tp->assign('rep', $rep);

        $con->tp->assign('err', $err);
    }
    else
    {
        $islogin = false;
        $btitle = "Login Failed";
        $bbody = "<div id='pginfo'>Please try to login again. <p>If you had forgotten your password please go to <a href='".URL."/forgot'>Forget Password</a> link in the home page to get your password after we send it to your email or you can <a href='".URL."/signup'>Signup</a> for a new account and join conveylive.com.</div>";
        $err = "Invalid Email or Password!";
        
        $con->tp->assign('bbody', $bbody);
        
        $con->tp->assign('btitle', $btitle);
        
        $con->tp->assign('rep', $rep);

        $con->tp->assign('err', $err);
    }
}
else
{
    $islogin = false;
    $btitle = "Login Failed";
    $bbody = "Please try to login again. <p>If you had forgotten your password please go to <a href='".URL."/forgot'>Forget Password</a> link in the home page to get your password after we send it to your email or you can <a href='".URL."/signup'>Signup</a> for a new account and join conveylive.com.</p>";
    $err = "Invalid Email or Password!";
    
    $con->tp->assign('bbody', $bbody);
    
    $con->tp->assign('btitle', $btitle);
    
    $con->tp->assign('rep', $rep);

    $con->tp->assign('err', $err);    
}

$con->tp->assign('title', $title);

$con->tp->assign('sideitem',$sideitem);

$con->tp->assign('islogin',$islogin);

addSiteStat($title, $con, $email);

$con->tp->display('main.tpl');
?>