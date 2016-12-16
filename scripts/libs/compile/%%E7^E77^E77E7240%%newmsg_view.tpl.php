<?php /* Smarty version 2.6.26, created on 2010-01-15 05:45:07
         compiled from newmsg_view.tpl */ ?>
<div style="width:740px;">
    <div id="errors"></div>
     
    <div id="pginfo">
        From here you can send message to all your friends.
    </div>
    <div><a href="<?php echo @URL; ?>
/message/inbox">Inbox</a>&nbsp;|&nbsp;<a href="<?php echo @URL; ?>
/message/sentmessages">Sent Messages</a></div>

    <br />
    <form name="frmnewmsg" id="frmnewmsg" method="post" action="<?php echo @URL; ?>
/newmessage.php">
        <fieldset>
            <legend><?php if ($this->_tpl_vars['msg']['user_email'] != ""): ?> Write a reply<?php else: ?>Compose new message<?php endif; ?></legend>
            <div>
                <span>
                    <div style='float:left; width:60px;'>
                        <label>To:</label>
                    </div>
                    <div style="float:left;width:630px;"><input type="text" name="to" id="to" style="width:566px;" value="" /></div>
                </span>
            </div>
            <div>
                <span>
                    <div style='float:left; width:60px;'><label>Subject:</label></div>
                    <input type="text" name="subj" id="subj" style="width:566px;" value="<?php if ($this->_tpl_vars['msg']['subj'] != ""): ?>Reply: <?php echo $this->_tpl_vars['msg']['subj']; ?>
 <?php else: ?> <?php endif; ?>"/>
                </span>
            </div>
            <div>
                <span>
                    <div style='float:left; width:80px;'><label for="cont">Message:</label></div>
                    <div style='float:left; width:700px;'><textarea  name="cont" id="cont" ></textarea></div>
                </span>
            </div>
            <div>
                <span>
                    <input type="submit" name="submit" id="button" value="Send" class="frmbtn"/>
                    <input type="reset" name="reset" id="button" value="Clear" class="frmbtn"/>
                    <input type="hidden" name="email" id="email" size="30" value="<?php echo $this->_tpl_vars['email']; ?>
"/>
                    <input type="hidden" name="privacy_type" id="privacy_type" value="private" />
                    <input type="hidden" name="sender_type" id="sender_type" value="people" />
                    <input type="hidden" name="cont_id" id="cont_id" value="<?php echo $this->_tpl_vars['uid']; ?>
" />
                    <input type="hidden" name="cont_type" id="cont_type" value="users" />
                </span>
            </div>
        </fieldset>
    </form>
</div>
<?php echo '
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
                   maxlength: "The \'To\' field can not be more than 2500 characters"
               },
               subj: {
                    maxlength: "The \'Subject\' field can not be more than 80 characters"
               },
               cont: {
                   minlength: "You can not send an empty message.",
                   maxlength: "Content can not be more than 3000 characters long"
               }
           }
       });
   });
</script>
'; ?>


<?php echo '
    <script type="text/javascript">
        tinyMCE.init({
            mode : "exact",
            elements : "cont",
            theme : "advanced",
            skin : "o2k7",
            width : 700,
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
'; ?>