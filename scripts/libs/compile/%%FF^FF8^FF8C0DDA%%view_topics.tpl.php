<?php /* Smarty version 2.6.26, created on 2010-01-26 16:11:59
         compiled from view_topics.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'view_topics.tpl', 19, false),)), $this); ?>
<div style="float:left; width:730px;">
    <div>
        <img src="<?php echo @URL; ?>
/getimage.php?id=<?php echo $this->_tpl_vars['club']['image_id']; ?>
" width="80" alt="<?php echo $this->_tpl_vars['club']['name']; ?>
, conveylive.com, club" />
        <a href="<?php echo @URL; ?>
/clubs/newtopic/<?php echo $this->_tpl_vars['club']['id']; ?>
">Post New Topic</a>&nbsp;|&nbsp;<a href="<?php echo @URL; ?>
/clubs/view/<?php echo $this->_tpl_vars['club']['id']; ?>
">Back to Club</a>
    </div>
        <br />
    <?php $_from = $this->_tpl_vars['posts']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['post']):
?>
    <div class="artcont">
        
        <?php if ($this->_tpl_vars['post']['pid'] == null): ?>
            <div class="entry" style="width:20%;"><img src="<?php echo @URL; ?>
/getsmimage.php?id=<?php echo $this->_tpl_vars['post']['user_imgs_id']; ?>
" alt="<?php echo $this->_tpl_vars['club']['name']; ?>
,<?php echo $this->_tpl_vars['post']['f_name']; ?>
, <?php echo $this->_tpl_vars['post']['f_name']; ?>
, conveylive" width="80" border="1" /></div>
            <div class="entry" style="width:40%;"><h3><?php echo $this->_tpl_vars['post']['title']; ?>
</h3>
        <?php else: ?>
            <div class="entry" style="width:20%;"><a href="<?php echo @URL; ?>
/profile/view/<?php echo $this->_tpl_vars['post']['pid']; ?>
" ><img src="<?php echo @URL; ?>
/getsmimage.php?id=<?php echo $this->_tpl_vars['post']['user_imgs_id']; ?>
" alt="<?php echo $this->_tpl_vars['club']['cname']; ?>
,<?php echo $this->_tpl_vars['post']['f_name']; ?>
, <?php echo $this->_tpl_vars['post']['f_name']; ?>
, conveylive" width="80" border="1" /></a></div>
            <div class="entry" style="width:40%;"><h3><a href="<?php echo @URL; ?>
/clubs/viewpost/<?php echo $this->_tpl_vars['post']['post_id']; ?>
" ><?php echo $this->_tpl_vars['post']['title']; ?>
</a></h3>
        <?php endif; ?>
            <br/>By: <a href="<?php echo @URL; ?>
/profile/view/<?php echo $this->_tpl_vars['post']['pid']; ?>
"><?php echo $this->_tpl_vars['post']['f_name']; ?>
 <?php echo $this->_tpl_vars['post']['l_name']; ?>
</a>
            <br/>Posted On: <?php echo ((is_array($_tmp=$this->_tpl_vars['post']['ins_date'])) ? $this->_run_mod_handler('date_format', true, $_tmp) : smarty_modifier_date_format($_tmp)); ?>

        </div>
    </div>
    <?php endforeach; else: ?>
        <div class="artcont">There are no topics in this club</div>
    <?php endif; unset($_from); ?>
</div>