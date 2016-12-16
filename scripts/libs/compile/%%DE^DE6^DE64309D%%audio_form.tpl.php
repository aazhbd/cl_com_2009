<?php /* Smarty version 2.6.26, created on 2010-07-02 00:05:18
         compiled from audio_form.tpl */ ?>
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
        You can publish your personal audio collections of any number, be it the song sung by you, your friends or any personal collection of audio that you want to let the world listen to. You should mention the name of the artist who sung the song or whose voice it is or who played the instruments in an audio if known.
    </div>
    
    <form style="width:745px;" method="post" action="<?php echo @URL; ?>
/submitaudio.php" id="frmaudio" enctype="multipart/form-data">
        <fieldset>
            <legend>Add Audio</legend>
            <div>
                <?php if ($this->_tpl_vars['action'] == 'insert'): ?>
                    <span style="float:left; width:320px;">
                        <div style="float:left; width:90px;">
                            <label for="audio">Audio File:</label>
                        </div>
                        <input type="hidden" name="MAX_FILE_SIZE" value="94371840" />
                        <input type="file" name="audio" id="audio" value="" style="width:200px;"/>
                        <div style="width:300px;" class="subinfo">Upload mp3 files only with size limit 9 MB</div>
                    </span>
                <?php endif; ?>
                <span style="float:left;">
                    <label for="cat_id">Genre: </label>
                    <select name='cat_id' id='cat_id'>
                        <?php if ($this->_tpl_vars['audio']['genre'] == null): ?>
                            <option value='' selected="selected" style="color:#CCC">Select</option>
                        <?php endif; ?>
                        <?php $_from = $this->_tpl_vars['genreList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['genre']):
?>
                            
                            <?php if ($this->_tpl_vars['audio']['genre'] == $this->_tpl_vars['genre']): ?>
                                <option selected="selected" value='<?php echo $this->_tpl_vars['genre']['id']; ?>
' style="color:#636;"><?php echo $this->_tpl_vars['genre']['cname']; ?>
</option>
                            <?php else: ?>
                                <option value='<?php echo $this->_tpl_vars['genre']['id']; ?>
'><?php echo $this->_tpl_vars['genre']['cname']; ?>
</option>
                            <?php endif; ?>
                        <?php endforeach; endif; unset($_from); ?>
                    </select>
                </span>
            </div>
            <div>
                <span>
                    <div style="float:left; width:90px;">
                        <label for="audiotitle">Title : </label>
                    </div>
                    <input type="text" name="audiotitle" id="audiotitle" style="width:610px;" value="<?php echo $this->_tpl_vars['audio']['title']; ?>
"/>
                    <div class="subinfo"> Maximum 100 characters</div>
                </span>
            </div>
            <div>
                <span>
                    <div style="float:left; width:90px;">
                        <label for="artist">Artist(s): </label>
                    </div>
                    <textarea id="artist" name="artist" cols="50" rows="3" style="width:610px;"><?php echo $this->_tpl_vars['audio']['artist']; ?>
</textarea>
                    <div class="subinfo">Maximum 200 characters</div>
                </span>
            </div>
            <div>
                <span style="width:500px;">
                    <?php if ($this->_tpl_vars['action'] == 'insert'): ?>
                    <input type="submit" value="Publish" class="frmbtn"/>
                    <?php endif; ?>
                    <?php if ($this->_tpl_vars['action'] == 'update'): ?>
                    <input type="submit" value="Edit" class="frmbtn"/>
                    <?php endif; ?>
                    <input type="reset" name="reset" id="reset" value="Reset" class="frmbtn" />
                    <input type="hidden" value="<?php echo $this->_tpl_vars['action']; ?>
" name="action" />
                </span>
            </div>
            <div style="float:left;width:720px;">
                <span style="float:left;">
                    <label for="meta_tags">Keywords: </label><br />
                    <textarea id="meta_tags" name="meta_tags" style="width:320px;" rows="8" ><?php echo $this->_tpl_vars['audio']['meta_tags']; ?>
</textarea>
                    <div style="width:250px;" class="subinfo">Maximum 200 characters. Seperate your keywords with comma (,) to make it available to the search engines</div>
                </span>
                <span style="float:right;">
                    <label for="additional">Additional: </label><br />
                    <textarea id="additional" name="additional" style="width:335px;" rows="8" ><?php echo $this->_tpl_vars['audio']['additional']; ?>
</textarea>
                    <div style="width:250px;" class="subinfo">Maximum 200 characters</div>
                </span>
            </div>
        </fieldset>
    </form>
</div>

<?php echo '
<script type="text/javascript">
    $(document).ready(function()
    {
        $("#frmaudio").validate(
        {
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
                audio: { required: true, accept: "mp3" },
                cat_id: { required: true },
                audiotitle: { required: true, maxlength: 100, minlength: 1 },
                artist: { required: true, maxlength: 200,  minlength: 1 },
                additional: { maxlength: 200 },
                meta_tags: { maxlength: 200 }
            },
            messages: {
                audio: {
                    required: "Select an audio file to upload",
                    accept: "Please upload files with mp3 extensions"
                },
                cat_id: { required: "Select genre for this audio to upload" },
                audiotitle: {
                    required: "Please write the title for this audio",
                    maxlength: "The title should be within 100 characters",
                    minlength: "Please write the title for this audio"
                },
                artist: {
                    required: "Please put atleast one name of the artist/band for this audio",
                    maxlength: "The artist name should be within 200 characters",
                    minlength: "Please write the title for this audio"
                },
                additional: {
                    maxlength: "The additional information should be within 200 characters"
                },
                meta_tags: {
                    maxlength: "The Keywords should be within 200 characters"
                }
            }
        });
    });
</script>
'; ?>