<?php
require('config/project.php');
$con = new Project();

if($_POST['ins'])
{
    $out = "";
    $id = $_POST['aid'];
    $cmt = $_POST['cmt'];
    $mtype = $_POST['mt'];
    $uemail = $_POST['ue'];
    $uem = $_POST['uem'];
    $nn = "";//$_POST['nn'];
    $comIns = false;;
    /*
    if(($uemail == "" || $uemail == null) && $uem != "" || $uem != null)
    {
        $uemail = $uem;
    }*/

    
    $l = mysql_connect("localhost", "conlive_cuser", "mod#8121431");
    mysql_select_db("conlive_clive");
    
    //$l = mysql_connect("localhost", "root", "");
    //mysql_select_db("conlivenew");
    
    $date = date('Y-m-d H:i:s');
    $qr = "insert into `comments`(`user_email`, `media_id`, `mtype`, `ins_date`, `upd_date`,`comment`, `admin_perm`, `privacy`, `nick_name`) values('$uemail', '$id', '$mtype', '$date','$date', '".addslashes($cmt)."', '0', '0', '$nn')";
    
    $r = mysql_query($qr);
    if(isset($r) ) echo mysql_error();
    
    if($r == false) echo 'data not inserted';
    else
    {
        $comIns = true;
        $coms = array();
        $qr1 = "select comments.id as id, comments.ins_date as ins_date, f_name, l_name, comment, privacy, user_email, email from comments, users where media_id = $id and mtype = '$mtype' and comments.admin_perm = 0 and email = user_email order by comments.ins_date asc";
        
        $r = mysql_query($qr1) or die("can't execute" . mysql_errno());
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
                
                $t = mysql_query($qr2) or die("can't execute 2" . mysql_errno());
                if($t != false || $t != array())
                {
                    while($u = mysql_fetch_assoc($t))
                    {
                        $a = $u;
                    }
                    $coms[$i]['user_imgs_id'] = $a['user_imgs_id'];
                    $coms[$i]['pid'] = $a['pid'];
                }
                
                $coms[$i]['name'] = $coms[$i]['f_name'] . " " . $coms[$i]['l_name'];
                $i++;
            }
        }
        
        if($mtype == "Article") { $tbl = 'articles'; $link = "http://conveylive.com/article/view/$id"; }
        if($mtype == "Audio") {  $tbl = 'audios'; $link = "http://conveylive.com/audio/listen/$id"; }
        if($mtype == "Video")  { $tbl = 'videos'; $link = "http://conveylive.com/video/watch/$id"; }
        if($mtype == "Picture")  {$tbl = 'user_imgs'; $link = "http://conveylive.com/picture/pictureview/$id"; }
        if($mtype == "Blog Post") 
        {
            $postid = $id;
            $blog_url = getBlogURLbyId($con, $postid);
            $tbl = 'bposts'; $link = "http://conveylive.com/b/$blog_url/$id"; 
        }
        if($mtype == "Profile") { $tbl = 'bposts'; $link = "http://conveylive.com/profile/view/$id"; }
        
        $q = "select * from $tbl, users where $tbl.id = $id and user_email = email";
        
        $r = $con->db->selectData("select * from $tbl, users where $tbl.id = $id and user_email = email");
        if($r == false || $r == array() || count($r) == 0) $err .= $con->db->err;
        else
        {
            $uemail_n = $r[0]['email'];
            $uname_n = $r[0]['f_name'] ." ". $r[0]['l_name'];
        }
        foreach($coms as $com)
        {
            $dt = new DateTime($com['ins_date']);
            $d = $dt->format("F j, Y");
            $t = $dt->format("g:i a, l");
            
            $out .= "<div class='combox'>";
            if($com['pid'] == null )
            {
                $out .= "<div style='float:left; width:50px;'>";
                    $out .= "<img src='".URL."/getsmimage.php?id=0' alt='".$com['f_name'].", ".$com['l_name'].", ConveyLive.com, Photos, Picture, Album' height='40' />";
                $out .= "</div>";
                $out .= "<div style='float:left; width:85%; padding:5px; text-align: justify;'>";
                   $out .= "<p><strong>".$com['f_name'] ." ".$com['l_name']."</strong> :".$com['comment'] . "</p>"; 
                   $out .= "<br />";
                   $out .= "<span class='subinfo'>";
                        $out .= "$d at $t &nbsp;";
/*                        if($com['email'] == $uemail || $uemail_n == $uemail)
                        {
                            $out .= "<a href='".URL."/cmtprocess.php?id=".$com['id']."' id='removecmt'>remove</a>";
                        }
*/
                    $out .= "</span>";
                $out .= "</div>";
            }
            else
            {
                $out .= "<div style='float:left; width:50px;'>";
                    $out .= "<a href='".URL."/profile/view/".$com['pid']."'><img src='".URL."/getsmimage.php?id=".$com['user_imgs_id']."' alt='".$com['f_name'].", ".$com['l_name'].", ConveyLive.com, Photos, Picture, Album' height='40' /></a>";
                $out .= "</div>";
                $out .= "<div style='float:left; width:85%; padding:5px; text-align: justify;'>";
                   $out .= "<p><strong><a href='".URL."/profile/view/".$com['pid']."'>".$com['f_name'] ." ".$com['l_name']."</strong> </a> :".$com['comment'] . "</p>"; 
                   $out .= "<br />";
                   $out .= "<span class='subinfo'>";
                        $out .= "$d at $t &nbsp;";
/*
                        if($com['email'] == $uemail || $uemail_n == $uemail)
                        {
                            $out .= "<a href='".URL."/cmtprocess.php?id=".$com['id']."' id='removecmt'>remove</a>";
                        }
*/
                    $out .= "</span>";
                $out .= "</div>";
            }
            $out .= "</div>";
            $out .= "<br/>";
        }
        $emList = array();
        
        if($comIns)
        {
            $qr1 = "select distinct email from comments, users where media_id = $id and mtype = '$mtype' and comments.admin_perm = 0 and email = user_email order by comments.ins_date asc";
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
                    $emList[$i] = $s;
                    $i++;
                }
            }
            $tot = count($emList);
            $name = getUserName($uemail, $con);
            for($i = 0; $i < $tot ; $i++)
            {
                $em = $emList[$i]['email']; 
                if( ($uemail_n != $uemail) && ( $uemail == $em ) )
                {
                    $sender_name = getUserName($uemail_n, $con); 
                    $subject = "$name commented on your content.";
                    $msgBody = "Hello, " . $sender_name . "\r\n\r\n$name commented on your $mtype with id $id. \r\n\r\nTo reply to this please follow the link below: \r\n\r\n$link";
                    $msgBody .= "\r\n\r\nThanks\r\n\r\nConveyLive Team\r\n\r\n";
                    $msgBody .= "-------\r\n\r\nFind people from your address book on ConveyLive! Go to: http://conveylive.com/invite.php";
                    $msgBody .= "\r\n\r\nThis message was intended for $uemail_n";
                    
                    $fromAr = array("mail@conveylive.com" => "conveylive.com");
                    $toAr = array($uemail_n => $sender_name);
                    $isMailSent = simpleMail($con, $msgBody, $subject, $fromAr, $toAr, "text/plain", array("mail@conveylive.com" => "Conveylive Team"), 0 ); //HiGH
                    //$out .= "<br />Sent mail to $uemail_n <br />";
                }
                else if( ($uemail != $em) && ($em != $uemail_n) )
                {
                    $sender_name = getUserName($em, $con); 
                    $subject = "$name commented on the $mtype that you commented recently.";
                    $msgBody = "Hello, " . $sender_name . "\r\n\r\n$name commented on the $mtype with id $id. \r\n\r\nTo reply to this comment please follow the link below: \r\n\r\n$link";
                    $msgBody .= "\r\n\r\nThanks\r\n\r\nConveyLive Team\r\n\r\n";
                    $msgBody .= "-------\r\n\r\nFind people from your address book on ConveyLive! Go to: http://conveylive.com/invite.php";
                    $msgBody .= "\r\n\r\nThis message was intended for $em";
                    
                    $fromAr = array("mail@conveylive.com" => "conveylive.com");
                    $toAr = array( $em => $sender_name);
                    $isMailSent = simpleMail($con, $msgBody, $subject, $fromAr, $toAr, "text/plain", array("mail@conveylive.com" => "Conveylive Team"), 0 );  //HiGH 
                    //$out .= "<br />Sent mail to $em <br />"; 
                }                   
            }
        }
        echo $out;
    } 
}
else if($_POST['rem'])
{
    $islogin = false;
    $out = "";
    $id = $_POST['id'];
    $uemail = trim($_POST['em']);
    $email = "";
    
    $mid = $_POST['mid'];
    $mtype = $_POST['mt'];
    
    mysql_connect("localhost", "conlive_cuser", "mod#8121431");
    mysql_select_db("conlive_clive");
    
    //$l = mysql_connect("localhost", "root", "");
    //mysql_select_db("conlivenew");
    
    if(isset($_SESSION['login'] ) == true)
    {
        $l = $_SESSION['login'];
        $islogin = true;
        $uemail = $l->getEmail();
    }

    $qr = "update comments set admin_perm = 1 where user_email = '$uemail' and id = $id";
    $r = mysql_query($qr) or die("can't execute " . mysql_error());
    if($r == false)
    {
        $out .= "<p>Could not delete comment.".mysql_error()."</p>";
    }
    else
    {
        $out .= "<i style='color:red'>Comment deleted</i><br />";
    }

    $coms = array();
    $qr1 = "select comments.id as id, comments.ins_date as ins_date, f_name, l_name, comment, privacy, user_email, email from comments, users where media_id = $mid and mtype = '$mtype' and comments.admin_perm = 0 and email = user_email order by ins_date asc";
    $r = mysql_query($qr1) or die("can't execute " . mysql_error());
    if($r == false || $r == array())
    {
        $err .= $con->db->err;
    }
    else
    {
        $i = 0;
        $data = array();
        while($s = mysql_fetch_assoc($r))
        {
            $coms[$i] = $s;
            $email = $coms[$i]['email'];
            $qr2 = "select user_imgs_id, id as pid from profiles where user_email = '$email'";
            $t = mysql_query($qr2) or die("can't execute " . mysql_error());
            if($t != false && $t != array() && count($t) > 0)
            {
                while($d = mysql_fetch_assoc($t))
                {
                    $data = $d;
                }
                $coms[$i]['user_imgs_id'] = $data['user_imgs_id'];
                $coms[$i]['pid'] = $data['pid'];
            }
            $coms[$i]['name'] = $coms[$i]['f_name'] . " " . $coms[$i]['l_name'];
            $i++;
        }
        
    }
    foreach($coms as $com)
    {
        $dt = new DateTime($com['cdate']);
        $d = $dt->format("F j, Y");
        $t = $dt->format("g:i a, l");
        
        $out .= "<div class='combox'>";
        if($com['pid'] == null )
        {
            $out .= "<div style='float:left; width:50px;'>";
                $out .= "<img src='".URL."/getsmimage.php?id=0' alt='".$com['f_name'].", ".$com['l_name'].", ConveyLive.com, Photos, Picture, Album' height='40' />";
            $out .= "</div>";
            $out .= "<div style='float:left;width:400px; padding:5px;'>";
               $out .= "<strong>".$com['f_name'] ." ".$com['f_name']."</strong> :".$com['comment']; 
               $out .= "<br />";
               $out .= "<span style='color:#aaa' class='subinfo'>";
                    $out .= "$d at $t &nbsp;";
/*
                    if($com['email'] == $uemail || $uemail_n == $uemail)
                    {
                        $out .= "<a href='".URL."/cmtprocess.php?id=".$com['id']."' id='removecmt'>remove</a>";
                    }
*/
                $out .= "</span>";
            $out .= "</div>";
        }
        else
        {
            $out .= "<div style='float:left; width:50px;'>";
                $out .= "<a href='".URL."/profile/view/".$com['pid']."'><img src='".URL."/getsmimage.php?id=".$com['user_imgs_id']."' alt='".$com['f_name'].", ".$com['l_name'].", ConveyLive.com, Photos, Picture, Album' height='40' /></a>";
            $out .= "</div>";
            $out .= "<div style='float:left;width:400px; padding:5px;'>";
               $out .= "<strong><a href='".URL."/profile/view/".$com['pid']."'>".$com['f_name'] ." ".$com['f_name']."</strong> </a> :".$com['comment']; 
               $out .= "<br />";
               $out .= "<span style='color:#aaa' class='subinfo'>";
                    $out .= "$d at $t &nbsp;";
/*
                    if($com['email'] == $uemail || $uemail_n == $uemail)
                    {
                        $out .= "<a href='".URL."/cmtprocess.php?id=".$com['id']."' id='removecmt'>remove</a>";
                    }
*/
                $out .= "</span>";
            $out .= "</div>";
        }
        $out .= "</div>";
        $out .= "<br/>";
    }
    echo $out;
}
else{
    echo 'You are not allowed to access this page directly';
}
?>
