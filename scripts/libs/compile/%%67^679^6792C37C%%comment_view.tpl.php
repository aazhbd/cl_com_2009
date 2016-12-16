<?php /* Smarty version 2.6.26, created on 2010-07-03 01:17:28
         compiled from comment_view.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'comment_view.tpl', 13, false),array('modifier', 'strip_tags', 'comment_view.tpl', 26, false),)), $this); ?>
<?php if ($this->_tpl_vars['coms'] != null): ?>    
    <?php $_from = $this->_tpl_vars['coms']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['com']):
?>
        <div class="combox">
            <?php if ($this->_tpl_vars['com']['pid'] != null): ?>
                <div style="float:left; width:50px;">
                    <a href="<?php echo @URL; ?>
/profile/view/<?php echo $this->_tpl_vars['com']['pid']; ?>
"><img src="<?php echo @URL; ?>
/getsmimage.php?id=<?php echo $this->_tpl_vars['com']['user_imgs_id']; ?>
" alt="<?php echo $this->_tpl_vars['com']['f_name']; ?>
, <?php echo $this->_tpl_vars['com']['l_name']; ?>
 , ConveyLive.com, Photos, Picture, Album" height="40" /></a>
                </div>
                <div style="float:left; width:85%; padding:5px; text-align: justify;">
                    <p>
                        <strong><a href="<?php echo @URL; ?>
/profile/view/<?php echo $this->_tpl_vars['com']['pid']; ?>
"><?php echo $this->_tpl_vars['com']['f_name']; ?>
 <?php echo $this->_tpl_vars['com']['l_name']; ?>
 </a></strong> : <?php echo $this->_tpl_vars['com']['comment']; ?>
 
                    </p>
                    <span class="subinfo">
                        <?php echo ((is_array($_tmp=$this->_tpl_vars['com']['ins_date'])) ? $this->_run_mod_handler('date_format', true, $_tmp) : smarty_modifier_date_format($_tmp)); ?>
 at <?php echo ((is_array($_tmp=$this->_tpl_vars['com']['ins_date'])) ? $this->_run_mod_handler('date_format', true, $_tmp, '%I:%M %p, %A') : smarty_modifier_date_format($_tmp, '%I:%M %p, %A')); ?>
 &nbsp;
                    </span>
                </div>
            <?php else: ?>
                <div style="float:left; width:50px;">
                    <img src="<?php echo @URL; ?>
/getsmimage.php?id=0" alt="<?php echo $this->_tpl_vars['com']['f_name']; ?>
, <?php echo $this->_tpl_vars['com']['l_name']; ?>
 , ConveyLive.com, Photos, Picture, Album" height="40" />
                </div>
                <div style="float:left; width:85%; padding:5px; text-align: justify;">
                    <p>
                        <strong><?php echo $this->_tpl_vars['com']['f_name']; ?>
 <?php echo $this->_tpl_vars['com']['l_name']; ?>
 </strong> : <?php echo ((is_array($_tmp=$this->_tpl_vars['com']['comment'])) ? $this->_run_mod_handler('strip_tags', true, $_tmp, false) : smarty_modifier_strip_tags($_tmp, false)); ?>
 
                    </p>

                    <span class="subinfo">
                        <?php echo ((is_array($_tmp=$this->_tpl_vars['com']['ins_date'])) ? $this->_run_mod_handler('date_format', true, $_tmp) : smarty_modifier_date_format($_tmp)); ?>
 at <?php echo ((is_array($_tmp=$this->_tpl_vars['com']['ins_date'])) ? $this->_run_mod_handler('date_format', true, $_tmp, '%I:%M %p, %A') : smarty_modifier_date_format($_tmp, '%I:%M %p, %A')); ?>
 &nbsp;
                    </span>
                </div>
            <?php endif; ?>
        </div>
        <br/>
    <?php endforeach; endif; unset($_from); ?>
<?php endif; ?>