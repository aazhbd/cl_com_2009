<?php
//if(!isset($_POST['submit'])){ echo "You can not access this page directly."; return; }

require_once('config/project.php');
$con = new Project();

$pageName ='Submit Audio';

$title = "conveylive.com :: $pageName";

$desc = "Publish Audio, Songs, Voice in conveylive.com. Listen to you favourite audio publshed by users of ConveyLive and browse audio";
$con->tp->assign("descrip", $desc);

$keys = "Audio, Listen, Song, Music, Voice, communicate, share,network,  conveylive";
$con->tp->assign("keys", $keys);

$rep = "";
$err = "";
$btitle = "";
$bbody = "";
$vad = "";
$had = "";
$sideitem = array();
$islogin = false;
$audio_ins = false;
$audio_upd = false;

$MAX_FILE_SIZE = 9437184;

$con->tp->assign('title', $title);

//getLatestCont($con,"Audios");
//getTopRatedCont($con,"Audios");
//getMostViewedCont($con,"Audios");

if(isset($_SESSION['login'] ) == true)
{
    $l = $_SESSION['login'];
    $islogin = true;
    $email = $l->getEmail();
}
$con->tp->assign('islogin',$islogin);

extract($_POST);


if($action == "insert")
{
    $pageName ='Save Audio';
    
    $filePath = PATH . "/tmp";
    $fileName = basename($_FILES['audio']['name']);
    
    $uploadfile = PATH ."/tmp/in.mp3";
    
    $error_code =  $_FILES['audio']['error'];    
    
    if($error_code > 0)
    {
        switch($error_code)
        {
            case 1:
            $err = "The file is larger than ConveyLive allows. ";
            break;
            
            case 2:
            $err = "The audio you selected is more than $MAX_FILE_SIZE bytes. Please select a smaller file.";
            break;
            
            case 3:
            $err = "Only part of the file was uploaded";
            break;
            
            case 4:
            $err = "Can not move file! ";
        }
        $upload_success = false;
    }
    else
    {
        if(move_uploaded_file($_FILES['audio']['tmp_name'], $uploadfile)) 
        {
            if( file_exists($uploadfile) )
            {
                ////$cmd = "ffmpeg -i " . $filePath . "/in.mp3 -y -acodec libmp3lame -ab 64 -ar 44100 " . $filePath . "/out.mp3";
                $cmd = "ffmpeg -i " . $filePath . "/in.mp3 -y -acodec libmp3lame " . $filePath . "/out.mp3";
                //$cmd = PATH. "/tmp/ffmpeg.exe -i " . $filePath . "/in.mp3 -y -acodec mp3 " . $filePath . "/out.mp3";
                $out = exec($cmd);
                
                if( file_exists("$filePath/out.mp3") )
                {
                    $audio = file_get_contents($filePath . "/" . "out.mp3");
                    
                    $fileSize = $_FILES['audio']['size'];
                    $fileType = $_FILES['audio']['type'];
                    $upload_success = true;
                }
                else
                {
                    $err = "Could not save audio";
                    $upload_success = false;
                }
            }
            else
            {
                $err = "Audio file does not exist.";
            }
        }
        else
        {
            $err = "Failed to upload audio file.";
        }
         
        $date_pub = date("Y-m-d H:i:s");

        if($upload_success && $audio != null)
        {
            if(!get_magic_quotes_gpc())
            {
                $fileName = addslashes($fileName);
            }
            
            $table = "audios";
            $id = getNewId($table, $con);
            
            $new_filename = $id . "_" . trim($fileName);
            
            $new_filename = str_replace(' ', '_', $new_filename);
            
            $ins_date = date("Y-m-d G:i:s");
            
            $fields = array("id", "user_email", "title", "artist", "category_id", "additional", "file_path", "filename", "filetype",  "filesize", "meta_tags", "privacy", "ins_date", "upd_date", "admin_perm");
            $values = array("'".$id."'" , "'".$email."'" , "'".addslashes($audiotitle)."'" , "'".addslashes($artist)."'", "'".$cat_id."'", "'".addslashes($additional)."'", "'".addslashes($new_filename)."'", "'".addslashes($fileName)."'", "'".$fileType."'", "'".$fileSize."'", "'".addslashes($meta_tags)."'", "'0'", "'".$ins_date."'", "'".$ins_date."'", "'0'");
                
            $f = implode(",", $fields);
            $v = implode(",", $values);
            
            $query = "insert into $table ( $f ) values ( $v )";

            $i = $con->db->insertData($query);
            
            $err = $con->db->err;
            if($i == true)
            {
                unlink($uploadfile);
                
                $new_path = PATH . "/directories/audios/$new_filename";
                
                if($audio != null)
                {
                    chmod($new_path, 0777);
                    file_put_contents($new_path, $audio);
                }
                
                if(file_exists($new_path))
                {
                    unlink($filePath . "/" . "out.mp3");
                    $audio_ins = true;
                }
                else
                {
                    $err .= "Audio Uploaded and Inserted. Could not save audio in filesystem. Please contact your administrator to resolve this error.";
                }            
            }
            else
            {
                $err .= "Audio uploaded but not saved in database. Could not save audio in filesystem. Please contact your administrator to resolve this error.";
            } 

            if($audio_ins)
            {
                $view_count = 0;
                $tothits = 0;
                $neghits = 0;
                $rating = 0;
                $media_id = $id;
                $media_type = "Audio";
                
                $contstat_ins = insertContStats($con, $email, $view_count, $tothits, $neghits, $rating, $media_id, $media_type);
                if($contstat_ins)
                {
                    $art_ins = true;
                }
                if($art_ins)
                {
                    $name = getUserName($email, $con);
                    $subject = "Your audio has been published.";
                    $msgBody = "Hello, $name \r\n";
                    $msgBody .= "Your audio has been published.\r\n\r\n";
                    $msgBody .= "To listen to this audio, follow the link below: \r\n\r\n http://conveylive.com/audio/listen/$id";
                    $msgBody .= "\r\n\r\nThanks\r\n\r\nConveylive Team\r\n\r\n";
                    $msgBody .= "-------\r\n\r\nFind people from your address book on conveylive.com! Go to: http://conveylive.com/invite.php";
                    $msgBody .= "\r\n\r\nThis message was intended for $email";
                    
                    $fromAr = array("mail@conveylive.com" => "Conveylive Team");
                    $toAr = array($email => $name);
                    
                    $isMailSent = simpleMail($con, $msgBody, $subject, $fromAr, $toAr, 'text/plain', $fromAr, 0 );
                    
                    if($isMailSent)
                    {
                        $err .= "Your audio has been published.";
                        $err .= "<a href ='".URL."/audio/listen/".$id."'>Listen to this audio</a>";
                    }
                    else
                    {
                        $err .= "Audio published!  But Mail Not Sent to notify";
                    }
                }
                else
                {
                    $err .= "Audio published!  But Mail Not Sent to notify. and Content Statistics not inserted.";
                }
            }
            else
            {
                 $err .= "Audio was not inserted properly. Could not save audio. Please try again with correct fields and valid characters.";
            }
        }
        else
        {
            $err .= "Audio was not uploaded properly. Could not save audio. Please try again with correct fields and valid characters.";
        }
    }
}
else if($action == "update")
{
    $table = "audios";
    
    $fields = array("title", "category_id", "artist", "additional", "upd_date", "meta_tags");
    $values = array(addslashes($audiotitle) , $genre , addslashes($artist) , addslashes($additional), $date_pub , addslashes($meta_tags) );


    $query = "update $table set ";
    $i = 0;
    foreach($fields as $f)
    {
        if($i > 0) $query .= " , ";
        $query .= "".$f." = '".$values[$i]."'";
        $i++;
    }

    $query .= " where id = $id and user_email = '$email'";

    $i = $con->db->executeNonQuery($query);

    if($i == true)
    {
        $audio_upd = true;
    }
    $err .= $con->db->err;

    if($audio_upd)
    {
        $rep = "Your audio has been updated.";
    }
    else
    {
        $err .= "We are sorry. Your audio was not published. Please try again.";
    }

    $retList = play_audio($con, $email, $id);

    $bbody = $retList['bbody'];
    $btitle = $retList['btitle'];
    $bsubtitle = $retList['bsubtitle'];
    $rep .= $retList['rep'];
    $err .= $retList['err'];    
    
}

$con->tp->assign('rep', $rep);

$con->tp->assign('err', $err);

$con->tp->assign('bbody', $bbody);

$con->tp->assign('btitle',$btitle);

$con->tp->assign('bsubtitle',$bsubtitle);

$con->tp->assign('email',$email);

$v = setLoginInfo($email, $con);

$sideitem = getSideItems($email, $con);

$blogexist = checkBlog($con, $email);

$con->tp->assign('sideitem', $sideitem);

$con->tp->assign('title',$pageName);

addSiteStat($pageName, $con, $email);

$con->tp->display('main.tpl');
 
?>