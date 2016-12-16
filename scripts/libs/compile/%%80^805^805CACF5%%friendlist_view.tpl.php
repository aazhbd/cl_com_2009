<?php /* Smarty version 2.6.26, created on 2010-01-15 05:44:46
         compiled from friendlist_view.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'paginate_first', 'friendlist_view.tpl', 25, false),array('function', 'paginate_prev', 'friendlist_view.tpl', 25, false),array('function', 'paginate_middle', 'friendlist_view.tpl', 25, false),array('function', 'paginate_next', 'friendlist_view.tpl', 25, false),array('function', 'paginate_last', 'friendlist_view.tpl', 25, false),)), $this); ?>
<div style="float:left; width:740px;">
<div id="pginfo">
    All your friends' list is here. You may send them message, or view their friends. Click on their names to view their profiles. You may also want to report any friend whom you find to be disturbing and using offensive languages in messages or comments or posting obscene/violent contents.
</div>
 
<?php $this->assign('isFriend', 'false'); ?>
    <?php if ($this->_tpl_vars['frnd_list'] != null): ?>
    <div>
        Showing friends <?php echo $this->_tpl_vars['paginate']['first']; ?>
-<?php echo $this->_tpl_vars['paginate']['last']; ?>
 of <?php echo $this->_tpl_vars['paginate']['total']; ?>

        <?php $_from = $this->_tpl_vars['frnd_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['frnd']):
?>
        <div class="artcont">
            <?php if ($this->_tpl_vars['frnd']['isfriend'] == true): ?>
                <img src="<?php echo @URL; ?>
/interface/icos/delete_user.png" width="20" alt="<?php echo $this->_tpl_vars['frnd']['name']; ?>
, ConveyLive, Friends, Network" />
                <a href="<?php echo @URL; ?>
/friend/remove/<?php echo $this->_tpl_vars['frnd']['fid']; ?>
" class="frnddel">Remove from friends</a>
                <img src="<?php echo @URL; ?>
/interface/icos/page_edit.png" width="20" alt="<?php echo $this->_tpl_vars['frnd']['name']; ?>
, ConveyLive, Friends, Network"/>
                <a href="<?php echo @URL; ?>
/friend/report/<?php echo $this->_tpl_vars['frnd']['pid']; ?>
">Report user</a></span>
            <?php endif; ?>
            <div class="entry" style="width:30%;"><img src="<?php echo @URL; ?>
/getsmimage.php?id=<?php echo $this->_tpl_vars['frnd']['user_imgs_id']; ?>
" height="70" border="1" alt="<?php echo $this->_tpl_vars['frnd']['name']; ?>
, ConveyLive, Friends, Network" /></div>
            <div class="entry" style="width:30%;"><h3><a href="<?php echo @URL; ?>
/profile/view/<?php echo $this->_tpl_vars['frnd']['pid']; ?>
"><?php echo $this->_tpl_vars['frnd']['name']; ?>
</a></h3></div>
            <div class="entry" style="width:65%;"><img src="<?php echo @URL; ?>
/interface/icos/email.png" width="20" alt="<?php echo $this->_tpl_vars['frnd']['name']; ?>
, ConveyLive, Friends, Network" /><a href="<?php echo @URL; ?>
/friend/sendmessage/<?php echo $this->_tpl_vars['frnd']['pid']; ?>
">Send a message</a></div>
            <div class="entry" style="width:65%;"><img src="<?php echo @URL; ?>
/interface/icos/users.png" width="20" alt="<?php echo $this->_tpl_vars['frnd']['name']; ?>
, ConveyLive, Friends, Network" /><a href="<?php echo @URL; ?>
/friend/viewfriends/<?php echo $this->_tpl_vars['frnd']['pid']; ?>
">View Friends</a></div>
        </div>
        <?php endforeach; endif; unset($_from); ?>
    </div>
    <span><?php echo smarty_function_paginate_first(array(), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_prev(array(), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_middle(array('format' => 'page','prefix' => "",'suffix' => "",'link_prefix' => "&nbsp;",'link_suffix' => "&nbsp;"), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_next(array(), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_last(array(), $this);?>
</span>
    <?php else: ?>
    <div id ="pginfo" style="border: #ccc solid 1px; background: #ffe;">
        No friends found. <br /><br />
        <a href="<?php echo @URL; ?>
/invite.php"><img src="<?php echo @URL; ?>
/interface/icos/users.png" style="width:30px;"/>Invite your friends from your email contacts</a><br /><br />
        <a href="<?php echo @URL; ?>
/moresearch/people"><img src="<?php echo @URL; ?>
/interface/icos/convey-logo.png" style="width:30px;"/>Search People in conveylive.com to add as friends</a>
    </div>
    <?php endif; ?>
</div>

<?php echo '
<script type="text/javascript">
$(document).ready(function(){
    $(\'a.frnddel\').click(function(){
       var link = $(this).attr(\'href\');
        jConfirm(\'Are you sure you want to remove this friend?\', \'Confirmation Dialog\', function(r) {
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