<?php /* Smarty version 2.6.26, created on 2010-01-14 04:00:00
         compiled from browse_album.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'paginate_first', 'browse_album.tpl', 14, false),array('function', 'paginate_prev', 'browse_album.tpl', 14, false),array('function', 'paginate_middle', 'browse_album.tpl', 14, false),array('function', 'paginate_next', 'browse_album.tpl', 14, false),array('function', 'paginate_last', 'browse_album.tpl', 14, false),array('modifier', 'truncate', 'browse_album.tpl', 28, false),array('modifier', 'date_format', 'browse_album.tpl', 29, false),)), $this); ?>
<div style="float:left; width:740px;">
        <div id="pginfo">
        Browse latest albums published by the users of conveylive.
        See the albums one by one and its photos. If you are logedin you may post comments to give some feedback.
    </div>
    <div style="width:98%; float:left;">
        <?php if ($this->_tpl_vars['albums'] != null): ?>

        <div>
            <br />
            <span style="float:left;" class="pageLink"><h3>Showing page <?php echo $this->_tpl_vars['paginate']['page_current']; ?>
 of <?php echo $this->_tpl_vars['paginate']['page_total']; ?>
</h3></span>
            <span style="float:right;" class="pageLink">
                <?php echo smarty_function_paginate_first(array(), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_prev(array(), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_middle(array('format' => 'page','prefix' => "",'suffix' => "",'link_prefix' => "&nbsp;",'link_suffix' => "&nbsp;"), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_next(array(), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_last(array(), $this);?>

            </span>
        
        </div>
        <br /><br />
        
        <div style="width:98%;">
            <center>
                <div style="width:98%;">
                    <?php $_from = $this->_tpl_vars['albums']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['album']):
?>
                        <div class="album">
                            <center>
                                <div class="browsealbums">
                                    <a href='<?php echo @URL; ?>
/picture/albumview/<?php echo $this->_tpl_vars['album']['id']; ?>
'><img src='<?php echo @URL; ?>
/getsmimage.php?id=<?php echo $this->_tpl_vars['album']['image_id']; ?>
' style="max-height:100px;" alt="<?php echo $this->_tpl_vars['album']['album_name']; ?>
, <?php echo $this->_tpl_vars['album']['f_name']; ?>
 <?php echo $this->_tpl_vars['album']['l_name']; ?>
, conveylive"/></a>
                                    <h3><?php echo ((is_array($_tmp=$this->_tpl_vars['album']['album_name'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 30) : smarty_modifier_truncate($_tmp, 30)); ?>
</h3>
                                    <?php echo ((is_array($_tmp=$this->_tpl_vars['album']['ins_date'])) ? $this->_run_mod_handler('date_format', true, $_tmp) : smarty_modifier_date_format($_tmp)); ?>
<br />
                                    Total <?php echo $this->_tpl_vars['album']['pic_count']; ?>
 photo(s)<br />
                                    by <a href="<?php echo @URL; ?>
/profile/view/<?php echo $this->_tpl_vars['album']['pid']; ?>
" style= "width:190px; overflow:hidden;"><?php echo ((is_array($_tmp=$this->_tpl_vars['album']['f_name'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 30) : smarty_modifier_truncate($_tmp, 30)); ?>
 <?php echo ((is_array($_tmp=$this->_tpl_vars['album']['l_name'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 30) : smarty_modifier_truncate($_tmp, 30)); ?>
</a>
                                    <br />
                                </div>
                            </center>
                        </div>
                    <?php endforeach; endif; unset($_from); ?>
                </div>
            </center>
        </div>

        <div style="float:left;width:98%;">
            <span style="float:right;" class="pageLink">
                <?php echo smarty_function_paginate_first(array(), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_prev(array(), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_middle(array('format' => 'page','prefix' => "",'suffix' => "",'link_prefix' => "&nbsp;",'link_suffix' => "&nbsp;"), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_next(array(), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_last(array(), $this);?>

            </span>
        </div>
        <?php else: ?>
        <p>There are no latest albums to view</p>
        <?php endif; ?>
    </div>

</div>