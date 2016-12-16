<?php /* Smarty version 2.6.26, created on 2010-02-14 06:00:18
         compiled from browse_audio.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'paginate_first', 'browse_audio.tpl', 52, false),array('function', 'paginate_prev', 'browse_audio.tpl', 52, false),array('function', 'paginate_middle', 'browse_audio.tpl', 52, false),array('function', 'paginate_next', 'browse_audio.tpl', 52, false),array('function', 'paginate_last', 'browse_audio.tpl', 52, false),array('modifier', 'date_format', 'browse_audio.tpl', 61, false),array('modifier', 'replace', 'browse_audio.tpl', 82, false),array('modifier', 'capitalize', 'browse_audio.tpl', 82, false),)), $this); ?>
<div style="float:left; width:740px;">
        <div id="pginfo">
        Browse latest audios published by users of conveylive. You may browse audios by artist or genre.
        Listen to the audios one by one either from browse page or individually. If you are logedin you may post comments to give some feedback and rate them if you like or dislike them.
    </div>
    <?php if ($this->_tpl_vars['audioList'] != null): ?>
        <h3><a href="<?php echo @URL; ?>
/audio/browsegenre">Browse by Genre</a> | <a href="<?php echo @URL; ?>
/audio/browseartist">Browse by Artist</a></h3>
    <?php endif; ?>
    
    <div style="padding: 1em;">
    <?php if ($this->_tpl_vars['pubList'] != null): ?>
        <br />
        <div class="browsecat" style="float:left;">
            <h3>Published Genre</h3>
            <div class="catmenuLink" style="border:none;">
                <?php $_from = $this->_tpl_vars['pubList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['audio']):
?>
                    <li>
                        <a href="<?php echo @URL; ?>
/audio/genrebrowse/<?php echo $this->_tpl_vars['audio']['linkgenre']; ?>
"><?php echo $this->_tpl_vars['audio']['genre']['cname']; ?>
 (<?php echo $this->_tpl_vars['audio']['count']; ?>
) </a>
                    </li>
                <?php endforeach; endif; unset($_from); ?>
            </div>
        </div>
    <?php endif; ?>
    
    <?php if ($this->_tpl_vars['selfList'] != null): ?>
        <div class="browsecat" style="float:left;">
            <h3>Personal Uploaded Genre</h3>
            <div class="catmenuLink" style="border:none; ">
                <?php $_from = $this->_tpl_vars['selfList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['audio']):
?>
                    <li>
                        <a href="<?php echo @URL; ?>
/audio/genrebrowse/<?php echo $this->_tpl_vars['audio']['linkgenre']; ?>
/self"><?php echo $this->_tpl_vars['audio']['genre']['cname']; ?>
 (<?php echo $this->_tpl_vars['audio']['count']; ?>
) </a>
                    </li>
                <?php endforeach; endif; unset($_from); ?>
            </div>
        </div>
    <?php endif; ?>
    </div>
    
    <div style="width:740px;">
        <br />
        <?php if ($this->_tpl_vars['topicHead'] != null): ?>
            <h3><?php echo $this->_tpl_vars['topicHead']; ?>
</h3>
        <?php endif; ?>
    </div>
    
    <div>
        <?php if ($this->_tpl_vars['audioList'] != null): ?>
            <div>
                <span style='float:left;' class="pageLink">Showing audios <?php echo $this->_tpl_vars['paginate']['first']; ?>
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
            
            <div>
            <?php $_from = $this->_tpl_vars['audioList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['audio']):
?>
                <div class="artcont">

                    <a href='<?php echo @URL; ?>
/audio/listen/<?php echo $this->_tpl_vars['audio']['id']; ?>
' class="entry" style="width:60%;" id="titleblock"><?php echo $this->_tpl_vars['audio']['title']; ?>
</a>
                    
                    <a href="<?php echo @URL; ?>
/profile/view/<?php echo $this->_tpl_vars['audio']['pid']; ?>
" class="entry" style="width:30%;" id="titleblock">by <?php echo $this->_tpl_vars['audio']['author']; ?>
 | <?php echo ((is_array($_tmp=$this->_tpl_vars['audio']['ins_date'])) ? $this->_run_mod_handler('date_format', true, $_tmp) : smarty_modifier_date_format($_tmp)); ?>
 </a>
                    
                    <div class="entry" style="width:60%;"><?php echo $this->_tpl_vars['audio']['artist']; ?>
</div>
                    
                    <div class="entry" style="width:30%;">
                        <object type='application/x-shockwave-flash' data='<?php echo @URL; ?>
/scripts/player/mp3player.swf' width='185' height='20'>
                             <param name='movie' value='<?php echo @URL; ?>
/scripts/player/mp3player.swf' />
                             <param name = 'wmode' value = 'transparent' / >
                             <param name='FlashVars' value="mp3=<?php echo @URL; ?>
/getaudio.php?id=<?php echo $this->_tpl_vars['audio']['id']; ?>
" />
                        </object>
                    </div>
                    
                    <div class="entry" style="width:100%;">
                        Rating: <?php echo $this->_tpl_vars['audio']['rating']; ?>

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
                            <?php if ($this->_sections['foo']['index'] <= $this->_tpl_vars['audio']['rating']): ?>
                                <img src="<?php echo @URL; ?>
/interface/icos/star.png" alt="<?php echo $this->_tpl_vars['audio']['author']; ?>
 , <?php echo $this->_tpl_vars['audio']['title']; ?>
" width="12px"/>
                            <?php elseif ($this->_sections['foo']['index'] > $this->_tpl_vars['article']['rating']): ?>
                                <img src="<?php echo @URL; ?>
/interface/icos/star_dull.png" alt="<?php echo $this->_tpl_vars['audio']['author']; ?>
 , <?php echo $this->_tpl_vars['audio']['title']; ?>
" width="12px"/>
                            <?php endif; ?>
                        <?php endfor; endif; ?> 
                        | Played: <?php echo $this->_tpl_vars['audio']['view_count']; ?>
 | <a href="<?php echo @URL; ?>
/audio/genrebrowse/<?php echo ((is_array($_tmp=$this->_tpl_vars['audio']['genre'])) ? $this->_run_mod_handler('replace', true, $_tmp, ' ', '_') : smarty_modifier_replace($_tmp, ' ', '_')); ?>
"><?php echo ((is_array($_tmp=$this->_tpl_vars['audio']['genre'])) ? $this->_run_mod_handler('capitalize', true, $_tmp) : smarty_modifier_capitalize($_tmp)); ?>
</a>
                        <?php if ($this->_tpl_vars['audio']['user_email'] == $this->_tpl_vars['email']): ?>
                            | <a href="<?php echo @URL; ?>
/audio/edit/<?php echo $this->_tpl_vars['audio']['id']; ?>
">Edit Audio Info</a> | <a href="<?php echo @URL; ?>
/audio/delete/<?php echo $this->_tpl_vars['audio']['id']; ?>
" class="audiodel">Delete Audio</a>
                        <?php endif; ?>
                    </div>
                    
                </div>
            <?php endforeach; endif; unset($_from); ?>
            </div>
            
             <br />
             
            <span style='float:right;' class="pageLink"><?php echo smarty_function_paginate_first(array(), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_prev(array(), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_middle(array('format' => 'page','prefix' => "",'suffix' => "",'link_prefix' => "&nbsp;",'link_suffix' => "&nbsp;"), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_next(array(), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_last(array(), $this);?>
</span>
            <br /><br />
        <?php else: ?>
            <p>No latest audio has been published.</p>
        <?php endif; ?>
    </div>
</div>
<?php echo '
<script type="text/javascript">
    $(document).ready(function(){
        $(\'a.audiodel\').click(function(){
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
        })
    });
</script>
'; ?>