<?php
if(!isset($_POST['submit']) ){ echo "You can not access this page directly."; return; } 

require_once('config/project.php');
$con = new Project();
$pageName ='Edit Account';


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

$acc_updt = false;

extract($_POST);

$blogexist = checkBlog($con, $email);

$bdate = $year."-".$month."-".$day;
if(trim($fname) == "")
{
    $err .= "Account not updated" . "Your First Name is Blank. Please type the first name.";
    $btitle = "Account Settings";
    $bbody = "Your First Name is Blank";
}
else if(trim($lname) == "")
{
    $err .= "Account not updated" . "Your Last Name is Blank. Please type the last name.";
    $btitle = "Account Settings";
    $bbody = "Your First Name is Blank";
}
else if(trim($password_old) == "" && trim($password_new) == "")
{
    $query = "update users set f_name = '$fname', l_name = '$lname', gender = '$sex', birth_date = '$bdate' where email = '$email'";
    $i = $con->db->updateData($query);
    if($i == true)
    {
        $acc_updt = true;
    }
    $err .= $con->db->err;

    if($acc_updt)
    {
        $rep = "Your account has been updated successfully.";
    }
    else
    {
        $err .= "Could not update Account information. Please try again with correct fields and valid characters. ";
    }
    $btitle = "Account Settings";
    $bbody = "<a href= '".URL."/home'>Back to home page</a>";
    
}
else if(trim($password_old) != "" && trim($password_new) == "")
{
    $err .= "Account not updated." . " You did not enter any new password. You can not have a blank password as your new password";
    $btitle = "Account Settings";
    $bbody = "You did not enter any new password. You can not have a blank password as your new password";
}
else if(trim($password_old) == "" && trim($password_new) != "")
{
    $err .= "Account not updated." . " You did not enter the old password! Your new password is not updated";
    $btitle = "Account Settings";
    $bbody = "You did not enter the old password! Your new password is not updated";
}
else if(trim($password_old) != "" && trim($password_new) != "" )
{
    $r = $con->db->selectData("select pass from users where email = '$email'");
    $opass = $r[0]['pass'];
    
    if(trim($opass) != trim($password_old))
    {
        $err .= "Account not updated" . "Your old password did not match!" ;
        $btitle = "Account Settings";
        $bbody = "Your old password did not match!";
    }
    else if(strlen(trim($password_new)) < 6 )
    {
        $err .= "Account not updated" . "Your new password is less than 6 characters!";
        $btitle = "Account Settings";
        $bbody = "Your new password is less than 6 characters!";
    }
    else
    {
        $pnew = $password_new;
        $query = "update users set f_name = '$fname', l_name = '$lname', pass = '$pnew', gender = '$sex', birth_date = '$bdate' where email = '$email'";
        $i = $con->db->updateData($query);
        if($i == true)
        {
           $acc_updt = true;
        }
        $err .= $con->db->err;

        if($acc_updt)
        {
            $rep = "Your account has been updated successfully.";
        }
        else
        {
            $err .= "Could not update Account information. Please try again with correct fields and valid characters. " .$con->db->err;
        }

    }
}
home($con, $email);

$desc = "Change your Account Settings at ConveyLive. Set Your Privacy Settings and decide what you want to share and the ones you want to keep private. ConveyLive.com is a place to make friends and broadcast your creativity with the world. Publish your articles, audio, video, files, blogs, clubs and make it available to search engines, links and other sites as well as your friends. Browse the world through conveylive.com, expand your circle and get amazed with the large collection of other people's contents.";
$con->tp->assign("descrip", $desc);

$keys = "Set account, Privacy, Send, New, Messages, article, audio, video, photos, club, blog";
$con->tp->assign("keys", $keys);

$v = setLoginInfo($email, $con);

$sideitem = getSideItems($email, $con);

$con->tp->assign('sideitem', $sideitem);

$con->tp->assign('rep', $rep);

$con->tp->assign('err', $err);

$con->tp->assign('islogin',$islogin);

addSiteStat($pageName, $con, $email);

$con->tp->display('main.tpl');     

?>