<?php /* Smarty version 2.6.26, created on 2010-05-02 01:34:33
         compiled from home.tpl */ ?>
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
        
        <center>
            <div id="homecon">
                <div id="topbann"><img src="<?php echo @URL; ?>
/interface/images/bann.gif" style="margin-top:2px;" alt="ConveyLive, Share, Article, Audio, Video, Photos, Blogs, Clubs, Network, Friends, People" broder="0" /></div>
                <div id="hcont">
                    <div id="desc">
                        <div style="margin-bottom: 2px;"><span style="font-weight: bold;">ConveyLive.com</span> is a place to make friends and broadcast your creativity. <br />Publish your profiles, articles, audio, video, files, blogs, clubs or almost any sort of page at all. Browse the world through conveylive.com.</div>
                        <form action="<?php echo @URL; ?>
/searchpost.php" method="post" id="searchfrm" >
                            <input type="text" class="field" name="token" id="token" value="Search"  style="height: 20px; width:200px;" onclick="this.form.token.value = ''"/>
                            <input type="submit" name="submit" style="height:30px;border:none;" value="Search" class="frmbtn"/>
                        </form>                        
                    </div>
                    <div id="frmlogin">
                        <form action="loginpost.php" method="post" id ="frmlogin" style="width:99%">
                            <fieldset>
                            <legend>Login to the community</legend>
                                <div>
                                    <span>
                                        <div style="float:left; width:80px;"><label>eMail:</label></div>
                                        <input type="text" name="email" class="log" />
                                    </span>
                                </div>
                                <div>
                                    <span>
                                        <div style="float:left; width:80px;"><label>Password:</label></div>
                                        <input type="password" name="pass" class="log" />
                                    </span>
                                </div>
                                <div>
                                    <span>
                                        <input type="submit" class="frmbtn" name="submit" value="Login" />
                                        <label><input type="checkbox" name="remember[]" value="1"/> Remember Me.</label>
                                        <a href="<?php echo @URL; ?>
/forgot">Forgot password?</a>
                                    </span>
                                </div>
                                <div>
                                    <span style="line-height:30px;">
                                        Not a member yet? <a href="<?php echo @URL; ?>
/signup">Sign Up</a>
                                    </span>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </center>
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