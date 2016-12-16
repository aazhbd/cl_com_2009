<?php /* Smarty version 2.6.26, created on 2010-01-15 04:14:56
         compiled from friendreq_view.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'friendreq_view.tpl', 13, false),)), $this); ?>
 
<br />
<?php $_from = $this->_tpl_vars['req_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['frnd']):
?>
    <div class="reqCont">
        <div style="float:left; width:160px; margin:10px;">
            <img border="1" src="<?php echo @URL; ?>
/getsmimage.php?id=<?php echo $this->_tpl_vars['frnd']['user_imgs_id']; ?>
" alt="<?php echo $this->_tpl_vars['frnd']['f_name']; ?>
 <?php echo $this->_tpl_vars['frnd']['l_name']; ?>
" style="width:150px;"/>
        </div>
        <div style="float:left; width:300px;" id="cont">
            <h3><a href="<?php echo @URL; ?>
/profile/view/<?php echo $this->_tpl_vars['frnd']['pid']; ?>
"><?php echo $this->_tpl_vars['frnd']['f_name']; ?>
 <?php echo $this->_tpl_vars['frnd']['l_name']; ?>
</a> wants to be your friend.</h3>
            <?php if ($this->_tpl_vars['frnd']['req_msg'] != ""): ?>
                <?php echo $this->_tpl_vars['frnd']['f_name']; ?>
 wrote: 
                <h4><i><?php echo $this->_tpl_vars['frnd']['req_msg']; ?>
</i></h4>
                <?php echo ((is_array($_tmp=$this->_tpl_vars['frnd']['date_added'])) ? $this->_run_mod_handler('date_format', true, $_tmp) : smarty_modifier_date_format($_tmp)); ?>

            <?php endif; ?>
           	<br/>
            <h3>
            <a href="<?php echo @URL; ?>
/friend/approve/<?php echo $this->_tpl_vars['frnd']['fid']; ?>
">Approve</a>
        	&nbsp;&nbsp;
        	<a href="<?php echo @URL; ?>
/friend/denyrequest/<?php echo $this->_tpl_vars['frnd']['fid']; ?>
">Deny</a>
            </h3>
        </div>
    </div>
    <br/>
<?php endforeach; else: ?>
<h3>You have no friend requests</h3>
<?php endif; unset($_from); ?>