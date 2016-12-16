<div style="float:left; width:740px;">
    {*include file="subtpl/had.tpl"*}
    <div id="pginfo">
        Browse latest albums published by the users of conveylive.
        See the albums one by one and its photos. If you are logedin you may post comments to give some feedback.
    </div>
    <div style="width:98%; float:left;">
        {if $albums != null}

        <div>
            <br />
            <span style="float:left;" class="pageLink"><h3>Showing page {$paginate.page_current} of {$paginate.page_total}</h3></span>
            <span style="float:right;" class="pageLink">
                {paginate_first}&nbsp;&nbsp;{paginate_prev}&nbsp;&nbsp;{paginate_middle format="page" prefix="" suffix="" link_prefix="&nbsp;" link_suffix="&nbsp;" }&nbsp;&nbsp;{paginate_next}&nbsp;&nbsp;{paginate_last}
            </span>
        
        </div>
        <br /><br />
        
        <div style="width:98%;">
            <center>
                <div style="width:98%;">
                    {foreach item=album from=$albums}
                        <div class="album">
                            <center>
                                <div class="browsealbums">
                                    <a href='{$smarty.const.URL}/picture/albumview/{$album.id}'><img src='{$smarty.const.URL}/getsmimage.php?id={$album.image_id}' style="max-height:100px;" alt="{$album.album_name}, {$album.f_name} {$album.l_name}, conveylive"/></a>
                                    <h3>{$album.album_name|truncate:30}</h3>
                                    {$album.ins_date|date_format}<br />
                                    Total {$album.pic_count} photo(s)<br />
                                    by <a href="{$smarty.const.URL}/profile/view/{$album.pid}" style= "width:190px; overflow:hidden;">{$album.f_name|truncate:30} {$album.l_name|truncate:30}</a>
                                    <br />
                                </div>
                            </center>
                        </div>
                    {/foreach}
                </div>
            </center>
        </div>

        <div style="float:left;width:98%;">
            <span style="float:right;" class="pageLink">
                {paginate_first}&nbsp;&nbsp;{paginate_prev}&nbsp;&nbsp;{paginate_middle format="page" prefix="" suffix="" link_prefix="&nbsp;" link_suffix="&nbsp;" }&nbsp;&nbsp;{paginate_next}&nbsp;&nbsp;{paginate_last}
            </span>
        </div>
        {else}
        <p>There are no latest albums to view</p>
        {/if}
    </div>

</div>