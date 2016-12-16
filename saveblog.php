<?php
if(!isset($_POST['submit']) ){ echo "You can not access this page directly."; return; } 

require_once('config/project.php');
$con = new Project();
$pageName ='Save Blog';

$rep = "";
$err = "";
$btitle = "";
$bbody = "";
$vad = "";
$had = "";
$sideitem = array();
$islogin = true;

$con->tp->assign('title', $title);

$blog_ins = false;
$blog_upt = false;

getLatestCont($con,"Blogs");
extract($_POST);

switch($action)
{
    case 'create':
    
    $r = $con->db->executeQuery("select count(*) as tot from blogs where url = '$blogurl'");
    $c = 0;
    if($r == array() || $r == false) $err .= $con->db->err;
    else
    {
        $c = $r[0]['tot'];
    }

    if($c > 0) $valid = false;
    else $valid = true;
    
    
    if($valid)
    {
        $btitle = "Blog Saved";     
        $table = "blogs";
        $cdate = date("Y-m-d H:i:s");
        $perm = 0;
                
        $fields = array("user_email", "cname", "url", "ins_date","upd_date", "admin_perm");
        $values = array("'".$email."'", "'".$blogname."'", "'".$blogurl."'", "'".$cdate."'","'".$cdate."'", "'".$perm."'");

        $f = implode(",", $fields);
        $v = implode(",", $values);

        $query = "insert into $table ( $f ) values ( $v )";
        $i = $con->db->executeNonQuery($query);
        if($i == true)
        {
            $blog_ins = true;
        }
        $err .= $con->db->err;
        
        if(!$blog_ins)
        {
            $err .= "Could not insert blog information. Please try again with correct fields and valid characters.";
            break;
        }
        if($blog_ins)
        {
            $name = getUserName($email, $con);
            $subject = "Your blog has been created.";
            $msgBody = "Hello " . $name . ",\r\n\r\nYour Blog has been created with name $blogname.\r\n\r\n";
            $msgBody .= "You can click the following url to access to your blog anytime and post new topics.\r\n\r\nhttp://conveylive.com/b/$blogurl";
            $msgBody .= "\r\n\r\nThanks\r\n\r\nConveyLive Team\r\n\r\n";
            $msgBody .= "-------\r\n\r\nFind people from your address book on conveylive.com! Go to: http://conveylive.com/invite.php";
            $msgBody .= "\r\n\r\nThis message was intended for $email";

            $fromAr = "ConveyLive <mail@conveylive.com>";
            $toAr = $email;
            
            $isMailSent = simpleMail($con, $msgBody, $subject, $fromAr, $toAr);
        }
        
        if($isMailSent == true)
        {
            $rep = "Your blog has been created successfully.";
        }
        else
        {
            $err .= $isMailSent;
            $rep = "Your blog has been created successfully. But no mail sent to notify"; 
        }
    }
    else
    {
        $err .= "The blog url already exists. Please create your Blog again with a different url";
    }       
    break;
    
    case 'update':
    $btitle = "Blog Saved";     
    $table = "blogs";
    $cdate = date("Y-m-d H:i:s");
    $perm = 0;

    if($i == true)
    {
        $blog_ins = true;
    }
    $err .= $con->db->err;
    
    $query = "update blogs set user_email = '$email', cname = '$blogname', url = '$blogurl', upd_date = '$cdate', admin_perm = '$perm' where id = $blogid";
    $i = $con->db->updateData($query);
    if($i == true)
    {
       $blog_upt = true;
    }
    $err .= $con->db->err;
    

    if($blog_upt)
    {
        $rep = "Your Blog has been updated successfully.";
    }
    else
    {
        $err .= "Could not update blog information. Please try again with correct fields and valid characters.";
    }    
    break;
}

$retList = blogview($con, $email, $blogurl);

$bbody = $retList['bbody'];
$btitle = $retList['btitle'];
$bsubtitle = $retList['bsubtitle'];
$rep .= $retList['rep'];
$err .= $retList['err'];

$v = setLoginInfo($email, $con);

$sideitem = getSideItems($email, $con);

$blogexist = checkBlog($con, $email);
    
$con->tp->assign('btitle', $btitle);

$con->tp->assign('bbody', $bbody);

$con->tp->assign('sideitem', $sideitem);

$con->tp->assign('rep', $rep);

$con->tp->assign('err', $err);

$con->tp->assign('islogin',$islogin);

addSiteStat($pageName, $con, $email);

$con->tp->display('main.tpl');     

?>