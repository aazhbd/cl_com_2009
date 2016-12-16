<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    {include file="subtpl/head.tpl"}
    {include file="subtpl/mlinks.tpl"}
    {include file="subtpl/js.tpl"}
    {if $coneditor_js neq null}
        {include file="$coneditor_js"}
    {/if}
    {include file="subtpl/friend_js.tpl"}
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
        
        <div id="left">
            <div id="bodycon">
                {if $btitle}<h2>{$btitle}</h2>{/if}
                {if $bsubtitle}<p class="subtitle">{$bsubtitle}</p>{/if}
{*                <div>
                    {include file="subtpl/had.tpl"}
                </div>
*}
{*                {if $isinvalid == false}
                    <div style="width:95%;">
                        <div style="width:65%; float:left;">
                            {include file="subtpl/had.tpl"}
                        </div>
                        <div style="width:30%; float:left;">
                            {include file="subtpl/had_adbrite.tpl"}
                        </div>
                    </div>
                {/if}
*}
                {if $bbody}{$bbody}{/if}
            </div>
        </div>
        <div id="side">
            <div class="box">
                {if $islogin == true}
                    <h3>Convey Panel</h3>
                {/if}
                {include file="subtpl/side.tpl"}
            </div>
            {include file="subtpl/infobox.tpl"}
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