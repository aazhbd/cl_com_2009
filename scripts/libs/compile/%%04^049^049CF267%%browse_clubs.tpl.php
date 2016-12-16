<?php /* Smarty version 2.6.26, created on 2010-02-14 12:16:04
         compiled from browse_clubs.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'replace', 'browse_clubs.tpl', 15, false),array('modifier', 'date_format', 'browse_clubs.tpl', 53, false),array('modifier', 'truncate', 'browse_clubs.tpl', 59, false),array('function', 'paginate_first', 'browse_clubs.tpl', 43, false),array('function', 'paginate_prev', 'browse_clubs.tpl', 43, false),array('function', 'paginate_middle', 'browse_clubs.tpl', 43, false),array('function', 'paginate_next', 'browse_clubs.tpl', 43, false),array('function', 'paginate_last', 'browse_clubs.tpl', 43, false),)), $this); ?>
<div style="float:left; width:740px;">
        <div id="pginfo">
        Browse recent clubs published by users of conveylive. You may browse clubs by category.
        Join clubs of your interest. If you are logedin, you may take part in discussion with the club members and share files and photos. You may invite your friends and enjoy various club activities.
        Clubs are of three types: Open, Closed and Secret.
    </div>
    <div style="padding: 1em;">
    <?php if ($this->_tpl_vars['pubList'] != null): ?>
        <br />
        <div class="browsecat" style="float:left;">
            <h3>Public and Closed Club Categories</h3>
            <div class="catmenuLink" style="border:none; ">
                <?php $_from = $this->_tpl_vars['pubList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['club']):
?>
                    <li><a href="<?php echo @URL; ?>
/clubs/catbrowse/<?php echo ((is_array($_tmp=$this->_tpl_vars['club']['cat']['cname'])) ? $this->_run_mod_handler('replace', true, $_tmp, ' ', '_') : smarty_modifier_replace($_tmp, ' ', '_')); ?>
"><?php echo $this->_tpl_vars['club']['cat']['cname']; ?>
 (<?php echo $this->_tpl_vars['club']['count']; ?>
) </a></li>
                <?php endforeach; endif; unset($_from); ?>
            </div>
        </div>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['selfList'] != null): ?>
        <div class="browsecat" style="float:left;">
            <h3>Your club categories</h3>
            <div class="catmenuLink" style="border:none; ">
                <?php $_from = $this->_tpl_vars['selfList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['club']):
?>
                    <li><a href="<?php echo @URL; ?>
/clubs/catbrowse/<?php echo ((is_array($_tmp=$this->_tpl_vars['club']['cat']['cname'])) ? $this->_run_mod_handler('replace', true, $_tmp, ' ', '_') : smarty_modifier_replace($_tmp, ' ', '_')); ?>
/self"><?php echo $this->_tpl_vars['club']['cat']['cname']; ?>
 (<?php echo $this->_tpl_vars['club']['count']; ?>
) </a></li>
                <?php endforeach; endif; unset($_from); ?>
            </div>
        </div>
        <br />
    <?php endif; ?>
    </div>
    <div style="width:740px;">
        <br />
        <?php if ($this->_tpl_vars['topicHead'] != null): ?>
            <h3><?php echo $this->_tpl_vars['topicHead']; ?>
</h3>
        <?php else: ?>
            <h3>Recently Published Clubs</h3>
        <?php endif; ?>
    </div>
    <?php if ($this->_tpl_vars['clubList'] != null): ?> 
        <div>
            <span style="float:left;" class="pageLink">Showing clubs <?php echo $this->_tpl_vars['paginate']['first']; ?>
-<?php echo $this->_tpl_vars['paginate']['last']; ?>
 of <?php echo $this->_tpl_vars['paginate']['total']; ?>
</span>
            <span style="float:right;padding:5px;" class="pageLink"><?php echo smarty_function_paginate_first(array(), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_prev(array(), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_middle(array('format' => 'page','prefix' => "",'suffix' => "",'link_prefix' => "&nbsp;",'link_suffix' => "&nbsp;"), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_next(array(), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_last(array(), $this);?>
</span>
        </div> 
        <div>
            <?php $_from = $this->_tpl_vars['clubList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['club']):
?>
                <?php if (( $this->_tpl_vars['club']['is_member'] == true ) || ( $this->_tpl_vars['club']['is_member'] == false && $this->_tpl_vars['club']['privacy'] != 2 )): ?>
                    <div class="artcont">
                        <a href='<?php echo @URL; ?>
/clubs/view/<?php echo $this->_tpl_vars['club']['id']; ?>
' id="titleblock" class="entry" style="width:65%;font-weight:bold;font-size:16px;" >
                            <?php echo $this->_tpl_vars['club']['cname']; ?>

                        </a>
                        
                        <a href="<?php echo @URL; ?>
/profile/view/<?php echo $this->_tpl_vars['club']['pid']; ?>
" class="entry" style="width:30%; " id="titleblock">by <?php echo $this->_tpl_vars['club']['f_name']; ?>
 <?php echo $this->_tpl_vars['club']['l_name']; ?>
 | <?php echo ((is_array($_tmp=$this->_tpl_vars['club']['ins_date'])) ? $this->_run_mod_handler('date_format', true, $_tmp) : smarty_modifier_date_format($_tmp)); ?>
 </a>
                        
                        <div class="entry" style="width:35%;">
                            <a href='<?php echo @URL; ?>
/clubs/view/<?php echo $this->_tpl_vars['club']['id']; ?>
'><img src="<?php echo @URL; ?>
/getsmimage.php?id=<?php echo $this->_tpl_vars['club']['image_id']; ?>
" alt="<?php echo $this->_tpl_vars['club']['cname']; ?>
,<?php echo $this->_tpl_vars['club']['category']; ?>
, <?php echo $this->_tpl_vars['club']['f_name']; ?>
, <?php echo $this->_tpl_vars['club']['l_name']; ?>
 ConveyLive" width="80" border="1" /></a>
                        </div>
                        <div class="entry" style="width:29%;">
                            <?php echo ((is_array($_tmp=$this->_tpl_vars['club']['description'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 100) : smarty_modifier_truncate($_tmp, 100)); ?>

                        </div>                        
                        <div class="entry" style="width:20%;">
                            <a href="<?php echo @URL; ?>
/clubs/catbrowse/<?php echo ((is_array($_tmp=$this->_tpl_vars['club']['category'])) ? $this->_run_mod_handler('replace', true, $_tmp, ' ', '_') : smarty_modifier_replace($_tmp, ' ', '_')); ?>
"><?php echo $this->_tpl_vars['club']['category']; ?>
</a>
                        </div>                        
                        <div class="entry" style="width:98%;">
                            Total <?php echo $this->_tpl_vars['club']['mem_count']; ?>
 member(s) 
                            <?php if ($this->_tpl_vars['club']['user_email'] == $this->_tpl_vars['email']): ?>
                                | <a href="<?php echo @URL; ?>
/clubs/edit/<?php echo $this->_tpl_vars['club']['id']; ?>
">Edit Club Info</a> | <a href="<?php echo @URL; ?>
/clubs/delete/<?php echo $this->_tpl_vars['club']['id']; ?>
" class="clubdel">Delete Club</a>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endforeach; endif; unset($_from); ?>
            </div>
            <div style="width:740px;">
                <span style="float:right" class="pageLink">
                    <?php echo smarty_function_paginate_first(array(), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_prev(array(), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_middle(array('format' => 'page','prefix' => "",'suffix' => "",'link_prefix' => "&nbsp;",'link_suffix' => "&nbsp;"), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_next(array(), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_last(array(), $this);?>

                </span>
            </div>
    <?php else: ?>
        <p>No clubs have been recently updated.</p>
    <?php endif; ?>
</div>

<?php echo '
<script type="text/javascript">
$(document).ready(function(){
    $(\'a.clubdel\').click(function(){
       var link = $(this).attr(\'href\');
        jConfirm(\'Are you sure you want to delete this club?\', \'Confirmation Dialog\', function(r) {
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