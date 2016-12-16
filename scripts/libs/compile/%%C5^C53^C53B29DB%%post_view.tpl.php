<?php /* Smarty version 2.6.26, created on 2010-06-24 10:27:51
         compiled from post_view.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'post_view.tpl', 15, false),array('modifier', 'default', 'post_view.tpl', 18, false),array('modifier', 'truncate', 'post_view.tpl', 80, false),)), $this); ?>
<div style="float:left; width:745px;">
    <div><a href="<?php echo @URL; ?>
/b/<?php echo $this->_tpl_vars['blog']['url']; ?>
">Back to Blogs page</a>&nbsp;|&nbsp;<?php if ($this->_tpl_vars['islogin'] == true && $this->_tpl_vars['blogexist'] == true): ?><a href="<?php echo @URL; ?>
/blog/new">New Post</a>&nbsp;|&nbsp;<?php endif; ?><a href="<?php echo @URL; ?>
/blog/browseall">View Others' Blogs</a>&nbsp;</div>
    <br />
    <div id="box">
        <div style="width:42px; height:42px; float:left;">
            <a href="<?php echo @URL; ?>
/profile/view/<?php echo $this->_tpl_vars['blog']['pid']; ?>
"><img src="<?php echo @URL; ?>
/getsmimage.php?id=<?php echo $this->_tpl_vars['blog']['user_imgs_id']; ?>
" alt="<?php echo $this->_tpl_vars['blog']['f_name']; ?>
, <?php echo $this->_tpl_vars['blog']['l_name']; ?>
" height="40" width="40"  /></a>
        </div>
        <div class="smallbox">
            <?php if ($this->_tpl_vars['blog']['pid'] == ""): ?>
                <?php echo $this->_tpl_vars['blog']['f_name']; ?>
 <?php echo $this->_tpl_vars['blog']['l_name']; ?>

            <?php else: ?>
                <a href="<?php echo @URL; ?>
/profile/view/<?php echo $this->_tpl_vars['blog']['pid']; ?>
"><?php echo $this->_tpl_vars['blog']['f_name']; ?>
 <?php echo $this->_tpl_vars['blog']['l_name']; ?>
</a>
            <?php endif; ?>
            <br />
            <?php echo ((is_array($_tmp=$this->_tpl_vars['post']['ins_date'])) ? $this->_run_mod_handler('date_format', true, $_tmp) : smarty_modifier_date_format($_tmp)); ?>

        </div>
        <div class="infobox">
            <?php echo ((is_array($_tmp=@$this->_tpl_vars['post']['com_count'])) ? $this->_run_mod_handler('default', true, $_tmp, '0') : smarty_modifier_default($_tmp, '0')); ?>
 Comments | <?php echo $this->_tpl_vars['post']['view_count']; ?>
 Views |
            <?php echo $this->_tpl_vars['post']['tothits']; ?>
 Hits <br />
            <?php if ($this->_tpl_vars['post']['user_email'] != $this->_tpl_vars['email'] && $this->_tpl_vars['islogin'] == true): ?>
                Rate up &nbsp;<a href="<?php echo @URL; ?>
/b/<?php echo $this->_tpl_vars['blog']['url']; ?>
/rateup/<?php echo $this->_tpl_vars['post']['post_id']; ?>
" ><img src="<?php echo @URL; ?>
/interface/icos/thumbs_up.gif" width="15px" alt="<?php echo $this->_tpl_vars['post']['name']; ?>
,rating-up, <?php echo $this->_tpl_vars['post']['title']; ?>
" border="0"/></a> &nbsp;
                Rate down &nbsp;<a href="<?php echo @URL; ?>
/b/<?php echo $this->_tpl_vars['blog']['url']; ?>
/ratedown/<?php echo $this->_tpl_vars['post']['post_id']; ?>
" ><img src="<?php echo @URL; ?>
/interface/icos/thumbs_down.gif" width="15px" alt="<?php echo $this->_tpl_vars['post']['name']; ?>
, rating-down, <?php echo $this->_tpl_vars['post']['title']; ?>
" border="0" /></a>
            <?php endif; ?>
        </div>
        <div class="ratingbox">                    
            Rating: <?php echo $this->_tpl_vars['post']['rating']; ?>

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
, <?php echo $this->_tpl_vars['blog']['l_name']; ?>
, <?php echo $this->_tpl_vars['post']['title']; ?>
" width="12px"/>
                <?php elseif ($this->_sections['foo']['index'] > $this->_tpl_vars['article']['rating']): ?>
                    <img src="<?php echo @URL; ?>
/interface/icos/star_dull.png" alt="<?php echo $this->_tpl_vars['post']['name']; ?>
 , <?php echo $this->_tpl_vars['post']['title']; ?>
" width="12px"/>
                <?php endif; ?>
            <?php endfor; endif; ?>
        </div>
    </div>
    
    <div style="width:98%;padding:5px;">
        <?php if ($this->_tpl_vars['prev'] != null): ?>
            <div style="float:left;">
                <a href="<?php echo @URL; ?>
/b/<?php echo $this->_tpl_vars['blog']['url']; ?>
/<?php echo $this->_tpl_vars['prev']['post_id']; ?>
" title="<?php echo $this->_tpl_vars['prev']['title']; ?>
">
                    <div style="float: left;"><img src="<?php echo @URL; ?>
/interface/images/left_arrow.png" /></div>
                    <div style="float: left; padding: 10px;">Previous</div>
                </a>                
            </div>
        <?php endif; ?>
        <?php if ($this->_tpl_vars['next'] != null): ?>
            <div style="float:right;">
                <div style="float:right;">
                    <a href="<?php echo @URL; ?>
/b/<?php echo $this->_tpl_vars['blog']['url']; ?>
/<?php echo $this->_tpl_vars['next']['post_id']; ?>
" title="<?php echo $this->_tpl_vars['next']['title']; ?>
">
                        <div style="float: left; padding: 10px;">Next</div>
                        <div style="float: left;"><img src="<?php echo @URL; ?>
/interface/images/right_arrow.png" /></div>
                    </a>
                </div>                
            </div>
        <?php endif; ?>
    </div>

    <div>
        <br/>
        <h2 style="color:#069; "><?php echo $this->_tpl_vars['post']['title']; ?>
</h2>
        <strong><i><?php echo $this->_tpl_vars['post']['sub_title']; ?>
</i></strong>
        <br />
        <div style="padding-top:10px;">
        <?php if ($this->_tpl_vars['post']['user_email'] == $this->_tpl_vars['email'] && $this->_tpl_vars['islogin'] == true): ?>
            <span><img src="<?php echo @URL; ?>
/interface/icos/page_edit.png" style="width:15px;"/><a href="<?php echo @URL; ?>
/blog/editpost/<?php echo $this->_tpl_vars['post_id']; ?>
" >Edit this post</a>&nbsp;|&nbsp;<img src="<?php echo @URL; ?>
/interface/icos/delete_post.png" style="width:15px;"/><a href="<?php echo @URL; ?>
/blog/deletepost/<?php echo $this->_tpl_vars['post_id']; ?>
" class="postdelete">Delete this post</a></span>&nbsp;|
        <?php endif; ?>
            <?php if ($this->_tpl_vars['post']['com_count'] > 0): ?><span><img src="<?php echo @URL; ?>
/interface/icos/comments.png" style="width:15px;"/><a href="#comlist" >View Comments</a></span>&nbsp;|&nbsp;<?php endif; ?><span><img src="<?php echo @URL; ?>
/interface/icos/comment_add.png" style="width:15px;"/><a href="#comment" >Add Your Comment</a></span>
        </div>
    </div>
    <hr color="#CCCCCC" noshade="noshade" />
    <br />
    <div style="width:570px;float:left;padding:10px;">
        <?php echo $this->_tpl_vars['post']['body']; ?>

    </div>
    <div style="padding:2px; ">
        <?php if ($this->_tpl_vars['postList'] != null): ?>
            <h3 class="sideheaderbox"><img src="<?php echo @URL; ?>
/interface/icos/tag_blue.png" style="width:25px;margin-left:5px;margin-right:5px;" />Posts by <?php echo $this->_tpl_vars['blog']['f_name']; ?>
 <?php echo $this->_tpl_vars['blog']['l_name']; ?>
 </h3>
            <div class="sideinfobox" >
                <?php $_from = $this->_tpl_vars['postList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['pst']):
?>
                    <div style="list-style:none;"><a href="<?php echo @URL; ?>
/b/<?php echo $this->_tpl_vars['blog']['url']; ?>
/<?php echo $this->_tpl_vars['pst']['post_id']; ?>
" class="sidelinklist"><img src="<?php echo @URL; ?>
/interface/icos/arrow_gray.gif" style="width:7px;"/>&nbsp;<?php echo ((is_array($_tmp=$this->_tpl_vars['pst']['title'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 20) : smarty_modifier_truncate($_tmp, 20)); ?>
</a></div>
                <?php endforeach; endif; unset($_from); ?>
            </div>
        <?php endif; ?>
        <?php if ($this->_tpl_vars['latArt'] != null): ?>
            <h3 class="sideheaderbox"><img src="<?php echo @URL; ?>
/interface/icos/tag_green.png" style="width:25px;margin-left:5px;margin-right:5px;" />Latest Blogs</h3>
            <div class="sideinfobox">
                <?php $_from = $this->_tpl_vars['latArt']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['art']):
?>
                    <div style="list-style:none;"><a href='<?php echo @URL; ?>
/b/<?php echo $this->_tpl_vars['art']['url']; ?>
' class="sidelinklist"><img src="<?php echo @URL; ?>
/interface/icos/arrow_gray.gif" style="width:7px;"/>&nbsp;<?php echo ((is_array($_tmp=$this->_tpl_vars['art']['cname'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 20) : smarty_modifier_truncate($_tmp, 20)); ?>
</a></div>
                <?php endforeach; endif; unset($_from); ?>
                <p><a href="<?php echo @URL; ?>
/blog/browseall">See all</a></p>
            </div>
        <?php else: ?>    
            <br />
        <?php endif; ?>
    </div>
 
    <div style="width:98%;">
        <br />
        <?php if ($this->_tpl_vars['post']['remarks'] != ""): ?>
            <div>
                <img src="<?php echo @URL; ?>
/interface/icos/posttopic.png" style="width:30px;" /><strong>Author's note</strong>: <?php echo $this->_tpl_vars['post']['remarks']; ?>

            </div>
        <?php endif; ?>
        <br />
        <?php if ($this->_tpl_vars['post']['meta_tags'] != ""): ?>
            <div>
                <img src="<?php echo @URL; ?>
/interface/icos/key.png" style="width:30px;" /><strong>Keywords</strong>: <?php echo $this->_tpl_vars['post']['meta_tags']; ?>

            </div>
        <?php endif; ?>
    </div>
    <br />
    <hr color="#CCCCCC" noshade="noshade" />
    <?php if ($this->_tpl_vars['coms'] != null): ?>
        <br />
            <h3><img src="<?php echo @URL; ?>
/interface/icos/comments.png" style="width:30px;" />Comments on this post</h3>
        <br />
    <?php endif; ?>
    <div id="comlist">
        <?php if ($this->_tpl_vars['coms'] != null): ?>
            <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "comment_view.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
        <?php endif; ?>
    </div>
    <br />
    <br />
    <?php if ($this->_tpl_vars['islogin'] == true): ?>
        <div id="addcomment">
            <?php $this->assign('mid', $this->_tpl_vars['post_id']); ?>
            <?php $this->assign('mtype', 'Blog Post'); ?>
            
            <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'frm_comment.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>            
        </div>
    <?php else: ?>
        <div style="width:550px;" id="addcomment">
            <h3>Please <a href="<?php echo @URL; ?>
/signup">Signup</a> to comment on this blog post</h3>
        </div>
    <?php endif; ?>
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
