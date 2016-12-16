<div style="float:left; width:750px;">
    {if $prof == null }
        <div id="pginfo">
            This user does not have a public profile.
        </div>
    {else}

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
                <div style="padding:5px; padding: 10px; margin: 5px; width: 96%;" id="profstat">
                    {$prof.f_name} says, {$prof.pstatus}
                    <a href="{$smarty.const.URL}/profile/remstat/{$email}" class="subinfo">remove</a>
                </div>
            {/if}
            <div style="text-align:right;">
            <form id="statusfrm" action="" method="post" >
                <fieldset>
                    <label style="padding:10px;">{$prof.f_name} says,</label>
                    <input id="stat" name="stat" type="text" style="width:530px;" />
                    <input id="pid" name="pid" type="hidden" value="{$prof.id}" />
                    <input id="statusup" name="statusup" class="frmbtn" type="submit" value="Update" />
                </fieldset>
            </form>
            </div>
        {else}
            {if $prof.pstatus != ""}
                <div style="padding:5px; padding: 10px; margin: 5px; width: 96%;" id="profstat" id="profstat">
                    {$prof.f_name} says, {$prof.pstatus}
                </div>
            {/if}
        {/if}
        <br />
        {if $prof.user_email != $user_email && $islogin == true}
            <div style="width:95%;padding:5px; float:left;">
                {if $isfriend  == false && $hasProfile == true}
                    <a href="{$smarty.const.URL}/friend/request/{$prof.id}"><img src="{$smarty.const.URL}/interface/icos/personal.png" />Add as friend</a>
                {/if}
                {if $hasProfile == false}
                    <a href="{$smarty.const.URL}/profile/create/{$email}"><img src="{$smarty.const.URL}/interface/icos/create.png" />Create a profile to add me as friend</a>&nbsp;
                {/if}
                <a href="{$smarty.const.URL}/friend/sendmessage/{$prof.id}" ><img src="{$smarty.const.URL}/interface/icos/mail_send.png" />Send a message</a>&nbsp;
                <a href="{$smarty.const.URL}/friend/viewfriends/{$prof.id}"><img src="{$smarty.const.URL}/interface/icos/users.png" />View Friends</a>
            </div>
        {elseif $islogin == false}
            <div style="width:95%;padding:5px; float:left;">
                <a href="{$smarty.const.URL}/signup/friend" ><img src="{$smarty.const.URL}/interface/icos/users.png" />Add as friend</a>&nbsp;
            </div>
        {/if}    
        <div style="width:98%;">
            <div align="center" style="width:30%; float:left;">
                <a id="profimg" style="width:90%; float:left;" href="{$smarty.const.URL}/picture/view/{$prof.user_imgs_id}">
                    <img src="{$smarty.const.URL}/getsmimage.php?id={$prof.user_imgs_id}" class="profpic" align="middle"  alt="{$prof.f_name} ,{$prof.l_name}" style="max-width: 220px; max-height:250px;"/>
                </a>
            </div>
            <div style="float:left; padding: 5px; width: 60%;" id="profbox">
                <div>
                    <a href="{$smarty.const.URL}/profile/view/{$prof.id}" style="font-weight: bold; font-size: 16px;">{$prof.f_name} {$prof.l_name}</a><br />
                    {if $prof.gender != null}
                        {if $prof.gender == 'm'}
                            Male
                        {elseif $prof.gender == 'f'}
                            Female
                        {/if}
                        <br />
                    {/if}
                    
                    {if $prof.birth_date}
                        Born on {$prof.birth_date|date_format} <br />
                    {/if}
                    {if $prof.age}
                        Age : {$prof.age} <br />
                    {/if}
                    
                    {if $prof.country != null} From: {$prof.country} {/if}<br />
                    {if $prof.lang != null}Language: {$prof.lang}<br /> {/if} 
                    {if $prof.religion != null} Religion: {$prof.religion} <br />{/if} 
                     
                    {if $prof.phone != ""}
                        Phone No.: {$prof.phone} <br />  
                    {/if}
                    
                    {if $prof.web_url != ""}
                        Web: <a href="{$prof.web_url}">{$prof.web_url|wordwrap:65:"<br />":true}</a>
                        <br />
                    {/if}
                    
                    {if $prof.last_login_date != null}
                        Last Login: {$prof.last_login_date|date_format} {$prof.last_login_date|date_format:'%I:%M %p'}<br />
                    {/if}
                    {if $prof.ins_date != null}
                        Member since {$prof.ins_date|date_format} <br />
                    {/if}
                    {if $prof.upd_date != ""}
                        Profile Last Updated: {$prof.upd_date|date_format}
                    {/if}
                </div>
            </div>
        </div>
        <br />
        <div id="tabs">
            <ul>
                <li><a href="#tabs-1">Info</a></li>
                <li><a href="#tabs-2">Photos</a></li>
                <li><a href="#tabs-3">Pages</a></li>
                <li><a href="#tabs-4">Audios</a></li>
                <li><a href="#tabs-5">Videos</a></li>
                <li><a href="#tabs-6">Blogs</a></li>
                <li><a href="#tabs-7">Clubs</a></li>
            </ul>
            <div id="tabs-1">
                <div id="profbox">
                    {if $prof.rel_status != "" || $prof.activities != "" || $prof.interests != null ||  $prof.favourites != null
                          || $prof.edu_info != null ||   $prof.work_info != null ||  $prof.occupation != null || $prof.about_me != null || $prof.lookingfor != null || $prof.activities != null}
                        <h3 style="color:#69C;">Personal Details</h3><br />
                    
                            {if $prof.about_me != null}
                                <p><b>About me</b>: {$prof.about_me}</p>
                            {/if}
                            
                            {if $prof.lookingfor != ""}
                                <p>Looking for: {$prof.lookingfor}</p>
                            {/if}
                            {if $prof.rel_status != ""}
                                <p><b>Relationship status</b>: {$prof.rel_status}</p>
                            {/if}
                            {if $prof.interests != null}
                                <p><b>Interests</b>: {$prof.interests|wordwrap:80:"\n":true}</p>
                            {/if}
                            {if $prof.favourites != null}
                                <p><b>Favorites</b>: {$prof.favourites|wordwrap:80:"\n":true}</p>
                            {/if}
                            {if $prof.activities != null}
                                <p><b>Activities</b>: {$prof.activities|wordwrap:80:"\n":true}</p>
                            {/if}
                    {/if}
                </div>
                {if $prof.edu_info != null}
                    <div id="profbox">
                        <h3 style="color:#69C;">Educational info</h3><br />
                        <p>{$prof.edu_info}</p>
                    </div>
                {/if}
                    
                {if $prof.work_info != null || $prof.occupation != null}
                    <div id="profbox">
                        <h3 style="color:#69C;">Work info</h3><br />
                        {if $prof.work_info != null}
                            <p>{$prof.work_info}</p>
                        {/if}
                        {if $prof.occupation != null}
                            <p><b>Occupation</b>: {$prof.occupation}</p>
                        {/if}
                    </div>
                {/if}
                <div id="profbox">
                    <h3 style="color:#69C;">Contact info</h3><br />
                    {if $prof.addr != null}
                        <p><b>Address</b>: {$prof.addr}</p>
                    {/if}
                    {if $prof.home_town != ""}
                        <p><b>Home Town</b>: {$prof.home_town}</p>
                    {/if}
                    {if $prof.city != ""}
                        <p><b>Current City</b>: {$prof.city}</p>
                    {/if}
                    {if $prof.zipcode != ""}
                        <p><b>Zip Code</b>: {$prof.zipcode}</p>
                    {/if}
                    {if $prof.country}
                        <p><b>Country</b>: {$prof.country}</p>
                    {/if}
                </div>
                    
                {if $friends != null}
                     <div style="padding:5px; width:680px;" id="profbox">
                        <p><b style="color:#69C;"><img src='{$smarty.const.URL}/interface/icos/users.png' style="height:20px;" alt="Friend icon" />Friends </b>- Total {$tot} friends  <a href="{$smarty.const.URL}/friend/viewfriends/{$prof.id}">See all</a></p>
                         {foreach item=frnd from=$friends}
                            <div style="float: left; margin:10px;" class="friend">
                                <a href='{$smarty.const.URL}/profile/view/{$frnd.pid}'><img src='{$smarty.const.URL}/getsmimage.php?id={$frnd.user_imgs_id}' style="height:40px;max-width:80px;" alt="{$frnd.f_name} , {$frnd.f_name},{$frnd.l_name}, conveylive"/></a>
                                <br /><a href='{$smarty.const.URL}/profile/view/{$frnd.pid}'>{$frnd.f_name} {$frnd.l_name}</a>
                            </div>
                         {/foreach}
                     </div>
                {else}
                    <div id="profbox" style="width:95%; margin:2px;">
                        {if $prof.user_email == $email}
                            <h3>No friends listed. Click <a href="{$smarty.const.URL}/invite.php">here</a> to invite friends from your email contacts</h3>
                        {else}
                            <h3>{$prof.f_name} {$prof.l_name} has no friends</h3>
                        {/if}
                    </div>
                {/if}
            </div>
        
     
        <div id="tabs-2">
            <div style="width:98%;">
                {if $email == $prof.email}
                <div class="publishlink">
                    <div style="float:left;width:40px;padding:5px;"><img src="{$smarty.const.URL}/interface/icos/images.png" width="40" /></div>
                    <div style="float:left;width:200px;padding:10px;"><a href="{$smarty.const.URL}/picture/new" style="color:#39C;">Publish Your Album</a></div>
                </div>
                {/if}
                {if $albums != null}
                <div>
                    <div class="bhead" style="width:95%;">
                        Albums {$pag_alb.first}-{$pag_alb.last} of {$pag_alb.total}
                    </div>
                    <br/>
                    <div class="catmenuLink" style="border:none;">
                        {foreach item=cont from=$albums}
                            <li class="list-new" >
                                <a href="{$smarty.const.URL}/picture/albumview/{$cont.alb_id}" >{$cont.alb_title} </a> on {$cont.date|date_format}
                            </li>
                            <br />
                        {/foreach}
                    </div>
                    <br />
                    <span class="pageLink">{paginate_first id="albums"}&nbsp;&nbsp;{paginate_prev id="albums"}&nbsp;&nbsp;{paginate_middle id="albums" format="page" prefix="" suffix="" link_prefix="&nbsp;" link_suffix="&nbsp;" }&nbsp;&nbsp;{paginate_next id="albums"}&nbsp;&nbsp;{paginate_last id="albums"}</span>
                    <br /><br />
                </div>
                {else}
                    <p>{$prof.f_name} {$prof.l_name} did not publish any album</p>
                {/if}
                <br />
                {if $albumsList != null}
                    <div style="float:left; width:740%;">
                        <center>
                            {foreach item=album from=$albumsList}
                                {if $album.privacy == 0 || ($album.privacy == 1 && $album.user_email == $prof.email)  || ($album.privacy == 2 && $album.user_email == $prof.email) || ($album.privacy == 1 && $isfriend == true)  || ($album.privacy == 2 && $isfriend == true)  }
                                    {if $album.image_id == 0}
                                    <div class="album">
                                        <div class="browsealbums">
                                            <center>
                                                <a href='{$smarty.const.URL}/picture/albumview/{$album.id}'><img src='{$smarty.const.URL}/interface/icos/albumimg.gif.' style="max-height:100px;" alt="People, Friends, Network, ConveyLive, {$album.album_name}"/></a>
                                                <h3><a href='{$smarty.const.URL}/picture/albumview/{$album.id}'>{$album.album_name}</a></h3>
                                                {$album.ins_date|date_format}<br />
                                                Total {$album.tot} photo(s)<br />
                                                <br />
                                            </center>
                                        </div>
                                    </div>
                                    {else}
                                    <div class="album">
                                        <center>
                                            <div class="browsealbums">
                                                <a href='{$smarty.const.URL}/picture/albumview/{$album.id}'><img src='{$smarty.const.URL}/getsmimage.php?id={$album.image_id}' style="max-height:100px;" alt="People, Friends, Network, ConveyLive, {$album.album_name}"/></a>
                                                <h3><a href='{$smarty.const.URL}/picture/albumview/{$album.id}'>{$album.album_name}</a></h3>
                                                {$album.ins_date|date_format}<br />
                                                Total {$album.tot} photo(s)<br />
                                                <br />
                                            </div>
                                        </center>
                                    </div>
                                    {/if}
                                {/if}
                            {/foreach}
                        </center>
                    </div>
                {/if}
             </div>    
        </div>
        <div id="tabs-3">
            <div style="width:98%;">
                {if $email == $prof.email}
                <div class="publishlink">
                    <div style="float:left;width:40px;padding:5px;"><img src="{$smarty.const.URL}/interface/icos/note.png" width="40" /></div>
                    <div style="float:left;width:200px;padding:10px;"><a href="{$smarty.const.URL}/article/new" style="color:#39C;">Publish Your Pages</a></div>
                </div>
                {/if}
                {if $articles != null}
                        <div>
                            <div class="bhead" style="width:95%;">
                                Pages {$pag_art.first}-{$pag_art.last} of {$pag_art.total}
                            </div>
                            <br/>
                            <div style="width:95%;" class="catmenuLink" style="border:none;">
                                {foreach item=cont from=$articles}
                                    <li class="list-new" >
                                        {if $cont.art_url == ""}
                                            <a href="{$smarty.const.URL}/a/{$cont.art_id}" style="color:#39C;">{$cont.art_title|truncate}</a> on {$cont.date|date_format}
                                        {else}
                                            <a href="{$smarty.const.URL}/a/{$cont.art_url}" >{$cont.art_title|truncate} </a> on {$cont.date|date_format}
                                        {/if}
                                    </li>
                                    <br />
                                {/foreach}
                            </div>
                            <br />
                            <span class="pageLink">{paginate_first id="articles"}&nbsp;&nbsp;{paginate_prev id="articles"}&nbsp;&nbsp;{paginate_middle id="articles" format="page" prefix="" suffix="" link_prefix="&nbsp;" link_suffix="&nbsp;" }&nbsp;&nbsp;{paginate_next id="articles"}&nbsp;&nbsp;{paginate_last id="articles"}</span>
                            <br /><br />
                        </div>
                    {else}
                        <p>{$prof.f_name} {$prof.l_name} did not publish any page</p>
                    {/if}
                </div>
            </div>
            <div id="tabs-4">
                <div style="width:98%;">
                    {if $email == $prof.email}
                    <div class="publishlink">
                        <div style="float:left;width:40px;padding:5px;"><img src="{$smarty.const.URL}/interface/icos/audio.png" width="40" /></div>
                        <div style="float:left;width:200px;padding:10px;"><a href="{$smarty.const.URL}/audio/new" style="color:#39C;">Publish Your Audios</a></div>
                    </div>
                    {/if}
                    {if $audios != null}
                        <div>
                            <div class="bhead" style="width:95%;">Audios {$pag_aud.first}-{$pag_aud.last} of {$pag_aud.total}</div>
                            <br/>
                            <div class="catmenuLink" style="border:none;">

                                {foreach item=cont from=$audios}
                                    <li class="list-new">
                                        <a href="{$smarty.const.URL}/audio/listen/{$cont.aud_id}" >{$cont.aud_title} </a> on {$cont.date|date_format}
                                    </li>
                                    <br />
                                {/foreach}
                            </div>
                            <br />
                            <span class="pageLink">{paginate_first id="audios"}&nbsp;&nbsp;{paginate_prev id="audios"}&nbsp;&nbsp;{paginate_middle id="audios" format="page" prefix="" suffix="" link_prefix="&nbsp;" link_suffix="&nbsp;" }&nbsp;&nbsp;{paginate_next id="audios"}&nbsp;&nbsp;{paginate_last id="audios"}</span>
                            <br /><br />
                        </div>
                    {else}
                        <p>{$prof.f_name} {$prof.l_name} did not publish any audio</p>
                  {/if}
                </div>
            </div>
            
            <div id="tabs-5">
                <div style="width:98%;">
                    {if $email == $prof.email}
                    <div class="publishlink">
                        <div style="float:left;width:40px;padding:5px;"><img src="{$smarty.const.URL}/interface/icos/video.png" width="40" /></div>
                        <div style="float:left;width:200px;padding:10px;"><a href="{$smarty.const.URL}/video/new" style="color:#39C;">Publish Your Videos</a></div>
                    </div>
                    {/if}
                    
                    {if $videos != null}
                        <div>
                            <div class="bhead" style="width:95%;">Videos {$pag_vid.first}-{$pag_vid.last} of {$pag_vid.total}</div><br/>
                            <div class="catmenuLink" style="border:none;">
                                {foreach item=cont from=$videos}        
                                    <li class="list-new">
                                        <a href="{$smarty.const.URL}/video/watch/{$cont.vid_id}" >{$cont.vid_title} </a> on {$cont.date|date_format}
                                    </li>
                                    <br />
                                {/foreach}
                            </div>
                            <br />
                            <span class="pageLink">{paginate_first id="videos"}&nbsp;&nbsp;{paginate_prev id="videos"}&nbsp;&nbsp;{paginate_middle id="videos" format="page" prefix="" suffix="" link_prefix="&nbsp;" link_suffix="&nbsp;" }&nbsp;&nbsp;{paginate_next id="videos"}&nbsp;&nbsp;{paginate_last id="videos"}</span>
                            <br /><br />
                        </div>
                    {else}
                        <p>{$prof.f_name} {$prof.l_name} did not publish any video</p>
                    {/if}
                </div>
            </div>
            
            <div id="tabs-6">
            
                <div style="width:98%;">
                    {if $email == $prof.email}
                    <div class="publishlink">
                        <div style="float:left;width:40px;padding:5px;"><img src="{$smarty.const.URL}/interface/icos/blog.png" width="40" /></div>
                        <div style="float:left;width:200px;padding:10px;"><a href="{$smarty.const.URL}/blog/new" style="color:#39C;">Publish Your Blog Posts</a></div>
                    </div>
                    {/if}
                    
                {if $blogposts != null}
                        <div>
                            <div class="bhead" style="width:95%;">Blog Posts {$pag_post.first}-{$pag_post.last} of {$pag_post.total}</div>
                            <br/>
                            <div class="catmenuLink" style="border:none;">
                                {foreach item=cont from=$blogposts}
                                    <li class="list-new">
                                        <a href="{$smarty.const.URL}/b/{$blog.url}/{$cont.post_id}" >{$cont.post_title} </a> on {$cont.date|date_format}
                                    </li>
                                    <br />
                                {/foreach}
                            </div>
                            <br />
                            <span class="pageLink">{paginate_first id="blogposts"}&nbsp;&nbsp;{paginate_prev id="blogposts"}&nbsp;&nbsp;{paginate_middle id="blogposts" format="page" prefix="" suffix="" link_prefix="&nbsp;" link_suffix="&nbsp;" }&nbsp;&nbsp;{paginate_next id="blogposts"}&nbsp;&nbsp;{paginate_last id="blogposts"}</span>
                            <br /><br />
                        </div>
                {else}
                    <p>{$prof.f_name} {$prof.l_name} did not publish any post</p>
                {/if}
            </div>
        </div>
        <div id="tabs-7">
            <div style="width:98%;">
                {if $email == $prof.email}
                    <div class="publishlink">
                        <div style="float:left;width:40px;padding:5px;"><img src="{$smarty.const.URL}/interface/icos/club.png" width="40" /></div>
                        <div style="float:left;width:200px;padding:10px;"><a href="{$smarty.const.URL}/clubs/new" style="color:#39C;">Publish Your Clubs</a></div>
                    </div>
                {/if}
                {if $clubs != null}
                    <div>
                        <div class="bhead" style="width:95%;">Clubs {$pag_clu.first}-{$pag_clu.last} of {$pag_clu.total}</div><br/>
                        <div class="catmenuLink" style="border:none;">
                            {foreach item=cont from=$clubs}
                                <li class="list-new">
                                    <a href="{$smarty.const.URL}/clubs/view/{$cont.club_id}" >{$cont.cname} </a> on {$cont.date|date_format}
                                </li>
                                <br />
                            {/foreach}
                        </div>
                        <br />
                        <span class="pageLink">{paginate_first id="clubs"}&nbsp;&nbsp;{paginate_prev id="clubs"}&nbsp;&nbsp;{paginate_middle id="clubs" format="page" prefix="" suffix="" link_prefix="&nbsp;" link_suffix="&nbsp;" }&nbsp;&nbsp;{paginate_next id="clubs"}&nbsp;&nbsp;{paginate_last id="clubs"}</span>
                        <br /><br />
                    </div>
                {else}
                    <p>{$prof.f_name} {$prof.l_name} did not create any clubs</p>
                {/if}
            </div>
        </div>
     </div>
     
     <br />
        <div style="width:98%;padding:5px; float:left;">
            {if $coms != null}
                <br />
                <h3><img src="{$smarty.const.URL}/interface/icos/comments.png" style="width:30px;" />Comments on this profile</h3>
                <br />
            {/if}
            <div id="comlist">
                {if $coms != null}
                    {include file="comment_view.tpl"}
                {/if}
            </div>
            {if $islogin == true}
                <br />
                <div>
                    {assign var='mid' value=$prof.id}
                    {assign var='mtype' value='Profile'}
                    
                    {include file='frm_comment.tpl'}                    
                </div>
            {/if}
        </div>
     {/if}
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