<?php
if(!isset($_POST['submit']) ){ echo "You can not access this page directly."; return; } 

require_once('config/project.php');
$con = new Project();
$pageName ='Save Club Photo';

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
        unlink($uploadfile);
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
        $err .= "Photo was not uploaded properly";
    }
    $upload_success = false;
}
if($upload_success || $default_img)
{
    $album = getClubAlbum($con, $club_id);
    
    $table = "images";
    $status = 0;
    $aid = $album['id'];
    
    $ins_date = date("Y-m-d G:i:s");
    
    $img_id = getNewId($table, $con);
    
    $fields = array("id", "user_email", "file_type", "stat", "file_name", "file_size" , "album_id", "admin_perm", "ins_date", "upd_date");
    $values = array("'".$img_id."'", "'".$email."'", "'".$img_type."'", "'".$status."'", "'".$fileName."'", "'".$file_size."'", "'".$aid."'", "0" , "'".$ins_date."'", "'".$ins_date."'");
    
    $f = implode(",", $fields);
    $v = implode(",", $values);

    $query2 = "insert into $table ( $f ) values ( $v )";

    $i = $con->db->insertData($query2);    
    

    if($i == true)
    {
        $img_ins = true;
        $view_count = 0;
        $tothits = 0;
        $neghits = 0;
        $rating = 0;
        $media_id = $img_id;
        $media_type = "Photo";
        
        $contstat_ins = insertContStats($con, $email, $view_count, $tothits, $neghits, $rating, $media_id, $media_type);
        if($contstat_ins)
        {
            $art_ins = true;
        }
        
        $albumName = $album['album_name']; 
        $album_id = $aid;
        $imgFileName = $fileName;
        $img_id = $img_id;
        $isCreated = putImageInFile($con, $albumName, $album_id, $imgFileName, $img_id, $originalpic, $thumbpic );
    }
    $err .= $con->db->err;
    
    if(!$img_ins)
    {
        $err .= "Cound not insert image";
    }
}
else
{
    $err .= "Could not upload image.";
}

if($img_ins)
{
    $rep = "Club photo was uploaded successfully";
}

$retList = viewClub($con, $email, $club_id);

$bbody = $retList['bbody'];
$btitle = $retList['btitle'];
$bsubtitle = $retList['bsubtitle'];
$rep .= $retList['rep'];
$err .= $retList['err'];
//code to add

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
