<?php /* Smarty version 2.6.26, created on 2010-01-17 00:27:59
         compiled from msg_view.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'msg_view.tpl', 28, false),)), $this); ?>
<div style="float:left; width:740px;">
         
    <div style="float:left;">
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
    <div id="viewmsg">
        <div>
            <span>
                <?php if ($this->_tpl_vars['boxtype'] == 'inbox'): ?>
                    <div style="float:left; width:80px;"><strong>From:</strong></div>
                    <div width="85"><?php echo $this->_tpl_vars['msg']['sndr_name']; ?>
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
            <div id="cont"><br/> <?php echo $this->_tpl_vars['msg']['content']; ?>
</div>
        </div>
        <div>
            <span>&nbsp;</span>
        </div>
        <div style="float:left;">
            <span align="left"><h3>
            <?php if ($this->_tpl_vars['boxtype'] == 'inbox'): ?>
                <a href="<?php echo @URL; ?>
/message/reply/inbox/<?php echo $this->_tpl_vars['msg']['id']; ?>
"><img src="<?php echo @URL; ?>
/interface/icos/mail_reply.png"  style="width:20px;" />Reply</a>&nbsp;&nbsp;&nbsp;
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
    })
});

</script>
'; ?>