<?php

require('config/project.php');
$con = new Project();

$isinvalid = false;

$pageName = "";

$rep = "";
$err = "";

$btitle = "";
$bbody = "";

$islogin = false;
$email = "";

$parExists = false;

$totParams = 0;

$params = getParams();

if(is_array($params) && $params != null)
{
    $parExists = true;
}
else
{
    $parExists = false;
}

if($parExists == true)
{
    $totParams = count($params);
}

if($totParams > 0 && trim($params[0]) != "")
{
    $pageName = trim($params[0]);
}
else
{
    $pageName = "home";
    $title = "Welcome to conveylive.com :: conveylive.com";
}

if(isset($_SESSION['login'] ) == true)
{
    $l = $_SESSION['login'];
    $islogin = true;
    $email = $l->getEmail();
}
$con->tp->assign('islogin',$islogin);

hasRemUser($con);

$blogexist = checkBlog($con, $email);

switch ($pageName)
{    
    case 'a':
        $title = $params[1];
        $art_id = $params[1];
        
        $retList =  view_article($con, $email, $art_id);
        
        $bbody = $retList['bbody'];
        $btitle = $retList['btitle'];
        $bsubtitle = $retList['bsubtitle'];
        $rep = $retList['rep'];
        $err = $retList['err'];
                
        if( $bbody == null )
        {
//            header("HTTP/1.1 404 Not Found", true, 404);
            $isinvalid = true;
            $con->tp->assign('isinvalid',$isinvalid);
            $btitle = "Invalid Page";
            $bbody = $con->tp->fetch('subtpl/invalid_page.tpl');
            $con->tp->assign('btitle',$btitle);
            $con->tp->assign('bbody', $bbody);
            loadBaseTpl('main.tpl', $con, $email);
            break;
        }
        getLatestCont($con,"Pages");
        getTopRatedCont($con,"Pages");
        getMostViewedCont($con,"Pages");
        
        $con->tp->assign('bsubtitle', $bsubtitle);
        $con->tp->assign('bbody', $bbody);
        $con->tp->assign('btitle', $btitle);
        $con->tp->assign('rep', $rep);
        $con->tp->assign('err', $err);
        
        addSiteStat($pageName.'/'.$art_id , $con, $email);
        loadBaseTpl('main.tpl' , $con, $email);
    break;
    
    case 'accounts':
        $title = "conveylive.com :: Accounts";
        $con->tp->assign('title',$title);
        
        $desc = "conveylive.com - Accounts";
        $con->tp->assign("descrip", $desc);
        
        if( $email == "" )
        {
//            header("HTTP/1.1 404 Not Found", true, 404);
            $isinvalid = true;
            $con->tp->assign('isinvalid',$isinvalid);            
            
            $con->tp->assign('btitle', "Invalid Page");
            $con->tp->assign('bbody', "<div id='pginfo'> You can not access this page without login. Please login, with your user name and password of your conveylive account to access this page.<br /><br />If you do not have an account then please <a href='".PATH."/signup.php' >Signup</a></div>");
            addSiteStat($pageName.'/'.$section, $con, $email);
            loadBaseTpl('main.tpl' , $con , $email);
            break;
        }
        $section = $params[1];
        account($con, $section,$email);
        addSiteStat($pageName.'/'.$section, $con, $email);
        loadBaseTpl('main.tpl' , $con , $email);
    break;    
    
    case 'article': 
        $section = $params[1];
        $id = $params[2];
        $tmp_id = $params[3];
        
        $keys = "Articles, Writeups, communicate, share,network,  conveylive";
        $con->tp->assign("keys", $keys);
        
        $desc = "conveylive.com - Articles. Publish articles and writeups and share your views.";
        $con->tp->assign("descrip", $desc);
        
        $title = "conveylive.com :: Article - ".$params[1]." - Unavailable";
        $con->tp->assign("title", $title);
        
        if($section != 'categorybrowse' && $section != 'browse' && $section != 'view' && $section != 'browsemostviewed' && $section != 'browsetoprated' && $section != 'browselatest')
        {
            if($email == "")
            {
//                header("HTTP/1.1 404 Not Found", true, 404);
                $isinvalid = true;
                $con->tp->assign('isinvalid',$isinvalid);
                
                $con->tp->assign('btitle', "Invalid Page");
                $con->tp->assign('bbody', "<div id='pginfo'> You can not access this page without login. Please login, with your user name and password of your conveylive account to access this page.<br /><br />If you do not have an account then please <a href='".URL."/signup' >Signup</a></div>");
                addSiteStat($pageName.'/'.$section, $con, $email);
                loadBaseTpl('main.tpl' , $con ,$email);
                break;
            }
        }
        article($con,$email, $section, $id, $tmp_id );
        
        getLatestCont($con,"Pages");
        getTopRatedCont($con,"Pages");
        getMostViewedCont($con,"Pages");
        
        addSiteStat($pageName.'/'.$section, $con, $email);
        loadBaseTpl('main.tpl' , $con, $email, $vad, $had, $title);
    break;

    case 'audio':
        $section = $params[1];
        $id = $params[2];
        if(isset($params[3]))
            $tmp_id = $params[3];
        $title = "conveylive.com :: Audio - ".$params[1];
        
        $keys = "Audio, Listen, Song, Music, Voice, communicate, share,network,  conveylive";
        $con->tp->assign("keys", $keys);
        
        $desc = "Listen to you favourite audio publshed by users of ConveyLive and publish your own audio for the world to listen";
        $con->tp->assign("descrip", $desc);
        
        if($section != 'browsegenre' && $section != 'browseartist' && $section != 'browse' && $section != 'genrebrowse' && $section != 'listen' && $section != 'browsemostviewed' && $section != 'browsetoprated' && $section != 'browselatest')
        {
            if($email == "")
            {
//                header("HTTP/1.1 404 Not Found", true, 404);
                $isinvalid = true;
                $con->tp->assign('isinvalid',$isinvalid);                
                $con->tp->assign('title', $title);
                $con->tp->assign('btitle', "Invalid Page");
                $con->tp->assign('bbody', "<div id='pginfo'> You can not access this page without login. Please login, with your user name and password of your conveylive account to access this page.<br /><br />If you do not have an account then please <a href='".URL."/signup' >Signup</a></div>");
                addSiteStat($pageName.'/'.$section, $con, $email);
                loadBaseTpl('main.tpl' , $con , $email);
                break;
            }
        }
        audio($con, $email, $section,  $id , $tmp_id);
        
        getLatestCont($con,"Audios");
        getTopRatedCont($con,"Audios");
        getMostViewedCont($con,"Audios");
        
        addSiteStat($pageName.'/'.$section, $con, $email);
        loadBaseTpl('main.tpl' , $con, $email);
    break;    
    
    case 'b':
        $title = "conveylive.com :: Blogs - ".$params[1];
        $con->tp->assign('title',$title);
        $blogName = $params[1];
        $post_id = $params[2];
        $retList = array();
        
        if($post_id == '')
        {
            $retList = blogview($con, $email, $blogName);
            $bbody = $retList['bbody'];
            $btitle = $retList['btitle'];
            $bsubtitle = $retList['bsubtitle'];
            $rep = $retList['rep'];
            $err = $retList['err'];
            
            $con->tp->assign('bsubtitle', $bsubtitle);
            $con->tp->assign('bbody', $bbody);
            $con->tp->assign('btitle', $btitle);
            $con->tp->assign('rep', $rep);
            $con->tp->assign('err', $err);            
        }
        else if($post_id == "rateup")
        {
            $id = $params[3];
            blog($con, $email, "rateup", $id);
        }
        else if($post_id == "ratedown")
        {
            $id = $params[3];
            blog($con, $email, "ratedown", $id);
        }        
        else if($post_id != "rateup" && $post_id != "ratedown")
        {
            $retList = bpostview($con, $email, $blogName, $post_id);
            $bbody = $retList['bbody'];
            $btitle = $retList['btitle'];
            $bsubtitle = $retList['bsubtitle'];
            $rep = $retList['rep'];
            $err = $retList['err'];
            
            $con->tp->assign('bsubtitle', $bsubtitle);
            $con->tp->assign('bbody', $bbody);
            $con->tp->assign('btitle', $btitle);
            $con->tp->assign('rep', $rep);
            $con->tp->assign('err', $err);            
        }
        
        if($retList == array() && $post_id != "rateup" && $post_id != "ratedown")
        {
//            header("HTTP/1.1 404 Not Found", true, 404);
            $isinvalid = true;
            $con->tp->assign('isinvalid',$isinvalid);
            $btitle = "Invalid Page";
            $bbody = $con->tp->fetch('subtpl/invalid_page.tpl');
            $con->tp->assign('btitle',$btitle);
            $con->tp->assign('bbody', $bbody);
            loadBaseTpl('main.tpl', $con, $email);            
            break;
        }
        
        getLatestCont($con,"Blogs");
        
        addSiteStat($pageName.'/'.$blogName . '/' . $post_id, $con, $email);
        loadBaseTpl('main.tpl' , $con, $email);
    break;
        
    case 'blog':
        $title = "conveylive.com :: Blog - ".$params[1];
        $section = $params[1];
        $id = $params[2];
        
        $desc = "Share Your Blogs and posts with your friends and family. Browse all the blogs published by users of conveylive.com to share and comment.";
        $con->tp->assign("descrip", $desc);
        
        $keys = "Blogs, Posts, Share, ConveyLive";
        $con->tp->assign("keys", $keys);
        
        if($section != 'browseall' && $section != 'browselatest')
        {
            if( $email == "" )
            {
//                header("HTTP/1.1 404 Not Found", true, 404);
                $isinvalid = true;
                $con->tp->assign('isinvalid',$isinvalid);                
                $con->tp->assign('title', $title);
                $con->tp->assign('btitle', "Invalid Page");
                $con->tp->assign('bbody', "<div id='pginfo'> You can not access this page without login. Please login, with your user name and password of your conveylive account to access this page.<br /><br />If you do not have an account then please <a href='".URL."/signup' >Signup</a></div>");
                addSiteStat($pageName.'/'.$section, $con, $email);
                loadBaseTpl('main.tpl' , $con , $email);
                break;
            }
        }
        blog($con, $email, $section, $id);
        
        getLatestCont($con,"Blogs");
        
        addSiteStat($pageName.'/'.$section . '/' .$id, $con, $email);
        loadBaseTpl('main.tpl' , $con, $email);
    break;

    case 'clubs':
        $section = $params[1];
        $title = "conveylive.com :: Club - $section";
        
        $id = $params[2];
        
        $desc = "Create Your own Clubs to discuss and share your digital possesions like, Photos, Files and text posts. Browse all the Clubs of conveylive published by users to share,comment and discuss.";
        $con->tp->assign("descrip", $desc);
        
        $keys = "Clubs, Posts, File, Share, Community, Network, ConveyLive";
        $con->tp->assign("keys", $keys);
        
        if(isset($params[3])) $tmp_id = $params[3];
        else $tmp_id = '';
        
        if($section != 'view' && $section != 'catbrowse' && $section != 'browse' && $section != 'browselatest')
        {
            if( $email == "" )
            {
//                header("HTTP/1.1 404 Not Found", true, 404);
                $isinvalid = true;
                $con->tp->assign('isinvalid',$isinvalid);
                
                $con->tp->assign('title', $title);
                $con->tp->assign('btitle', "Invalid Page");
                $con->tp->assign('bbody', "<div id='pginfo'> You can not access this page without login. Please login, with your user name and password of your conveylive account to access this page.<br /><br />If you do not have an account then please <a href='".URL."/signup' style='color:#cyan'>Signup</a></div>");
                addSiteStat($pageName.'/'.$section, $con, $email);
                loadBaseTpl('main.tpl' , $con , $email);
                break;
            }
        }
        club($con, $email, $section, $id, $tmp_id);
        
        getLatestCont($con,"Clubs");
        
        addSiteStat($pageName.'/'.$section . '/' .$id, $con, $email);
        loadBaseTpl('main.tpl' , $con, $email);
    break;    
    
    case 'forgot':
        $keys = "forget, password, conveylive, address, articulatelogic";
        $con->tp->assign("keys", $keys);
        
        $desc = "conveylive.com :: Forgot Password ";
        $con->tp->assign("descrip", $desc);
        
        $title = "conveylive.com :: Forgot Password";
        $con->tp->assign('title',$title);
        if( $email != "" )
        {
//            header("HTTP/1.1 404 Not Found", true, 404);
            $isinvalid = true;
            $con->tp->assign('isinvalid',$isinvalid);
                        
            $con->tp->assign('err', "");
            $con->tp->assign('btitle', "Invalid Page");
            $con->tp->assign('bbody', "<div id='pginfo'> You can not access this page without logging out. Please logout. </div>");
            addSiteStat($pageName.'/'.$section, $con, $email);
            loadBaseTpl('main.tpl' , $con , $email);
            break;
        }
        $btitle = "Unable to access your account?";
        $bbody = $con->tp->fetch('fpass_view.tpl');
        
        $con->tp->assign('bbody', $bbody);
        $con->tp->assign('btitle', $btitle);
        
        $con->tp->assign('rep', $rep);
        $con->tp->assign('err', $err);
        addSiteStat($pageName, $con, $email);
        loadBaseTpl('main.tpl' , $con , $email);
    break;    
    
    case 'friend':
        $pemail = "";
        $id = 0;
        $title = "conveylive.com :: Friends - ".$params[1];
        $section = $params[1];
        $p = $params[2];
        
        $keys = "friends, communicate, share,network,  conveylive";
        $con->tp->assign("keys", $keys);
        
        $desc = "conveylive.com - Friends. Stay in touch with your friends through conveylive and share your creativity";
        $con->tp->assign("descrip", $desc);
        
        $title = "conveylive.com :: Friends";
        $con->tp->assign("title", $title);
        
        if( $email == "" )
        {
//            header("HTTP/1.1 404 Not Found", true, 404);
            $isinvalid = true;
            $con->tp->assign('isinvalid',$isinvalid);            
            $con->tp->assign('btitle', "Invalid Page");
            $con->tp->assign('bbody', "<div id='pginfo'> You can not access this page without login. Please login, with your user name and password of your conveylive account to access this page.<br /><br />If you do not have an account then please <a href='".PATH."/signup.php' >Signup</a></div>");
            addSiteStat($pageName.'/'.$section, $con, $email);
            loadBaseTpl('main.tpl' , $con, $email);
            break;
        }
        
        if( ($p != null || $p != "") && !(strpos($p, "@") === false) ) 
            $pemail = $p;
        else  
            $id = (int)$p;
        
        if($section == 'view' )
        {
            if($email == $pemail && $pemail != "")
            {
                friends($con, $section, '', $pemail);
            }
            else if($id != 0 && $pemail == "")
            {
                friends($con, $section, $id, $email);
            }
        }
        else if($section != "" )
        {
            friends($con, $section, $id, $email);
        }
        addSiteStat($pageName.'/'.$section, $con, $email);
        loadBaseTpl('main.tpl' , $con, $email);
    break;    

    case 'home':
        $title = "conveylive.com :: Home";
        $con->tp->assign("title", $title);
        $desc = "conveylive.com is a place to make friends and broadcast your creativity with the world. Publish your articles, audio, video, files, blogs, clubs and make it available to search engines, links and other sites as well as your friends. Browse the world through conveylive.com, expand your circle and get amazed with the large collection of other people's contents.";
        $con->tp->assign("descrip", $desc);
        
        $keys = "article, audio, video, photos, club, blog";
        $con->tp->assign("keys", $keys); 
        
        if( $email == "" ) 
        {
            addSiteStat($pageName, $con, $email);
            loadBaseTpl('home.tpl', $con , $email, $vad, $had, $title);
            break;
        }
        home($con,$email);
        addSiteStat($pageName, $con, $email);
        loadBaseTpl('main.tpl' , $con , $email);
    break;
    
    case 'logout':
        $title = "conveylive.com :: Logout";
        $con->tp->assign('title',$title);
        
        $desc = "conveylive.com- Logout";
        $con->tp->assign("descrip", $desc);
        
        if($email != "")
        {
            $ckname = 'ZakirCookie';
            $l = $_SESSION['login'];
            
            $l->logout();
            
            unset($_SESSION['login']);
            unset($_COOKIE[$ckname]);
            $islogin = false;
            $blogexist = checkBlog($con, "");
        }
        $con->tp->assign('islogin',false);

        $con->tp->assign('rep', "You have been logged out");
        addSiteStat($pageName, $con, $email);
        loadBaseTpl('home.tpl' , $con , $email);
    break;    
    
    case 'message':
        $keys = "message, inbox, sent messages, email, password, conveylive";
        $con->tp->assign("keys", $keys);
        
        $desc = "conveylive.com - Messages. Send messages through conveylive and keep in touch";
        $con->tp->assign("descrip", $desc);
        
        $title = "conveylive.com :: Message";
        $con->tp->assign("title", $title);
        
        if( $email == "" )
        {
//            header("HTTP/1.1 404 Not Found", true, 404);
            $isinvalid = true;
            $con->tp->assign('isinvalid',$isinvalid);
            
            $con->tp->assign('btitle', "Invalid Page");
            $con->tp->assign('bbody', "<div id='pginfo'> You can not access this page without login. Please login, with your user name and password of your conveylive account to access this page.<br /><br />If you do not have an account then please <a href='".PATH."/signup.php' >Signup</a></div>");
            addSiteStat($pageName.'/'.$section, $con, $email);
            loadBaseTpl('main.tpl' , $con , $email);
            break;
        }
        $section = trim($params[1]); 
        if($section == 'view' || $section == 'reply' || $section == 'delete' )
        {
            $id =  $params[3];
            $box_type = $params[2];
        }
        message($con, $section, $email, $id, $box_type);
        addSiteStat($pageName.'/'.$section, $con, $email);
        loadBaseTpl('main.tpl' , $con, $email);
    break;

    case 'invitemessage':
        $title = "conveylive.com :: Invite Your Friends";
        $con->tp->assign('title',$title);

        $desc = "conveylive.com - Invite Your Friends to conveylive";
        $con->tp->assign("descrip", $desc);
        
        if( $email == "" )
        {
//            header("HTTP/1.1 404 Not Found", true, 404);
            $isinvalid = true;
            $con->tp->assign('isinvalid',$isinvalid);
            
            $con->tp->assign('btitle', "Invalid Page");
            $con->tp->assign('bbody', "<div id='pginfo'> You can not access this page without login. Please login, with your user name and password of your conveylive account to access this page.<br /><br />If you do not have an account then please <a href='".PATH."/signup.php' >Signup</a></div>");
            addSiteStat($pageName.'/'.$section, $con, $email);
            loadBaseTpl('main.tpl' , $con , $email);
            break;
        }
        $uname = getUserName($email, $con);

        $subj = "Come and join conveylive.com";

        $msgBody .= "Hello, \r\n\r\n";
        $msgBody .= "I have been using the site conveylive.com for a while and I really find this one interesting. Here I can post my own articles and blogs in custom formatting and view people's articles, blogs, blog posts and their comments.\r\n\r\n";
        $msgBody .= "Moreover, it has some exclusive collection of photos in the image gallery, and audios and videos published by people from different corners of the world. I hope that you can also join and post your personal collections of albums, audios and videos to share with us.\r\n";
        $msgBody .= "\r\nWe can also join serveral clubs and share files and discuss various current issues. It's really worth being a member of conveylive. So come and join me in conveylive.com.\r\n";
        $msgBody .= "\r\nRegards\r\n$uname";
        
        $con->tp->assign('subj', $subj);
        $con->tp->assign('msgBody', $msgBody);
        
        $bbody = $con->tp->fetch('invitemessage.tpl');
        
        $btitle = "Invite your Friends";
        $bsubtitle = "Add your own message to invite friends";
        
        $con->tp->assign('err', $err);
        $con->tp->assign('rep', $rep);
        $con->tp->assign('bbody', $bbody);
        $con->tp->assign('btitle', $btitle);
        $con->tp->assign('bsubtitle', $bsubtitle);
        addSiteStat($pageName.'/'.$section, $con, $email);
        loadBaseTpl('main.tpl' , $con , $email);
    break;
    
    case 'moresearch':
        $section = $params[1];
        $title = "conveylive.com :: Profile Search - ". $params[1]."";
        $con->tp->assign('title', $title);
        
        $desc = "Search ConveyLive with More Search to get your specific content easily.";
        $con->tp->assign("descrip", $desc);
        
        $keys = "Search, Advanced, Articles, Writeups, Audio, Video, Blogs, Photos, Pictures, Clubs, Share Files, Communicate, share,network,  conveylive";
        $con->tp->assign("keys", $keys);
        
        if(trim($section) == "people")
        {
            $searchtype = "People";
            $btitle = "Profile Search";
            
            $data['countryList']    = getCountryListDb($con);
            
            $data['relStatusList']  = getRelStatusListDb($con);
            
            $data['religionList']   = getReligionListDb($con);
            
            $data['cityList']       = getCityListDb($con);
            
            $data['htownList']      = getHTownListDb($con);
            
            $data['languageList']   = getLanguageListDb($con);
            
            $monthList = getTxtMonths();
            $con->tp->assign('monthList', $monthList);

            $con->tp->assign('searchtype',$searchtype);
            $data['occupationList'] = getOccupationListDb($con);
        }
        
        $con->tp->assign('data',$data);
        $con->tp->assign('searchtype',$searchtype);
        
        $bbody = $con->tp->fetch('moresearch_view.tpl');
        $con->tp->assign('btitle',$btitle);
        $con->tp->assign('bbody', $bbody);
        $con->tp->assign('rep', $rep);
        $con->tp->assign('err', $err);
        addSiteStat($pageName.'/'.$section, $con, $email);
        loadBaseTpl('main.tpl' , $con, $email);
    break;    
    
    case 'picture':
        $section = $params[1];
        $title = "conveylive.com :: Photos - ".$params[1];
        $id = $params[2];
        
        $desc = "Share Your photos with your friends and family. Browse all the albums published by users of conveylive to share and comment.";
        $con->tp->assign("descrip", $desc);
        
        $keys = "Photos, Albums, Picture, Share, ConveyLive";
        $con->tp->assign("keys", $keys);
        
        if($section != 'view' && $section != 'albumview' && $section != 'browse' && $section != 'browselatest')
        {
            if( $email == "" )
            {
//                header("HTTP/1.1 404 Not Found", true, 404);
                $isinvalid = true;
                $con->tp->assign('isinvalid',$isinvalid);
                $con->tp->assign('title', $title);
                $con->tp->assign('btitle', "Invalid Page");
                $con->tp->assign('bbody', "<div id='pginfo'> You can not access this page without login. Please login, with your user name and password of your conveylive account to access this page.<br /><br />If you do not have an account then please <a href='".URL."/signup' >Signup</a></div>");
                addSiteStat($pageName.'/'.$section, $con, $email);
                loadBaseTpl('main.tpl' , $con , $email);
                break;
            }
        }
        album($con, $email, $section, $id);
        
        getLatestCont($con,"Albums");
        
        addSiteStat($pageName.'/'.$section, $con, $email);
        loadBaseTpl('main.tpl' , $con, $email, $vad, $had, $title);
    break;

    case 'profile':
        $title = "conveylive.com :: Profiles - ".$params[1];
        
        $desc = "conveylive.com is a place to make friends and broadcast your creativity with the world. Publish your articles, audio, video, files, blogs, clubs and make it available to search engines, links and other sites as well as your friends. Browse the world through conveylive.com, expand your circle and get amazed with the large collection of other people's contents.";
        $con->tp->assign("descrip", $desc);
        
        $pemail = "";
        $id = 0;
        $section = $params[1];
        $p = $params[2];
        if($p != "")
        {
            if( ($p != null || $p != "") && !(strpos($p, "@") === false) ) 
                $pemail = $p;
            else  
                $id = (int)$p;
            
            if( $email == "" )
            {
                if($section == 'view' )
                {
                    if($id != 0)
                    viewProfile($con, $id);
                    addSiteStat($pageName.'/'.$section, $con, $email);
                    loadBaseTpl('main.tpl' , $con , $email);
                    break;
                }
                else
                {
//                    header("HTTP/1.1 404 Not Found", true, 404);
                    $isinvalid = true;
                    $con->tp->assign('isinvalid',$isinvalid);                
                    $con->tp->assign('btitle', "Invalid Page");
                    $con->tp->assign('bbody', "<div id='pginfo'> You can not access this page without login. Please login, with your user name and password of your conveylive account to access this page.<br /><br />If you do not have an account then please <a href='".PATH."/signup.php' >Signup</a></div>");
                    addSiteStat($pageName.'/'.$section, $con, $email);
                    loadBaseTpl('main.tpl' , $con , $email);
                    break;
                }
                break;
            }

            if ($section == 'view' )
            {
                if($email == $pemail && $pemail != "")
                {
                    $r = profile($con, $section, $email, $id);
                }
                else if($id != 0 && $pemail == "")
                {
                    viewProfile($con, $id, $email);
                }
            }
            else
            {
                $r = profile($con, $section, $email, 0);
            }
        }
        else
        {
            $isinvalid = true;
            $title = "Profiles - View";
            $con->tp->assign('title', $title);
            $con->tp->assign('isinvalid',$isinvalid);            
            $con->tp->assign('btitle', "Profile unavailable");
            $con->tp->assign('bbody', "<div id='pginfo'>This user does not have a profile.</div>");
            addSiteStat($pageName.'/'.$section, $con, $email);
            loadBaseTpl('main.tpl' , $con , $email);
            break;
        }
        addSiteStat($pageName.'/'.$section, $con, $email);
        loadBaseTpl('main.tpl' , $con , $email);
    break;    

    case 'resendvmail':
        $desc = "conveylive.com is a place to make friends and broadcast your creativity with the world. Publish your articles, audio, video, files, blogs, clubs and make it available to search engines, links and other sites as well as your friends. Browse the world through conveylive.com, expand your circle and get amazed with the large collection of other people's contents.";
        $con->tp->assign("descrip", $desc);
        
        $keys = "article, audio, video, photos, club, blog";
        $con->tp->assign("keys", $keys);
        
        $keys = "Clubs, Posts, File, Share, Community, Network, ConveyLive";
        $con->tp->assign("keys", $keys);
        
        $vemail = $params[1];
        $r = $con->db->selectData("select validator, f_name, l_name from users where email = '$vemail'");
        $err .= $con->db->err;

        if($r == false || $r == array()) 
        {
//            header("HTTP/1.1 404 Not Found", true, 404);
            $isinvalid = true;
            $con->tp->assign('isinvalid',$isinvalid);
            $con->tp->assign('btitle', "Invalid Page");
            $con->tp->assign('bbody', "<div id='pginfo'> You can not access this page without login. Please login, with your user name and password of your conveylive account to access this page.<br /><br />If you do not have an account then please <a href='".PATH."/signup.php' >Signup</a></div>");
            addSiteStat($pageName.'/'.$section, $con, $email);
            loadBaseTpl('main.tpl' , $con , $email);
            break;
        }
        else
        {
            $v = $r[0]['validator'];
            $fname = $r[0]['f_name'];
            $lname = $r[0]['l_name'];
            
            if(isset($_SESSION['validreqest']) && $_SESSION['validreqest'] == "valid")
            {
                $to = $vemail;
                $subject = 'Welcome to conveylive.com : Please validate your email address';
                $message = "Hello, ".$fname." ".$lname." \r\nThank you for registering with ConveyLive.com. \r\nPlease click the following link to complete your registration process. \r\nhttp://www.conveylive.com/validate.php?id=$validator&e=$vemail";
                $message .= "\r\n\r\n(If clicking on the link does not work, try copying and pasting it into your browser)";
                $message .= "\r\n\r\nShare your imagination with ConveyLive and have fun !!! \r\n\r\n\r\nThanks. \r\nConveyLive Team";
                    
                try
                {
                    $result = simpleMail($con, $message, $subject, array("mail@conveylive.com" => "Conveylive Team"), array($to => "" .$fname ." ". $lname ."" ), "text/plain",array("mail@conveylive.com" => "Conveylive Team") , 0 );
                    
                    $mail_sent = true;
                }
                catch(Exception $ex)
                {
                    $btitle = "Sorry, could not send you validation email !";
                    $bbody =  "<p>Failed to send you the validation email due to invalid email address. <br/>Please try <a href='index.php?p=signup'>signing up</a> again !<br />";
                    $err .= $ex->getMessage();
                }
                if($mail_sent && $is_ins)
                {
                    $btitle = "<p>Validation Mail sent!</p>";
                    $bbody = "<p>An email has been sent to your mail address ".$email.". <br/>Please follow the link given in your email to verify your account and complete your registration.</p>";
                    $rep = "Validation Mail sent!";
                }
                else
                {
                    $err = "Could not Send Email";
                }
            }
            $con->tp->assign('err', $err);
            $con->tp->assign('rep', $rep);
            $con->tp->assign('bbody', $bbody);
            $con->tp->assign('btitle', $btitle);
            addSiteStat($pageName.'/'.$section, $con, $email);
            loadBaseTpl('main.tpl', $con, $email);
        }
    break;
    
    case 'signup':
        
        $tag = $params[1];
        if($tag == "friend")
        {
            $msg = "Please signup to conveylive.com and add this user as your friend. <br /><br />Please note that inorder to add as friend, you need to create your own profile after logging in to your account. <br />Join in and share your creativity.<br /><br /> --Conveylive Team";
            $con->tp->assign('msg', $msg);
        }
        $title = "conveylive.com :: Signup";
        $con->tp->assign('title',$title);
        
        $keys = "signup, user, email, password, conveylive";
        $con->tp->assign("keys", $keys);
        
        $desc = "conveylive.com - Signup: Signup in conveylive and express your creativity.";
        $con->tp->assign("descrip", $desc);
        
        if( $email != "" )
        {
//            header("HTTP/1.1 404 Not Found", true, 404);
            $isinvalid = true;
            $con->tp->assign('isinvalid',$isinvalid);
                        
            $con->tp->assign('err', "");
            $con->tp->assign('btitle', "Invalid Page");
            $con->tp->assign('bbody', "<div id='pginfo'> You can not access this page without logging out. Please logout. </div>");
            addSiteStat($pageName.'/'.$section, $con, $email);
            loadBaseTpl('main.tpl' , $con , $email);
            break;
        }
        $btitle = "Signup";
        $monthList = getTxtMonths();
        $con->tp->assign('monthList', $monthList);
        $bbody = $con->tp->fetch('signup_view.tpl');
        $con->tp->assign('bbody', $bbody);
        $con->tp->assign('btitle', $btitle);
        $con->tp->assign('rep', $rep);
        $con->tp->assign('err', $err);
        addSiteStat($pageName, $con, $email);
        loadBaseTpl('main.tpl' , $con , $email);
    break;    

    case 'static':
        $keys = "privacy, terms, conditions, about, conveylive, address, articulatelogic";
        $con->tp->assign("keys", $keys);
        
        $staticPage = "";
        if($params[1] == 'about')
        {
            $title = "conveylive.com :: About";
            $con->tp->assign('title',$title);
            $btitle = "About";
            $bbody = $con->tp->fetch('about.tpl');
            
            $desc = "conveylive.com is a place to make friends and broadcast your creativity with the world. Publish your articles, audio, video, files, blogs, clubs and make it available to search engines, links and other sites as well as your friends. Browse the world through conveylive.com, expand your circle and get amazed with the large collection of other people's contents.";
            $con->tp->assign("descrip", $desc);
        }
        else if($params[1] == 'contact')
        {
            $title = "conveylive.com :: Contact";
            $con->tp->assign('title',$title);
            $btitle = "Contact";
            $bbody = $con->tp->fetch('contact.tpl');
            
            $desc = "conveylive.com Address: Muhammadpur Dhaka, Bangladesh - 1207. Email: mail@conveylive.com , aazhbd@yahoo.com. Courtesy of ArticulateLogic: www.articulatelogic.com. Email: web@articulatelogic.com";
            $con->tp->assign("descrip", $desc);
        }
        else
        {
            $t = $params[1];

            if(trim($t) =="terms")
            {
                $t = "Terms";
            }
            if(trim($t) =="privacy")
            {
                $t = "Privacy";
            }
            $title = "conveylive.com :: $t";
            $con->tp->assign('title',$title);
            
            $staticPage = getStatic(trim($params[1]));
            
            $desc = "conveylive.com - ".substr(strip_tags(stripcslashes($staticPage)), 0, 500);
            $con->tp->assign("descrip", $desc);
        }
        
        if($staticPage != "")
        {
            $t =  substr($staticPage,0, strpos($staticPage,"</h2>"));
            $count = 1;
            $btitle = str_replace("<h2>", "", trim($t), $count);
            $bbody = str_replace("<h2>$btitle</h2>", "", $staticPage, $count);
        }
        else if($islogin)
        {
            addSiteStat($pageName.'/'.$params[1], $con, $email);
        }
        else
        {
            addSiteStat($pageName.'/'.$params[1], $con, $email);
        }
        
        $staticbody = $bbody;
        $con->tp->assign('staticbody',$staticbody);
        $bbody = $con->tp->fetch('static.tpl');
        
        $con->tp->assign('btitle',$btitle);
        $con->tp->assign('bbody', $bbody);
        loadBaseTpl('main.tpl' , $con , $email);
    break;
    
    case 'video':
        $section = $params[1];
        $id = $params[2];
        $tmp_id = $params[3];
        $title = "conveylive.com :: Video - ".$params[1];
        
        $desc = "Watch your favourite video and songs and tutorials publshed by users of conveylive.com and publish your own video for the world to watch.";
        $con->tp->assign("descrip", $desc);
        
        $keys = "Video, Watch, Song, Music, Voice, communicate, share,network,  conveylive";
        $con->tp->assign("keys", $keys);
        
        if($section != 'watch' && $section != 'categorybrowse' && $section != 'browse' && $section != 'browsemostviewed' && $section != 'browsetoprated' && $section != 'browselatest')
        {
            if( (isset($_SESSION['login']) && $l->isLoged()) == false )
            {                
//                header("HTTP/1.1 404 Not Found", true, 404);
                $isinvalid = true;
                $con->tp->assign('isinvalid',$isinvalid);                
                $con->tp->assign('title', $title);
                $con->tp->assign('btitle', "Invalid Page");
                $con->tp->assign('bbody', "<div id='pginfo'> You can not access this page without login. Please login, with your user name and password of your conveylive account to access this page.<br /><br />If you do not have an account then please <a href='".URL."/signup' style='color:#cyan'>Signup</a></div>");
                addSiteStat($pageName.'/'.$section, $con, $email);
                loadBaseTpl('main.tpl' , $con , $email);
                break;
            }
        }
        video($con, $email, $section, $id, $tmp_id);
        
        getLatestCont($con,"Videos");
        getTopRatedCont($con,"Videos");
        getMostViewedCont($con,"Videos");
        
        addSiteStat($pageName.'/'.$section, $con, $email);
        loadBaseTpl('main.tpl' , $con, $email);
    break;
    
    default:
        $desc = "Invalid Page";
        $con->tp->assign("descrip", $desc);
        
        $title = "conveylive.com :: Invalid Page";
        $con->tp->assign('title',$title);
        
//        header("HTTP/1.1 404 Not Found", true, 404);
        
        $isinvalid = true;
        $con->tp->assign('isinvalid',$isinvalid);
        
        $btitle = "Invalid Page";
        $bbody = $con->tp->fetch('subtpl/invalid_page.tpl');
        
        $con->tp->assign('btitle',$btitle);
        $con->tp->assign('bbody', $bbody);
        loadBaseTpl('main.tpl', $con, $email);
}

?>