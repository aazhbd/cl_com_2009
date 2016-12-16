<?php /* Smarty version 2.6.26, created on 2010-01-23 23:07:06
         compiled from blog_view.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'paginate_first', 'blog_view.tpl', 37, false),array('function', 'paginate_prev', 'blog_view.tpl', 37, false),array('function', 'paginate_middle', 'blog_view.tpl', 37, false),array('function', 'paginate_next', 'blog_view.tpl', 37, false),array('function', 'paginate_last', 'blog_view.tpl', 37, false),array('modifier', 'truncate', 'blog_view.tpl', 45, false),array('modifier', 'date_format', 'blog_view.tpl', 55, false),array('modifier', 'capitalize', 'blog_view.tpl', 66, false),)), $this); ?>
<?php echo '
<script type="text/javascript">
   $(document).ready(function(){
       $("#errors").hide();
       $("#reps").hide();
   });
</script>
'; ?>


<div style="width:745px;">
    <?php if ($this->_tpl_vars['blog']['user_email'] == $this->_tpl_vars['email']): ?>
    <div id="pginfo">
        This page shows all blog posts that you have published. Look at the top Menu that says "Blog" which has some new sub-menu after blog creation. Browse others blogs and see what others have written. To publish a new Post click the "New Post"  link below.
    </div>
    <?php else: ?>
    <div id="pginfo">
        This page shows all blog posts of this person. Browse through these posts and click the title to read them. You may rate and comment on these posts if you are loged in.
    </div>
    <?php endif; ?>
        <div>
        <?php if ($this->_tpl_vars['blog']['user_email'] == $this->_tpl_vars['email']): ?>
            <div>
                <span>
                    <a href="<?php echo @URL; ?>
/blog/editblog/<?php echo $this->_tpl_vars['blog']['id']; ?>
" >Edit Blog</a> |
                    <a href="<?php echo @URL; ?>
/blog/deleteblog/<?php echo $this->_tpl_vars['blog']['id']; ?>
" class="blogdelete">Delete Blog</a> |
                    <a href="<?php echo @URL; ?>
/blog/new/">New Post</a> |
                    <a href="<?php echo @URL; ?>
/blog/browseall">Browse Latest Blogs</a>
                </span>
            </div>
            <br />
        <?php endif; ?>

        <?php if ($this->_tpl_vars['postList'] != null): ?>
            <br />
            <span style="float:left">Showing posts <?php echo $this->_tpl_vars['paginate']['first']; ?>
-<?php echo $this->_tpl_vars['paginate']['last']; ?>
 of <?php echo $this->_tpl_vars['paginate']['total']; ?>
</span>
            <span style="float:right" class="pageLink"><?php echo smarty_function_paginate_first(array(), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_prev(array(), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_middle(array('format' => 'page','prefix' => "",'suffix' => "",'link_prefix' => "&nbsp;",'link_suffix' => "&nbsp;"), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_next(array(), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_last(array(), $this);?>
</span>

            <?php $_from = $this->_tpl_vars['postList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['post']):
?>
                <div class="artcont" >
                    <a href="<?php echo @URL; ?>
/b/<?php echo $this->_tpl_vars['blog']['url']; ?>
/<?php echo $this->_tpl_vars['post']['post_id']; ?>
" ><div class="entry" style="width:65%;" id="titleblock"><h3><?php echo $this->_tpl_vars['post']['title']; ?>
</h3></div></a>
                    <a href="<?php echo @URL; ?>
/profile/view/<?php echo $this->_tpl_vars['blog']['pid']; ?>
"><div class="entry" style="width:30%;" id="titleblock"><?php echo $this->_tpl_vars['blog']['f_name']; ?>
 <?php echo $this->_tpl_vars['blog']['l_name']; ?>
</div></a>
                    
                    <div class="entry" style="width:95%;"><?php echo $this->_tpl_vars['post']['sub_title']; ?>
</div>
                    <div class="entry" style="width:95%;text-align:justify;"><?php echo ((is_array($_tmp=$this->_tpl_vars['post']['body'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 800) : smarty_modifier_truncate($_tmp, 800)); ?>
 <a href="<?php echo @URL; ?>
/b/<?php echo $this->_tpl_vars['blog']['url']; ?>
/<?php echo $this->_tpl_vars['post']['post_id']; ?>
" class="more" style="font-size:12px;"> &raquo; read more</a></div>
                    <div class="entry" style="width:95%;">View: <?php echo $this->_tpl_vars['post']['view_count']; ?>
&nbsp;|&nbsp;Rating <?php echo $this->_tpl_vars['post']['rating']; ?>
  
                    <?php unset($this->_sections['foo']);
$this->_sections['foo']['name'] = 'foo';
$this->_sections['foo']['start'] = (int)1;
$this->_sections['foo']['loop'] = is_array($_loop=6) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['foo']['max'] = (int)6;
$this->_sections['foo']['step'] = ((int)1) == 0 ? 1 : (int)1;
$this->_sections['foo']['show'] = true;
if ($this->_sections['foo']['max'] < 0)
    $this->_sections['foo']['max'] = $this->_sections['foo']['loop'];
if ($this->_sections['foo']['start'] < 0)
    $this->_sections['foo']['start'] = max($this->_sections['foo']['step'] > 0 ? 0 : -1, $this->_sections['foo']['loop'] + $this->_sections['foo']['start']);
else
    $this->_sections['foo']['start'] = min($this->_sections['foo']['start'], $this->_sections['foo']['step'] > 0 ? $this->_sections['foo']['loop'] : $this->_sections['foo']['loop']-1);
if ($this->_sections['foo']['show']) {
    $this->_sections['foo']['total'] = min(ceil(($this->_sections['foo']['step'] > 0 ? $this->_sections['foo']['loop'] - $this->_sections['foo']['start'] : $this->_sections['foo']['start']+1)/abs($this->_sections['foo']['step'])), $this->_sections['foo']['max']);
    if ($this->_sections['foo']['total'] == 0)
        $this->_sections['foo']['show'] = false;
} else
    $this->_sections['foo']['total'] = 0;
if ($this->_sections['foo']['show']):

            for ($this->_sections['foo']['index'] = $this->_sections['foo']['start'], $this->_sections['foo']['iteration'] = 1;
                 $this->_sections['foo']['iteration'] <= $this->_sections['foo']['total'];
                 $this->_sections['foo']['index'] += $this->_sections['foo']['step'], $this->_sections['foo']['iteration']++):
$this->_sections['foo']['rownum'] = $this->_sections['foo']['iteration'];
$this->_sections['foo']['index_prev'] = $this->_sections['foo']['index'] - $this->_sections['foo']['step'];
$this->_sections['foo']['index_next'] = $this->_sections['foo']['index'] + $this->_sections['foo']['step'];
$this->_sections['foo']['first']      = ($this->_sections['foo']['iteration'] == 1);
$this->_sections['foo']['last']       = ($this->_sections['foo']['iteration'] == $this->_sections['foo']['total']);
?>
                        <?php if ($this->_sections['foo']['index'] <= $this->_tpl_vars['post']['rating']): ?>
                            <img src="<?php echo @URL; ?>
/interface/icos/star.png" alt="<?php echo $this->_tpl_vars['blog']['f_name']; ?>
 <?php echo $this->_tpl_vars['blog']['l_name']; ?>
 , <?php echo $this->_tpl_vars['post']['title']; ?>
" width="12px"/>
                        <?php elseif ($this->_sections['foo']['index'] > $this->_tpl_vars['post']['rating']): ?>
                            <img src="<?php echo @URL; ?>
/interface/icos/star_dull.png" alt="<?php echo $this->_tpl_vars['blog']['f_name']; ?>
 <?php echo $this->_tpl_vars['blog']['l_name']; ?>
 , <?php echo $this->_tpl_vars['post']['title']; ?>
" width="12px"/>
                        <?php endif; ?>
                    <?php endfor; endif; ?>
                    
                    <?php if ($this->_tpl_vars['post']['com_count'] > 0): ?> &nbsp;|&nbsp; <?php echo $this->_tpl_vars['post']['com_count']; ?>
 Comment(s) <?php endif; ?> &nbsp;|&nbsp; <?php echo ((is_array($_tmp=$this->_tpl_vars['post']['cdate'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%A, %B %e") : smarty_modifier_date_format($_tmp, "%A, %B %e")); ?>
 at <?php echo ((is_array($_tmp=$this->_tpl_vars['post']['cdate'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%I:%M %p") : smarty_modifier_date_format($_tmp, "%I:%M %p")); ?>
 </div>
                    
                    <?php if ($this->_tpl_vars['post']['user_email'] == $this->_tpl_vars['email']): ?>
                        <div class="entry" style="width:100%;">
                            <a href="<?php echo @URL; ?>
/blog/editpost/<?php echo $this->_tpl_vars['post']['post_id']; ?>
">Edit this post</a>&nbsp;|&nbsp;
                            <a href="<?php echo @URL; ?>
/blog/deletepost/<?php echo $this->_tpl_vars['post']['post_id']; ?>
" class="postdelete">Delete this post</a>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; else: ?>
                <div class="artcont">
                    <div class="entry" style="width:100%;"><strong><?php if ($this->_tpl_vars['blog']['user_email'] != $this->_tpl_vars['email']): ?><?php echo ((is_array($_tmp=$this->_tpl_vars['blog']['f_name'])) ? $this->_run_mod_handler('capitalize', true, $_tmp) : smarty_modifier_capitalize($_tmp)); ?>
 <?php echo ((is_array($_tmp=$this->_tpl_vars['blog']['l_name'])) ? $this->_run_mod_handler('capitalize', true, $_tmp) : smarty_modifier_capitalize($_tmp)); ?>
 does not have any published post <?php else: ?> You do not have any published post<?php endif; ?> </strong></div>
                </div>
            <?php endif; unset($_from); ?>
            
            <br />
            
            <span style="float:right; " class="pageLink"><br /><?php echo smarty_function_paginate_first(array(), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_prev(array(), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_middle(array('format' => 'page','prefix' => "",'suffix' => "",'link_prefix' => "&nbsp;",'link_suffix' => "&nbsp;"), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_next(array(), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_last(array(), $this);?>
</span>
        <?php else: ?>
            <div class="artcont">
                <div class="entry" style="width:100%;"><strong><?php if ($this->_tpl_vars['blog']['user_email'] != $this->_tpl_vars['email']): ?><?php echo ((is_array($_tmp=$this->_tpl_vars['blog']['f_name'])) ? $this->_run_mod_handler('capitalize', true, $_tmp) : smarty_modifier_capitalize($_tmp)); ?>
 <?php echo ((is_array($_tmp=$this->_tpl_vars['blog']['l_name'])) ? $this->_run_mod_handler('capitalize', true, $_tmp) : smarty_modifier_capitalize($_tmp)); ?>
 does not have any published post <?php else: ?> You do not have any published post<?php endif; ?></strong></div>
            </div>
        <?php endif; ?>
    </div>
    <br /> 
    <?php if ($this->_tpl_vars['post'] != null && $this->_tpl_vars['islogin'] == true): ?>
        <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "invitecontent_form.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
    <?php endif; ?>
</div>

<?php echo '
<script type="text/javascript">
$(document).ready(function(){
    
    $(\'a.blogdelete\').click(function(){
       var link = $(this).attr(\'href\');
        jConfirm(\'Are you sure you want to delete this blog? All your blog posts will also be deleted if you delete your blog.\', \'Confirmation Dialog\', function(r) {
            if(r == true){
                window.location.href = link;
            }
            else{
                return false;
            }
        });
        return false;
    });
    
    $(\'a.postdelete\').click(function(){
       var link = $(this).attr(\'href\');
        jConfirm(\'Are you sure you want to delete this post? All your posts comments will also be deleted if you delete this post.\', \'Confirmation Dialog\', function(r) {
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