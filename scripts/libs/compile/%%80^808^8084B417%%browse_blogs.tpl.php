<?php /* Smarty version 2.6.26, created on 2010-01-14 04:00:47
         compiled from browse_blogs.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'paginate_first', 'browse_blogs.tpl', 13, false),array('function', 'paginate_prev', 'browse_blogs.tpl', 13, false),array('function', 'paginate_middle', 'browse_blogs.tpl', 13, false),array('function', 'paginate_next', 'browse_blogs.tpl', 13, false),array('function', 'paginate_last', 'browse_blogs.tpl', 13, false),array('modifier', 'date_format', 'browse_blogs.tpl', 20, false),)), $this); ?>
<div style="float:left; width:745px;">
    
    <div id="pginfo">
        This page shows all the latest blogs published in conveylive. Browse through these blogs and read the posts of various authors. You can comment on these posts if you are loged in.
    </div>
        <h3>Latest Blogs</h3><br />
	    <div>
            <?php if ($this->_tpl_vars['blogs'] != null): ?>
            
            <span style="float:left;">Showing page <?php echo $this->_tpl_vars['paginate']['page_current']; ?>
 of <?php echo $this->_tpl_vars['paginate']['page_total']; ?>
<br /></span>
            <span style="float:right;" class="pageLink">
                    <?php echo smarty_function_paginate_first(array(), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_prev(array(), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_middle(array('format' => 'page','prefix' => "",'suffix' => "",'link_prefix' => "&nbsp;",'link_suffix' => "&nbsp;"), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_next(array(), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_last(array(), $this);?>

            </span>
            
            <div style="float:left; width:745px;">
                <?php $_from = $this->_tpl_vars['blogs']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['blog']):
?>
                    <div class="artcont">
                        <a href='<?php echo @URL; ?>
/b/<?php echo $this->_tpl_vars['blog']['url']; ?>
' id="titleblock" class="entry" style="width:65%; font-weight:bold; font-size: 16px;"><?php echo $this->_tpl_vars['blog']['cname']; ?>
</a>
                        <div class="entry" style="width:30%;" id="titleblock">by <a href="<?php echo @URL; ?>
/profile/view/<?php echo $this->_tpl_vars['blog']['pid']; ?>
"><?php echo $this->_tpl_vars['blog']['f_name']; ?>
 <?php echo $this->_tpl_vars['blog']['l_name']; ?>
</a> | <?php echo ((is_array($_tmp=$this->_tpl_vars['blog']['ins_date'])) ? $this->_run_mod_handler('date_format', true, $_tmp) : smarty_modifier_date_format($_tmp)); ?>
</div>
                        <div class="entry" style="width:65%;"><a href='<?php echo @URL; ?>
/b/<?php echo $this->_tpl_vars['blog']['url']; ?>
'><?php echo @URL; ?>
/b/<?php echo $this->_tpl_vars['blog']['url']; ?>
</a></div>
                        <?php if ($this->_tpl_vars['blog']['posts'] != null): ?>
                        <div class="entry" style="width:65%;">
                        <div class="catmenuLink">Latest posts</div>
                        <?php $_from = $this->_tpl_vars['blog']['posts']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['post']):
?>
                            <div class="catmenuLink" ><img src="<?php echo @URL; ?>
/interface/icos/arrow_gray.gif"><a href='<?php echo @URL; ?>
/b/<?php echo $this->_tpl_vars['blog']['url']; ?>
/<?php echo $this->_tpl_vars['post']['post_id']; ?>
'><?php echo $this->_tpl_vars['post']['title']; ?>
</a> published on <?php echo ((is_array($_tmp=$this->_tpl_vars['post']['upd_date'])) ? $this->_run_mod_handler('date_format', true, $_tmp) : smarty_modifier_date_format($_tmp)); ?>
</div>
                        <?php endforeach; endif; unset($_from); ?>
                        </div>
                        <?php endif; ?>
                        <div class="entry" style="width:30%;"><a href="<?php echo @URL; ?>
/profile/view/<?php echo $this->_tpl_vars['blog']['pid']; ?>
"><img src='<?php echo @URL; ?>
/getsmimage.php?id=<?php echo $this->_tpl_vars['blog']['user_imgs_id']; ?>
' border="1" height="100" style="max-width:150px;" alt="<?php echo $this->_tpl_vars['blog']['f_name']; ?>
, <?php echo $this->_tpl_vars['blog']['l_name']; ?>
, <?php echo $this->_tpl_vars['blog']['url']; ?>
, <?php echo $this->_tpl_vars['blog']['name']; ?>
 " /></a></div>
                        <div class="entry" style="width:98%;">
                            <?php if ($this->_tpl_vars['blog']['user_email'] == $this->_tpl_vars['email']): ?>
                                <p><a href="<?php echo @URL; ?>
/blog/editblog/<?php echo $this->_tpl_vars['blog']['id']; ?>
">Edit blog</a>&nbsp;|&nbsp;<a href="<?php echo @URL; ?>
/blog/deleteblog/<?php echo $this->_tpl_vars['blog']['id']; ?>
" class="artdel">Delete blog</a></p>
                            <?php endif; ?>
                        </div>
                    </div>
                    <br />
                <?php endforeach; endif; unset($_from); ?>
            </div>
            <span style="float:right;" class="pageLink">
                <br />
                <?php echo smarty_function_paginate_first(array(), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_prev(array(), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_middle(array('format' => 'page','prefix' => "",'suffix' => "",'link_prefix' => "&nbsp;",'link_suffix' => "&nbsp;"), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_next(array(), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_last(array(), $this);?>

                <br />
            </span>
            <?php else: ?>
            <div>
                <span>There are no latest blogs</span>
            </div>
            <?php endif; ?>
        </div>
</div>
<?php echo '
<script type="text/javascript">
$(document).ready(function(){
    $(\'a.artdel\').click(function(){
       var link = $(this).attr(\'href\');
        jConfirm(\'Are you sure you want to delete this blog?\', \'Confirmation Dialog\', function(r) {
            if(r == true){
                window.location.href = link;
            }
            else{
                return false;
            }
        });
        return false;
    })
});

</script>
'; ?>