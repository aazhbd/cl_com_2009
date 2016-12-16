<div style="float:left; width:740px;">
<div id="pginfo">
    All your friends' list is here. You may send them message, or view their friends. Click on their names to view their profiles. You may also want to report any friend whom you find to be disturbing and using offensive languages in messages or comments or posting obscene/violent contents.
</div>
{*include file="subtpl/had.tpl"*} 
{assign var="isFriend" value='false'}
    {if $frnd_list != null}
    <div>
        Showing friends {$paginate.first}-{$paginate.last} of {$paginate.total}
        {foreach item=frnd from=$frnd_list}
        <div class="artcont">
            {if $frnd.isfriend == true}
                <img src="{$smarty.const.URL}/interface/icos/delete_user.png" width="20" alt="{$frnd.name}, ConveyLive, Friends, Network" />
                <a href="{$smarty.const.URL}/friend/remove/{$frnd.fid}" class="frnddel">Remove from friends</a>
                <img src="{$smarty.const.URL}/interface/icos/page_edit.png" width="20" alt="{$frnd.name}, ConveyLive, Friends, Network"/>
                <a href="{$smarty.const.URL}/friend/report/{$frnd.pid}">Report user</a></span>
            {/if}
            <div class="entry" style="width:30%;"><img src="{$smarty.const.URL}/getsmimage.php?id={$frnd.user_imgs_id}" height="70" border="1" alt="{$frnd.name}, ConveyLive, Friends, Network" /></div>
            <div class="entry" style="width:30%;"><h3><a href="{$smarty.const.URL}/profile/view/{$frnd.pid}">{$frnd.name}</a></h3></div>
            <div class="entry" style="width:65%;"><img src="{$smarty.const.URL}/interface/icos/email.png" width="20" alt="{$frnd.name}, ConveyLive, Friends, Network" /><a href="{$smarty.const.URL}/friend/sendmessage/{$frnd.pid}">Send a message</a></div>
            <div class="entry" style="width:65%;"><img src="{$smarty.const.URL}/interface/icos/users.png" width="20" alt="{$frnd.name}, ConveyLive, Friends, Network" /><a href="{$smarty.const.URL}/friend/viewfriends/{$frnd.pid}">View Friends</a></div>
        </div>
        {/foreach}
    </div>
    <span>{paginate_first}&nbsp;&nbsp;{paginate_prev}&nbsp;&nbsp;{paginate_middle format="page" prefix="" suffix="" link_prefix="&nbsp;" link_suffix="&nbsp;" }&nbsp;&nbsp;{paginate_next}&nbsp;&nbsp;{paginate_last}</span>
    {else}
    <div id ="pginfo" style="border: #ccc solid 1px; background: #ffe;">
        No friends found. <br /><br />
        <a href="{$smarty.const.URL}/invite.php"><img src="{$smarty.const.URL}/interface/icos/users.png" style="width:30px;"/>Invite your friends from your email contacts</a><br /><br />
        <a href="{$smarty.const.URL}/moresearch/people"><img src="{$smarty.const.URL}/interface/icos/convey-logo.png" style="width:30px;"/>Search People in conveylive.com to add as friends</a>
    </div>
    {/if}
</div>

{literal}
<script type="text/javascript">
$(document).ready(function(){
    $('a.frnddel').click(function(){
       var link = $(this).attr('href');
        jConfirm('Are you sure you want to remove this friend?', 'Confirmation Dialog', function(r) {
            if(r == true){
                window.location.href = link;
            }
            else{
                return false;
            }
        });
        return false;
    })
});
</script>
{/literal}