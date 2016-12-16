<div style="float:left; width:745px;">
    <div><a href="{$smarty.const.URL}/b/{$blog.url}">Back to Blogs page</a>&nbsp;|&nbsp;{if $islogin == true && $blogexist == true}<a href="{$smarty.const.URL}/blog/new">New Post</a>&nbsp;|&nbsp;{/if}<a href="{$smarty.const.URL}/blog/browseall">View Others' Blogs</a>&nbsp;</div>
    <br />
    <div id="box">
        <div style="width:42px; height:42px; float:left;">
            <a href="{$smarty.const.URL}/profile/view/{$blog.pid}"><img src="{$smarty.const.URL}/getsmimage.php?id={$blog.user_imgs_id}" alt="{$blog.f_name}, {$blog.l_name}" height="40" width="40"  /></a>
        </div>
        <div class="smallbox">
            {if $blog.pid == ""}
                {$blog.f_name} {$blog.l_name}
            {else}
                <a href="{$smarty.const.URL}/profile/view/{$blog.pid}">{$blog.f_name} {$blog.l_name}</a>
            {/if}
            <br />
            {$post.ins_date|date_format}
        </div>
        <div class="infobox">
            {$post.com_count|default:'0'} Comments | {$post.view_count} Views |
            {$post.tothits} Hits <br />
            {if $post.user_email neq $email && $islogin == true}
                Rate up &nbsp;<a href="{$smarty.const.URL}/b/{$blog.url}/rateup/{$post.post_id}" ><img src="{$smarty.const.URL}/interface/icos/thumbs_up.gif" width="15px" alt="{$post.name},rating-up, {$post.title}" border="0"/></a> &nbsp;
                Rate down &nbsp;<a href="{$smarty.const.URL}/b/{$blog.url}/ratedown/{$post.post_id}" ><img src="{$smarty.const.URL}/interface/icos/thumbs_down.gif" width="15px" alt="{$post.name}, rating-down, {$post.title}" border="0" /></a>
            {/if}
        </div>
        <div class="ratingbox">                    
            Rating: {$post.rating}
            {section name=foo start=1 loop=6 max=6 step=1}
                {if $smarty.section.foo.index <= $post.rating}
                    <img src="{$smarty.const.URL}/interface/icos/star.png" alt="{$blog.f_name}, {$blog.l_name}, {$post.title}" width="12px"/>
                {elseif $smarty.section.foo.index > $article.rating}
                    <img src="{$smarty.const.URL}/interface/icos/star_dull.png" alt="{$post.name} , {$post.title}" width="12px"/>
                {/if}
            {/section}
        </div>
    </div>
    
    <div style="width:98%;padding:5px;">
        {if $prev != null}
            <div style="float:left;">
                <a href="{$smarty.const.URL}/b/{$blog.url}/{$prev.post_id}" title="{$prev.title}">
                    <div style="float: left;"><img src="{$smarty.const.URL}/interface/images/left_arrow.png" /></div>
                    <div style="float: left; padding: 10px;">Previous</div>
                </a>                
            </div>
        {/if}
        {if $next != null}
            <div style="float:right;">
                <div style="float:right;">
                    <a href="{$smarty.const.URL}/b/{$blog.url}/{$next.post_id}" title="{$next.title}">
                        <div style="float: left; padding: 10px;">Next</div>
                        <div style="float: left;"><img src="{$smarty.const.URL}/interface/images/right_arrow.png" /></div>
                    </a>
                </div>                
            </div>
        {/if}
    </div>

    <div>
        <br/>
        <h2 style="color:#069; ">{$post.title}</h2>
        <strong><i>{$post.sub_title}</i></strong>
        <br />
        <div style="padding-top:10px;">
        {if $post.user_email eq $email && $islogin == true}
            <span><img src="{$smarty.const.URL}/interface/icos/page_edit.png" style="width:15px;"/><a href="{$smarty.const.URL}/blog/editpost/{$post_id}" >Edit this post</a>&nbsp;|&nbsp;<img src="{$smarty.const.URL}/interface/icos/delete_post.png" style="width:15px;"/><a href="{$smarty.const.URL}/blog/deletepost/{$post_id}" class="postdelete">Delete this post</a></span>&nbsp;|
        {/if}
            {if $post.com_count > 0}<span><img src="{$smarty.const.URL}/interface/icos/comments.png" style="width:15px;"/><a href="#comlist" >View Comments</a></span>&nbsp;|&nbsp;{/if}<span><img src="{$smarty.const.URL}/interface/icos/comment_add.png" style="width:15px;"/><a href="#comment" >Add Your Comment</a></span>
        </div>
    </div>
    <hr color="#CCCCCC" noshade="noshade" />
    <br />
    <div style="width:570px;float:left;padding:10px;">
        {$post.body}
    </div>
    <div style="padding:2px; ">
        {if $postList != null}
            <h3 class="sideheaderbox"><img src="{$smarty.const.URL}/interface/icos/tag_blue.png" style="width:25px;margin-left:5px;margin-right:5px;" />Posts by {$blog.f_name} {$blog.l_name} </h3>
            <div class="sideinfobox" >
                {foreach item=pst from=$postList}
                    <div style="list-style:none;"><a href="{$smarty.const.URL}/b/{$blog.url}/{$pst.post_id}" class="sidelinklist"><img src="{$smarty.const.URL}/interface/icos/arrow_gray.gif" style="width:7px;"/>&nbsp;{$pst.title|truncate:20}</a></div>
                {/foreach}
            </div>
        {/if}
        {if $latArt != null}
            <h3 class="sideheaderbox"><img src="{$smarty.const.URL}/interface/icos/tag_green.png" style="width:25px;margin-left:5px;margin-right:5px;" />Latest Blogs</h3>
            <div class="sideinfobox">
                {foreach item=art from=$latArt}
                    <div style="list-style:none;"><a href='{$smarty.const.URL}/b/{$art.url}' class="sidelinklist"><img src="{$smarty.const.URL}/interface/icos/arrow_gray.gif" style="width:7px;"/>&nbsp;{$art.cname|truncate:20}</a></div>
                {/foreach}
                <p><a href="{$smarty.const.URL}/blog/browseall">See all</a></p>
            </div>
        {else}    
            <br />
        {/if}
    </div>
 
    <div style="width:98%;">
        <br />
        {if $post.remarks != ""}
            <div>
                <img src="{$smarty.const.URL}/interface/icos/posttopic.png" style="width:30px;" /><strong>Author's note</strong>: {$post.remarks}
            </div>
        {/if}
        <br />
        {if $post.meta_tags != ""}
            <div>
                <img src="{$smarty.const.URL}/interface/icos/key.png" style="width:30px;" /><strong>Keywords</strong>: {$post.meta_tags}
            </div>
        {/if}
    </div>
    <br />
    <hr color="#CCCCCC" noshade="noshade" />
    {if $coms != null}
        <br />
            <h3><img src="{$smarty.const.URL}/interface/icos/comments.png" style="width:30px;" />Comments on this post</h3>
        <br />
    {/if}
    <div id="comlist">
        {if $coms != null}
            {include file="comment_view.tpl"}
        {/if}
    </div>
    <br />
    <br />
    {if $islogin == true}
        <div id="addcomment">
            {assign var='mid' value=$post_id}
            {assign var='mtype' value='Blog Post'}
            
            {include file='frm_comment.tpl'}            
        </div>
    {else}
        <div style="width:550px;" id="addcomment">
            <h3>Please <a href="{$smarty.const.URL}/signup">Signup</a> to comment on this blog post</h3>
        </div>
    {/if}
    <br /> 
    {if $post != null && $islogin == true}
        {include file="invitecontent_form.tpl"}
    {/if}
</div>
{literal}
<script type="text/javascript">
$(document).ready(function(){
    $('a.blogdelete').click(function(){
       var link = $(this).attr('href');
        jConfirm('Are you sure you want to delete this blog? All your blog posts will also be deleted if you delete your blog.', 'Confirmation Dialog', function(r) {
            if(r == true){
                window.location.href = link;
            }
            else{
                return false;
            }
        });
        return false;
    });
    
        
    $('a.postdelete').click(function(){
       var link = $(this).attr('href');
        jConfirm('Are you sure you want to delete this post? All your posts comments will also be deleted if you delete this post.', 'Confirmation Dialog', function(r) {
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
