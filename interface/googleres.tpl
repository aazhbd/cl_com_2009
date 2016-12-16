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
    <title>conveylive.com :: {$title}</title>
</head>

<body>
    <div class="wrap background">
        <div id="title"><a href="http://www.conveylive.com/">conveylive.com</a></div>
        <div id="search">
            <form action="{$smarty.const.URL}/searchpost.php" method="post" id="searchfrm">
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
                {if $islogin == true}
                    <h3>Convey Panel</h3>
                {/if}
                {include file="subtpl/side.tpl"}
            </div>
        </div>
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