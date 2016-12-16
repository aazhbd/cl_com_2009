<?php /* Smarty version 2.6.26, created on 2010-01-22 15:10:10
         compiled from album_form.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'album_form.tpl', 125, false),)), $this); ?>
<?php echo '
<script type="text/javascript">
   $(document).ready(function(){
       $("#errors").hide();
   });
</script>
'; ?>

<div style="width:730px;">   
<div id="errors"></div>
<div id="pginfo">
    You can publish your personal photo albums of tours, birthday parties, convocation, friends and families, rare collection of photos, artwork etc to share with the community of conveylive.
</div>
<form method="post" action="<?php echo @URL; ?>
/submitalbum.php" id="frmalbum" enctype="multipart/form-data">
    <fieldset>
        <legend>Create New Album</legend> 
        <input type="hidden" name="category_id" id="category_id" value="<?php echo $this->_tpl_vars['category_id']; ?>
" />
        <div>
            <span>
                <div style="float:left; width:100px;">
                    <label for="albumname">Album Name:</label>
                </div>
                <input type="text" name="albumname" id="albumname" style="width:550px;" />
                <div class="subinfo"> Maximum 50 characters</div>
            </span>
        </div>
        <div>
            <span>
                <div style="float:left; width:100px;">
                    <label for="remarks">Remarks:</label>
                </div>
                <textarea name="remarks" id="remarks" style="width:550px;" rows="8" ></textarea>
                <div class="subinfo"> Maximum 200 characters</div>
            </span>
        </div>
        <div>
            <span>
                <div style="float:left; width:100px;">
                    <label for="picture">Photo:</label>
                </div>
                <input type="hidden" name="MAX_FILE_SIZE" value="2097152" />
                <input type="file" name="picture" id="picture" size="20" value="" />
                <div class="subinfo">File size limit 2 MB. If your upload does not work, try a smaller picture.</div>
            </span>
        </div>
        <div>
            <span>
                <div style="float:left; width:100px;"><label for="privacy">Privacy:</label></div>
                <select name='privacy' />
                   <option value='0' selected="selected">Everybody</option>
                   <option value='1'>Only Friends</option>
                </select>
            </span>
        </div>
        <div>
            <span style="padding-left:100px; ">
                <input type="submit" name="submit" class="frmbtn" value="Create Album" />
                <input type="reset" name="reset" id="reset" value="Reset" class="frmbtn" />
                <a href="<?php echo @URL; ?>
/home">Cancel</a>
            </span>
        </div>
    </fieldset>
</form>
<br />

<?php if ($this->_tpl_vars['createImage'] == true): ?>
<?php if ($this->_tpl_vars['albums'] != null): ?>
<form method="post" action="<?php echo @URL; ?>
/submitalbum.php" id="frmimg" enctype="multipart/form-data" >
    <fieldset>
        <legend>Add Album Images</legend>
        <div>You can upload maximum <?php echo $this->_tpl_vars['max_img']; ?>
 images per album. </div>
        <div>
            <span>
                <div style="float:left; width:100px;">
                    <label for="aid">Album:</label>
                </div>
                <select name="aid" id="aid">
                    <?php $_from = $this->_tpl_vars['albums']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['album']):
?>
                        <?php if ($this->_tpl_vars['album']['id'] == $this->_tpl_vars['aid']): ?>
                            <option value="<?php echo $this->_tpl_vars['album']['id']; ?>
" selected="selected"><?php echo $this->_tpl_vars['album']['album_name']; ?>
 (<?php echo $this->_tpl_vars['album']['tot']; ?>
)</option>
                        <?php else: ?>
                            <option value="<?php echo $this->_tpl_vars['album']['id']; ?>
" <?php if ($this->_tpl_vars['album']['album_name'] == 'Profile' && $this->_tpl_vars['aid'] == null): ?> selected="selected" <?php endif; ?> ><?php echo $this->_tpl_vars['album']['album_name']; ?>
 (<?php echo $this->_tpl_vars['album']['tot']; ?>
)</option>
                        <?php endif; ?>
                    <?php endforeach; endif; unset($_from); ?>
                </select>
            </span>
        </div>
        <div>
            <span>
                <div style="float:left; width:100px;">
                    <label for="picture">Photo:</label>
                </div>
                <input type="hidden" name="MAX_FILE_SIZE" value="2097152" />
                <input type="file" name="picture" id="picture" size="20" value="" />
                <label><input type="checkbox" name="frontimg[]" id="frontimg[]" size="20" value="1" /><span class="subinfo">Set this photo as album cover</span></label>
                <div class="subinfo">File size limit 2 MB. If your upload does not work, try a smaller picture.</div>
            </span>
        </div>
        <div>
            <span style="padding-left:100px; ">
                <input type="submit" name="submit" class="frmbtn" value="Add Picture" />
                <input type="reset" name="reset" id="reset" value="Reset" class="frmbtn" />
                <a href="<?php echo @URL; ?>
/home">Cancel</a>
            </span>
        </div>
    </fieldset>
</form>
<?php endif; ?>
<?php endif; ?>

<?php if ($this->_tpl_vars['albums'] != null): ?>
    <br />
    <h3>Your Albums</h3>
    <br />
    <div style="float:left; width:730px;">    
        <center>
            <div style="width:720px;">
                <?php $_from = $this->_tpl_vars['albums']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['album']):
?>
                    <?php if ($this->_tpl_vars['album']['image_id'] == 0): ?>
                    <div class="album">
                        <div class="browsealbums">
                            <center>
                                <a href='<?php echo @URL; ?>
/picture/albumview/<?php echo $this->_tpl_vars['album']['id']; ?>
'><img src='<?php echo @URL; ?>
/interface/icos/albumimg.gif.' style="max-height:100px;" alt="<?php echo $this->_tpl_vars['album']['album_name']; ?>
, conveylive" /></a>
                                <h3><a href='<?php echo @URL; ?>
/picture/albumview/<?php echo $this->_tpl_vars['album']['id']; ?>
'><?php echo $this->_tpl_vars['album']['album_name']; ?>
</a></h3>
                                <?php echo ((is_array($_tmp=$this->_tpl_vars['album']['ins_date'])) ? $this->_run_mod_handler('date_format', true, $_tmp) : smarty_modifier_date_format($_tmp)); ?>
<br />
                                Total <?php echo $this->_tpl_vars['album']['tot']; ?>
 photo(s)<br />
                                <a href='<?php echo @URL; ?>
/picture/albumremove/<?php echo $this->_tpl_vars['album']['id']; ?>
'>Delete this album</a>
                                <br />
                            </center>
                        </div>
                    </div>
                    <?php else: ?>
                    <div class="album">
                        <center>
                            <div class="browsealbums">
                                <a href='<?php echo @URL; ?>
/picture/albumview/<?php echo $this->_tpl_vars['album']['id']; ?>
'><img src='<?php echo @URL; ?>
/getsmimage.php?id=<?php echo $this->_tpl_vars['album']['image_id']; ?>
' style="max-height:100px;" alt="<?php echo $this->_tpl_vars['album']['album_name']; ?>
, conveylive" /></a>
                                <h3><a href='<?php echo @URL; ?>
/picture/albumview/<?php echo $this->_tpl_vars['album']['id']; ?>
'><?php echo $this->_tpl_vars['album']['album_name']; ?>
</a></h3>
                                <?php echo ((is_array($_tmp=$this->_tpl_vars['album']['ins_date'])) ? $this->_run_mod_handler('date_format', true, $_tmp) : smarty_modifier_date_format($_tmp)); ?>
<br />
                                Total <?php echo $this->_tpl_vars['album']['tot']; ?>
 photo(s)<br />
                                <a href='<?php echo @URL; ?>
/picture/albumremove/<?php echo $this->_tpl_vars['album']['id']; ?>
'>Delete this album</a>
                                <br />
                            </div>
                        </center>
                    </div>
                    <?php endif; ?>
                <?php endforeach; endif; unset($_from); ?>
            </div>
        </center>
    </div>
<?php endif; ?>
</div>

<?php echo '
<script type="text/javascript">
   
   $(document).ready(function(){      
       $("#frmalbum").validate({
       errorLabelContainer: "#errors",
       wrapper: "p",
           rules:{
               albumname:{ required: true , maxlength: 50 },
               remarks:{ maxlength: 200 },
               picture:{ required: true, allow: "jpeg|jpg|JPEG|JPG|GIF|gif|bmp|BMP" }
           },
           messages:{
               albumname: 
               {
                   required: "Please enter a name for the album.",
                   maxlength: "Album name can not have more than 50 characters"
               },
               remarks: "Remarks can not have more than 200 characters",
               picture: 
               {
                   required: "Please select an image to upload.",
                   allow: "Please upload images with any valid extensions: jpeg ,jpg, JPEG, JPG, GIF, gif, bmp, BMP"
               }
           }
       });
       
       $("#frmimg").validate({
       errorLabelContainer: "#errors",
       wrapper: "p",
           rules:{
               picture:{ required: true, allow: "jpeg|jpg|JPEG|JPG|GIF|gif|bmp|BMP" }
           },
           messages:{
               picture: 
               {
                   required: "Please select an image to upload.",
                   allow: "Please upload images with any valid extensions: jpeg ,jpg, JPEG, JPG, GIF, gif, bmp, BMP"
               }
           }
       });
   });
</script>
'; ?>