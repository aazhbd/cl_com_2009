<?php /* Smarty version 2.6.26, created on 2011-03-16 20:36:18
         compiled from edit_club.tpl */ ?>
<?php echo '
<script type="text/javascript">
   $(document).ready(function(){
       $("#errors").hide();
   });
</script>
'; ?>

<div style="width:730px;">
    <div>
        <img src="<?php echo @URL; ?>
/getimage.php?id=<?php echo $this->_tpl_vars['club']['image_id']; ?>
" width="80" alt="<?php echo $this->_tpl_vars['club']['cname']; ?>
, conveylive.com, club" />
        <a href="<?php echo @URL; ?>
/clubs/view/<?php echo $this->_tpl_vars['club']['id']; ?>
">Back to Club</a>
        <br />
    </div>
    <div id="errors"></div>
    <form method="post" action="<?php echo @URL; ?>
/updateclub.php" id="frmclub" enctype="multipart/form-data" >
        <fieldset>
            <legend>Please fill in the information below to edit club</legend>
            <input type="hidden" name="action" id="action" value="<?php echo $this->_tpl_vars['action']; ?>
"/>
            <input type="hidden" name="email" id="email" value="<?php echo $this->_tpl_vars['email']; ?>
"/>
            <input type="hidden" name="club_id" id="club_id" value="<?php echo $this->_tpl_vars['club']['id']; ?>
"/>
            <div>
                <span>
                    <div style="float:left; width:100px;" >
                        <label for="cat">Category: </label>(required)
                    </div>
                    <select name='cat' id='cat'>
                        <?php $_from = $this->_tpl_vars['catList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['cat']):
?>
                            <?php if ($this->_tpl_vars['club']['category_id'] == $this->_tpl_vars['cat']['id']): ?>
                                <option value='<?php echo $this->_tpl_vars['cat']['id']; ?>
' selected="selected"><?php echo $this->_tpl_vars['cat']['cname']; ?>
</option>
                            <?php else: ?>
                                <option value='<?php echo $this->_tpl_vars['cat']['id']; ?>
'><?php echo $this->_tpl_vars['cat']['cname']; ?>
</option>
                            <?php endif; ?>
                        <?php endforeach; endif; unset($_from); ?>
                    </select>
                </span>
            </div>
            <div>
                <span>
                    <div style="float:left; width:100px;">
                        <label for="cname">Name: </label>
                    </div>
                    <input type="text" name="cname" style="width: 600px;" id="cname" value="<?php echo $this->_tpl_vars['club']['cname']; ?>
"/>
                    <div class="subinfo">Maximum 100 characters</div>
                </span>
            </div>
            <div>
                <span>
                    <div style="width: 100px;">
                        <label for="privacy">Access: </label>(required)
                    </div>
                    <br/>
                    <div  style="margin-left:100px;">
                    <?php if ($this->_tpl_vars['club']['privacy'] == 0): ?>
                        <label><input type="radio" name="privacy" id="privacy" value="0" checked="checked"/>Open </label>(Anyone can join)<br/>
                    <?php else: ?>
                        <label><input type="radio" name="privacy" id="privacy" value="0"/>Open </label>(Anyone can join)<br/>
                    <?php endif; ?>
                    <?php if ($this->_tpl_vars['club']['privacy'] == 1): ?>
                        <label><input type="radio" name="privacy" id="privacy" value="1" checked="checked"/>Closed </label>(Anyone can join but join request needs approval from club admin)<br/>
                    <?php else: ?>
                        <label><input type="radio" name="privacy" id="privacy" value="1"/>Closed </label>(Anyone can join but join request needs approval from club admin)<br/>
                    <?php endif; ?>
                    <?php if ($this->_tpl_vars['club']['privacy'] == 2): ?>
                        <label><input type="radio" name="privacy" id="privacy" value="2" checked="checked"/>Secret </label>(Members can join only by invitation and will not appear in search results)<br/>
                    <?php else: ?>
                        <label><input type="radio" name="privacy" id="privacy" value="2"/>Secret </label>(Members can join only by invitation and will not appear in search results)<br/>
                    <?php endif; ?>
                    </div>
                </span>
            </div>
            <div>
                <span>
                    <input name="submit" type="submit" value="Update Club" class="frmbtn" />
                    <input name="submit" type="reset" value="Reset" class="frmbtn" />
                    &nbsp;<a href="<?php echo @URL; ?>
/home">Cancel</a>
                </span>
            </div>
            <div>
                <span>
                    <input type="hidden" name="MAX_FILE_SIZE" value="2097152" />
                    <div style="float:left;width:100px;"><label for="clubphoto">Club Photo:</label><br />(Optional)</div>
                    <input type="file" name="clubphoto" id="clubphoto" value="" />
                    <div style="margin-left:100px;width:500px;" class="subinfo">File size limit 2 MB. If your upload does not work, try a smaller picture.</div>
                </span>
            </div>            
            <div>
                <span>
                    <div style="float:left; width:100px;" >
                        <label for="description">Description: </label>
                    </div>
                    <textarea id="description" name="description" style="width: 600px;" rows="10"><?php echo $this->_tpl_vars['club']['description']; ?>
</textarea>
                    <div class="subinfo">Maximum 1000 characters</div>
                </span>
            </div>
        </fieldset>
    </form>
</div>
<?php echo '
<script type="text/javascript">
   $(document).ready(function(){       
       $("#frmclub").validate({
           errorLabelContainer: "#errors",
           wrapper: "p",
           rules:{
               cat: { required: true },
               cname: { required: true, maxlength: 100, minlength: 5 },
               description: { required: true, maxlength: 1000 },
               privacy: { required: true },
               clubphoto: { accept: "jpeg|jpg|gif|png|PNG|GIF|JPEG|JPG" }
           },
           messages:{
               cat: { required: "Select a category for this club" },
               cname: { 
                        required: "Please provide a name for this club",
                        maxlength: "The name should be within 100 characters",
                        minlength: "The name should have atleast 5 characters"
               },
               description: { 
                        required: "Please write the description for this club",
                        maxlength: "The description should be within 1000 characters"
               },
               privacy: {
                        required: "Please select the club type"
               },
               clubphoto: { 
                        accept: "Please upload files with jpeg or jpg or gif or png or PNG or GIF or JPEG or JPG extensions" 
               }
           }
       });
   });
</script>
'; ?>