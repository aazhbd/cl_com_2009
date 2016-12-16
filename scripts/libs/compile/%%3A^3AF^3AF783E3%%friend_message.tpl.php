<?php /* Smarty version 2.6.26, created on 2010-02-06 06:05:33
         compiled from friend_message.tpl */ ?>
<div style="float:left;width:740px;">
    <div id="errors"></div>
    
    <div style="float:left;width:100%;">
        <span align="left">
            <h3>
                <a href="<?php echo @URL; ?>
/message/inbox"><img src="<?php echo @URL; ?>
/interface/icos/mail_receive.png" style="width:20px;"/>Inbox</a>&nbsp;&nbsp;&nbsp;
                <a href="<?php echo @URL; ?>
/message/sentmessages"><img src="<?php echo @URL; ?>
/interface/icos/mail_send.png"  style="width:20px;" />Sent Messages</a>&nbsp;&nbsp;&nbsp;
                <a href="<?php echo @URL; ?>
/message/new"><img src="<?php echo @URL; ?>
/interface/icos/mail_new.png"  style="width:20px;" />New Message</a>&nbsp;&nbsp;&nbsp;
            </h3>
        </span>
    </div>
    <br />
    <div style="float:left;width:740px;margin-top:10px;">
        <form name="frmnewmsg" id="frmnewmsg" method="post" action="<?php echo @URL; ?>
/newmessage.php">
            <fieldset>
                <legend>Write a reply</legend>
                <div>
                    <span>
                        <div style='float:left; width:80px;'>
                            <label>To:</label>
                        </div>
                        <input type="text" name="to" id="fname" value="<?php echo $this->_tpl_vars['fname']; ?>
" style="width:570px;color:black; background:#eee;font-weight:bold;" disabled="disabled"/>
                    </span>
                </div>
                <div>
                    <span>
                        <div style='float:left; width:80px;'>
                            <label>Subject:</label>
                        </div>
                        <input type="text" name="subj" id="subj" style="width:570px;color:black;" value=""/>
                    </span>
                </div>
                <div>
                    <span>
                        <div style='float:left; width:80px;'>
                            <label for="cont">Message:</label>
                        </div>
                        <textarea  name="cont" id="cont" ></textarea>
                    </span>
                </div>
                <div>
                    <span>
                        <div style='float:left; width:80px;'><label>&nbsp;</label></div>
                        <input type="submit" name="submit" id="button" value="Send" class="frmbtn"/>
                        <input type="reset" name="reset" id="button" value="Reset" class="frmbtn"/>
                        <input type="hidden" name="email" id="email" size="30" value="<?php echo $this->_tpl_vars['email']; ?>
"/>
                        <input type="hidden" name="privacy_type" id="privacy_type" value="private" />
                        <input type="hidden" name="sender_type" id="sender_type" value="people" />
                        <input type="hidden" name="cont_id" id="cont_id" value="<?php echo $this->_tpl_vars['uid']; ?>
" />
                        <input type="hidden" name="fid" id="fid" value="<?php echo $this->_tpl_vars['fid']; ?>
" />
                        <input type="hidden" name="cont_type" id="cont_type" value="users" />
                    </span>
                </div>
            </fieldset>
        </form>
    </div>
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
                   //required: "You can not send an empty message.",
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
        // General options
        mode : "exact",
        elements : "cont",
        theme : "advanced",
        skin : "o2k7",
        skin_variant : "silver",
        width : 570,
        height : 300,
        plugins : "safari,spellchecker,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template",

        // Theme options
        theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,undo, redo,|,link,unlink,anchor,|,forecolor,backcolor,|,charmap,emotions,|,bullist,numlist",
        theme_advanced_buttons2 : "",
        theme_advanced_buttons3 : "",
        theme_advanced_buttons4 : "",
        theme_advanced_toolbar_location : "top",
        theme_advanced_toolbar_align : "left",
        theme_advanced_statusbar_location : "bottom",
        theme_advanced_resizing : false,
        // Drop lists for link/image/media/template dialogs
        template_external_list_url : "js/template_list.js",
        external_link_list_url : "js/link_list.js",
        external_image_list_url : "js/image_list.js",
        media_external_list_url : "js/media_list.js"
    });
</script>
'; ?>