
<script type="text/javascript" src="{$smarty.const.URL}/scripts/js/jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="{$smarty.const.URL}/scripts/js/jquery.livequery.js"></script>
<script type="text/javascript" src="{$smarty.const.URL}/scripts/js/jquery.validate.js"></script>
<script type="text/javascript" src="{$smarty.const.URL}/scripts/js/jquery.form.js"></script>
<script type="text/javascript" src="{$smarty.const.URL}/scripts/js/jquery.alerts.js" ></script>
<script type="text/javascript" src="{$smarty.const.URL}/scripts/editor/tiny_mce.js" ></script>
<script type="text/javascript" src="{$smarty.const.URL}/scripts/player/flowplayer-3.2.4.min.js"></script>
<script type="text/javascript" src="{$smarty.const.URL}/scripts/js/jquery-ui-1.7.2.custom.min.js"></script>
<script type="text/javascript" src="{$smarty.const.URL}/scripts/js/jquery.tokeninput.js"></script>
<script type="text/javascript" src="{$smarty.const.URL}/scripts/js/jquery.fancybox-1.2.6.pack.js"></script>
{literal}
<script type="text/javascript">
    var site = new Object();
    site.url = "{/literal}{$smarty.const.URL}{literal}"; 
    $(document).ready(function() {
        $('li').hover(function() {
                $(this).addClass('hover');
            }, function() {
                $(this).removeClass('hover');
            }
        );
    });
</script>
{/literal}