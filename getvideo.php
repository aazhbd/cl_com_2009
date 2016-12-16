<?php
/*
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); 
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); 
header("Cache-Control: no-store, no-cache, must-revalidate"); 
header("Cache-Control: post-check=0, pre-check=0", false); 
header("Pragma: no-cache");
*/

//define('PATH', str_replace(DIRECTORY_SEPARATOR, '/', realpath(dirname(__FILE__).'/..')));
require('config/project.php');

mysql_connect("localhost", "conlive_cuser", "mod#8121431");
mysql_select_db("conlive_clive");

//$l = mysql_connect("localhost", "root", "");
//mysql_select_db("conlivenew");

$id = $_GET['id'];

$id = 2;

$qr = "select videos.id as id, filename, file_path, view_count from videos, contstats where videos.id = $id and contstats.media_id = $id and contstats.media_type = 'Video'";

$r = mysql_query($qr);


if($video = mysql_fetch_assoc($r))
{
    $c = (int)$video['view_count'] + 1;
            
    $query = "update contstats set view_count = ".$c." where media_id = $id and media_type = 'Video'";
    $u = mysql_query($query);
    
    $file_path = ($video['file_path']);
    
    $path = PATH . "/directories/videos/". $file_path;
    
    $file = file_get_contents($path);
/*
    $handle = fopen($file_path, "r");
    $file = fread($handle, filesize($file_path));
    fclose($handle);
*/
    $size = filesize($path);

    if($size > 0)
    {
        header("Content-transfer-encoding: binary");
        header("Content-Type: video/x-flv");
        header("Content-Disposition: attachment; filename=\"$file_path\"");
        header("Content-Length: " . $size);
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Cache-Control: private");
    }
    else
    {
        header("HTTP/1.0 404 Not Found");
    }

    print($file);
}
else
{
    header("HTTP/1.0 404 Not Found");
}
/*
define('PATH', str_replace(DIRECTORY_SEPARATOR, '/', realpath(dirname(__FILE__).'/..')));
header('Content-Type: video/x-flv');
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); 
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); 
header("Cache-Control: no-store, no-cache, must-revalidate"); 
header("Cache-Control: post-check=0, pre-check=0", false); 
header("Pragma: no-cache");
readfile("C:\\wamp\\www\\Conveylive\\conveylive_2_1_10\\site\\directories\\videos\\site\\directories\\videos\\2_HAPPY.flv.flv"); 
*/
?>
