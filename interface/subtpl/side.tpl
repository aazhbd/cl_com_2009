{if $islogin == false}
<div class="box">
    <h3>Please Signup</h3>
    <a href="{$smarty.const.URL}/signup">
        <span class="item">
            <strong>Not a member yet? Sign up here</strong>
        </span>
    </a>
</div>
<div class="box">
    <a href="{$smarty.const.URL}">
        <span class="item">
            <strong>Already a member? Login here.</strong>
        </span>
    </a>
</div>
{else}
<div class="box">
    {foreach from=$sideitem item=item}
        {if $item.name == "Home" || $item.name == "Friends" || $item.name == "Account"  || $item.name == "View Profile"}
            {if $item.name == "Home"}
                <a href="{$item.link}">
                    <span class="item">
                        <img src="{$item.img}" height="40" width="40" />
                        <strong>{$item.name}</strong>
                        <div>{$loginmsg}, {$item.desc}</div>
                    </span>
                </a>
            {else}
                <a href="{$item.link}">
                    <span class="item">
                        <img src="{$item.img}" height="40" width="40" />
                        <strong>{$item.name}</strong>
                        <div>{$item.desc}</div>
                    </span>
                </a>
            {/if}
        {else}
            {if $latContList == null && $topContList == null && $viewContList == null}
                <a href="{$item.link}">
                    <span class="item">
                        <img src="{$item.img}" height="40" width="40" />
                        <strong>{$item.name}</strong>
                        <div>{$item.desc}</div>
                    </span>
                </a>
            {/if}
        {/if}
    {/foreach}
</div>
{/if}