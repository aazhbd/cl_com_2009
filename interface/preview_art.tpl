<div style="width:730px;">
    {if $action == "add"}
        <form action="{$smarty.const.URL}/submitarticle.php" method = "post">
    {/if}
    {if $action == "edit"}
        <form action="{$smarty.const.URL}/editarticle.php" method = "post">
    {/if}
            <fieldset>
                <legend>Are you sure you want to publish this article?<br /></legend>
                <div>
                    <h2>{$arttitle}</h2>
                    <p class="subtitle">{$subtitle}</p>
                    <p>by {$name}</p>
                <p>published on {$date_pub|date_format:"%A, %B %e, %Y"}&nbsp;&nbsp;{$date_pub|date_format:"%I:%M %p"} </p>
                <p>about {$cat}</p>
                <div>
                <div>
                    <p>
                        {$bodytxt}
                    </p>
                    <br/>
                </div>
                {if $url != ""}
                <div>
                    <label>URL:</label>
                    {$smarty.const.URL}/a/{$url}
                </div>
                {/if}
                {if $remarks != ""}
                <div>
                    <label>Author's note:</label>
                    {$remarks}
                </div>
                {/if}
                {if $keywords != ""}
                <div>
                    <label>Keywords :</label>
                    {$keywords}
                </div>
                {/if}
                </div>
            </fieldset>
            <br/>
            <div>
                <input name="cat" type="hidden" value="{$cat}" />
                <input name="cat_id" type="hidden" value="{$cat_id}" />
                <input name="arttitle" type="hidden" value="{$arttitle}" />
                <input name="subtitle" type="hidden" value="{$subtitle}" />
                <input name="remarks" type="hidden" value="{$remarks}" />
                <input name="date_pub" type="hidden" value="{$date_pub}" />
                <input name="atype" type="hidden" value="{$atype}" />
                <input name="privacy" type="hidden" value="{$privacy}" />
                <input name="admin_perm" type="hidden" value="{$admin_perm}" />
                <input name="keywords" type="hidden" value="{$keywords}" />
                <input name="arturl" type="hidden" value="{$arturl}" />
                <input name="art_id" type="hidden" value="{$id}" />
                <input name="submit" type="submit" value="Confirm and Publish" class="frmbtn" />&nbsp;&nbsp;
                <a href="{$smarty.const.URL}/article/edit/current">Edit this article</a>&nbsp;&nbsp;
                <a href="{$smarty.const.URL}/home">Discard</a>
            </div>
        </form>
</div>