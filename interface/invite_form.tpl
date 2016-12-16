{literal}
<script type="text/javascript">
   $(document).ready(function(){
       $("#errors").hide();
   });
   function toggleAll(element) 
    {
        var form = document.forms.frminvitefrnds, z = 0;
        for(z=0; z < form.length; z++)
        {
            if(form[z].type == 'checkbox')
                form[z].checked = element.checked;
        }
    }
</script>
{/literal}
<div id="errors"></div>
<div style="float:left; width:745px;">
    <div id="pginfo">
        Invite your friends to join conveylive. Submit your email address and password in the form below and click "Import Contacts" button.
        If your email address and password are correct then you will see a list of your email addresses from your email's address book. You may select the emails to which you want to send invitation.
        You can also add a message with the invitation mail.
    </div> 
    {if $done neq true}
        {if $step == 'send_invites'}
            {if  $showContacts == true }
                <form id="frminvitefrnds" method="post" action="{$smarty.const.URL}/sendmail.php">
                    <fieldset title="Invite Friends">
                        <input type='hidden' name='uemail_id' value='{$uemail_id}' />
                        <input type='hidden' name='uemail' value='{$uemail}' />
                        <input type='hidden' name='username' value='{$username}' />
                        <div>
                            <span>Select which contacts to invite from the list below. You can also try <a href="{$smarty.const.URL}/invite.php">another email account.</a></span>
                        </div>
                        <div>
                            <span>
                                <label>Subject: </label>
                                <div style="width:98%;float:left;">Your friend {$username} invites you to join ConveyLive.com.</div>
                            </span>
                        </div>
                        <div>
                            <div>
                                <span>
                                    <label for="cont">Your Message:</label>
                                    <div style="width:730px;float:left;">
                                    Hello,
                                        <center>
                                            <textarea  name="message" id="message" style="width:700px;height:100px;float:left;padding:10px;" class="msgbox" readonly="readonly" >Come and join me in ConveyLive! You can meet here different people from all over the world who has published various articles, audio, video, photos, clubs and blogs. Let's express our creativity, share our views and enjoy ConveyLive ! {if $pid != null}Click the link http://conveylive.com/profile/view/{$pid} to view my profile{/if}

Thanks
{$username}
</textarea>
                                        </center>
                                    </div>
                                </span>
                            </div>
                            <div>
                                <span>&nbsp;</span>
                            </div>
                            <div class="invitebox">
                                <div style="float:left; width:220px;padding:5px;">
                                    <input type='checkbox' onChange={literal}'toggleAll(this)'{/literal} name='toggle_all' title='Select/Deselect all' checked="checked" />
                                    &nbsp;&nbsp;
                                    <strong>Name</strong>
                                </div>
                                <div style="float:left; width:230px;padding:5px;"><strong>Email</strong></div>
                                <div style="float:left; width:730px;">
                                    {foreach item=name from=$contacts key=email }
                                        <div class="uname">
                                            <input name='chkedemail[]' value='{$email},{$name}' type='checkbox' checked="checked" /> &nbsp;&nbsp;
                                            {$name|wordwrap:18:"\n":true}
                                        </div>
                                        <div class="uemail">
                                            {$email|wordwrap:18:"\n":true}
                                        </div>
                                        <div style="float:left; width:560px;">
                                            <span>&nbsp;</span>
                                        </div>
                                    {/foreach}
                                </div>
                            </div>
                            <br />
                            <div>
                                <span align="center">
                                    <input type="submit" name="submit" id="button" value="Send Invitation Mail" class="frmbtn"/>
                                    <a href="{$smarty.const.URL}/home">Cancel</a>
                                    <input type="hidden" name="email" id="email"  value="{$prof.user_email}"/>
                                </span>
                            </div>
                        </div>
                    </fieldset>
                </form>
            {/if}
        {/if}
    {/if}
    {if $done neq true}
        {if $step == 'get_contacts'}
            <form action='{$smarty.const.URL}/invite.php' method='POST' name='openinviter' align="center" style="width:730px;">
                    <fieldset style="width:730px;">
                    <legend style="width:200px;">Invite Your Friends</legend>
                    {$ers}{$oks}
                        <div>
                            <span>
                                <label style="float:left;width:65px;" for='email_box'>Email</label>
                                <input class='thTextbox' type='text' name='email_box' value='{$email_box}' style="width:155px;" /><br/>
                            </span>
                        </div>
                        <div>
                            <span>
                                <label style="float:left;width:65px;" for='password_box'>Password</label>
                                <input class='thTextbox' type='password' name='password_box' value='{$password_box}' style="width:155px;" /><br/>
                            </span>
                        </div>
                        <div>
                            <span>
                                <label style="float:left;width:65px;" for='provider_box'>Provider</label>
                                <select class='thSelect' name='provider_box' style="width:155px;" />
                                    <option value=''></option>
                                    {$options_list}
                                </select><br /><br />
                            </span>
                        </div>
                        <div>
                            <span style="padding-left:65px; padding-right:20px; width:200px;">
                                <input class='frmbtn' type='submit' name='import' value='Import Contacts' />
                                <input type='hidden' name='step' value='get_contacts' />
                            </span>
                        </div>
                    </fieldset>
                </form>
            {/if}
        {/if}
</div>
{literal}
<script type="text/javascript">
   
   $(document).ready(function(){      
       $("#frminvitefrnds").validate({
       errorLabelContainer: "#errors",
       wrapper: "p",
           rules:{
               message:{ maxlength: 1000}
           },
           messages:{
               message: {
                   maxlength: "Message can not be more than 1000 characters long"
               }
           }
       });
   });
</script>
{/literal}