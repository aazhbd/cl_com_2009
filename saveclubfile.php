<?php
if(!isset($_POST['submit']) ){ echo "You can not access this page directly."; return; } 

require_once('config/project.php');
$con = new Project();
$pageName ='Save Club Files';

$rep = "";
$err = "";
$btitle = "";
$bbody = "";
$vad = "";
$had = "";
$sideitem = array();
$islogin = true;

$club_ins = false;
$file_ins = false;

getLatestCont($con,"Clubs");

if(isset($_SESSION['login'] ) == true)
{
    $l = $_SESSION['login'];
    $islogin = true;
    $email = $l->getEmail();
}


function saveFile($main_dir,  $fileName, $file_id, $club_name, $club_id, $uploadfile)
{   
    $fileName = str_replace(" ", "_", $fileName);
    
    $club_dir = $main_dir ."/".$club_name."".$club_id;
    
    $file_path = $club_dir ."/".$file_id. "". $fileName;

    $hasDir = false;
    $main_dir = PATH . "/directories/clubs";
    if(is_dir($main_dir))
    {
        $hasDir = true;
    }
    else
    {
        if(mkdir($main_dir , 0777))
        {
            $hasDir = true;
        }
        else
        {
            $err .= "Could not create $main_dir folder. Contact your administrator to resolve this issue";
            $hasDir = false;
        }
    }
    if($hasDir)
    {
        $club_dir = $main_dir ."/".$club_id. "_" .$club_name;
        if(is_dir($club_dir))
        {
            $club_dir_exist = true;
        }
        else
        {
            if(mkdir($club_dir , 0777))
            {
                $club_dir_exist = true;
            }
            else
            {
                $club_dir_exist = false;
                $err .= "Failed to create club directory.";
            }
        }
    }
    
    if($club_dir_exist)
    {
        $originalfile = file_get_contents($uploadfile);
        $file_path = $club_dir ."/".$file_id. "_". $fileName;
        
        file_put_contents($file_path ,$originalfile);
        $file_saved = true;
        unlink($uploadfile);
    }
    else
    {
        $file_saved = false;
    }
    return $file_saved;
}

extract($_POST);

$MAX_FILE_SIZE = 20971520;

$file_path = PATH . "/tmp";
$fileName = basename($_FILES['clubfile']['name']);

$uploadfile = $file_path ."/". $fileName;

if(move_uploaded_file($_FILES['clubfile']['tmp_name'], $uploadfile)) 
{
    $file_size = filesize($file_path."/".$fileName);
    
    $file_type = $_FILES['clubfile']['type'];
    
    $file_ext = getFileExt($fileName);
    
    $upload_success = true;
}
else
{
    $error_code =  $_FILES['clubfile']['error'];
    
    switch($error_code)
    {
        case 1:
        $err .= "The file is bigger than ConveyLive allows.";
        break;
        
        case 2:
        $err .= "The file you selected is more than $MAX_FILE_SIZE bytes. Please select a smaller file.";
        break;
        
        case 3:
        $err .= "Only part of the file was uploaded";
        break;
        
        case 4:
        $err .= "File not uploaded";
    }
    $upload_success = false;
}
if($upload_success)
{
    $table = "user_files";
    $status = 0;
    $aid = "";
    $cdate = date("Y-m-d H:i:s");
    
    $file_id = getNewId($table, $con);
    
    $main_dir = PATH . "/directories/clubs";
    
    $file_saved = saveFile($main_dir, $fileName, $file_id, $club_name, $club_id, $uploadfile);
    
    $fileName = str_replace(" ", "_", $fileName);
    
    $file_path = $club_name ."". $club_id . "/" . $file_id. "". $fileName;
    
    
    if($file_saved)
    {
        $fields = array("id", "file_name", "file_path" ,"file_type", "file_ext", "file_size", "ins_date", "upd_date", "user_email", "admin_perm","privacy", "category_id" ,"club_id");
        $values = array("'".$file_id."'", "'".addslashes($fileName)."'", "'".addslashes($file_path)."'" ,"'".$file_type."'", "'".$file_ext."'", "'".$file_size."'", "'".$cdate."'","'".$cdate."'", "'".$email."'", "'0'", "'0'", "'".$category."'", "'".$club_id."'");

        $f = implode(",", $fields);
        $v = implode(",", $values);

        $query = "insert into $table ( $f ) values ( $v )";
        
        $i = $con->db->executeNonQuery($query);

        if($i == true)
        {
            $file_ins = true;
        }
        $err .= $con->db->err;
    }
    if(!$file_ins)
    {
        $err .= " Cound not insert file";
    }
    else
    {
        $media_id = $file_id;
        $media_type = "Club File";
        $date_pub = date("Y-m-d H:i:s");
        $table = "cposts";
        $id = getNewId($table, $con);

        $fields = array("id", "user_email","club_id" , "media_id", "media_type", "admin_perm", "ins_date", "upd_date");
        $values = array("'".$id."'", "'".$email."'", $club_id, "'".$media_id."'", "'".$media_type."'", "'0'", "'".$date_pub."'", "'".$date_pub."'");

        $f = implode(",", $fields);
        $v = implode(",", $values);

        $query = "insert into $table ( $f ) values ( $v )";
        $i = $con->db->executeNonQuery($query);

        if($i == true)
        {
            $post_ins = true;
            $rep .= "Your club file has been uploaded successfully ";
            $post_id = $id;
        }
        else
        {
            $err .= "Could not insert data in cpost db";
        }
    }
}
else
{
    $err .= "Could not upload file.";
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
