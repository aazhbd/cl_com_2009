<?php /* Smarty version 2.6.26, created on 2010-02-24 14:10:23
         compiled from album_view.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'paginate_first', 'album_view.tpl', 33, false),array('function', 'paginate_prev', 'album_view.tpl', 33, false),array('function', 'paginate_middle', 'album_view.tpl', 33, false),array('function', 'paginate_next', 'album_view.tpl', 33, false),array('function', 'paginate_last', 'album_view.tpl', 33, false),)), $this); ?>
<?php echo '
<script type="text/javascript"> 
$(document).ready(function() {
    $("a.zoom").fancybox();

    $("a.zoom1").fancybox({
        \'overlayOpacity\'    :    0.7,
        \'overlayColor\'        :    \'#FFF\'
    });

    $("a.zoom2").fancybox({
        \'zoomSpeedIn\'        :    500,
        \'zoomSpeedOut\'        :    500
    });
});
</script>
'; ?>

<div style="float:left;width:740px;" >
    <div style="float:left;width:98%;">
        <span><img src="<?php echo @URL; ?>
/getsmimage.php?id=<?php echo $this->_tpl_vars['img_id']; ?>
" width="40"/><a href="<?php echo @URL; ?>
/profile/view/<?php echo $this->_tpl_vars['pid']; ?>
" />&nbsp;<?php echo $this->_tpl_vars['uname']; ?>
's Profile</a></span>
        <div>
            <span class="mediumtxt" style="float:right;">
                <a href="<?php echo @URL; ?>
/picture/new">Create New Album</a>&nbsp;|&nbsp;<a href="<?php echo @URL; ?>
/picture/albumview/<?php echo $this->_tpl_vars['prof_aid']; ?>
">Profile Photos</a>
            </span>
        </div>
        
        <?php if ($this->_tpl_vars['album'] != null): ?>
            <div style="width:98%px;">
                <span class="mediumtxt" style="float:left;">
                    <h3>Showing page <?php echo $this->_tpl_vars['paginate']['page_current']; ?>
 of <?php echo $this->_tpl_vars['paginate']['page_total']; ?>
</h3>
                </span>
                <span class="mediuminfo" style="float:right;">
                    <?php echo smarty_function_paginate_first(array(), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_prev(array(), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_middle(array('format' => 'page','prefix' => "",'suffix' => "",'link_prefix' => "&nbsp;",'link_suffix' => "&nbsp;"), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_next(array(), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_last(array(), $this);?>

                </span>
            </div>
            <br />
            <div style="float:left;width:98%;">
                <center>
                    <div style="float:left;width:98%;">
                        <?php $_from = $this->_tpl_vars['album']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['pic']):
?>
                            <?php if ($this->_tpl_vars['album']['albumimg_id'] == 0): ?>
                                <div class="pics">
                                    <div class="browsepics">
                                        <center>
                                        <a href='<?php echo @URL; ?>
/picture/view/<?php echo $this->_tpl_vars['pic']['id']; ?>
'><img src='<?php echo @URL; ?>
/getsmimage.php?id=<?php echo $this->_tpl_vars['pic']['id']; ?>
'  style="max-height:110px;max-width:200px;" alt="<?php echo $this->_tpl_vars['uname']; ?>
 , <?php echo $this->_tpl_vars['pic']['id']; ?>
,<?php echo $this->_tpl_vars['pic']['id']; ?>
 conveylive"/></a>
                                        </center>
                                    </div>
                                    <div id="preview">
                                        <a href='<?php echo @URL; ?>
/<?php echo $this->_tpl_vars['pic']['fpath']; ?>
' class="zoom2" style="width:98%;" >Preview</a>
                                    </div>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; endif; unset($_from); ?>
                    </div>
                </center>
            </div>
            <div style="width:98%;">
                <span  class="mediuminfo" style="float:right;">
                    <?php echo smarty_function_paginate_first(array(), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_prev(array(), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_middle(array('format' => 'page','prefix' => "",'suffix' => "",'link_prefix' => "&nbsp;",'link_suffix' => "&nbsp;"), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_next(array(), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_last(array(), $this);?>

                </span>
            </div>
        <?php else: ?>
            <p>There are no pictures in this album</p>
        <?php endif; ?>
    </div>
</div>

<div style="float:left;width:98%;">
    <br />
    <?php if ($this->_tpl_vars['album'] != null && $this->_tpl_vars['islogin'] == true): ?>
        <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "invitecontent_form.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
    <?php endif; ?>
</div>