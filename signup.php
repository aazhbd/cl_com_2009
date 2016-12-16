<?php
if(!isset($_POST['submit'])){ echo "You can not access this page directly."; return; }

require_once('config/project.php');
$con = new Project();

$pageName ='Signup submit';


$title = "conveylive.com :: $pageName";

$keys = "signup, user, email, password, conveylive";
$con->tp->assign("keys", $keys);

$desc = "conveylive.com - Signup: Signup in conveylive and express your creativity.";
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
$is_ins = false;

$con->tp->assign('title', $title);


extract($_POST);

//$birthday = $year."-".$month."-".$day;

$birthday = $_POST['birthdate'];

list($month, $day, $year) = explode("/", $birthday);

$birthday = $year."-".$month."-".$day;


$validator = sha1(rand(10, 100));
$ins_date = date("Y-m-d G:i:s");

$table = "users";
$fields = array("email", "pass", "f_name", "l_name", "gender", "birth_date", "utype", "ustatus", "validator", "last_login_date", "ins_date", "upd_date", "admin_perm");
$values = array("'".trim($email)."'", "'".trim($password)."'", "'".trim($fname)."'", "'".trim($lname)."'", "'".$sex."'", "'".$birthday."'", 0, 0, "'".$validator."'", "'00-00-00 00:00'", "'".$ins_date."'", "'".$ins_date."'", 0 );

$f = implode(",", $fields);
$v = implode(",", $values);
$query = "insert into $table ( $f ) values ( $v )";


$i = $con->db->insertData($query);

if( $i == true )
{
    $is_ins = true;
}

$to = $email;
$subject = "Welcome to conveylive.com: Please validate your email address";
$message = "Hello, ".$fname." ".$lname." \r\n\r\nThank you for registering with conveylive.com. \r\n\r\nPlease click the following link to complete your registration process. \r\n\r\nhttp://www.conveylive.com/validate.php?id=$validator&e=$email";
$message .= "\r\n\r\n(If clicking on the link does not work, try copying and pasting it into your browser)";
$message .= "\r\n\r\nThanks\r\n\r\nconveylive Team\r\n\r\n";
$message .= "-------\r\n\r\nFind people from your address book on conveylive! Go to: http://conveylive.com/invite.php";
$message .= "\r\n\r\nThis message was intended for $email";
    
try
{
    if($is_ins)
    {
        $result = simpleMail($con, $message, $subject, array("mail@conveylive.com" => "conveylive Team" ), array($to =>  $fname ." ". $lname),  "text/plain" , array("mail@conveylive.com" => "conveylive Team"), 0 );
        $mail_sent = true;
    }
    else
    {
        $btitle = "Sorry, your signup process failed !";
        $bbody = "<p>Possible reasons could be the existence of this email address in database already or the entering of invalid characters in  first name, last name, password or email address. Please try <a href='".URL."/signup'>signing up</a> again.</p>";
        $err .= "<p>DB Error:".$con->db->err; 
    }
}
catch(Exception $ex)
{
    $btitle = "Sorry, your signup process failed !";
    $bbody =  "<p>Failed to send you the validation email due to invalid email address. <br/>Please try <a href='".URL."/signup'>signing up</a> again !<br />";
    $err .= $ex->getMessage();
}
if($mail_sent && $is_ins)
{
    $btitle = "Congratulations!";
    $bbody = "<div id='pginfo''>You are now registered to ConveyLive.com. <p>An email has been sent to your mail address ".$email.". <br/>Please follow the link given in your email to verify your account and complete your registration.</p></div>";
    $rep = "Signup Successful !";
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
