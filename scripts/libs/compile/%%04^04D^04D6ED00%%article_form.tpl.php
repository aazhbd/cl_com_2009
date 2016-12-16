<?php /* Smarty version 2.6.26, created on 2011-03-15 15:54:06
         compiled from article_form.tpl */ ?>
<?php echo '
<script type="text/javascript">
   $(document).ready(function(){
      $("#errors").hide(); 
   });
</script>
'; ?>

<div style="width:745px;">
    <div id="errors"><?php if ($this->_tpl_vars['err'] != ""): ?><?php echo $this->_tpl_vars['err']; ?>
<?php endif; ?></div>
    
    <div id="pginfo">
        You can publish any pages, articles, story, event, news, biography, etc from here. Add you own document formatting, color, image and click the publish button to confirm and publish your article.
    </div>
    
    <form method="post" action="<?php echo @URL; ?>
/previewarticle.php" id="frmart" >
        <fieldset>
            <legend>Add a new page</legend>
            <input type="hidden" name="id" id="id" value="<?php echo $this->_tpl_vars['art']['id']; ?>
"/>
            <input type="hidden" name="action" id="action" value="<?php echo $this->_tpl_vars['action']; ?>
"/>
            <div>
                <span>
                    <div style="float:left; width:80px;">
                        <label for="cat">Category:</label>
                    </div>
                    <select name='cat_id' id='cat_id'>
                        <?php $_from = $this->_tpl_vars['catList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['cat']):
?>
                            <?php if ($this->_tpl_vars['art']['category_id'] == $this->_tpl_vars['cat']['id']): ?>
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
                    <div style="float:left; width:80px;">
                        <label for="arttitle">Title:</label>
                    </div>
                    <input type="text" name="arttitle" id="arttitle" value="<?php echo $this->_tpl_vars['art']['title']; ?>
" style="width:540px;" />
                    <div class="subinfo">Maximum 100 characters</div>
                </span>
            </div>
            <div>
                <span>
                    <div style="float:left; width:80px;" >
                        <label for="subtitle">Sub-title:</label>
                    </div>
                    <input type="text" name="subtitle" id="subtitle" value="<?php echo $this->_tpl_vars['art']['sub_title']; ?>
" style="width:540px;"/>
                    <div class="subinfo">Maximum 200 characters</div> 
                </span>
            </div>
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
            <div>
                <span>
                    <input name="submit" type="submit" value="Preview and publish" class="frmbtn" />
                    <input type="reset" name="reset" id="reset" value="Reset" class="frmbtn" />
                    <a href="<?php echo @URL; ?>
/home">Cancel</a>
                </span>
            </div>
            <div style="float:left;height:60px;">
                <span>
                    <div><label  style="float:left; width:100px;" for="arturl">Page URL:</label></div>
                    http://conveylive.com/a/<input type="text" name="arturl" id="arturl" value="<?php echo $this->_tpl_vars['art']['url']; ?>
" style="width:410px;" />&nbsp;<strong><a href="#" id="checkavail" >Check Availability</a></strong>
                    <div style="width:500px;" class="subinfo">Maximum 250 characters</div>
                    <div style="width:500px;color:#F93; font-size:larger; font-stretch:semi-expanded; font-weight:bolder;" id ="availresponse"></div><br/>
                </span>
            </div>
            <div style="float:left;width:710px;">
                <span style="float:left;">
                    <label for="keywords">Keywords: </label><br />
                    <textarea id="keywords" name="keywords" style="width:320px;" rows="8" ><?php echo $this->_tpl_vars['art']['meta_tags']; ?>
</textarea>
                    <div style="width:250px;" class="subinfo">Maximum 200 characters. Seperate your keywords with comma (,) to make it available to the search engines</div>
                </span>
                <span style="float:right;">
                    <label for="remarks">Remarks: </label><br />
                    <textarea id="remarks" name="remarks" style="width:320px;" rows="8" ><?php echo $this->_tpl_vars['art']['remarks']; ?>
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
        $(\'input#arturl\').keyup(function () {
          var n = $(this).val();
          var murl = n.replace(/[\\s/\\:*?"><|%()$#;\',+=@^!&`]/g, \'_\');
          $(\'input#arturl\').val(murl);
        }); 
        
       //$("#errors").hide();
        $("#availresponse").hide();

        $(\'#checkavail\').click(function(){
            var url = $(\'#arturl\').val();
            var typ = \'art\';
            var dataString = \'name=\'+ url + \'type=\'+typ;
            var aurl = site.url + "/zproc.php";
            
            if(url.length > 0)
            {
                $.ajax({
                    type: "POST",
                    url: aurl,
                    data: dataString,
                    cache: false,
                    dataType: "html",
                    success: function(response){
                        $("#availresponse").show();
                        $("#availresponse").fadeIn(400).html(\'Your selected url is \' + response);
                    }
                });
            }
            return false;
        });
        
       $("#frmart").validate({
           errorLabelContainer: "#errors",
           wrapper: "p",
           rules:{
               bodytxt: { required: true, minlength: 1 ,maxlength: 16777216},
               cat: { required: true },
               arttitle: { required: true, maxlength: 100, minlength: 1 },
               subtitle: { maxlength: 200 },
               remarks: { maxlength: 500 },
               keywords: { maxlength: 200},
               arturl: { maxlength: 250}
           },
           messages:{
               bodytxt: {
                   required: "You can not publish blank article. Please enter your text.",     
                   minlength: "You can not publish blank article. Please enter your text.",
                   maxlength: "The text of your article is too big and has exceeded 16777216 characters. Please shorten your article."
               },
               cat: { required: "Select a category for this article" },
               arttitle: { 
                        required: "Please write the title for this article",
                        maxlength: "The title should be within 100 characters",
                        minlength: "Please write the title for this article"
               },
               subtitle: { 
                        maxlength: "The subtitle should be within 200 characters"
               },
               remarks: {
                        maxlength: "The remarks should be within 500 characters"
               },
               keywords: { 
                        maxlength: "The keywords should be within 200 characters" 
               },
               arturl: {
                        maxlength: "The url should be within 250 characters"
               }
           }
       });
   });
</script>
'; ?>