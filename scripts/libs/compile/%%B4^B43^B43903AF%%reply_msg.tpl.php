<?php /* Smarty version 2.6.26, created on 2010-02-06 04:51:14
         compiled from reply_msg.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'default', 'reply_msg.tpl', 79, false),array('modifier', 'date_format', 'reply_msg.tpl', 92, false),)), $this); ?>
<?php echo '
<script type="text/javascript">
$(document).ready(function(){
    $(\'a.msgdel\').click(function(){
       var link = $(this).attr(\'href\');
        jConfirm(\'Are you sure you want to delete this message?\', \'Confirmation Dialog\', function(r) {
            if(r == true){
                window.location.href = link;
            }
            else{
                return false;
            }
        });
        return false;
    });
});

</script>
'; ?>

<div style="float:left;width:740px;">
    <div id="errors"></div>
        
    <div style="float:left;width:100%;">
        <span align="left"><h3>
        <a href="<?php echo @URL; ?>
/message/inbox"><img src="<?php echo @URL; ?>
/interface/icos/mail_receive.png" style="width:20px;"/>Inbox</a>&nbsp;&nbsp;&nbsp;
        <a href="<?php echo @URL; ?>
/message/sentmessages"><img src="<?php echo @URL; ?>
/interface/icos/mail_send.png"  style="width:20px;" />Sent Messages</a>&nbsp;&nbsp;&nbsp;
        <a href="<?php echo @URL; ?>
/message/new"><img src="<?php echo @URL; ?>
/interface/icos/mail_new.png"  style="width:20px;" />New Message</a>&nbsp;&nbsp;&nbsp;
        </h3></span>
    </div>
    <br />
    <div style="float:left;width:740px;margin-top:10px;">

        <form name="frmnewmsg" id="frmnewmsg" method="post" action="<?php echo @URL; ?>
/newmessage.php">
            <fieldset>
                <legend>Write a reply</legend>
                <div>
                    <span>
                        <div style='float:left; width:80px;'><label>To:</label></div>
                        <input type="text" name="to" id="fname" value="<?php echo $this->_tpl_vars['fname']; ?>
" style="width:566px;color:black; background:#eee;font-weight:bold;"  disabled="disabled"/>
                    </span>
                </div>
                <div>
                    <span>
                        <div style='float:left; width:80px;'><label>Subject:</label></div>
                        <input type="text" name="subj" id="subj" style="width:566px;" value="<?php if ($this->_tpl_vars['msg']['subj'] != ""): ?>Reply: <?php echo $this->_tpl_vars['msg']['subj']; ?>
 <?php else: ?> <?php endif; ?>"/>
                    </span>
                </div>
                <div>
                    <span>
                        <div style='float:left; width:80px;'><label for="cont">Message:</label></div>
                        <textarea  name="cont" id="cont" ></textarea>
                    </span>
                </div>
                <div>
                    <span>
                        <div style='float:left; width:80px;'><label>&nbsp;</label></div>
                        <input type="submit" name="submit" id="button" value="Send" class="frmbtn"/>
                        <input type="reset" name="reset" id="button" value="Clear" class="frmbtn"/>
                        <input type="hidden" name="email" id="email" size="30" value="<?php echo $this->_tpl_vars['email']; ?>
"/>
                        <input type="hidden" name="privacy_type" id="privacy_type" value="private" />
                        <input type="hidden" name="sender_type" id="sender_type" value="people" />
                        <input type="hidden" name="cont_id" id="cont_id" value="<?php echo $this->_tpl_vars['uid']; ?>
" />
                        <input type="hidden" name="fid" id="fid" value="<?php echo $this->_tpl_vars['fid']; ?>
" />
                        <input type="hidden" name="cont_type" id="cont_type" value="users" />
                    </span>
                </div>
            </fieldset>
        </form>
    </div>
</div>

<div style="float:left; width:740px;margin-top:10px;">
    <div id="viewmsg">
        <div>
            <span>
                <?php if ($this->_tpl_vars['boxtype'] == 'inbox'): ?>
                    <div style="float:left; width:80px;"><strong>From:</strong></div>
                    <div width="85"><?php echo ((is_array($_tmp=@$this->_tpl_vars['msg']['sndr_name'])) ? $this->_run_mod_handler('default', true, $_tmp, 'Club') : smarty_modifier_default($_tmp, 'Club')); ?>
</div>
                <?php elseif ($this->_tpl_vars['boxtype'] == 'sentbox'): ?>
                    <div style="float:left; width:80px;"><strong>Receiver:</strong></div>
                    <div width="85"><?php echo $this->_tpl_vars['msg']['rcvr_name']; ?>
</div>
                <?php endif; ?>
            </span>
        </div>
        <div>
            <span>&nbsp;</span>
        </div>
        <div>
            <span>
                <div style="float:left; width:80px;"><strong>Date:</strong></div>
                <div width="85"><?php echo ((is_array($_tmp=$this->_tpl_vars['msg']['ins_date'])) ? $this->_run_mod_handler('date_format', true, $_tmp, '%A, %B %e, %Y') : smarty_modifier_date_format($_tmp, '%A, %B %e, %Y')); ?>
 <?php echo ((is_array($_tmp=$this->_tpl_vars['msg']['ins_date'])) ? $this->_run_mod_handler('date_format', true, $_tmp, '%I:%M %p') : smarty_modifier_date_format($_tmp, '%I:%M %p')); ?>
</div>
            </span>
        </div>
        <div>
            <span>&nbsp;</span>
        </div>
        <div>
            <span>&nbsp;</span>
        </div>
        <div>
            <span>
                <div style="float:left; width:630px;"><strong><img src="<?php echo @URL; ?>
/interface/icos/mail.png" />Message:</strong>&nbsp;&nbsp;</div>
                <?php if ($this->_tpl_vars['boxtype'] == 'inbox'): ?> <div style="float:left;"><a href="<?php echo @URL; ?>
/message/delete/inbox/<?php echo $this->_tpl_vars['msg']['id']; ?>
" class="msgdel" ><img src="<?php echo @URL; ?>
/interface/icos/mail_remove.png"  style="width:20px;" />Delete</a></div>
                
                <?php elseif ($this->_tpl_vars['boxtype'] == 'sentbox'): ?> <div style="float:left;"><a href="<?php echo @URL; ?>
/message/delete/inbox/<?php echo $this->_tpl_vars['msg']['id']; ?>
" class="msgdel" ><img src="<?php echo @URL; ?>
/interface/icos/mail_remove.png"  style="width:20px;" />Delete</a></div>
                <?php endif; ?>
            </span>
            <div id="cont"><br/><?php echo $this->_tpl_vars['msg']['content']; ?>
</div>
        </div>
        <div>
            <span>&nbsp;</span>
        </div>
        <div style="float:left;">
            <span align="left"><h3>
            <?php if ($this->_tpl_vars['boxtype'] == 'inbox'): ?>
                <a href="<?php echo @URL; ?>
/message/delete/inbox/<?php echo $this->_tpl_vars['msg']['id']; ?>
" class="msgdel"><img src="<?php echo @URL; ?>
/interface/icos/mail_remove.png"  style="width:20px;" />Delete</a>&nbsp;&nbsp;&nbsp;
            <?php elseif ($this->_tpl_vars['boxtype'] == 'sentbox'): ?>
                <a href="<?php echo @URL; ?>
/message/delete/sentbox/<?php echo $this->_tpl_vars['msg']['id']; ?>
" class="msgdel"><img src="<?php echo @URL; ?>
/interface/icos/mail_remove.png"  style="width:20px;" />Delete</a>&nbsp;&nbsp;&nbsp;
            <?php endif; ?>
            </h3></span>
        </div>
        <div style="float:right;">
            <span align="left"><h3>
            <a href="<?php echo @URL; ?>
/message/inbox"><img src="<?php echo @URL; ?>
/interface/icos/mail_receive.png" style="width:20px;"/>Inbox</a>&nbsp;&nbsp;&nbsp;
            <a href="<?php echo @URL; ?>
/message/sentmessages"><img src="<?php echo @URL; ?>
/interface/icos/mail_send.png"  style="width:20px;" />Sent Messages</a>&nbsp;&nbsp;&nbsp;
            <a href="<?php echo @URL; ?>
/message/new"><img src="<?php echo @URL; ?>
/interface/icos/mail_new.png"  style="width:20px;" />New Message</a>&nbsp;&nbsp;&nbsp;
            </h3></span>
        </div>
    </div>
</div>
<?php echo '
<script type="text/javascript">
   $(document).ready(function(){      
       $("#errors").hide();
       $("#frmnewmsg").validate({
       errorLabelContainer: "#errors",
       wrapper: "p",
           rules:{
               to:{ required: true, maxlength: 2500},
               subj:{ maxlength: 80 },
               cont:{ minlength: 1 , maxlength: 3000}
           },
           messages:{
               to: {
                   required: "You must specify at least one recipient for this message.",
                   maxlength: "The \'To\' field can not be more than 2500 characters"
               },
               subj: {
                    maxlength: "The \'Subject\' field can not be more than 80 characters"
               },
               cont: {
                   //required: "You can not send an empty message.",
                   minlength: "You can not send an empty message.",
                   maxlength: "Content can not be more than 3000 characters long"
               }
           }
       });
   });
</script>
'; ?>


<?php echo '
    <script type="text/javascript">
        tinyMCE.init({
            mode : "exact",
            elements : "cont",
            theme : "advanced",
            skin : "o2k7",
            width : 570,
            height : 300,
            skin_variant : "silver",
            plugins : "safari,spellchecker,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template",        
            theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,undo, redo,|,link,unlink,anchor,|,forecolor,backcolor,|,charmap,emotions,|,bullist,numlist",
            theme_advanced_buttons2 : "",
            theme_advanced_buttons3 :  "", 
            theme_advanced_toolbar_location : "top",
            theme_advanced_toolbar_align : "left",
            theme_advanced_statusbar_location : "bottom",
            plugin_insertdate_dateFormat : "%Y-%m-%d",
            plugin_insertdate_timeFormat : "%H:%M:%S",
            extended_valid_elements : "hr[class|width|size|noshade]",
            paste_use_dialog : false,
            theme_advanced_resizing : false,
            theme_advanced_link_targets : "_something=My somthing;_something2=My somthing2;_something3=My somthing3;",
            apply_source_formatting : true
        });
    </script>
'; ?>