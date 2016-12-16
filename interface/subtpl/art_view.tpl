
<div style="width:98%;">
    <div id="box">
        <div style="width:42px; height:42px; float:left;">
            <a href="{$smarty.const.URL}/profile/view/{$article.pid}"><img src="{$smarty.const.URL}/getsmimage.php?id={$article.user_imgs_id}" alt="{$article.name}" height="40" /></a>
        </div>
        <div class="smallbox">
            <a href="{$smarty.const.URL}/profile/view/{$article.pid}">{$article.name}</a><br />
            {$article.ins_date|date_format}
        </div>
        <div class="infobox">
            {$com_count|default:'0'} Comments | {$article.view_count} Views |
            {$article.tothits} Hits
            <br />
            {if $article.user_email neq $email && $islogin == true}
                Rate up &nbsp;<a href="{$smarty.const.URL}/article/rateup/{$article.id}" id="rateup" title="Rate down"><img src="{$smarty.const.URL}/interface/icos/thumbs_up.gif" width="15px" alt="{$article.name},rating-up, {$article.title}" border="0"/></a> &nbsp;
                Rate down &nbsp;<a href="{$smarty.const.URL}/article/ratedown/{$article.id}" id="ratedown" title="Rate down"><img src="{$smarty.const.URL}/interface/icos/thumbs_down.gif" width="15px" alt="{$article.name}, rating-down, {$article.title}" border="0" /></a>
            {/if}
        </div>
        <div class="ratingbox">
            Rating: {$article.rating}
            {section name=foo start=1 loop=6 max=6 step=1}
                {if $smarty.section.foo.index <= $article.rating}
                    <img src="{$smarty.const.URL}/interface/icos/star.png" alt="{$article.name} , {$article.title}" width="12px"/>
                {elseif $smarty.section.foo.index > $article.rating}
                    <img src="{$smarty.const.URL}/interface/icos/star_dull.png" alt="{$article.name} , {$article.title}" width="12px"/>
                {/if}
            {/section}
            
            {if $article.category != ""}<br /><a href="{$smarty.const.URL}/article/categorybrowse/{$article.category|replace:' ':'_'}">{$article.category}{/if}</a>
        </div>
    </div>
    <br />
    
    <div style="width:98%;">
        <div>
            <span>
                {if $article.user_email eq $email && $islogin == true}
                    <img src="{$smarty.const.URL}/interface/icos/page_edit.png" style="width:15px;" />
                    <a href="{$smarty.const.URL}/article/edit/{$article.id}">Edit</a> | 
                    <img src="{$smarty.const.URL}/interface/icos/delete_post.png" style="width:15px;"/>
                    <a href="{$smarty.const.URL}/article/delete/{$article.id}" class="artdel">Delete</a> | 
                {/if}
                {if $com_count > 0}
                    <img src="{$smarty.const.URL}/interface/icos/comments.png" style="width:15px;"/>
                    <a href="#comlist" >View Comments</a> | 
                {/if}
                    <img src="{$smarty.const.URL}/interface/icos/comment_add.png" style="width:15px;"/>
                    <a href="#addcomment" >Add Your Comment</a>
            </span>
        </div>
        <br />
        {if $prev.url == null && $prev != null}
            <div style="float:left;">
                <a href="{$smarty.const.URL}/a/{$prev.id}" title="{$prev.title}"><img src="{$smarty.const.URL}/interface/images/left_arrow.png" />Previous</a>
            </div>
        {elseif $prev != null}
            <div style="float:left;">
                <a href="{$smarty.const.URL}/a/{$prev.url}" title="{$prev.title}"><img src="{$smarty.const.URL}/interface/images/left_arrow.png" /><br />Previous</a>
            </div>
        {/if}
        {if $next.url == null && $next != null}
            <div style="float:right;">
                <a href="{$smarty.const.URL}/a/{$next.id}" title="{$next.title}"><img src="{$smarty.const.URL}/interface/images/right_arrow.png" /><br />Next</a>
            </div>
        {elseif $next != null}
            <div style="float:right;">
                <a href="{$smarty.const.URL}/a/{$next.url}" title="{$next.title}"><img src="{$smarty.const.URL}/interface/images/right_arrow.png" /><br />Next</a>
            </div>
        {/if}
    </div>
    <div style="width:98%;">
        <div style="width:98%; float:none;">
            {$article.body}
        </div>

        <div style="width:98%; float:none;margin-top:20px;">
        {if $article.remarks != ""}
            <div>
                <img src="{$smarty.const.URL}/interface/icos/posttopic.png" style="width:30px;" /><strong>Author's note</strong>: {$article.remarks}
            </div>
        {/if}
        {if $article.meta_tags != ""}
            <div>
                <img src="{$smarty.const.URL}/interface/icos/key.png" style="width:30px;" /><strong>Keywords</strong>: {$article.meta_tags}
            </div>
        {/if}
        <hr />
        </div>
    </div>
    
    
    <br />
    
    <div>
        {if $coms != null}<h3><img src="{$smarty.const.URL}/interface/icos/comments.png" style="width:30px;" />Comments on this page</h3>{/if}
        <br />
        <div id="comlist">
            {if $coms != null}
                {include file="comment_view.tpl"}
            {/if}
        </div>
        {if $islogin == true}
            <div id="addcomment">
                <form id="frmcmt" method="post">
                    <fieldset>
                        <legend>Add your comment</legend>
                        <div>
                            <input type="hidden" name="artid" id="artid" value="{$article.id}" />
                            <input type="hidden" name="mtype" id="mtype" value="Article" />
                            <input type="hidden" name="uemail" id="uemail" value="{$email}" />
                            <textarea id="comment" name="comment" style="width:700px;height:150px;" rows="5" ></textarea>
                        </div>
                        <div>
                            <input type="submit" value="Add Comment" class="frmbtn" id="cmtpost" />
                        </div>
                    </fieldset>
                </form>
            </div>
        {else}
            <div style="width:550px;" id="addcomment">
                <h3>Please <a href="{$smarty.const.URL}/signup">Signup</a> to comment on this page</h3>
            </div> 
        {/if}
    </div>
    {if $relArt != null}
    <div style="width:98%; float:left; margin-top:10px; margin-bottom:10px;">
        <div style="width:570px;height:auto;float: left;" class="invitebox">            
            <div style="float:left;width:720px;" >
                <h3>Related Pages</h3>
                <div class="relList">
                {foreach item=art from=$relArt}
                    {if $art.url == null || $art.url == ""}
                        <li style="padding:5px;"><a href='{$smarty.const.URL}/a/{$art.id}'>{$art.title|truncate:100}</a></li>
                    {else}
                        <li style="padding:5px;"><a href='{$smarty.const.URL}/a/{$art.url}'>{$art.title|truncate:100}</a></li>
                    {/if}
                {/foreach}
                </div>
                <div style="padding:10px;">
                    Browse other page of similar category <a href="{$smarty.const.URL}/article/categorybrowse/{$article.category|replace:' ':'_'}"> >> {$article.category}</a>
                </div>
            </div>
        </div>
        <div style="float: right;">
            <script language='javascript'>var sp_key = '4iclo93r28w0scws';</script><script type='text/javascript' src='http://www.spottt.com/js/spottt.js'></script>
        </div>
    </div>
    {/if}
    <br />
    {if $article != null && $islogin == true }
        {include file="invitecontent_form.tpl"}
    {/if}
</div>


{literal}
<script type="text/javascript">
    $(document).ready(function(){
        $('a.artdel').click(function(){
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
        });
        
        $('#cmtpost').click(function(){
            var cmt = $('#comment').val();
            var aid = $('#artid').val();
            var mt = $('#mtype').val();
            var ue = $('#uemail').val();
            var ins = 'insert';
            var dataString = 'cmt='+cmt+'&aid='+aid+'&mt='+mt+'&ue='+ue+'&ins='+ins;
            if(cmt.length == 0)
            {
                alert("You can not post blank comment. Please type your comment.");
                return false;
            }
            if(cmt.length > 2499)
            {
                alert("You can not put more than 2499 characters for comment. Please shorten your comment.");
                return false;
            }
            var aurl = site.url + "/cmtprocess.php";
            
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
            return false;
        });
        
        $('a#removecmt').click(function(){
            var link = $(this).attr("href");
            var qpos = link.indexOf('?');
            var param = link.substring(qpos + 1);
            var rem = "remove";
            
            var mid = $('#artid').val();
            var mt = $('#mtype').val();
            
            var dataString = param +'&rem='+rem+'&mid='+mid+'&mt='+mt;
            
            var aurl = site.url + "/cmtprocess.php";
            
            $.ajax({
                type: "POST",
                url: aurl,
                data: dataString,
                cache: false,
                dataType: "html",
                success: function(response){
                    $("#comlist").fadeIn(400).html(response);
                }
            });
            return false;
        });        
        
    });
</script>
{/literal}