<?php /* Smarty version 2.6.26, created on 2011-12-27 08:54:25
         compiled from browse_art.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'truncate', 'browse_art.tpl', 16, false),array('modifier', 'date_format', 'browse_art.tpl', 62, false),array('modifier', 'replace', 'browse_art.tpl', 97, false),array('function', 'paginate_first', 'browse_art.tpl', 48, false),array('function', 'paginate_prev', 'browse_art.tpl', 48, false),array('function', 'paginate_middle', 'browse_art.tpl', 48, false),array('function', 'paginate_next', 'browse_art.tpl', 48, false),array('function', 'paginate_last', 'browse_art.tpl', 48, false),)), $this); ?>

<div style="float:left; width:740px;">
    
    <div id="pginfo">
        Browse latest pages published by users of conveylive. Sign in to rate articles according to your like or dislike. 
        You may also post comments and discuss.
    </div>
    
<!--    <div style="padding: 1em;">-->
    <?php if ($this->_tpl_vars['pubList'] != null): ?>
        <div class="browsecat" style="float:left; margin: 0.5em;">
            <h3>Published Categories</h3>
            <div class="catmenuLink" style="border:none; ">
            <?php $_from = $this->_tpl_vars['pubList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['cat']):
?>
                <div>
                    <a href="<?php echo @URL; ?>
/article/categorybrowse/<?php echo $this->_tpl_vars['cat']['linkcat']; ?>
" ><?php echo ((is_array($_tmp=$this->_tpl_vars['cat']['category'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 30) : smarty_modifier_truncate($_tmp, 30)); ?>
 (<?php echo $this->_tpl_vars['cat']['count']; ?>
)</a>
                </div>
            <?php endforeach; endif; unset($_from); ?>
            </div>
        </div>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['selfCatList'] != null): ?>
        <div class="browsecat" style="float:left; margin: 0.5em;">
            <h3>Personal Archive</h3>
            <div class="catmenuLink" style="border:none;">
            <?php $_from = $this->_tpl_vars['selfCatList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['cat']):
?>
                <div>
                    <a href="<?php echo @URL; ?>
/article/categorybrowse/<?php echo $this->_tpl_vars['cat']['linkcat']; ?>
/self" ><?php echo ((is_array($_tmp=$this->_tpl_vars['cat']['category'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 30) : smarty_modifier_truncate($_tmp, 30)); ?>
 (<?php echo $this->_tpl_vars['cat']['count']; ?>
) </a>
                </div>
            <?php endforeach; endif; unset($_from); ?>
            </div>
        </div>
    <?php endif; ?>
<!--    </div>-->
    
    <br />
    <div style="width:740px;">
        <?php if ($this->_tpl_vars['topicHead'] != null): ?>
            <h3><?php echo $this->_tpl_vars['topicHead']; ?>
</h3>
        <?php else: ?>
            <h3>Latest Pages</h3>
        <?php endif; ?>
    </div>

    <?php if ($this->_tpl_vars['artList'] != null): ?>
        <div>
            <span style='float:left;' class="pageLink">Showing pages <?php echo $this->_tpl_vars['paginate']['first']; ?>
-<?php echo $this->_tpl_vars['paginate']['last']; ?>
 of <?php echo $this->_tpl_vars['paginate']['total']; ?>
</span>
            <span style='float:right;' class="pageLink" ><?php echo smarty_function_paginate_first(array(), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_prev(array(), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_middle(array('format' => 'page','prefix' => "",'suffix' => "",'link_prefix' => "&nbsp;",'link_suffix' => "&nbsp;"), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_next(array(), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_last(array(), $this);?>
</span>
        </div>

        <?php $_from = $this->_tpl_vars['artList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['art']):
?>
            <div class="artcont">

                <?php if ($this->_tpl_vars['art']['url'] == null || $this->_tpl_vars['art']['url'] == ""): ?>
                    <h3><a href='<?php echo @URL; ?>
/a/<?php echo $this->_tpl_vars['art']['id']; ?>
' id="titleblock" class="entry" style="width:65%;"><?php echo $this->_tpl_vars['art']['title']; ?>
</a></h3>
                <?php else: ?>
                    <h3><a href='<?php echo @URL; ?>
/a/<?php echo $this->_tpl_vars['art']['url']; ?>
' id="titleblock" class="entry" style="width:65%;"><?php echo $this->_tpl_vars['art']['title']; ?>
</a></h3>
                <?php endif; ?>

                <a href="<?php echo @URL; ?>
/profile/view/<?php echo $this->_tpl_vars['art']['pid']; ?>
" >
                    <div class="entry" style="width:30%;" id="titleblock">
                        by <?php echo $this->_tpl_vars['art']['author']; ?>
 | <?php echo ((is_array($_tmp=$this->_tpl_vars['art']['ins_date'])) ? $this->_run_mod_handler('date_format', true, $_tmp) : smarty_modifier_date_format($_tmp)); ?>

                    </div>
                </a>

                <?php if ($this->_tpl_vars['art']['sub_title'] != null): ?>
                    <div class="entry" style="float:left; width:85%;"><?php echo $this->_tpl_vars['art']['sub_title']; ?>
</div>
                <?php endif; ?>
                
                <?php if ($this->_tpl_vars['art']['url'] == null || $this->_tpl_vars['art']['url'] == ""): ?>
                    <div class="entry" style="width:98%;">
                        <?php echo ((is_array($_tmp=$this->_tpl_vars['art']['body'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 300) : smarty_modifier_truncate($_tmp, 300)); ?>

                        <a class="more" href="<?php echo @URL; ?>
/a/<?php echo $this->_tpl_vars['art']['id']; ?>
"> &raquo;read more</a>
                    </div>
                <?php else: ?>
                    <div class="entry" style="width:98%;">
                        <?php echo ((is_array($_tmp=$this->_tpl_vars['art']['body'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 300) : smarty_modifier_truncate($_tmp, 300)); ?>

                        <a class="more" href="<?php echo @URL; ?>
/a/<?php echo $this->_tpl_vars['art']['url']; ?>
"> &raquo;read more</a>
                    </div>
                <?php endif; ?>

                <div class="entry" style="width:98%;">
                    
                    Rating: <?php echo $this->_tpl_vars['art']['rating']; ?>

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
                        <?php if ($this->_sections['foo']['index'] <= $this->_tpl_vars['art']['rating']): ?>
                            <img src="<?php echo @URL; ?>
/interface/icos/star.png" alt="Rating <?php echo $this->_sections['foo']['index']; ?>
" width="12px"/>
                        <?php elseif ($this->_sections['foo']['index'] > $this->_tpl_vars['art']['rating']): ?>
                            <img src="<?php echo @URL; ?>
/interface/icos/star_dull.png" alt="<?php echo $this->_sections['foo']['index']; ?>
" width="12px"/>
                        <?php endif; ?>
                    <?php endfor; endif; ?>
                     | Views: <?php echo $this->_tpl_vars['art']['view_count']; ?>


                    <?php if ($this->_tpl_vars['art']['user_email'] == $this->_tpl_vars['email']): ?>
                        | <span><a href="<?php echo @URL; ?>
/article/edit/<?php echo $this->_tpl_vars['art']['id']; ?>
">Edit this page</a>&nbsp;|&nbsp;<a href="<?php echo @URL; ?>
/article/delete/<?php echo $this->_tpl_vars['art']['id']; ?>
" class="artdel">Delete this page</a></span>
                    <?php endif; ?>
                    | <a href="<?php echo @URL; ?>
/article/categorybrowse/<?php echo ((is_array($_tmp=$this->_tpl_vars['art']['category'])) ? $this->_run_mod_handler('replace', true, $_tmp, ' ', '_') : smarty_modifier_replace($_tmp, ' ', '_')); ?>
"><?php echo $this->_tpl_vars['art']['category']; ?>
</a>
                </div>
            </div>
        <?php endforeach; endif; unset($_from); ?>
        <div style="float:left; width:740px;" >
            <br />
            <span style='float:right;' class="pageLink"><?php echo smarty_function_paginate_first(array(), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_prev(array(), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_middle(array('format' => 'page','prefix' => "",'suffix' => "",'link_prefix' => "&nbsp;",'link_suffix' => "&nbsp;"), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_next(array(), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_last(array(), $this);?>
</span>
        </div>
    <?php else: ?>
        <p>There are no published page</p>
    <?php endif; ?> 
</div>

<?php echo '
<script type="text/javascript">
$(document).ready(function(){
    $(\'a.artdel\').click(function(){
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