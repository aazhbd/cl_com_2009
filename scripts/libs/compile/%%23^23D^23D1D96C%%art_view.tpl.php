<?php /* Smarty version 2.6.26, created on 2011-07-26 16:37:41
         compiled from art_view.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'art_view.tpl', 9, false),array('modifier', 'default', 'art_view.tpl', 12, false),array('modifier', 'replace', 'art_view.tpl', 30, false),array('modifier', 'truncate', 'art_view.tpl', 136, false),)), $this); ?>

<div style="width:98%;">
    <div id="box">
        <div style="width:42px; height:42px; float:left;">
            <a href="<?php echo @URL; ?>
/profile/view/<?php echo $this->_tpl_vars['article']['pid']; ?>
"><img src="<?php echo @URL; ?>
/getsmimage.php?id=<?php echo $this->_tpl_vars['article']['user_imgs_id']; ?>
" alt="<?php echo $this->_tpl_vars['article']['name']; ?>
" height="40" /></a>
        </div>
        <div class="smallbox">
            <a href="<?php echo @URL; ?>
/profile/view/<?php echo $this->_tpl_vars['article']['pid']; ?>
"><?php echo $this->_tpl_vars['article']['name']; ?>
</a><br />
            <?php echo ((is_array($_tmp=$this->_tpl_vars['article']['ins_date'])) ? $this->_run_mod_handler('date_format', true, $_tmp) : smarty_modifier_date_format($_tmp)); ?>

        </div>
        <div class="infobox">
            <?php echo ((is_array($_tmp=@$this->_tpl_vars['com_count'])) ? $this->_run_mod_handler('default', true, $_tmp, '0') : smarty_modifier_default($_tmp, '0')); ?>
 Comments | <?php echo $this->_tpl_vars['article']['view_count']; ?>
 Views |
            <?php echo $this->_tpl_vars['article']['tothits']; ?>
 Hits
            <br />
            <?php if ($this->_tpl_vars['article']['user_email'] != $this->_tpl_vars['email'] && $this->_tpl_vars['islogin'] == true): ?>
                Rate up &nbsp;<a href="<?php echo @URL; ?>
/article/rateup/<?php echo $this->_tpl_vars['article']['id']; ?>
" id="rateup" title="Rate down"><img src="<?php echo @URL; ?>
/interface/icos/thumbs_up.gif" width="15px" alt="<?php echo $this->_tpl_vars['article']['name']; ?>
,rating-up, <?php echo $this->_tpl_vars['article']['title']; ?>
" border="0"/></a> &nbsp;
                Rate down &nbsp;<a href="<?php echo @URL; ?>
/article/ratedown/<?php echo $this->_tpl_vars['article']['id']; ?>
" id="ratedown" title="Rate down"><img src="<?php echo @URL; ?>
/interface/icos/thumbs_down.gif" width="15px" alt="<?php echo $this->_tpl_vars['article']['name']; ?>
, rating-down, <?php echo $this->_tpl_vars['article']['title']; ?>
" border="0" /></a>
            <?php endif; ?>
        </div>
        <div class="ratingbox">
            Rating: <?php echo $this->_tpl_vars['article']['rating']; ?>

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
                <?php if ($this->_sections['foo']['index'] <= $this->_tpl_vars['article']['rating']): ?>
                    <img src="<?php echo @URL; ?>
/interface/icos/star.png" alt="<?php echo $this->_tpl_vars['article']['name']; ?>
 , <?php echo $this->_tpl_vars['article']['title']; ?>
" width="12px"/>
                <?php elseif ($this->_sections['foo']['index'] > $this->_tpl_vars['article']['rating']): ?>
                    <img src="<?php echo @URL; ?>
/interface/icos/star_dull.png" alt="<?php echo $this->_tpl_vars['article']['name']; ?>
 , <?php echo $this->_tpl_vars['article']['title']; ?>
" width="12px"/>
                <?php endif; ?>
            <?php endfor; endif; ?>
            
            <?php if ($this->_tpl_vars['article']['category'] != ""): ?><br /><a href="<?php echo @URL; ?>
/article/categorybrowse/<?php echo ((is_array($_tmp=$this->_tpl_vars['article']['category'])) ? $this->_run_mod_handler('replace', true, $_tmp, ' ', '_') : smarty_modifier_replace($_tmp, ' ', '_')); ?>
"><?php echo $this->_tpl_vars['article']['category']; ?>
<?php endif; ?></a>
        </div>
    </div>
    <br />
    
    <div style="width:98%;">
        <div>
            <span>
                <?php if ($this->_tpl_vars['article']['user_email'] == $this->_tpl_vars['email'] && $this->_tpl_vars['islogin'] == true): ?>
                    <img src="<?php echo @URL; ?>
/interface/icos/page_edit.png" style="width:15px;" />
                    <a href="<?php echo @URL; ?>
/article/edit/<?php echo $this->_tpl_vars['article']['id']; ?>
">Edit</a> | 
                    <img src="<?php echo @URL; ?>
/interface/icos/delete_post.png" style="width:15px;"/>
                    <a href="<?php echo @URL; ?>
/article/delete/<?php echo $this->_tpl_vars['article']['id']; ?>
" class="artdel">Delete</a> | 
                <?php endif; ?>

                <?php if ($this->_tpl_vars['com_count'] > 0): ?>
                    <img src="<?php echo @URL; ?>
/interface/icos/comments.png" style="width:15px;"/>
                    <a href="#comlist" >View Comments</a> | 
                <?php endif; ?>
                    <img src="<?php echo @URL; ?>
/interface/icos/comment_add.png" style="width:15px;"/>
                    <a href="#addcomment" >Add Your Comment</a>
            </span>
        </div>
        <br />
        <?php if ($this->_tpl_vars['prev']['url'] == null && $this->_tpl_vars['prev'] != null): ?>
            <div style="float:left;">
                <a href="<?php echo @URL; ?>
/a/<?php echo $this->_tpl_vars['prev']['id']; ?>
" title="<?php echo $this->_tpl_vars['prev']['title']; ?>
">
                    <div style="float: left;"><img src="<?php echo @URL; ?>
/interface/images/left_arrow.png" /></div>
                    <div style="float: left; padding: 10px;">Previous</div>
                </a>
            </div>
        <?php elseif ($this->_tpl_vars['prev'] != null): ?>
            <div style="float:left;">
                <a href="<?php echo @URL; ?>
/a/<?php echo $this->_tpl_vars['prev']['url']; ?>
" title="<?php echo $this->_tpl_vars['prev']['title']; ?>
">
                    <div style="float: left;"><img src="<?php echo @URL; ?>
/interface/images/left_arrow.png" /></div>
                    <div style="float: left; padding: 10px;">Previous</div>
                </a>                
            </div>
        <?php endif; ?>
        <?php if ($this->_tpl_vars['next']['url'] == null && $this->_tpl_vars['next'] != null): ?>
            <div style="float:right;">
                <a href="<?php echo @URL; ?>
/a/<?php echo $this->_tpl_vars['next']['id']; ?>
" title="<?php echo $this->_tpl_vars['next']['title']; ?>
">
                    <div style="float: left; padding: 10px;">Next</div>
                    <div style="float: left;"><img src="<?php echo @URL; ?>
/interface/images/right_arrow.png" /></div>
                </a>
            </div>
        <?php elseif ($this->_tpl_vars['next'] != null): ?>
            <div style="float:right;">
                <a href="<?php echo @URL; ?>
/a/<?php echo $this->_tpl_vars['next']['url']; ?>
" title="<?php echo $this->_tpl_vars['next']['title']; ?>
">
                    <div style="float: left; padding: 10px;">Next</div>
                    <div style="float: left;"><img src="<?php echo @URL; ?>
/interface/images/right_arrow.png" /></div>
                </a>
            </div>
        <?php endif; ?>
    </div>
    <div style="width:98%;">
        <div style="width:98%; float:none;">
            <?php echo $this->_tpl_vars['article']['body']; ?>

        </div>

        <div style="width:98%; float:none;margin-top:20px;">
        <?php if ($this->_tpl_vars['article']['remarks'] != ""): ?>
            <div>
                <img src="<?php echo @URL; ?>
/interface/icos/posttopic.png" style="width:30px;" /><strong>Author's note</strong>: <?php echo $this->_tpl_vars['article']['remarks']; ?>

            </div>
        <?php endif; ?>
        <?php if ($this->_tpl_vars['article']['meta_tags'] != ""): ?>
            <div>
                <img src="<?php echo @URL; ?>
/interface/icos/key.png" style="width:30px;" /><strong>Keywords</strong>: <?php echo $this->_tpl_vars['article']['meta_tags']; ?>

            </div>
        <?php endif; ?>
        <hr />
        </div>
    </div>
    
    
    <br />
    
    <div>
        <?php if ($this->_tpl_vars['coms'] != null): ?><h3><img src="<?php echo @URL; ?>
/interface/icos/comments.png" style="width:30px;" />Comments on this article</h3><?php endif; ?>
        <br />
        <div id="comlist">
            <?php if ($this->_tpl_vars['coms'] != null): ?>
                <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "comment_view.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            <?php endif; ?>
        </div>
        <?php if ($this->_tpl_vars['islogin'] == true): ?>
            <div id="addcomment">
                <?php $this->assign('mid', $this->_tpl_vars['article']['id']); ?>
                <?php $this->assign('mtype', 'Article'); ?>
                
                <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'frm_comment.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            </div>
        <?php else: ?>
            <div style="width:550px;" id="addcomment">
                <h3>Please <a href="<?php echo @URL; ?>
/signup">Signup</a> to comment on this article</h3>
            </div> 
        <?php endif; ?>
    </div>
    <?php if ($this->_tpl_vars['relArt'] != null): ?>
        <div style="margin-top:10px; margin-bottom:10px;">
            <div style="float:left; width: 716px;" class="invitebox" >
                <h3>Related Pages</h3>
                <div class="relList">
                <?php $_from = $this->_tpl_vars['relArt']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['art']):
?>
                    <?php if ($this->_tpl_vars['art']['url'] == null || $this->_tpl_vars['art']['url'] == ""): ?>
                        <li style="padding:5px;"><a href='<?php echo @URL; ?>
/a/<?php echo $this->_tpl_vars['art']['id']; ?>
'><?php echo ((is_array($_tmp=$this->_tpl_vars['art']['title'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 100) : smarty_modifier_truncate($_tmp, 100)); ?>
</a></li>
                    <?php else: ?>
                        <li style="padding:5px;"><a href='<?php echo @URL; ?>
/a/<?php echo $this->_tpl_vars['art']['url']; ?>
'><?php echo ((is_array($_tmp=$this->_tpl_vars['art']['title'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 100) : smarty_modifier_truncate($_tmp, 100)); ?>
</a></li>
                    <?php endif; ?>
                <?php endforeach; endif; unset($_from); ?>
                </div>
                <div style="padding:10px;">
                    Browse other pages of similar category <a href="<?php echo @URL; ?>
/article/categorybrowse/<?php echo ((is_array($_tmp=$this->_tpl_vars['article']['category'])) ? $this->_run_mod_handler('replace', true, $_tmp, ' ', '_') : smarty_modifier_replace($_tmp, ' ', '_')); ?>
"> >> <?php echo $this->_tpl_vars['article']['category']; ?>
</a>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <br />
    <?php if ($this->_tpl_vars['article'] != null && $this->_tpl_vars['islogin'] == true): ?>
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
        $(\'a.artdel\').click(function(){
           var link = $(this).attr(\'href\');
            jConfirm(\'Are you sure you want to delete this article?\', \'Confirmation Dialog\', function(r) {
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
