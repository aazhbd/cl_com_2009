<?php /* Smarty version 2.6.26, created on 2010-02-24 13:57:56
         compiled from pic_view.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'paginate_prev', 'pic_view.tpl', 13, false),array('function', 'paginate_next', 'pic_view.tpl', 13, false),)), $this); ?>
<div style="float:left; width:730px;">
    <?php if ($this->_tpl_vars['res_list'] != null): ?>
    <div>
        <span class="mediumtxt" style="float:right;">
            <a href="<?php echo @URL; ?>
/picture/new">Create New Album</a>&nbsp;|&nbsp;<a href="<?php echo @URL; ?>
/picture/albumview/<?php echo $this->_tpl_vars['prof_aid']; ?>
">Profile Photos</a>
        </span>
    </div>
    <div>
        <span class="mediumtxt" style="float:left;">
            Photo <?php echo $this->_tpl_vars['paginate']['current_item']; ?>
 of <?php echo $this->_tpl_vars['paginate']['total']; ?>
 | <a href="<?php echo @URL; ?>
/picture/albumview/<?php echo $this->_tpl_vars['aid']; ?>
">Back to Album</a>
        </span>
        <span class="mediuminfo" style="float:right;">
                <?php echo smarty_function_paginate_prev(array(), $this);?>
 <?php echo smarty_function_paginate_next(array(), $this);?>

        </span>
    </div>
    <hr />
    <?php $_from = $this->_tpl_vars['res_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['img']):
?>
    <div align="center">
        <a href="<?php echo @URL; ?>
/getimage.php?id=<?php echo $this->_tpl_vars['img']['id']; ?>
"><img src="<?php echo @URL; ?>
/getimage.php?id=<?php echo $this->_tpl_vars['img']['id']; ?>
"   align="absmiddle" style="max-width:550px; max-height:700px; border: solid #ccc 1px;" alt="Image, Photo, ConveyLive, <?php echo $this->_tpl_vars['album_name']; ?>
 , <?php echo $this->_tpl_vars['uname']; ?>
, <?php echo $this->_tpl_vars['img']['id']; ?>
" /></a>
        <?php $this->assign('media_id', $this->_tpl_vars['img']['id']); ?>
        <?php $this->assign('uemail', $this->_tpl_vars['img']['user_email']); ?>
    </div>
    <?php endforeach; endif; unset($_from); ?>
    
    <br />
    <br />
    
    <div style="float:left; width:98%;" class="mediumtxt">
        <p><?php echo $this->_tpl_vars['remarks']; ?>
</p>
    </div>
    
    <div style="float:right;" class="mediumtxt">
        From the album:
        <p>
            <a href="<?php echo @URL; ?>
/picture/albumview/<?php echo $this->_tpl_vars['aid']; ?>
"><?php echo $this->_tpl_vars['album_name']; ?>
</a>
            by <a href="<?php echo @URL; ?>
/profile/view/<?php echo $this->_tpl_vars['pid']; ?>
"><?php echo $this->_tpl_vars['uname']; ?>
</a>
            <br />
            <?php if ($this->_tpl_vars['uemail'] == $this->_tpl_vars['email']): ?>
                <a href="<?php echo @URL; ?>
/picture/setalbumphoto/<?php echo $this->_tpl_vars['img']['id']; ?>
">Set as album cover photo</a>
                <br />
                <a href="<?php echo @URL; ?>
/picture/setprofilephoto/<?php echo $this->_tpl_vars['img']['id']; ?>
">Set as profile photo</a>
                <br />
                <a href="<?php echo @URL; ?>
/picture/new">Add more photos</a>
                <br />
                <a href="<?php echo @URL; ?>
/picture/delete/<?php echo $this->_tpl_vars['img']['id']; ?>
" class='picremove'>Remove photo</a>
            <?php endif; ?>
        </p>    
    </div>
    <?php else: ?>
        <div id="pginfo">
            Sorry, this album is not available.
        </div>
    <?php endif; ?>
</div>
<?php echo '
<script type="text/javascript">
$(document).ready(function(){
    $(\'a.picremove\').click(function(){
       var link = $(this).attr(\'href\');
        jConfirm(\'Are you sure you want to delete this page?\', \'Confirmation Dialog\', function(r) {
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