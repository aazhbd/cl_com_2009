<?php /* Smarty version 2.6.26, created on 2010-01-26 16:03:46
         compiled from invitemessage.tpl */ ?>
<?php echo '
<script type="text/javascript">
   $(document).ready(function(){
       $("#errors").hide();
   });
</script>
'; ?>

<div style="width:745px;">
    <div id="errors"></div>
    <form method="post" action="<?php echo @URL; ?>
/singleinvite.php" id="frmnewmsg">
        <fieldset title="Invite Friends">
            <legend>Write your message and send invitation to your friend by email</legend>
            <div>
                <span><a href="<?php echo @URL; ?>
/invite.php">Invite friends from email account's addressbook</a></span>
            </div>
            <div>
                <span>
                    <div style="width:150px;float:left;">
                        <label for="email">Friend's Email: </label>
                    </div>
                    <input type="text" name="email" id="email" value="" size="40" />
                </span>
            </div>
            <div>
                <span>
                    <div style="width:150px;float:left;">
                        <label>Subject: </label>
                    </div>
                    <?php echo $this->_tpl_vars['subj']; ?>

                    <input type="hidden" name="subj" value="<?php echo $this->_tpl_vars['subj']; ?>
">
                </span>
            </div>  
            <div>
                <span>
                    <div style="width:600px;float:left;">
                        <label for="message">Your Message:</label>
                    </div>
                    <div style="float:left; width:700px;"><textarea  name="message" id="message" style="width:675px;height:230px;padding:10px;" class="msgbox" ><?php echo $this->_tpl_vars['msgBody']; ?>
</textarea></div>
                </span>
            </div>
            <div>
                <span>&nbsp;</span>
                <br />
            </div>
            <div>
                <span>
                    <input type="submit" name="submit" id="button" value="Send Invitation Mail" class="frmbtn"/>
                    <input type="reset" name="reset" id="button" value="Reset" class="frmbtn"/>
                    
                    <a href="<?php echo @URL; ?>
/home">Cancel</a>
                </span>
            </div>
        </fieldset>
    </form>
</div>
<?php echo '
<script type="text/javascript">
   
   $(document).ready(function(){      
       $("#frmnewmsg").validate({
       errorLabelContainer: "#errors",
       wrapper: "p",
           rules:{
               email:{ required: true, maxlength: 50, email: true },
               message:{ required: true, maxlength: 3000}
           },
           messages:{
               email: {
                   required: "Please type the email address",
                   maxlength: "The \'To\' field can not be more than 50 characters",
                   email: "Email address you entered is not valid, please correct the email address"
               },
               message: {
                   required: "You can not send an empty message.",
                   maxlength: "Content can not be more than 3000 characters long"
               }
           }
       });
   });
</script>
'; ?>