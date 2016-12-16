<?php /* Smarty version 2.6.26, created on 2010-02-05 03:08:29
         compiled from create_blog.tpl */ ?>
<?php echo '
<script type="text/javascript">
   $(document).ready(function(){
       $("#errors").hide();
   });
</script>
'; ?>

<div style="width:735px;">   
    <div id="errors"></div>
    <div id="pginfo">
        A blog is basically a journal where entries are made in journal style and displayed in a reverse chronological order. You may post any type of your own short writeups, experience etc, in blog posts after you create a blog. You can create at most 1 blog and can post any number of topics. The blog you create in conveylive should have a unique web address which can be found publicly, from conveylive as well as search engines like google.
    </div>
    <form id="frmblog" name="frmblog" method="post" action="<?php echo @URL; ?>
/saveblog.php">
        <fieldset>
            <legend>Enter a name for your blog and create an url/address to access your blog</legend>
                <div>
                    <span>
                        <div style="float:left; width:150px;">
                            <label for="blogname">Blog Name:</label>
                        </div>
                        <input type="text" name="blogname" id="blogname" size="20" value="<?php echo $this->_tpl_vars['blog']['cname']; ?>
" />
                        <span class="subinfo">This will appear on your published blog posts.</span>
                    </span>
                </div>
                <div>
                    <span>
                        <div style="float:left; width:150px;">
                            <label for="blogurl">Blog address (URL):</label>
                        </div>
                        http://conveylive.com/b/<input type="text" name="blogurl" id="blogurl" size="15" value="<?php echo $this->_tpl_vars['blog']['url']; ?>
"  />&nbsp;<strong><a href="#" id="checkavail" >Check Availability</a></strong>
                        <div id ="availresponse"></div><br/>
                    </span>
                </div>
                <div>
                    <span align="left">
                        <?php if ($this->_tpl_vars['action'] != create): ?>
                            <input type="submit" name="submit" id="submit" value="Update Blog" class="frmbtn"/>
                            <input type="reset" name="reset" id="reset" value="Reset" class="frmbtn" />
                        <?php else: ?>
                            <input type="submit" name="submit" id="submit" value="Create Blog" class="frmbtn"/>
                            <input type="reset" name="reset" id="reset" value="Reset" class="frmbtn" />
                        <?php endif; ?>
                        <input type="hidden" name="email" id="email" size="30" value="<?php echo $this->_tpl_vars['email']; ?>
"/>
                        <input type="hidden" name="permission" id="permission" size="30" value="<?php echo $this->_tpl_vars['blog']['permission']; ?>
"/>
                        <input type="hidden" name="cdate" id="cdate" size="30" value="<?php echo $this->_tpl_vars['blog']['cdate']; ?>
"/>
                        <input type="hidden" name="blogid" id="blogid" size="30" value="<?php echo $this->_tpl_vars['blog']['id']; ?>
"/>
                        <input type="hidden" name="action" id="action" size="30" value="<?php echo $this->_tpl_vars['action']; ?>
"/>
                    </span>
                </div>
        </fieldset>
    </form>
</div>
<?php echo '
<script type="text/javascript">
    $(document).ready(function(){
        
        $(\'input#blogname\').keyup(function () {
          var n = $(this).val();
          var murl = n.replace(/[\\s/\\:*?"><|%()$#;\',+=@!&`]/g, \'_\');
          $(\'input#blogurl\').val(murl);
        });
        
        $(\'input#blogurl\').keyup(function () {
          var n = $(this).val();
          var murl = n.replace(/[\\s/\\:*?"><|%()$#;\',+=@^!&`]/g, \'_\');
          $(\'input#blogurl\').val(murl);
        });        
        
        $("#errors").hide();
        $("#availresponse").hide();

        $(\'#blogurl\').click(function(){
            var nur = $("#blogname").val();
            if(nur.length > 0)
            {
                var murl = n.replace(/[\\s/\\:*?"><|%()$#;\',+=@!&`]/g, \'_\');
                $("#availresponse").show();
                $("#availresponse").fadeIn(400).html(\'Suggested url for your blog name: \' + murl);
                document.frmblog.blogurl.value = murl;
            }
        });
        
        $(\'#checkavail\').click(function(){
            var url = $(\'#blogurl\').val();
            var dataString = \'name=\'+ url;
            var aurl = site.url + "/zproc.php";
            
            $.ajax({
                type: "POST",
                url: aurl,
                data: dataString,
                cache: false,
                dataType: "html",
                success: function(response){
                    $("#availresponse").fadeIn(400).html(\'Your selected url is \' + response);
                }
            });
        });
        
        var ok = "no";
        
        $(\'#submit\').click(function(){
            var url = $(\'#blogurl\').val();
            var dataString = \'name=\'+ url;
            var aurl = site.url + "/zproc.php";
            var name = $(\'#blogname\').val();
            if(name.length == 0)
            {
                alert("Please type a name for your blog.");
                return false;
            }
            if(url.length == 0)
            {
                alert("Please type an url name for your blog and check validity.");
                return false;
            }
            $.ajax({
                type: "POST",
                url: aurl,
                data: dataString,
                cache: false,
                dataType: "html",
                async: false,
                success: function(response){
                    if(response == "not available")
                    {
                        alert("Your selected url is already in use, try a different one");
                        ok = "no";
                        return false;
                    }
                    else{
                        ok = "ok";
                        $("form:first").submit();
                        return true;
                        //$(\'#submit\').parents("form").submit();
                        //$(\'#frmblog\').submit();
                    }
                }
            });
            
            if(ok == "no") return false;
        });
        
        $("#frmblog").validate({
        errorLabelContainer: "#errors",
        wrapper: "p",
           rules:{
               blogname:{ required: true , maxlength: 250 },
               blogurl: { required: true, maxlength: 250 }
           },
           messages:{
               blogname: 
               {
                   required: "Please enter a name for the blog.",
                   maxlength: "Blog name can not have more than 250 characters"
               },
               blogurl:
               {
                   required: "Please enter an url for the blog.",
                   maxlength: "Blog url can not have more than 250 characters"
               }
           }
       });
    });
</script>
'; ?>