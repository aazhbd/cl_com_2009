<div style="float:left;width:730px;">
    <div id="errors"></div>
    <div>
        <img src="{$smarty.const.URL}/getimage.php?id={$club_img_id}" width="80" alt="{$club_name}, conveylive.com, club" />
        <a href="{$smarty.const.URL}/clubs/newtopic/{$club_id}">Post New Topic</a>&nbsp;|&nbsp;<a href="{$smarty.const.URL}/clubs/topics/{$club_id}">Club Topics</a>&nbsp;|&nbsp;<a href="{$smarty.const.URL}/clubs/view/{$club_id}">Back to Club</a>

    </div>
    <div class="clubpart3" id="profbox" style="width:95%;"><h3>{$topic.title}</h3></div><br />
    
    {if $post != null}
    <div class="artcont">
        <div class="entry" style="width:100%;">
            <div class="entry" style="width:15%;"><img src="{$smarty.const.URL}/getsmimage.php?id={$post.user_imgs_id}" width="60" alt="{$post.f_name},{$post.l_name}" /></div>
            <div class="entry" style="width:80%;"><a href="{$smarty.const.URL}/profile/view/{$post.pid}">{$post.f_name} {$post.l_name}</a> wrote on <strong>{$post.ins_date|date_format:"%A, %B %e, %Y"} at {$post.ins_date|date_format:"%I:%M %p"}</strong> </div>
        </div>
        <div class="entry" style="width:15%;"> 
            {if ( $post.user_email == $email or $is_admin == true ) && $islogin == true}
                <a href="{$smarty.const.URL}/clubs/deletepost/{$club_id}/{$post.id}" class="postdel">Delete Post</a>
            {else}
                <a href="{$smarty.const.URL}/clubs/reportpost/{$club_id}/{$post.id}">Report this post</a>
            {/if}
        </div>
        <div class="entry" style="width:60%;">{$post.body}</div>
        <div class="entry" style="width:100%;">
            {if $post.meta_tags != null}<p><img src="{$smarty.const.URL}/interface/icos/key.png" /><strong>Keywords: </strong> {$post.meta_tags}</p>{/if}
        </div>
    </div>
    <div id="comlist" style="float:left;width:730px;">
        {if $coms != null}
            {foreach item=com from=$coms}
            <div class="artcont">
                <div class="entry" style="width:15%;"><img src="{$smarty.const.URL}/getsmimage.php?id={$com.user_imgs_id}" width="60" alt="{$com.f_name},{$com.l_name}" /></div>
                <div class="entry" style="width:80%;"><a href="{$smarty.const.URL}/profile/view/{$com.pid}">{$com.f_name} {$com.l_name}</a> wrote on {$com.cdate|date_format:"%A, %B %e, %Y"} at {$com.cdate|date_format:"%I:%M %p"} </div>
                <div class="entry" style="width:60%;">{$com.comment}</div>
                <div class="entry" style="width:100%;"> 
                    <br/>
                    {if ( $com.user_email == $email or $is_admin == true or $cpost.user_email == $email ) && $islogin == true}
                        <a href="{$smarty.const.URL}/clubs/deletecom/{$cpost.id}/{$com.id}" class="postdel">Delete Post</a>
                    {else}
                        <a href="{$smarty.const.URL}/clubs/reportcom/{$cpost.id}/{$com.id}">Report this post</a>
                    {/if}
                </div>
            </div>
            {/foreach}
        {/if}
    </div>
    <br />
    {if $islogin == true}
    
    <div style="float:left;width:730px;">
    <br />
        <form method="post" id="frmpost" >
            <fieldset>
                <legend style="width:200px;">Post a reply</legend>
                <input type="hidden" name="media_type" id="media_type" value="{$media_type}"/>
                <input type="hidden" name="media_type" id="media_id" value="{$media_id}"/>
                <input type="hidden" name="email" id="email" value="{$email}"/>
                <input type="hidden" name="club_id" id="club_id" value="{$club_id}"/>
                <div>
                    <span>
                        <textarea id="bodytxt" name="bodytxt"  style="width:700px;height:150px;" rows="5"></textarea>
                    </span>
                </div>
                <div>
                    <input type="submit" name="submit" value="Reply" class="frmbtn" id ="cmtpost"/>
                    <a href="{$smarty.const.URL}/clubs/view/{$club_id}">Cancel</a>
                </div>
            </fieldset>
        </form>
    </div>
    {/if}
</div>
{/if}
{literal}
<script type="text/javascript">
   $(document).ready(function(){
       $("#errors").hide();
       $('#cmtpost').click(function(){
            var cmt = $('#bodytxt').val();
            var mid = $('#media_id').val();
            var mt = $('#media_type').val();
            var ue = $('#email').val();
            var cid = $('#club_id').val();
            var ins = 'insert';
            if(cmt.length == 0)
            {
                alert("You can not publish blank post reply. Please type your reply.");
                return false;
            }
            if(cmt.length > 2499)
            {
                alert("You can not put more than 2499 characters for post. Please shorten your content.");
                return false;
            }
            
            var dataString = 'cmt='+cmt+'&mid='+mid+'&mt='+mt+'&ue='+ue+'&cid='+cid+'&ins='+ins;
            
            var aurl = site.url + "/cpostprocess.php";
            
            $.ajax({
                type: "POST",
                url: aurl,
                data: dataString,
                cache: false,
                dataType: "html",
                success: function(response){
                    $("#comlist").fadeIn(400).html(response);
                    $('#comment').val("");
                }
            });
        });
        return false;
   });
</script>
{/literal}