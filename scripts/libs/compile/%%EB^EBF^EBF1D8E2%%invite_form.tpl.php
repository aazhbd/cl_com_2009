<?php /* Smarty version 2.6.26, created on 2010-01-25 12:48:56
         compiled from invite_form.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'wordwrap', 'invite_form.tpl', 71, false),)), $this); ?>
<?php echo '
<script type="text/javascript">
   $(document).ready(function(){
       $("#errors").hide();
   });
   function toggleAll(element) 
    {
        var form = document.forms.frminvitefrnds, z = 0;
        for(z=0; z < form.length; z++)
        {
            if(form[z].type == \'checkbox\')
                form[z].checked = element.checked;
        }
    }
</script>
'; ?>

<div id="errors"></div>
<div style="float:left; width:745px;">
    <div id="pginfo">
        Invite your friends to join conveylive. Submit your email address and password in the form below and click "Import Contacts" button.
        If your email address and password are correct then you will see a list of your email addresses from your email's address book. You may select the emails to which you want to send invitation.
        You can also add a message with the invitation mail.
    </div> 
    <?php if ($this->_tpl_vars['done'] != true): ?>
        <?php if ($this->_tpl_vars['step'] == 'send_invites'): ?>
            <?php if ($this->_tpl_vars['showContacts'] == true): ?>
                <form id="frminvitefrnds" method="post" action="<?php echo @URL; ?>
/sendmail.php">
                    <fieldset title="Invite Friends">
                        <input type='hidden' name='uemail_id' value='<?php echo $this->_tpl_vars['uemail_id']; ?>
' />
                        <input type='hidden' name='uemail' value='<?php echo $this->_tpl_vars['uemail']; ?>
' />
                        <input type='hidden' name='username' value='<?php echo $this->_tpl_vars['username']; ?>
' />
                        <div>
                            <span>Select which contacts to invite from the list below. You can also try <a href="<?php echo @URL; ?>
/invite.php">another email account.</a></span>
                        </div>
                        <div>
                            <span>
                                <label>Subject: </label>
                                <div style="width:98%;float:left;">Your friend <?php echo $this->_tpl_vars['username']; ?>
 invites you to join ConveyLive.com.</div>
                            </span>
                        </div>
                        <div>
                            <div>
                                <span>
                                    <label for="cont">Your Message:</label>
                                    <div style="width:730px;float:left;">
                                    Hello,
                                        <center>
                                            <textarea  name="message" id="message" style="width:700px;height:100px;float:left;padding:10px;" class="msgbox" readonly="readonly" >Come and join me in ConveyLive! You can meet here different people from all over the world who has published various articles, audio, video, photos, clubs and blogs. Let's express our creativity, share our views and enjoy ConveyLive ! <?php if ($this->_tpl_vars['pid'] != null): ?>Click the link http://conveylive.com/profile/view/<?php echo $this->_tpl_vars['pid']; ?>
 to view my profile<?php endif; ?>

Thanks
<?php echo $this->_tpl_vars['username']; ?>

</textarea>
                                        </center>
                                    </div>
                                </span>
                            </div>
                            <div>
                                <span>&nbsp;</span>
                            </div>
                            <div class="invitebox">
                                <div style="float:left; width:220px;padding:5px;">
                                    <input type='checkbox' onChange=<?php echo '\'toggleAll(this)\''; ?>
 name='toggle_all' title='Select/Deselect all' checked="checked" />
                                    &nbsp;&nbsp;
                                    <strong>Name</strong>
                                </div>
                                <div style="float:left; width:230px;padding:5px;"><strong>Email</strong></div>
                                <div style="float:left; width:730px;">
                                    <?php $_from = $this->_tpl_vars['contacts']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['email'] => $this->_tpl_vars['name']):
?>
                                        <div class="uname">
                                            <input name='chkedemail[]' value='<?php echo $this->_tpl_vars['email']; ?>
,<?php echo $this->_tpl_vars['name']; ?>
' type='checkbox' checked="checked" /> &nbsp;&nbsp;
                                            <?php echo ((is_array($_tmp=$this->_tpl_vars['name'])) ? $this->_run_mod_handler('wordwrap', true, $_tmp, 18, "\n", true) : smarty_modifier_wordwrap($_tmp, 18, "\n", true)); ?>

                                        </div>
                                        <div class="uemail">
                                            <?php echo ((is_array($_tmp=$this->_tpl_vars['email'])) ? $this->_run_mod_handler('wordwrap', true, $_tmp, 18, "\n", true) : smarty_modifier_wordwrap($_tmp, 18, "\n", true)); ?>

                                        </div>
                                        <div style="float:left; width:560px;">
                                            <span>&nbsp;</span>
                                        </div>
                                    <?php endforeach; endif; unset($_from); ?>
                                </div>
                            </div>
                            <br />
                            <div>
                                <span align="center">
                                    <input type="submit" name="submit" id="button" value="Send Invitation Mail" class="frmbtn"/>
                                    <a href="<?php echo @URL; ?>
/home">Cancel</a>
                                    <input type="hidden" name="email" id="email"  value="<?php echo $this->_tpl_vars['prof']['user_email']; ?>
"/>
                                </span>
                            </div>
                        </div>
                    </fieldset>
                </form>
            <?php endif; ?>
        <?php endif; ?>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['done'] != true): ?>
        <?php if ($this->_tpl_vars['step'] == 'get_contacts'): ?>
            <form action='<?php echo @URL; ?>
/invite.php' method='POST' name='openinviter' align="center" style="width:730px;">
                    <fieldset style="width:730px;">
                    <legend style="width:200px;">Invite Your Friends</legend>
                    <?php echo $this->_tpl_vars['ers']; ?>
<?php echo $this->_tpl_vars['oks']; ?>

                        <div>
                            <span>
                                <label style="float:left;width:65px;" for='email_box'>Email</label>
                                <input class='thTextbox' type='text' name='email_box' value='<?php echo $this->_tpl_vars['email_box']; ?>
' style="width:155px;" /><br/>
                            </span>
                        </div>
                        <div>
                            <span>
                                <label style="float:left;width:65px;" for='password_box'>Password</label>
                                <input class='thTextbox' type='password' name='password_box' value='<?php echo $this->_tpl_vars['password_box']; ?>
' style="width:155px;" /><br/>
                            </span>
                        </div>
                        <div>
                            <span>
                                <label style="float:left;width:65px;" for='provider_box'>Provider</label>
                                <select class='thSelect' name='provider_box' style="width:155px;" />
                                    <option value=''></option>
                                    <?php echo $this->_tpl_vars['options_list']; ?>

                                </select><br /><br />
                            </span>
                        </div>
                        <div>
                            <span style="padding-left:65px; padding-right:20px; width:200px;">
                                <input class='frmbtn' type='submit' name='import' value='Import Contacts' />
                                <input type='hidden' name='step' value='get_contacts' />
                            </span>
                        </div>
                    </fieldset>
                </form>
            <?php endif; ?>
        <?php endif; ?>
</div>
<?php echo '
<script type="text/javascript">
   
   $(document).ready(function(){      
       $("#frminvitefrnds").validate({
       errorLabelContainer: "#errors",
       wrapper: "p",
           rules:{
               message:{ maxlength: 1000}
           },
           messages:{
               message: {
                   maxlength: "Message can not be more than 1000 characters long"
               }
           }
       });
   });
</script>
'; ?>