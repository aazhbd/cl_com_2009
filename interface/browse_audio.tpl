<div style="float:left; width:740px;">
    {*include file="subtpl/had.tpl"*}
    <div id="pginfo">
        Browse latest audios published by users of conveylive. You may browse audios by artist or genre.
        Listen to the audios one by one either from browse page or individually. If you are logedin you may post comments to give some feedback and rate them if you like or dislike them.
    </div>
    {if $audioList != null}
        <h3><a href="{$smarty.const.URL}/audio/browsegenre">Browse by Genre</a> | <a href="{$smarty.const.URL}/audio/browseartist">Browse by Artist</a></h3>
    {/if}
    
    <div style="padding: 1em;">
    {if $pubList != null}
        <br />
        <div class="browsecat" style="float:left;">
            <h3>Published Genre</h3>
            <div class="catmenuLink" style="border:none;">
                {foreach item=audio from=$pubList}
                    <li>
                        <a href="{$smarty.const.URL}/audio/genrebrowse/{$audio.linkgenre}">{$audio.genre.cname} ({$audio.count}) </a>
                    </li>
                {/foreach}
            </div>
        </div>
    {/if}
    
    {if $selfList != null}
        <div class="browsecat" style="float:left;">
            <h3>Personal Uploaded Genre</h3>
            <div class="catmenuLink" style="border:none; ">
                {foreach item=audio from=$selfList}
                    <li>
                        <a href="{$smarty.const.URL}/audio/genrebrowse/{$audio.linkgenre}/self">{$audio.genre.cname} ({$audio.count}) </a>
                    </li>
                {/foreach}
            </div>
        </div>
    {/if}
    </div>
    
    <div style="width:740px;">
        <br />
        {if $topicHead != null}
            <h3>{$topicHead}</h3>
        {/if}
    </div>
    
    <div>
        {if $audioList != null}
            <div>
                <span style='float:left;' class="pageLink">Showing audios {$paginate.first}-{$paginate.last} of {$paginate.total}</span>
            
                <span style='float:right;' class="pageLink">{paginate_first}&nbsp;&nbsp;{paginate_prev}&nbsp;&nbsp;{paginate_middle format="page" prefix="" suffix="" link_prefix="&nbsp;" link_suffix="&nbsp;" }&nbsp;&nbsp;{paginate_next}&nbsp;&nbsp;{paginate_last}</span>
            </div>
            
            <div>
            {foreach item=audio from=$audioList}
                <div class="artcont">

                    <a href='{$smarty.const.URL}/audio/listen/{$audio.id}' class="entry" style="width:60%;" id="titleblock">{$audio.title}</a>
                    
                    <a href="{$smarty.const.URL}/profile/view/{$audio.pid}" class="entry" style="width:30%;" id="titleblock">by {$audio.author} | {$audio.ins_date|date_format} </a>
                    
                    <div class="entry" style="width:60%;">{$audio.artist}</div>
                    
                    <div class="entry" style="width:30%;">
                        <object type='application/x-shockwave-flash' data='{$smarty.const.URL}/scripts/player/mp3player.swf' width='185' height='20'>
                             <param name='movie' value='{$smarty.const.URL}/scripts/player/mp3player.swf' />
                             <param name = 'wmode' value = 'transparent' / >
                             <param name='FlashVars' value="mp3={$smarty.const.URL}/getaudio.php?id={$audio.id}" />
                        </object>
                    </div>
                    
                    <div class="entry" style="width:100%;">
                        Rating: {$audio.rating}
                        {section name=foo start=1 loop=6 max=6 step=1}
                            {if $smarty.section.foo.index <= $audio.rating}
                                <img src="{$smarty.const.URL}/interface/icos/star.png" alt="{$audio.author} , {$audio.title}" width="12px"/>
                            {elseif $smarty.section.foo.index > $article.rating}
                                <img src="{$smarty.const.URL}/interface/icos/star_dull.png" alt="{$audio.author} , {$audio.title}" width="12px"/>
                            {/if}
                        {/section} 
                        | Played: {$audio.view_count} | <a href="{$smarty.const.URL}/audio/genrebrowse/{$audio.genre|replace:' ':'_'}">{$audio.genre|capitalize}</a>
                        {if $audio.user_email == $email}
                            | <a href="{$smarty.const.URL}/audio/edit/{$audio.id}">Edit Audio Info</a> | <a href="{$smarty.const.URL}/audio/delete/{$audio.id}" class="audiodel">Delete Audio</a>
                        {/if}
                    </div>
                    
                </div>
            {/foreach}
            </div>
            
             <br />
             
            <span style='float:right;' class="pageLink">{paginate_first}&nbsp;&nbsp;{paginate_prev}&nbsp;&nbsp;{paginate_middle format="page" prefix="" suffix="" link_prefix="&nbsp;" link_suffix="&nbsp;" }&nbsp;&nbsp;{paginate_next}&nbsp;&nbsp;{paginate_last}</span>
            <br /><br />
        {else}
            <p>No latest audio has been published.</p>
        {/if}
    </div>
</div>
{literal}
<script type="text/javascript">
    $(document).ready(function(){
        $('a.audiodel').click(function(){
           var link = $(this).attr('href');
            jConfirm('Are you sure you want to delete this article?', 'Confirmation Dialog', function(r) {
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