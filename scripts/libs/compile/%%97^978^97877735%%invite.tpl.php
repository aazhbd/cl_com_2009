<?php /* Smarty version 2.6.26, created on 2010-01-14 04:01:44
         compiled from invite.tpl */ ?>
<div style="float:left; width:270px;">
    <form action='<?php echo @URL; ?>
/invite.php' method='POST' name='openinviter'>
        <fieldset style="width:270px;">
            <legend style="width:200px;">Invite Your Friends</legend>
            <input type='hidden' name='uemail_id' value='<?php echo $this->_tpl_vars['uemail_id']; ?>
' />
            <?php echo $this->_tpl_vars['ers']; ?>
<?php echo $this->_tpl_vars['oks']; ?>

            <?php if ($this->_tpl_vars['done'] != true): ?>
                <?php if ($this->_tpl_vars['step'] == 'get_contacts'): ?>
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
                <?php endif; ?>
            <?php endif; ?>
        </fieldset>
    </form>
</div>