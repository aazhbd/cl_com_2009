<div style="float:left; width:740px;">
    {*include file="subtpl/had.tpl"*}     
    <div style="float:left;">
        <span align="left"><h3>
        <a href="{$smarty.const.URL}/message/inbox"><img src="{$smarty.const.URL}/interface/icos/mail_receive.png" style="width:20px;"/>Inbox</a>&nbsp;&nbsp;&nbsp;
        <a href="{$smarty.const.URL}/message/sentmessages"><img src="{$smarty.const.URL}/interface/icos/mail_send.png"  style="width:20px;" />Sent Messages</a>&nbsp;&nbsp;&nbsp;
        <a href="{$smarty.const.URL}/message/new"><img src="{$smarty.const.URL}/interface/icos/mail_new.png"  style="width:20px;" />New Message</a>&nbsp;&nbsp;&nbsp;
        </h3></span>
    </div>
    <div id="viewmsg">
        <div>
            <span>
                {if $boxtype == "inbox"}
                    <div style="float:left; width:80px;"><strong>From:</strong></div>
                    <div width="85">{$msg.sndr_name}</div>
                {elseif $boxtype == "sentbox"}
                    <div style="float:left; width:80px;"><strong>Receiver:</strong></div>
                    <div width="85">{$msg.rcvr_name}</div>
                {/if}
            </span>
        </div>
        <div>
            <span>&nbsp;</span>
        </div>
        <div>
            <span>
                <div style="float:left; width:80px;"><strong>Date:</strong></div>
                <div width="85">{$msg.ins_date|date_format:'%A, %B %e, %Y'} {$msg.ins_date|date_format:'%I:%M %p'}</div>
            </span>
        </div>
        <div>
            <span>&nbsp;</span>
        </div>
        <div>
            <span>&nbsp;</span>
        </div>
        <div>
            <span>
                <div style="float:left; width:630px;"><strong><img src="{$smarty.const.URL}/interface/icos/mail.png" />Message:</strong>&nbsp;&nbsp;</div>
                {if $boxtype == "inbox"} <div style="float:left;"><a href="{$smarty.const.URL}/message/delete/inbox/{$msg.id}" class="msgdel" ><img src="{$smarty.const.URL}/interface/icos/mail_remove.png"  style="width:20px;" />Delete</a></div>
                
                {elseif $boxtype == "sentbox"} <div style="float:left;"><a href="{$smarty.const.URL}/message/delete/inbox/{$msg.id}" class="msgdel" ><img src="{$smarty.const.URL}/interface/icos/mail_remove.png"  style="width:20px;" />Delete</a></div>
                {/if}
            </span>
            <div id="cont"><br/> {$msg.content}</div>
        </div>
        <div>
            <span>&nbsp;</span>
        </div>
        <div style="float:left;">
            <span align="left"><h3>
            {if $boxtype == "inbox"}
                <a href="{$smarty.const.URL}/message/reply/inbox/{$msg.id}"><img src="{$smarty.const.URL}/interface/icos/mail_reply.png"  style="width:20px;" />Reply</a>&nbsp;&nbsp;&nbsp;
                <a href="{$smarty.const.URL}/message/delete/inbox/{$msg.id}" class="msgdel"><img src="{$smarty.const.URL}/interface/icos/mail_remove.png"  style="width:20px;" />Delete</a>&nbsp;&nbsp;&nbsp;
            {elseif $boxtype== "sentbox"}
                <a href="{$smarty.const.URL}/message/delete/sentbox/{$msg.id}" class="msgdel"><img src="{$smarty.const.URL}/interface/icos/mail_remove.png"  style="width:20px;" />Delete</a>&nbsp;&nbsp;&nbsp;
            {/if}
            </h3></span>
        </div>
        <div style="float:right;">
            <span align="left"><h3>
            <a href="{$smarty.const.URL}/message/inbox"><img src="{$smarty.const.URL}/interface/icos/mail_receive.png" style="width:20px;"/>Inbox</a>&nbsp;&nbsp;&nbsp;
            <a href="{$smarty.const.URL}/message/sentmessages"><img src="{$smarty.const.URL}/interface/icos/mail_send.png"  style="width:20px;" />Sent Messages</a>&nbsp;&nbsp;&nbsp;
            <a href="{$smarty.const.URL}/message/new"><img src="{$smarty.const.URL}/interface/icos/mail_new.png"  style="width:20px;" />New Message</a>&nbsp;&nbsp;&nbsp;
            </h3></span>
        </div>
    </div>
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