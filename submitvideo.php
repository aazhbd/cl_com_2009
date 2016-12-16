<?php

require_once('config/project.php');
$con = new Project();

$pageName ='Submit Video';


$title = $pageName;
$rep = "";
$err = "";
$btitle = "";
$bbody = "";
$vad = "";
$had = "";
$sideitem = array();
$islogin = false;
$video_ins = false;

$con->tp->assign('title', $title);

getLatestCont($con,"Videos");
getTopRatedCont($con,"Videos");
getMostViewedCont($con,"Videos");

if(isset($_SESSION['login'] ) == true)
{
    $l = $_SESSION['login'];
    $islogin = true;
    $email = $l->getEmail();
}

extract($_POST);

$error_code =  $_FILES['video']['error'];

if($error_code > 0)
{
    switch($error_code)
    {
        case 1:
        $err .= " The file is bigger than ConveyLive allows.";
        $uploadvideo_success = false;
        break;
        
        case 2:
        $err .= " The video you selected is more than $MAX_FILE_SIZE bytes. Please select a smaller file.";
        $uploadvideo_success = false;
        break;
        
        case 3:
        $err .= " Only part of the file was uploaded";
        $uploadvideo_success = false;
        break;
        
        case 4:
        $err .= " Can not move file! ";
        $uploadvideo_success = false;
        
        default:
        $uploadvideo_success = true;
    }
}
else
{
    $vfile_ext = getFileExt($_FILES['video']['name']);
    $vfileSize = $_FILES['video']['size'];
    $filePath = PATH . "/tmp";
     
    
    $vfileName = basename($_FILES['video']['name']);
    $vfileName = str_replace(' ', '_', $vfileName);
    $vfileName = addslashes($vfileName);
    
    $vfileType = $_FILES['video']['type'];
    
    $table = "uploaded_videos";
    $id = getNewId($table, $con);
    $vfileName = $id . "_". trim($vfileName);
    
    $uploadfile = $filePath . "/" . $vfileName;
    $file_path = $uploadfile;
    if(move_uploaded_file($_FILES['video']['tmp_name'], $uploadfile)) 
    {
        if( file_exists($uploadfile) )
        {
            $uploadvideo_success = true;
        }
        else
        {
            $err .= " Could not save video. File already exists";
            $upload_success = false;
        }
    }
    else
    {
        $err .= " Could not upload Video";
    }
    
}


$video_ins = false;

if($uploadvideo_success )
{
    $scr_id = 0;

    $ins_date = date("Y-m-d H:i:s");
    $privacy = 0;
    
    $fields = array("id", "user_email", "title", "artist", "additional", "filetype","file_path", "filename", "filesize", "img_id","meta_tags", "category_id","privacy", "ins_date", "upd_date", "admin_perm");
    $values = array("'".$id."'", "'".$email."'", "'".addslashes($videotitle)."'", "'".addslashes($artist)."'", "'".addslashes($additional)."'", "'".$vfileType."'", "'".addslashes($vfileName)."'", "'".addslashes($_FILES['video']['name'])."'", "'".$vfileSize."'", "'".$scr_id."'", "'".addslashes($meta_tags)."'", "'".$cat_id."'",  "'".$privacy."'", "'".$ins_date."'", "'".$ins_date."'", "'0'");
    
        
    $f = implode(",", $fields);
    $v = implode(",", $values);
        
    $query = "insert into $table ( $f ) values ($v)";
    
    $r = $con->db->insertData($query);
    $err .= $con->db->err;
    
    if(isset($r) && $r == true)
    {
        $video_ins =  true;       
    }    
}
if(!$uploadvideo_success || !$video_ins )
{
    $err .= " Could not save video. Please try again with correct fields and valid characters.";
}
if(!$video_ins)
{
    $err .= " Video not published";
}
else
{
    $name = getUserName($email, $con);
    $subject = "Your video was uploaded successfully.";
    $msgBody = "Hello, $name \r\n\r\n";
    $msgBody .= "You video has been uploaded successfully and you will be notified soon after your video is published.";
    $msgBody .= "\r\n\r\nThanks\r\n\r\n Conveylive Team\r\n\r\n";
    $msgBody .= "-------\r\n\r\nFind people from your address book on ConveyLive! Go to: http://conveylive.com/invite,php";
    $msgBody .= "\r\n\r\nThis message was intended for $email";
    
    $fromAr = "conveylive.com <mail@conveylive.com>";
    $toAr = array($email => $name);
    
    $isMailSent = simpleMail($con, $msgBody, $subject, $fromAr, $toAr, 'text/plain', $fromAr, 0 );
    
    if($isMailSent)
    {
        $rep .= " Your video has been saved and it will be published soon. You will be notified by email after publishing";
    }
    else
    {
        $rep .= " Video published!  But Mail Not Sent to notify";
    }
}
/*
$retList = browse_video($con, $email, '');

$bbody = $retList['bbody'];
$btitle = $retList['btitle'];
$bsubtitle = $retList['bsubtitle'];
$rep .= $retList['rep'];
$err .= $retList['err'];
*/
$v = setLoginInfo(trim($email), $con);

$con->tp->assign('islogin',$islogin);

$sideitem = getSideItems(trim($email), $con);

$blogexist = checkBlog($con, $email);

$con->tp->assign('btitle', $btitle);

$con->tp->assign('bsubtitle', $bsubtitle);

$con->tp->assign('bbody', $bbody);

$con->tp->assign('sideitem', $sideitem);

$con->tp->assign('rep', $rep);

$con->tp->assign('err', $err);

addSiteStat($pageName, $con, $email);

$con->tp->display('main.tpl');


?>