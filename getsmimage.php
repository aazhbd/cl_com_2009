<?php

mysql_connect("localhost", "conlive_cuser", "mod#8121431");
mysql_select_db("conlive_clive");
require_once('data/dbdata.php');

//$l = mysql_connect("localhost", "root", "");
//mysql_select_db("conlivenew");

$id = $_GET['id']; 
$hasimg = false;

if($id > 0)
    $retAr = getImagePathDB($id, "sml");

if($retAr != null && is_array($retAr) && count($retAr) > 0 && $id != null)
{
    if($retAr['err'] != "")
        echo $retAr['err'];
    else
    {
        $path = $retAr['img_path'];
        if($path != null)
        {
            if(file_exists($path))
            {
                $p = file_get_contents($path);
                $f = "Content-Type: " . $retAr['file_type'];
                $hasimg = true; 
            }
        }
    }
}
if($hasimg == false){
    $p = file_get_contents("interface/icos/image.png");
    $f = "Content-Type: " . "image/png";
}
header($f);
print $p;

?>
