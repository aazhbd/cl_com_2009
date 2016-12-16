{literal}
<script type="text/javascript">

    $(document).ready(function() {

        $("#reps").hide();
        $('#tabs').tabs();
        $('#tabs').tabs({ fx: { opacity: 'toggle' } });
        $('#tabs').tabs('option', 'fx', { opacity: 'toggle' });
    });

</script>
{/literal}
<div style="float:left;width:740px;">
    {*include file="subtpl/had.tpl"*}
    <div>
        <form action="{$smarty.const.URL}/searchpost.php" method="post" >
            <fieldset>
                <div>
                    <span>
                        <div style="float:left;">
                            <input type="text" class="field" name="token" id="token" value="{$token}"  style="width:560px;" />
                            <input type="submit" name="submit" id = "submit" class="frmbtn"  value="Search" />
                        </div>
                    </span>
                </div>
            </fieldset>
        </form>
    </div>
    <div class="bhead" style='width:97%;'>
        Search Results For Keyword(s) : {$token}
    </div>    
    <div id="tabs" style='98%;'>
        <ul>
            <li><a href="#tabs-1">People</a></li>
            <li><a href="#tabs-2">Pages</a></li>
            <li><a href="#tabs-3">Photos</a></li>
            <li><a href="#tabs-4">Audio</a></li>
            <li><a href="#tabs-5">Videos</a></li>
            <li><a href="#tabs-6">Blogs</a></li>
            <li><a href="#tabs-7">Clubs</a></li>
        </ul>
        <div id="tabs-1">
            {if $people != null}
                <div style="float:left; width:100%;">
                    <div>
                        <img src="{$smarty.const.URL}/interface/icos/convey-logo.png" style="width:40px;" /> <strong>People Search</strong> :{$pag_ppl.total} result(s) found.
                        <div style="width:100%;" align="right">{paginate_first id="people"}&nbsp;&nbsp;{paginate_prev id="people"}&nbsp;&nbsp;{paginate_middle id="people" format="page" prefix="" suffix="" link_prefix="&nbsp;" link_suffix="&nbsp;" }&nbsp;&nbsp;{paginate_next id="people"}&nbsp;&nbsp;{paginate_last id="people"}</div>
                        <hr />
                        <div style="background:#F0F8FF; padding-left:5px; border: thin solid #eee; color:#336; width:100%; margin-bottom:10px;">
                            Showing {$pag_ppl.first}-{$pag_ppl.last} of {$pag_ppl.total}
                        </div>
                        {foreach item=frnd from=$people}
                            <div style="border:#eee thin solid; padding:5px; width=400px;">
                                <div>
                                    <div style="float:left; width:150px;"><img src="{$smarty.const.URL}/getsmimage.php?id={$frnd.user_imgs_id}" height="70" border="1" alt="{$frnd.f_name} {$frnd.l_name}" /></div>
                                    <div style="float:left; width:200px;">
                                        <div><h3><a href="{$smarty.const.URL}/profile/view/{$frnd.id}">{$frnd.f_name} {$frnd.l_name}</a></h3></div>
                                    </div>
                                    <div style="float:left;">
                                        <div><img src="{$smarty.const.URL}/interface/icos/email.png" width="20" alt="{$frnd.f_name}, {$frnd.l_name}, People, Friends, Network, ConveyLive" /><a href="{$smarty.const.URL}/friend/sendmessage/{$frnd.id}">Send a message</a></div>
                                        <div><img src="{$smarty.const.URL}/interface/icos/users.png" width="20" alt="{$frnd.f_name}, {$frnd.l_name}, People, Friends, Network, ConveyLive" /><a href="{$smarty.const.URL}/friend/viewfriends/{$frnd.id}">View Friends</a></div>
                                    </div>
                                </div>
                            </div>
                        {foreachelse}
                            <div class="artcont">
                                <div class="entry" style="width:90%;">
                                    <h3>No Match Found</h3>
                                </div>
                            </div>                            
                        {/foreach}
                    </div>
                    <br />
                    <span>{paginate_first id="people"}&nbsp;&nbsp;{paginate_prev id="people"}&nbsp;&nbsp;{paginate_middle id="people" format="page" prefix="" suffix="" link_prefix="&nbsp;" link_suffix="&nbsp;" }&nbsp;&nbsp;{paginate_next id="people"}&nbsp;&nbsp;{paginate_last id="people"}</span>
                </div>
            {else}
                <div class="artcont">
                    <div class="entry" style="width:90%;">
                        <h3>No Match Found</h3>
                    </div>
                </div>            
            {/if}            
        </div>
        <div id="tabs-2">
            {if $articles != null}
                <div style="float:left; width:100%;">
                    <img src="{$smarty.const.URL}/interface/icos/article.png" style="width:42px;" /> <strong>Page Search</strong> :{$pag_art.total} result(s) found.
                    <div style="width:100%;" align="right">{paginate_first id="articles"}&nbsp;&nbsp;{paginate_prev id="articles"}&nbsp;&nbsp;{paginate_middle id="articles" format="page" prefix="" suffix="" link_prefix="&nbsp;" link_suffix="&nbsp;" }&nbsp;&nbsp;{paginate_next id="articles"}&nbsp;&nbsp;{paginate_last id="articles"}</div>
                    <hr />
                    <div style="background:#F0F8FF; padding-left:5px; border: thin solid #eee; color:#336; width:100%; margin-bottom:10px;">
                        Showing {$pag_art.first}-{$pag_art.last} of {$pag_art.total}
                    </div>                    
                    {foreach item=art from=$articles}
                        <div class="artcont" style="height:100px;">
                            {if $art.url == null || $art.url == ""}
                                <div class="entry" style="width:65%;"><a href='{$smarty.const.URL}/article/view/{$art.id}'>{$art.title}</a></div>
                            {else}
                                <div class="entry" style="width:65%;"><a href='{$smarty.const.URL}/a/{$art.url}'>{$art.title}</a></div>
                            {/if}
                            <div class="entry" style="width:30%;"><a href="{$smarty.const.URL}/profile/view/{$art.pid}">{$art.f_name} {$art.l_name}</a></div>
                            <div class="entry" style="width:65%;">{$art.sub_title}</div>
                            <div class="entry" style="width:30%;">{$art.ins_date|date_format}</div>
                        </div>
                    {foreachelse}
                        <div class="artcont">
                            <div class="entry" style="width:90%;">
                                <h3>No Match Found</h3>
                            </div>
                        </div>
                    {/foreach}
                </div>
                <span>{paginate_first id="articles"}&nbsp;&nbsp;{paginate_prev id="articles"}&nbsp;&nbsp;{paginate_middle id="articles" format="page" prefix="" suffix="" link_prefix="&nbsp;" link_suffix="&nbsp;" }&nbsp;&nbsp;{paginate_next id="articles"}&nbsp;&nbsp;{paginate_last id="articles"}</span>
            {else}
                <div class="artcont">
                    <div class="entry" style="width:90%;">
                        <h3>No Match Found</h3>
                    </div>
                </div>
            {/if}            
        </div>
        <div id="tabs-3">
            {if $albums != null}
                <div style="float:left; width:98%;">
                    <img src="{$smarty.const.URL}/interface/icos/images.png" style="width:42px;" /> <strong>Album Search</strong> :{$pag_alb.total} result(s) found.
                    <div style="width:100%;" align="right">{paginate_first id="albums"}&nbsp;&nbsp;{paginate_prev id="albums"}&nbsp;&nbsp;{paginate_middle id="albums" format="page" prefix="" suffix="" link_prefix="&nbsp;" link_suffix="&nbsp;" }&nbsp;&nbsp;{paginate_next id="albums"}&nbsp;&nbsp;{paginate_last id="albums"}</div>
                    <hr />
                    <div style="background:#F0F8FF; padding-left:5px; border: thin solid #eee; color:#336; width:100%; margin-bottom:10px;">
                        Showing {$pag_alb.first}-{$pag_alb.last} of {$pag_alb.total}
                    </div> 
                    {foreach item=album from=$albums}
                        <div class="artcont">
                            <div class="entry" style="width:65%;"><a href='{$smarty.const.URL}/picture/albumview/{$album.id}'>{$album.album_name}</a> | {$album.ins_date|date_format}</div>
                            <div class="entry" style="width:30%;">
                                {if $album.pid != null}
                                    by <a href="{$smarty.const.URL}/profile/view/{$album.pid}">{$album.f_name} {$album.l_name}</a>
                                {else}
                                    by {$album.f_name} {$album.l_name}
                                {/if}
                            </div>
                            <div class="entry" style="width:35%;"><a href='{$smarty.const.URL}/picture/albumview/{$album.id}'><img src="{$smarty.const.URL}/getsmimage.php?id={$album.image_id}" alt="{$album.f_name} , {$album.l_name} , {$album.album_name}, conveylive.com" width="120px;" /></a></div>
                            <div class="entry" style="width:20%;">{$album.remarks}</div>
                        </div>
                    {foreachelse}
                        <div class="artcont">
                            <div class="entry" style="width:90%;">
                                <h3>No Match Found</h3>
                            </div>
                        </div>
                    {/foreach}
                </div>                
                <span>{paginate_first id="albums"}&nbsp;&nbsp;{paginate_prev id="albums"}&nbsp;&nbsp;{paginate_middle id="albums" format="page" prefix="" suffix="" link_prefix="&nbsp;" link_suffix="&nbsp;" }&nbsp;&nbsp;{paginate_next id="albums"}&nbsp;&nbsp;{paginate_last id="albums"}</span>
            {else}
                <div class="artcont">
                    <div class="entry" style="width:90%;">
                        <h3>No Match Found</h3>
                    </div>
                </div>
            {/if}
        </div>
        <div id="tabs-4">
            {if $audios != null}
                
                <div style="float:left; width:98%;">
                    <img src="{$smarty.const.URL}/interface/icos/audio.png" style="width:42px;" /> <strong>Audio Search</strong> : {$pag_aud.total} result(s) found.
                    <div style="width:100%;" align="right">{paginate_first id="audios"}&nbsp;&nbsp;{paginate_prev id="audios"}&nbsp;&nbsp;{paginate_middle id="audios" format="page" prefix="" suffix="" link_prefix="&nbsp;" link_suffix="&nbsp;" }&nbsp;&nbsp;{paginate_next id="audios"}&nbsp;&nbsp;{paginate_last id="audios"}</div>
                    <hr />
                    <div style="background:#F0F8FF; padding-left:5px; border: thin solid #eee; color:#336; width:100%; margin-bottom:10px;">
                        Showing {$pag_aud.first}-{$pag_aud.last} of {$pag_aud.total}
                    </div>                     
                    {foreach item=audio from=$audios}
                        <div class="artcont">
                            <div class="entry" style="width:65%;"><a href='{$smarty.const.URL}/audio/listen/{$audio.id}'>{$audio.title}</a> </div>
                            <div class="entry" style="width:30%;">by <a href="{$smarty.const.URL}/profile/view/{$audio.pid}">{$audio.f_name} {$audio.l_name}</a></div>
                            <div class="entry" style="width:30%;">{$audio.ins_date|date_format}</a></div>
                            <div class="entry" style="width:65%;">{$audio.artist}</div>
                            <div class="entry" style="width:100%;">
                                Rating: {$audio.rating} | View: {$audio.view_count} | <a href="{$smarty.const.URL}/audio/genrebrowse/{$audio.category|replace:' ':'_'}">{$audio.category|capitalize}
                            </div>
                        </div>
                    {foreachelse}
                        <div class="artcont">
                            <div class="entry" style="width:90%;">
                                <h3>No Match Found</h3>
                            </div>
                        </div>
                    {/foreach}
                </div>                
                <span>{paginate_first id="audios"}&nbsp;&nbsp;{paginate_prev id="audios"}&nbsp;&nbsp;{paginate_middle id="audios" format="page" prefix="" suffix="" link_prefix="&nbsp;" link_suffix="&nbsp;" }&nbsp;&nbsp;{paginate_next id="audios"}&nbsp;&nbsp;{paginate_last id="audios"}</span>
            {else}
                <div class="artcont">
                    <div class="entry" style="width:90%;">
                        <h3>No Match Found</h3>
                    </div>
                </div>
            {/if}
        </div>
        <div id="tabs-5">
            {if $videos != null}
                
                <div style="float:left; width:98%;">
                    <img src="{$smarty.const.URL}/interface/icos/video.png" style="width:42px;" /> <strong>Video Search</strong> : {$pag_vid.total} result(s) found.
                    <div style="width:100%;" align="right">{paginate_first id="videos"}&nbsp;&nbsp;{paginate_prev id="videos"}&nbsp;&nbsp;{paginate_middle id="videos" format="page" prefix="" suffix="" link_prefix="&nbsp;" link_suffix="&nbsp;" }&nbsp;&nbsp;{paginate_next id="videos"}&nbsp;&nbsp;{paginate_last id="videos"}</div>
                    <hr />
                    <div style="background:#F0F8FF; padding-left:5px; border: thin solid #eee; color:#336; width:100%; margin-bottom:10px;">
                        Showing {$pag_vid.first}-{$pag_vid.last} of {$pag_vid.total}
                    </div>                    
                    {foreach item=video from=$videos}
                        <div class="artcont">
                            <div class="entry" style="width:65%;"><a href='{$smarty.const.URL}/video/watch/{$video.id}'>{$video.title}</a> | {$video.ins_date|date_format}</div>
                            <div class="entry" style="width:30%;"><a href="{$smarty.const.URL}/profile/view/{$video.pid}">{$video.f_name} {$video.l_name}</a></div>
                            <div class="entry" style="width:65%;">{$video.artist}</div>
                            <div class="entry" style="width:65%;"><img src="{$smarty.const.URL}/getsmimage.php?id={$video.img_id}" alt="{$video.f_name} , {$video.l_name} , {$video.title}, {$video.additional}, {$video.meta_tags}, conveylive.com"/></div>
                            <div class="entry" style="width:100%;">
                                Rating: {$video.rating} | View: {$video.view_count} | <a href="{$smarty.const.URL}/video/categorybrowse/{$video.category|replace:' ':'_'}">{$video.category|capitalize}</a>
                            </div>
                        </div>
                    {foreachelse}
                        <div class="artcont">
                            <div class="entry" style="width:90%;">
                                <h3>No Match Found</h3>
                            </div>
                        </div>
                    {/foreach}
                </div>                
                <span>{paginate_first id="videos"}&nbsp;&nbsp;{paginate_prev id="videos"}&nbsp;&nbsp;{paginate_middle id="videos" format="page" prefix="" suffix="" link_prefix="&nbsp;" link_suffix="&nbsp;" }&nbsp;&nbsp;{paginate_next id="videos"}&nbsp;&nbsp;{paginate_last id="videos"}</span>
            {else}
                <div class="artcont">
                    <div class="entry" style="width:90%;">
                        <h3>No Match Found</h3>
                    </div>
                </div>
            {/if}
        </div>
        <div id="tabs-6">
            {if $blogposts != null}
                <div style="float:left; width:98%;">
                    <img src="{$smarty.const.URL}/interface/icos/posttopic.png" style="width:42px;" /> <strong>Blog Post Search</strong> :{$pag_post.total} result(s) found.
                    <div style="width:100%;" align="right">{paginate_first id="blogposts"}&nbsp;&nbsp;{paginate_prev id="blogposts"}&nbsp;&nbsp;{paginate_middle id="blogposts" format="page" prefix="" suffix="" link_prefix="&nbsp;" link_suffix="&nbsp;" }&nbsp;&nbsp;{paginate_next id="blogposts"}&nbsp;&nbsp;{paginate_last id="blogposts"}</div>
                    <hr />
                    <div style="background:#F0F8FF; padding-left:5px; border: thin solid #eee; color:#336; width:100%; margin-bottom:10px;">
                        Showing page {$pag_post.page_current} of {$pag_post.page_total}
                    </div>
                    {foreach item=blog from=$blogposts}
                        <div class="artcont">
                            <div class="entry" style="float:left;width:20%;"><a href="{$smarty.const.URL}/profile/view/{$blog.pid}"><img src='{$smarty.const.URL}/getsmimage.php?id={$blog.user_imgs_id}' border="1" style="max-width:100px;max-height:150px;" alt="{$blog.f_name}, {$blog.l_name}, {$blog.url}, {$blog.name} " /></a></div>
                            <div class="entry" style="float:left;width:50%;"><b style="font-size:16px; color:#036;"><a href='{$smarty.const.URL}/b/{$blog.url}/{$blog.post_id}'>{$blog.title|truncate:50}</a></b></div>
                            <div class="entry" style="width:25%;float:right;">From the Blog: <b style="font-size:12px; color:#036;"><a href='{$smarty.const.URL}/b/{$blog.url}'>{$blog.blog_name}</a></b></div>
                            <div class="entry" style="float:left;width:50%;">{$blog.ins_date|date_format}</div>
                            <div class="entry" style="float:left;width:20%;">by <a href="{$smarty.const.URL}/profile/view/{$blog.pid}">{$blog.f_name} {$blog.l_name}</a></div>
                            <div class="entry" style="float:left;width:50%;"><b style="font-size:12px; ">{$blog.sub_title|truncate:80}</b></div>
                        </div>
                        <br />
                    {foreachelse}
                        <div class="artcont">
                            <div class="entry" style="width:90%;">
                                <h3>No Match Found</h3>
                            </div>
                        </div>
                    {/foreach}
                </div>
                <span>{paginate_first id="blogposts"}&nbsp;&nbsp;{paginate_prev id="blogposts"}&nbsp;&nbsp;{paginate_middle id="blogposts" format="page" prefix="" suffix="" link_prefix="&nbsp;" link_suffix="&nbsp;" }&nbsp;&nbsp;{paginate_next id="blogposts"}&nbsp;&nbsp;{paginate_last id="blogposts"}</span>
            {else}
                <div class="artcont">
                    <div class="entry" style="width:90%;">
                        <h3>No Match Found</h3>
                    </div>
                </div>
            {/if}
        </div>
        <div id="tabs-7">
            {if $clubs != null}
                <div style="float:left; width:98%;">
                    <img src="{$smarty.const.URL}/interface/icos/club.png" style="width:42px;" /> <strong>Club Search</strong> :{$pag_clu.total} result(s) found.
                    <div style="width:100%;" align="right">{paginate_first id="clubs"}&nbsp;&nbsp;{paginate_prev id="clubs"}&nbsp;&nbsp;{paginate_middle id="clubs" format="page" prefix="" suffix="" link_prefix="&nbsp;" link_suffix="&nbsp;" }&nbsp;&nbsp;{paginate_next id="clubs"}&nbsp;&nbsp;{paginate_last id="clubs"}</div>
                    <hr />
                    <div style="background:#F0F8FF; padding-left:5px; border: thin solid #eee; color:#336; width:100%; margin-bottom:10px;">
                        <div style="float:left:width:45%;">Showing {$pag_clu.first}-{$pag_clu.last} of {$pag_clu.total}</div>
                    </div>
                    {foreach item=club from=$clubs}
                        {if $club.is_member == true}
                            <div class="artcont">
                                <div class="entry" style="width:55%;"><a href='{$smarty.const.URL}/clubs/view/{$club.id}'>{$club.name}</a> | {$club.cdate|date_format}</div>
                                <div class="entry" style="width:55%;">
                                    <a href='{$smarty.const.URL}/clubs/view/{$club.id}'><img src="{$smarty.const.URL}/getsmimage.php?id={$club.image_id}" alt="{$club.name},{$club.category}, {$club.f_name}, {$club.l_name} ConveyLive" width="80" border="1" /></a>
                                </div>
                                <div class="entry" style="width:25%;"><a href="{$smarty.const.URL}/clubs/catbrowse/{$club.category|replace:' ':'_'}">{$club.category}</a></div>
                                <div class="entry" style="width:25%;">Total {$club.mem_count} member(s)<br />Owner <a href="{$smarty.const.URL}/profile/view/{$club.pid}">{$club.f_name} {$club.l_name}</a></div>
                            </div>
                        {elseif $club.is_member == false && $club.privacy != 2}
                            <div class="artcont">
                                <div class="entry" style="width:55%;"><a href='{$smarty.const.URL}/clubs/view/{$club.id}'>{$club.cname}</a> | {$club.ins_date|date_format}</div>
                                <div class="entry" style="width:55%;">
                                    <a href='{$smarty.const.URL}/clubs/view/{$club.id}'><img src="{$smarty.const.URL}/getsmimage.php?id={$club.club_img_id}" alt="{$club.cname},{$club.category}, {$club.f_name}, {$club.l_name} ConveyLive" width="80" border="1" /></a>
                                </div>
                                <div class="entry" style="width:25%;"><a href="{$smarty.const.URL}/clubs/catbrowse/{$club.category|replace:' ':'_'}">{$club.category}</a></div>
                                <div class="entry" style="width:25%;">Total {$club.mem_count} member(s)<br />Owner <a href="{$smarty.const.URL}/profile/view/{$club.pid}">{$club.f_name} {$club.l_name}</a></div>
                            </div>
                        {/if}
                    {foreachelse}
                        <div class="artcont">
                            <div class="entry" style="width:90%;">
                                <h3>No Match Found</h3>
                            </div>
                        </div>
                    {/foreach}
                </div>                
                <span>{paginate_first id="clubs"}&nbsp;&nbsp;{paginate_prev id="clubs"}&nbsp;&nbsp;{paginate_middle id="clubs" format="page" prefix="" suffix="" link_prefix="&nbsp;" link_suffix="&nbsp;" }&nbsp;&nbsp;{paginate_next id="clubs"}&nbsp;&nbsp;{paginate_last id="clubs"}</span>
            {else}
                <div class="artcont">
                    <div class="entry" style="width:90%;">
                        <h3>No Match Found</h3>
                    </div>
                </div>
            {/if}            
        </div>
    </div>
</div>
{literal}
<script type="text/javascript">
$(document).ready(function(){
    $('a.del').click(function(){
       var link = $(this).attr('href');
        jConfirm('Are you sure you want to delete this ?', 'Confirmation Dialog', function(r) {
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