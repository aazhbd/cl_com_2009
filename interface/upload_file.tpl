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

    <form method="post" action="{$smarty.const.URL}/saveclubfile.php" id="frmclubfile" enctype="multipart/form-data" >
        <fieldset>
            <legend>Add files</legend>
            <input type="hidden" name="email" id="email" value="{$email}"/>
            <input type="hidden" name="club_id" id="club_id" value="{$club_id}"/>
            <input type="hidden" name="club_name" id="club_name" value="{$club_name}"/>
            <div>
                <span>
                    <div style="float:left; width:90px;"><label for="category">Category: </label></div>
                    <select name='category' id='category' >
                        {foreach item=cat from=$catList}
                            <option value='{$cat.id}'>{$cat.cname}</option>
                        {/foreach}
                    </select>
                </span>
            </div>
            <div>
                <span>
                    <input type="hidden" name="MAX_FILE_SIZE" value="20971520" />
                    <div style="float:left;width:90px;"><label for="clubfile">File:</label></div>
                    <input type="file" name="clubfile" id="clubfile" size="20" value="" />
                    <div class="subinfo">File size limit 20 MB. If your upload does not work, try a smaller file.</div>
                </span>
            </div>
            <div>
                <span>
                    <input name="submit" type="submit" value="Upload and Share Files" class="frmbtn" />&nbsp;   <a href="{$smarty.const.URL}/clubs/view/{$club_id}">Cancel</a>
                </span>
            </div>
        </fieldset>
    </form>
</div>
{literal}
<script type="text/javascript">
   $(document).ready(function(){       
       $("#frmclubfile").validate({
           errorLabelContainer: "#errors",
           wrapper: "p",
           rules:{
               clubfile: { required: true, accept: "doc|docx|ppt|pptx|xls|xlsx|mpp|mpx|csv|txt|rtf|pdf|odf|zip" },
               category: { required: true }
           },
           messages:{
               clubfile: { 
                   accept: "Please upload files with doc, docx, ppt, pptx, xls, xlsx, mpp, mpx, csv, txt, rtf, pdf, odf, zip extensions",
                   required: "Please select a file to upload"
               },
               category: { 
                   required: "Please select a category for this file you want to upload" 
               }
           }
       });
   });
</script>
{/literal}