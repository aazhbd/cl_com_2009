<div style="width:740px;"> 
    {if $video != null}
        <div id="box">
            <div style="width:42px; height:42px; float:left;">
                <a href="{$smarty.const.URL}/profile/view/{$video.pid}"><img src="{$smarty.const.URL}/getsmimage.php?id={$video.user_imgs_id}" alt="{$video.name}" height="40" /></a>
            </div>
            <div class="smallbox">
                <a href="{$smarty.const.URL}/profile/view/{$video.pid}">{$video.f_name} {$video.l_name}</a><br />
                {$video.ins_date|date_format}            
            </div>
            
            <div class="infobox">
                {$com_count|default:'0'} Comments | Played {$video.view_count} times |
                {$video.tothits} Hits 
                <br />
                {if $video.user_email neq $email && $islogin == true}
                    Rate up&nbsp;<a href="{$smarty.const.URL}/video/rateup/{$video.id}" ><img src="{$smarty.const.URL}/interface/icos/thumbs_up.gif" width="15px" alt="{$video.name},rating-up, {$video.title}" border="0"/></a> &nbsp;
                    Rate down&nbsp;<a href="{$smarty.const.URL}/video/ratedown/{$video.id}" ><img src="{$smarty.const.URL}/interface/icos/thumbs_down.gif" width="15px" alt="{$video.name}, rating-down, {$video.title}" border="0" /></a>
                {/if}
            </div>
            
            <div class="ratingbox">
                Rating: {$video.rating}
                {section name=foo start=1 loop=6 max=6 step=1}
                    {if $smarty.section.foo.index <= $video.rating}
                        <img src="{$smarty.const.URL}/interface/icos/star.png" alt="{$video.title} , {$video.f_name}, {$video.l_name}" width="12px"/>
                    {elseif $smarty.section.foo.index > $video.rating}
                        <img src="{$smarty.const.URL}/interface/icos/star_dull.png" alt="{$video.title} , {$video.f_name}, {$video.l_name}" width="12px"/>
                    {/if}
                {/section}
                {if $video.category != ""}<br /><a href="{$smarty.const.URL}/video/categorybrowse/{$video.category|replace:' ':'_'}">{$video.category}{/if}</a>
            </div>
        </div>
    {/if}
</div>
<br />
<div style="width:740px;">
    {if $prev != null}
        <div style="float:left;">
            <a href="{$smarty.const.URL}/video/watch/{$prev.id}" title="{$prev.title}">
                <div style="float: left;"><img src="{$smarty.const.URL}/interface/images/left_arrow.png" /></div>
                <div style="float: left; padding: 10px;">Previous</div>
            </a>
        </div>
    {/if}
    {if $next != null}
        <div style="float:right;">
            <a href="{$smarty.const.URL}/video/watch/{$next.id}" title="{$next.title}">
                <div style="float: left; padding: 10px;">Next</div>
                <div style="float: left;"><img src="{$smarty.const.URL}/interface/images/right_arrow.png" /></div>
            </a>            
        </div>
    {/if}
</div>

{if $video != null}
    <div style="float:left; width:580px;margin-top:10px;">    
        <center>                
                <div>
                    <a 
                        href="{$smarty.const.URL}/directories/videos/{$video.file_path}"
                        style="display:block;width:570px;height:350px;" 
                        id="player"
                        title="{$video.title} - Artist - {$video.artist} , pubished by {$video.f_name}, {$video.l_name}, Category - {$video.category}">
                        
                    </a>
                    <div class="info" ></div>
                </div>
                
        </center>
        <br />    
        <div style="width:570px;">
            {if $video.user_email eq $email && $islogin == true}
                <br /><br />
                <a href="{$smarty.const.URL}/video/delete/{$video.id}" class="artdel"><img src="{$smarty.const.URL}/interface/icos/delete_post.png" style="width:20px;" /> Delete this video</a></span>
            {/if}
            {if $video.artist != null}
                <br />
                <div style="font-weight:bold;">
                    In this video: {$video.artist}<br />
                </div>
                <br />
            {/if}
        </div>
        <hr />
        <div style="float:left;width:570px; margin-top:5px;">
            {if $video.additional neq ""}
                <div class="entry" style="width:95%;">
                    <img src="{$smarty.const.URL}/interface/icos/posttopic.png" style="width:30px;" />
                    <span style="font-weight:bold;">Additional Info: </span> {$video.additional}
                </div>
            {/if}
            {if $video.meta_tags neq ""}
                <div class="entry" style="width:95%;">
                    <img src="{$smarty.const.URL}/interface/icos/key.png" style="width:30px;" />
                    <span style="font-weight:bold;">Keywords: </span> {$video.meta_tags}
                </div>
            {/if}
        </div>
    </div>
{else}
    <div id="pginfo">No video is available</div>
{/if}    
<div style="width:160px;float:left;">
    {if $relArt != null}
        <div style="width:160px;">
            <h3 style="padding-left:10px;"><img src="{$smarty.const.URL}/interface/icos/tag_blue.png" style="width:25px;margin-left:5px;margin-right:5px;" />Related Videos</h3>
            <div class="relList">
                <br />
                {foreach item=art from=$relArt}
                    <div align="center">
                        <a href="{$smarty.const.URL}/video/watch/{$art.id}" ><img src="{$smarty.const.URL}/getsmimage.php?id={$art.img_id}" width="130" /></a>
                        <a href='{$smarty.const.URL}/video/watch/{$art.id}'>{$art.title|truncate:30}</a>
                    </div>
                    <br />
                {/foreach}
                <div>Browse related videos of category <a href="{$smarty.const.URL}/video/categorybrowse/{$video.category|replace:' ':'_'}"> >> {$video.category|truncate:30}</a></div>
            </div>
            
        </div>
    {else}
        <br />
    {/if}
</div>

{if $video != null}
<div style="float:left; width:740px;">
    <br />
    {if $coms != null}
        <br />
        <h3><img src="{$smarty.const.URL}/interface/icos/comments.png" style="width:30px;" />Comments on this video</h3>
        <br />
    {/if}
    <div id="comlist">
        {if $coms != null}
            {include file="comment_view.tpl"}
        {/if}
    </div>
    {if $islogin == true}
        {assign var='mid' value=$video.id}
        {assign var='mtype' value='Video'}
        
        {include file='frm_comment.tpl'}    
    {else}
        <div style="width:550px;" id="addcomment">
            <h3>Please <a href="{$smarty.const.URL}/signup">Signup</a> to comment on this video</h3>
        </div>    
    {/if}
</div>
{/if}

{if $video != null && $islogin == true}
    <br />
    <div style="width:740px;">
        <br />
        {include file="invitecontent_form.tpl"}
    </div>
{/if}
{literal}
<script type="text/javascript">
var srcurl = {/literal}'{$smarty.const.URL}/scripts/player/flowplayer-3.1.5.swf'{literal};
    flowplayer(
        'player',
        {
            src: srcurl,
            wmode: 'opaque',
            onFail: function()  { 
                document.getElementById("info").innerHTML = 
                    "You need the latest Flash version to Conveylive Videos. " + 
                    "Your version is " + this.getVersion() 
                ; 
            },
            version: [9, 115],
            
            onFinish: function() {
                alert("Click Player to start video again"); 
            }
                       
        },
        {
            clip:  {
                autoPlay: false,
                autoBuffering: true
            }
        }
    );
</script>
{/literal}
{literal}
<script type="text/javascript">
$(document).ready(function()
{        
    $('a.delvid').click(function(){
       var link = $(this).attr('href');
        jConfirm('Are you sure you want to delete this Video?', 'Confirmation Dialog', function(r) {
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
