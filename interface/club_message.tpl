
{literal}
<script type="text/javascript">
   $(document).ready(function(){
       $("#errors").hide();
   });
</script>
{/literal}
<div style="width:730px;">
    <div id="errors"></div>
    <div>
        <img src="{$smarty.const.URL}/getimage.php?id={$club.image_id}" width="80" alt="{$club.name}, conveylive.com, club" />
        <a href="{$smarty.const.URL}/clubs/view/{$club.id}">Back to Club</a>
        <br />
    </div>
    <br />
    <div style="float:left; width:730px;">
        <form id="frmnewmsg" method="post" action="{$smarty.const.URL}/clubmessage.php">
            <fieldset>
                <legend>Send a Message to all members</legend>
                <input type="hidden" name="id_list" id="id_list" value="{$id_list}" />
                <input type="hidden" name="club_id" id="club_id" value="{$club.id}" />
                <div>
                    <span>
                        <div style="float:left; width:80px;"><label for="subj">Subject:</label></div>
                        <input type="text" name="subj" id="subj" size="75" value="{if $msg.subj neq ""}Reply: {$msg.subj} {else} {/if}"/>
                    </span>
                </div>
                <div>
                    <span>
                        <div><label for="cont">Message:</label></div>
                        <div><textarea  name="cont" id="cont" rows="8" cols="85" ></textarea></div>
                    </span>
                </div>
                <div>
                    <span align="left">
                        <input type="submit" name="submit" id="button" value="Send" class="frmbtn"/>
                        <input type="reset" name="reset" id="button" value="Clear" class="frmbtn"/>
                        <input type="hidden" name="email" id="email" size="30" value="{$email}"/>
                    </span>
                </div>
            </fieldset>
        </form>
    </div>
</div>
{literal}
<script type="text/javascript">
   
   $(document).ready(function(){      
       $("#frmnewmsg").validate({
       errorLabelContainer: "#errors",
       wrapper: "p",
           rules:{
               subj:{ maxlength: 80 },
               cont:{ required: true, minlength: 1 , maxlength: 3000}
           },
           messages:{
               subj: {
                    maxlength: "The 'Subject' field can not be more than 80 characters",
               },
               cont: {
                   required: "You must type a message to send",
                   minlength: "You can not send an empty message.",
                   maxlength: "Content can not be more than 3000 characters long"
               }
           }
       });
   });
</script>
{/literal}
{literal}
    <script language="javascript" type="text/javascript">
        tinyMCE.init({
            mode : "exact",
            elements : "cont",
            theme : "advanced",
            skin : "o2k7",
            width : "700",
            height : "300",
            skin_variant : "silver",
            plugins : "safari,spellchecker,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,imagemanager,filemanager",        
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