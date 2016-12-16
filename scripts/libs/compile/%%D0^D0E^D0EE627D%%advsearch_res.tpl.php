<?php /* Smarty version 2.6.26, created on 2010-01-22 02:37:46
         compiled from advsearch_res.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'paginate_first', 'advsearch_res.tpl', 41, false),array('function', 'paginate_prev', 'advsearch_res.tpl', 41, false),array('function', 'paginate_middle', 'advsearch_res.tpl', 41, false),array('function', 'paginate_next', 'advsearch_res.tpl', 41, false),array('function', 'paginate_last', 'advsearch_res.tpl', 41, false),)), $this); ?>
<div style="margin-top:10px;">
    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "moresearch_view.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</div>
<?php if ($this->_tpl_vars['searchtype'] == 'People'): ?>
    <div style="width:730px; margin-top:10px;">
    <?php if ($this->_tpl_vars['res_list'] != null): ?>
        <div>
            <h2>Search results for</h2>
            <div style="width:98%; font:weight:bold; font-size:16px; color:#069; margin-bottom:10px;">
                <?php echo $this->_tpl_vars['tok']; ?>

                <br />
            </div>
        </div>
        <div>
            <?php echo $this->_tpl_vars['paginate']['total']; ?>
 result(s) found.
            <div style="float:right;">&nbsp;Showing results <?php echo $this->_tpl_vars['paginate']['first']; ?>
-<?php echo $this->_tpl_vars['paginate']['last']; ?>
 of <?php echo $this->_tpl_vars['paginate']['total']; ?>
</div>
        </div>
        <div >
          <?php $this->assign('p', ($this->_tpl_vars['paginate']['page'][$this->_tpl_vars['paginate']['page_current']]['item_start'])); ?>
          <?php $_from = $this->_tpl_vars['res_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['res']):
?>
              <div class="artcont">
                    <div class="entry" style="width:30%;">
                        <div style="float: left;"><a href="<?php echo @URL; ?>
/profile/view/<?php echo $this->_tpl_vars['res']['pid']; ?>
"><img src="<?php echo @URL; ?>
/getsmimage.php?id=<?php echo $this->_tpl_vars['res']['user_imgs_id']; ?>
" style="max-width:100;" height="70" border="1" alt=" Photo of <?php echo $this->_tpl_vars['res']['f_name']; ?>
 <?php echo $this->_tpl_vars['res']['l_name']; ?>
"/></a></div>
                    </div>
                    <div class="entry" style="width:30%;">
                        <div><a href="<?php echo @URL; ?>
/profile/view/<?php echo $this->_tpl_vars['res']['pid']; ?>
"><?php echo $this->_tpl_vars['res']['f_name']; ?>
&nbsp;<?php echo $this->_tpl_vars['res']['l_name']; ?>
</a></div>
                    </div>
                    <div class="entry" style="width:30%;">
                        <div><img src="<?php echo @URL; ?>
/interface/icos/users.png" width="20" alt="<?php echo $this->_tpl_vars['frnd']['name']; ?>
, ConveyLive, Friends, Network" /><a href="<?php echo @URL; ?>
/friend/viewfriends/<?php echo $this->_tpl_vars['res']['pid']; ?>
">View Friends</a></div>
                        <?php if ($this->_tpl_vars['res']['email'] != $this->_tpl_vars['email']): ?>
                        <div><img src="<?php echo @URL; ?>
/interface/icos/email.png" width="20" alt="<?php echo $this->_tpl_vars['frnd']['name']; ?>
, ConveyLive, Friends, Network" /><a href="<?php echo @URL; ?>
/friend/sendmessage/<?php echo $this->_tpl_vars['res']['pid']; ?>
">Send Message</a></div>
                        <?php endif; ?>
                    </div>
                <?php $this->assign('p', ($this->_tpl_vars['p']+$this->_tpl_vars['x'])); ?>
              </div>
          <?php endforeach; endif; unset($_from); ?>
        </div>

        <div>
            <span>
                <?php echo smarty_function_paginate_first(array(), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_prev(array(), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_middle(array('format' => 'page','prefix' => "",'suffix' => "",'link_prefix' => "&nbsp;",'link_suffix' => "&nbsp;"), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_next(array(), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_last(array(), $this);?>

            </span>
        </div>
        <?php else: ?>
            <div>
                <span>
                        Sorry, no results were found. Please refine your search keyword and try again !
                </span>
            </div>
        <?php endif; ?>
    </div>    
<?php endif; ?>