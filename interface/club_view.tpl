
<a href="{$smarty.const.URL}/clubs/browse">Browse Clubs</a>&nbsp;|&nbsp;<a href="{$smarty.const.URL}/clubs/new">Create Club</a>
{if $club.clubType == 'secret' && $is_member == false}
    <p>No such club exists</p>
{else}
<div style="float:left; width:740px;">
    {if $reqArr != null}
        <div class="artcont" style="border:#ccc solid 1px; background:#eee;">
            {foreach item=req from=$reqArr}
                <div class="entry" style="width:50%;">
                    <strong><a href="{$smarty.const.URL}/profile/view/{$req.pid}">{$req.f_name} {$req.l_name}</a> wants to join this club. <br/>Request sent on {$req.join_date|date_format}</strong>
                </div>
                <div class="entry" style="width:18%;">
                    <strong><a href="{$smarty.const.URL}/clubs/approve/{$club.id}/{$req.id}">Approve</a></strong>
                </div>
                <div class="entry" style="width:18%;">
                    <strong><a href="{$smarty.const.URL}/clubs/deny/{$club.id}/{$req.id}">Deny</a></strong>
                </div>
            {/foreach}
        </div>
    {/if}
    {if $clubType == 'closed' and $is_member == false}
        <div class="artcont">
            <div class="entry" style="width:30%;" id="profbox" align="center"><img src="{$smarty.const.URL}/getimage.php?id={$club.image_id}" alt="{$club.name},{$club.category}" width="180" border="1" /></div>
            <div class="entry" style="width:65%; "><h3 style="color:olive; font-weight: bolder; font-size: 18px;">{$club.cname}</h3>
                <br/>Created: {$club.ins_date|date_format}
                <br/>Category: <a href="{$smarty.const.URL}/clubs/catbrowse/{$club.category|replace:' ':'_'}">{$club.category}</a>
                <br />Club Creator: <a href="{$smarty.const.URL}/profile/view/{$club.creator.pid}">{$club.f_name} {$club.l_name}</a>
            </div>
            <div class="entry" style="width:100%;">
                <a href="{$smarty.const.URL}/clubs/join/{$club.id}">Join Club</a>
                <p>This is a closed group. Your request to join this group requires admin approval.</p>
            </div>        
            <div class="entry" style="width:65%;">Total {$club.mem_count} member(s)</div>
            {if $club.description != null}
                <div class="entry" style="width:100%;">
                      {$club.description}
                </div>
            {/if}
        </div>
    {else}
    <div id="profbox" style="width:95%;">
        <div class="entry" style="width:30%;" id="profbox" align="center"><img src="{$smarty.const.URL}/getimage.php?id={$club.image_id}" alt="{$club.name},{$club.category}" style="width:95%;" border="1" align="middle"/></div>
        <div class="entry" style="width:65%; "><h3 style="color: olive; font-weight: bolder; font-size: 18px;">{$club.cname}</h3>
            {if $club.clubType == 'open'}
                <p>This is an open club. Anyone can join and share there views</p>
            {/if}
            {if $club.clubType == 'closed'}
                <p>This is closed club. It requires the approval of the admin for members to join</p>
            {/if}
            {if $club.clubType == 'secret'}
                <p>This is an secret club. Members can only join here by invitation</p>
            {/if}
            {if $club.description != null}
                <div class="entry" style="width:100%;">
                    Description: {$club.description}
                </div>
            {/if}            
        </div>
        <div class="entry" style="width:100%;" align="center"  >
           <a href="#Members" style="width:20%; " class="clubpart1" id="clubtop">Members</a>
           <a href="#Photos" style="width:20%; " class="clubpart2" id="clubtop">Photos</a>
           <a href="#Topics" style="width:20%; " class="clubpart3" id="clubtop">Topics</a>
           <a href="#Shared Files" style="width:20%; " class="clubpart4" id="clubtop">Shared Files</a>
        </div>
        <div class="entry" style="width:30%;" id="profbox">
            <div class="entry" style="width:100%;">
                Owner: <a href="{$smarty.const.URL}/profile/view/{$club.creator.pid}">{$club.f_name} {$club.l_name}</a>
            </div>
            <div class="entry" style="width:30%;">
                Admin(s):
            </div>
            <div class="entry" style="width:60%;">
            {foreach from=$club.adminList item=admin}
                <div><a href="{$smarty.const.URL}/profile/view/{$admin.pid}">{$admin.f_name} {$admin.l_name}</a></div>
            {/foreach}
            </div>
            <div class="entry" style="width:100%;">
                <br/>Created: {$club.ins_date|date_format}
                <br/>Category: <a href="{$smarty.const.URL}/clubs/catbrowse/{$club.category|replace:' ':'_'}">{$club.category}</a>
                <br /><a href="{$smarty.const.URL}/clubs/viewmembers/{$club.id}">Total {$club.mem_count} member(s)</a>
            </div>
        </div>
        <div class="entry" style="width:30%; margin-left:10px; border:none;" id="profbox">
            {if $is_member == true}
                <div class="catmenuLink" style="border:none; "><a href="{$smarty.const.URL}/clubs/invite/{$club.id}" ><img src="{$smarty.const.URL}/interface/icos/club_members.png" width="40px;"/>Invite friends</a></div> 
                <div class="catmenuLink" style="border:none; "><a href="{$smarty.const.URL}/clubs/newtopic/{$club.id}" ><img src="{$smarty.const.URL}/interface/icos/posttopic.png" width="40px;"/>New topic Post</a></div>
                <div class="catmenuLink" style="border:none; "><a href="{$smarty.const.URL}/clubs/addphotos/{$club.id}"><img src="{$smarty.const.URL}/interface/icos/addphoto.png" width="40px;"/>Add photos to club</a></div>
                <div class="catmenuLink" style="border:none; "><a href="{$smarty.const.URL}/clubs/uploadfile/{$club.id}" ><img src="{$smarty.const.URL}/interface/icos/sharefiles.png" width="40px;"/>Upload Files to Share</a></div>
            {/if}
            {if $is_admin == true}
                <div class="catmenuLink" style="border:none; "><a href="{$smarty.const.URL}/clubs/clubmessage/{$club.id}" <img src="{$smarty.const.URL}/interface/icos/mail_new.png" width="40px;"/>Send Message to all</a></div>
            {/if}
        </div>
        <div class="entry" style="width:25%; border:none;" id="profbox">
            {if $is_member == true}
                <div class="catmenuLink" style="border:none; "><a href="{$smarty.const.URL}/clubs/leave/{$club.id}" class="clubdel" >Leave Club</a></div>
            {/if}
            {if $is_member == false}
                <div class="catmenuLink" style="border:none; "><a href="{$smarty.const.URL}/clubs/join/{$club.id}">Join Club</a></div>
            {/if}
            {if $is_admin == true}
                <div class="catmenuLink" style="border:none; "><a href="{$smarty.const.URL}/clubs/editmembers/{$club.id}" >Edit Members</a> </div>
            {/if}
            {if $club.user_email == $email}
                <div class="catmenuLink" style="border:none; "><a href="{$smarty.const.URL}/clubs/edit/{$club.id}">Edit Club </a></div>
                <div class="catmenuLink" style="border:none; "><a href="{$smarty.const.URL}/clubs/delete/{$club.id}" class="audiodel">Delete Club</a></div>
            {/if}
        </div>       
    </div>
    {/if}
    {if $is_member == true}
    <div id="profbox" style="width:95%;">
        <h3 style="background:#D9F1FF; padding:10px;border: thin #eee solid;" id="Members">Members</h3>
        <img src="{$smarty.const.URL}/interface/icos/club_members.png" width="40px;"/><a href="{$smarty.const.URL}/clubs/invite/{$club.id}" >Invite friends</a>
        <br />
        <br />
        {if $members != null}
        <div style="float:left;width:100%;"><p><strong>Showing {$mem_paginate.first}-{$mem_paginate.last} of {$mem_paginate.total} members &nbsp;<a href="{$smarty.const.URL}/clubs/viewmembers/{$club.id}">See All</a></strong></p></div>
        <span class="pageLink" >{paginate_first id="member"}&nbsp;&nbsp;{paginate_prev id="member"}&nbsp;&nbsp;{paginate_middle id="member" format="page" prefix="" suffix="" link_prefix="&nbsp;" link_suffix="&nbsp;" }&nbsp;&nbsp;{paginate_next id="member"}&nbsp;&nbsp;{paginate_last id="member"}</span>
        <table>
            <tr>
                {foreach from=$members item=mem name=mi}
                <td height="80" style="background:white;">
                    <a href="{$smarty.const.URL}/profile/view/{$mem.pid}"><img src="{$smarty.const.URL}/getsmimage.php?id={$mem.user_imgs_id}" style="max-width:200px; max-height: 80px;" alt="{$mem.f_name}, {$mem.l_name}, conveylive"/></a>&nbsp;
                    <br/><a href="{$smarty.const.URL}/profile/view/{$mem.pid}">{$mem.f_name} {$mem.l_name}</a>
                </td>
                {/foreach}
            </tr>
        </table>
        <br/>
        {/if}
    </div>

    <div id="profbox" style="width:95%;">
        <h3 style="background:#fee; padding:10px;border: thin #eee solid;" id="Photos">Photos</h3>
        <br />
        <img src="{$smarty.const.URL}/interface/icos/addphoto.png" width="40px;"/><a href="{$smarty.const.URL}/clubs/addphotos/{$club.id}">Add photos to club</a>
        <br/> <br/> 
        {if $pictures != null}
        <div style="float:left;width:100%;"><p><strong>Showing {$pic_paginate.first}-{$pic_paginate.last} of {$pic_paginate.total} photos </strong></p></div>
        <br/>
        <div class="pageLink" > {paginate_first id="picture"}&nbsp;&nbsp;{paginate_prev id="picture"}&nbsp;&nbsp;{paginate_middle id="picture" format="page" prefix="" suffix="" link_prefix="&nbsp;" link_suffix="&nbsp;" }&nbsp;&nbsp;{paginate_next id="picture"}&nbsp;&nbsp;{paginate_last id="picture"}</div>
        <table>
            <tr>
                {foreach from=$pictures item=pic }
                    <td height="80">
                        <a href="{$smarty.const.URL}/picture/view/{$pic.id}"><img src="{$smarty.const.URL}/getsmimage.php?id={$pic.id}" style="max-width:200px; max-height: 80px;" alt="{$pic.f_name}, {$pic.l_name}" border="1"/> </a>&nbsp;
                    </td>
                {/foreach}
            </tr>
        </table>
        <br/>
        {/if}
    </div>

    <div id="profbox" style="width:95%;">
        <h3 style="background:#ffe; padding:10px;border: thin #eee solid;" id="Topics">Topics</h3>
        <br />
        <img src="{$smarty.const.URL}/interface/icos/posttopic.png" width="40px;"/><a href="{$smarty.const.URL}/clubs/newtopic/{$club.id}" >Post New Topic</a><br/>
        <br />
        {if $topics != null}
            <div style="float:left;width:100%;"><p><strong>Showing {$top_paginate.first}-{$top_paginate.last} of {$top_paginate.total} topics <a href="{$smarty.const.URL}/clubs/topics/{$club.id}">See All</a></strong></p></div>
            <br/>
            <span class="pageLink" >{paginate_first id="topic"}&nbsp;&nbsp;{paginate_prev id="topic"}&nbsp;&nbsp;{paginate_middle id="topic" format="page" prefix="" suffix="" link_prefix="&nbsp;" link_suffix="&nbsp;" }&nbsp;&nbsp;{paginate_next id="topic"}&nbsp;&nbsp;{paginate_last id="topic"}</span>
            <br /><br />
            <ol>
                {foreach item=t from=$topics name=top}
                    <li>&nbsp;&nbsp;<a href="{$smarty.const.URL}/clubs/viewpost/{$t.post_id}">{$t.topic}</a></li>
                    <br />
                {/foreach}
            </ol>
            <br/>
        {/if}
    </div>
    
    <div id="profbox" style="width:95%;">
        
        <h3 style="background:#B8DCDC; padding:10px;border: thin #eee solid;" id="Shared Files">Shared Files</h3>
        <br />
        <img src="{$smarty.const.URL}/interface/icos/sharefiles.png" width="40px;"/><a href="{$smarty.const.URL}/clubs/uploadfile/{$club.id}" >Upload Files to Share</a><br/>
        <br />
        {if $files != null}
            <div style="float:left;width:100%;">
                <p><strong>Showing {$file_paginate.first}-{$file_paginate.last} of {$file_paginate.total} files </strong></p>
            </div>
            <span class="pageLink" >{paginate_first id="files"}&nbsp;&nbsp;{paginate_prev id="files"}&nbsp;&nbsp;{paginate_middle id="files" format="page" prefix="" suffix="" link_prefix="&nbsp;" link_suffix="&nbsp;" }&nbsp;&nbsp;{paginate_next id="files"}&nbsp;&nbsp;{paginate_last id="files"}</span>
            <div style="margin-top:10px;">
                {foreach item=file from=$files name=f}
                    <li>
                    {if $file.file_ext == ".pdf"}
                        <img src="{$smarty.const.URL}/interface/icos/pdf.png" alt="pdf, {$file.file_name}, {$file.f_name} {$file.l_name}, conveylive.com" width="20px" />
                    {elseif $file.file_ext == ".doc"}
                        <img src="{$smarty.const.URL}/interface/icos/doc.png" alt="doc, {$file.file_name}, {$file.f_name} {$file.l_name}, conveylive.com" width="20px" />
                    {elseif $file.file_ext == ".docx"}
                        <img src="{$smarty.const.URL}/interface/icos/doc.png" alt="doc, {$file.file_name}, {$file.f_name} {$file.l_name}, conveylive.com" width="20px" />
                    {elseif $file.file_ext == ".zip"}
                        <img src="{$smarty.const.URL}/interface/icos/zip.png" alt="zip, {$file.file_name}, {$file.f_name} {$file.l_name}, conveylive.com" width="20px" />
                    {elseif $file.file_ext == ".txt"}
                        <img src="{$smarty.const.URL}/interface/icos/text.png" alt="txt, {$file.file_name}, {$file.f_name} {$file.l_name}, conveylive.com" width="20px" />
                    {elseif $file.file_ext == ".rtf"}
                        <img src="{$smarty.const.URL}/interface/icos/rtf.png" alt="rtf, {$file.file_name}, {$file.f_name} {$file.l_name}, conveylive.com" width="20px" />
                    {elseif $file.file_ext == ".ppt"}
                        <img src="{$smarty.const.URL}/interface/icos/ppt.png" alt="ppt, {$file.file_name}, {$file.f_name} {$file.l_name}, conveylive.com" width="20px" />
                    {else}
                        <img src="{$smarty.const.URL}/interface/icos/help.png" alt="unknown, {$file.file_name}, {$file.f_name} {$file.l_name}, conveylive.com" width="20px" />    
                    {/if}
                    &nbsp;&nbsp;<a href="{$smarty.const.URL}/getfile.php?id={$file.file_id}&cid={$club.id}">{$file.file_name}</a> uploaded by  <a href="{$smarty.const.URL}/profile/view/{$file.pid}">{$file.f_name} {$file.l_name}</a> on {$file.date|date_format} &nbsp; {if $is_admin == true}<a href="{$smarty.const.URL}/clubs/deletefile/{$club.id}/{$file.file_id}" class="filedel">Delete</a>{/if}</li>
                {/foreach}
            </div>
            
            <br/>
        {/if}
    </div>
    {/if}
</div>
{/if}
{if $relArt != null || $latArt != null || $popArt != null}
<div id="profbox" style="width:93%;">
    {if $relArt != null}
        <div style="float:left;width:500px;">
            <h3>Related Clubs</h3>
            <div class="relList">
            {foreach item=art from=$relArt}
                <li><a href='{$smarty.const.URL}/clubs/view/{$art.id}'>{$art.cname}</a></li>
            {/foreach}
            <li>Browse <a href="{$smarty.const.URL}/clubs/catbrowse/{$club.category|replace:' ':'_'}"> >> {$club.category}</a></li>
            </div>
            
        </div>
    {else}
        <br />
    {/if}
    
    {if $latArt != null}
        <div style="float:left;">
            <h3>Latest Clubs</h3>
            <div class="relList">
            {foreach item=art from=$latArt}
                <li><a href='{$smarty.const.URL}/clubs/view/{$art.id}'>{$art.name}</a></li>
            {/foreach}
            </div>
            <p><a href="{$smarty.const.URL}/clubs/browse">>> All Latest Clubs</a></p>
        </div>
    {else}    
        <br />
    {/if}
    
    {if $popArt != null}
        <div style="float:left;width:160px;">
            <h3>Popular Clubs</h3>
            <div class="relList">
            {foreach item=art from=$popArt}
                <li><a href='{$smarty.const.URL}/clubs/view/{$art.id}'>{$art.name}</a></li>
            {/foreach}
            </div>
        </div>
    {else}    
        <br />
    {/if}
</div>
{/if}

{literal}
<script type="text/javascript">
$(document).ready(function(){
    $('a.clubdel').click(function(){
       var link = $(this).attr('href');
        jConfirm('Are you sure you want to leave this club?', 'Confirmation Dialog', function(r) {
            if(r == true){
                window.location.href = link;
            }
            else{
                return false;
            }
        });
        return false;
    });
    $('a.filedel').click(function(){
       var link = $(this).attr('href');
        jConfirm('Are you sure you want to delete this file?', 'Confirmation Dialog', function(r) {
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