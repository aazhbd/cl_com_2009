<?php /* Smarty version 2.6.26, created on 2010-06-24 10:16:17
         compiled from blogpost_form.tpl */ ?>
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
        Publish your blog posts from here which may include your own short writeups, experience etc.
        You can also put a list of keywords that are related to your blog post text so that the search engines like google can easily find it.
    </div>
    <br/>
    
    <div><a href="<?php echo $this->_tpl_vars['blog_url']; ?>
">Back to Blogs page</a>&nbsp;|&nbsp;<a href="<?php echo @URL; ?>
/blog/browseall">View Others Blogs</a>&nbsp;</div>
    
    <br />
    <form method="post" action="<?php echo @URL; ?>
/submitpost.php" id="frmpost" >
        <fieldset>
            <legend>New Post</legend>
            <input type="hidden" name="id" id="id" value="<?php echo $this->_tpl_vars['art']['id']; ?>
"/>
            <input type="hidden" name="post_id" id="post_id" value="<?php echo $this->_tpl_vars['post_id']; ?>
"/>
            <input type="hidden" name="cat_id" id="cat_id" value="<?php echo $this->_tpl_vars['cat_id']; ?>
"/>
            <input type="hidden" name="action" id="action" value="<?php echo $this->_tpl_vars['action']; ?>
"/>
            <input type="hidden" name="atype" id="atype" value="<?php echo $this->_tpl_vars['atype']; ?>
"/>
            <input type="hidden" name="email" id="email" value="<?php echo $this->_tpl_vars['email']; ?>
"/>
            <input type="hidden" name="blog_id" id="blog_id" value="<?php echo $this->_tpl_vars['blog_id']; ?>
"/>
            <input type="hidden" name="blog_url" id="blog_url" value="<?php echo $this->_tpl_vars['blog_url']; ?>
"/>
            <div>
                <span>
                    <div style="float:left; width:80px;">
                        <label for="arttitle">Title: </label>
                    </div>
                    <input type="text" name="arttitle" style="width:620px;" id="arttitle" value="<?php echo $this->_tpl_vars['art']['title']; ?>
"/>
                    <div class="subinfo"> Maximum 100 characters</div>
                </span>
            </div>
            <div>
                <span>
                    <div style="float:left; width: 80px;">
                        <label for="subtitle">Sub-title: </label>
                    </div>
                    <input type="text" name="subtitle" style="width:620px;" id="subtitle" value="<?php echo $this->_tpl_vars['art']['sub_title']; ?>
" />
                    <div class="subinfo"> Maximum 200 characters</div>
                </span>
            </div>
            <div>
                <span>
                    <?php if ($this->_tpl_vars['action'] == 'create'): ?>
                        <p><label for="bodytxt">Write your blog post below: </label></p>
                    <?php endif; ?>
                    <?php if ($this->_tpl_vars['action'] == 'update'): ?>
                        <p><label for="bodytxt">Edit your post: </label></p>
                    <?php endif; ?>
                    
                    <?php if ($this->_tpl_vars['fckEditor'] != null): ?>
                        <?php echo $this->_tpl_vars['fckEditor']; ?>

                    <?php else: ?>
                        <div>
                            <span>
                                <label for="bodytxt">Body:</label><br />
                                <textarea id="bodytxt" name="bodytxt" style="width:100%" ></textarea>
                            </span>
                        </div>
                    <?php endif; ?>
                    <div style="width:500px;" class="subinfo">Maximum 16777216 characters</div>
                    
                </span>
            </div>
            <div>
                <span>
                    <?php if ($this->_tpl_vars['action'] == 'create'): ?>
                        <input type="submit" name="submit" value="Publish Post" class="frmbtn" />
                        <input type="reset" name="reset" id="reset" value="Reset" class="frmbtn" />
                    <?php endif; ?>
                    <?php if ($this->_tpl_vars['action'] == 'update'): ?>
                        <input type="submit" name="submit" value="Update Post" class="frmbtn" />
                        <input type="reset" name="reset" id="reset" value="Reset" class="frmbtn" />
                    <?php endif; ?>
                    <a href="<?php echo @URL; ?>
/home">Cancel</a>
                </span>
            </div>
            <div style="float:left;width:725px;">
                <span style="float:left;">
                    <label for="meta_tags">Keywords: </label><br />
                    <textarea id="meta_tags" name="meta_tags" style="width:330px;" rows="8" ><?php echo $this->_tpl_vars['art']['meta_tags']; ?>
</textarea>
                    <div style="width:250px;" class="subinfo">Maximum 200 characters. Seperate your keywords with comma (,) to make it available to the search engines</div>
                </span>
                <span style="float:right;">
                    <label for="remarks">Remarks: </label><br />
                    <textarea id="remarks" name="remarks" style="width:330px;" rows="8" ><?php echo $this->_tpl_vars['art']['remarks']; ?>
</textarea>
                    <div style="width:250px;" class="subinfo">Maximum 500 characters</div>
                </span>
            </div>
        </fieldset>
    </form>
</div>
<?php echo '
<script type="text/javascript">
   $(document).ready(function(){       
       $("#frmpost").validate({
           errorLabelContainer: "#errors",
           wrapper: "p",
           rules:{
               bodytxt: { required: true, maxlength: 16777216, minlength: 1 },
               arttitle: { required: true, maxlength: 100, minlength: 1 },
               subtitle: { maxlength: 200 },
               remarks: { maxlength: 500 },
               meta_tags: { maxlength: 200}
           },
           messages:{
               bodytxt: {
                        required: "You can not publish blank blog post. Please enter your text.", 
                        minlength: "You can not publish blank post. Please enter your text.",
                        maxlength: "You can not put more than 16777216 characters for post. Please shorten your content."
               },
               arttitle: { 
                        required: "Please write the title for this post",
                        maxlength: "The title should be within 100 characters",
                        minlength: "Please write the title for this post"
               },
               subtitle: {
                        maxlength: "The title should be within 100 characters"
               },
               remarks: {
                        maxlength: "The remarks should be within 500 characters"
               },
               meta_tags: { 
                        maxlength: "The keywords should be within 200 characters" 
               }
           }
       });
   });
</script>
'; ?>
