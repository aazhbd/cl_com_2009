<?php
class Login
{
    var $loged = false;
    var $uemail = "";
    var $utype = "";
    var $validator = "";
    var $msg = "";
    
    function Login($email, $pass, $db)
    {
        $email = trim($email);
        $pass = trim($pass);
        
        $r = $db->selectData("select pass, ustatus, utype, validator, admin_perm from users where email = '$email'");
        //print_r($r);
        if($r == null || $r == false) return false;
        
        foreach($r as $p)
        {
            $tpass = $p['pass'];
            $tstat = "" . $p['ustatus'];
            $utype = "" . $p['utype'];
            $tvdator =  "" . $p['validator'];
            $tperm =  "" . $p['admin_perm'];
        }
        
        if($tpass == $pass && $tstat == "1" && $tperm == "0")
        {                    
            $this->uemail = $email;                    
            $this->loged = true;
            $this->utype = $utype;
            $this->validator = $tvdator;
        }
        else if($tpass == $pass && $tstat == "0")
        {
            $this->uemail = $email;
            $this->msg = "Please validate your email address by clicking on the link provided in the mail sent by conveylive to your email account. If you did not get the email please check your spam folder or request us to send you the email again by clicking the link below.";
        }
    }
    
    function isLoged()
    {
        return $this->loged;
    }
    
    function getEmail()
    {
        return $this->uemail;
    }
    
    function getuType()
    {
        return $this->utype;
    }
    
    function logout()
    {
        $this->uemail = "";
        $this->loged = false;
        $this->type = "";
    }
    function getValidator()
    {
        return $this->validator;
    }
}
?>
