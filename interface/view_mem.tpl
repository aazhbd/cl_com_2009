<div style="float:left; width:730px;">
    <div>
        <img src="{$smarty.const.URL}/getimage.php?id={$club.image_id}" width="80" alt="{$club.name}, conveylive.com, club" />
        <a href="{$smarty.const.URL}/clubs/view/{$club.id}">Back to Club</a>
    </div>
    
    {foreach item=member from=$members}
    <div class="artcont">
        
        {if $member.pid == null}
            <div class="entry" style="width:20%;"><img src="{$smarty.const.URL}/getsmimage.php?id={$member.user_imgs_id}" alt="{$club.cname},{$member.f_name}, {$member.f_name}, conveylive" width="80" border="1" /></div>
            <div class="entry" style="width:40%;"><h3>{$member.f_name} {$member.l_name}</h3>
        {else}
            <div class="entry" style="width:20%;"><a href="{$smarty.const.URL}/profile/view/{$member.pid}" ><img src="{$smarty.const.URL}/getsmimage.php?id={$member.user_imgs_id}" alt="{$club.name},{$member.f_name}, {$member.f_name}, conveylive" height="80" border="1" /></a></div>
            <div class="entry" style="width:40%;"><h3><a href="{$smarty.const.URL}/profile/view/{$member.pid}" >{$member.f_name} {$member.l_name}</a></h3>
        {/if}
            <br/>Joined: {$member.join_date|date_format}
            <br/>Designation: {$member.rank}
        </div>
        <div class="entry" style="width:30%;">
            {if $is_creator == true and $member.rank == "Creator"}
                <a href="{$smarty.const.URL}/clubs/deletemember/{$club.id}/{$member.id}">Remove Member</a>
            {elseif $is_creator == false and $member.rank == "Creator"}
            {elseif $member.rank == "General Member"}
                
            {elseif $member.rank == "Admin"}
                <a href="{$smarty.const.URL}/clubs/deletemember/{$club.id}/{$member.id}">Remove Member</a>
                <br/><a href="{$smarty.const.URL}/clubs/demotemember/{$club.id}/{$member.id}">Remove from Club Admin</a>
            {/if}
            
        </div>
    </div>
    {/foreach}
</div>