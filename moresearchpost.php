<?php
if(!isset($_POST['submit'])){ echo "You can not access this page directly."; return; }

require_once('config/project.php');
$con = new Project();
extract($_POST);

$pageName = 'More Search Result for '.$searchtype;

$desc = "Search ConveyLive with More Search to get your specific content easily.";
$con->tp->assign("descrip", $desc);

$keys = "Search, Advanced,  Articles, Writeups, Audio, Video, Blogs, Photos, Pictures, Clubs, Share Files, Communicate, share,network,  conveylive";
$con->tp->assign("keys", $keys);

$title = "conveylive.com :: $pageName";
$rep = "";
$err = "";
$btitle = "";
$bbody = "";
$sideitem = array();
$islogin = false;

$perPage = 10;
$pageLimit = 5;
$found = false;

$whre = array();
$query = "";



if(isset($_SESSION['login'] ) == true)
{
    $l = $_SESSION['login'];
    $islogin = true;
    $email = $l->getEmail();
}
$con->tp->assign('email', $email);
$con->tp->assign('islogin', $islogin);

$searchtype = "People";

switch($searchtype)
{
    case 'People':
    $query = "select count(*) as tot from profiles, users where email = user_email";
    $url = URL ."/moresearchpage.php?cat=people";
    
    if(trim($rel_status) != "")
    {
        $whre[] = "rel_status = '" . trim($rel_status). "'";
        $token[] = "Relation Status: ". $rel_status;
    }
    if(trim($country) != "")
    {
        $whre[] = "country = '" . trim($country). "'";
        $token[] = "Country: ".$country;
    }
    if(trim($zip_code) != "")
    {
        $whre[] = "zipcode = '" . trim($zip_code). "'";
        $token[] = "Zip Code: ".$zip_code;
    }
    if(trim($city) != "")
    {
        $whre[] = "city = '" . trim($city). "'";
        $token[] = "City: ".$city;
    }
    if(trim($user_email) != "")
    {
        $whre[] = "user_email = '" . trim($user_email). "'";
        $token[] = "Email: ".$user_email;
        
    }
    if(trim($home_town) != "")
    {
        $whre[] = "home_town = '" . trim($home_town). "'";
        $token[] = "Home Town: ".$home_town;
    }
    if(trim($religion) != "")
    {
        $whre[] = "religion = '" . trim($religion). "'";
        $token[] = "Religion: ". $religion;
    }
    if(trim($language) != "")
    {
        $whre[] = "lang = '" . trim($language). "'";
        $token[] = "Language: ".$language;
    }
    if(trim($interests) != "")
    {
        $whre[] = "interests LIKE '%" . trim($interests). "%'";
        $token[] = "Interest: ".$interests;
    }
    if(trim($favorites) != "")
    {
        $whre[] = "favorites LIKE '%" . trim($favorites). "%'";
        $token[] = "Favorites: ".$favorites;
    }
    if(trim($occupation) != "")
    {
        $whre[] = "occupation LIKE '%" . trim($occupation). "%'";
        $token[] = "Occupation: " .$occupation;
    }
    if(trim($eduinfo) != "")
    {
        $whre[] = "edu_info LIKE '%" . trim($eduinfo). "%'";
        $token[] = "Education: ". $eduinfo;
    }
    if(trim($workinfo) != "")
    {
        $whre[] = "work_info LIKE '%" . trim($workinfo). "%'";
        $token[] = "Work Info: ".$rel_status;
    }
    if(trim($weburl) != "")
    {
        $whre[] = "web_url LIKE '%" . trim($weburl). "%'";
        $token[] = "Web URL: ". $weburl;
    }
    if(trim($name) != "")
    {
        $ar = explode(" ", $name);
        $w = "";
        $i = 0;
        foreach($ar as $a)
        {
            if($i > 0)
                $w .= " or ";
                
            $w .= "( f_name LIKE '%" . trim($a). "%' or " . "l_name LIKE '%" . trim($a). "%' )";
            $i++;
        }
        $whre[] = $w;
        $token[] = "Name: ". $name;
    }
    if(trim($sex) != "")
    {
        $whre[] = "gender = '" . trim($sex). "'";
        if(trim($sex) == "m")
        {
            $token[] = "Male";
        }
        else if(trim($sex) == "m")
        {
            $token[] = "Female";
        }
    }
    if(trim($month) != "")
    {
        $whre[] = "birth_date LIKE '%" . trim($month). "%'";
        $token[] = "Birth Month: ".$month;
    }
    if(trim($year) != "")
    {
        $whre[] = "birth_date LIKE '%" . trim($year). "%'";
        $token[] = "Birth Year: ".$year;
    }    
    $tok = implode(", ", $token);
    $con->tp->assign('tok', $tok);
    $n = count($whre);
    
    if($n == 0)
    {
        $found = false;
    }
    else if($n > 0)
    {
        $_query = "select f_name , l_name,  email,  profiles.id as pid, user_imgs_id from profiles , users where email = user_email "; 
        
        for($i = 0; $i < $n; $i++)
        {
            $_query .= " and ";
            $query  .= " and ";
            $_query .= $whre[$i];
            $query .= $whre[$i];
        }
        
        $_query .= " order by f_name";
        
        unset($_SESSION['res']);
        SmartyPaginate::reset();
        $_SESSION['advquery'] = $_query;
                 
        if(!isset($_SESSION['res']))
        {
            SmartyPaginate::connect();
            if(SmartyPaginate::isConnected())
            {
                $found = init_pagination_search($query, $url, $perPage, $pageLimit, $email,  $con);
            }
        }
    }    
    break;
    
    case 'Article':

    break;
    
    case '3':
    //$table = 'users';
    break;
    
    case '4':
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

if($found)
{
    if(isset($_SESSION['res']))
    {
        $btitle = "Profile Search Results ";
        
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
        
        $bbody .= "No results were found. Please try again with correct fields and valid characters.";
        
        $btitle = "$searchtype Search Results: ";
        
        $con->tp->assign('searchtype', "");
        
        $bbody =  $con->tp->fetch("advsearch_res.tpl");
    }
}
else
{    
    $btitle = "Profile Search Results ";
    
    $bbody .= "No results were found. Please try again with correct fields and valid characters.";
    $con->tp->assign('searchtype', "");
    
    $bbody .=  $con->tp->fetch("advsearch_res.tpl");
}

$title = "conveylive.com:: Search Result for Profiles";
$con->tp->assign('title', $title);

$con->tp->assign('bbody', $bbody);
$con->tp->assign('btitle', $btitle);
$con->tp->assign('rep', $rep);
$con->tp->assign('err', $err);

$blogexist = checkBlog($con, $email);

if($islogin == true)
{
    $v = setLoginInfo($email, $con);
    $sideitem = getSideItems($email, $con);
}

addSiteStat($pageName, $con, $email);

$con->tp->assign('sideitem', $sideitem);
$con->tp->assign('islogin',$islogin);
$con->tp->display('main.tpl');
?>
