<?php /* Smarty version 2.6.26, created on 2011-02-19 16:26:11
         compiled from main.tpl */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "subtpl/head.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "subtpl/mlinks.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "subtpl/js.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
    <?php if ($this->_tpl_vars['coneditor_js'] != null): ?>
        <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['coneditor_js']), 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
    <?php endif; ?>
    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "subtpl/friend_js.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
    <meta name="verify-v1" content="UU1I6lz6WL9xng+5BbUqiDixlHUDCZmYqrhr91MABtQ=" />
    <title><?php echo $this->_tpl_vars['title']; ?>
</title>
</head>

<body>
    <div class="wrap background">
        <div id="title"><a href="http://www.conveylive.com/">conveylive.com</a></div>
        <div id="search">
            <form action="<?php echo @URL; ?>
/searchpost.php" method="post" id="searchfrm">
                <input type="image" name="submit" style="height:20px;border:none;float:right;" src="<?php echo @URL; ?>
/interface/icos/search.png" />
                <input type="text" class="field" name="token" id="token" value="Search"  style="width:160px;float:right;" onclick="this.form.token.value = ''"/>
            </form>
        </div>
        <div id="nav">
            <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "subtpl/menu.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
        </div>
                <?php if ($this->_tpl_vars['rep'] != ""): ?>
            <div id="reports"><?php echo $this->_tpl_vars['rep']; ?>
</div>
        <?php endif; ?>
        <?php if ($this->_tpl_vars['err'] != ""): ?>
            <div id="errors"><?php echo $this->_tpl_vars['err']; ?>
</div>
        <?php endif; ?>
                
        <div id="left">
            <div id="bodycon">
                <?php if ($this->_tpl_vars['btitle']): ?><h2><?php echo $this->_tpl_vars['btitle']; ?>
</h2><?php endif; ?>
                <?php if ($this->_tpl_vars['bsubtitle']): ?><p class="subtitle"><?php echo $this->_tpl_vars['bsubtitle']; ?>
</p><?php endif; ?>
                <?php if ($this->_tpl_vars['bbody']): ?><?php echo $this->_tpl_vars['bbody']; ?>
<?php endif; ?>
            </div>
        </div>
        <div id="side">
            <div class="box">
                <?php if ($this->_tpl_vars['islogin'] == true): ?>
                    <h3>Convey Panel</h3>
                <?php endif; ?>
                <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "subtpl/side.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            </div>
            <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "subtpl/infobox.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
        </div>
    </div>
    <div id="promo">
        <div id="footer">
            <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "subtpl/footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
        </div>
    </div>
    
    <?php echo '
    <script type="text/javascript">
    var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
    document.write(unescape("%3Cscript src=\'" + gaJsHost + "google-analytics.com/ga.js\' type=\'text/javascript\'%3E%3C/script%3E"));
    </script>
    <script type="text/javascript">
    try {
    var pageTracker = _gat._getTracker("UA-10149323-2");
    pageTracker._trackPageview();
    } catch(err) {}
    </script>
    '; ?>

</body>
</html>