<div style="float:left; width:730px;">
    {if $coms != null}<h3><img src="{$smarty.const.URL}/interface/icos/comments.png" style="width:30px;" />Comments on this photo</h3>{/if}
    <div id="comlist">
        {if $coms != null}
            <br />
            {include file="comment_view.tpl"}
        {/if}
    </div>
    {if $islogin == true}
    <div>
        {assign var='mid' value=$media_id}
        {assign var='mtype' value='Picture'}
        
        {include file='frm_comment.tpl'}
    </div>
    {/if}
    <br />
</div>