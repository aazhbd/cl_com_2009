<script type="text/javascript" src="{$smarty.const.URL}/scripts/fckeditor/fckeditor.js"></script>
{literal}
<script type="text/javascript">
window.onload = function()
{
    var ed = new FCKeditor( 'bodytxt' ) ;
    ed.BasePath = "{/literal}{$smarty.const.URL}{literal}/scripts/fckeditor/" ;
    ed.Config["CustomConfigurationsPath"] = "edconfig.js?" + ( new Date() * 1 ) ;
    ed.ToolbarSet = 'ArticleToolbar' ;
    ed.Config['SkinPath'] = "skins/silver/" ;
    ed.Width = 720;
    ed.Height = 500;
    ed.ReplaceTextarea() ;
}
</script>
{/literal}