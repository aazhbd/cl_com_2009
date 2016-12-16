<?php
require('config/project.php');
//$con = new Project();
if($_POST['ins'])
{
    $out = "";
    $id = $_POST['mid'];
    $cmt = $_POST['cmt'];
    $mtype = $_POST['mt'];
    $uemail = $_POST['ue'];
    $cid = $_POST['cid'];
    $comIns = false;
    
    mysql_connect("localhost", "conlive_cuser", "mod#8121431");
    mysql_select_db("conlive_clive");
    
    //$l = mysql_connect("localhost", "root", "");
    //mysql_select_db("conlivenew");
    
    $d = date('Y-m-d H:i:s');
    $qr = "insert into `comments`(`user_email`, `media_id`, `mtype`, `ins_date`, `upd_date`, `comment`, `admin_perm`, `privacy`) values('$uemail', '$id', '$mtype', '$d','$d', '".addslashes($cmt)."', '0', '0')";
    $r = mysql_query($qr) or die("can't execute " . mysql_errno());
    
    if($r == false) echo 'data not inserted';
    else
    {
        $comIns = true;
        $coms = array();
        $qr1 = "select * from comments, users where media_id = $id and mtype = '$mtype' and admin_perm = 0 and email = user_email order by ins_date asc";
        $r = mysql_query($qr1) or die("can't execute " . mysql_errno());
        if($r == false || $r == array())
        {
            $err .= $con->db->err;
        }
        else
        {
            $i = 0;
            while($s = mysql_fetch_assoc($r))
            {
                $coms[$i] = $s;
                $email = $coms[$i]['email'];
                $qr2 = "select user_imgs_id, id as pid from profiles where user_email = '$email'";
                $t = mysql_query($qr2) or die("can't execute " . mysql_errno());
                if($t != false && $t != array())
                {
                    $coms[$i]['img_id'] = $t[0]['user_imgs_id'];
                    $coms[$i]['pid'] = $t[0]['pid'];
                }
                $coms[$i]['name'] = $coms[$i]['f_name'] . " " . $coms[$i]['l_name'];
                $i++;
            }
        }
        foreach($coms as $com)
        {
            $dt = new DateTime($com['ins_date']);
            $d = $dt->format("l, F j, Y, g:i a");
            
            $out .= "<div class='artcont'>";
            if($com['pid'] == 0 || $com['pid'] == null || $com['pid'] == "")
            {
                $out .= "<div class='entry' style='width:15%;'><img src='".URL."/interface/icos/user.gif' width='60' alt=".$com['f_name'].",".$com['l_name']." /></div>";
                $out .= "<div class='entry' style='width:80%;'>".$com['f_name']." ".$com['l_name']." wrote on ".$d."</div>";
            }
            else
            {
                $out .= "<div class='entry' style='width:15%;'><img src='".URL."/getsmimage.php?id=".$com['user_imgs_id']." width='60' alt=".$com['f_name'].",".$com['l_name']." /></div>";
                $out .= "<div class='entry' style='width:80%;'><a href='".URL."/profile/view/".$com['pid'].">".$com['f_name']." ".$com['l_name']."</a> wrote on ".$com['ins_date']."</div>";
            }
            $out .= "<div class='entry' style='width:60%;'>".$com['comment']."<br/></div>";
            $out .= "<div class='entry' style='width:20%;'>";
            if ($com['user_email']== $email || $is_admin == true )
            {
                $out .= "<a href='".URL."/clubs/deletecom/".$com['id']."' class='postdel'>Delete Post</a>";
            }
            else
            {
                $out .= "&nbsp;|&nbsp;<a href='".URL."/clubs/reportcom/".$com['id']."'>Report this post</a>";
            }
            $out .= "</div></div>";
        }
        
        if($comIns)
        {
            $q = "select * from cposts, users where id = $id and user_email = email";
            
            $r = $con->db->selectData($q);
            if($r == false || $r == array() || count($r) == 0) $err .= $con->db->err;
            else
            {
                $uemail_n = $r[0]['email'];
                $uname_n = $r[0]['f_name'] ." ". $r[0]['l_name'];
            }
            $name = getUserName($uemail, $con);
            $sender_name = getUserName($uemail_n, $con); 
            $subject = "$name commented on your content.";
            $msgBody = "Hello, " . $sender_name . "\r\n$name posted a reply to your $mtype with id $id. \r\n\r\nTo reply to this post please follow the link below: \r\n\r\nhttp://conveylive.com/clubs/viewpost/$id";
            $msgBody .= "\r\n\r\nThanks\r\n\r\nConveyLive Team\r\n\r\n";
            $msgBody .= "-------\r\n\r\nFind people from your address book on ConveyLive! Go to: http://conveylive.com/invite.php";
            $msgBody .= "\r\n\r\nThis message was intended for $uemail_n";

            $fromAr = array("mail@conveylive.com" => "conveylive.com");
            $toAr = $uemail_n;
            $isMailSent = simpleMail($con, $msgBody, $subject, $fromAr, $toAr, "text/plain", array("mail@conveylive.com" => "Conveylive Team") , 3);
        }
        echo $out;
    } 
}
else{
    echo 'you are not allowed to access this page directly';
}
?>
