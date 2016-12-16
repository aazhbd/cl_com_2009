<div style="float:left; width:730px;">
    {if $res_list != null}
    <div>
        <span class="mediumtxt" style="float:right;">
            <a href="{$smarty.const.URL}/picture/new">Create New Album</a>&nbsp;|&nbsp;<a href="{$smarty.const.URL}/picture/albumview/{$prof_aid}">Profile Photos</a>
        </span>
    </div>
    <div>
        <span class="mediumtxt" style="float:left;">
            Photo {$paginate.current_item} of {$paginate.total} | <a href="{$smarty.const.URL}/picture/albumview/{$aid}">Back to Album</a>
        </span>
        <span class="mediuminfo" style="float:right;">
                {paginate_prev} {paginate_next}
        </span>
    </div>
    <hr />
    {foreach item=img from=$res_list}
    <div align="center">
        <a href="{$smarty.const.URL}/getimage.php?id={$img.id}"><img src="{$smarty.const.URL}/getimage.php?id={$img.id}"   align="absmiddle" style="max-width:550px; max-height:700px; border: solid #ccc 1px;" alt="Image, Photo, ConveyLive, {$album_name} , {$uname}, {$img.id}" /></a>
        {assign var="media_id" value=$img.id}
        {assign var="uemail" value=$img.user_email}
    </div>
    {/foreach}
    
    <br />
    <br />
    
    <div style="float:left; width:98%;" class="mediumtxt">
        <p>{$remarks}</p>
    </div>
    
    <div style="float:right;" class="mediumtxt">
        From the album:
        <p>
            <a href="{$smarty.const.URL}/picture/albumview/{$aid}">{$album_name}</a>
            by <a href="{$smarty.const.URL}/profile/view/{$pid}">{$uname}</a>
            <br />
            {if $uemail == $email}
                <a href="{$smarty.const.URL}/picture/setalbumphoto/{$img.id}">Set as album cover photo</a>
                <br />
                <a href="{$smarty.const.URL}/picture/setprofilephoto/{$img.id}">Set as profile photo</a>
                <br />
                <a href="{$smarty.const.URL}/picture/new">Add more photos</a>
                <br />
                <a href="{$smarty.const.URL}/picture/delete/{$img.id}" class='picremove'>Remove photo</a>
            {/if}
        </p>    
    </div>
    {else}
        <div id="pginfo">
            Sorry, this album is not available.
        </div>
    {/if}
</div>
{literal}
<script type="text/javascript">
$(document).ready(function(){
    $('a.picremove').click(function(){
       var link = $(this).attr('href');
        jConfirm('Are you sure you want to delete this page?', 'Confirmation Dialog', function(r) {
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