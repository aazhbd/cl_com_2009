<?php /* Smarty version 2.6.26, created on 2010-01-31 01:08:24
         compiled from accedit_view.tpl */ ?>
<?php echo '
<script type="text/javascript">
   $(document).ready(function(){
       $("#errors").hide();
   });
</script>
'; ?>

<div style="width:740px;">
<div id="errors"></div>
<div id="pginfo">
    You may change your conveylive account settings from here. You can change you name, password, birthdate or sex.
</div>
 
<form id="frmaccedit" method="post" action="<?php echo @URL; ?>
/editaccount.php">
    <fieldset title="Account Settings">
        <legend><b>Change account info and click save button!</b></legend>
            <div>
                <span>
                    <div style="float:left; width:120px;"><label for="fname">First Name:</label></div>
                    <input type="text" name="fname" id="fname" size="20" value="<?php echo $this->_tpl_vars['data']['f_name']; ?>
" />
                </span>
                <span>
                    <div style="float:left; margin-left:20px; width:120px;"><label for="lname">Last Name:</label></div>
                    <input type="text" name="lname" id="lname" size="20" value="<?php echo $this->_tpl_vars['data']['l_name']; ?>
"/>
                    
                </span>
            </div>
            <div>
                <span>
                    <div style="float:left; width:120px;"><label for="password_old">Old Password:</label></div>
                    <input type="password" name="password_old" id="password_old" size="20" />
                </span>
            </div>
            <div>
                <span>
                    <div style="float:left; width:120px;"><label for="password_new">New Password:</label></div>
                    <input type="password" name="password_new" id="password_new" size="20" />
                </span>
                <span>
                    <div style="float:left; margin-left:20px; width:120px;"><label for="rpass">Re-Type:</label></div>
                    <input type="password" name="rpass" id="rpass" size="20" />
                </span>
            </div>
            <div>
                <span>
                    <div style="float:left; width:120px;"><label for="sex">Sex: </label></div>
                    <select name="sex" id="sex" >
                        <?php if ($this->_tpl_vars['data']['gender'] == 'm'): ?>
                        <option value="m" selected="selected">Male</option>
                        <option value="f" >Female</option>
                        <?php else: ?>
                        <option value="m" >Male</option>
                        <option value="f" selected="selected">Female</option>
                        <?php endif; ?>
                    </select>
                </span>
                <span>
                    <div style="margin-left:95px;float:left; width:120px;"><label>Birth Date: </label></div>
                        <Label>Day</label>
                        <select name="day">
                            <?php unset($this->_sections['d']);
$this->_sections['d']['name'] = 'd';
$this->_sections['d']['start'] = (int)1;
$this->_sections['d']['loop'] = is_array($_loop=32) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['d']['step'] = ((int)1) == 0 ? 1 : (int)1;
$this->_sections['d']['show'] = true;
$this->_sections['d']['max'] = $this->_sections['d']['loop'];
if ($this->_sections['d']['start'] < 0)
    $this->_sections['d']['start'] = max($this->_sections['d']['step'] > 0 ? 0 : -1, $this->_sections['d']['loop'] + $this->_sections['d']['start']);
else
    $this->_sections['d']['start'] = min($this->_sections['d']['start'], $this->_sections['d']['step'] > 0 ? $this->_sections['d']['loop'] : $this->_sections['d']['loop']-1);
if ($this->_sections['d']['show']) {
    $this->_sections['d']['total'] = min(ceil(($this->_sections['d']['step'] > 0 ? $this->_sections['d']['loop'] - $this->_sections['d']['start'] : $this->_sections['d']['start']+1)/abs($this->_sections['d']['step'])), $this->_sections['d']['max']);
    if ($this->_sections['d']['total'] == 0)
        $this->_sections['d']['show'] = false;
} else
    $this->_sections['d']['total'] = 0;
if ($this->_sections['d']['show']):

            for ($this->_sections['d']['index'] = $this->_sections['d']['start'], $this->_sections['d']['iteration'] = 1;
                 $this->_sections['d']['iteration'] <= $this->_sections['d']['total'];
                 $this->_sections['d']['index'] += $this->_sections['d']['step'], $this->_sections['d']['iteration']++):
$this->_sections['d']['rownum'] = $this->_sections['d']['iteration'];
$this->_sections['d']['index_prev'] = $this->_sections['d']['index'] - $this->_sections['d']['step'];
$this->_sections['d']['index_next'] = $this->_sections['d']['index'] + $this->_sections['d']['step'];
$this->_sections['d']['first']      = ($this->_sections['d']['iteration'] == 1);
$this->_sections['d']['last']       = ($this->_sections['d']['iteration'] == $this->_sections['d']['total']);
?>
                            <?php if ($this->_tpl_vars['data']['day'] == $this->_sections['d']['index']): ?>
                            <option value="<?php echo $this->_sections['d']['index']; ?>
" selected="selected"><?php echo $this->_sections['d']['index']; ?>
</option>
                            <?php else: ?>
                            <option value="<?php echo $this->_sections['d']['index']; ?>
"><?php echo $this->_sections['d']['index']; ?>
</option>
                            <?php endif; ?>
                            <?php endfor; endif; ?>                            
                        </select>-
                        <Label>Month</label>
                        <select name="month">
                            <?php $_from = $this->_tpl_vars['monthList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['m']):
?>
                            <?php if ($this->_tpl_vars['data']['month'] == $this->_tpl_vars['m']): ?>
                            <option value="<?php echo $this->_tpl_vars['k']; ?>
" selected="selected"><?php echo $this->_tpl_vars['m']; ?>
</option>
                            <?php else: ?>
                            <option value="<?php echo $this->_tpl_vars['k']; ?>
"><?php echo $this->_tpl_vars['m']; ?>
</option>
                            <?php endif; ?>
                            <?php endforeach; endif; unset($_from); ?>        
                        </select>-
                        <Label>Year</label>
                        <select name="year">
                            <?php unset($this->_sections['y']);
$this->_sections['y']['name'] = 'y';
$this->_sections['y']['start'] = (int)1950;
$this->_sections['y']['loop'] = is_array($_loop=2051) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['y']['step'] = ((int)1) == 0 ? 1 : (int)1;
$this->_sections['y']['show'] = true;
$this->_sections['y']['max'] = $this->_sections['y']['loop'];
if ($this->_sections['y']['start'] < 0)
    $this->_sections['y']['start'] = max($this->_sections['y']['step'] > 0 ? 0 : -1, $this->_sections['y']['loop'] + $this->_sections['y']['start']);
else
    $this->_sections['y']['start'] = min($this->_sections['y']['start'], $this->_sections['y']['step'] > 0 ? $this->_sections['y']['loop'] : $this->_sections['y']['loop']-1);
if ($this->_sections['y']['show']) {
    $this->_sections['y']['total'] = min(ceil(($this->_sections['y']['step'] > 0 ? $this->_sections['y']['loop'] - $this->_sections['y']['start'] : $this->_sections['y']['start']+1)/abs($this->_sections['y']['step'])), $this->_sections['y']['max']);
    if ($this->_sections['y']['total'] == 0)
        $this->_sections['y']['show'] = false;
} else
    $this->_sections['y']['total'] = 0;
if ($this->_sections['y']['show']):

            for ($this->_sections['y']['index'] = $this->_sections['y']['start'], $this->_sections['y']['iteration'] = 1;
                 $this->_sections['y']['iteration'] <= $this->_sections['y']['total'];
                 $this->_sections['y']['index'] += $this->_sections['y']['step'], $this->_sections['y']['iteration']++):
$this->_sections['y']['rownum'] = $this->_sections['y']['iteration'];
$this->_sections['y']['index_prev'] = $this->_sections['y']['index'] - $this->_sections['y']['step'];
$this->_sections['y']['index_next'] = $this->_sections['y']['index'] + $this->_sections['y']['step'];
$this->_sections['y']['first']      = ($this->_sections['y']['iteration'] == 1);
$this->_sections['y']['last']       = ($this->_sections['y']['iteration'] == $this->_sections['y']['total']);
?>
                            <?php if ($this->_tpl_vars['data']['year'] == $this->_sections['y']['index']): ?>
                            <option value="<?php echo $this->_sections['y']['index']; ?>
" selected="selected"><?php echo $this->_sections['y']['index']; ?>
</option>
                            <?php else: ?>
                            <option value="<?php echo $this->_sections['y']['index']; ?>
"><?php echo $this->_sections['y']['index']; ?>
</option>
                            <?php endif; ?>
                            <?php endfor; endif; ?>        
                        </select>
                </span>
            </div>
            <div>
                <span align="left"><h3>
                <input type="submit" name="submit" id="button" value="Save" class="frmbtn"/>
                <input type="reset" name="reset" id="button" value="Clear" class="frmbtn"/>
                <input type="hidden" name="email" id="email" size="30" value="<?php echo $this->_tpl_vars['data']['email']; ?>
"/>
                </h3></span>
            </div>
    </fieldset>
</form>
</div>
<?php echo '
<script type="text/javascript">
   
   $(document).ready(function(){      
       $("#frmaccedit").validate({
       errorLabelContainer: "#errors",
       wrapper: "p",
           rules:{
               fname:{ required: true, maxlength: 50 , minlength: 1 },
               lname:{ required: true, maxlength: 50 ,  minlength: 1},
               password_new:{ minlength: 5 , maxlength: 20},
               rpass:{ minlength: 5, maxlength: 20, equalTo: "#password_new" }
           },
           messages:{
               fname: {
                   required: "Your first name is blank. Please type your first name",
                   maxlength: "First name can not be more than 50 characters long",
                   minlength: "First name can not be blank."
               },
               lname: {
                   required: "Your last name is blank. Please type your last name",
                   maxlength: "Last name can not be more than 50 characters long.",
                   minlength: "Last name can not be blank."
               },
               password_new: {
                   minlength: "Please enter a minimum 5 character new password.",
                   maxlength: "New password can not be more than 20 characters long."
               },
               rpass: {
                   equalTo: "Your re-typed password does not match the new password you entered.",
                   minlength: "Password must be at laest 5 characters long",
                   maxlength: "Password can not be more than 20 characters long"
               }
           }
       });
   });
</script>
'; ?>