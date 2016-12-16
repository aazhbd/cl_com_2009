<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    {include file="subtpl/head.tpl"}
    {include file="subtpl/mlinks.tpl"}
    {include file="subtpl/js.tpl"}
    {if $coneditor_js neq null}
        {include file="$coneditor_js"}
    {/if}
    <meta name="verify-v1" content="UU1I6lz6WL9xng+5BbUqiDixlHUDCZmYqrhr91MABtQ=" />
    <title>{$title}</title>
</head>

<body>
    <div class="wrap background">
        <div id="title"><a href="http://www.conveylive.com/">conveylive.com</a></div>
        <div id="search">
            <form action="{$smarty.const.URL}/searchpost.php" method="post" id="searchfrm">
                <input type="image" name="submit" style="height:20px;border:none;float:right;" src="{$smarty.const.URL}/interface/icos/search.png" />
                <input type="text" class="field" name="token" id="token" value="Search"  style="width:160px;float:right;" onclick="this.form.token.value = ''"/>
            </form>
        </div>
        <div id="nav">
            {include file="subtpl/menu.tpl"}
        </div>
        {* error and report part *}
        {if $rep neq ""}
            <div id="reports">{$rep}</div>
        {/if}
        {if $err neq ""}
            <div id="errors">{$err}</div>
        {/if}
        {* end of error and report part *}

        <center>
            <div id="homecon">
                <div id="topbann"><img src="{$smarty.const.URL}/interface/images/bann.gif" style="margin-top:2px;" alt="ConveyLive, Share, Article, Audio, Video, Photos, Blogs, Clubs, Network, Friends, People" broder="0" /></div>
                <div id="hcont">
                    <div id="desc">
                        <div style="margin-bottom: 2px;"><span style="font-weight: bold;">ConveyLive.com</span> is a place to make friends and broadcast your creativity. <br />Publish your profiles, articles, audio, video, files, blogs, clubs or almost any sort of page at all. Browse the world through conveylive.com.</div>
                        <form action="{$smarty.const.URL}/searchpost.php" method="post" id="searchfrm" >
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
                                        <a href="{$smarty.const.URL}/forgot">Forgot password?</a>
                                    </span>
                                </div>
                                <div>
                                    <span style="line-height:30px;">
                                        Not a member yet? <a href="{$smarty.const.URL}/signup">Sign Up</a>
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
            {include file="subtpl/footer.tpl"}
        </div>
    </div>
{literal}
<script type="text/javascript">
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
try {
var pageTracker = _gat._getTracker("UA-10149323-2");
pageTracker._trackPageview();
} catch(err) {}
</script>
{/literal}
</body>
</html>