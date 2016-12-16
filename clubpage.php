<?php
require('config/project.php');
$con = new Project();

extract($_GET);

$pageName = "Clubs";
$title = "ConveyLive :: $pageName";

$rep = "";
$err = "";
$btitle = "";
$bbody = "";
$vad = "";
$had = "";
$sideitem = array();
$islogin = false;
$email = "";

getLatestCont($con,"Clubs");

$mediaLoaded = false;

if(isset($_SESSION['login'] ) == true)
{
    $l = $_SESSION['login'];
    $islogin = true;
    $email = $l->getEmail();
}
$con->tp->assign('islogin',$islogin);

function paginate_cont($id, $sess_name, $qsess_id, $pgtpl_id, $ctyp, $tplvar, $con, $start = '', $static_name = 'default')
{
    if(isset($_SESSION[$sess_name]))
    {    
        $_query = $_SESSION[$qsess_id];
        if($static_name == 'default' && $start != '')
        {
            SmartyPaginate::setCurrentItem($start,$id);
        }
        
        $currIndex = SmartyPaginate::getCurrentIndex($id);
        $limit = SmartyPaginate::getLimit($id);
        $l = sprintf(" LIMIT %d, %d", $currIndex, $limit);
        $query = $_query.$l;
        
        $res = paginate_search($query, $con);
        
        if(is_array($res) && $res!= false && $res != array() && count($res) > 0)
        {
            if($ctyp == 'Member')
            {
                for($i = 0; $i < count($res); $i++)
                {
                    $cdate = $res[$i]['ins_date'];
                    $date = new DateTime($cdate);
                    $res[$i]['cdate'] = $date->format("F j, Y, g:i a");
                    
                    $query = "select profiles.id as pid, user_imgs_id from profiles where user_email = '".$res[$i]['user_email']."'";
                    
                    $r = $con->db->selectData($query);
                    
                    if($r == array() || count($r) == 0 || $r == false) $err .= $con->db->err;
                    else
                    {
                        $res[$i]['pid'] = $r[0]['pid'];
                        $res[$i]['user_imgs_id'] = $r[0]['user_imgs_id'];
                    }
                }
            }
            if($ctyp == 'File')
            {
                for($i = 0; $i < count($res); $i++)
                {
                    $cdate = $res[$i]['ins_date'];
                    $date = new DateTime($cdate);
                    $res[$i]['ins_date'] = $date->format("F j, Y, g:i a");
                    
                    $query = "select profiles.id as pid, user_imgs_id from profiles where user_email = '".$res[$i]['user_email']."'";
                    
                    $r = $con->db->selectData($query);
                    
                    if($r == array() || count($r) == 0 || $r == false) $err .= $con->db->err;
                    else
                    {
                        $res[$i]['pid'] = $r[0]['pid'];
                        $res[$i]['user_imgs_id'] = $r[0]['user_imgs_id'];
                    }
                }
            }
            $con->tp->assign($tplvar, $res);
            
            SmartyPaginate::assign($con->tp, $pgtpl_id, $id);
        }
        else
        {
            $err .= $con->db->err;
        }
    }
    return $err;
}


$isValid = true;

$is_member = false;
$is_admin = false;
$is_owner = false;

$btitle = "Club - ";
$bsubtitle = "";
$r = $con->db->selectData("select * from clubs,users where clubs.admin_perm = 0 and id = $cid and status = 0 and email = user_email");
if($r == false || $r == array()) $err .= $con->db->err;
else
{
    $i = 0;
    foreach($r as $a)
    {
        $club = $a;
    }
    $btitle .= $club['cname'];
    
    if($club['privacy'] == 0)   $clubType = "open";
    if($club['privacy'] == 1)   $clubType = "closed";
    if($club['privacy'] == 2)   $clubType = "secret";
    $club['clubType'] = $clubType;
    
    $mem = array();
    
    $t = $con->db->selectData("select user_email, privilege, f_name, l_name, cmembers.id as mem_id from cmembers, users where club_id =".$club['id']." and cmembers.admin_perm = 0 and status = 0 and email = cmembers.user_email");
    if($t == false || $t == array() || count($t) == 0) $err .= $con->db->err;
    else
    {
        $i = 0;
        $j = 0;
        foreach($t as $ts)
        {
            $mem[$i] = $ts;
            $club['memberList'][$i] = $mem[$i];
            $p = $con->db->selectData("select profiles.id as pid, user_imgs_id from profiles where user_email = '".$mem['user_email']."' and active = 0 and admin_perm = 0");
            if($p == false || $p == array() || count($p) == 0) $err .= $con->db->err;
            else
            {
                $mem[$i]['pid'] = $p[0]['pid'];
                $club['memberList'][$i]['pid'] = $p[0]['pid'];
                
                $mem[$i]['user_imgs_id'] = $p[0]['user_imgs_id'];
                $club['memberList'][$i]['user_imgs_id'] = $p[0]['user_imgs_id'];
            }
            if($mem[$i]['privilege'] == 1)
            {
                $club['adminList'][$j] = $mem[$i];
                $j++;
            }
            if($mem[$i]['privilege'] == 2)
            {
                $club['adminList'][$j] = $mem[$i];
                $club['creator'] = $mem[$i];
                $j++;
            }
            $i++;
        }
        $mem_count = $i;
    }
    $club['mem_count'] = $mem_count;
    
    $is_member = isMember($con, $cid, $email);
    $is_admin  = isAdmin($con, $cid, $email);
    $is_owner = isCreator($con, $cid, $email);
    
    if($ctyp == "Member")
    {
        $id = 'member';
        $sess_name = 'members';
        $qsess_id = 'mem';
        $pgtpl_id ='mem_paginate';
        $tplvar = 'members';
        
        paginate_cont('picture', 'pictures', 'pic', 'pic_paginate', 'Picture', 'pictures', $con, '', 'picture');
        paginate_cont('topic', 'topics', 'top', 'top_paginate', 'Post', 'topics', $con, '','topic');
        paginate_cont('files', 'files', 'fil', 'file_paginate', 'File', 'files', $con, '', 'file');
    }
    else if($ctyp == "Picture")
    {
        $id = 'picture';
        $sess_name = 'pictures';
        $qsess_id = 'pic';
        $pgtpl_id ='pic_paginate';
        $tplvar = 'pictures';
        
        paginate_cont('member', 'members', 'mem', 'mem_paginate', 'Member', 'members', $con, '', 'member');
        paginate_cont('topic', 'topics', 'top', 'top_paginate', 'Post', 'topics', $con, '','topic');
        paginate_cont('files', 'files', 'fil', 'file_paginate', 'File', 'files', $con, '', 'file');
    }
    else if($ctyp == "Post")
    {
        $id = 'topic';
        $sess_name = 'topics';
        $qsess_id = 'top';
        $pgtpl_id ='top_paginate';
        $tplvar = 'topics';
        
        paginate_cont('member', 'members', 'mem', 'mem_paginate', 'Member', 'members', $con, '', 'member');
        paginate_cont('picture', 'pictures', 'pic', 'pic_paginate', 'Picture', 'pictures', $con, '', 'picture');
        paginate_cont('files', 'files', 'fil', 'file_paginate', 'File', 'files', $con, '', 'file');
    }
    else if($ctyp == "File")
    {
        $id = 'files';
        $sess_name = 'files';
        $qsess_id = 'fil';
        $pgtpl_id ='file_paginate';
        $tplvar = 'files';
        
        paginate_cont('member', 'members', 'mem', 'mem_paginate', 'Member', 'members', $con, '', 'member');
        paginate_cont('picture', 'pictures', 'pic', 'pic_paginate', 'Picture', 'pictures', $con, '', 'picture');
        paginate_cont('topic', 'topics', 'top', 'top_paginate', 'Post', 'topics', $con, '','topic');
    }
    paginate_cont($id, $sess_name, $qsess_id, $pgtpl_id, $ctyp, $tplvar, $con, $start);
    
}

$relArt = array();
$r = $con->db->selectData("select * from clubs where category_id  = '".$club['category_id']."' and admin_perm = 0 and id != ".$club['id']." order by ins_date desc LIMIT 0, 5");
if($r == false || $r === array() || count($r) == 0) $err .= $con->db->err;
else
{
    foreach($r as $a)
    {
        $relArt[] = $a;
    }
}

$con->tp->assign('relArt', $relArt);

$latArt = array();
$r = $con->db->selectData("select * from clubs where admin_perm = 0 and privacy != 2 order by ins_date desc LIMIT 0, 5");
if($r == false || $r === array() || count($r) == 0) $err .= $con->db->err;
else
{
    foreach($r as $a)
    {
        $latArt[] = $a;
    }
}
$con->tp->assign('latArt', $latArt);



$desc = "$btitle. Browse all the Clubs of conveylive published by users to share,comment and discuss. Create Your own Clubs to discuss and share your digital possesions like, Photos, Files and text posts.";
$con->tp->assign("descrip", $desc);

$keys = "$btitle, Clubs, Posts, File, Share, Community, Network, ConveyLive";
$con->tp->assign("keys", $keys);

$con->tp->assign('email', $email);
$con->tp->assign('topicList', $topicList);
$con->tp->assign('is_admin', $is_admin);
$con->tp->assign('is_owner', $is_owner);
$con->tp->assign('is_member', $is_member);
$con->tp->assign('clubType', $clubType);
$con->tp->assign('club', $club);
$bbody = $con->tp->fetch('club_view.tpl');
    
$con->tp->assign('bsubtitle', $bsubtitle);
$con->tp->assign('bbody', $bbody);
$con->tp->assign('btitle', $btitle);
$con->tp->assign('rep', $rep);
$con->tp->assign('err', $err);

if($islogin == true)
{
    $v = setLoginInfo($email, $con);
    $sideitem = getSideItems($email, $con);
    $blogexist = checkBlog($con, $email);
}

addSiteStat($pageName, $con, $email);
$con->tp->assign('sideitem', $sideitem);    
$con->tp->assign('vad', $vad);
$con->tp->assign('had', $had);
$con->tp->assign('title', $title);
$con->tp->display('main.tpl');
?>