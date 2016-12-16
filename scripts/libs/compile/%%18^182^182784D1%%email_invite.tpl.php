<?php /* Smarty version 2.6.26, created on 2010-01-13 08:33:20
         compiled from subtpl/email_invite.tpl */ ?>

<?php if ($this->_tpl_vars['islogin'] != null): ?>
    <div class="box" style="margin-top:5px;">
        <h3>Invite Your Friends</h3>
        <div class="sideCont">
            <div class="contName">
                <div id="err"></div>
                <form id="invitefrm" action="<?php echo @URL; ?>
/singleinvite.php" method="post">
                    <span>
                        <input type="text" id = "email" name="email" value="Email" onclick="this.value=''" style="margin:5px;" />
                    </span>
                    <span>
                        <input type="submit" id="submit" name="submit" value="Send" class="frmbtn"/>
                    </span>
                    <span>
                        <br />
                        <a href="<?php echo @URL; ?>
/invitemessage" >Invite with Message</a>
                    </span>
                </form>
            </div>
        </div>
    </div>
<?php endif; ?>

<?php echo '
<script type="text/javascript">
   
   $(document).ready(function(){      
       
       $("#err").hide();
       
       $("#invitefrm").validate({
       errorLabelContainer: "#errors",
       wrapper: "p",
           rules:{
               email:{ required: true, email: true , maxlength: 50}
           },
           messages:{
               email: "Please enter a valid email address."
           }
       });
   });
</script>
'; ?>