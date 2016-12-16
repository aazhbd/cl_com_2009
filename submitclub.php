<?php
if(!isset($_POST['submit']) ){ echo "You can not access this page directly."; return; } 

require_once('config/project.php');
$con = new Project();
$pageName ='Create Club';


$title = "ConveyLive :: Clubs";
$con->tp->assign('title', $title);
$rep = "";
$err = "";
$btitle = "";
$bbody = "";
$sideitem = array();
$islogin = true;

$con->tp->assign('title', $title);

getLatestCont($con,"Clubs");

$desc = "Create Your own Clubs to discuss and share your digital possesions like, Photos, Files and text posts. Browse all the Clubs of conveylive published by users to share,comment and discuss.";
$con->tp->assign("descrip", $desc);

$keys = "New Clubs, Posts, File, Share, Community, Network, ConveyLive";
$con->tp->assign("keys", $keys);

$picture = "";
$img_type = "";
$language = "";
$club_ins = false;
$img_ins = false;
$mem_ins = false;

if(isset($_SESSION['login'] ) == true)
{
    $l = $_SESSION['login'];
    $islogin = true;
    $email = $l->getEmail();
}

extract($_POST);

$MAX_FILE_SIZE = 2097152;
$thumb_widthpx = 160;

$default_img = false;
$img_path = PATH . "/tmp";
$fileName = basename($_FILES['clubphoto']['name']);

$uploadfile = $img_path ."/". $fileName;

if(move_uploaded_file($_FILES['clubphoto']['tmp_name'], $uploadfile)) 
{
    $file_size = filesize($uploadfile);
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

        $img_path = "interface/icos";
        $fileName = "club.png";
        
        $file_size = filesize(PATH . "/".$img_path."/".$fileName);
        $originalpic = file_get_contents(PATH . "/".$img_path."/".$fileName);
        
        list($width, $height) = getimagesize(PATH . "/".$img_path."/".$fileName);
        if($width > $thumb_widthpx)
        {
            $thumbpic = getThumbImage($img_path, $thumb_widthpx, $fileName);
        }
        else
        {
            $thumbpic = $originalpic;
        } 
        $img_type = filetype(PATH . "/".$img_path."/".$fileName);
        $default_img = true;
    }
    $upload_success = false;
}


if($upload_success || $default_img)
{
    //Album insert
    $aid = getNewId("albums", $con);
    $img_id = getNewId("images", $con);

    $album_name = "$cname";
    $remarks = "";
    $priv = "4"; // Club Albums
    $ins_date = date("Y-m-d G:i:s");

    $q = "insert into albums (id, user_email, category_id, image_id, album_name, remarks, privacy, ins_date, upd_date, admin_perm ) values ( $aid , '$email', $cat_id, $img_id, '$album_name', '$remarks' , $priv, '$ins_date', '$ins_date', 0)";
    
    $r = $con->db->insertData($q);
    if($r == false)
    {
        $err .= $con->db->err;
        $ins_album = false;
    }
    else
    {
        $ins_album = true;
        
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
    }

    if($ins_album)
    {
        //Image insert
        $table = "images";
        $status = 0;
        $ins_date = date("Y-m-d G:i:s"); 
        
        $img_id = getNewId($table, $con);

        $status = 0;
        
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
            
            $albumName = $album_name; 
            $album_id = $aid;
            $imgFileName = $fileName;
            $img_id = $img_id;
            $isCreated = putImageInFile($con, $albumName, $album_id, $imgFileName, $img_id, $originalpic, $thumbpic );
        }
        $err .= $con->db->err;
    }
    
    if($img_ins && $ins_album)
    {
        //Club Insert     
        $table = "clubs";
        $status = 0;
        $club_id = getNewId($table, $con);
        $fields = array("id", "user_email", "cname", "description", "category_id", "ins_date","upd_date", "image_id", "admin_perm", "privacy", "status" );
        $values = array("'".$club_id."'", "'".$email."'", "'".addslashes($cname)."'", "'".addslashes($description)."'","'".$cat_id."'", "'".$ins_date."'","'".$ins_date."'", "'".$img_id."'", "'0'", "'".$privacy."'", "'".$status."'");

        $f = implode(",", $fields);
        $v = implode(",", $values);

        $query1 = "insert into $table ( $f ) values ( $v )";
        
        $i = $con->db->executeNonQuery($query1);
        
        if($i == true)
        {
            $club_ins = true;
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
                    $err .= "Could not create directories folder. Contact your administrator to resolve this issue";
                }
            }
            $has_club_dir = false;
            
            if($hasDir)
            {
                $name = str_replace(" ", "_", $cname);
                $club_dir = $main_dir ."/".$club_id . "_". $name;

                if(is_dir($club_dir))
                {
                    $err .= "Could not create directory for club. Please chose a different name for directory.";
                }
                else
                {
                    if(mkdir($club_dir , 0777))
                    {
                        $has_club_dir = true;
                        //echo "Directory has been created successfully...";
                    }
                    else
                    {
                        $has_club_dir = false;
                        //echo "Failed to create directory...";
                    }
                }
            }
        }
        $err .= $con->db->err;
    }
    
    if($has_club_dir && $club_ins)
    {
        //Album post insert in cpost table
        
        $media_id = $aid;
        $media_type = "Club Album";
        $date_pub = date("Y-m-d H:i:s");
        $table = "cposts";
        $id = getNewId($table, $con);

        $fields = array("id", "user_email","club_id" , "media_id", "media_type", "admin_perm", "ins_date", "upd_date");
        $values = array("'".$id."'", "'".$email."'", $club_id, $media_id, "'".$media_type."'", "0", "'".$date_pub."'", "'".$date_pub."'");

        $f = implode(",", $fields);
        $v = implode(",", $values);

        $query = "insert into $table ( $f ) values ( $v )";
        $i = $con->db->executeNonQuery($query);

        if($i == true)
        {
            $post_ins = true;
            $post_id = $id;
        }
        $err .= $con->db->err;
        
        
        //Club Member Insert
        $table = "cmembers";
        $join_date =  date("Y-m-d H:i:s");
        $status = 0;
        $privilege = 2;
        $permission = 0;
        $mem_id = getNewId($table, $con);
        $fields = array("id","user_email", "club_id", "join_date", "privilege", "admin_perm", "status" , "ins_date", "upd_date");
        $values = array("'".$mem_id."'", "'".$email."'", "'".$club_id."'", "'".$join_date."'","'".$privilege."'", "'".$permission."'", "'".$status."'", "'".$ins_date."'", "'".$ins_date."'");

        $f = implode(",", $fields);
        $v = implode(",", $values);

        $query1 = "insert into $table ( $f ) values ( $v )";
        $i = $con->db->executeNonQuery($query1);
        if($i == true)
        {
            $mem_ins = true;
        }
        $err .= $con->db->err;
        
        if(!$img_ins)
        {
            $err .= "Cound not insert image";
        }
        if(!$club_ins)
        {
            $err .= "Cound not create your new club";
        }
        if(!$mem_ins)
        {
            $err .= "Cound not insert member";
        }
        
        
        //Cont Stat insert
        $view_count = 0;
        $tothits = 0;
        $neghits = 0;
        $rating = 0;
        $media_id = $club_id;
        $media_type = "Club";
        
        $contstat_ins = insertContStats($con, $email, $view_count, $tothits, $neghits, $rating, $media_id, $media_type);
        if($contstat_ins)
        {
            $stat_ins = true;
        }
        
        if($club_ins && $img_ins && $mem_ins && $stat_ins && $post_ins)
        {
            $name = getUserName($email, $con);
            $subject = "Your club has been published.";
            $msgBody = "Hello, $name \r\n\r\n";
            $msgBody .= "Your club has been created.\r\n\r\n";
            $msgBody .= "To go to your club, follow the link below:\r\n\r\n http://conveylive.com/clubs/view/$club_id";
            $msgBody .= "\r\n\r\nThanks\r\n\r\nConveyLive Team\r\n\r\n";
            $msgBody .= "-------\r\n\r\nFind people from your address book on ConveyLive! Go to: http://conveylive.com/invite,php";
            $msgBody .= "\r\n\r\nThis message was intended for $email";
            
            $fromAr = array("mail@conveylive.com" => "Conveylive Team");
            $toAr = array($email => $name);
            
            $isMailSent = simpleMail($con, $msgBody, $subject, $fromAr, $toAr);
            if($isMailSent)
            {
                $rep .= "Your new club has been created successfully";
            }
            else
            {
                $err = $isMailSent;
                $rep .= "Your new club has been created successfully. But Mail Not Sent to notify";
            }
        }
        else
        {
            $err .= "Could not insert Club information.";
        }
    }
    else
    {
        $err .= "Could not insert Club information.";
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
