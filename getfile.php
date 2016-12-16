<?php
require_once('config/project.php');
$con = new Project();

mysql_connect("localhost", "conlive_cuser", "mod#8121431");
mysql_select_db("conlive_clive");

//$l = mysql_connect("localhost", "root", "");
//mysql_select_db("conlivenew");

if(isset($_SESSION['login'] ) == true)
{
    $l = $_SESSION['login'];
    $islogin = true;
    $email = $l->getEmail();
}

if(isset($_GET['id']) == true && $_GET['id'] != '' && $_GET['cid'] == true && $_GET['cid'] != '' && $islogin == true && $email != '')
{
    $id = $_GET['id'];
    $cid = $_GET['cid'];
    $is_member = false;
    
    //Check membership in club
    $t = $con->db->selectData("select user_email from cmembers, users where club_id = $cid and cmembers.admin_perm = 0 and status = 0 and ustatus = 1 and email = cmembers.user_email");
    if($t == false || $t == array() || count($t) == 0) $err .= $con->db->err;
    else
    {
        foreach($t as $a)
        {
            if($a['user_email'] == $email)
            {
                $is_member = true;
                break;
            }
        }
    }
    
    if($is_member)
    {
        $q = "select file_path, file_name, cname from `user_files`, `clubs` where user_files.id = $id and club_id = $cid and clubs.id = $cid and clubs.id = user_files.club_id and clubs.admin_perm = 0 and user_files.admin_perm = 0";
        $updated = false;
        if($r = mysql_query($q))
        {
            while($l = mysql_fetch_assoc($r))
            {
                $file = $l;
            }
            $club_name = makeFileNameSafe($file['cname']);
            $path = PATH . "/directories/clubs/" . $cid. "_" .$club_name . "/". $file['file_path'];
            $filsize = filesize($path);
            $filename = $file['file_name'];
        }
        
        header('Content-Description: File Transfer'); 
        header("Content-type: application/force-download");
        header('Content-Disposition: inline; filename="' . $file['file_name'] . '"');
        header("Content-Transfer-Encoding: Binary");
        header("Content-length: ".$filsize);
        header('Content-Type: application/octet-stream');            
        header("Content-Disposition: attachment; filename=" . $file['file_name'] . "");
        header("Cache-control: private");
        readfile($path);
    }
}  
?>
