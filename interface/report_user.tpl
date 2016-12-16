<div style="width:730px;">
	<div>You are about to report a violation of our <a href="{$smarty.const.URL}/static/terms">Terms and Conditions </a>of ConveyLive.com. All reports are strictly confidential.</div>
    <form action="{$smarty.const.URL}/reportsubmit.php" name="reportfrm" method="post" >
        <fieldset>
        <legend>Report {$report.f_name}&nbsp;{$report.l_name}</legend>
        	<div style="float:left;">Reason for reporting:</div>
            <div>
                <select name="remarks">
                    <option value="1" selected="selected">Select a reason</option>
                    <option value="2">Nudity or pornography</option>
                    <option value="3">Fake Profile</option>
                    <option value="4">Racist/Hate Speech</option>
                    <option value="5">Cyber Bullying</option>
                    <option value="6">Threatens me or others</option>
                    <option value="7">Unwanted contact</option>
                </select>
            </div>
            <div>
            &nbsp;
            </div>
            <div>
            	<input type="hidden" name="rep_email" value="{$report.email}" />
                <input type="hidden" name="user_email" value="{$user_email}" class="frmbtn" />
                <input type="submit" name="submit" value="Report" class="frmbtn" />
                <a href="{$smarty.const.URL}/home" >Cancel</a>
            </div>
    	</fieldset>
    </form>
</div>