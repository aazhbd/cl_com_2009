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
    });
});

</script>
{/literal}
<div style="float:left;width:740px;">
    <div id="errors"></div>
    {*include file="subtpl/had.tpl"*}
    
    <div style="float:left;width:100%;">
        <span align="left"><h3>
        <a href="{$smarty.const.URL}/message/inbox"><img src="{$smarty.const.URL}/interface/icos/mail_receive.png" style="width:20px;"/>Inbox</a>&nbsp;&nbsp;&nbsp;
        <a href="{$smarty.const.URL}/message/sentmessages"><img src="{$smarty.const.URL}/interface/icos/mail_send.png"  style="width:20px;" />Sent Messages</a>&nbsp;&nbsp;&nbsp;
        <a href="{$smarty.const.URL}/message/new"><img src="{$smarty.const.URL}/interface/icos/mail_new.png"  style="width:20px;" />New Message</a>&nbsp;&nbsp;&nbsp;
        </h3></span>
    </div>
    <br />
    <div style="float:left;width:740px;margin-top:10px;">

        <form name="frmnewmsg" id="frmnewmsg" method="post" action="{$smarty.const.URL}/newmessage.php">
            <fieldset>
                <legend>Write a reply</legend>
                <div>
                    <span>
                        <div style='float:left; width:80px;'><label>To:</label></div>
                        <input type="text" name="to" id="fname" value="{$fname}" style="width:566px;color:black; background:#eee;font-weight:bold;"  disabled="disabled"/>
                    </span>
                </div>
                <div>
                    <span>
                        <div style='float:left; width:80px;'><label>Subject:</label></div>
                        <input type="text" name="subj" id="subj" style="width:566px;" value="{if $msg.subj neq ""}Reply: {$msg.subj} {else} {/if}"/>
                    </span>
                </div>
                <div>
                    <span>
                        <div style='float:left; width:80px;'><label for="cont">Message:</label></div>
                        <textarea  name="cont" id="cont" ></textarea>
                    </span>
                </div>
                <div>
                    <span>
                        <div style='float:left; width:80px;'><label>&nbsp;</label></div>
                        <input type="submit" name="submit" id="button" value="Send" class="frmbtn"/>
                        <input type="reset" name="reset" id="button" value="Clear" class="frmbtn"/>
                        <input type="hidden" name="email" id="email" size="30" value="{$email}"/>
                        <input type="hidden" name="privacy_type" id="privacy_type" value="private" />
                        <input type="hidden" name="sender_type" id="sender_type" value="people" />
                        <input type="hidden" name="cont_id" id="cont_id" value="{$uid}" />
                        <input type="hidden" name="fid" id="fid" value="{$fid}" />
                        <input type="hidden" name="cont_type" id="cont_type" value="users" />
                    </span>
                </div>
            </fieldset>
        </form>
    </div>
</div>

<div style="float:left; width:740px;margin-top:10px;">
    <div id="viewmsg">
        <div>
            <span>
                {if $boxtype == "inbox"}
                    <div style="float:left; width:80px;"><strong>From:</strong></div>
                    <div width="85">{$msg.sndr_name|default:"Club"}</div>
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
            <div id="cont"><br/>{$msg.content}</div>
        </div>
        <div>
            <span>&nbsp;</span>
        </div>
        <div style="float:left;">
            <span align="left"><h3>
            {if $boxtype == "inbox"}
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
       $("#errors").hide();
       $("#frmnewmsg").validate({
       errorLabelContainer: "#errors",
       wrapper: "p",
           rules:{
               to:{ required: true, maxlength: 2500},
               subj:{ maxlength: 80 },
               cont:{ minlength: 1 , maxlength: 3000}
           },
           messages:{
               to: {
                   required: "You must specify at least one recipient for this message.",
                   maxlength: "The 'To' field can not be more than 2500 characters"
               },
               subj: {
                    maxlength: "The 'Subject' field can not be more than 80 characters"
               },
               cont: {
                   //required: "You can not send an empty message.",
                   minlength: "You can not send an empty message.",
                   maxlength: "Content can not be more than 3000 characters long"
               }
           }
       });
   });
</script>
{/literal}

{literal}
    <script type="text/javascript">
        tinyMCE.init({
            mode : "exact",
            elements : "cont",
            theme : "advanced",
            skin : "o2k7",
            width : 570,
            height : 300,
            skin_variant : "silver",
            plugins : "safari,spellchecker,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template",        
            theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,undo, redo,|,link,unlink,anchor,|,forecolor,backcolor,|,charmap,emotions,|,bullist,numlist",
            theme_advanced_buttons2 : "",
            theme_advanced_buttons3 :  "", 
            theme_advanced_toolbar_location : "top",
            theme_advanced_toolbar_align : "left",
            theme_advanced_statusbar_location : "bottom",
            plugin_insertdate_dateFormat : "%Y-%m-%d",
            plugin_insertdate_timeFormat : "%H:%M:%S",
            extended_valid_elements : "hr[class|width|size|noshade]",
            paste_use_dialog : false,
            theme_advanced_resizing : false,
            theme_advanced_link_targets : "_something=My somthing;_something2=My somthing2;_something3=My somthing3;",
            apply_source_formatting : true
        });
    </script>
{/literal}