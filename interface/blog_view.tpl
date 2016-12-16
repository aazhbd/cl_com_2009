{literal}
<script type="text/javascript">
   $(document).ready(function(){
       $("#errors").hide();
       $("#reps").hide();
   });
</script>
{/literal}

<div style="width:745px;">
    {if $blog.user_email eq $email}
    <div id="pginfo">
        This page shows all blog posts that you have published. Look at the top Menu that says "Blog" which has some new sub-menu after blog creation. Browse others blogs and see what others have written. To publish a new Post click the "New Post"  link below.
    </div>
    {else}
    <div id="pginfo">
        This page shows all blog posts of this person. Browse through these posts and click the title to read them. You may rate and comment on these posts if you are loged in.
    </div>
    {/if}
    {*include file="subtpl/had.tpl"*}
    <div>
        {if $blog.user_email eq $email}
            <div>
                <span>
                    <a href="{$smarty.const.URL}/blog/editblog/{$blog.id}" >Edit Blog</a> |
                    <a href="{$smarty.const.URL}/blog/deleteblog/{$blog.id}" class="blogdelete">Delete Blog</a> |
                    <a href="{$smarty.const.URL}/blog/new/">New Post</a> |
                    <a href="{$smarty.const.URL}/blog/browseall">Browse Latest Blogs</a>
                </span>
            </div>
            <br />
        {/if}

        {if $postList != null}
            <br />
            <span style="float:left">Showing posts {$paginate.first}-{$paginate.last} of {$paginate.total}</span>
            <span style="float:right" class="pageLink">{paginate_first}&nbsp;&nbsp;{paginate_prev}&nbsp;&nbsp;{paginate_middle format="page" prefix="" suffix="" link_prefix="&nbsp;" link_suffix="&nbsp;" }&nbsp;&nbsp;{paginate_next}&nbsp;&nbsp;{paginate_last}</span>

            {foreach item=post from=$postList}
                <div class="artcont" >
                    <a href="{$smarty.const.URL}/b/{$blog.url}/{$post.post_id}" ><div class="entry" style="width:65%;" id="titleblock"><h3>{$post.title}</h3></div></a>
                    <a href="{$smarty.const.URL}/profile/view/{$blog.pid}"><div class="entry" style="width:30%;" id="titleblock">{$blog.f_name} {$blog.l_name}</div></a>
                    
                    <div class="entry" style="width:95%;">{$post.sub_title}</div>
                    <div class="entry" style="width:95%;text-align:justify;">{$post.body|truncate:800} <a href="{$smarty.const.URL}/b/{$blog.url}/{$post.post_id}" class="more" style="font-size:12px;"> &raquo; read more</a></div>
                    <div class="entry" style="width:95%;">View: {$post.view_count}&nbsp;|&nbsp;Rating {$post.rating}  
                    {section name=foo start=1 loop=6 max=6 step=1}
                        {if $smarty.section.foo.index <= $post.rating}
                            <img src="{$smarty.const.URL}/interface/icos/star.png" alt="{$blog.f_name} {$blog.l_name} , {$post.title}" width="12px"/>
                        {elseif $smarty.section.foo.index > $post.rating}
                            <img src="{$smarty.const.URL}/interface/icos/star_dull.png" alt="{$blog.f_name} {$blog.l_name} , {$post.title}" width="12px"/>
                        {/if}
                    {/section}
                    
                    {if $post.com_count > 0} &nbsp;|&nbsp; {$post.com_count} Comment(s) {/if} &nbsp;|&nbsp; {$post.cdate|date_format:"%A, %B %e"} at {$post.cdate|date_format:"%I:%M %p"} </div>
                    
                    {if $post.user_email eq $email}
                        <div class="entry" style="width:100%;">
                            <a href="{$smarty.const.URL}/blog/editpost/{$post.post_id}">Edit this post</a>&nbsp;|&nbsp;
                            <a href="{$smarty.const.URL}/blog/deletepost/{$post.post_id}" class="postdelete">Delete this post</a>
                        </div>
                    {/if}
                </div>
            {foreachelse}
                <div class="artcont">
                    <div class="entry" style="width:100%;"><strong>{if $blog.user_email != $email}{$blog.f_name|capitalize} {$blog.l_name|capitalize} does not have any published post {else} You do not have any published post{/if} </strong></div>
                </div>
            {/foreach}
            
            <br />
            
            <span style="float:right; " class="pageLink"><br />{paginate_first}&nbsp;&nbsp;{paginate_prev}&nbsp;&nbsp;{paginate_middle format="page" prefix="" suffix="" link_prefix="&nbsp;" link_suffix="&nbsp;" }&nbsp;&nbsp;{paginate_next}&nbsp;&nbsp;{paginate_last}</span>
        {else}
            <div class="artcont">
                <div class="entry" style="width:100%;"><strong>{if $blog.user_email != $email}{$blog.f_name|capitalize} {$blog.l_name|capitalize} does not have any published post {else} You do not have any published post{/if}</strong></div>
            </div>
        {/if}
    </div>
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