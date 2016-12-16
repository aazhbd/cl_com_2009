<?php /* Smarty version 2.6.26, created on 2010-01-13 08:33:20
         compiled from subtpl/side.tpl */ ?>
<?php if ($this->_tpl_vars['islogin'] == false): ?>
<div class="box">
    <h3>Please Signup</h3>
    <a href="<?php echo @URL; ?>
/signup">
        <span class="item">
            <strong>Not a member yet? Sign up here</strong>
        </span>
    </a>
</div>
<div class="box">
    <a href="<?php echo @URL; ?>
">
        <span class="item">
            <strong>Already a member? Login here.</strong>
        </span>
    </a>
</div>
<?php else: ?>
<div class="box">
    <?php $_from = $this->_tpl_vars['sideitem']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
        <?php if ($this->_tpl_vars['item']['name'] == 'Home' || $this->_tpl_vars['item']['name'] == 'Friends' || $this->_tpl_vars['item']['name'] == 'Account' || $this->_tpl_vars['item']['name'] == 'View Profile'): ?>
            <?php if ($this->_tpl_vars['item']['name'] == 'Home'): ?>
                <a href="<?php echo $this->_tpl_vars['item']['link']; ?>
">
                    <span class="item">
                        <img src="<?php echo $this->_tpl_vars['item']['img']; ?>
" height="40" width="40" />
                        <strong><?php echo $this->_tpl_vars['item']['name']; ?>
</strong>
                        <div><?php echo $this->_tpl_vars['loginmsg']; ?>
, <?php echo $this->_tpl_vars['item']['desc']; ?>
</div>
                    </span>
                </a>
            <?php else: ?>
                <a href="<?php echo $this->_tpl_vars['item']['link']; ?>
">
                    <span class="item">
                        <img src="<?php echo $this->_tpl_vars['item']['img']; ?>
" height="40" width="40" />
                        <strong><?php echo $this->_tpl_vars['item']['name']; ?>
</strong>
                        <div><?php echo $this->_tpl_vars['item']['desc']; ?>
</div>
                    </span>
                </a>
            <?php endif; ?>
        <?php else: ?>
            <?php if ($this->_tpl_vars['latContList'] == null && $this->_tpl_vars['topContList'] == null && $this->_tpl_vars['viewContList'] == null): ?>
                <a href="<?php echo $this->_tpl_vars['item']['link']; ?>
">
                    <span class="item">
                        <img src="<?php echo $this->_tpl_vars['item']['img']; ?>
" height="40" width="40" />
                        <strong><?php echo $this->_tpl_vars['item']['name']; ?>
</strong>
                        <div><?php echo $this->_tpl_vars['item']['desc']; ?>
</div>
                    </span>
                </a>
            <?php endif; ?>
        <?php endif; ?>
    <?php endforeach; endif; unset($_from); ?>
</div>
<?php endif; ?>