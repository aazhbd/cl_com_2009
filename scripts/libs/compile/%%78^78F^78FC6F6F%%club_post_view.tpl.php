<?php /* Smarty version 2.6.26, created on 2010-01-26 16:11:24
         compiled from club_post_view.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'club_post_view.tpl', 14, false),)), $this); ?>
<div style="float:left;width:730px;">
    <div id="errors"></div>
    <div>
        <img src="<?php echo @URL; ?>
/getimage.php?id=<?php echo $this->_tpl_vars['club_img_id']; ?>
" width="80" alt="<?php echo $this->_tpl_vars['club_name']; ?>
, conveylive.com, club" />
        <a href="<?php echo @URL; ?>
/clubs/newtopic/<?php echo $this->_tpl_vars['club_id']; ?>
">Post New Topic</a>&nbsp;|&nbsp;<a href="<?php echo @URL; ?>
/clubs/topics/<?php echo $this->_tpl_vars['club_id']; ?>
">Club Topics</a>&nbsp;|&nbsp;<a href="<?php echo @URL; ?>
/clubs/view/<?php echo $this->_tpl_vars['club_id']; ?>
">Back to Club</a>

    </div>
    <div class="clubpart3" id="profbox" style="width:95%;"><h3><?php echo $this->_tpl_vars['topic']['title']; ?>
</h3></div><br />
    
    <?php if ($this->_tpl_vars['post'] != null): ?>
    <div class="artcont">
        <div class="entry" style="width:100%;">
            <div class="entry" style="width:15%;"><img src="<?php echo @URL; ?>
/getsmimage.php?id=<?php echo $this->_tpl_vars['post']['user_imgs_id']; ?>
" width="60" alt="<?php echo $this->_tpl_vars['post']['f_name']; ?>
,<?php echo $this->_tpl_vars['post']['l_name']; ?>
" /></div>
            <div class="entry" style="width:80%;"><a href="<?php echo @URL; ?>
/profile/view/<?php echo $this->_tpl_vars['post']['pid']; ?>
"><?php echo $this->_tpl_vars['post']['f_name']; ?>
 <?php echo $this->_tpl_vars['post']['l_name']; ?>
</a> wrote on <strong><?php echo ((is_array($_tmp=$this->_tpl_vars['post']['ins_date'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%A, %B %e, %Y") : smarty_modifier_date_format($_tmp, "%A, %B %e, %Y")); ?>
 at <?php echo ((is_array($_tmp=$this->_tpl_vars['post']['ins_date'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%I:%M %p") : smarty_modifier_date_format($_tmp, "%I:%M %p")); ?>
</strong> </div>
        </div>
        <div class="entry" style="width:15%;"> 
            <?php if (( $this->_tpl_vars['post']['user_email'] == $this->_tpl_vars['email'] || $this->_tpl_vars['is_admin'] == true ) && $this->_tpl_vars['islogin'] == true): ?>
                <a href="<?php echo @URL; ?>
/clubs/deletepost/<?php echo $this->_tpl_vars['club_id']; ?>
/<?php echo $this->_tpl_vars['post']['id']; ?>
" class="postdel">Delete Post</a>
            <?php else: ?>
                <a href="<?php echo @URL; ?>
/clubs/reportpost/<?php echo $this->_tpl_vars['club_id']; ?>
/<?php echo $this->_tpl_vars['post']['id']; ?>
">Report this post</a>
            <?php endif; ?>
        </div>
        <div class="entry" style="width:60%;"><?php echo $this->_tpl_vars['post']['body']; ?>
</div>
        <div class="entry" style="width:100%;">
            <?php if ($this->_tpl_vars['post']['meta_tags'] != null): ?><p><img src="<?php echo @URL; ?>
/interface/icos/key.png" /><strong>Keywords: </strong> <?php echo $this->_tpl_vars['post']['meta_tags']; ?>
</p><?php endif; ?>
        </div>
    </div>
    <div id="comlist" style="float:left;width:730px;">
        <?php if ($this->_tpl_vars['coms'] != null): ?>
            <?php $_from = $this->_tpl_vars['coms']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['com']):
?>
            <div class="artcont">
                <div class="entry" style="width:15%;"><img src="<?php echo @URL; ?>
/getsmimage.php?id=<?php echo $this->_tpl_vars['com']['user_imgs_id']; ?>
" width="60" alt="<?php echo $this->_tpl_vars['com']['f_name']; ?>
,<?php echo $this->_tpl_vars['com']['l_name']; ?>
" /></div>
                <div class="entry" style="width:80%;"><a href="<?php echo @URL; ?>
/profile/view/<?php echo $this->_tpl_vars['com']['pid']; ?>
"><?php echo $this->_tpl_vars['com']['f_name']; ?>
 <?php echo $this->_tpl_vars['com']['l_name']; ?>
</a> wrote on <?php echo ((is_array($_tmp=$this->_tpl_vars['com']['cdate'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%A, %B %e, %Y") : smarty_modifier_date_format($_tmp, "%A, %B %e, %Y")); ?>
 at <?php echo ((is_array($_tmp=$this->_tpl_vars['com']['cdate'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%I:%M %p") : smarty_modifier_date_format($_tmp, "%I:%M %p")); ?>
 </div>
                <div class="entry" style="width:60%;"><?php echo $this->_tpl_vars['com']['comment']; ?>
</div>
                <div class="entry" style="width:100%;"> 
                    <br/>
                    <?php if (( $this->_tpl_vars['com']['user_email'] == $this->_tpl_vars['email'] || $this->_tpl_vars['is_admin'] == true || $this->_tpl_vars['cpost']['user_email'] == $this->_tpl_vars['email'] ) && $this->_tpl_vars['islogin'] == true): ?>
                        <a href="<?php echo @URL; ?>
/clubs/deletecom/<?php echo $this->_tpl_vars['cpost']['id']; ?>
/<?php echo $this->_tpl_vars['com']['id']; ?>
" class="postdel">Delete Post</a>
                    <?php else: ?>
                        <a href="<?php echo @URL; ?>
/clubs/reportcom/<?php echo $this->_tpl_vars['cpost']['id']; ?>
/<?php echo $this->_tpl_vars['com']['id']; ?>
">Report this post</a>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; endif; unset($_from); ?>
        <?php endif; ?>
    </div>
    <br />
    <?php if ($this->_tpl_vars['islogin'] == true): ?>
    
    <div style="float:left;width:730px;">
    <br />
        <form method="post" id="frmpost" >
            <fieldset>
                <legend style="width:200px;">Post a reply</legend>
                <input type="hidden" name="media_type" id="media_type" value="<?php echo $this->_tpl_vars['media_type']; ?>
"/>
                <input type="hidden" name="media_type" id="media_id" value="<?php echo $this->_tpl_vars['media_id']; ?>
"/>
                <input type="hidden" name="email" id="email" value="<?php echo $this->_tpl_vars['email']; ?>
"/>
                <input type="hidden" name="club_id" id="club_id" value="<?php echo $this->_tpl_vars['club_id']; ?>
"/>
                <div>
                    <span>
                        <textarea id="bodytxt" name="bodytxt"  style="width:700px;height:150px;" rows="5"></textarea>
                    </span>
                </div>
                <div>
                    <input type="submit" name="submit" value="Reply" class="frmbtn" id ="cmtpost"/>
                    <a href="<?php echo @URL; ?>
/clubs/view/<?php echo $this->_tpl_vars['club_id']; ?>
">Cancel</a>
                </div>
            </fieldset>
        </form>
    </div>
    <?php endif; ?>
</div>
<?php endif; ?>
<?php echo '
<script type="text/javascript">
   $(document).ready(function(){
       $("#errors").hide();
       $(\'#cmtpost\').click(function(){
            var cmt = $(\'#bodytxt\').val();
            var mid = $(\'#media_id\').val();
            var mt = $(\'#media_type\').val();
            var ue = $(\'#email\').val();
            var cid = $(\'#club_id\').val();
            var ins = \'insert\';
            if(cmt.length == 0)
            {
                alert("You can not publish blank post reply. Please type your reply.");
                return false;
            }
            if(cmt.length > 2499)
            {
                alert("You can not put more than 2499 characters for post. Please shorten your content.");
                return false;
            }
            
            var dataString = \'cmt=\'+cmt+\'&mid=\'+mid+\'&mt=\'+mt+\'&ue=\'+ue+\'&cid=\'+cid+\'&ins=\'+ins;
            
            var aurl = site.url + "/cpostprocess.php";
            
            $.ajax({
                type: "POST",
                url: aurl,
                data: dataString,
                cache: false,
                dataType: "html",
                success: function(response){
                    $("#comlist").fadeIn(400).html(response);
                    $(\'#comment\').val("");
                }
            });
        });
        return false;
   });
</script>
'; ?>