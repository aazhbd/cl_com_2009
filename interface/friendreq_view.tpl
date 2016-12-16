{*include file="subtpl/had.tpl"*} 
<br />
{foreach item=frnd from=$req_list}
    <div class="reqCont">
        <div style="float:left; width:160px; margin:10px;">
            <img border="1" src="{$smarty.const.URL}/getsmimage.php?id={$frnd.user_imgs_id}" alt="{$frnd.f_name} {$frnd.l_name}" style="width:150px;"/>
        </div>
        <div style="float:left; width:300px;" id="cont">
            <h3><a href="{$smarty.const.URL}/profile/view/{$frnd.pid}">{$frnd.f_name} {$frnd.l_name}</a> wants to be your friend.</h3>
            {if $frnd.req_msg != ""}
                {$frnd.f_name} wrote: 
                <h4><i>{$frnd.req_msg}</i></h4>
                {$frnd.date_added|date_format}
            {/if}
           	<br/>
            <h3>
            <a href="{$smarty.const.URL}/friend/approve/{$frnd.fid}">Approve</a>
        	&nbsp;&nbsp;
        	<a href="{$smarty.const.URL}/friend/denyrequest/{$frnd.fid}">Deny</a>
            </h3>
        </div>
    </div>
    <br/>
{foreachelse}
<h3>You have no friend requests</h3>
{/foreach}