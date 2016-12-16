{literal}
<script type="text/javascript"> 
$(document).ready(function() {
    $("a.zoom").fancybox();

    $("a.zoom1").fancybox({
        'overlayOpacity'    :    0.7,
        'overlayColor'        :    '#FFF'
    });

    $("a.zoom2").fancybox({
        'zoomSpeedIn'        :    500,
        'zoomSpeedOut'        :    500
    });
});
</script>
{/literal}
<div style="float:left;width:740px;" >
    <div style="float:left;width:98%;">
        <span><img src="{$smarty.const.URL}/getsmimage.php?id={$img_id}" width="40"/><a href="{$smarty.const.URL}/profile/view/{$pid}" />&nbsp;{$uname}'s Profile</a></span>
        <div>
            <span class="mediumtxt" style="float:right;">
                <a href="{$smarty.const.URL}/picture/new">Create New Album</a>&nbsp;|&nbsp;<a href="{$smarty.const.URL}/picture/albumview/{$prof_aid}">Profile Photos</a>
            </span>
        </div>
        
        {if $album != null}
            <div style="width:98%px;">
                <span class="mediumtxt" style="float:left;">
                    <h3>Showing page {$paginate.page_current} of {$paginate.page_total}</h3>
                </span>
                <span class="mediuminfo" style="float:right;">
                    {paginate_first}&nbsp;&nbsp;{paginate_prev}&nbsp;&nbsp;{paginate_middle format="page" prefix="" suffix="" link_prefix="&nbsp;" link_suffix="&nbsp;" }&nbsp;&nbsp;{paginate_next}&nbsp;&nbsp;{paginate_last}
                </span>
            </div>
            <br />
            <div style="float:left;width:98%;">
                <center>
                    <div style="float:left;width:98%;">
                        {foreach item=pic from=$album}
                            {if $album.albumimg_id == 0}
                                <div class="pics">
                                    <div class="browsepics">
                                        <center>
                                        <a href='{$smarty.const.URL}/picture/view/{$pic.id}'><img src='{$smarty.const.URL}/getsmimage.php?id={$pic.id}'  style="max-height:110px;max-width:200px;" alt="{$uname} , {$pic.id},{$pic.id} conveylive"/></a>
                                        </center>
                                    </div>
                                    <div id="preview">
                                        <a href='{$smarty.const.URL}/{$pic.fpath}' class="zoom2" style="width:98%;" >Preview</a>
                                    </div>
                                </div>
                            {/if}
                        {/foreach}
                    </div>
                </center>
            </div>
            <div style="width:98%;">
                <span  class="mediuminfo" style="float:right;">
                    {paginate_first}&nbsp;&nbsp;{paginate_prev}&nbsp;&nbsp;{paginate_middle format="page" prefix="" suffix="" link_prefix="&nbsp;" link_suffix="&nbsp;" }&nbsp;&nbsp;{paginate_next}&nbsp;&nbsp;{paginate_last}
                </span>
            </div>
        {else}
            <p>There are no pictures in this album</p>
        {/if}
    </div>
</div>

<div style="float:left;width:98%;">
    <br />
    {if $album != null && $islogin == true}
        {include file="invitecontent_form.tpl"}
    {/if}
</div>