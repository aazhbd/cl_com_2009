<?php /* Smarty version 2.6.26, created on 2010-02-05 04:52:20
         compiled from view_mem.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'view_mem.tpl', 17, false),)), $this); ?>
<div style="float:left; width:730px;">
    <div>
        <img src="<?php echo @URL; ?>
/getimage.php?id=<?php echo $this->_tpl_vars['club']['image_id']; ?>
" width="80" alt="<?php echo $this->_tpl_vars['club']['name']; ?>
, conveylive.com, club" />
        <a href="<?php echo @URL; ?>
/clubs/view/<?php echo $this->_tpl_vars['club']['id']; ?>
">Back to Club</a>
    </div>
    
    <?php $_from = $this->_tpl_vars['members']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['member']):
?>
    <div class="artcont">
        
        <?php if ($this->_tpl_vars['member']['pid'] == null): ?>
            <div class="entry" style="width:20%;"><img src="<?php echo @URL; ?>
/getsmimage.php?id=<?php echo $this->_tpl_vars['member']['user_imgs_id']; ?>
" alt="<?php echo $this->_tpl_vars['club']['cname']; ?>
,<?php echo $this->_tpl_vars['member']['f_name']; ?>
, <?php echo $this->_tpl_vars['member']['f_name']; ?>
, conveylive" width="80" border="1" /></div>
            <div class="entry" style="width:40%;"><h3><?php echo $this->_tpl_vars['member']['f_name']; ?>
 <?php echo $this->_tpl_vars['member']['l_name']; ?>
</h3>
        <?php else: ?>
            <div class="entry" style="width:20%;"><a href="<?php echo @URL; ?>
/profile/view/<?php echo $this->_tpl_vars['member']['pid']; ?>
" ><img src="<?php echo @URL; ?>
/getsmimage.php?id=<?php echo $this->_tpl_vars['member']['user_imgs_id']; ?>
" alt="<?php echo $this->_tpl_vars['club']['name']; ?>
,<?php echo $this->_tpl_vars['member']['f_name']; ?>
, <?php echo $this->_tpl_vars['member']['f_name']; ?>
, conveylive" height="80" border="1" /></a></div>
            <div class="entry" style="width:40%;"><h3><a href="<?php echo @URL; ?>
/profile/view/<?php echo $this->_tpl_vars['member']['pid']; ?>
" ><?php echo $this->_tpl_vars['member']['f_name']; ?>
 <?php echo $this->_tpl_vars['member']['l_name']; ?>
</a></h3>
        <?php endif; ?>
            <br/>Joined: <?php echo ((is_array($_tmp=$this->_tpl_vars['member']['join_date'])) ? $this->_run_mod_handler('date_format', true, $_tmp) : smarty_modifier_date_format($_tmp)); ?>

            <br/>Designation: <?php echo $this->_tpl_vars['member']['rank']; ?>

        </div>
        <div class="entry" style="width:30%;">
            <?php if ($this->_tpl_vars['is_creator'] == true && $this->_tpl_vars['member']['rank'] == 'Creator'): ?>
                <a href="<?php echo @URL; ?>
/clubs/deletemember/<?php echo $this->_tpl_vars['club']['id']; ?>
/<?php echo $this->_tpl_vars['member']['id']; ?>
">Remove Member</a>
            <?php elseif ($this->_tpl_vars['is_creator'] == false && $this->_tpl_vars['member']['rank'] == 'Creator'): ?>
            <?php elseif ($this->_tpl_vars['member']['rank'] == 'General Member'): ?>
                
            <?php elseif ($this->_tpl_vars['member']['rank'] == 'Admin'): ?>
                <a href="<?php echo @URL; ?>
/clubs/deletemember/<?php echo $this->_tpl_vars['club']['id']; ?>
/<?php echo $this->_tpl_vars['member']['id']; ?>
">Remove Member</a>
                <br/><a href="<?php echo @URL; ?>
/clubs/demotemember/<?php echo $this->_tpl_vars['club']['id']; ?>
/<?php echo $this->_tpl_vars['member']['id']; ?>
">Remove from Club Admin</a>
            <?php endif; ?>
            
        </div>
    </div>
    <?php endforeach; endif; unset($_from); ?>
</div>