<?php /* Smarty version 2.6.26, created on 2010-02-15 12:41:10
         compiled from play_audio.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'capitalize', 'play_audio.tpl', 22, false),array('modifier', 'date_format', 'play_audio.tpl', 23, false),array('modifier', 'default', 'play_audio.tpl', 49, false),array('modifier', 'replace', 'play_audio.tpl', 50, false),array('modifier', 'truncate', 'play_audio.tpl', 83, false),)), $this); ?>
<div style="width:740px;">
    <div style="width:740px;">
        <?php if ($this->_tpl_vars['prev'] != null): ?>
            <div style="float:left;">
                <a href="<?php echo @URL; ?>
/audio/listen/<?php echo $this->_tpl_vars['prev']['id']; ?>
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
                <a href="<?php echo @URL; ?>
/audio/listen/<?php echo $this->_tpl_vars['next']['id']; ?>
" title="<?php echo $this->_tpl_vars['next']['title']; ?>
">
                    <div style="float: left; padding: 10px;">Next</div>
                    <div style="float: left;"><img src="<?php echo @URL; ?>
/interface/images/right_arrow.png" /></div>
                </a>
            </div>
        <?php endif; ?>
    </div>
    <?php if ($this->_tpl_vars['audio'] != null): ?>
        <div class="artcont" style="float:left;width:730px;">
            <div class="entry" style="width:60%; font-weight:bold; font-size:16px;"><a href='<?php echo @URL; ?>
/audio/listen/<?php echo $this->_tpl_vars['audio']['id']; ?>
'><?php echo ((is_array($_tmp=$this->_tpl_vars['audio']['title'])) ? $this->_run_mod_handler('capitalize', true, $_tmp) : smarty_modifier_capitalize($_tmp)); ?>
</a></div>
            <div class="entry" style="width:37%;" align="right">by <a href="<?php echo @URL; ?>
/profile/view/<?php echo $this->_tpl_vars['audio']['pid']; ?>
"><?php echo $this->_tpl_vars['audio']['author']; ?>
</a> | <?php echo ((is_array($_tmp=$this->_tpl_vars['audio']['ins_date'])) ? $this->_run_mod_handler('date_format', true, $_tmp) : smarty_modifier_date_format($_tmp)); ?>
</div>
            <div class="entry" style="width:60%;"><?php echo $this->_tpl_vars['audio']['artist']; ?>
</div>

            <div class="entry" style="width:98%;" align="center">
                <object type='application/x-shockwave-flash' data='<?php echo @URL; ?>
/scripts/player/mp3player.swf' width='300' height='30'>
                     <param name='movie' value='<?php echo @URL; ?>
/scripts/player/mp3player.swf' />
                     <param name = 'wmode' value = 'transparent' / >
                     <param name='FlashVars' value="mp3=<?php echo @URL; ?>
/getaudio.php?id=<?php echo $this->_tpl_vars['audio']['id']; ?>
&amp;showstop=1&amp;showvolume=1" />
                </object><br />
                Click the play button to play this audio
            </div>
            <div class="entry" style="width:100%;">
                Hits : <?php echo $this->_tpl_vars['audio']['tothits']; ?>
 
                <?php if ($this->_tpl_vars['audio']['user_email'] != $this->_tpl_vars['email'] && $this->_tpl_vars['islogin'] == true): ?>
                    <a href="<?php echo @URL; ?>
/audio/rateup/<?php echo $this->_tpl_vars['audio']['id']; ?>
" ><img src="<?php echo @URL; ?>
/interface/icos/thumbs_up.gif" width="15px" alt="<?php echo $this->_tpl_vars['audio']['name']; ?>
,rating-up, <?php echo $this->_tpl_vars['audio']['title']; ?>
" border="0"/></a> &nbsp;
                    <a href="<?php echo @URL; ?>
/audio/ratedown/<?php echo $this->_tpl_vars['audio']['id']; ?>
" ><img src="<?php echo @URL; ?>
/interface/icos/thumbs_down.gif" width="15px" alt="<?php echo $this->_tpl_vars['audio']['name']; ?>
, rating-down, <?php echo $this->_tpl_vars['audio']['title']; ?>
" border="0" /></a>
                <?php endif; ?>
                | Rating: <?php echo $this->_tpl_vars['audio']['rating']; ?>

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

                | Comments <?php echo ((is_array($_tmp=@$this->_tpl_vars['com_count'])) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0)); ?>

                | <a href="<?php echo @URL; ?>
/audio/genrebrowse/<?php echo ((is_array($_tmp=$this->_tpl_vars['audio']['genre'])) ? $this->_run_mod_handler('replace', true, $_tmp, ' ', '_') : smarty_modifier_replace($_tmp, ' ', '_')); ?>
"><?php echo ((is_array($_tmp=$this->_tpl_vars['audio']['genre'])) ? $this->_run_mod_handler('capitalize', true, $_tmp) : smarty_modifier_capitalize($_tmp)); ?>
 </a>
                
                <?php if ($this->_tpl_vars['audio']['user_email'] == $this->_tpl_vars['email'] && $this->_tpl_vars['islogin'] == true): ?>
                    <br /><br />
                    <a href="<?php echo @URL; ?>
/audio/edit/<?php echo $this->_tpl_vars['audio']['id']; ?>
">Edit Audio Info</a> | <a href="<?php echo @URL; ?>
/audio/delete/<?php echo $this->_tpl_vars['audio']['id']; ?>
" class="audiodel">Delete Audio</a>
                <?php endif; ?>                
            </div>
            <br />
        </div>
        <?php if ($this->_tpl_vars['audio']['additional'] != "" || $this->_tpl_vars['audio']['meta_tags'] != ""): ?>
            <div style="float:left;width:350px; margin-top:5px;">
                <?php if ($this->_tpl_vars['audio']['additional'] != ""): ?>
                    <div class="entry" style="width:95%;">
                        <img src="<?php echo @URL; ?>
/interface/icos/posttopic.png" style="width:30px;" />
                        <span style="font-weight:bold;">Additional Info: </span> <?php echo $this->_tpl_vars['audio']['additional']; ?>

                    </div>
                <?php endif; ?>
                <?php if ($this->_tpl_vars['audio']['meta_tags'] != ""): ?>
                    <div class="entry" style="width:95%;">
                        <img src="<?php echo @URL; ?>
/interface/icos/key.png" style="width:30px;" />
                        <span style="font-weight:bold;">Keywords: </span> <?php echo $this->_tpl_vars['audio']['meta_tags']; ?>

                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>
        <?php if ($this->_tpl_vars['latArt'] != null): ?>
            <div style="float:left;width:180px;margin-top:5px;">
                <h3>Latest Audio</h3>
                <div class="relList">
                    <?php $_from = $this->_tpl_vars['latArt']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['art']):
?>
                        <li style="padding:2px; list-style:none;">
                            <a href='<?php echo @URL; ?>
/audio/listen/<?php echo $this->_tpl_vars['art']['id']; ?>
'>
                                <img src="<?php echo @URL; ?>
/interface/icos/arrow_gray.gif" style="width:7px;"/> 
                                <?php echo ((is_array($_tmp=$this->_tpl_vars['art']['title'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 20) : smarty_modifier_truncate($_tmp, 20)); ?>

                            </a>
                        </li>
                    <?php endforeach; endif; unset($_from); ?>
                </div>
                <p><a href="<?php echo @URL; ?>
/audio/browse">Browse All Latest Audio</a></p>
            </div>
        <?php else: ?>    
            <br />
        <?php endif; ?>
        
        <?php if ($this->_tpl_vars['popArt'] != null): ?>
            <div style="float:left;width:200px;margin-top:5px;">
                <h3>Popular Audio</h3>
                <div class="relList">
                    <?php $_from = $this->_tpl_vars['popArt']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['art']):
?>
                        <li style="padding:2px; list-style:none;">
                            <a href='<?php echo @URL; ?>
/audio/listen/<?php echo $this->_tpl_vars['art']['id']; ?>
'>
                                <img src="<?php echo @URL; ?>
/interface/icos/arrow_gray.gif" style="width:7px;"/> 
                                <?php echo ((is_array($_tmp=$this->_tpl_vars['art']['title'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 20) : smarty_modifier_truncate($_tmp, 20)); ?>

                            </a>
                        </li>
                    <?php endforeach; endif; unset($_from); ?>
                </div>
            </div>
        <?php else: ?>    
            <br />
        <?php endif; ?>
    <?php else: ?>
        This audio is not available
    <?php endif; ?>

    <div style="width:730px;float:left;">
        <?php if ($this->_tpl_vars['coms'] != null): ?>
            <br />
            <h3><img src="<?php echo @URL; ?>
/interface/icos/comments.png" style="width:30px;" />Comments on this audio</h3>
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
        <?php if ($this->_tpl_vars['islogin'] == true): ?>
            <?php $this->assign('mid', $this->_tpl_vars['audio']['id']); ?>
            <?php $this->assign('mtype', 'Audio'); ?>
            
            <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'frm_comment.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>        
        <?php else: ?>
            <div style="width:550px;" id="addcomment">
                <h3>Please <a href="<?php echo @URL; ?>
/signup">Signup</a> to comment on this audio</h3>
            </div>
        <?php endif; ?>
    </div>
    
    <?php if ($this->_tpl_vars['relArt'] != null): ?>
        <div style="width:720px;float:left; margin-top:10px; " class="invitebox">
            <h3>Related Audio</h3>
            <div class="relList">
                <?php $_from = $this->_tpl_vars['relArt']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['art']):
?>
                    <li style="padding:5px; list-style:none;">
                        <a href="<?php echo @URL; ?>
/audio/listen/<?php echo $this->_tpl_vars['art']['id']; ?>
" >
                            <img src="<?php echo @URL; ?>
/interface/icos/arrow_gray.gif" style="width:7px;"/>&nbsp;<?php echo $this->_tpl_vars['art']['title']; ?>

                        </a>
                    </li>
                <?php endforeach; endif; unset($_from); ?>
            </div>
            <div style="padding:10px;">
                Browse other audios from this genre >> <a href="<?php echo @URL; ?>
/audio/genrebrowse/<?php echo ((is_array($_tmp=$this->_tpl_vars['audio']['genre'])) ? $this->_run_mod_handler('replace', true, $_tmp, ' ', '_') : smarty_modifier_replace($_tmp, ' ', '_')); ?>
"><?php echo $this->_tpl_vars['audio']['genre']; ?>
</a>
            </div>
        </div>
    <?php endif; ?>
</div>
<?php if ($this->_tpl_vars['audio'] != null && $this->_tpl_vars['islogin'] == true): ?>
    <br />
    <div style="width:740px;">
        <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "invitecontent_form.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
    </div>
<?php endif; ?>

<?php echo '
<script type="text/javascript">
$(document).ready(function()
{        
    $(\'a.audiodel\').click(function(){
       var link = $(this).attr(\'href\');
        jConfirm(\'Are you sure you want to delete this audio?\', \'Confirmation Dialog\', function(r) {
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