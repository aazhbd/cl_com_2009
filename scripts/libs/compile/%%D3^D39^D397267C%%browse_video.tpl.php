<?php /* Smarty version 2.6.26, created on 2011-02-04 23:45:36
         compiled from browse_video.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'paginate_first', 'browse_video.tpl', 42, false),array('function', 'paginate_prev', 'browse_video.tpl', 42, false),array('function', 'paginate_middle', 'browse_video.tpl', 42, false),array('function', 'paginate_next', 'browse_video.tpl', 42, false),array('function', 'paginate_last', 'browse_video.tpl', 42, false),array('modifier', 'date_format', 'browse_video.tpl', 49, false),array('modifier', 'replace', 'browse_video.tpl', 69, false),array('modifier', 'capitalize', 'browse_video.tpl', 69, false),)), $this); ?>
<div style="width:740px;">
        <div id="pginfo">
        Browse latest videos published by users of conveylive. You may browse videos by category.
        Watch videos and share with your friends. If you are logedin you may post comments to give some feedback and rate them if you like or dislike them.
    </div>
    <div style="padding: 1em;">
        <?php if ($this->_tpl_vars['pubList'] != null): ?>
            <br />
            <div class="browsecat" style="float:left;">
                <h3>Published Categories</h3>
                <div class="catmenuLink" style="border:none; ">
                    <?php $_from = $this->_tpl_vars['pubList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['video']):
?>
                        <div><a href="<?php echo @URL; ?>
/video/categorybrowse/<?php echo $this->_tpl_vars['video']['linkcat']; ?>
"><?php echo $this->_tpl_vars['video']['cat']['cname']; ?>
 (<?php echo $this->_tpl_vars['video']['count']; ?>
) </a></div>
                    <?php endforeach; endif; unset($_from); ?>
                </div>
            </div>
        <?php endif; ?>
        <?php if ($this->_tpl_vars['selfList'] != null): ?>
            <div class="browsecat" style="float:left;">
                <h3>Personal Upload Categories</h3>
                <div class="catmenuLink" style="border:none; ">
                <?php $_from = $this->_tpl_vars['selfList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['video']):
?>
                    <div><a href="<?php echo @URL; ?>
/video/categorybrowse/<?php echo $this->_tpl_vars['video']['linkcat']; ?>
/self"><?php echo $this->_tpl_vars['video']['cat']['cname']; ?>
 (<?php echo $this->_tpl_vars['video']['count']; ?>
) </a></div>
                <?php endforeach; endif; unset($_from); ?>
                </div>
            </div>
        <?php endif; ?>

    </div>

    <div style="float:left;width:740px;">
        <br /><br />
        <div style="width:740px;">
            <h3><?php echo $this->_tpl_vars['topicHead']; ?>
</h3>
        </div>
    </div>
    <div style="width:740px;">
        <?php if ($this->_tpl_vars['videoList'] != null): ?>
            <div>            
                <span style='float:left;' class="pageLink">Showing videos <?php echo $this->_tpl_vars['paginate']['first']; ?>
-<?php echo $this->_tpl_vars['paginate']['last']; ?>
 of <?php echo $this->_tpl_vars['paginate']['total']; ?>
</span>
                <span style='float:right;' class="pageLink"><?php echo smarty_function_paginate_first(array(), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_prev(array(), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_middle(array('format' => 'page','prefix' => "",'suffix' => "",'link_prefix' => "&nbsp;",'link_suffix' => "&nbsp;"), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_next(array(), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_last(array(), $this);?>
</span>
            </div>
            <?php $_from = $this->_tpl_vars['videoList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['video']):
?>
                <br />
                <div class="artcont">
                    <a href='<?php echo @URL; ?>
/video/watch/<?php echo $this->_tpl_vars['video']['id']; ?>
' id="titleblock" class="entry" style="width:65%;"><?php echo $this->_tpl_vars['video']['title']; ?>
</a>
                    
                    <a href="<?php echo @URL; ?>
/profile/view/<?php echo $this->_tpl_vars['video']['pid']; ?>
" class="entry" style="width:30%;" id="titleblock"><?php echo $this->_tpl_vars['video']['author']; ?>
 | <?php echo ((is_array($_tmp=$this->_tpl_vars['video']['ins_date'])) ? $this->_run_mod_handler('date_format', true, $_tmp) : smarty_modifier_date_format($_tmp)); ?>
</a>
                    
                    <div style="float: none; width: 98%;">
                        <div class="entry" style="width:auto;">
                            <a href="<?php echo @URL; ?>
/video/watch/<?php echo $this->_tpl_vars['video']['id']; ?>
"><img src="<?php echo @URL; ?>
/getsmimage.php?id=<?php echo $this->_tpl_vars['video']['img_id']; ?>
" width="200" alt="Video, <?php echo $this->_tpl_vars['video']['title']; ?>
, <?php echo $this->_tpl_vars['video']['author']; ?>
, <?php echo $this->_tpl_vars['video']['category']; ?>
, ConveyLive" /></a>
                        </div>
                        <div class="entry" style="width:45%;">
                            <?php echo $this->_tpl_vars['video']['artist']; ?>

                        </div>
                    </div>
                    
                    <div class="entry" style="width:100%;">
                        Rating: <?php echo $this->_tpl_vars['video']['rating']; ?>
 
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
                            <?php if ($this->_sections['foo']['index'] <= $this->_tpl_vars['video']['rating']): ?>
                                <img src="<?php echo @URL; ?>
/interface/icos/star.png" alt="<?php echo $this->_tpl_vars['video']['title']; ?>
 , <?php echo $this->_tpl_vars['video']['title']; ?>
" width="12px"/>
                            <?php elseif ($this->_sections['foo']['index'] > $this->_tpl_vars['video']['rating']): ?>
                                <img src="<?php echo @URL; ?>
/interface/icos/star_dull.png" alt="<?php echo $this->_tpl_vars['video']['title']; ?>
 , <?php echo $this->_tpl_vars['video']['title']; ?>
" width="12px"/>
                            <?php endif; ?>
                        <?php endfor; endif; ?>
                        | Played: <?php echo $this->_tpl_vars['video']['view_count']; ?>
 | <a href="<?php echo @URL; ?>
/video/categorybrowse/<?php echo ((is_array($_tmp=$this->_tpl_vars['video']['category'])) ? $this->_run_mod_handler('replace', true, $_tmp, ' ', '_') : smarty_modifier_replace($_tmp, ' ', '_')); ?>
"><?php echo ((is_array($_tmp=$this->_tpl_vars['video']['category'])) ? $this->_run_mod_handler('capitalize', true, $_tmp) : smarty_modifier_capitalize($_tmp)); ?>
 </a>
                        <?php if ($this->_tpl_vars['video']['user_email'] == $this->_tpl_vars['email']): ?>
                            | <a href="<?php echo @URL; ?>
/video/delete/<?php echo $this->_tpl_vars['video']['id']; ?>
" class="videodel">Delete Video</a>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; endif; unset($_from); ?>

            <div style="width:740px;">
                <span style="float:right;" class="pageLink"><?php echo smarty_function_paginate_first(array(), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_prev(array(), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_middle(array('format' => 'page','prefix' => "",'suffix' => "",'link_prefix' => "&nbsp;",'link_suffix' => "&nbsp;"), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_next(array(), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_last(array(), $this);?>
</span>
            </div>
        <?php else: ?>
            <p>No latest video has been published.</p>
        <?php endif; ?>
    </div>
</div>
<?php echo '
<script type="text/javascript">
$(document).ready(function(){
    $(\'a.videodel\').click(function(){
       var link = $(this).attr(\'href\');
        jConfirm(\'Are you sure you want to delete this video?\', \'Confirmation Dialog\', function(r) {
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