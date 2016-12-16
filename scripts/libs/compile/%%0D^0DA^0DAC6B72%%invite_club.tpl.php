<?php /* Smarty version 2.6.26, created on 2010-01-26 16:06:58
         compiled from invite_club.tpl */ ?>
<?php echo '

<script type="text/javascript">

   $(document).ready(function(){

       $("#errors").hide();

   });

</script>

'; ?>


<div style="float:left; width:730px;">
    <div>
        <img src="<?php echo @URL; ?>
/getimage.php?id=<?php echo $this->_tpl_vars['club']['image_id']; ?>
" width="80" alt="<?php echo $this->_tpl_vars['club']['cname']; ?>
, conveylive.com, club" />
        <a href="<?php echo @URL; ?>
/clubs/view/<?php echo $this->_tpl_vars['club']['id']; ?>
">Back to Club</a>
    </div>
    <br />
    <div id="errors"></div>
      
    <?php if ($this->_tpl_vars['friendList'] != null): ?>

    <div style="float:left; width:610px;">
        <form method="post" action="<?php echo @URL; ?>
/sendinvite.php" id="frminvite" >
            <fieldset>
                <legend>Select your friends to send invitations</legend>
                <div class="entry" style="width:100%;">

                    <?php $_from = $this->_tpl_vars['friendList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['friend']):
?>

                        <label for="inv"><input type="checkbox" name="inv[]" value="<?php echo $this->_tpl_vars['friend']['id']; ?>
" class="frmbtn" checked="checked"/><?php echo $this->_tpl_vars['friend']['f_name']; ?>
 <?php echo $this->_tpl_vars['friend']['l_name']; ?>
</label>
                        <br />

                    <?php endforeach; endif; unset($_from); ?>

                </div>

                <div class="entry" style="width:100%;">
                    <span>
                        <div style="width: 80px; float:left;">
                            <label for="msg">Message: </label>
                        </div>
                        <textarea id="msg" name="msg" cols="50" style="height:100px; padding:10px;" >Come and join <?php echo $this->_tpl_vars['club_name']; ?>
 to share your views and discuss various topics with me and other friends of mine. Click the following link to join this club <a href="<?php echo @URL; ?>
/clubs/join/<?php echo $this->_tpl_vars['club_id']; ?>
">Join</a></textarea>
                    </span>
                </div>
                
                <input type="hidden" name="club_name" value="<?php echo $this->_tpl_vars['club_name']; ?>
" />
                <input type="hidden" name="club_id" value="<?php echo $this->_tpl_vars['club_id']; ?>
" /> 
                <input type="hidden" name="club_type" value="<?php echo $this->_tpl_vars['club_type']; ?>
" />
                <div>
                    <span>
                        <input type="submit" name="submit" value="Invite to Club" class="frmbtn" />&nbsp;<a href="<?php echo @URL; ?>
/clubs/view/<?php echo $this->_tpl_vars['club_id']; ?>
" >Cancel</a>
                    </span>
                </div>
            </fieldset>
        </form>
    </div>
    <?php else: ?>
        <br />
        <div class="artcont">You do not have friends to invite to this club. Please invite your friends to join conveylive. <br />Click <a href="<?php echo @URL; ?>
/invite.php">here</a> to invite</div>
    <?php endif; ?>
</div>

<?php echo '

<script type="text/javascript">

   $(document).ready(function(){       

       $("#frminvite").validate({

           errorLabelContainer: "#errors",

           wrapper: "p",

           rules:{

               inv: { required:true }

           },

           messages:{

               required: {

                   required: "Please select atleast 1 friend to send invitation.";

               }

           }

       });

   });

</script>

'; ?>