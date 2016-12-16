<?php /* Smarty version 2.6.26, created on 2010-01-15 05:44:55
         compiled from inbox_view.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'paginate_first', 'inbox_view.tpl', 5, false),array('function', 'paginate_prev', 'inbox_view.tpl', 5, false),array('function', 'paginate_middle', 'inbox_view.tpl', 5, false),array('function', 'paginate_next', 'inbox_view.tpl', 5, false),array('function', 'paginate_last', 'inbox_view.tpl', 5, false),array('modifier', 'default', 'inbox_view.tpl', 49, false),array('modifier', 'truncate', 'inbox_view.tpl', 57, false),array('modifier', 'date_format', 'inbox_view.tpl', 61, false),)), $this); ?>
<div style="float:left; width:730px;">
        <?php if ($this->_tpl_vars['messages'] != null): ?>
        <div style="float:left; width:530px;">
            <span><?php echo smarty_function_paginate_first(array(), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_prev(array(), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_middle(array('format' => 'page','prefix' => "",'suffix' => "",'link_prefix' => "&nbsp;",'link_suffix' => "&nbsp;"), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_next(array(), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_last(array(), $this);?>
</span>
        </div>
        <div style="float:left;">
            <span>&nbsp;Showing messages <?php echo $this->_tpl_vars['paginate']['first']; ?>
-<?php echo $this->_tpl_vars['paginate']['last']; ?>
 of <?php echo $this->_tpl_vars['paginate']['total']; ?>
 </span>
        </div>
        <br /><br />
        <table class="mailbox">
            <tr style="height:50px;font-weight:bolder;" >
                <td style="background:white;width:100%;">
                    <div style="width:15px;float:left;">&nbsp;</div> 
                    <div style="width:30px;float:left;">&nbsp;</div>
                    <div style="width:60px;float:left;">&nbsp;</div>
                    <div style="width:110px;float:left;"><?php if ($this->_tpl_vars['boxtype'] == 'inbox'): ?>Sender<?php else: ?>Recepient<?php endif; ?></div>
                    <div style="width:250px;float:left;">Subject</div>
                    <div style="width:100px;float:left;">Date</div>
                    <div style="width:80px;float:left;">&nbsp;</div>
                    <div style="width:60px;float:left;">&nbsp;</div>
                </td>
            </tr>
            <?php $this->assign('p', ($this->_tpl_vars['paginate']['page'][$this->_tpl_vars['paginate']['page_current']]['item_start'])); ?>
            <?php $_from = $this->_tpl_vars['messages']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['m'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['m']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['msg']):
        $this->_foreach['m']['iteration']++;
?>
                <tr class="mailtblrow">
                    <td style="width:100%;" 
                    <?php if (!(1 & $this->_foreach['m']['iteration'])): ?>
                    class="evenrow">
                    <?php else: ?>
                    class="oddrow">
                    <?php endif; ?>
                        <?php if ($this->_tpl_vars['msg']['read_stat'] == 2 && $this->_tpl_vars['boxtype'] == 'inbox'): ?>
                            <div style="width:40px;float:left;"><img src="<?php echo @URL; ?>
/interface/icos/read.png" height="15" />&nbsp;<?php echo $this->_tpl_vars['p']; ?>
</div>
                        <?php elseif ($this->_tpl_vars['msg']['read_stat'] == 1 && $this->_tpl_vars['boxtype'] == 'inbox'): ?>
                            <div style="width:40px;float:left;"><img src="<?php echo @URL; ?>
/interface/icos/unread.png" height="15" />&nbsp;<?php echo $this->_tpl_vars['p']; ?>
</div>
                        <?php elseif ($this->_tpl_vars['boxtype'] == 'sentbox'): ?>
                            <div style="width:40px;float:left;"><img src="<?php echo @URL; ?>
/interface/icos/read.png" height="15" />&nbsp;<?php echo $this->_tpl_vars['p']; ?>
</div>
                        <?php endif; ?>
                        
                        <div style="float:left;width:60px;">
                            <?php if ($this->_tpl_vars['msg']['sndr_mail_addr'] != ""): ?>
                                <a href='<?php echo @URL; ?>
/profile/view/<?php echo $this->_tpl_vars['msg']['sndr_pid']; ?>
'><img src="<?php echo @URL; ?>
/getsmimage.php?id=<?php echo $this->_tpl_vars['msg']['sndr_img_id']; ?>
" height="50" border="1" alt="<?php echo $this->_tpl_vars['msg']['sndr_name']; ?>
"/></a>
                            <?php else: ?>
                                <a href='<?php echo @URL; ?>
/profile/view/<?php echo $this->_tpl_vars['msg']['sndr_pid']; ?>
'><img src="<?php echo @URL; ?>
/interface/icos/user.gif" height="50"  border="1" alt="<?php echo $this->_tpl_vars['msg']['sndr_name']; ?>
" /></a>
                            <?php endif; ?>
                        </div>
                        <div style="width:100px;float:left;margin-left:5px; margin-right:10px;" >
                            <a href='<?php echo @URL; ?>
/profile/view/<?php echo $this->_tpl_vars['msg']['sndr_pid']; ?>
'><?php echo ((is_array($_tmp=@$this->_tpl_vars['msg']['sndr_name'])) ? $this->_run_mod_handler('default', true, $_tmp, "<No user>") : smarty_modifier_default($_tmp, "<No user>")); ?>
</a>
                        </div>
                        <?php if ($this->_tpl_vars['boxtype'] == 'inbox'): ?>
                        <a href='<?php echo @URL; ?>
/message/view/inbox/<?php echo $this->_tpl_vars['msg']['id']; ?>
' class="subj">
                            <div style="width:250px;float:left;" >
                                <?php if ($this->_tpl_vars['msg']['subj'] == ""): ?>
                                    < No Subject >
                                <?php else: ?>
                                    <?php echo ((is_array($_tmp=$this->_tpl_vars['msg']['subj'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 50) : smarty_modifier_truncate($_tmp, 50)); ?>

                                <?php endif; ?>
                            </div>
                            <div style="width:100px;float:left;">
                                <?php echo ((is_array($_tmp=$this->_tpl_vars['msg']['ins_date'])) ? $this->_run_mod_handler('date_format', true, $_tmp) : smarty_modifier_date_format($_tmp)); ?>

                            </div>
                        </a>
                        <?php elseif ($this->_tpl_vars['boxtype'] == 'sentbox'): ?>
                            <a href='<?php echo @URL; ?>
/message/view/sentbox/<?php echo $this->_tpl_vars['msg']['id']; ?>
' class="subj">
                                <div style="width:250px;float:left;" >
                                    <?php echo ((is_array($_tmp=@$this->_tpl_vars['msg']['subj'])) ? $this->_run_mod_handler('default', true, $_tmp, '< No Subject >') : smarty_modifier_default($_tmp, '< No Subject >')); ?>

                                </div>
                                <div style="width:100px;float:left;">
                                    <?php echo ((is_array($_tmp=$this->_tpl_vars['msg']['ins_date'])) ? $this->_run_mod_handler('date_format', true, $_tmp) : smarty_modifier_date_format($_tmp)); ?>

                                </div>
                            </a>
                        <?php endif; ?>
                        <div style="width:80px;float:left;">
                        <?php if ($this->_tpl_vars['boxtype'] == 'inbox'): ?> 
                            <a href="<?php echo @URL; ?>
/message/delete/inbox/<?php echo $this->_tpl_vars['msg']['id']; ?>
" class="msgdel" title="Delete Message"><img src="<?php echo @URL; ?>
/interface/icos/mail_remove.png" width="30" alt="Delete Message"/><br />Delete</a>
                        <?php endif; ?>
                        <?php if ($this->_tpl_vars['boxtype'] == 'sentbox'): ?> 
                            <a href="<?php echo @URL; ?>
/message/delete/sentbox/<?php echo $this->_tpl_vars['msg']['id']; ?>
" class="msgdel" title="Delete Message"><img src="<?php echo @URL; ?>
/interface/icos/mail_remove.png" width="30" alt="Delete Message"/><br />Delete</a>
                        <?php endif; ?>
                        </div>
                        <?php if ($this->_tpl_vars['boxtype'] == 'inbox'): ?> 
                            <div style="width:60px;float:left;">
                                <a href="<?php echo @URL; ?>
/message/reply/inbox/<?php echo $this->_tpl_vars['msg']['id']; ?>
" title="Reply"><img src="<?php echo @URL; ?>
/interface/icos/mail_reply.png" width="30" alt="Reply"/><br />Reply</a>
                            </div>
                        <?php endif; ?>
                        <?php $this->assign('p', ($this->_tpl_vars['p']+$this->_tpl_vars['x'])); ?>
                    </td>
                </tr>
            <?php endforeach; endif; unset($_from); ?>
        </table>
        <div><img src="<?php echo @URL; ?>
/interface/icos/unread.png" height="15" />&nbsp; = Mail Unread key Icon </div>
        <div><img src="<?php echo @URL; ?>
/interface/icos/read.png" height="15" />&nbsp; = Mail Read key Icon</div>
        <br />
        <span><?php echo smarty_function_paginate_first(array(), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_prev(array(), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_middle(array('format' => 'page','prefix' => "",'suffix' => "",'link_prefix' => "&nbsp;",'link_suffix' => "&nbsp;"), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_next(array(), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_last(array(), $this);?>
</span>
    <?php else: ?>
        <div id="pginfo" style="background: #ffe; ">
            Your Message Box Is Empty <br /><br />
            <a href="<?php echo @URL; ?>
/message/new"><img src="<?php echo @URL; ?>
/interface/icos/mail_send.png">Send a new message </a>to your friend in conveylive.com
        </div>
    <?php endif; ?>
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
