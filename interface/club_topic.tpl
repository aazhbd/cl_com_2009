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
    <img src="{$smarty.const.URL}/getimage.php?id={$club_img_id}" width="80" alt="{$club_name}, conveylive.com, club" />
    <a href="{$smarty.const.URL}/clubs/topics/{$club_id}">Club Topics</a>&nbsp;|&nbsp;<a href="{$smarty.const.URL}/clubs/view/{$club_id}">Back to Club</a>
</div>

<form method="post" action="{$smarty.const.URL}/submitclubtopic.php" id="frmpost" >
    <fieldset>
        <legend>Post a new topic</legend>
        <input type="hidden" name="atype" id="atype" value="{$atype}"/>
        <input type="hidden" name="email" id="email" value="{$email}"/>
        <input type="hidden" name="club_id" id="club_id" value="{$club_id}"/>
        <input type="hidden" name="club_name" id="club_name" value="{$club_name}"/>
        <div>
            <span>
                <div style="float:left; width: 150px;"><label for="arttitle">Subject: </label>(required)</div>
                <input type="text" name="arttitle" size="65" id="arttitle" value=""/>
                <div style="margin-left:150;">Maximum 100 characters</div>
            </span>
        </div>
        <div>
            <span>
                <p><label for="bodytxt">Post: </label>(required)</p>
                <textarea id="bodytxt" name="bodytxt" id="bodytxt"  style="width:100%" ></textarea>
                <div>Maximum 16777216 characters</div>
            </span>
        </div>
        <div>
            <input type="submit" name="submit" value="Post New Topic" class="frmbtn" />
            <a href="{$smarty.const.URL}/clubs/view/{$club_id}">Cancel</a>
        </div>
        <div>
            <span>
                <div><label for="keywords">Keywords: </label></div>
                <textarea id="keywords" name="keywords" style="width:100%" cols="60" rows="8" ></textarea>
                <div>Maximum 200 characters</div>
            </span>
        </div>
    </fieldset>
</form>
</div>
{literal}
<script type="text/javascript">
   $(document).ready(function(){       
       $("#frmpost").validate({
           errorLabelContainer: "#errors",
           wrapper: "p",
           rules:{
               bodytxt: { maxlength: 16777216, minlength: 1 },
               arttitle: { required: true, maxlength: 100, minlength: 1 },
               keywords: { maxlength: 200}
           },
           messages:{
               bodytxt: {
                        required: "You can not publish blank post. Please enter your text.",
                        maxlength: "You can not put more than 16777216 characters for post. Please shorten your content."
               },
               arttitle: { 
                        required: "Please write the subject for this post",
                        maxlength: "The title should be within 100 characters",
                        minlength: "Please write the title for this article"
               },
               keywords: { 
                        maxlength: "The keywords should be within 200 characters" 
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
            elements : "bodytxt",
            theme : "advanced",
            skin : "o2k7",
            width : "700",
            height : "400",
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