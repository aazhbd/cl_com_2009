<?php
if(!isset($_POST['submit'])){ echo "You can not access this page directly."; return; }

require_once('config/project.php');
$con = new Project();

$pageName ='Report Submit';


$title = "ConveyLive :: Home";
$rep = "";
$err = "";
$btitle = "";
$bbody = "";
$vad = "";
$had = "";
$sideitem = array();
$islogin = true;

$is_ins = false;

$con->tp->assign('title', $title);


extract($_POST);


$table = "admin_msgs";
$fields = array("report_email", "submit_email", "remarks", "submit_date");
$values = array("'".trim($rep_email)."'", "'".trim($user_email)."'", "'".trim($remarks)."'", "'".date("Y-m-d G:i:s")."'");

$f = implode(",", $fields);
$v = implode(",", $values);
$query = "insert into $table ( $f ) values ( $v )";

$i = $con->db->insertData($query);

if( $i == true )
{
    $is_ins = true;
}
    

if($is_ins)
{
    $btitle = "Report Submitted";
    $bbody = "Your report has been submittted. We shall review your report and take appropriate actions";
    $rep = "Your report has been submitted";
}
else
{
    $btitle = "Report not submitted";
    $bbody = "Sorry, your report could not be saved. Try again!";
    $err .= "<p>DB Error:".$con->db->err; 
}

home($con,$email);

$v = setLoginInfo($email, $con);

$sideitem = getSideItems($user_email, $con);

$blogexist = checkBlog($con, $email);

$con->tp->assign('btitle', $btitle);

$con->tp->assign('bbody', $bbody);

$con->tp->assign('sideitem', $sideitem);

$con->tp->assign('rep', $rep);

$con->tp->assign('err', $err);

$con->tp->assign('islogin',$islogin);

addSiteStat($pageName, $con, $email);

$con->tp->display('main.tpl');

?>
