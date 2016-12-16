{if $viewContList != null}
<div class="box" style="margin-top:5px;">
    <h3>Most Viewed {$viewContTitle} this month</h3>
    <div class="sideCont">
        <div class="contName">
            <ul>
                {foreach item=cont from=$viewContList}
                    <li class="listItem"><a href="{$smarty.const.URL}/{$cont.contURL}">{$cont.title|truncate:26:"...":true}</a></li>
                {/foreach}
            </ul>
        </div>
    </div>
    <a href="{$smarty.const.URL}/{$viewBrowselink}"><h3>{$viewContTitle} for all time</h3></a>
</div>
{/if}
{if $latContList != null}
<div class="box" style="margin-top:5px;">
    <h3>Latest {$latContTitle}</h3>
    <div class="sideCont">
        <div class="contName">
            <ul>
                {foreach item=cont from=$latContList}
                    <li class="listItem"><a href="{$smarty.const.URL}/{$cont.contURL}">{$cont.title|truncate:26:"...":true}</a></li>
                {/foreach}
            </ul>
        </div>
    </div>
    <a href="{$smarty.const.URL}/{$latBrowselink}"><h3>{$latContTitle} for all time</h3></a>
</div>
{/if}
{if $topContList != null}
<div class="box" style="margin-top:5px;">
    <h3>Top Rated {$topContTitle} this month</h3>
    <div class="sideCont">
        <div class="contName">
            <ul>
                {foreach item=cont from=$topContList}
                    <li class="listItem"><a href="{$smarty.const.URL}/{$cont.contURL}">{$cont.title|truncate:26:"...":true}</a></li>
                {/foreach}
            </ul>
        </div>
    </div>
    <a href="{$smarty.const.URL}/{$topBrowselink}"><h3>{$topContTitle} for all time</h3></a>
</div>
{/if}
{include file="subtpl/email_invite.tpl"}