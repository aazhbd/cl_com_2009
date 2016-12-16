<?php
//Sample controller file for logged in users in conveylive.com

require_once('config/project.php');
$con = new Project();


//$er = simpleMail($con, "Message to me", "Hello tumpa", array("mail@conveylive.com" => "conveylive Team"), array("tasneem_rumy@yahoo.com" => "Tumpa"), "text/plain" );
echo $er;
$con->tp->display('main.tpl');