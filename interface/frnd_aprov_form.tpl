{*include file="subtpl/had.tpl"*} 
{foreach item=frnd from=$req_list}
    <div class="reqCont">
        <img border="1" src="{$smarty.const.URL}/getimage.php?id={$frnd.user_imgs_id}" width="150px" />
        <div style="float:left">
            <h3><a href="{$smarty.const.URL}/friend/view/{$frnd.pid}">{$frnd.f_name} {$frnd.l_name}</a> wants to be your friend.</h3>
            {if $frnd.req_msg != ""}
                <div>
                {$frnd.name} wrote:<br/> 
                <textarea readonly="readonly" wrap="hard" cols="30" rows="8" >{$frnd.req_msg}</textarea>
                <div>{$frnd.date_added|date_format}</div>
                </div>
            {/if}
        </div>
        <div>
        	<h3><a href="{$smarty.const.URL}/friend/approve/{$frnd.fid}">Approve</a>
        	&nbsp;|&nbsp;
        	<a href="{$smarty.const.URL}/friend/denyrequest/{$frnd.fid}">Deny</a></h3>
        </div>
    </div>
{/foreach}