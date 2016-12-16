<div style="width:740px;">
    {*include file="subtpl/had.tpl"*}
    <div id="pginfo">
        Browse latest videos published by users of conveylive. You may browse videos by category.
        Watch videos and share with your friends. If you are logedin you may post comments to give some feedback and rate them if you like or dislike them.
    </div>
    <div style="padding: 1em;">
        {if $pubList != null}
            <br />
            <div class="browsecat" style="float:left;">
                <h3>Published Categories</h3>
                <div class="catmenuLink" style="border:none; ">
                    {foreach item=video from=$pubList}
                        <div><a href="{$smarty.const.URL}/video/categorybrowse/{$video.linkcat}">{$video.cat.cname} ({$video.count}) </a></div>
                    {/foreach}
                </div>
            </div>
        {/if}
        {if $selfList != null}
            <div class="browsecat" style="float:left;">
                <h3>Personal Upload Categories</h3>
                <div class="catmenuLink" style="border:none; ">
                {foreach item=video from=$selfList}
                    <div><a href="{$smarty.const.URL}/video/categorybrowse/{$video.linkcat}/self">{$video.cat.cname} ({$video.count}) </a></div>
                {/foreach}
                </div>
            </div>
        {/if}

    </div>

    <div style="float:left;width:740px;">
        <br /><br />
        <div style="width:740px;">
            <h3>{$topicHead}</h3>
        </div>
    </div>
    <div style="width:740px;">
        {if $videoList != null}
            <div>            
                <span style='float:left;' class="pageLink">Showing videos {$paginate.first}-{$paginate.last} of {$paginate.total}</span>
                <span style='float:right;' class="pageLink">{paginate_first}&nbsp;&nbsp;{paginate_prev}&nbsp;&nbsp;{paginate_middle format="page" prefix="" suffix="" link_prefix="&nbsp;" link_suffix="&nbsp;" }&nbsp;&nbsp;{paginate_next}&nbsp;&nbsp;{paginate_last}</span>
            </div>
            {foreach item=video from=$videoList}
                <br />
                <div class="artcont">
                    <a href='{$smarty.const.URL}/video/watch/{$video.id}' id="titleblock" class="entry" style="width:65%;">{$video.title}</a>
                    
                    <a href="{$smarty.const.URL}/profile/view/{$video.pid}" class="entry" style="width:30%;" id="titleblock">{$video.author} | {$video.ins_date|date_format}</a>
                    
                    <div style="float: none; width: 98%;">
                        <div class="entry" style="width:auto;">
                            <a href="{$smarty.const.URL}/video/watch/{$video.id}"><img src="{$smarty.const.URL}/getsmimage.php?id={$video.img_id}" width="200" alt="Video, {$video.title}, {$video.author}, {$video.category}, ConveyLive" /></a>
                        </div>
                        <div class="entry" style="width:45%;">
                            {$video.artist}
                        </div>
                    </div>
                    
                    <div class="entry" style="width:100%;">
                        Rating: {$video.rating} 
                        {section name=foo start=1 loop=6 max=6 step=1}
                            {if $smarty.section.foo.index <= $video.rating}
                                <img src="{$smarty.const.URL}/interface/icos/star.png" alt="{$video.title} , {$video.title}" width="12px"/>
                            {elseif $smarty.section.foo.index > $video.rating}
                                <img src="{$smarty.const.URL}/interface/icos/star_dull.png" alt="{$video.title} , {$video.title}" width="12px"/>
                            {/if}
                        {/section}
                        | Played: {$video.view_count} | <a href="{$smarty.const.URL}/video/categorybrowse/{$video.category|replace:' ':'_'}">{$video.category|capitalize} </a>
                        {if $video.user_email == $email}
                            | <a href="{$smarty.const.URL}/video/delete/{$video.id}" class="videodel">Delete Video</a>
                        {/if}
                    </div>
                </div>
            {/foreach}

            <div style="width:740px;">
                <span style="float:right;" class="pageLink">{paginate_first}&nbsp;&nbsp;{paginate_prev}&nbsp;&nbsp;{paginate_middle format="page" prefix="" suffix="" link_prefix="&nbsp;" link_suffix="&nbsp;" }&nbsp;&nbsp;{paginate_next}&nbsp;&nbsp;{paginate_last}</span>
            </div>
        {else}
            <p>No latest video has been published.</p>
        {/if}
    </div>
</div>
{literal}
<script type="text/javascript">
$(document).ready(function(){
    $('a.videodel').click(function(){
       var link = $(this).attr('href');
        jConfirm('Are you sure you want to delete this video?', 'Confirmation Dialog', function(r) {
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