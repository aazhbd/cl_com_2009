<div style="float:left; width:745px;">
    
    <div id="pginfo">
        This page shows all the latest blogs published in conveylive. Browse through these blogs and read the posts of various authors. You can comment on these posts if you are loged in.
    </div>
    {*include file="subtpl/had.tpl"*}
    <h3>Latest Blogs</h3><br />
	    <div>
            {if $blogs != null}
            
            <span style="float:left;">Showing page {$paginate.page_current} of {$paginate.page_total}<br /></span>
            <span style="float:right;" class="pageLink">
                    {paginate_first}&nbsp;&nbsp;{paginate_prev}&nbsp;&nbsp;{paginate_middle format="page" prefix="" suffix="" link_prefix="&nbsp;" link_suffix="&nbsp;" }&nbsp;&nbsp;{paginate_next}&nbsp;&nbsp;{paginate_last}
            </span>
            
            <div style="float:left; width:745px;">
                {foreach item=blog from=$blogs}
                    <div class="artcont">
                        <a href='{$smarty.const.URL}/b/{$blog.url}' id="titleblock" class="entry" style="width:65%; font-weight:bold; font-size: 16px;">{$blog.cname}</a>
                        <div class="entry" style="width:30%;" id="titleblock">by <a href="{$smarty.const.URL}/profile/view/{$blog.pid}">{$blog.f_name} {$blog.l_name}</a> | {$blog.ins_date|date_format}</div>
                        <div class="entry" style="width:65%;"><a href='{$smarty.const.URL}/b/{$blog.url}'>{$smarty.const.URL}/b/{$blog.url}</a></div>
                        {if $blog.posts != null}
                        <div class="entry" style="width:65%;">
                        <div class="catmenuLink">Latest posts</div>
                        {foreach item=post from=$blog.posts}
                            <div class="catmenuLink" ><img src="{$smarty.const.URL}/interface/icos/arrow_gray.gif"><a href='{$smarty.const.URL}/b/{$blog.url}/{$post.post_id}'>{$post.title}</a> published on {$post.upd_date|date_format}</div>
                        {/foreach}
                        </div>
                        {/if}
                        <div class="entry" style="width:30%;"><a href="{$smarty.const.URL}/profile/view/{$blog.pid}"><img src='{$smarty.const.URL}/getsmimage.php?id={$blog.user_imgs_id}' border="1" height="100" style="max-width:150px;" alt="{$blog.f_name}, {$blog.l_name}, {$blog.url}, {$blog.name} " /></a></div>
                        <div class="entry" style="width:98%;">
                            {if $blog.user_email == $email}
                                <p><a href="{$smarty.const.URL}/blog/editblog/{$blog.id}">Edit blog</a>&nbsp;|&nbsp;<a href="{$smarty.const.URL}/blog/deleteblog/{$blog.id}" class="artdel">Delete blog</a></p>
                            {/if}
                        </div>
                    </div>
                    <br />
                {/foreach}
            </div>
            <span style="float:right;" class="pageLink">
                <br />
                {paginate_first}&nbsp;&nbsp;{paginate_prev}&nbsp;&nbsp;{paginate_middle format="page" prefix="" suffix="" link_prefix="&nbsp;" link_suffix="&nbsp;" }&nbsp;&nbsp;{paginate_next}&nbsp;&nbsp;{paginate_last}
                <br />
            </span>
            {else}
            <div>
                <span>There are no latest blogs</span>
            </div>
            {/if}
        </div>
</div>
{literal}
<script type="text/javascript">
$(document).ready(function(){
    $('a.artdel').click(function(){
       var link = $(this).attr('href');
        jConfirm('Are you sure you want to delete this blog?', 'Confirmation Dialog', function(r) {
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