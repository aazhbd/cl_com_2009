<?php /* Smarty version 2.6.26, created on 2010-01-23 23:41:54
         compiled from video_form.tpl */ ?>
<?php $id = $_GET['id']; ?>
<?php echo '
<script type="text/javascript">
    $(document).ready(function() {
        $("#reps").hide();
    });
</script>
'; ?>

<div style="width:745px;">
    <div id="reps"></div>
    <div id="pginfo">
        You can publish your videos such as home videos that are funny, educational, or amazing. Select any of the categories from the list and publish your videos. Your videos will be publicly visible to all members of conveylive aswell as the world.
    </div>
    
    <form method="post" action="<?php echo @URL; ?>
/submitvideo.php" id="frmvideo" enctype="multipart/form-data" >
        <fieldset>
            <legend>Add Video</legend>
            <div>
                <span>
                    <div style="float:left; width:80px;">
                        <label for="video">Video File :</label>
                    </div>
                    <input type="hidden" name="MAX_FILE_SIZE" value="20971520" />
                    <input type="file" name="video" id="video" size="20" value="" />
                </span>
                <span>
                    <label for="cat_id">Category : </label>
                    <select name='cat_id' id='cat_id'>
                        <?php if ($this->_tpl_vars['video']['category'] == null): ?>
                            <option value='' selected="selected" style="color:#CCC">Select</option>
                        <?php endif; ?>
                        <?php $_from = $this->_tpl_vars['videoList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['cat']):
?>
                            <?php if ($this->_tpl_vars['video']['category'] == $this->_tpl_vars['cat']['cname']): ?>
                                <option selected="selected" value='<?php echo $this->_tpl_vars['cat']['id']; ?>
' style="color:#06F"><?php echo $this->_tpl_vars['cat']['cname']; ?>
</option>
                            <?php else: ?>
                                <option value='<?php echo $this->_tpl_vars['cat']['id']; ?>
'><?php echo $this->_tpl_vars['cat']['cname']; ?>
</option>
                            <?php endif; ?>
                        <?php endforeach; endif; unset($_from); ?>
                    </select>
                </span>
                <div style="float:left;" class="subinfo">File size limit is 20 MB. Allowed extensions .flv, .mp4, .mpeg, .wmv, .avi, .mpg, .mov, .ogg or .asf </div>
            </div>
            <div>
                <span>
                    <div style="float:left; width:80px;"><label for="videotitle">Title : </label></div>
                    <input type="text" name="videotitle" id="videotitle" style="width:600px;" value="<?php echo $this->_tpl_vars['video']['title']; ?>
"/>
                    <div class="subinfo"> Maximum 100 characters</div>
                </span>
            </div>
            <div>
                <span>
                    <label for="artist">Artist(s): </label>
                    <textarea id="artist" name="artist" rows="3" style="width:700px;"><?php echo $this->_tpl_vars['video']['artist']; ?>
</textarea>
                    <div class="subinfo">Maximum 200 characters</div>
                </span>
            </div>
            <div>
                <span>
                    <?php if ($this->_tpl_vars['action'] == 'insert'): ?>
                        <input type="submit" value="Publish" class="frmbtn"/>
                    <?php endif; ?>
                    <?php if ($this->_tpl_vars['action'] == 'update'): ?>
                        <input type="submit" value="Edit" class="frmbtn"/>
                    <?php endif; ?>
                    <input type="reset" value="Reset" class="frmbtn" />
                    <input type="hidden" value="<?php echo $this->_tpl_vars['action']; ?>
" name="action" />
                </span>
            </div>
            <br />
            <div style="float:left; width:700px;">
                <span style="float:left;">
                    <label for="meta_tags">Keywords: </label><br />
                    <textarea id="meta_tags" name="meta_tags" style="width:320px;" rows="8" ><?php echo $this->_tpl_vars['video']['meta_tags']; ?>
</textarea>
                    <div style="width:320px;" class="subinfo">Maximum 200 characters. Seperate your keywords with comma (,) to make it available to the search engines</div>
                </span>
                <span style="float:right;">
                    <label for="additional">Additional: </label><br />
                    <textarea id="additional" name="additional" style="width:310px;" rows="8" ><?php echo $this->_tpl_vars['video']['additional']; ?>
</textarea>
                    <div style="width:320px;" class="subinfo">Maximum 200 characters</div>
                </span>
            </div>
        </fieldset>
    </form>
</div>
<?php echo '
<script type="text/javascript">

    $(document).ready(function(){
        $("#frmvideo").validate({
            submitHandler: function(form) {
                $(form).ajaxSubmit({
                    success: function(response, status) {
                        $("#reps").html($("#errors", response).html());
                        $("#reps").append($("#reports", response).html());
                        $("#reps").show();
                        $("input[type=\'submit\']", form).attr(\'disabled\', \'\');
                        $("input[type=\'submit\']", form).attr(\'value\', \'Upload\');
                    },
                    beforeSubmit: function() {
                        $("input[type=\'submit\']", form).attr(\'disabled\', \'disabled\');
                        $("input[type=\'submit\']", form).attr(\'value\', \'Please wait...\');
                    }
                });
                return false;
            },

            errorLabelContainer: "#reps",
            wrapper: "p",
            rules: {
                video: { required: true, accept: "flv|mp4|mpeg|wmv|avi|mpg|mov|ogg|asf" },
                cat_id: { required: true },
                videotitle: { required: true, maxlength: 100 },
                artist: { maxlength: 200 },
                additional: { maxlength: 200 },
                meta_tags: { maxlength: 200 }
            },
            messages: 
            {
                video: 
                {
                    required: "Select a video file to upload",
                    accept: "Please upload files with .flv or .mp4 or .mpeg or .wmv or .avi or .mpg or .mov or .ogg or .asf extensions"
                },
                cat_id: 
                { 
                    required: "Select category for this video to upload" 
                },
                videotitle: {
                    required: "Please write the title for this audio",
                    maxlength: "The title should be within 100 characters"
                },
                artist: {
                    maxlength: "The artist name should be within 200 characters"
                },
                additional: {
                    maxlength: "The additional information should be within 200 characters"
                },
                meta_tags: {
                    maxlength: "The keywords should be within 200 characters"
                }
            }
        });
    });
    
</script>
'; ?>