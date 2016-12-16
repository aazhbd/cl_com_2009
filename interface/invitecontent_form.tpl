{literal}
<script type="text/javascript">
   $(document).ready(function(){
       $("#reps").hide();
   });
</script>
{/literal}
<div style="width:740px;">
    <div id="reps"></div>
    <form id="frmcontinvitefrnds" method="post" action="{$smarty.const.URL}/contentinvite.php" >
        <fieldset title="Invite Friends">
            <legend><img src="{$smarty.const.URL}/interface/icos/users.png" style="width:20px;" />{$cont_formlabel}</legend>
            <div>
                <span>
                    <div style="width:120px;float:left;">
                        <label for="email">Friends' Email(s): </label>
                    </div>
                    <textarea type="text" name="email" id="email" value="" style="width:570px;height:40px;" ></textarea>
                    <div class="subinfo">Type email addresses separated by commas(,)</div>
                </span>
            </div>
            <div>
                <span>
                    <div style="width:60px;float:left;">
                        <label>Subject: </label>
                    </div>
                    {if $islogin == true}
                        <div style="float:left; font-weight:bold; width: 500px;">{$mail_subject}</div>
                        <input type="hidden" name="subj" id="subj" value="{$mail_subject|escape:'html'}" />
                    {else}
                        <div style="margin-left:120px;">
                            <div style="font-weight:bold;">{$mail_subject_general} </div>
                            <input type="hidden" name="subj" id="subj" value="{$mail_subject_general|escape:'html'}" />
                            <input type="text" name="uname" id ="uname" value="Type your name" style="width:100px;color:#aaa;" onclick="this.value=''"  />
                        </div>
                    {/if}
                </span>
            </div>  
            <div>
                <span>
                    <div style="width:98%;float:left;">
                        <label for="message">Your Message:</label>
                    </div>
                    <input type="hidden" name="addmsg" id="addmsg" value="{$mail_body|escape:'html'}" />
                    <div style="float:left;width:700px; "><textarea  name="message" id="message" style="width:670px;height:90px;padding:5px;font-size:12px;" class="msgbox" readonly="readonly">Hi,
{$mail_body}

Regards</textarea></div>
                </span>
            </div>
            <div>
                <span>                    
                    <input type="hidden" name="conttype" value="{$conttype}" id="conttype" />
                    <input type="submit" name="submit" id="button" value="Send Mail" class="frmbtn"/>
                    <input type="reset" name="reset" id="button" value="Reset" class="frmbtn"/>
                </span>
            </div>
        </fieldset>
    </form>
</div>
{literal}
<script type="text/javascript">
$(document).ready(function(){
    $("#frmcontinvitefrnds").validate(
    {
        submitHandler: function(form) {
            $(form).ajaxSubmit({
                success: function(response, status) {
                    $("#reps").html($("#errors", response).html());
                    $("#reps").append($("#reports", response).html());
                    $("#reps").show();
                    $("input[type='submit']", form).attr('disabled', '');
                    $("input[type='submit']", form).attr('value', 'Send Mail');
                    $("input[type='submit']", form).attr('value', 'Send Mail');
                    $('textarea#email').val("");
                },
                beforeSubmit: function() {
                    $("input[type='submit']", form).attr('disabled', 'disabled');
                    $("input[type='submit']", form).attr('value', 'Sending...');
                }
            });
            return false;
        },
        errorLabelContainer: "#reps",
        wrapper: "p",
        rules: {
            email: { required: true, maxlength: 500 },
            message: { required: true ,minlength: 1, maxlength:1000 },
            uname : { required:true, maxlength:100 }
        },
        messages: {
            email: {
                    required: "Please typein atleast 1 email address",
                    maxlength: "You have exceeded the maximum number of characters allowed for email field (500). Please remove email addresses"
            },

            message: {
                required: "Please write a message for this mail",
                maxlength: "The message should be within 1000 characters",
                minlength: "Please write the message for this mail"
            },
            uname:{
                required: "Please type your user name",
                maxlength: "You name can not be of length more than 100 characters. Please shorten your name."
            }
            
        }
    });
});
</script>
{/literal}
