<?php /* Smarty version 2.6.26, created on 2010-02-15 10:21:51
         compiled from frm_comment.tpl */ ?>
<form id="frmcmt" method="post">
    <fieldset>
        <legend>Add your comment</legend>
        <div>
            <input type="hidden" name="artid" id="artid" value="<?php echo $this->_tpl_vars['mid']; ?>
" />
            <input type="hidden" name="mtype" id="mtype" value="<?php echo $this->_tpl_vars['mtype']; ?>
" />
            <input type="hidden" name="uemail" id="uemail" value="<?php echo $this->_tpl_vars['email']; ?>
" />
            <textarea id="comment" name="comment" style="width:700px;height:150px;" rows="5" ></textarea>
        </div>
        <div>
            <input type="submit" value="Add Comments" class="frmbtn" id="cmtpost" />
        </div>
    </fieldset>
</form>
<?php echo '
<script type="text/javascript">
$(document).ready(function()
{
    $(\'#cmtpost\').click(function(){
        var cmt = $(\'#comment\').val();
        var aid = $(\'#artid\').val();
        var mt = $(\'#mtype\').val();
        var ue = $(\'#uemail\').val();
        var ins = \'insert\';
        var dataString = \'cmt=\'+cmt+\'&aid=\'+aid+\'&mt=\'+mt+\'&ue=\'+ue+\'&ins=\'+ins;
        if(cmt.length == 0)
        {
            alert("You can not publish blank comment. Please type your comment.");
            return false;
        }
        if(cmt.length > 2499)
        {
            alert("You can not put more than 2499 characters for comment. Please shorten your comment.");
            return false;
        }
        var aurl = site.url + "/cmtprocess.php";
        
        $.ajax({
            type: "POST",
            url: aurl,
            data: dataString,
            cache: false,
            dataType: "html",
            success: function(response){
                $("#comlist").fadeIn(400).html(response);
                $(\'#comment\').val("");
            }
        });
        return false;
    });
    
    $(\'a#removecmt\').click(function(){
        var link = $(this).attr("href");
        var qpos = link.indexOf(\'?\');
        var param = link.substring(qpos + 1);
        var rem = "remove";
        
        var mid = $(\'#artid\').val();
        var mt = $(\'#mtype\').val();
        
        var dataString = param +\'&rem=\'+rem+\'&mid=\'+mid+\'&mt=\'+mt;
        
        var aurl = site.url + "/cmtprocess.php";
        
        $.ajax({
            type: "POST",
            url: aurl,
            data: dataString,
            cache: false,
            dataType: "html",
            success: function(response){
                $("#comlist").fadeIn(400).html(response);
            }
        });
        return false;
    });
});
</script>
'; ?>
