<?php

function loadBaseTpl($tplName, $con, $email)
{
    $v = setLoginInfo($email, $con);
    $sideitem = getSideItems($email, $con);
    $con->tp->assign('sideitem', $sideitem);
    $con->tp->display($tplName);
}

?>
