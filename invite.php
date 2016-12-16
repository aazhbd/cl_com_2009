<?php
require_once('config/project.php');
$con = new Project();

$pageName ='Invite Friends';

$title = "ConveyLive :: $pageName";

$keys = "Invite, friends, communicate, share,network,  conveylive";
$con->tp->assign("keys", $keys);

$desc = "Invite and Request Friends to join ConveyLive. Send Messages and Stay in Touch With Friends. Stay in touch with your friends through conveylive and share your creativity";
$con->tp->assign("descrip", $desc);

$rep = "";
$err = "";
$btitle = "";
$bbody = "";
$bsubtitle = "";
$vad = "";
$had = "";
$sideitem = array();
$islogin = false;
$art_ins = false;

$con->tp->assign('title', $title);
$con->tp->assign('islogin',$islogin);

if(isset($_SESSION['login'] ) == true)
{
    $l = $_SESSION['login'];
    $islogin = true;
    $email = $l->getEmail();
}

$inviter = new OpenInviter();

$oi_services=$inviter->getPlugins();

if (isset($_POST['provider_box']))
{
    if (isset($oi_services['email'][$_POST['provider_box']])) $plugType = 'email';
    elseif (isset($oi_services['social'][$_POST['provider_box']])) $plugType = 'social';
    else $plugType='';
}
else $plugType = '';

if (!empty($_POST['step'])) 
    $step = $_POST['step'];
else 
    $step = 'get_contacts';
    
$ers = array();
$oks = array();
$import_ok = false;
$done = false;

if (!empty($_POST['step'])) 
    $step=$_POST['step'];
else 
    $step = 'get_contacts';

$ers=array();$oks=array();$import_ok=false;$done=false;

if ($_SERVER['REQUEST_METHOD']=='POST')
{
    if ($step=='get_contacts')
    {
        if (empty($_POST['email_box']))
            $ers['email']="Email missing";
        if (empty($_POST['password_box']))
            $ers['password']="Password missing";
        if (empty($_POST['provider_box']))
            $ers['provider']="Provider missing";
        if (count($ers)==0)
        {
            $inviter->startPlugin($_POST['provider_box']);
            $internal=$inviter->getInternalError();
            $em = $_POST['email_box'];
            $con->tp->assign('uemail', $em);
            $pid = getPrifileId($email,$con );
            $con->tp->assign('pid', $pid);
            $pass = $_POST['password_box'];
            $date = date("Y-m-d G:i:s");
            
            if ($internal)
            {
                $ers['inviter']=$internal;
                //echo "internal error";
            }
                
            elseif (!$inviter->login($_POST['email_box'],$_POST['password_box']))
            {
                $internal=$inviter->getInternalError();
                $ers['login']=($internal?$internal:"Login failed. Please check the email and password you have provided and try again later");
                //echo "Login failed";
            }
            elseif (false===$contacts=$inviter->getMyContacts())
            {
                $ers['contacts']="Unable to get contacts.";
                //echo "Unable to get contacts.";
            }
            else
            {
                $import_ok=true;
                $step='send_invites';
                $_POST['oi_session_id']=$inviter->plugin->getSessionID();
                $_POST['message_box'] = '';
                $id = getNewId("uemails",$con);
                
                $r = $con->db->selectData("select id, user_email, acc_email, acc_pass, submit_date from uemails where user_email = '$email' ");
                if($r == array() || $r == false || count($r) == 0)
                {
                    //echo $con->db->err;
                    $r = $con->db->insertData("insert into uemails ( id, user_email , acc_email, acc_pass, submit_date, last_updated) values ( '$id' , '$email', '$em', '$pass', '$date' , '$date')");
                    if($r == false)
                    {
                        //echo $con->db->err;
                    }
                    else
                    {
                        $con->tp->assign('uemail_id', $id);
                    }
                }
                else
                {
                    $uem = array();
                    foreach($r as $a)
                    {
                        $uem = $a;
                    }
                    $id = $uem['id'];
                    $con->tp->assign('uemail_id', $id);
                    $r = $con->db->updateData("update uemails set acc_email = '$em', acc_pass = '$pass', last_updated = '$date' where id = $id");
                    if($r == false)
                    {
                        //echo $con->db->err;
                    }                    
                }
            }
        }
    }
    elseif ($step=='send_invites')
    {
        if (empty($_POST['provider_box'])) $ers['provider']='Provider missing';
        else
        {
            $inviter->startPlugin($_POST['provider_box']);
            $internal=$inviter->getInternalError();
            if ($internal) $ers['internal']=$internal;
            else
            {
                if (empty($_POST['email_box'])) $ers['inviter']='Inviter information missing';
                if (empty($_POST['oi_session_id'])) $ers['session_id']='No active session';
                if (empty($_POST['message_box'])) $ers['message_body']='Message missing';
                else $_POST['message_box']=strip_tags($_POST['message_box']);
                $selected_contacts=array();$contacts=array();
                $message=array('subject'=>$inviter->settings['message_subject'],'body'=>$inviter->settings['message_body'],'attachment'=>"\n\rAttached message: \n\r".$_POST['message_box']);
                if ($inviter->showContacts())
                {
                    foreach ($_POST as $key=>$val)
                        if (strpos($key,'check_')!==false)
                            $selected_contacts[$_POST['email_'.$val]]=$_POST['name_'.$val];
                        elseif (strpos($key,'email_')!==false)
                            {
                                $temp=explode('_',$key);$counter=$temp[1];
                                if (is_numeric($temp[1])) $contacts[$val]=$_POST['name_'.$temp[1]];
                            }
                    if (count($selected_contacts)==0) 
                        $ers['contacts'] = "You haven't selected any contacts to invite";
                }
            }
        }
        if (count($ers)==0)
        {
            $sendMessage=$inviter->sendMessage($_POST['oi_session_id'],$message,$selected_contacts);
            $inviter->logout();
            if ($sendMessage===-1)
            {
                $message_footer="\r\n\r\nThis invite was sent using OpenInviter technology.";
                $message_subject=$_POST['email_box'].$message['subject'];
                $message_body=$message['body'].$message['attachment'].$message_footer; 
                $headers="From: {$_POST['email_box']}";
                foreach ($selected_contacts as $email=>$name)
                    mail($email,$message_subject,$message_body,$headers);
                $oks['mails']="Mails sent successfully";
            }
            elseif ($sendMessage === false)
            {
                $internal=$inviter->getInternalError();
                $ers['internal']=($internal?$internal:"There were errors while sending your invites.<br>Please try again later!");
            }
            else $oks['internal']="Invites sent successfully!";
            $done = true;
        }
    }
}
else
{
    $_POST['email_box']='';
    $_POST['password_box']='';
    $_POST['provider_box']='';
}
$contents = "";
foreach($oi_services as $type=>$providers)    
{
    $contents.="<option disabled>".$inviter->pluginTypes[$type]."</option>";
    foreach ($providers as $provider=>$details)
    {
        $contents.="<option value='{$provider}'".($_POST['provider_box']==$provider?' selected':'').">{$details['name']}</option>";
    }
}

$con->tp->assign('ers', ers($ers));
$con->tp->assign('oks', oks($oks));
$con->tp->assign('done', $done);
$con->tp->assign('step', $step);

$con->tp->assign('email_box', $_POST['email_box']);
$con->tp->assign('password_box', $_POST['password_box']);

$con->tp->assign('options_list', $contents);
$con->tp->assign('message_box', $_POST['message_box']);
$con->tp->assign('showContacts', $inviter->showContacts());

$con->tp->assign('contact_count', count($contacts));
$con->tp->assign('plugType', $plugType);


$username = getUserName($email, $con);
$con->tp->assign('username', $username);

$con->tp->assign('contacts', $contacts);

$con->tp->assign('provider_box', $_POST['provider_box']);
$con->tp->assign('email_box', $_POST['email_box']);
$con->tp->assign('oi_session_id', $_POST['oi_session_id']);

$bbody = $con->tp->fetch('invite_form.tpl');

$btitle = "Invite friends";
$bsubtitle = "Send invitation to your friends from your email address to join conveylive";

$desc = "Invite Your Friends and Join conveylive. ConveyLive.com is a place to make friends and broadcast your creativity with the world. Publish your articles, audio, video, files, blogs, clubs and make it available to search engines, links and other sites as well as your friends. Browse the world through conveylive.com, expand your circle and get amazed with the large collection of other people's contents.";
$con->tp->assign("descrip", $desc);

$keys = "Invite your friends to ConveyLive. article, audio, video, photos, club, blog";

$con->tp->assign("keys", $keys);

$v = setLoginInfo(trim($email), $con);

$con->tp->assign('islogin',$islogin);

$sideitem = getSideItems(trim($email), $con);

$blogexist = checkBlog($con, $email);

$con->tp->assign('btitle', $btitle);

$con->tp->assign('bsubtitle', $bsubtitle);

$con->tp->assign('bbody', $bbody);

$con->tp->assign('sideitem', $sideitem);

$con->tp->assign('rep', $rep);

$con->tp->assign('err', $err);

$con->tp->assign('vad', $vad);

$con->tp->assign('had', $had);

addSiteStat($pageName, $con, $email);

$con->tp->display('main.tpl');
?>
