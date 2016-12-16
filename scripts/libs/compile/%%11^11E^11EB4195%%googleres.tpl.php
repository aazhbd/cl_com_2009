<?php /* Smarty version 2.6.26, created on 2010-02-05 05:25:47
         compiled from googleres.tpl */ ?>
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
    <meta name="verify-v1" content="UU1I6lz6WL9xng+5BbUqiDixlHUDCZmYqrhr91MABtQ=" />
    <title>conveylive.com :: <?php echo $this->_tpl_vars['title']; ?>
</title>
</head>

<body>
    <div class="wrap background">
        <div id="title"><a href="http://www.conveylive.com/">conveylive.com</a></div>
        <div id="search">
            <form action="<?php echo @URL; ?>
/searchpost.php" method="post" id="searchfrm">
                <input type="text" class="field" name="token" id="token" value="Search"  style="width:120px;" onclick="this.form.token.value = ''"/>
                <select name='category' style="width:60px;"  >
                   <option value="1" selected="selected">People</option>
                   <option value="2">Articles</option>
                   <option value="3">Albums</option>
                   <option value="4">Audio</option>
                   <option value="5">Video</option>
                   <option value="6">Blog</option>
                   <option value="7">Clubs</option>
                </select>
                <input type="submit" class="button" name="submit" style="width:20px;height:13px;"  />
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
            <div style="width:730px;">
                <h2>Search Result</h2>
                <div>
                    <form action="http://conveylive.com/result.php" id="cse-search-box">
                      <div>
                        <input type="hidden" name="cx" value="partner-pub-8343252598404045:33zj8i-vptm" />
                        <input type="hidden" name="cof" value="FORID:10" />
                        <input type="hidden" name="ie" value="ISO-8859-1" />
                        <input type="text" name="q" size="31" />
                        <input type="submit" name="sa" value="Search" class="frmbtn" />
                      </div>
                    </form>
                    <script type="text/javascript" src="http://www.google.com/cse/brand?form=cse-search-box&amp;lang=en"></script>
                </div>
                <div id="cse-search-results"></div>
                <script type="text/javascript">
                      var googleSearchIframeName = "cse-search-results";
                      var googleSearchFormName = "cse-search-box";
                      var googleSearchFrameWidth = 795;
                      var googleSearchDomain = "www.google.com";
                      var googleSearchPath = "/cse";
                </script>
                <script type="text/javascript" src="http://www.google.com/afsonline/show_afs_search.js"></script>
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