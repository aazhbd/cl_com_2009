<div style="float:left; width:730px;">
    <div>
        <img src="{$smarty.const.URL}/getimage.php?id={$club.image_id}" width="80" alt="{$club.name}, conveylive.com, club" />
        <a href="{$smarty.const.URL}/clubs/newtopic/{$club.id}">Post New Topic</a>&nbsp;|&nbsp;<a href="{$smarty.const.URL}/clubs/view/{$club.id}">Back to Club</a>
    </div>
    {*include file="subtpl/had.tpl"*}
    <br />
    {foreach item=post from=$posts}
    <div class="artcont">
        
        {if $post.pid == null}
            <div class="entry" style="width:20%;"><img src="{$smarty.const.URL}/getsmimage.php?id={$post.user_imgs_id}" alt="{$club.name},{$post.f_name}, {$post.f_name}, conveylive" width="80" border="1" /></div>
            <div class="entry" style="width:40%;"><h3>{$post.title}</h3>
        {else}
            <div class="entry" style="width:20%;"><a href="{$smarty.const.URL}/profile/view/{$post.pid}" ><img src="{$smarty.const.URL}/getsmimage.php?id={$post.user_imgs_id}" alt="{$club.cname},{$post.f_name}, {$post.f_name}, conveylive" width="80" border="1" /></a></div>
            <div class="entry" style="width:40%;"><h3><a href="{$smarty.const.URL}/clubs/viewpost/{$post.post_id}" >{$post.title}</a></h3>
        {/if}
            <br/>By: <a href="{$smarty.const.URL}/profile/view/{$post.pid}">{$post.f_name} {$post.l_name}</a>
            <br/>Posted On: {$post.ins_date|date_format}
        </div>
    </div>
    {foreachelse}
        <div class="artcont">There are no topics in this club</div>
    {/foreach}
</div>