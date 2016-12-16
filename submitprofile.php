<?php
if(!isset($_POST['submit']) ){ echo "You can not access this page directly."; return; } 

require_once('config/project.php');
$con = new Project();
$pageName ='profile_submit';


$title = "ConveyLive :: Profile";
$con->tp->assign('title', $title);
$rep = "";
$err = "";
$btitle = "";
$bbody = "";
$vad = "";
$had = "";
$sideitem = array();
$islogin = true;

$con->tp->assign('title', $title);


$picture = "";
$img_type = "";
$language = "";
$prof_ins = false;
$img_ins = false;
$prof_upt = false;
$img_upt = false;
$thumb_widthpx = 160;

if(isset($_SESSION['login'] ) == true)
{
    $l = $_SESSION['login'];
    $islogin = true;
    $email = $l->getEmail();
}
$con->tp->assign('islogin',$islogin);

extract($_POST);

if(isset($lang)) $language = implode(",", $lang);
$ins_date = date("Y-m-d G:i:s");


switch($action)
{
    case 'create':
    $img_path = "interface/icos";
    $fileName = "user.gif";
    
    $file_size = filesize($img_path."/".$fileName);
    $originalpic = file_get_contents($img_path."/".$fileName);
    $img_type = "image/gif";
    
    list($width, $height) = getimagesize($img_path."/".$fileName);
    if($width > $thumb_widthpx)
    {
        $thumbpic = getThumbImage($img_path, $thumb_widthpx, $fileName);
    }
    else
    {
        $thumbpic = $originalpic;
    } 
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
        $album_name = "Profile";
        $remarks = "";
        $privacy = 1; //privacy only friends - for profile photos 
        $ins_date = date("Y-m-d G:i:s");
        
        $q = "insert into albums (id, user_email, category_id, image_id, album_name, remarks, privacy, ins_date, upd_date, admin_perm ) values ( $aid , '$email', $cat_id, $img_id, '$album_name', '$remarks' , $privacy, '$ins_date', '$ins_date', 0)";

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
    
    if($ins_album)
    {
        $table = "images";
        $status = 0;
        
        $fields = array("id", "user_email", "file_type", "stat", "file_name", "file_size", "album_id", "admin_perm", "ins_date", "upd_date");
        $values = array("'".$img_id."'", "'".$user_email."'", "'".$img_type."'", "'".$status."'", "'".$fileName."'", "'".$file_size."'", "'".$aid."'", "'0'", "'".$ins_date."'", "'".$ins_date."'");

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
    }
    
    if($img_ins)
    {
        $btitle = "Profile Creation";     
        $table = "profiles";
        
        if($otherlang != "")
        {
            $lang = $otherlang;
        }
        
        $fields = array("user_imgs_id","user_email", "addr", "city", "country", "zipcode", "occupation", "religion", "about_me", "lang" , "home_town","rel_status","interests","favourites","phone","web_url", "edu_info","work_info", "ins_date", "upd_date", "active", "admin_perm", "lookingfor", "activities");
        $values = array("'".$img_id."'","'".$user_email."'", "'".addslashes($address)."'", "'".addslashes($city)."'", "'".addslashes($country)."'", "'".addslashes($zip_code)."'", "'".addslashes($occupation)."'", "'".addslashes($religion)."'", "'".addslashes($about_me)."'", "'".addslashes($language)."'" , "'".addslashes($home_town)."'", "'".addslashes($rel_status)."'", "'".addslashes($interests)."'", "'".addslashes($favorites)."'", "'".addslashes($phone)."'", "'".addslashes($web)."'", "'".addslashes($edu_info)."'", "'".addslashes($work_info)."'", "'".date("Y-m-d H:i:s")."'","'".date("Y-m-d H:i:s")."'", "'0'", "'0'", "'". $lookfor."'", "'".addslashes($activities)."'");

        $f = implode(",", $fields);
        $v = implode(",", $values);

        $query1 = "insert into $table ( $f ) values ( $v )";
        
        $i = $con->db->executeNonQuery($query1);
        if($i == true)
        {
            $prof_ins = true;
        }
        $err .= $con->db->err;
    }
    
    if($prof_ins && $img_ins && $ins_album)
    {
        $rep .= "Your profile has been created successfully.";
    }
    else if(!$img_ins)
    {
        $err .= "Could not insert profile information. Image not added. Please try again.";
    }
    else if(!$ins_album)
    {
        $err .= "Could not insert profile information. Album not added. Please try again.";
    }
    else if(!$prof_ins)
    {
        $err .= "Could not insert profile information. Please try again.";
    }
    break;
    
    case 'update':
        $btitle = "Profile Update";

        $address = addslashes($address);
        $city = addslashes($city);
        $country = addslashes($country);
        $zip_code = addslashes($zip_code);
        $occupation = addslashes($occupation);
        $religion = addslashes($religion);
        $about_me = addslashes($about_me);
        $language = addslashes($language);
        $home_town = addslashes($home_town);
        $rel_status = addslashes($rel_status);
        $interests = addslashes($interests);
        $favorites = addslashes($favorites);
        $phone = addslashes($phone);
        $web = addslashes($web);
        $edu_info = addslashes($edu_info);
        $work_info = addslashes($work_info);
        $activities = addslashes($activities);
        
        $q = "update profiles set addr = '$address', city = '$city', country = '$country', zipcode = '$zip_code', occupation = '$occupation', religion = '$religion', upd_date = '".date("Y-m-d H:i:s")."', about_me = '$about_me', home_town = '$home_town', rel_status = '$rel_status', interests = '$interests', favourites = '$favorites', phone = '$phone', web_url = '$web', edu_info = '$edu_info', work_info = '$work_info', lookingfor = '$lookfor', activities = '$activities' where user_email = '$user_email'";
        
        $i = $con->db->updateData($q);
        if($i == true)
        {
           $prof_upt = true;
        }
        $err .= $con->db->err;
        

        if($prof_upt)
        {
            $rep = "Your profile has been updated successfully.";
        }
        else
        {
            $err .= "Could not update profile information. Please try again with correct fields and valid characters. " .$i;
        }    
    break;
}

$id = getPrifileId($user_email, $con);

viewProfile($con,$id, $user_email);

$v = setLoginInfo($user_email, $con);

$sideitem = getSideItems($user_email, $con);

$blogexist = checkBlog($con, $user_email);
    
$con->tp->assign('blogexist', $blogexist);

$con->tp->assign('sideitem', $sideitem);

$con->tp->assign('rep', $rep);

$con->tp->assign('err', $err);

$con->tp->assign('islogin',$islogin);

addSiteStat($pageName, $con, $user_email);

$con->tp->display('main.tpl');     

?>