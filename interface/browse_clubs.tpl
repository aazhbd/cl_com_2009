<div style="float:left; width:740px;">
    {*include file="subtpl/had.tpl"*}
    <div id="pginfo">
        Browse recent clubs published by users of conveylive. You may browse clubs by category.
        Join clubs of your interest. If you are logedin, you may take part in discussion with the club members and share files and photos. You may invite your friends and enjoy various club activities.
        Clubs are of three types: Open, Closed and Secret.
    </div>
    <div style="padding: 1em;">
    {if $pubList != null}
        <br />
        <div class="browsecat" style="float:left;">
            <h3>Public and Closed Club Categories</h3>
            <div class="catmenuLink" style="border:none; ">
                {foreach item=club from=$pubList}
                    <li><a href="{$smarty.const.URL}/clubs/catbrowse/{$club.cat.cname|replace:' ':'_'}">{$club.cat.cname} ({$club.count}) </a></li>
                {/foreach}
            </div>
        </div>
    {/if}
    {if $selfList != null}
        <div class="browsecat" style="float:left;">
            <h3>Your club categories</h3>
            <div class="catmenuLink" style="border:none; ">
                {foreach item=club from=$selfList}
                    <li><a href="{$smarty.const.URL}/clubs/catbrowse/{$club.cat.cname|replace:' ':'_'}/self">{$club.cat.cname} ({$club.count}) </a></li>
                {/foreach}
            </div>
        </div>
        <br />
    {/if}
    </div>
    <div style="width:740px;">
        <br />
        {if $topicHead != null}
            <h3>{$topicHead}</h3>
        {else}
            <h3>Recently Published Clubs</h3>
        {/if}
    </div>
    {if $clubList != null} 
        <div>
            <span style="float:left;" class="pageLink">Showing clubs {$paginate.first}-{$paginate.last} of {$paginate.total}</span>
            <span style="float:right;padding:5px;" class="pageLink">{paginate_first}&nbsp;&nbsp;{paginate_prev}&nbsp;&nbsp;{paginate_middle format="page" prefix="" suffix="" link_prefix="&nbsp;" link_suffix="&nbsp;" }&nbsp;&nbsp;{paginate_next}&nbsp;&nbsp;{paginate_last}</span>
        </div> 
        <div>
            {foreach item=club from=$clubList}
                {if ( $club.is_member == true) || ( $club.is_member == false && $club.privacy != 2) }
                    <div class="artcont">
                        <a href='{$smarty.const.URL}/clubs/view/{$club.id}' id="titleblock" class="entry" style="width:65%;font-weight:bold;font-size:16px;" >
                            {$club.cname}
                        </a>
                        
                        <a href="{$smarty.const.URL}/profile/view/{$club.pid}" class="entry" style="width:30%; " id="titleblock">by {$club.f_name} {$club.l_name} | {$club.ins_date|date_format} </a>
                        
                        <div class="entry" style="width:35%;">
                            <a href='{$smarty.const.URL}/clubs/view/{$club.id}'><img src="{$smarty.const.URL}/getsmimage.php?id={$club.image_id}" alt="{$club.cname},{$club.category}, {$club.f_name}, {$club.l_name} ConveyLive" width="80" border="1" /></a>
                        </div>
                        <div class="entry" style="width:29%;">
                            {$club.description|truncate:100}
                        </div>                        
                        <div class="entry" style="width:20%;">
                            <a href="{$smarty.const.URL}/clubs/catbrowse/{$club.category|replace:' ':'_'}">{$club.category}</a>
                        </div>                        
                        <div class="entry" style="width:98%;">
                            Total {$club.mem_count} member(s) 
                            {if $club.user_email == $email}
                                | <a href="{$smarty.const.URL}/clubs/edit/{$club.id}">Edit Club Info</a> | <a href="{$smarty.const.URL}/clubs/delete/{$club.id}" class="clubdel">Delete Club</a>
                            {/if}
                        </div>
                    </div>
                {/if}
            {/foreach}
            </div>
            <div style="width:740px;">
                <span style="float:right" class="pageLink">
                    {paginate_first}&nbsp;&nbsp;{paginate_prev}&nbsp;&nbsp;{paginate_middle format="page" prefix="" suffix="" link_prefix="&nbsp;" link_suffix="&nbsp;" }&nbsp;&nbsp;{paginate_next}&nbsp;&nbsp;{paginate_last}
                </span>
            </div>
    {else}
        <p>No clubs have been recently updated.</p>
    {/if}
</div>

{literal}
<script type="text/javascript">
$(document).ready(function(){
    $('a.clubdel').click(function(){
       var link = $(this).attr('href');
        jConfirm('Are you sure you want to delete this club?', 'Confirmation Dialog', function(r) {
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