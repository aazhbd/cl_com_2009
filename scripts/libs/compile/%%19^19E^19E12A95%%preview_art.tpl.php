<?php /* Smarty version 2.6.26, created on 2010-01-15 12:46:53
         compiled from preview_art.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'preview_art.tpl', 14, false),)), $this); ?>
<div style="width:730px;">
    <?php if ($this->_tpl_vars['action'] == 'add'): ?>
        <form action="<?php echo @URL; ?>
/submitarticle.php" method = "post">
    <?php endif; ?>
    <?php if ($this->_tpl_vars['action'] == 'edit'): ?>
        <form action="<?php echo @URL; ?>
/editarticle.php" method = "post">
    <?php endif; ?>
            <fieldset>
                <legend>Are you sure you want to publish this article?<br /></legend>
                <div>
                    <h2><?php echo $this->_tpl_vars['arttitle']; ?>
</h2>
                    <p class="subtitle"><?php echo $this->_tpl_vars['subtitle']; ?>
</p>
                    <p>by <?php echo $this->_tpl_vars['name']; ?>
</p>
                <p>published on <?php echo ((is_array($_tmp=$this->_tpl_vars['date_pub'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%A, %B %e, %Y") : smarty_modifier_date_format($_tmp, "%A, %B %e, %Y")); ?>
&nbsp;&nbsp;<?php echo ((is_array($_tmp=$this->_tpl_vars['date_pub'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%I:%M %p") : smarty_modifier_date_format($_tmp, "%I:%M %p")); ?>
 </p>
                <p>about <?php echo $this->_tpl_vars['cat']; ?>
</p>
                <div>
                <div>
                    <p>
                        <?php echo $this->_tpl_vars['bodytxt']; ?>

                    </p>
                    <br/>
                </div>
                <?php if ($this->_tpl_vars['url'] != ""): ?>
                <div>
                    <label>URL:</label>
                    <?php echo @URL; ?>
/a/<?php echo $this->_tpl_vars['url']; ?>

                </div>
                <?php endif; ?>
                <?php if ($this->_tpl_vars['remarks'] != ""): ?>
                <div>
                    <label>Author's note:</label>
                    <?php echo $this->_tpl_vars['remarks']; ?>

                </div>
                <?php endif; ?>
                <?php if ($this->_tpl_vars['keywords'] != ""): ?>
                <div>
                    <label>Keywords :</label>
                    <?php echo $this->_tpl_vars['keywords']; ?>

                </div>
                <?php endif; ?>
                </div>
            </fieldset>
            <br/>
            <div>
                <input name="cat" type="hidden" value="<?php echo $this->_tpl_vars['cat']; ?>
" />
                <input name="cat_id" type="hidden" value="<?php echo $this->_tpl_vars['cat_id']; ?>
" />
                <input name="arttitle" type="hidden" value="<?php echo $this->_tpl_vars['arttitle']; ?>
" />
                <input name="subtitle" type="hidden" value="<?php echo $this->_tpl_vars['subtitle']; ?>
" />
                <input name="remarks" type="hidden" value="<?php echo $this->_tpl_vars['remarks']; ?>
" />
                <input name="date_pub" type="hidden" value="<?php echo $this->_tpl_vars['date_pub']; ?>
" />
                <input name="atype" type="hidden" value="<?php echo $this->_tpl_vars['atype']; ?>
" />
                <input name="privacy" type="hidden" value="<?php echo $this->_tpl_vars['privacy']; ?>
" />
                <input name="admin_perm" type="hidden" value="<?php echo $this->_tpl_vars['admin_perm']; ?>
" />
                <input name="keywords" type="hidden" value="<?php echo $this->_tpl_vars['keywords']; ?>
" />
                <input name="arturl" type="hidden" value="<?php echo $this->_tpl_vars['arturl']; ?>
" />
                <input name="art_id" type="hidden" value="<?php echo $this->_tpl_vars['id']; ?>
" />
                <input name="submit" type="submit" value="Confirm and Publish" class="frmbtn" />&nbsp;&nbsp;
                <a href="<?php echo @URL; ?>
/article/edit/current">Edit this article</a>&nbsp;&nbsp;
                <a href="<?php echo @URL; ?>
/home">Discard</a>
            </div>
        </form>
</div>