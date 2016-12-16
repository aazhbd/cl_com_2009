<?php
function account($con, $section, $email)
{
    $rep = "";
    $err = "";
    $btitle = "";
    $bbody = "";
    $bsubtitle = "";
    
    switch($section)
    {
        case 'edit':
            $btitle = "Account";
            $bsubtitle = "Settings of your conveylive account";
            $monthList = getTxtMonths();
            $d = $con->db->selectData("select * from users where email = '$email'");
            
            $arr = explode("-",$d[0]['birth_date']);
            $d[0]['day'] = $arr[2];
            $m = $arr[1];
            $m=ltrim($m,'0');
            $d[0]['month'] = $monthList[$m];
            $d[0]['year'] = $arr[0];
            
            $con->tp->assign('monthList', $monthList);
            $con->tp->assign('data', $d[0]);
            $bbody = $con->tp->fetch('accedit_view.tpl');

            $title = "ConveyLive :: My Account";
            $con->tp->assign('title', $title);
            
            $desc = "Change your Account Settings at ConveyLive. Set Your Privacy Settings and decide what you want to share and the ones you want to keep private. ConveyLive.com is a place to make friends and broadcast your creativity with the world. Publish your articles, audio, video, files, blogs, clubs and make it available to search engines, links and other sites as well as your friends. Browse the world through conveylive.com, expand your circle and get amazed with the large collection of other people's contents.";
            $con->tp->assign("descrip", $desc);

            $keys = "Set account, Privacy, Send, New, Messages, article, audio, video, photos, club, blog";
            $con->tp->assign("keys", $keys);
        break;
        
        /*
        case 'deactivate':
        $btitle = " Deactivate Account";
        $bsubtitle = "Deactivate your conveylive account";

        $bbody = $con->tp->fetch('deactivate.tpl');
        $title = "ConveyLIve :: My Account - Deactivate";
        $con->tp->assign('title', $title);
        
        $desc = "Change your Account Settings at ConveyLive. Set Your Privacy Settings and decide what you want to share and the ones you want to keep private. ConveyLive.com is a place to make friends and broadcast your creativity with the world. Publish your articles, audio, video, files, blogs, clubs and make it available to search engines, links and other sites as well as your friends. Browse the world through conveylive.com, expand your circle and get amazed with the large collection of other people's contents.";
        $con->tp->assign("descrip", $desc);

        $keys = "Set account, Privacy, Send, New, Messages, article, audio, video, photos, club, blog";
        $con->tp->assign("keys", $keys);
        break;
        /*
        case 'privacy':
        $btitle = "User Home";
        $bsubtitle = "Set the privacy of conveylive account";
        $bbody = $con->tp->fetch('uhome_view.tpl');
        break;*/
        
        default:
            $btitle = "Account";
            $bsubtitle = "Settings of your conveylive account";
            $monthList = getTxtMonths();
            $d = $con->db->selectData("select * from users where email = '$email'");
            
            $arr = explode("-",$d[0]['birth_date']);
            $d[0]['day'] = $arr[2];
            $m = $arr[1];
            $m=ltrim($m,'0');
            $d[0]['month'] = $monthList[$m];
            $d[0]['year'] = $arr[0];
            
            $con->tp->assign('monthList', $monthList);
            $con->tp->assign('data', $d[0]);
            $bbody = $con->tp->fetch('accedit_view.tpl');

            $title = "ConveyLive :: My Account";
            $con->tp->assign('title', $title);
            
            $desc = "Change your Account Settings at ConveyLive. Set Your Privacy Settings and decide what you want to share and the ones you want to keep private. ConveyLive.com is a place to make friends and broadcast your creativity with the world. Publish your articles, audio, video, files, blogs, clubs and make it available to search engines, links and other sites as well as your friends. Browse the world through conveylive.com, expand your circle and get amazed with the large collection of other people's contents.";
            $con->tp->assign("descrip", $desc);

            $keys = "Set account, Privacy, Send, New, Messages, article, audio, video, photos, club, blog";
            $con->tp->assign("keys", $keys);        
    }
    $con->tp->assign('bsubtitle', $bsubtitle);
    $con->tp->assign('bbody', $bbody);
    $con->tp->assign('btitle', $btitle);
    $con->tp->assign('rep', $rep);
    $con->tp->assign('err', $err);
}
?>