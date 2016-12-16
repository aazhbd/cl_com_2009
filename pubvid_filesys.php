<?php
define('PATH', str_replace(DIRECTORY_SEPARATOR, '/', realpath(dirname(__FILE__).'/..')));
//require_once('config/project.php');
//$con = new Project();

//chdir(dirname(__FILE__));

$log = fopen("log.txt", "w");

//$l = mysql_connect("localhost", "conlive_cuser", "mod#8121431") or die("Can't connect " . mysql_error());

$l = mysql_connect("localhost", "root", "") or die("Can't connect " . mysql_error());
//mysql_select_db("conlive_conlive") or die("can't select DB " . mysql_error());

mysql_select_db("conlivenew") or die("can't select DB " . mysql_error());

$data = mysql_query("select * from uploaded_videos") or die("Can't select data " . mysql_error());

$num = mysql_num_rows($data);

fwrite($log, "Total videos found " . $num . "\n");

if($num > 0)
{
    while($d = mysql_fetch_assoc($data))
    {
        $file_name = $d['filename'];
        $file_name = str_replace(" ", "_", $file_name);
        
        //echo $file_name;
        
        $old_name = $d['file_path'];
        $old_path = PATH . "/site/tmp/". $d['file_path'];
        
        $id = getNewId("videos");
        
        $new_name = $id."_".$file_name;
        $ext = getFileExt($new_name);
        $new_name = str_replace($ext, ".flv", $new_name);
        echo $new_name."\n\n";
        $new_path = PATH . "/site/directories/videos/$new_name";
        
        if( !file_exists($old_path))
        {
            fwrite($log, "\n File does not exist in location $old_path with id = " . $d['id'] . " at ". date("F j, Y, g:i a") . "\n");
            echo "Error generated.\n";
        }
        else
        {
            $c = encodeFile($old_path, $log, $new_path);
            
            if($c == false)
            {
                fwrite($log, "\nUnsuccessful encode operation on id = " . $d['id'] . " at ". date("F j, Y, g:i a") . "\n");
                echo "Error generated.\n";
            }
            else
            {
                if(file_exists($new_path))
                {                    
                    $e = insertDB("$new_name", $d, $new_path);
                }
                if($e == false)
                {
                    fwrite($log, "\nUnable to insert to db id = " . $d['id'] . " at " . date("F j, Y, g:i a") . "\n");
                    echo "Error generated.\n";
                }
                else
                {
                    $sc = getScreenShot($new_name, $d, $id);
                    
                    if($sc == false)
                    {
                        fwrite($log, "\nUnable to get screenshot for video with id = " . $d['id'] . " at " . date("F j, Y, g:i a") . "\n");
                        echo "Error generated for screenshot.\n"; 
                    }
                    else
                    {
                        fwrite($log, "\nOperation complete successfully on id = " . $d['id'] . " at " . date("F j, Y, g:i a") . "\n");
                        echo "Operation complete successfully on id = " . $d['id'] . " at ". date("F j, Y, g:i a");
                    }
                    unlink($old_path);
                }
            }
        }
    }
}

function getNewId($table)
{
    $q = "select max(id) as max from $table";
    
    if($r = mysql_query($q))
    {
        echo "id done";
        while($l = mysql_fetch_assoc($r))
        {
            $max = $l["max"];
        }
        echo $max;
        return $max + 1;
    }
    else
    {
        
        return 0;
    }
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

function getScreenShot($new_name, $d, $id)
{
    $vfile_ext = getFileExt($d['filename']);
    $table = "images";
    $id = getNewId($table);
    echo "id = ". $id ."\n";
    $fileName = $d['filename'];
    $fileName = str_replace($vfile_ext, "" ,$fileName);
    $fileName = str_replace(" ", "_" ,$fileName);
    
    //echo $fileName;
    
    //$cmd = "ffmpeg -itsoffset -4 -i " . $videofile ." -vcodec png -vframes 1 -an -f rawvideo -s 320x240 $fileName.png";
    $cmd = PATH ."/site/tmp/ffmpeg.exe -itsoffset -4 -i " .PATH."/site/directories/videos/". $new_name ." -vcodec png -vframes 1 -an -f rawvideo -s 480x270 ".PATH. "/site/tmp/large.png";
    $out = exec($cmd);
    
    $smlfileName = "sml_".$fileName;
    
    //$cmd = "ffmpeg -itsoffset -4 -i " . $videofile ." -vcodec png -vframes 1 -an -f rawvideo -s 160x120 $smlfileName.png";
    $cmd = PATH ."/site/tmp/ffmpeg.exe -itsoffset -4 -i " .PATH."/site/directories/videos/". $new_name ." -vcodec png -vframes 1 -an -f rawvideo -s 160x120 ".PATH."/site/tmp/small.png";
    $out = exec($cmd);
    
    echo "\r\n".$cmd ."\r\n";
    
    $img_saved = false;
    $hasThumb = false;
    $lrgimg_saved = false;
    $smlimg_saved = false;
    
    if( file_exists(PATH. "/site/tmp/large.png") )
    {   
        $fileSize = filesize(PATH. "/site/tmp/large.png");
        $image = file_get_contents(PATH. "/site/tmp/large.png");
        $fileType = "image/png";

        $lrgimg_saved = true;
        unlink(PATH. "/site/tmp/large.png");
    }
    
    if( file_exists(PATH. "/site/tmp/small.png") )
    {
        
        $thumbpic = file_get_contents(PATH. "/site/tmp/small.png");
        $smlimg_saved = true;
        unlink(PATH. "/site/tmp/small.png");
    }
    
    if($lrgimg_saved && $smlimg_saved)
    {
        $email = $d['user_email'];
        $ext = getFileExt($new_name);
        $new_name = str_replace($ext, ".png", $new_name);
        //$new_name = str_replace(" ", "_", $new_name);
        $isIns = insertImg($image, $thumbpic, $d, $id, $fileSize, $fileType , $new_name, $email);
        if($isIns == false)
        {
            $img_saved = false;
            
            $q = "select album_name from albums where id = $aid";
            $r = mysql_query($q); 
            if($r == null || $r == false || $r == array() || count($r) == 0)
            {
                $err .= $con->db->err;
            }
            else
            {
                while($a = mysql_fetch_assoc($r))
                {
                   $album = $a; 
                }
                $albumname = $album['album_name'];
            }
            
            $q = "select file_name from images where id = ".$album['image_id'];
            $r = mysql_query($q); 
            if($r == null || $r == false || $r == array() || count($r) == 0)
            {
                $err .= $con->db->err;
            }
            else
            {
                while($a = mysql_fetch_assoc($r))
                {
                   $album = $a; 
                }
                $img_name = $album['file_name'];
            }            
            
            $albumName = $albumname; 
            $album_id = $aid;
            $imgFileName = $img_name;
            $img_id = $album['image_id'];
            $isCreated = putImageInFile($albumName, $album_id, $imgFileName, $img_id, $image, $thumbpic ); 
            if($isCreated)
            {
                echo "Screenshot image created"; 
            }           
        }
        else
        {
            $vid = $d['id'];
            $q = "update videos set img_id = $id where id = $vid";
            
            if($r = mysql_query($q))
            {
                $img_saved = true;
            }
            else
            {
                 echo mysql_error();
                 $img_saved = false;
            }
        }
    }
    else
    {
        $img_saved = false;
    }
    return $img_saved; 
}

function createFolderPath($albumName)
{
    $path = "directories/albums/" .$albumName;
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
            echo $err;
            $hasDir = false;
        }
    }
    return $hasDir;
}

function putImageInFile($albumName, $album_id, $imgFileName, $img_id, $image, $thumbpic )
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

function getCatsByName($con, $catName)
{
    $q = "select * from categorys where cname = $catName";
    
    if($r = mysql_query($q))
    {
        echo "id done";
        while($l = mysql_fetch_assoc($r))
        {
            $m = $l;
            break;
        }
        return $m;
    }
    else
    {
        
        return 0;
    }    
}

function getVideoAlbumId($email, $album_name = 'Video', $img_id)
{
    $id = "";
    $q = "select id from albums where user_email = '$email' and album_name = '$album_name'";
    echo "\r\n".$q . "\r\n\r\n";
    $r = mysql_query($q);

    if($albums = mysql_fetch_assoc($r))
    {
        $id = $albums['id'];
        return $id;
    }
    else
    {
        $id = getNewId("albums");
        $cat = getCatsByName($con, "Album");
        
        $cat_id = $cat['id'];
        $date = date("Y-m-d H:i:s");
        $q = "insert into albums ( id, album_name, user_email, category_id , image_id, remarks, privacy, ins_date, upd_date, admin_perm) values ( $id, $album_name, $email, $cat_id, $img_id, '',  3, $date, $date, 0 );";
        if($r = mysql_query($q))
        {
            if(mysql_affected_rows($r) > 0)
            {
                return $id;
            }
            else
            {
                return null;
            }
        }
    }
    
    return null;
}

function insertImg($image, $thumbpic, $d, $id, $fileSize, $fileType, $fileName, $email )
{
    //require_once('config/project.php');
    //$image = addslashes($image);
    //$thumbpic = addslashes($thumbpic);
    
    $scr_id = $id;
    $email = $d['user_email'];
    $status = 0; 

    $alb_id = getVideoAlbumId($email, "Video");
    $ins_date = $d['ins_date'];
    $fields = array("id", "user_email", "file_type", "stat", "file_name", "file_size" ,"admin_perm", "ins_date", "upd_date", "album_id");
    $values = array($scr_id, $email, $fileType, $status, $fileName, $fileSize, "0", $ins_date, $ins_date, $alb_id);

    $f = implode(",", $fields);
    $v = implode(",", $values);

    $i = insertData("images",$fields, $values);
    
    //$q = "insert into $table ( $f ) values ( ?, ?, ?, ?, ?, ? ,?, ?, ?)";

    //$r = mysql_query($q) or die("Can't insert image data " . mysql_error());
    //$i = $con->db->insertImage($query2, $image, $thumbpic, $values);

    if($i == true)
    {
        return true;
    }
    else
    {
        return false;
    }
}

function insertData($table, $fields, $values)
{
    $n = count($fields);
    $m = count($values);
    
    if($n != $m) return false;
    
    for($i = 0; $i < $m ; $i++)
    {
        $values[$i] = mysql_real_escape_string($values[$i]);
    }
    
    $query = "insert into " . $table . "(";

    for($i = 0; $i < $n; $i++)
    {
        $query .= "`" . $fields[$i] . "`";
        if($i != ($n - 1)) $query .= ",";
    }
    
    $query .= ") values(";
    
    for($i = 0; $i < $m; $i++)
    {
        $query .= "'" . $values[$i] . "'";
        if($i != ($m - 1)) $query .= ",";
    }
    $query .= ")";
    
    //echo $query;
    
    if($r = mysql_query($query))
    {
        return true;
    }
    else
    {
        return mysql_error();
    }
}

function getPngThumbImage($modwidth = 60, $fileName)
{
    $save = "sml_" . $fileName; //This is the new file you saving
    $file = $fileName; //This is the original file

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
        
    if($ext == "png" or $ext == "PNG")
    {
        $image = imagecreatefrompng($file);
    }
    else
    {
        return null;
    }
    
    imagecopyresampled($tn, $image, 0, 0, 0, 0, $modwidth, $modheight, $width, $height) ; 


    $image = imagepng($tn, $save);


    $thumb_image = file_get_contents($save);
        
    unlink($save);
    unlink($file);
    
    return $thumb_image;
}

function insertDB($new_name, $data, $new_path)
{
    /* get the file contents from out.flv and write it to db with varification. */
    //if(!file_exists($outfile)) return false;
    
    $id = getNewId("videos");
    $user_email = $data['user_email'];
    $title = $data['title'];
    $category_id = $data['category_id'];
    $artist = $data['artist'];
    $additional = $data['additional'];
    $ins_date = $data['ins_date'];
    $upd_date = $data['upd_date'];
    $filetype = "video/flv";
    $admin_perm = $data['admin_perm'];
    //$file_path = $new_name;
    $privacy = $data['privacy'];
    //echo $file_path;
    $file_path = $new_name;

    
    $vfile_ext = getFileExt($data['filename']);
    $filename = str_replace($vfile_ext, ".flv" ,$data['filename']);

    $filesize = filesize($new_path);
    //play_count = $data['play_count'];
    
    $img_id = getNewId("images");
    //crnshot_img_id = $data['scrnshot_img_id'];
    
    $meta_tags = $data['meta_tags'];

    $filesize = filesize($new_path);
    
    //$video = addslashes($video);
    
    $qr =   "INSERT INTO `videos` (`id` ,`user_email` ,`title` ,`category_id` ,`artist` ,`additional` ,`ins_date` ,`upd_date` ,`filetype` ,`admin_perm` ,`privacy` ,`filename` ,`filesize` ,`img_id` ,`meta_tags`, `file_path`) "
            ." VALUES ('$id', '$user_email', '$title ', '$category_id ', '$artist', '$additional', '$ins_date', '$upd_date', '$filetype','$admin_perm', '$privacy', '$filename', '$filesize', '$img_id', '$meta_tags', '$file_path' )";
    
    
    //echo $qr;
    $r = mysql_query($qr) or die("Can't insert data " . mysql_error());

    //unlink($outfile);

    $view_count = 0;
    $tothits = 0;
    $neghits = 0;
    $rating = 0;
    $media_id = $id;
    $media_type = "Video";
    
    $contstat_ins = insertContStats($user_email, $view_count, $tothits, $neghits, $rating, $media_id, $media_type);
    if($contstat_ins)
    {
        $video_ins = true;
    } 
    
    if($r)
    {
        $id = $data['id'];
        $q = "delete from uploaded_videos where id = '" . $id . "'";
        $rr = mysql_query($q); /*No error generated from this line.*/

        $to      = $user_email;
        $subject = 'Your video has been published.';
        $message = "Your video with title " . $title . " has been published you can see it by browsing video section of conveylive.com, happy broadcasting!";
        //$headers = 'From: mail@conveylive.com' . "\r\n" . 'Reply-To: mail@conveylive.com' . "\r\n" . 'X-Mailer: PHP/' . phpversion();

        //$issent = simpleMail($message, $subject, array("mail@conveylive.com" => "Conveylive Team"),$to);

        return true;
    }
    else return false;
}

function insertContStats($email, $view_count, $tothits, $neghits, $rating, $media_id, $media_type)
{
    $table = "contstats";
    $id = getNewId($table);
    $admin_perm = 0;
    $ins_date = date("Y-m-d H:i:s");
    $upd_date = $ins_date;
    $fields = array("id", "user_email", "view_count", "tothits", "neghits", "rating", "media_id", "media_type","ins_date", "upd_date","admin_perm");
    $values = array("'".$id."'", "'".$email."'","'".$view_count."'", "'".$tothits."'", "'".$neghits."'", "'".$rating."'",  "'".$media_id."'","'".$media_type."'" , "'".$ins_date."'", "'".$upd_date."'", "'".$admin_perm."'");

    $f = implode(",", $fields);
    $v = implode(",", $values);

    $query = "insert into $table ( $f ) values ( $v )";

    $i = mysql_query($query) or die("Can't insert stats data " . mysql_error());
    
    if(isset($i) && mysql_affected_rows($i) > 0)
    {
        return true;
    }
    else
    {
        return false;
    }
}


function onFile($cont, $filename)
{
    if ($handle = fopen($filename, 'w'))
    {
        echo "file created successfully.";
    }
    else
    {
        echo "Can't create file with name " . $filename;
        return false;
    }

    chmod($filename, 0777);

    if(is_writable($filename))
    {
        echo "file writable";

        file_put_contents($filename, $cont);

//        if (fwrite($handle, $cont) === FALSE) return false;
        
//        fclose($handle);

        return true;
    }

    else return false;
}

function encodeFile($old_path, $log, $new_path)
{
    echo "ENCODE operation on " . $old_path;

    if( file_exists($old_path) )
    {
        //$cmd = "ffmpeg -i " . $old_path . " -y -deinterlace -f flv -vcodec flv -acodec libmp3lame -ab 128 -ar 44100 $new_path";
        $cmd = PATH ."/site/tmp/ffmpeg.exe -i " . $old_path . " -y -deinterlace -f flv -vcodec flv -acodec mp3 -ab 128 -ar 44100 $new_path";
        
        echo "Starting to encode file with command: " . $cmd . "\n";
        
        $out = exec($cmd);
        
        echo "Encode completed\n" . $out;
        echo $new_path;
        if( file_exists($new_path) )
        {
            return true;
        }
        else
        {
            fwrite($log, '\nEncode failed at '. date("F j, Y, g:i a") .'\n');
            echo 'Error generated. file do not exist';
            return false;
        }
    }
    else
    {
        fwrite($log, '\n\rFile not found in file system, at '. date("F j, Y, g:i a") .'\n');
        echo 'Error generated. old path do not exist';
        return false;
    }
}

?>
