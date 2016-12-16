<?php /* Smarty version 2.6.26, created on 2010-11-22 12:23:46
         compiled from topinfo.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'topinfo.tpl', 8, false),array('modifier', 'default', 'topinfo.tpl', 11, false),array('modifier', 'replace', 'topinfo.tpl', 29, false),)), $this); ?>
<div style="float:left;width:98%;">
    <div id="box">
        <div style="width:42px; height:42px; float:left;">
            <a href="<?php echo @URL; ?>
/profile/view/<?php echo $this->_tpl_vars['pid']; ?>
"><img src="<?php echo @URL; ?>
/getsmimage.php?id=<?php echo $this->_tpl_vars['img_id']; ?>
" alt="<?php echo $this->_tpl_vars['uname']; ?>
" height="40" /></a>
        </div>
        <div class="smallbox">
            <a href="<?php echo @URL; ?>
/profile/view/<?php echo $this->_tpl_vars['pid']; ?>
"><?php echo $this->_tpl_vars['uname']; ?>
</a><br />
            <?php echo ((is_array($_tmp=$this->_tpl_vars['imgstats']['ins_date'])) ? $this->_run_mod_handler('date_format', true, $_tmp) : smarty_modifier_date_format($_tmp)); ?>

        </div>
        <div class="infobox">
            <?php echo ((is_array($_tmp=@$this->_tpl_vars['com_count'])) ? $this->_run_mod_handler('default', true, $_tmp, '0') : smarty_modifier_default($_tmp, '0')); ?>
 Comments | <?php echo $this->_tpl_vars['imgstats']['view_count']; ?>
 Views |
            <?php echo $this->_tpl_vars['imgstats']['tothits']; ?>
 Hits
            <br />
            <?php if ($this->_tpl_vars['imgstats']['user_email'] != $this->_tpl_vars['email'] && $this->_tpl_vars['islogin'] == true): ?>
                Rate up &nbsp;<a href="<?php echo @URL; ?>
/picture/rateup/<?php echo $this->_tpl_vars['media_id']; ?>
" id="rateup" title="Rate Up"><img src="<?php echo @URL; ?>
/interface/icos/thumbs_up.gif" width="15px" alt="<?php echo $this->_tpl_vars['uname']; ?>
,rating-up, <?php echo $this->_tpl_vars['album_name']; ?>
" border="0"/></a> &nbsp;
                Rate down &nbsp;<a href="<?php echo @URL; ?>
/picture/ratedown/<?php echo $this->_tpl_vars['media_id']; ?>
" id="ratedown" title="Rate down"><img src="<?php echo @URL; ?>
/interface/icos/thumbs_down.gif" width="15px" alt="<?php echo $this->_tpl_vars['uname']; ?>
, rating-down, <?php echo $this->_tpl_vars['album_name']; ?>
" border="0" /></a>
            <?php endif; ?>
        </div>
        <div class="ratingbox">
            Rating: <?php echo $this->_tpl_vars['imgstats']['rating']; ?>

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
                <?php if ($this->_sections['foo']['index'] <= $this->_tpl_vars['imgstats']['rating']): ?>
                    <img src="<?php echo @URL; ?>
/interface/icos/star.png" alt="<?php echo $this->_tpl_vars['uname']; ?>
 , <?php echo $this->_tpl_vars['album_name']; ?>
" width="12px"/>
                <?php elseif ($this->_sections['foo']['index'] > $this->_tpl_vars['imgstats']['rating']): ?>
                    <img src="<?php echo @URL; ?>
/interface/icos/star_dull.png" alt="<?php echo $this->_tpl_vars['uname']; ?>
 , <?php echo $this->_tpl_vars['album_name']; ?>
" width="12px"/>
                <?php endif; ?>
            <?php endfor; endif; ?>
            
            <?php if ($this->_tpl_vars['album_name'] != ""): ?><br /><a href="<?php echo @URL; ?>
/article/categorybrowse/<?php echo ((is_array($_tmp=$this->_tpl_vars['article']['album_name'])) ? $this->_run_mod_handler('replace', true, $_tmp, ' ', '_') : smarty_modifier_replace($_tmp, ' ', '_')); ?>
"><?php echo $this->_tpl_vars['album_name']; ?>
<?php endif; ?></a>
        </div>
    </div>
</div>