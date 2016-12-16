<?php
if(!isset($_POST['submit'])){ echo "You can not access this page directly."; return; }

require_once('config/project.php');
$con = new Project();

$pageName ='Submit Album';

$desc = "Publish your albums with conveylive. Share Your photos with your friends and family. Browse all the albums published by users of conveylive to share and comment.";
$con->tp->assign("descrip", $desc);

$keys = "Photos, New, Albums, Picture, Share, ConveyLive";
$con->tp->assign("keys", $keys);


$rep = "";
$err = "";
$btitle = "";
$bbody = "";
$vad = "";
$had = "";
$sideitem = array();
$islogin = false;
$album_ins = false;
$MAX_FILE_SIZE = 5242880;
$thumb_widthpx = 160;

getLatestCont($con,"Albums");

if(isset($_SESSION['login'] ) == true)
{
    $l = $_SESSION['login'];
    $islogin = true;
    $email = $l->getEmail();
}

extract($_POST);

if($submit == 'Create Album')
{
    $ins_date = date("Y-m-d H:i:s");
    $table = "albums";
    
    $admin_perm = 0;
    
    $aid = getNewId($table, $con);
    $fields = array("id", "user_email", "album_name", "remarks", "ins_date", "upd_date","admin_perm", "privacy", "image_id", "category_id");
    $values = array("'".$aid."'" , "'".$email."'" , "'".addslashes($albumname)."'", "'".addslashes($remarks)."'" , "'".$ins_date."'" , "'".$ins_date."'", "'".$admin_perm."'",  "'".$privacy."'", "'0'", "'". $category_id."'");

    $f = implode(",", $fields);
    $v = implode(",", $values);
    
    $query = "insert into $table ( $f ) values ( $v )";

    $i = $con->db->insertData($query);
    
    if($i == true)
    {
        $album_ins = true;
    }
    $err .= $con->db->err;
    
    if($album_ins)
    {
        //Insert Album Stats
        $view_count = 0;
        $tothits = 0;
        $neghits = 0;
        $rating = 0;
        $media_id = $aid;
        $media_type = "Album";
        
        $contstat_ins = insertContStats($con, $email, $view_count, $tothits, $neghits, $rating, $media_id, $media_type);
        if($contstat_ins)
        {
            $art_ins = true;
        }
        //album stats end
        
        
        $make_cover = null;
        $coverimg_made = true;
        $make_cover = 1;
        $img_saved = false;

        $img_path = PATH . "/tmp";
        $fileName = basename($_FILES['picture']['name']);
        
        $uploadfile = $img_path ."/". $fileName;
        
        if(move_uploaded_file($_FILES['picture']['tmp_name'], $uploadfile)) 
        {
            $file_size = filesize($uploadfile);
            $originalpic = file_get_contents($uploadfile);
            list($width, $height) = getimagesize($uploadfile);
            $img_type = $_FILES['picture']['type'];
            
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
                $err .= "The picture you selected is more than $maxfilesize bytes. Please select a smaller file.";
                break;
                
                case 3:
                $err .= "Only part of the file was uploaded";
                break;
                
                case 4:
                $err .= "Can not move file! ";
            }
            $upload_success = false;
        }
        
        if($upload_success)
        {
            $table = "images";
            $status = 0;
            $ins_date = date("Y-m-d G:i:s"); 
            
            
            $id = getNewId($table, $con);
            if($make_cover == "1")
            {
                $albumimg_id = $id;

                $r = $con->db->updateData("update albums set image_id = $albumimg_id where user_email = '$email' and admin_perm = 0 and id = $aid");
                if($r!= false && $r != array())
                {
                    $coverimg_made = true;
                }
                $err .= $con->db->err;
                if($err != "") $coverimg_made = false;
            }
            
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
                $view_count = 0;
                $tothits = 0;
                $neghits = 0;
                $rating = 0;
                $media_id = $id;
                $media_type = "Photo";
                
                $contstat_ins = insertContStats($con, $email, $view_count, $tothits, $neghits, $rating, $media_id, $media_type);
                if($contstat_ins)
                {
                    $art_ins = true;
                }                
            }
            $err .= $con->db->err;
            
            if($img_ins && $coverimg_made)
            {
                $img_saved = true;
            }
            else
            {
                $err .= "Could not insert image.";
            }
        }
        else
        {
            $err .= "Could not insert image.";
        }
    }
    if($img_saved)
    {
        $rep = "Your album was created successfully.";
        $_SESSION['curr_album_id'] = $aid;
        
        $albumName = $albumname; 
        $album_id = $aid;
        $imgFileName = $fileName;
        $img_id = $id;
        $isCreated = putImageInFile($con, $albumName, $album_id, $imgFileName, $img_id, $originalpic, $thumbpic );
    }
    else
    {
        $err .= "Could not save album. Please try again.";
    }
}
if($submit == 'Add Picture')
{
    $_SESSION['curr_album_id'] = $aid;
    $make_cover = null;
    $coverimg_made = true;
    if(isset($frontimg)) $make_cover = $frontimg[0];

    $img_path = PATH . "/tmp";
    $fileName = basename($_FILES['picture']['name']);
    
    $uploadfile = $img_path ."/". $fileName;
    
    if(move_uploaded_file($_FILES['picture']['tmp_name'], $uploadfile)) 
    {
        $file_size = filesize($uploadfile);
        $originalpic = file_get_contents($uploadfile);
        list($width, $height) = getimagesize($uploadfile);
        $img_type = $_FILES['picture']['type'];
        
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
            $err .= "The picture you selected is more than $maxfilesize bytes. Please select a smaller file.";
            break;
            
            case 3:
            $err .= "Only part of the file was uploaded";
            break;
            
            case 4:
            $err .= "Can not move file! ";
        }
        $upload_success = false;
    }
    
    if($upload_success)
    {
        $table = "images";
        $status = 0;
        
        $upd_date = date("Y-m-d G:i:s");
        
        $id = getNewId($table, $con);
        if($make_cover == "1")
        {
            $albumimg_id = $id;
            
            $q = "update albums set image_id = $id  , upd_date = '$upd_date' where user_email = '$email' and admin_perm = 0 and id = $aid";

            $r = $con->db->updateData($q);
            if($r!= false && $r != array())
            {
                $coverimg_made = true;
            }
            
            $err .= $con->db->err;
            if($err != "") $coverimg_made = false;
        }
        
        $status = 0;
        $ins_date = $upd_date;
        $fields = array("id", "user_email", "file_type", "stat", "file_name", "file_size" , "album_id", "admin_perm", "ins_date", "upd_date");
        $values = array("'".$id."'", "'".$email."'", "'".$img_type."'", "'".$status."'", "'".addslashes($fileName)."'", "'".$file_size."'", "'".$aid."'", "0" , "'".$ins_date."'", "'".$ins_date."'");
        
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
            $media_id = $id;
            $media_type = "Photo";
            
            $contstat_ins = insertContStats($con, $email, $view_count, $tothits, $neghits, $rating, $media_id, $media_type);
            if($contstat_ins)
            {
                $art_ins = true;
            }
        }
        $err .= $con->db->err;
        
        if($img_ins && $coverimg_made)
        {
            $rep .= "Your image has been uploaded.";
            
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
            $img_id = $id;
            $isCreated = putImageInFile($con, $albumName, $album_id, $imgFileName, $img_id, $originalpic, $thumbpic );
        }
        else
        {
            $err .= "Could not insert image.";
        }
    }
    else
    {
        $err .= "Could not insert image.";
    }
}

$retList = new_album($con, $email, $id);

$bbody = $retList['bbody'];
$btitle = $retList['btitle'];
$bsubtitle = $retList['bsubtitle'];
$rep .= $retList['rep'];
$err .= $retList['err'];

$v = setLoginInfo($email, $con);

$sideitem = getSideItems($email, $con);

$blogexist = checkBlog($con, $email);

$con->tp->assign('sideitem', $sideitem);

$con->tp->assign('bbody', $bbody);

$con->tp->assign('btitle', $btitle);

$con->tp->assign('bsubtitle', $bsubtitle);

$con->tp->assign('rep', $rep);

$con->tp->assign('err', $err);

$con->tp->assign('islogin',$islogin);

addSiteStat($pageName, $con, $email);

$con->tp->display('main.tpl'); 
?>