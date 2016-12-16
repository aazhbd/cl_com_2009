<div style="width:735px;">
    <div id="pginfo">
        You may delete your profile from here. If you delete your profile information your friends will never find you in search results and they will not be able to find you in their friendlist.
        Your published contents will still be available but not your profile. 
        You may create your profile anytime.
    </div>
    {*include file="subtpl/had.tpl"*}
    <form id="deleteform" method="post" action="{$smarty.const.URL}/deleteprofile.php" style="height:130px;">
        <fieldset>
        <br />
        <span>
        <div style='float: left'><img src='{$smarty.const.URL}/interface/icos/delete.png' width='40' height='40' alt="$fname} , {$lname} , conveylive"/></div>
        &nbsp;<label><b>All your profile information including picture will be deleted. Are you sure you want to delete?</b></label>
        <span>
        <br />
        <input id="email" type="hidden" name="email" value="{$email}" />
        <div>
            <span>
            &nbsp;
            </span>
        </div>
        <div>
            <span>
                <input type="submit" name="submit" id="button" value="Delete" class="frmbtn" />
                <a href="{$smarty.const.URL}/userhome">Cancel</a>
            </span>
        </div>
        </fieldset>
    </form>
</div>