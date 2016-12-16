<?php
require('config/project.php');
$con = new Project();

extract($_GET);
$pageName = $box;

$rep = "";
$err = "";
$btitle = "";
$bbody = "";
$vad = "";
$had = "";
$sideitem = array();
$islogin = false;
$email = "";

$keys = "friends, communicate, share,network,  conveylive";
$con->tp->assign("keys", $keys);

$desc = "ConveyLive - Friends. Stay in touch with your friends through conveylive and share your creativity";
$con->tp->assign("descrip", $desc);

if(isset($_SESSION['login'] ) == true)
{
    $l = $_SESSION['login'];
    $islogin = true;
    $email = $l->getEmail();
    

    $myFriends = array();
    if($email != "")
    {
        $q = "select f_name, l_name, email as user_email, profiles.id as pid, user_imgs_id, friends.id as fid from users, profiles, friends where (req_to='$email' or req_from='$email') and email != '$email'and  req_pending = 0 and blocked = 0 and friends.admin_perm = 1 and (req_to = email || req_from = email)  and profiles.user_email = email";
        
        $r = $con->db->selectData($q);
        
        if($r == false || $r == array() || count($r) == 0)
        {
            $err .= $con->db->err;
        }
        else
        {
            foreach($r as $a)
            {
                $myFriends[] = $a;
            }
        }
    }
    
    if(isset($_SESSION['frnd']))
    {    
        SmartyPaginate::setCurrentItem($start);
        
        $uemail = getEmail($id, $con);
        
        $err = paginate_friend($uemail, $con, $myFriends); 
        SmartyPaginate::assign($con->tp);
        $bbody = $con->tp->fetch('friendlist_view.tpl');
        
        $uemail = getEmail($id, $con);
        $uname = getUserName($uemail, $con);

        if($uemail == $email)
        {
            $btitle = "Your Friends";
        }
        else
        {
            $btitle = "Friends of ". $uname;
        }
        
        
        $title = "ConveyLive :: Friends";
        $con->tp->assign('title', $title);
        
        $con->tp->assign('bbody', $bbody);
        $con->tp->assign('btitle', $btitle);
        $con->tp->assign('rep', $rep);
        $con->tp->assign('err', $err);
        
        addSiteStat($pageName, $con, $email);
        
        if($islogin == true)
        {
            $v = setLoginInfo($email, $con);
            $sideitem = getSideItems($email, $con);
            $blogexist = checkBlog($con, $email);
        }
        $con->tp->assign('sideitem', $sideitem);    
        $con->tp->assign('vad', $vad);
        $con->tp->assign('had', $had);
        $con->tp->assign('islogin',$islogin);
        $con->tp->display('main.tpl');
    }
}

?>
