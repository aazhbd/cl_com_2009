<div style="width:740px;">
    <div style="width:740px;">
        {if $prev != null}
            <div style="float:left;">
                <a href="{$smarty.const.URL}/audio/listen/{$prev.id}" title="{$prev.title}">
                    <div style="float: left;"><img src="{$smarty.const.URL}/interface/images/left_arrow.png" /></div>
                    <div style="float: left; padding: 10px;">Previous</div>
                </a>
            </div>
        {/if}
        {if $next != null}
            <div style="float:right;">
                <a href="{$smarty.const.URL}/audio/listen/{$next.id}" title="{$next.title}">
                    <div style="float: left; padding: 10px;">Next</div>
                    <div style="float: left;"><img src="{$smarty.const.URL}/interface/images/right_arrow.png" /></div>
                </a>
            </div>
        {/if}
    </div>
    {if $audio != null}
        <div class="artcont" style="float:left;width:730px;">
            <div class="entry" style="width:60%; font-weight:bold; font-size:16px;"><a href='{$smarty.const.URL}/audio/listen/{$audio.id}'>{$audio.title|capitalize}</a></div>
            <div class="entry" style="width:37%;" align="right">by <a href="{$smarty.const.URL}/profile/view/{$audio.pid}">{$audio.author}</a> | {$audio.ins_date|date_format}</div>
            <div class="entry" style="width:60%;">{$audio.artist}</div>

            <div class="entry" style="width:98%;" align="center">
                <object type='application/x-shockwave-flash' data='{$smarty.const.URL}/scripts/player/mp3player.swf' width='300' height='30'>
                     <param name='movie' value='{$smarty.const.URL}/scripts/player/mp3player.swf' />
                     <param name = 'wmode' value = 'transparent' / >
                     <param name='FlashVars' value="mp3={$smarty.const.URL}/getaudio.php?id={$audio.id}&amp;showstop=1&amp;showvolume=1" />
                </object><br />
                Click the play button to play this audio
            </div>
            <div class="entry" style="width:100%;">
                Hits : {$audio.tothits} 
                {if $audio.user_email neq $email && $islogin == true }
                    <a href="{$smarty.const.URL}/audio/rateup/{$audio.id}" ><img src="{$smarty.const.URL}/interface/icos/thumbs_up.gif" width="15px" alt="{$audio.name},rating-up, {$audio.title}" border="0"/></a> &nbsp;
                    <a href="{$smarty.const.URL}/audio/ratedown/{$audio.id}" ><img src="{$smarty.const.URL}/interface/icos/thumbs_down.gif" width="15px" alt="{$audio.name}, rating-down, {$audio.title}" border="0" /></a>
                {/if}
                | Rating: {$audio.rating}
                {section name=foo start=1 loop=6 max=6 step=1}
                    {if $smarty.section.foo.index <= $audio.rating}
                        <img src="{$smarty.const.URL}/interface/icos/star.png" alt="{$audio.author} , {$audio.title}" width="12px"/>
                    {elseif $smarty.section.foo.index > $article.rating}
                        <img src="{$smarty.const.URL}/interface/icos/star_dull.png" alt="{$audio.author} , {$audio.title}" width="12px"/>
                    {/if}
                {/section}
                | Played: {$audio.view_count}
                | Comments {$com_count|default:0}
                | <a href="{$smarty.const.URL}/audio/genrebrowse/{$audio.genre|replace:' ':'_'}">{$audio.genre|capitalize} </a>
                
                {if $audio.user_email == $email && $islogin == true}
                    <br /><br />
                    <a href="{$smarty.const.URL}/audio/edit/{$audio.id}">Edit Audio Info</a> | <a href="{$smarty.const.URL}/audio/delete/{$audio.id}" class="audiodel">Delete Audio</a>
                {/if}                
            </div>
            <br />
        </div>
        {if $audio.additional neq "" || $audio.meta_tags neq ""}
            <div style="float:left;width:350px; margin-top:5px;">
                {if $audio.additional neq ""}
                    <div class="entry" style="width:95%;">
                        <img src="{$smarty.const.URL}/interface/icos/posttopic.png" style="width:30px;" />
                        <span style="font-weight:bold;">Additional Info: </span> {$audio.additional}
                    </div>
                {/if}
                {if $audio.meta_tags neq ""}
                    <div class="entry" style="width:95%;">
                        <img src="{$smarty.const.URL}/interface/icos/key.png" style="width:30px;" />
                        <span style="font-weight:bold;">Keywords: </span> {$audio.meta_tags}
                    </div>
                {/if}
            </div>
        {/if}
        {if $latArt != null}
            <div style="float:left;width:180px;margin-top:5px;">
                <h3>Latest Audio</h3>
                <div class="relList">
                    {foreach item=art from=$latArt}
                        <li style="padding:2px; list-style:none;">
                            <a href='{$smarty.const.URL}/audio/listen/{$art.id}'>
                                <img src="{$smarty.const.URL}/interface/icos/arrow_gray.gif" style="width:7px;"/> 
                                {$art.title|truncate:20}
                            </a>
                        </li>
                    {/foreach}
                </div>
                <p><a href="{$smarty.const.URL}/audio/browse">Browse All Latest Audio</a></p>
            </div>
        {else}    
            <br />
        {/if}
        
        {if $popArt != null}
            <div style="float:left;width:200px;margin-top:5px;">
                <h3>Popular Audio</h3>
                <div class="relList">
                    {foreach item=art from=$popArt}
                        <li style="padding:2px; list-style:none;">
                            <a href='{$smarty.const.URL}/audio/listen/{$art.id}'>
                                <img src="{$smarty.const.URL}/interface/icos/arrow_gray.gif" style="width:7px;"/> 
                                {$art.title|truncate:20}
                            </a>
                        </li>
                    {/foreach}
                </div>
            </div>
        {else}    
            <br />
        {/if}
    {else}
        This audio is not available
    {/if}

    <div style="width:730px;float:left;">
        {if $coms != null}
            <br />
            <h3><img src="{$smarty.const.URL}/interface/icos/comments.png" style="width:30px;" />Comments on this audio</h3>
            <br />
        {/if}
        <div id="comlist">
            {if $coms != null}
                {include file="comment_view.tpl"}
            {/if}
        </div>
        <br />
        {if $islogin == true}
            {assign var='mid' value=$audio.id}
            {assign var='mtype' value='Audio'}
            
            {include file='frm_comment.tpl'}        
        {else}
            <div style="width:550px;" id="addcomment">
                <h3>Please <a href="{$smarty.const.URL}/signup">Signup</a> to comment on this audio</h3>
            </div>
        {/if}
    </div>
    
    {if $relArt != null}
        <div style="width:720px;float:left; margin-top:10px; " class="invitebox">
            <h3>Related Audio</h3>
            <div class="relList">
                {foreach item=art from=$relArt}
                    <li style="padding:5px; list-style:none;">
                        <a href="{$smarty.const.URL}/audio/listen/{$art.id}" >
                            <img src="{$smarty.const.URL}/interface/icos/arrow_gray.gif" style="width:7px;"/>&nbsp;{$art.title}
                        </a>
                    </li>
                {/foreach}
            </div>
            <div style="padding:10px;">
                Browse other audios from this genre >> <a href="{$smarty.const.URL}/audio/genrebrowse/{$audio.genre|replace:' ':'_'}">{$audio.genre}</a>
            </div>
        </div>
    {/if}
</div>
{if $audio != null && $islogin == true}
    <br />
    <div style="width:740px;">
        {include file="invitecontent_form.tpl"}
    </div>
{/if}

{literal}
<script type="text/javascript">
$(document).ready(function()
{        
    $('a.audiodel').click(function(){
       var link = $(this).attr('href');
        jConfirm('Are you sure you want to delete this audio?', 'Confirmation Dialog', function(r) {
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