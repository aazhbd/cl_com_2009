<?php
require('config/project.php');

mysql_connect("localhost", "conlive_cuser", "mod#8121431");
mysql_select_db("conlive_clive");

//$l = mysql_connect("localhost", "root", "");
//mysql_select_db("conlivenew");

$id = $_GET['id'];

$qr = "select audios.id as id, filename, filetype, file_path, view_count  from audios, contstats where audios.id = $id and contstats.media_id = $id and contstats.media_type = 'Audio'";

$r = mysql_query($qr);

if($audio = mysql_fetch_assoc($r))
{
    $c = (int)$audio['view_count'] + 1;
            
    $query = "update contstats set view_count = ".$c." where media_id = ".$audio['id']." and media_type = 'Audio'";
    $u = mysql_query($query);
    
    $filename = $audio['filename'];
    
    $file_path = $audio['file_path'];
    
    $path = PATH . "/directories/audios/". trim($file_path);
    $file = file_get_contents($path);
    
    $size = filesize($path);
    if($size > 0)
    {
        header("Content-Type: audio/mp3");
        header("Content-Length: " . $size);
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
?>
