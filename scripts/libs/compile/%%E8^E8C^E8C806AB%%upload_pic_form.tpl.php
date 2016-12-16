<?php /* Smarty version 2.6.26, created on 2010-01-23 23:19:11
         compiled from upload_pic_form.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'upload_pic_form.tpl', 70, false),)), $this); ?>
<div style="width:740px;">
    <div id="pginfo">
        Update your profile photos from here.
        You may upload photos for your profile and the photos you have uploaded can be seen as an album from the link below , "Profile Photos Album".
        Your published albums are also displayed in this page. You may also chose images from your photo album and set them as your profile picture.
    </div>
    
    <span>
        <strong><a href="<?php echo @URL; ?>
/picture/albumview/0">Profile Photos Album</a></strong>&nbsp;|&nbsp;<strong><a href="<?php echo @URL; ?>
/picture/new">Create New Album</a></strong>
    </span>
    <br /><br />

    <?php if ($this->_tpl_vars['action'] == 'update'): ?>
        <div style="width:330px;float:left;">
            <div><strong>Current Profile Picture</strong></div> 
            <br />
            <div style="width:300px;">
                <center>
                    <span>
                        <img src="<?php echo @URL; ?>
/getsmimage.php?id=<?php echo $this->_tpl_vars['data']['user_imgs_id']; ?>
" name="pic" id="pic" style="border:1px #ccc solid;min-width:200px; max-height:300px;" alt="People, Friends, Network, ConveyLive, Album"/>
                    </span>
                </center>
            </div>
        </div>
    <?php endif; ?>
    <div style="width:390px;float:left;margin-top:40px;">
        <form id="frmimgnew" method="post" enctype="multipart/form-data" action="<?php echo @URL; ?>
/savepicture.php">
            <fieldset title="ProfileImage">
            <?php if ($this->_tpl_vars['action'] == 'update'): ?>
                <legend>Update your profile photo</legend>
                <?php else: ?>
                <legend>Add new profile picture</legend>
            <?php endif; ?>
                <input type="hidden" name="action" value="<?php echo $this->_tpl_vars['action']; ?>
" />
                <input type="hidden" name="user_email" value="<?php echo $this->_tpl_vars['user_email']; ?>
" />
                <input type="hidden" name="aid" value="<?php echo $this->_tpl_vars['aid']; ?>
" />                
                <div>
                    <span>
                        <input type="hidden" name="MAX_FILE_SIZE" value="2097152" />
                        <div style="float:left; width:150px;"><label for="picture">Upload Picture:</label></div>
                        <input type="file" name="picture" id="picture" size="20" value=""/>
                        <div style="float:left;">File size limit is 2 MB. If your upload does not work, try a smaller picture</div>
                    </span>
                </div>
                <div>
                    <span>
                        <input type="submit" name="submit" class="frmbtn" id="button" value="Upload" />
                    </span>
                </div>
            </fieldset>
        </form>
    </div>
    
    <br />
    
    <?php if ($this->_tpl_vars['albums'] != null): ?>
        <div style="width:740px;float:left;padding-top:50px;">
            <h3>Your Albums</h3>
            <br />
            <div style="float:left; width:730px;">    
                <center>
                    <div style="width:700px;">
                        <?php $_from = $this->_tpl_vars['albums']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['album']):
?>

                            <div class="album">
                                <center>
                                    <div class="browsealbums">
                                        <a href='<?php echo @URL; ?>
/picture/albumview/<?php echo $this->_tpl_vars['album']['id']; ?>
'><img src='<?php echo @URL; ?>
/getsmimage.php?id=<?php echo $this->_tpl_vars['album']['image_id']; ?>
' style="max-height:100px;" alt="People, Friends, Network, ConveyLive, <?php echo $this->_tpl_vars['album']['album_name']; ?>
"/></a>
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

                        <?php endforeach; endif; unset($_from); ?>
                    </div>
                </center>
            </div>
        </div>
    <?php endif; ?>
</div>
<?php echo '
<script type="text/javascript">
   
   $(document).ready(function(){       
       $("#frmimgnew").validate({
           errorLabelContainer: "#errors",
           wrapper: "p",
           rules:{
               picture:{ required: true,  allow: "jpeg|jpg|JPEG|JPG|GIF|gif|bmp|BMP" }
           },
           messages:{
               picture:"Select a picture from your computer.",
               allow: "Please upload images with any valid extensions: jpeg ,jpg, JPEG, JPG, GIF, gif, bmp, BMP"
           }
       });
   });
</script>
'; ?>