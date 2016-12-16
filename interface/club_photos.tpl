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
    <a href="{$smarty.const.URL}/clubs/view/{$club_id}">Back to Club</a>
</div>
{*include file="subtpl/had.tpl"*}
<form method="post" action="{$smarty.const.URL}/saveclubphoto.php" id="frmclubphoto" enctype="multipart/form-data" >
<fieldset>
        <legend>Add a new photo to this club</legend>
        <input type="hidden" name="email" id="email" value="{$email}"/>
        <input type="hidden" name="club_id" id="club_id" value="{$club_id}"/>
        <div>
            <span>
                <input type="hidden" name="MAX_FILE_SIZE" value="1048576" />
                <div style="width:120px;"><label for="clubphoto">Club Photo:</label></div>
                <input type="file" name="clubphoto" id="clubphoto" size="20" value="" />
                <br/>
                <p>File size limit 1 MB. If your upload does not work, try a smaller picture.</p>
            </span>
        </div>
        <div>
            <span>
                <div><input name="submit" type="submit" value="Add Photos" class="frmbtn" />&nbsp;   <a href="{$smarty.const.URL}/clubs/view/{$club_id}">Cancel</a></div>
            </span>
        </div>
    </fieldset>
</form>
</div>
{literal}
<script type="text/javascript">
   $(document).ready(function(){       
       $("#frmclubphoto").validate({
           errorLabelContainer: "#errors",
           wrapper: "p",
           rules:{
               clubphoto: { required: true, accept: "jpeg|jpg|gif|GIF|JPEG|JPG" }
           },
           messages:{
               clubphoto: { 
                            required: "You must chose a photo to upload",
                            accept: "Please upload files with jpeg or jpg or gif or GIF or JPEG or JPG extensions" 
               }
           }
       });
   });
</script>
{/literal}