<?php /* Smarty version 2.6.26, created on 2011-02-22 11:18:33
         compiled from watchvideo.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'watchvideo.tpl', 9, false),array('modifier', 'default', 'watchvideo.tpl', 13, false),array('modifier', 'replace', 'watchvideo.tpl', 31, false),array('modifier', 'truncate', 'watchvideo.tpl', 113, false),)), $this); ?>
<div style="width:740px;"> 
    <?php if ($this->_tpl_vars['video'] != null): ?>
        <div id="box">
            <div style="width:42px; height:42px; float:left;">
                <a href="<?php echo @URL; ?>
/profile/view/<?php echo $this->_tpl_vars['video']['pid']; ?>
"><img src="<?php echo @URL; ?>
/getsmimage.php?id=<?php echo $this->_tpl_vars['video']['user_imgs_id']; ?>
" alt="<?php echo $this->_tpl_vars['video']['name']; ?>
" height="40" /></a>
            </div>
            <div class="smallbox">
                <a href="<?php echo @URL; ?>
/profile/view/<?php echo $this->_tpl_vars['video']['pid']; ?>
"><?php echo $this->_tpl_vars['video']['f_name']; ?>
 <?php echo $this->_tpl_vars['video']['l_name']; ?>
</a><br />
                <?php echo ((is_array($_tmp=$this->_tpl_vars['video']['ins_date'])) ? $this->_run_mod_handler('date_format', true, $_tmp) : smarty_modifier_date_format($_tmp)); ?>
            
            </div>
            
            <div class="infobox">
                <?php echo ((is_array($_tmp=@$this->_tpl_vars['com_count'])) ? $this->_run_mod_handler('default', true, $_tmp, '0') : smarty_modifier_default($_tmp, '0')); ?>
 Comments | Played <?php echo $this->_tpl_vars['video']['view_count']; ?>
 times |
                <?php echo $this->_tpl_vars['video']['tothits']; ?>
 Hits 
                <br />
                <?php if ($this->_tpl_vars['video']['user_email'] != $this->_tpl_vars['email'] && $this->_tpl_vars['islogin'] == true): ?>
                    Rate up&nbsp;<a href="<?php echo @URL; ?>
/video/rateup/<?php echo $this->_tpl_vars['video']['id']; ?>
" ><img src="<?php echo @URL; ?>
/interface/icos/thumbs_up.gif" width="15px" alt="<?php echo $this->_tpl_vars['video']['name']; ?>
,rating-up, <?php echo $this->_tpl_vars['video']['title']; ?>
" border="0"/></a> &nbsp;
                    Rate down&nbsp;<a href="<?php echo @URL; ?>
/video/ratedown/<?php echo $this->_tpl_vars['video']['id']; ?>
" ><img src="<?php echo @URL; ?>
/interface/icos/thumbs_down.gif" width="15px" alt="<?php echo $this->_tpl_vars['video']['name']; ?>
, rating-down, <?php echo $this->_tpl_vars['video']['title']; ?>
" border="0" /></a>
                <?php endif; ?>
            </div>
            
            <div class="ratingbox">
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
 , <?php echo $this->_tpl_vars['video']['f_name']; ?>
, <?php echo $this->_tpl_vars['video']['l_name']; ?>
" width="12px"/>
                    <?php elseif ($this->_sections['foo']['index'] > $this->_tpl_vars['video']['rating']): ?>
                        <img src="<?php echo @URL; ?>
/interface/icos/star_dull.png" alt="<?php echo $this->_tpl_vars['video']['title']; ?>
 , <?php echo $this->_tpl_vars['video']['f_name']; ?>
, <?php echo $this->_tpl_vars['video']['l_name']; ?>
" width="12px"/>
                    <?php endif; ?>
                <?php endfor; endif; ?>
                <?php if ($this->_tpl_vars['video']['category'] != ""): ?><br /><a href="<?php echo @URL; ?>
/video/categorybrowse/<?php echo ((is_array($_tmp=$this->_tpl_vars['video']['category'])) ? $this->_run_mod_handler('replace', true, $_tmp, ' ', '_') : smarty_modifier_replace($_tmp, ' ', '_')); ?>
"><?php echo $this->_tpl_vars['video']['category']; ?>
<?php endif; ?></a>
            </div>
        </div>
    <?php endif; ?>
</div>
<br />
<div style="width:740px;">
    <?php if ($this->_tpl_vars['prev'] != null): ?>
        <div style="float:left;">
            <a href="<?php echo @URL; ?>
/video/watch/<?php echo $this->_tpl_vars['prev']['id']; ?>
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
/video/watch/<?php echo $this->_tpl_vars['next']['id']; ?>
" title="<?php echo $this->_tpl_vars['next']['title']; ?>
">
                <div style="float: left; padding: 10px;">Next</div>
                <div style="float: left;"><img src="<?php echo @URL; ?>
/interface/images/right_arrow.png" /></div>
            </a>            
        </div>
    <?php endif; ?>
</div>

<?php if ($this->_tpl_vars['video'] != null): ?>
    <div style="float:left; width:580px;margin-top:10px;">    
        <center>                
                <div>
                    <a 
                        href="<?php echo @URL; ?>
/directories/videos/<?php echo $this->_tpl_vars['video']['file_path']; ?>
"
                        style="display:block;width:570px;height:350px;" 
                        id="player"
                        title="<?php echo $this->_tpl_vars['video']['title']; ?>
 - Artist - <?php echo $this->_tpl_vars['video']['artist']; ?>
 , pubished by <?php echo $this->_tpl_vars['video']['f_name']; ?>
, <?php echo $this->_tpl_vars['video']['l_name']; ?>
, Category - <?php echo $this->_tpl_vars['video']['category']; ?>
">
                        
                    </a>
                    <div class="info" ></div>
                </div>
                
        </center>
        <br />    
        <div style="width:570px;">
            <?php if ($this->_tpl_vars['video']['user_email'] == $this->_tpl_vars['email'] && $this->_tpl_vars['islogin'] == true): ?>
                <br /><br />
                <a href="<?php echo @URL; ?>
/video/delete/<?php echo $this->_tpl_vars['video']['id']; ?>
" class="artdel"><img src="<?php echo @URL; ?>
/interface/icos/delete_post.png" style="width:20px;" /> Delete this video</a></span>
            <?php endif; ?>
            <?php if ($this->_tpl_vars['video']['artist'] != null): ?>
                <br />
                <div style="font-weight:bold;">
                    In this video: <?php echo $this->_tpl_vars['video']['artist']; ?>
<br />
                </div>
                <br />
            <?php endif; ?>
        </div>
        <hr />
        <div style="float:left;width:570px; margin-top:5px;">
            <?php if ($this->_tpl_vars['video']['additional'] != ""): ?>
                <div class="entry" style="width:95%;">
                    <img src="<?php echo @URL; ?>
/interface/icos/posttopic.png" style="width:30px;" />
                    <span style="font-weight:bold;">Additional Info: </span> <?php echo $this->_tpl_vars['video']['additional']; ?>

                </div>
            <?php endif; ?>
            <?php if ($this->_tpl_vars['video']['meta_tags'] != ""): ?>
                <div class="entry" style="width:95%;">
                    <img src="<?php echo @URL; ?>
/interface/icos/key.png" style="width:30px;" />
                    <span style="font-weight:bold;">Keywords: </span> <?php echo $this->_tpl_vars['video']['meta_tags']; ?>

                </div>
            <?php endif; ?>
        </div>
    </div>
<?php else: ?>
    <div id="pginfo">No video is available</div>
<?php endif; ?>    
<div style="width:160px;float:left;">
    <?php if ($this->_tpl_vars['relArt'] != null): ?>
        <div style="width:160px;">
            <h3 style="padding-left:10px;"><img src="<?php echo @URL; ?>
/interface/icos/tag_blue.png" style="width:25px;margin-left:5px;margin-right:5px;" />Related Videos</h3>
            <div class="relList">
                <br />
                <?php $_from = $this->_tpl_vars['relArt']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['art']):
?>
                    <div align="center">
                        <a href="<?php echo @URL; ?>
/video/watch/<?php echo $this->_tpl_vars['art']['id']; ?>
" ><img src="<?php echo @URL; ?>
/getsmimage.php?id=<?php echo $this->_tpl_vars['art']['img_id']; ?>
" width="130" /></a>
                        <a href='<?php echo @URL; ?>
/video/watch/<?php echo $this->_tpl_vars['art']['id']; ?>
'><?php echo ((is_array($_tmp=$this->_tpl_vars['art']['title'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 30) : smarty_modifier_truncate($_tmp, 30)); ?>
</a>
                    </div>
                    <br />
                <?php endforeach; endif; unset($_from); ?>
                <div>Browse related videos of category <a href="<?php echo @URL; ?>
/video/categorybrowse/<?php echo ((is_array($_tmp=$this->_tpl_vars['video']['category'])) ? $this->_run_mod_handler('replace', true, $_tmp, ' ', '_') : smarty_modifier_replace($_tmp, ' ', '_')); ?>
"> >> <?php echo ((is_array($_tmp=$this->_tpl_vars['video']['category'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 30) : smarty_modifier_truncate($_tmp, 30)); ?>
</a></div>
            </div>
            
        </div>
    <?php else: ?>
        <br />
    <?php endif; ?>
</div>

<?php if ($this->_tpl_vars['video'] != null): ?>
<div style="float:left; width:740px;">
    <br />
    <?php if ($this->_tpl_vars['coms'] != null): ?>
        <br />
        <h3><img src="<?php echo @URL; ?>
/interface/icos/comments.png" style="width:30px;" />Comments on this video</h3>
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
    <?php if ($this->_tpl_vars['islogin'] == true): ?>
        <?php $this->assign('mid', $this->_tpl_vars['video']['id']); ?>
        <?php $this->assign('mtype', 'Video'); ?>
        
        <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'frm_comment.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>    
    <?php else: ?>
        <div style="width:550px;" id="addcomment">
            <h3>Please <a href="<?php echo @URL; ?>
/signup">Signup</a> to comment on this video</h3>
        </div>    
    <?php endif; ?>
</div>
<?php endif; ?>

<?php if ($this->_tpl_vars['video'] != null && $this->_tpl_vars['islogin'] == true): ?>
    <br />
    <div style="width:740px;">
        <br />
        <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "invitecontent_form.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
    </div>
<?php endif; ?>
<?php echo '
<script type="text/javascript">
var srcurl = '; ?>
'<?php echo @URL; ?>
/scripts/player/flowplayer-3.1.5.swf'<?php echo ';
    flowplayer(
        \'player\',
        {
            src: srcurl,
            wmode: \'opaque\',
            onFail: function()  { 
                document.getElementById("info").innerHTML = 
                    "You need the latest Flash version to Conveylive Videos. " + 
                    "Your version is " + this.getVersion() 
                ; 
            },
            version: [9, 115],
            
            onFinish: function() {
                alert("Click Player to start video again"); 
            }
                       
        },
        {
            clip:  {
                autoPlay: false,
                autoBuffering: true
            }
        }
    );
</script>
'; ?>

<?php echo '
<script type="text/javascript">
$(document).ready(function()
{        
    $(\'a.delvid\').click(function(){
       var link = $(this).attr(\'href\');
        jConfirm(\'Are you sure you want to delete this Video?\', \'Confirmation Dialog\', function(r) {
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
