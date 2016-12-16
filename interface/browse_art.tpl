
<div style="float:left; width:740px;">
    
    <div id="pginfo">
        Browse latest pages published by users of conveylive. Sign in to rate articles according to your like or dislike. 
        You may also post comments and discuss.
    </div>
    
    {if $pubList != null}
        <div class="browsecat" style="float:left; margin: 0.5em;">
            <h3>Published Categories</h3>
            <div class="catmenuLink" style="border:none; ">
            {foreach item=cat from=$pubList}
                <div>
                    <a href="{$smarty.const.URL}/article/categorybrowse/{$cat.linkcat}" >{$cat.category|truncate:30} ({$cat.count})</a>
                </div>
            {/foreach}
            </div>
        </div>
    {/if}
    {if $selfCatList != null}
        <div class="browsecat" style="float:left; margin: 0.5em;">
            <h3>Personal Archive</h3>
            <div class="catmenuLink" style="border:none;">
            {foreach item=cat from=$selfCatList}
                <div>
                    <a href="{$smarty.const.URL}/article/categorybrowse/{$cat.linkcat}/self" >{$cat.category|truncate:30} ({$cat.count}) </a>
                </div>
            {/foreach}
            </div>
        </div>
    {/if}
    
    <br />
    <div style="width:740px;">
        {if $topicHead != null}
            <h3>{$topicHead}</h3>
        {else}
            <h3>Latest Pages</h3>
        {/if}
    </div>

    {if $artList != null}
        <div>
            <span style='float:left;' class="pageLink">Showing pages {$paginate.first}-{$paginate.last} of {$paginate.total}</span>
            <span style='float:right;' class="pageLink" >{paginate_first}&nbsp;&nbsp;{paginate_prev}&nbsp;&nbsp;{paginate_middle format="page" prefix="" suffix="" link_prefix="&nbsp;" link_suffix="&nbsp;" }&nbsp;&nbsp;{paginate_next}&nbsp;&nbsp;{paginate_last}</span>
        </div>

        {foreach item=art from=$artList}
            <div class="artcont">

                {if $art.url == null || $art.url == ""}
                    <h3><a href='{$smarty.const.URL}/a/{$art.id}' id="titleblock" class="entry" style="width:65%;">{$art.title}</a></h3>
                {else}
                    <h3><a href='{$smarty.const.URL}/a/{$art.url}' id="titleblock" class="entry" style="width:65%;">{$art.title}</a></h3>
                {/if}

                <a href="{$smarty.const.URL}/profile/view/{$art.pid}" >
                    <div class="entry" style="width:30%;" id="titleblock">
                        by {$art.author} | {$art.ins_date|date_format}
                    </div>
                </a>

                {if $art.sub_title != null }
                    <div class="entry" style="float:left; width:85%;">{$art.sub_title}</div>
                {/if}
                
                {if $art.url == null || $art.url == ""}
                    <div class="entry" style="width:98%;">
                        {$art.body|truncate:300}
                        <a class="more" href="{$smarty.const.URL}/a/{$art.id}"> &raquo;read more</a>
                    </div>
                {else}
                    <div class="entry" style="width:98%;">
                        {$art.body|truncate:300}
                        <a class="more" href="{$smarty.const.URL}/a/{$art.url}"> &raquo;read more</a>
                    </div>
                {/if}

                <div class="entry" style="width:98%;">
                    
                    Rating: {$art.rating}
                    {section name=foo start=1 loop=6 max=6 step=1}
                        {if $smarty.section.foo.index <= $art.rating}
                            <img src="{$smarty.const.URL}/interface/icos/star.png" alt="Rating {$smarty.section.foo.index}" width="12px"/>
                        {elseif $smarty.section.foo.index > $art.rating}
                            <img src="{$smarty.const.URL}/interface/icos/star_dull.png" alt="{$smarty.section.foo.index}" width="12px"/>
                        {/if}
                    {/section}
                     | Views: {$art.view_count}

                    {if $art.user_email == $email}
                        | <span><a href="{$smarty.const.URL}/article/edit/{$art.id}">Edit this page</a>&nbsp;|&nbsp;<a href="{$smarty.const.URL}/article/delete/{$art.id}" class="artdel">Delete this page</a></span>
                    {/if}
                    | <a href="{$smarty.const.URL}/article/categorybrowse/{$art.category|replace:' ':'_'}">{$art.category}</a>
                </div>
            </div>
        {/foreach}
        <div style="float:left; width:740px;" >
            <br />
            <span style='float:right;' class="pageLink">{paginate_first}&nbsp;&nbsp;{paginate_prev}&nbsp;&nbsp;{paginate_middle format="page" prefix="" suffix="" link_prefix="&nbsp;" link_suffix="&nbsp;" }&nbsp;&nbsp;{paginate_next}&nbsp;&nbsp;{paginate_last}</span>
        </div>
    {else}
        <p>There are no published page</p>
    {/if} 
</div>

{literal}
<script type="text/javascript">
$(document).ready(function(){
    $('a.artdel').click(function(){
       var link = $(this).attr('href');
        jConfirm('Are you sure you want to delete this page?', 'Confirmation Dialog', function(r) {
            if(r == true){
                window.location.href = link;
            }
            else{
                return false;
            }
        });
        return false;
    });
});
</script>
{/literal}