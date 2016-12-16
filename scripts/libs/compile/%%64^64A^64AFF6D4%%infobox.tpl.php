<?php /* Smarty version 2.6.26, created on 2010-01-26 08:36:18
         compiled from subtpl/infobox.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'truncate', 'subtpl/infobox.tpl', 8, false),)), $this); ?>
<?php if ($this->_tpl_vars['viewContList'] != null): ?>
<div class="box" style="margin-top:5px;">
    <h3>Most Viewed <?php echo $this->_tpl_vars['viewContTitle']; ?>
 this month</h3>
    <div class="sideCont">
        <div class="contName">
            <ul>
                <?php $_from = $this->_tpl_vars['viewContList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['cont']):
?>
                    <li class="listItem"><a href="<?php echo @URL; ?>
/<?php echo $this->_tpl_vars['cont']['contURL']; ?>
"><?php echo ((is_array($_tmp=$this->_tpl_vars['cont']['title'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 26, "...", true) : smarty_modifier_truncate($_tmp, 26, "...", true)); ?>
</a></li>
                <?php endforeach; endif; unset($_from); ?>
            </ul>
        </div>
    </div>
    <a href="<?php echo @URL; ?>
/<?php echo $this->_tpl_vars['viewBrowselink']; ?>
"><h3><?php echo $this->_tpl_vars['viewContTitle']; ?>
 for all time</h3></a>
</div>
<?php endif; ?>
<?php if ($this->_tpl_vars['latContList'] != null): ?>
<div class="box" style="margin-top:5px;">
    <h3>Latest <?php echo $this->_tpl_vars['latContTitle']; ?>
</h3>
    <div class="sideCont">
        <div class="contName">
            <ul>
                <?php $_from = $this->_tpl_vars['latContList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['cont']):
?>
                    <li class="listItem"><a href="<?php echo @URL; ?>
/<?php echo $this->_tpl_vars['cont']['contURL']; ?>
"><?php echo ((is_array($_tmp=$this->_tpl_vars['cont']['title'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 26, "...", true) : smarty_modifier_truncate($_tmp, 26, "...", true)); ?>
</a></li>
                <?php endforeach; endif; unset($_from); ?>
            </ul>
        </div>
    </div>
    <a href="<?php echo @URL; ?>
/<?php echo $this->_tpl_vars['latBrowselink']; ?>
"><h3><?php echo $this->_tpl_vars['latContTitle']; ?>
 for all time</h3></a>
</div>
<?php endif; ?>
<?php if ($this->_tpl_vars['topContList'] != null): ?>
<div class="box" style="margin-top:5px;">
    <h3>Top Rated <?php echo $this->_tpl_vars['topContTitle']; ?>
 this month</h3>
    <div class="sideCont">
        <div class="contName">
            <ul>
                <?php $_from = $this->_tpl_vars['topContList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['cont']):
?>
                    <li class="listItem"><a href="<?php echo @URL; ?>
/<?php echo $this->_tpl_vars['cont']['contURL']; ?>
"><?php echo ((is_array($_tmp=$this->_tpl_vars['cont']['title'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 26, "...", true) : smarty_modifier_truncate($_tmp, 26, "...", true)); ?>
</a></li>
                <?php endforeach; endif; unset($_from); ?>
            </ul>
        </div>
    </div>
    <a href="<?php echo @URL; ?>
/<?php echo $this->_tpl_vars['topBrowselink']; ?>
"><h3><?php echo $this->_tpl_vars['topContTitle']; ?>
 for all time</h3></a>
</div>
<?php endif; ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "subtpl/email_invite.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>