<?php
require('config/project.php');
$con = new Project();

extract($_GET);

$rep = "";
$err = "";
$btitle = "";
$bbody = "";
$vad = "";
$had = "";
$sideitem = array();
$islogin = false;
$email = "";

$desc = "Search conveylive.com with More Search to get your specific content easily.";
$con->tp->assign("descrip", $desc);

$keys = "Search, Advanced, Articles, Writeups, Audio, Video, Blogs, Photos, Pictures, Clubs, Share Files, Communicate, share,network,  conveylive";
$con->tp->assign("keys", $keys);

if(isset($_SESSION['login'] ) == true)
{
    $l = $_SESSION['login'];
    $islogin = true;
    $email = $l->getEmail();
}

switch($cat)
{
    case 'people':
    
    if(isset($_SESSION['advquery']))
    {
        $_query = $_SESSION['advquery'];
    }
    
    $url = URL ."/moresearchpage.php?cat=people";
    $searchtype = "People";
    break;
    
    case 'article':
    break;
    
    case 'audio':
    //$table = 'users';
    break;
    
    case 'video':
    //$table = 'users';
    break;
    
    default:
}

//$data['countryList'] = getCountryList();
$data['countryList'] = getCountryListDb($con);
//$data['relStatusList'] = getRelStatusList();
$data['relStatusList'] = getRelStatusListDb($con);

$data['religionList'] = getReligionListDb($con);

$data['cityList'] = getCityListDb($con);

$data['htownList'] = getHTownListDb($con);

$data['languageList'] = getLanguageListDb($con);

$monthList = getTxtMonths();
$con->tp->assign('monthList', $monthList);

$con->tp->assign('searchtype',$searchtype);
$data['occupationList'] = getOccupationListDb($con);

$con->tp->assign('data',$data);

$btitle = "$searchtype Search Results: "; 
$pageName = 'More Search Result for '.$searchtype;
$title = "ConveyLive :: $pageName";

if(isset($_SESSION['res']))
{    
    SmartyPaginate::setCurrentItem($start);

    $btitle = "$searchtype Search Results: ";
    
    $currIndex = SmartyPaginate::getCurrentIndex();
    $limit = SmartyPaginate::getLimit();
    $l = sprintf(" LIMIT %d, %d", $currIndex, $limit);
    $query = $_query.$l;
    
    $res = paginate_search($query, $con);
    if(is_string($res)) $err .= $con->db-> err;
    else if(is_array($res))
    {
        $con->tp->assign('res_list', $res);
    }
    
    $con->tp->assign('p', SmartyPaginate::getCurrentIndex());
    $con->tp->assign('x', 1); 

    $con->tp->assign('searchtype', $searchtype);
    SmartyPaginate::assign($con->tp);
    $bbody .=  $con->tp->fetch("advsearch_res.tpl");
}
else
{
    $err .= "Session is not set. No results found";
    
    $btitle = "$searchtype Search Results: ";
    
    $con->tp->assign('searchtype', "");
    
    $bbody =  $con->tp->fetch("advsearch_res.tpl");
}
    
    
$con->tp->assign('bbody', $bbody);
$con->tp->assign('btitle', $btitle);
$con->tp->assign('rep', $rep);
$con->tp->assign('err', $err);

if($islogin == true)
{
    $v = setLoginInfo($email, $con);
    $sideitem = getSideItems($email, $con);
}

addSiteStat($pageName, $con, $email);
$con->tp->assign('title', $title);
$con->tp->assign('sideitem', $sideitem);    
$con->tp->assign('vad', $vad);
$con->tp->assign('had', $had);
$con->tp->assign('islogin',$islogin);
$con->tp->display('main.tpl');


?>
