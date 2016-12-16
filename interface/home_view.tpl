
<div style="float:left; width:740px;">
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
    {if $prof.user_email == $email}
        {if $prof.pstatus != ""}
            <div id="profstat" style="padding: 10px; margin: 5px; width: 96%;" >
                {$prof.f_name} says, {$prof.pstatus} <a href="{$smarty.const.URL}/profile/remstat/{$email}" class="subinfo">remove</a>
            </div>
        {/if}
        
        <div style="text-align:left;">
        <form id="statusfrm" action="" method="post" >
            <fieldset>
                <label>{$prof.f_name} says, </label>
                <input id="stat" name="stat" type="text" style="width:530px;" />
                <input id="pid" name="pid" type="hidden" value="{$prof.id}" />
                <input id="statusup" name="statusup" class="frmbtn" type="submit" value="Update" />
            </fieldset>
        </form>
        </div>
        <br />
    {/if}

<div style="float:left;width:740px;">
    <div style="float:left;width:455px;">
        <a href="{$smarty.const.URL}/article/browse">
        <div style="float:left; width:215px;  height:110px;" class="item">
            <img src="{$smarty.const.URL}/interface/icos/article.png" alt="Browse Articles, Literature, Document, Writeup, Text" height="60px"/>
            <br />
            <h3>Pages</h3>
            Explore all kind of writeups, literature, documents, articles and journals
        </div>
        </a>
        <a href="{$smarty.const.URL}/picture/browse">
        <div style="float:left; width:215px;  height:110px;" class="item">
            <img src="{$smarty.const.URL}/interface/icos/images.png" alt="Browse Albums, Image, Picture, Photo, Album" height="60px"/>
            <br />
            <h3>Albums</h3>
            See the latest albums and photos published by the other users at conveylive
        </div>
        </a>
        <a href="{$smarty.const.URL}/audio/browse">
        <div style="float:left; width:215px;  height:110px;" class="item">
            <img src="{$smarty.const.URL}/interface/icos/audio.png" alt="Browse Audio, Recording, Music, Audio, Sound, Voice" height="60px"/>
            <br />
            <h3>Audio</h3>
            Explore and listen to all kinds of recording, personal songs, music; Share your sound with the world.
        </div>
        </a>
        <a href="{$smarty.const.URL}/video/browse">
        <div style="float:left; width:215px;  height:110px;" class="item">
            <img src="{$smarty.const.URL}/interface/icos/video.png" alt="Browse Video, Video, Broadcast, Movie, Clip, Share" height="60px"/>
            <br />
            <h3>Video</h3>
            Explore and watch new personal video, clips and share with the community of conveylive
        </div>
        </a>
        <a href="{$smarty.const.URL}/blog/browseall">
        <div style="float:left; width:215px;  height:110px;" class="item">
            <img src="{$smarty.const.URL}/interface/icos/blog.png" alt="Browse Blogs, Writeup, Discuss, Share" height="60px"/>
            <br />
            <h3>Blog</h3>
            Browse community blogs, the online journals where people post their short writeups, experience or daily incidents.
        </div>
        </a>
        <a href="{$smarty.const.URL}/clubs/browse">
        <div style="float:left; width:215px;  height:110px;" class="item">
            <img src="{$smarty.const.URL}/interface/icos/club.png" alt="Browse Clubs, Club, Community, Discuss, Share, Topic, Post, Network, Group, People, Interest" height="60px"/>
            <br />
            <h3>Clubs</h3>
            Browse and join conveylive clubs to communicate, discuss and share files and images.
        </div>
        </a>
    </div>
    <div class="innerbox" style="float:right;width:270px;">
        {include file="invite.tpl"}
        <div style="width:270px;">
            {if $req_count gt 0}
                <div class="msgbox" >
                    <h3><img src="{$smarty.const.URL}/interface/icos/users.png" alt="Friends, Requests" height="30px"/>Friend Requests</h3>
                    <a href='{$smarty.const.URL}/friend/requestlist'>You have {$req_count} friend request(s)</a>
                </div>
            {/if}
        </div>
        <div style="width:270px;">
            {if $joinreq_count gt 0}
                <div class="msgbox" >
                    <h3><img src="{$smarty.const.URL}/interface/icos/club.png" alt="Friends, Requests" height="30px"/>Club Join Requests</h3>
                    <a href='{$smarty.const.URL}/clubs/joinrequestlist'>You have {$joinreq_count} request(s) to join club(s)</a>
                </div>
            {/if}
        </div>
        <div style="width:270px;">
            {if $mail_count gt 0}
                <div class="msgbox" >
                    <h3><img src="{$smarty.const.URL}/interface/icos/mail.png" alt="Mail, Networking, Communication" height="30px"/>Unread Messages</h3>
                    <a href='{$smarty.const.URL}/message/inbox'>You have {$mail_count} unread messages</a>
                </div>
            {/if}
        </div>
    </div>
</div>
<div style='float:left;width:740px'>

    <div class="bhead" style='width:713px'>
        News Feed
    </div>    
    <div id="tabs" style='width:730px'>
        <ul>
            <li><a href="#tabs-1">Status</a></li>
            <li><a href="#tabs-2">Pages</a></li>
            <li><a href="#tabs-3">Photos</a></li>
            <li><a href="#tabs-4">Audio</a></li>
            <li><a href="#tabs-5">Videos</a></li>
            <li><a href="#tabs-6">Blogs</a></li>
            <li><a href="#tabs-7">Clubs</a></li>
        </ul>
        <div id="tabs-1">
            {if $statuses != null}
                <h3>Status Update {$pag_stat.first}-{$pag_stat.last} of {$pag_stat.total}</h3><br/>
                {foreach item=cont from=$statuses}
                    {if $cont.pstatus != ""}
                    <div class="artcont">
                        <div class="entry" style="width:10%;">
                            <img src="{$smarty.const.URL}/getsmimage.php?id={$cont.user_imgs_id}" alt="{$cont.f_name}, {$cont.l_name}" height="40px"/>
                        </div>
                        <div class="entry" style="width:80%;">
                            On {$cont.date|date_format}  <a href="{$smarty.const.URL}/profile/view/{$cont.pid}">{$cont.f_name} {$cont.l_name} </a> changed status to  <br/><h3><i>{$cont.pstatus}</i></h3>
                        </div>
                    </div>
                    {/if}
                {foreachelse}
                    <div class="artcont">
                        <div class="entry" style="width:90%;">
                            <h3>You have no recent status updates</h3>
                        </div>
                    </div>
                {/foreach}
                <span>{paginate_first id="status"}&nbsp;&nbsp;{paginate_prev id="status"}&nbsp;&nbsp;{paginate_middle id="status" format="page" prefix="" suffix="" link_prefix="&nbsp;" link_suffix="&nbsp;" }&nbsp;&nbsp;{paginate_next id="status"}&nbsp;&nbsp;{paginate_last id="status"}</span>
            {else}
                <div class="artcont">
                    <div class="entry" style="width:90%;">
                        <h3>You have no recent status updates</h3>
                    </div>
                </div>
            {/if}
        </div>
        <div id="tabs-2">
            {if $articles != null}
                <hr />
                <h3>Pages {$pag_art.first}-{$pag_art.last} of {$pag_art.total}</h3><br/>
                {foreach item=cont from=$articles}
                    <div class="artcont">
                        <div class="entry" style="width:10%;">
                            <img src="{$smarty.const.URL}/getsmimage.php?id={$cont.user_imgs_id}" alt="{$cont.f_name}, {$cont.l_name}" height="40px"/>
                        </div>
                        <div class="entry" style="width:80%;">
                            {if $cont.art_url == ""}
                                    On {$cont.date|date_format}  <a href="{$smarty.const.URL}/profile/view/{$cont.pid}">{$cont.f_name} {$cont.l_name} </a> published the page named <a href="{$smarty.const.URL}/article/view/{$cont.art_id}">{$cont.art_title} </a>
                            {else}
                                    On {$cont.date|date_format}  <a href="{$smarty.const.URL}/profile/view/{$cont.pid}">{$cont.f_name} {$cont.l_name} </a> published the page named <a href="{$smarty.const.URL}/a/{$cont.art_url}">{$cont.art_title} </a>
                            {/if}
                        </div>
                    </div>
                {foreachelse}
                    <div class="artcont">
                        <div class="entry" style="width:90%;">
                            <h3>You have no recent news on pages</h3>
                        </div>
                    </div>
                {/foreach}
                <span>{paginate_first id="articles"}&nbsp;&nbsp;{paginate_prev id="articles"}&nbsp;&nbsp;{paginate_middle id="articles" format="page" prefix="" suffix="" link_prefix="&nbsp;" link_suffix="&nbsp;" }&nbsp;&nbsp;{paginate_next id="articles"}&nbsp;&nbsp;{paginate_last id="articles"}</span>
            {else}
                <div class="artcont">
                    <div class="entry" style="width:90%;">
                        <h3>You have no recent news on Pages</h3>
                    </div>
                </div>
            {/if}
        </div>
        <div id="tabs-3">
            {if $albums != null}
                <hr />
                <h3>Albums {$pag_alb.first}-{$pag_alb.last} of {$pag_alb.total}</h3><br/>
                {foreach item=cont from=$albums}
                    <div class="artcont">
                        <div class="entry" style="width:10%;">
                            <img src="{$smarty.const.URL}/getsmimage.php?id={$cont.user_imgs_id}" alt="{$cont.f_name}, {$cont.l_name}" height="40px"/>
                        </div>                        
                        <div class="entry" style="width:80%;">
                            On {$cont.date|date_format} <a href="{$smarty.const.URL}/profile/view/{$cont.pid}">{$cont.f_name} {$cont.l_name} </a> published the album <a href="{$smarty.const.URL}/picture/albumview/{$cont.alb_id}">{$cont.alb_title} </a> 
                        </div>
                    </div>
                {foreachelse}
                    <div class="artcont">
                        <div class="entry" style="width:90%;">
                            <h3>You have no recent updates on albums</h3>
                        </div>
                    </div>
                {/foreach}
                <span>{paginate_first id="albums"}&nbsp;&nbsp;{paginate_prev id="albums"}&nbsp;&nbsp;{paginate_middle id="albums" format="page" prefix="" suffix="" link_prefix="&nbsp;" link_suffix="&nbsp;" }&nbsp;&nbsp;{paginate_next id="albums"}&nbsp;&nbsp;{paginate_last id="albums"}</span>
            {else}
                <div class="artcont">
                    <div class="entry" style="width:90%;">
                        <h3>You have no recent updates on albums</h3>
                    </div>
                </div>
            {/if}
        </div>
        <div id="tabs-4">
            {if $audios != null}
                <hr />
                <h3>Audio {$pag_aud.first}-{$pag_aud.last} of {$pag_aud.total}</h3><br/>
                {foreach item=cont from=$audios}                    
                    <div class="artcont">
                        <div class="entry" style="width:10%;">
                            <img src="{$smarty.const.URL}/getsmimage.php?id={$cont.user_imgs_id}" alt="{$cont.f_name}, {$cont.l_name}" height="40px"/>
                        </div>
                        <div class="entry" style="width:80%;">
                            On {$cont.date|date_format} <a href="{$smarty.const.URL}/profile/view/{$cont.pid}">{$cont.f_name} {$cont.l_name} </a> published the audio <a href="{$smarty.const.URL}/audio/listen/{$cont.aud_id}">{$cont.aud_title} </a> 
                        </div>
                    </div>
                {foreachelse}
                    <div class="artcont">
                        <div class="entry" style="width:90%;">
                            <h3>You have no recent news on audio</h3>
                        </div>
                    </div>
                {/foreach}
                <span>{paginate_first id="audios"}&nbsp;&nbsp;{paginate_prev id="audios"}&nbsp;&nbsp;{paginate_middle id="audios" format="page" prefix="" suffix="" link_prefix="&nbsp;" link_suffix="&nbsp;" }&nbsp;&nbsp;{paginate_next id="audios"}&nbsp;&nbsp;{paginate_last id="audios"}</span>
            {else}
                <div class="artcont">
                    <div class="entry" style="width:90%;">
                        <h3>You have no recent updates on audio</h3>
                    </div>
                </div>
            {/if}
        </div>
        <div id="tabs-5">
            {if $videos != null}
                <hr />
                <h3>Video {$pag_vid.first}-{$pag_vid.last} of {$pag_vid.total}</h3><br/>
                {foreach item=cont from=$videos}
                    <div class="artcont">
                        <div class="entry" style="width:10%;">
                            <img src="{$smarty.const.URL}/getsmimage.php?id={$cont.user_imgs_id}" alt="{$cont.f_name}, {$cont.l_name}" height="40px"/>
                        </div>
                        <div class="entry" style="width:80%;">
                            On {$cont.date|date_format} <a href="{$smarty.const.URL}/profile/view/{$cont.pid}">{$cont.f_name} {$cont.l_name} </a> published the audio <a href="{$smarty.const.URL}/video/watch/{$cont.vid_id}">{$cont.vid_title} </a> 
                        </div>
                    </div>
                {foreachelse}
                    <div class="artcont">
                        <div class="entry" style="width:90%;">
                            <h3>You have no recent news on video</h3>
                        </div>
                    </div>
                {/foreach}
                <span>{paginate_first id="videos"}&nbsp;&nbsp;{paginate_prev id="videos"}&nbsp;&nbsp;{paginate_middle id="videos" format="page" prefix="" suffix="" link_prefix="&nbsp;" link_suffix="&nbsp;" }&nbsp;&nbsp;{paginate_next id="videos"}&nbsp;&nbsp;{paginate_last id="videos"}</span>
            {else}
                <div class="artcont">
                    <div class="entry" style="width:90%;">
                        <h3>You have no recent updates on video</h3>
                    </div>
                </div>
            {/if}
        </div>
        <div id="tabs-6">
            {if $blogposts != null}
                <h3>Blog Post {$pag_post.first}-{$pag_post.last} of {$pag_post.total}</h3><br/>
                {foreach item=cont from=$blogposts}
                    <div class="artcont">
                        <div class="entry" style="width:10%;">
                            <img src="{$smarty.const.URL}/getsmimage.php?id={$cont.user_imgs_id}" alt="{$cont.f_name}, {$cont.l_name}" height="40px"/>
                        </div>
                        <div class="entry" style="width:80%;">
                            On {$cont.date|date_format} <a href="{$smarty.const.URL}/profile/view/{$cont.pid}">{$cont.f_name} {$cont.l_name} </a> published the blog post <a href="{$smarty.const.URL}/b/{$cont.blog_url}/{$cont.post_id}">{$cont.post_title} </a> 
                        </div>
                    </div>
                {foreachelse}
                    <div class="artcont">
                        <div class="entry" style="width:90%;">
                            <h3>You have no recent news on blog posts</h3>
                        </div>
                    </div>
                {/foreach}
                <span>{paginate_first id="blogposts"}&nbsp;&nbsp;{paginate_prev id="blogposts"}&nbsp;&nbsp;{paginate_middle id="blogposts" format="page" prefix="" suffix="" link_prefix="&nbsp;" link_suffix="&nbsp;" }&nbsp;&nbsp;{paginate_next id="blogposts"}&nbsp;&nbsp;{paginate_last id="blogposts"}</span>
            {else}
                <div class="artcont">
                    <div class="entry" style="width:90%;">
                        <h3>You have no recent updates on blog posts</h3>
                    </div>
                </div>
            {/if}
        </div>
        <div id="tabs-7">
            {if $clubs != null}
                <h3>Clubs {$pag_clu.first}-{$pag_clu.last} of {$pag_clu.total}</h3><br/>
                {foreach item=cont from=$clubs}
                    <div class="artcont">
                        <div class="entry" style="width:10%;">
                            <img src="{$smarty.const.URL}/getsmimage.php?id={$cont.user_imgs_id}" alt="{$cont.f_name}, {$cont.l_name}" width="40px"/>
                        </div>
                        <div class="entry" style="width:80%;">
                            On {$cont.date|date_format} <a href="{$smarty.const.URL}/profile/view/{$cont.pid}">{$cont.f_name} {$cont.l_name} </a> published the club <a href="{$smarty.const.URL}/clubs/view/{$cont.club_id}">{$cont.club_name} </a>
                        </div>
                    </div>
                {foreachelse}
                    <div class="artcont">
                        <div class="entry" style="width:55%;">
                            <h3>You have no recent news on blog post</h3>
                        </div>
                    </div>
                {/foreach}
                <span>{paginate_first id="clubs"}&nbsp;&nbsp;{paginate_prev id="clubs"}&nbsp;&nbsp;{paginate_middle id="clubs" format="page" prefix="" suffix="" link_prefix="&nbsp;" link_suffix="&nbsp;" }&nbsp;&nbsp;{paginate_next id="clubs"}&nbsp;&nbsp;{paginate_last id="clubs"}</span>
            {else}
                <div class="artcont">
                    <div class="entry" style="width:90%;">
                        <h3>You have no recent updates on clubs</h3>
                    </div>
                </div>
            {/if}            
        </div>
    </div>
</div>

</div>
{literal}
<script type="text/javascript">
    $(document).ready(function(){
        var ok = "no";
        $('#statusup').click(function(){
            var stat = $('#stat').val();
            var pid = $('#pid').val();
            var dataString = 'stat='+ stat + '&pid='+pid;
            var aurl = site.url + "/statupdt.php";
            if(stat.length == 0)
            {
                alert("Please type a status.");
                return false;
            }
            if(stat.length > 250)
            {
                alert("Status can not have more than 250 characters");
                return false;
            }
            $.ajax({
                type: "POST",
                url: aurl,
                data: dataString,
                cache: false,
                dataType: "html",
                async: false,
                success: function(response){
                    if(response == "not updated")
                    {
                        alert("Could not update status");
                        $("#reps").fadeIn(400).html('Could not update status');
                        ok = "no";
                        return false;
                    }
                    else if(response == "updated"){
                        ok = "ok";
                        $("#reps").show();
                        $("#reps").fadeIn(400).html('Status updated');
                        $("#st").fadeIn(400).html(stat);
                        return false;
                    }
                }
            });
            
            if(ok == "no") return false;
        });
        
        $("#statusfrm").validate({
            errorLabelContainer: "#reps",
            wrapper: "p",
               rules:{
                   stat:{ required: true , maxlength: 250 }
               },
               messages:{
                   stat: 
                   {
                       required: "Please type your status.",
                       maxlength: "Status can not have more than 250 characters"
                   }
               }
        });
    });
</script>
{/literal}