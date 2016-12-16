<?php
if(!isset($_POST['submit'])){ echo "You can not access this page directly."; return; }

require_once('config/project.php');
$con = new Project();


$pageName ='Forget Password';


$title = "ConveyLive :: ".$pageName;

$keys = "forget, password, conveylive, address, articulatelogic";
$con->tp->assign("keys", $keys);

$desc = "ConveyLive - Forgot Password ";
$con->tp->assign("descrip", $desc);

$rep = "";
$err = "";
$btitle = "";
$bbody = "";
$vad = "";
$had = "";
$sideitem = array();
$islogin = false;
$mail_sent = false;

$privacy_link = "www.conveylive.com/static/privacy";
$site_url = "www.conveylive.com";
$mail_addr = "mail@conveylive.com";

$con->tp->assign('title', $title);

extract($_POST);

$r = $con->db->selectData("select email, f_name, l_name, pass from users where email = '$email'");

if($r == false || $r == array())
{
    $err = "Invalid Email Address. ".$con->db->err;
    $err .= "Please try entering your email address again";
    $con->tp->assign('err', $err);
    $btitle = "Unable to access your account?";
    $bbody = $con->tp->fetch('fpass_view.tpl');
}
else
{
    $fname = $r[0]['f_name'];
    $lname = $r[0]['l_name'];
    $pass = $r[0]['pass'];
    
    $to = $email;
    $subject = 'ConveyLive\'s reply to password request';
    $message = "Hello, ".$fname." ".$lname." \r\n\r\nYou recently requested your account password for conveylive.com.\r\n";
    $message .= "\r\nHere is your email address and password.\r\n\r\nEmail: $email\r\nPassword: $pass\r\n\r\n";
    $message .= "Copy and paste this email and password in the login area of $site_url and login.\r\n\r\nPlease remember your password to login and keep your email and password secure from unauthorized access.\r\n";
    $message .= "\r\nIf you did not request your password, please disregard this message.";
    $message .= "\r\n\r\nCheck out $privacy_link if you have any questions regarding our privacy policy.";
    $message .= "\r\n\r\nShare your imagination with ConveyLive and have fun !!! \r\n\r\n\r\nThanks. \r\nConveyLive Team";
    
    try
    {
        $mail_sent = simpleMail($con, $message, $subject, array('mail@conveylive.com' => 'Conveylive Team'), array( $to => $fname ." ". $lname ), "text/plain", array( "mail@conveylive.com" => "Conveylive Team"), 0 );
    }
    catch(Exception $ex)
    {
        $btitle = "Sorry, our signup process failed !";
        $bbody =  "<p>Failed to send you the validation email. <br/>Please try <a href='".URL."/signup'>signing up</a> again !<br />";
        $err .= $ex->getMessage();
    }
    if($mail_sent)
    {        
        $rep = "Email has been sent!";
        $btitle = "Your password has been sent";
        $bbody .= "<div id='pginfo'>An email has been sent to ".$email.". This email contains your password. <br/>Please be patient; the delivery of email may be delayed. Remember to confirm that the email above is correct and to check your junk or spam folder or filter if you do not receive this email.</div>";
    }
    else
    {
        $err .= "Failed to send you the validation email due to invalid email address. <br/>Please try again.";
        $bbody = $con->tp->fetch('fpass_view.tpl');
    }
}
$con->tp->assign('btitle', $btitle);

$con->tp->assign('bbody', $bbody);

$con->tp->assign('sideitem', $sideitem);

$con->tp->assign('rep', $rep);

$con->tp->assign('err', $err);

$con->tp->assign('islogin',$islogin);

addSiteStat($pageName, $con, $email);

$con->tp->display('main.tpl');

?>