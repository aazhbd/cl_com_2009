<?php /* Smarty version 2.6.26, created on 2010-02-15 11:38:43
         compiled from photocmt_form.tpl */ ?>
<div style="float:left; width:730px;">
    <?php if ($this->_tpl_vars['coms'] != null): ?><h3><img src="<?php echo @URL; ?>
/interface/icos/comments.png" style="width:30px;" />Comments on this photo</h3><?php endif; ?>
    <div id="comlist">
        <?php if ($this->_tpl_vars['coms'] != null): ?>
            <br />
            <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "comment_view.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
        <?php endif; ?>
    </div>
    <?php if ($this->_tpl_vars['islogin'] == true): ?>
    <div>
        <?php $this->assign('mid', $this->_tpl_vars['media_id']); ?>
        <?php $this->assign('mtype', 'Picture'); ?>
        
        <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'frm_comment.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
    </div>
    <?php endif; ?>
    <br />
</div>