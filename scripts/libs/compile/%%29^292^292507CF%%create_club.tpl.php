<?php /* Smarty version 2.6.26, created on 2010-01-22 15:10:55
         compiled from create_club.tpl */ ?>
<?php echo '
<script type="text/javascript">
   $(document).ready(function(){
       $("#errors").hide();
   });
</script>
'; ?>

<div style="width:745px;"> 
    <div id="errors"></div>
    <div id="pginfo">
        You can publish clubs in various categories which could be used to promote social activities, sharing information, creating awareness by inviting a lot of people to join club. Select any of the categories from the list and publish your club. In clubs you can open discussion topics, invite friends, post photos and upload files.
    </div>
    <form method="post" action="<?php echo @URL; ?>
/submitclub.php" id="frmclub" enctype="multipart/form-data" >
        <fieldset>
            <legend>Please fill in the information below to create a new club</legend>
            <input type="hidden" name="action" id="action" value="<?php echo $this->_tpl_vars['action']; ?>
"/>
            <input type="hidden" name="email" id="email" value="<?php echo $this->_tpl_vars['email']; ?>
"/>
            <div>
                <span>
                    <div style="float:left; width:70px;" >
                        <label for="cat_id">Category: </label>
                    </div>
                    <select name='cat_id' id='cat_id'>
                        <option value=''>Select</option>
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
                    <div style="float:left; width:70px;">
                        <label for="cname">Name: </label>
                    </div>
                    <input type="text" name="cname" style="width: 600px;" id="cname" value="<?php echo $this->_tpl_vars['club']['cname']; ?>
"/>
                    <div class="subinfo">Maximum 100 characters</div>
                </span>
            </div>
            <div>
                <span>
                    <div style="width: 60px;">
                        <label for="privacy">Access: </label>
                    </div>
                    <div style="margin-left:60px;">
                        <label><input type="radio" name="privacy" id="privacy" value="0" checked="checked" />Open</label>
                        <br /><span class="subinfo">(Anyone can join) </span><br/>
                        <label><input type="radio" name="privacy" id="privacy" value="1" />Closed</label>
                        <br /><span class="subinfo">(Anyone can join but join request needs approval from club admin)</span><br/>
                        <label><input type="radio" name="privacy" id="privacy" value="2" />Secret</label>
                        <br /><span class="subinfo">(Members can join only by invitation and will not appear in search results)</span><br/>
                    </div>
                </span>
            </div>
            <div>
                <span>
                    <input name="submit" type="submit" value="Create Club" class="frmbtn" />
                    <input name="submit" type="reset" value="Reset" class="frmbtn" />&nbsp;<a href="<?php echo @URL; ?>
/home">Cancel</a>
                </span>
            </div>
            <div>
                <span>
                    <input type="hidden" name="MAX_FILE_SIZE" value="2097152" />
                    <div style="float:left;width:100px;">
                        <label for="clubphoto">Club Photo:</label>
                    </div>
                    <input type="file" name="clubphoto" id="clubphoto" value="" />
                    <div class="subinfo">File size limit 2 MB. If your upload does not work, try a smaller picture.</div>
                </span>
            </div>        
            <div>
                <span>
                    <div style="float:left;width:100px;">
                        <label for="description">Description: </label>
                    </div>
                    <textarea id="description" name="description" style="width: 700px;" rows="10"><?php echo $this->_tpl_vars['club']['description']; ?>
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
               cat_id: { required: true },
               cname: { required: true, maxlength: 100, minlength: 5 },
               description: { maxlength: 1000 },
               clubphoto: { accept: "jpeg|jpg|gif|png|PNG|GIF|JPEG|JPG" }
           },
           messages:{
               cat_id: { required: "Select a category for this club" },
               cname: { 
                        required: "Please provide a name for this club",
                        maxlength: "The name should be within 100 characters",
                        minlength: "The name should have atleast 5 characters"
               },
               description: { 
                        maxlength: "The description should be within 1000 characters"
               },
               clubphoto: { 
                        accept: "Please upload files with jpeg or jpg or gif or png or PNG or GIF or JPEG or JPG extensions" 
               }
           }
       });
   });
</script>
'; ?>