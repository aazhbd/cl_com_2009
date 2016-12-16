<div style="float:left; width:730px;">
    {*include file="subtpl/had.tpl"*}
    {if $messages != null}
        <div style="float:left; width:530px;">
            <span>{paginate_first}&nbsp;&nbsp;{paginate_prev}&nbsp;&nbsp;{paginate_middle format="page" prefix="" suffix="" link_prefix="&nbsp;" link_suffix="&nbsp;" }&nbsp;&nbsp;{paginate_next}&nbsp;&nbsp;{paginate_last}</span>
        </div>
        <div style="float:left;">
            <span>&nbsp;Showing messages {$paginate.first}-{$paginate.last} of {$paginate.total} </span>
        </div>
        <br /><br />
        <table class="mailbox">
            <tr style="height:50px;font-weight:bolder;" >
                <td style="background:white;width:100%;">
                    <div style="width:15px;float:left;">&nbsp;</div> 
                    <div style="width:30px;float:left;">&nbsp;</div>
                    <div style="width:60px;float:left;">&nbsp;</div>
                    <div style="width:110px;float:left;">{if $boxtype == "inbox"}Sender{else}Recepient{/if}</div>
                    <div style="width:250px;float:left;">Subject</div>
                    <div style="width:100px;float:left;">Date</div>
                    <div style="width:80px;float:left;">&nbsp;</div>
                    <div style="width:60px;float:left;">&nbsp;</div>
                </td>
            </tr>
            {assign var="p" value="`$paginate.page[$paginate.page_current].item_start`"}
            {foreach item=msg from=$messages name=m}
                <tr class="mailtblrow">
                    <td style="width:100%;" 
                    {if $smarty.foreach.m.iteration is even}
                    class="evenrow">
                    {else}
                    class="oddrow">
                    {/if}
                        {if $msg.read_stat == 2 and $boxtype == "inbox"}
                            <div style="width:40px;float:left;"><img src="{$smarty.const.URL}/interface/icos/read.png" height="15" />&nbsp;{$p}</div>
                        {elseif $msg.read_stat == 1 and $boxtype == "inbox"}
                            <div style="width:40px;float:left;"><img src="{$smarty.const.URL}/interface/icos/unread.png" height="15" />&nbsp;{$p}</div>
                        {elseif $boxtype == "sentbox"}
                            <div style="width:40px;float:left;"><img src="{$smarty.const.URL}/interface/icos/read.png" height="15" />&nbsp;{$p}</div>
                        {/if}
                        
                        <div style="float:left;width:60px;">
                            {if $msg.sndr_mail_addr neq ""}
                                <a href='{$smarty.const.URL}/profile/view/{$msg.sndr_pid}'><img src="{$smarty.const.URL}/getsmimage.php?id={$msg.sndr_img_id}" height="50" border="1" alt="{$msg.sndr_name}"/></a>
                            {else}
                                <a href='{$smarty.const.URL}/profile/view/{$msg.sndr_pid}'><img src="{$smarty.const.URL}/interface/icos/user.gif" height="50"  border="1" alt="{$msg.sndr_name}" /></a>
                            {/if}
                        </div>
                        <div style="width:100px;float:left;margin-left:5px; margin-right:10px;" >
                            <a href='{$smarty.const.URL}/profile/view/{$msg.sndr_pid}'>{$msg.sndr_name|default:"<No user>"}</a>
                        </div>
                        {if $boxtype == "inbox"}
                        <a href='{$smarty.const.URL}/message/view/inbox/{$msg.id}' class="subj">
                            <div style="width:250px;float:left;" >
                                {if $msg.subj == ""}
                                    < No Subject >
                                {else}
                                    {$msg.subj|truncate:50}
                                {/if}
                            </div>
                            <div style="width:100px;float:left;">
                                {$msg.ins_date|date_format}
                            </div>
                        </a>
                        {elseif $boxtype == "sentbox"}
                            <a href='{$smarty.const.URL}/message/view/sentbox/{$msg.id}' class="subj">
                                <div style="width:250px;float:left;" >
                                    {$msg.subj|default:'< No Subject >'}
                                </div>
                                <div style="width:100px;float:left;">
                                    {$msg.ins_date|date_format}
                                </div>
                            </a>
                        {/if}
                        <div style="width:80px;float:left;">
                        {if $boxtype == "inbox"} 
                            <a href="{$smarty.const.URL}/message/delete/inbox/{$msg.id}" class="msgdel" title="Delete Message"><img src="{$smarty.const.URL}/interface/icos/mail_remove.png" width="30" alt="Delete Message"/><br />Delete</a>
                        {/if}
                        {if $boxtype == "sentbox"} 
                            <a href="{$smarty.const.URL}/message/delete/sentbox/{$msg.id}" class="msgdel" title="Delete Message"><img src="{$smarty.const.URL}/interface/icos/mail_remove.png" width="30" alt="Delete Message"/><br />Delete</a>
                        {/if}
                        </div>
                        {if $boxtype == "inbox"} 
                            <div style="width:60px;float:left;">
                                <a href="{$smarty.const.URL}/message/reply/inbox/{$msg.id}" title="Reply"><img src="{$smarty.const.URL}/interface/icos/mail_reply.png" width="30" alt="Reply"/><br />Reply</a>
                            </div>
                        {/if}
                        {assign var="p" value="`$p+$x`"}
                    </td>
                </tr>
            {/foreach}
        </table>
        <div><img src="{$smarty.const.URL}/interface/icos/unread.png" height="15" />&nbsp; = Mail Unread key Icon </div>
        <div><img src="{$smarty.const.URL}/interface/icos/read.png" height="15" />&nbsp; = Mail Read key Icon</div>
        <br />
        <span>{paginate_first}&nbsp;&nbsp;{paginate_prev}&nbsp;&nbsp;{paginate_middle format="page" prefix="" suffix="" link_prefix="&nbsp;" link_suffix="&nbsp;" }&nbsp;&nbsp;{paginate_next}&nbsp;&nbsp;{paginate_last}</span>
    {else}
        <div id="pginfo" style="background: #ffe; ">
            Your Message Box Is Empty <br /><br />
            <a href="{$smarty.const.URL}/message/new"><img src="{$smarty.const.URL}/interface/icos/mail_send.png">Send a new message </a>to your friend in conveylive.com
        </div>
    {/if}
</div>
{literal}
<script type="text/javascript">
$(document).ready(function(){
    $('a.msgdel').click(function(){
       var link = $(this).attr('href');
        jConfirm('Are you sure you want to delete this message?', 'Confirmation Dialog', function(r) {
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
