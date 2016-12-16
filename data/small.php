<?php

function putImageInFile($con, $albumName, $album_id, $imgFileName, $img_id, $originalpic, $thumbpic )
{
    $albumName = str_replace(" ", "_", $albumName);
    $albumName = $album_id. "_" .$albumName;
    
    $is_path = createFolderPath($albumName);
    if($is_path)
    {
        $album_path = PATH . "/directories/albums/" .$albumName;
        $imgFileName = str_replace(" ", "_", $imgFileName);
        $small_path = $album_path ."/". $img_id . "_sml_" . $imgFileName;
        $large_path = $album_path ."/". $img_id . "_lrg_". $imgFileName;
        
        if(file_exists($small_path))
        {
            $small_saved = true;
        }
        else
        {
            file_put_contents($small_path, $thumbpic);
            
            if(file_exists($small_path))
            {
                $small_saved = true;
            }
            else
            {
                $small_saved = false;
            }
        }
        
        if(file_exists($large_path))
        {
            $large_saved = true;
        }
        else
        {
            file_put_contents($large_path, $originalpic);
            
            if(file_exists($large_path))
            {
                $large_saved = true;
            }
            else
            {
                $large_saved = false;
            }
        }
    }
    else
    {
        return false;
    }
    
    if($small_saved && $large_saved)
    {
        return true;
    }
       
}

function createFolderPath($albumName)
{
    $path = PATH . "/directories/albums/" .$albumName;
    if(is_dir($path))
    {
        $hasDir = true;
    }
    else
    {
        if(mkdir($path , 0777))
        {
            $hasDir = true;
        }
        else
        {
            $err .= "Could not create $path folder. Contact your administrator to resolve this issue";
            $hasDir = false;
        }
    }
    return $hasDir;
}

function calcAge($date)
{
    $currdate = date("Y-m-d G:i:s");
    $d1 = new DateTime( $date );
    $d2 = new DateTime($currdate );
    $age = $d2->diff( $d1 );
    return $age->y;
}

function calcRating($tothits, $neghits, $maxRate = 5)
{
    $rate = (double)0;
    if($tothits > 0)
    {
        $rate =  (double)$maxRate - (double)( ((double)$maxRate / (double)$tothits ) * (double)($neghits) );
    }
    return $rate;
}

function rateChange($con, $media_type, $media_id, $rateType = 'down')
{
    $cont = getContStats($con, $media_type, $media_id);
    
    if($cont == null || $cont == "")
    {
        $tothits = 0;
        $neghits = 0;
        return null;
    }
    else if(is_string($cont) && strlen($cont) > 0)
    {
        $err = $cont;
        return $err;
    }
    else if(count($cont) > 0)
    {
        foreach($cont as $c)
        {
            if($rateType == 'down')
            {
                $tothits = (double)$c['tothits'] + (double)1;
                $neghits = (double)$c['neghits'] + (double)1;
                $rate = calcRating($tothits, $neghits);
                $rate = ceil($rate);
                $upd = updateContStats($con, $media_id,$media_type, '', $tothits, $neghits, $rate);
            }
            else
            {
                
                $tothits = (double)$c['tothits'] + (double)1;
                $neghits = (double)$c['neghits'];
                $rate = calcRating($tothits, $neghits);
                $rate = ceil($rate);
                $upd = updateContStats($con, $media_id,$media_type, '', $tothits, $neghits, $rate);
            }
            break;
        }
        return $upd;
    }
    else
        return null;
}

function getThumbImage($imagepath = 'interface/icos', $modwidth = 60, $fileName = 'user.gif')
{
    $save = "$imagepath/sml_" . $fileName; //This is the new file you saving
    $file = "$imagepath/" . $fileName; //This is the original file

    list($width, $height) = getimagesize($file) ; 
                                             
    $diff = $width / $modwidth;
                                            
    $modheight = $height / $diff; 

    $tn = imagecreatetruecolor($modwidth, $modheight) ; 
    
    $ar = explode(".", $fileName);
    if(is_array($ar))
    {
        $c = count($ar);
        if($c > 1)
            $ext = $ar[$c - 1];
    }
    
    if($ext == "gif")
    {
        $image = imagecreatefromgif($file);
    }
    if($ext == "jpeg" or $ext == "jpg" or $ext == "JPG" or $ext == "JPEG")
    {
        $image = imagecreatefromjpeg($file);
    }
    if($ext == "bmp" or $ext == "BMP")
    {
        $image = imagecreatefromwbmp($file);
    }
    
    if($ext == "png" or $ext == "PNG")
    {
        $image = imagecreatefrompng($file);
    }
    
    imagecopyresampled($tn, $image, 0, 0, 0, 0, $modwidth, $modheight, $width, $height) ; 

    if($ext == "gif")
    {
        $image = imagegif($tn, $save, 100);
    }
    if($ext == "jpeg" or $ext == "jpg" or $ext == "JPG" or $ext == "JPEG")
    {
        $image = imagejpeg($tn, $save, 100);
    }
    if($ext == "bmp" or $ext == "BMP")
    {
        $image = image2wbmp($tn, $save, 100);
    }
    if($ext == "png" or $ext == "PNG")
    {
        $image = imagepng($tn, $save);
    }

    $thumb_image = file_get_contents($save);
    
    exec("del $save");
    exec("del $file");
    
    unlink($save);
    unlink($file);
    
    return $thumb_image;
}

function loadFckEditMode($con, $body, $divIdName = 'bodytxt')
{
    include_once(PATH . "/scripts/fckeditor/fckeditor_php5.php");
    
    $oFCKeditor = new FCKeditor($divIdName);
    $oFCKeditor->BasePath = URL.'/scripts/fckeditor/' ;
    $oFCKeditor->Config["CustomConfigurationsPath"] = 'edconfig.js'; 
    $oFCKeditor->Config['SkinPath'] = "skins/silver/" ;
    $oFCKeditor->Width = 720;
    $oFCKeditor->Height = 500;
    $oFCKeditor->ToolbarSet = 'ArticleToolbar' ;
            
    $oFCKeditor->Value = "".$body ."";
    
    $fckEditor = $oFCKeditor->CreateHtml();
    
    return $fckEditor;    
}

function getFileExt($vfileName)
{
    $vfileExt = "";
    $ar = explode(".", $vfileName);
    if(is_array($ar))
    {
        $c = count($ar);
        if($c > 1)
            $vfileExt = ".".$ar[$c - 1];
    }
    return $vfileExt;
}

/*
function simpleMail($msgBody, $subject, $fromAr = 'ConveyLive <mail@conveylive.com>', $toAr)
{
    $mail_sent = false;
    $headers = "From: $fromAr" . "\r\n" . "Reply-To: mail@conveylive.com" . "\r\n" . "X-Mailer: conveylive/" . phpversion();
    try
    {
        if(mail($toAr, $subject, $msgBody, $headers))
        {
            $mail_sent = true;
        }
        return $mail_sent;
    }
    catch(Exception $ex)
    {
        $err .= $ex->getMessage();
        return $err;
    }
    return $mail_sent;
}
*/

function simpleMail($con, $msgBody, $subject, $fromAr = array("mail@conveylive.com" => "conveylive Team"), $toAr, $msgtype = "text/plain" , $replyTo = array("mail@conveylive.com" => "conveylive Team"), $priority = 0)
{
    $fromAr = array("mail@conveylive.com" => "conveylive Team");
    
    $all_done = false;
    if($priority == 0)
    {
        $transport = Swift_SmtpTransport::newInstance('localhost', 25);

        $mailer = Swift_Mailer::newInstance($transport);
        
        $message = Swift_Message::newInstance($subject)
                  ->setFrom($fromAr)
                  ->setTo($toAr)
                  ->setBody($msgBody, $msgtype)
                  //->setBcc(array('web@conveylive.com' => 'ConveyLive Mail Backups'))
                  ->setReplyTo($replyTo)
                  ;
        
        $numSent = 1; //$mailer->send($message);
            
        if ($numSent)
        {
            $mail_sent = true;
            $is_sent = 1;
            $send_count = 1;
        }
        else
        {
            $mail_sent = false;
            $is_sent = 0;
            $send_count = 0;
        }
    }

    $is_ins = insertMailDb($con, $msgBody, $subject, $fromAr, $toAr, $msgtype, $replyTo, $priority, $is_sent, $send_count);
    if( ($is_ins  && !$mail_sent)|| ($mail_sent && $priority == 0 && $is_ins))
    {
        $all_done = true;
    }
    
    return $all_done;
}

function hasRemUser($con)
{
    $ckname = 'ZakirCookie';
    if (isset($_COOKIE[$ckname])) 
    {
       $val = $_COOKIE[$ckname] ;
       $r = $con->db->selectData("select email, validator, ustatus, utype, pass from users where validator = '$val'");
       if($r!= false && $r != array() && $r != count($r) > 0)
       {
           $v = $r[0]['validator'];
           if($v == $val)
           {
               $utype = $r[0]['utype'];
               $pass =  $r[0]['pass'];
               $l = new Login(trim($email), trim($pass), $con->db);
               if($l->isLoged())
               {
                   $_SESSION['login'] = $l;
                   $islogin = true;
               }
           }
       }
    }
    return $islogin;
}

function DoHTMLEntities ($string) {
    $trans_tbl[chr(145)] = '&#8216;';
    $trans_tbl[chr(146)] = '&#8217;';
    $trans_tbl[chr(147)] = '&#8220;';
    $trans_tbl[chr(148)] = '&#8221;';
    $trans_tbl[chr(142)] = '&eacute;';
    $trans_tbl[chr(150)] = '&#8211;';
    $trans_tbl[chr(151)] = '&#8212;';
    return strtr ($string, $trans_tbl);
}

function retUrl($name)
{   
    $chkList = array( " ", "!", "@","#", "$", "%", "^", "&", "*", "(", ")", "_", "-", "+", "=", "~", "`", "'","\"", ":" , ";", "{", "}", "[", "]", "|", "?", ">", ".", "<", ",", "/");
    $size = count($chkList);
    $outStr = "";
    for($i= 0; $i < $size; $i++)
    {
       $outStr = str_replace($chkList[$i], "_", $name);  
    }
    if($outStr == "") 
        return "";
    else
        return strtolower($outStr);
}

function checkavail($url, $boolret = true)
{
    mysql_connect("localhost", "root", "");
    mysql_select_db("conlive");
    
    $qr = "select url from blogs where url = '$url' ";
    $r = mysql_query($qr);
    $dbUrl = "";
    while($line = mysql_fetch_assoc($r))
    {
        $dbUrl = $line['url'];
    }
    
    if( strtolower($dbUrl) == strtolower(trim($url)) )
    {
        $isAvail = "This url name: ".$url ." is not available. Please try a new name.";
        $notExist = false;
    }
    else
    {
        $isAvail = "This url name: ".$url." is available! You can now click the Create Blog button to get a new blog.";
        $notExist = true;
    }
    if($boolret == true)
    {
       return $notExist; 
    }
    else
    {
        return $isAvail;
    }
}

function getParams()
{
    return explode('/', $_GET['url']);
}

function getSideItems($email, $con)
{
    $prof_exist = false;
    $q = "select user_email from profiles where user_email = '$email' and admin_perm = 0";
    $p = $con->db->selectData($q);
    
    if($p != false && $p != null && count($p) > 0)
    {
        if($p[0]['user_email'] == trim($email)) 
            $prof_exist = true;
    }
    
    $sideItems = array();
    $sideItems[] = array("link" => URL."/home/$email", "img" => URL."/interface/icos/home.png", "name" => "Home", "desc" => "Your home page with all accessibility");
    if($prof_exist == false)
    {
        $sideItems[] = array("link" => URL."/profile/create/$email", "img" => URL."/interface/icos/create.png", "name" => "Create Profile", "desc" => "Create a profile with your information.");
    }
    else
    {
        $sideItems[] = array("link" => URL."/profile/edit/$email", "img" => URL."/interface/icos/edit_profile.png", "name" => "Update Profile", "desc" => "Change your personal information.");
        $sideItems[] = array("link" => URL."/profile/profilepicture/$email", "img" => URL."/interface/icos/image_.png", "name" => "Set Profile Photo", "desc" => "Set your profile picture.");
        /*$sideItems[] = array("link" => URL."/profile/delete/$email", "img" => URL."/interface/icos/delete.png", "name" => "Delete Profile", "desc" => "Remove your profile information");*/
        $sideItems[] = array("link" => URL."/profile/view/$email", "img" => URL."/interface/icos/view_prof.png", "name" => "View Profile", "desc" => "See your profile");
    }
    $id = getPrifileId($email, $con);
    
    $sideItems[] = array("link" => URL."/friend/viewfriends/$id", "img" => URL."/interface/icos/users.png", "name" => "Friends", "desc" => "See all your friends");
    $sideItems[] = array("link" => URL."/accounts/edit/$email", "img" => URL."/interface/icos/settings.png", "name" => "Account", "desc" => "Change your account settings");
    
    return $sideItems;
}

function viewCmnts($per_page, $privacy, $mediatype, $limit, $mediaid, &$con)
{
    $hasComment = false;
    $tot = 0;

    $sql = "select count(*) as tot from comments where mtype = '$mediatype' and media_id = $mediaid and perm = 2 and privacy = $privacy";
    //echo $sql;
    $rsd = $con->db->selectData($sql);
    if($rsd != false || $rsd != array())
    {
        $tot = $rsd[0]['tot'];
    }
    //echo $con->db->err;
    //echo $tot;
    if($tot > 0)
    {
        $hasComment = true;
    }
    $con->tp->assign('tot', $tot);
    $con->tp->assign('limit', $limit);
    $con->tp->assign('per_page', $per_page);
    $con->tp->assign('mediatype', $mediatype);
    $con->tp->assign('mediaid', $mediaid);
    $con->tp->assign('privacy', $privacy);
    $con->tp->assign('hasComment', $hasComment);
    
    //$b = $con->tp->fetch('precmnt_view.tpl');
    //$b =  $con->tp->get_template_vars('preComment');
}

function getDayList()
{
    $daylist = array();
    for($i=1; $i<=31; $i++)
    {
        $daylist[] = $i;
    }
    return $daylist;
}

function getMonthList()
{
    $monthlist = array();
    for($i=1; $i<=12; $i++)
    {
        $monthlist[] = $i;
    }
    return $monthlist;
}

function getTxtMonths()
{
    $monthlist = array( 1 => "Jan", "Feb" , "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec" );
    return $monthlist;
}

function getYearList($yearmin, $yearmax )
{
    $yearlist = array();
    if($yearmax != $yearmin)
    {
        $tmax = $yearmax > $yearmin ? $yearmax : $yearmin;
        $tmin = $yearmin < $yearmax ? $yearmin : $yearmax;    
    }
    else return;
    for($i= $tmin; $i <= $tmax; $i++)
    {
        $yearlist[] = $i;
    }
    return $yearlist;
}

function getRelStatusList()
{
    $rs = array("Single", "In a Relationship", "Engaged", "Married", "It's Complicated");
    return $rs;
}
?>
