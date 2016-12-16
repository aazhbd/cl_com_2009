<?php
if(!isset($_POST['submit']) ){ echo "You can not access this page directly."; return; } 

require_once('config/project.php');
$con = new Project();
$pageName ='Save Picture';

$desc = "$pageName. Publish your albums with conveylive. Share Your photos with your friends and family. Browse all the albums published by users of conveylive to share and comment.";
$con->tp->assign("descrip", $desc);

$keys = "Photos, Albums, Picture, Share, ConveyLive";
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
$prof_ins = false;
$img_ins = false;
$prof_upt = false;
$img_upt = false;

if(isset($_SESSION['login'] ) == true)
{
    $l = $_SESSION['login'];
    $islogin = true;
    $email = $l->getEmail();
}
$con->tp->assign('email', $email);
$con->tp->assign('islogin', $islogin);

getLatestCont($con,"Albums");

extract($_POST);

$MAX_FILE_SIZE = 5242880;
$thumb_widthpx = 160;

$btitle = "Profile photo saved";

$title = "conveylive.com :: $btitle";
$con->tp->assign('title', $title);

$default_img = false;
$img_path = PATH . "/tmp";
$fileName = basename($_FILES['picture']['name']);

$uploadfile = $img_path ."/". $fileName;
try
{
    if(move_uploaded_file($_FILES['picture']['tmp_name'], $uploadfile)) 
    {
        $file_size = filesize($img_path."/".$fileName);
        $originalpic = file_get_contents($img_path."/".$fileName);
        $img_type = $_FILES['picture']['type'];
        
        list($width, $height) = getimagesize($uploadfile);

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
        $error_code =  $_FILES['picture']['error'];
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

            $img_path = PATH ."/interface/icos";
            $fileName = "user.gif";
            
            $file_size = filesize($img_path."/".$fileName);
            $originalpic = file_get_contents($img_path."/".$fileName);
            $img_type = filetype($img_path."/".$fileName);
            
            list($width, $height) = getimagesize($img_path."/".$fileName);
            if($width > $thumb_widthpx)
            {
                $thumbpic = getThumbImage($img_path, $thumb_widthpx, $fileName);
            }
            else
            {
                $thumbpic = $originalpic;
                unlink($img_path."/".$fileName);
            } 
            
            $default_img = true;
        }
        $upload_success = false;
    }
}
catch(Exception $ex)
{
    $err .= $ex->__toString();
}
if($upload_success || $default_img)
{
    $table = "images";
    $img_id = getNewId($table, $con);
    $aid = getProfileAlbumId($con,$email);
    
    
    if($aid == null)
    {
        $aid = getNewId("albums", $con);
        $catList = getCatListDb($con, "Profile");
        foreach($catList as $c)
        {
            $cat_id = $c['id'];
        }
        $album_name = addslashes(getUserName($email, $con) . "'s Profile Photos");
        $remarks = "";
        
        $ins_date = date("Y-m-d G:i:s");
        
        $q = "insert into albums (id, user_email, category_id, image_id, album_name, remarks, privacy, ins_date, upd_date, admin_perm ) values ( $aid , '$email', $cat_id, $img_id, '$album_name', '$remarks' , 0, '$ins_date', '$ins_date', 0)";

        $r = $con->db->insertData($q);
        if($r == false)
        {
            $err .= $con->db->err;
            $ins_album = false;
        }
        else
        {
            $ins_album = true;
        }
    }
    else
    {
        $ins_album = true; 
    }
    
    if($ins_album && $aid != "")
    {
        //Image updated
        $table = "images";
        $status = 0;
        $ins_date = date("Y-m-d G:i:s");
        
        $table = "images";
        $status = 0;
        
        $fields = array("id", "user_email", "file_type", "stat", "file_name", "file_size" , "album_id", "admin_perm", "ins_date", "upd_date");
        $values = array("'".$id."'", "'".$email."'", "'".$img_type."'", "'".$status."'", "'".$fileName."'", "'".$file_size."'", "'".$aid."'", "0" , "'".$ins_date."'", "'".$ins_date."'");
        
        $f = implode(",", $fields);
        $v = implode(",", $values);

        $query2 = "insert into $table ( $f ) values ( $v )";

        $i = $con->db->insertData($query2);

        if($i == true)
        {
            $img_ins = true;
            
            $q = "select album_name from albums where id = $aid";
            $r = $con->db->selectData($q);
            if($r == null || $r == false || $r == array() || count($r) == 0)
            {
                $err .= $con->db->err;
            }
            else
            {
                foreach($r as $a)
                {
                    $album = $a;
                }
                $albumname = $album['album_name'];
            }
            
            $albumName = $albumname;
            $album_id = $aid;
            $imgFileName = $fileName;
            $img_id = $img_id;
            $isCreated = putImageInFile($con, $albumName, $album_id, $imgFileName, $img_id, $originalpic, $thumbpic );
        }
        $err .= $con->db->err;

        $table = "profiles";
        $fields = array("user_imgs_id","user_email", "upd_date");
        $values = array("'".$id."'","'".$user_email."'", "'".date("Y-m-d H:i:s")."'" );

        $f = implode(",", $fields);
        $v = implode(",", $values);
        $date = date("Y-m-d H:i:s");
        $query1 = "update $table set user_imgs_id = '$img_id', upd_date = '".$date."' where user_email = '$user_email'";

        $i = $con->db->executeNonQuery($query1);
        if($i == true)
        {
            $prof_ins = true;
        }
        $err .= $con->db->err;
        
        
        //Album updated
        $table = "albums";
        
        $date = date("Y-m-d H:i:s");
        $query1 = "update $table set image_id = '$img_id', upd_date = '".$date."' where user_email = '$user_email' and id = $aid";

        $i = $con->db->executeNonQuery($query1);
        if($i == true)
        {
            $album_upd = true;
        }
        $err .= $con->db->err;
    }
}
if($prof_ins && $img_ins && $album_upd)
{
    $rep .= "Your profile image has been updated successfully.";
}
else if($prof_ins)
{
    $rep .= "Profile is updated successfully! ";
    $err .= "Image is not uploaded succesfuly!";
}
else if($img_ins)
{
    $res .= "Image is uploaded successfully! ";
    $err .= "Profile is not updated ! ";
}
else if($album_upd)
{
    $res .= "Album updated successfully! ";
    $err .= "Profile is not updated ! ";
}
else
{
    $err .= "Could not insert image.";
}

$r = $con->db->selectData("select * from albums where user_email = '$email' and admin_perm = 0 order by ins_date desc");
if($r != false and $r != array())
{
    foreach($r as $a)
    {
        $albumList[] = $a;
    }
}
$al = array();

for($i=0, $j=0; $i < count($albumList); $i++)
{
    $query = "select count(*) as tot from images where user_email = '$email' and admin_perm = 0 and stat = 0 and album_id = ".$albumList[$i]['id']."";
    $r = $con->db->selectData($query);

    if($r != false && $r != array())
    {
        $albumList[$i]['tot'] = $r[0]['tot']; 
    }
    $err .= $con->db->err;
}
$con->tp->assign('albums', $albumList);

//Image update or new upload
$action1 = "update";
$action2 = "create";
$aid = 0;

$d = $con->db->selectData("select id, user_imgs_id, user_email from profiles where user_email = '$user_email'");

if($d == false || $d == array() ) 
{
    $err .= "DB Error: ".$con->db->err;
    $btitle = "Add new profile photo";
    $action = $action2;
}
else
{
    $btitle = "Update profile photo";
    $action = $action1;
    foreach($d as $data)
    {
        $data[] = $d;
    }
    $con->tp->assign('data', $data);
}
if($err == "") $executed = true;

$btitle = "Update profile photo";

$con->tp->assign('btitle', $btitle);

$blogexist = checkBlog($con, $email);

$con->tp->assign('action', $action);

$con->tp->assign('aid', $aid);

$con->tp->assign('user_email', $data['user_email']);

$bbody = $con->tp->fetch('upload_pic_form.tpl');


$v = setLoginInfo($user_email, $con);

$sideitem = getSideItems($user_email, $con);

$con->tp->assign('bbody', $bbody);

$con->tp->assign('sideitem', $sideitem);

$con->tp->assign('rep', $rep);

$con->tp->assign('err', $err);

$con->tp->assign('islogin',$islogin);

addSiteStat($pageName, $con, $user_email);

$con->tp->display('main.tpl');     

?>