<?php /* Smarty version 2.6.26, created on 2010-01-28 08:55:08
         compiled from delprof_view.tpl */ ?>
<div style="width:735px;">
    <div id="pginfo">
        You may delete your profile from here. If you delete your profile information your friends will never find you in search results and they will not be able to find you in their friendlist.
        Your published contents will still be available but not your profile. 
        You may create your profile anytime.
    </div>
        <form id="deleteform" method="post" action="<?php echo @URL; ?>
/deleteprofile.php" style="height:130px;">
        <fieldset>
        <br />
        <span>
        <div style='float: left'><img src='<?php echo @URL; ?>
/interface/icos/delete.png' width='40' height='40' alt="$fname} , <?php echo $this->_tpl_vars['lname']; ?>
 , conveylive"/></div>
        &nbsp;<label><b>All your profile information including picture will be deleted. Are you sure you want to delete?</b></label>
        <span>
        <br />
        <input id="email" type="hidden" name="email" value="<?php echo $this->_tpl_vars['email']; ?>
" />
        <div>
            <span>
            &nbsp;
            </span>
        </div>
        <div>
            <span>
                <input type="submit" name="submit" id="button" value="Delete" class="frmbtn" />
                <a href="<?php echo @URL; ?>
/userhome">Cancel</a>
            </span>
        </div>
        </fieldset>
    </form>
</div>