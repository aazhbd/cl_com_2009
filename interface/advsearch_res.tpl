<div style="margin-top:10px;">
    {include file="moresearch_view.tpl"}
</div>
{if $searchtype == 'People'}
    <div style="width:730px; margin-top:10px;">
    {if $res_list!= null}
        <div>
            <h2>Search results for</h2>
            <div style="width:98%; font:weight:bold; font-size:16px; color:#069; margin-bottom:10px;">
                {$tok}
                <br />
            </div>
        </div>
        <div>
            {$paginate.total} result(s) found.
            <div style="float:right;">&nbsp;Showing results {$paginate.first}-{$paginate.last} of {$paginate.total}</div>
        </div>
        <div >
          {assign var="p" value="`$paginate.page[$paginate.page_current].item_start`"}
          {foreach item=res from=$res_list}
              <div class="artcont">
                    <div class="entry" style="width:30%;">
                        <div style="float: left;"><a href="{$smarty.const.URL}/profile/view/{$res.pid}"><img src="{$smarty.const.URL}/getsmimage.php?id={$res.user_imgs_id}" style="max-width:100;" height="70" border="1" alt=" Photo of {$res.f_name} {$res.l_name}"/></a></div>
                    </div>
                    <div class="entry" style="width:30%;">
                        <div><a href="{$smarty.const.URL}/profile/view/{$res.pid}">{$res.f_name}&nbsp;{$res.l_name}</a></div>
                    </div>
                    <div class="entry" style="width:30%;">
                        <div><img src="{$smarty.const.URL}/interface/icos/users.png" width="20" alt="{$frnd.name}, ConveyLive, Friends, Network" /><a href="{$smarty.const.URL}/friend/viewfriends/{$res.pid}">View Friends</a></div>
                        {if $res.email != $email}
                        <div><img src="{$smarty.const.URL}/interface/icos/email.png" width="20" alt="{$frnd.name}, ConveyLive, Friends, Network" /><a href="{$smarty.const.URL}/friend/sendmessage/{$res.pid}">Send Message</a></div>
                        {/if}
                    </div>
                {assign var="p" value="`$p+$x`"}
              </div>
          {/foreach}
        </div>

        <div>
            <span>
                {paginate_first}&nbsp;&nbsp;{paginate_prev}&nbsp;&nbsp;{paginate_middle format="page" prefix="" suffix="" link_prefix="&nbsp;" link_suffix="&nbsp;" }&nbsp;&nbsp;{paginate_next}&nbsp;&nbsp;{paginate_last}
            </span>
        </div>
        {else}
            <div>
                <span>
                        Sorry, no results were found. Please refine your search keyword and try again !
                </span>
            </div>
        {/if}
    </div>    
{/if}