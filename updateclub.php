<?php
if(!isset($_POST['submit']) ){ echo "You can not access this page directly."; return; } 

require_once('config/project.php');
$con = new Project();
$pageName ='Create Club';


$title = "ConveyLive :: Club Updated";
$con->tp->assign('title', $title);

$desc = "Create amd Update Your own Clubs to discuss and share your digital possesions like, Photos and Files. Post your opinions and communicate with your peers. Browse all the Clubs of conveylive published by users to share,comment and discuss.";
$con->tp->assign("descrip", $desc);

$keys = "New Clubs, Posts, File, Share, Community, Network, ConveyLive";
$con->tp->assign("keys", $keys);

$rep = "";
$err = "";
$btitle = "";
$bbody = "";
$vad = "";
$had = "";
$sideitem = array();
$islogin = true;


$picture = "";
$img_type = "";
$language = "";
$club_ins = false;
$img_ins = false;
$mem_ins = false;

getLatestCont($con,"Clubs");

if(isset($_SESSION['login'] ) == true)
{
    $l = $_SESSION['login'];
    $islogin = true;
    $email = $l->getEmail();
}

extract($_POST);

$MAX_FILE_SIZE = 5242880;
$thumb_widthpx = 160;

$btitle = "Club has been created";
$default_img = false;
$img_path = PATH . "/tmp";
$fileName = basename($_FILES['clubphoto']['name']);

$uploadfile = $img_path ."/". $fileName;

if(move_uploaded_file($_FILES['clubphoto']['tmp_name'], $uploadfile)) 
{
    $file_size = filesize($img_path."/".$fileName);
    $originalpic = file_get_contents($img_path."/".$fileName);
    list($width, $height) = getimagesize($uploadfile);
    $img_type = $_FILES['clubphoto']['type'];
    
    if($width > $thumb_widthpx)
    {
        $thumbpic = getThumbImage($img_path, $thumb_widthpx, $fileName);
    }
    else
    {
        $thumbpic = $originalpic;
    }
    $upload_success = true;
}
else
{
    $error_code =  $_FILES['clubphoto']['error'];
    
    switch($error_code)
    {
        case 1:
        $err .= "The file is bigger than ConveyLive allows.";
        break;
        
        case 2:
        $err .= "The picture you selected is more than $MAX_FILE_SIZE bytes. Please select a smaller file.";
        break;
        
        case 3:
        $err .= "Only part of the file was uploaded";
        break;
        
        case 4:
        /*
        $img_path = "interface/icos";
        $fileName = "usergroup.gif";
        
        $file_size = filesize($img_path."/".$fileName);
        $originalpic = file_get_contents($img_path."/".$fileName);
        
        list($width, $height) = getimagesize($img_path."/".$fileName);
        if($width > $thumb_widthpx)
        {
            $thumbpic = getThumbImage($img_path, $thumb_widthpx, $fileName);
        }
        else
        {
            $thumbpic = $originalpic;
        } 
        $img_type = filetype($img_path."/".$fileName);
        */
        $r = $con->db->selectData("select image_id from clubs where id = $club_id");
        if($r == false || $r == array() || count($r) == 0) $err .= $con->db->err;
        else
        {
            $imgid = $r[0]['club_img_id'];
        }
        
        $default_img = true;
    }
    $upload_success = false;
}
if($upload_success || $default_img)
{ 
    
    if($upload_success)
    {
        $table = "images";
        $status = 0;
        $album = getClubAlbum($con, $club_id);
        $aid = $album['id'];
        
        $ins_date = date("Y-m-d G:i:s");
        $img_id = getNewId($table, $con);
        $fields = array("id", "user_email", "file_type", "stat", "file_name", "file_size", "album_id", "admin_perm", "ins_date", "upd_date","large_image", "thumb_image");
        $values = array($img_id, $email, $img_type, $status, $fileName, $file_size, $aid, "0", $ins_date ,$ins_date);

        $f = implode(",", $fields);
        $v = implode(",", $values);

        $query2 = "insert into $table ( $f ) values ( ?, ?, ?, ?, ?, ? ,?, ?, ?, ?, ?, ?)";

        $i = $con->db->insertImage($query2, $originalpic, $thumbpic, $values);

        if($i == true)
        {
            $img_ins = true;
        }
        $err .= $con->db->err;
    }
    else
    {
        $img_id = $imgid;
    }
    $cdate =  date("Y-m-d H:i:s");

    $cname = addslashes($cname);
    $description = addslashes($description);
    $cat = addslashes($cat);
    $cname = addslashes($cname);
    
    
    if($img_id != null)
        $query1 = "update clubs set cname = '$cname', description = '$description' , category_id = '$cat' , upd_date = '$cdate' , image_id = $img_id where id = $club_id";
    else
        $query1 = "update clubs set cname = '$cname', description = '$description' , category_id = '$cat' , upd_date = '$cdate' where id = $club_id";
    
    $i = $con->db->executeNonQuery($query1);
    if($i == true)
    {
        $club_ins = true;
    }
    $err .= $con->db->err;
    
    if($club_ins )
    {
        $rep .= "Club has been updated successfully";
    }
}
else
{
    $err .= "Could not insert Club information.";
}

$retList = viewClub($con, $email, $club_id);

$bbody = $retList['bbody'];
$btitle = $retList['btitle'];
$bsubtitle = $retList['bsubtitle'];
$rep .= $retList['rep'];
$err .= $retList['err'];
$v = setLoginInfo($email, $con);

$sideitem = getSideItems($email, $con);

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
