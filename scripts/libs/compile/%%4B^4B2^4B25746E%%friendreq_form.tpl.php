<?php /* Smarty version 2.6.26, created on 2010-01-21 22:53:16
         compiled from friendreq_form.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'capitalize', 'friendreq_form.tpl', 11, false),)), $this); ?>
<?php echo '
<script type="text/javascript">
   $(document).ready(function(){
       $("#errors").hide();
   });
</script>
'; ?>

<div style="width:730px;">
    <div id="errors"></div>
     
    <div class="subtitle">You are about to add <a href='<?php echo @URL; ?>
/profile/view/<?php echo $this->_tpl_vars['prof']['id']; ?>
'><?php echo ((is_array($_tmp=$this->_tpl_vars['prof']['name'])) ? $this->_run_mod_handler('capitalize', true, $_tmp) : smarty_modifier_capitalize($_tmp)); ?>
</a> as your friend !</div>
    
    <form id="frmfreq" method="post" action="<?php echo @URL; ?>
/friendrequest.php">
        <fieldset title="Friend Request">
            <div>
                <span><h3><?php echo $this->_tpl_vars['prof']['name']; ?>
 will have to confirm that you are friends.</h3></span>
            </div>
            <div>
                <span align="left">
                    <input type="submit" name="submit" id="button" value="Send Request" class="frmbtn"/>
                    <a href="<?php echo @URL; ?>
/home">Cancel</a>
                    <input type="hidden" name="email" id="email" size="30" value="<?php echo $this->_tpl_vars['email']; ?>
"/>
                    <input type="hidden" name="f_email" id="f_email"  value="<?php echo $this->_tpl_vars['prof']['user_email']; ?>
"/>
                </span>
            </div>
            <div>
                <span>
                    <div style="float:left; width: 200px;">
                        <label for="cont">Message: (optional)</label>
                    </div>
                    <textarea  name="cont" id="c" rows="2" cols="110" ></textarea>
                     <div class="subinfo">Maximum 100 characters</div>
                </span>
            </div>            
        </fieldset>
    </form>
</div>
<?php echo '
<script type="text/javascript">
   
   $(document).ready(function(){      
       $("#frmfreq").validate({
       errorLabelContainer: "#errors",
       wrapper: "p",
           rules:{
               cont:{ maxlength: 100},
           },
           messages:{
               cont: {
                   maxlength: "Message can not be more than 100 characters long"
               }
           }
       });
   });
</script>
'; ?>