{literal}
<script type="text/javascript">
   $(document).ready(function(){
       $("#errors").hide();
   });
</script>
{/literal}
<div style="width:740px;">
<div id="errors"></div>
<div id="pginfo">
    You may change your conveylive account settings from here. You can change you name, password, birthdate or sex.
</div>
{*include file="subtpl/had.tpl"*} 
<form id="frmaccedit" method="post" action="{$smarty.const.URL}/editaccount.php">
    <fieldset title="Account Settings">
        <legend><b>Change account info and click save button!</b></legend>
            <div>
                <span>
                    <div style="float:left; width:120px;"><label for="fname">First Name:</label></div>
                    <input type="text" name="fname" id="fname" size="20" value="{$data.f_name}" />
                </span>
                <span>
                    <div style="float:left; margin-left:20px; width:120px;"><label for="lname">Last Name:</label></div>
                    <input type="text" name="lname" id="lname" size="20" value="{$data.l_name}"/>
                    
                </span>
            </div>
            <div>
                <span>
                    <div style="float:left; width:120px;"><label for="password_old">Old Password:</label></div>
                    <input type="password" name="password_old" id="password_old" size="20" />
                </span>
            </div>
            <div>
                <span>
                    <div style="float:left; width:120px;"><label for="password_new">New Password:</label></div>
                    <input type="password" name="password_new" id="password_new" size="20" />
                </span>
                <span>
                    <div style="float:left; margin-left:20px; width:120px;"><label for="rpass">Re-Type:</label></div>
                    <input type="password" name="rpass" id="rpass" size="20" />
                </span>
            </div>
            <div>
                <span>
                    <div style="float:left; width:120px;"><label for="sex">Sex: </label></div>
                    <select name="sex" id="sex" >
                        {if $data.gender == 'm'}
                        <option value="m" selected="selected">Male</option>
                        <option value="f" >Female</option>
                        {else}
                        <option value="m" >Male</option>
                        <option value="f" selected="selected">Female</option>
                        {/if}
                    </select>
                </span>
                <span>
                    <div style="margin-left:95px;float:left; width:120px;"><label>Birth Date: </label></div>
                        <Label>Day</label>
                        <select name="day">
                            {section name=d start=1 loop=32 step=1}
                            {if $data.day == $smarty.section.d.index }
                            <option value="{$smarty.section.d.index}" selected="selected">{$smarty.section.d.index}</option>
                            {else}
                            <option value="{$smarty.section.d.index}">{$smarty.section.d.index}</option>
                            {/if}
                            {/section}                            
                        </select>-
                        <Label>Month</label>
                        <select name="month">
                            {foreach item="m" from=$monthList key=k}
                            {if $data.month == $m }
                            <option value="{$k}" selected="selected">{$m}</option>
                            {else}
                            <option value="{$k}">{$m}</option>
                            {/if}
                            {/foreach}        
                        </select>-
                        <Label>Year</label>
                        <select name="year">
                            {section name=y start=1950 loop=2051 step=1}
                            {if $data.year == $smarty.section.y.index }
                            <option value="{$smarty.section.y.index}" selected="selected">{$smarty.section.y.index}</option>
                            {else}
                            <option value="{$smarty.section.y.index}">{$smarty.section.y.index}</option>
                            {/if}
                            {/section}        
                        </select>
                </span>
            </div>
            <div>
                <span align="left"><h3>
                <input type="submit" name="submit" id="button" value="Save" class="frmbtn"/>
                <input type="reset" name="reset" id="button" value="Clear" class="frmbtn"/>
                <input type="hidden" name="email" id="email" size="30" value="{$data.email}"/>
                </h3></span>
            </div>
    </fieldset>
</form>
</div>
{literal}
<script type="text/javascript">
   
   $(document).ready(function(){      
       $("#frmaccedit").validate({
       errorLabelContainer: "#errors",
       wrapper: "p",
           rules:{
               fname:{ required: true, maxlength: 50 , minlength: 1 },
               lname:{ required: true, maxlength: 50 ,  minlength: 1},
               password_new:{ minlength: 5 , maxlength: 20},
               rpass:{ minlength: 5, maxlength: 20, equalTo: "#password_new" }
           },
           messages:{
               fname: {
                   required: "Your first name is blank. Please type your first name",
                   maxlength: "First name can not be more than 50 characters long",
                   minlength: "First name can not be blank."
               },
               lname: {
                   required: "Your last name is blank. Please type your last name",
                   maxlength: "Last name can not be more than 50 characters long.",
                   minlength: "Last name can not be blank."
               },
               password_new: {
                   minlength: "Please enter a minimum 5 character new password.",
                   maxlength: "New password can not be more than 20 characters long."
               },
               rpass: {
                   equalTo: "Your re-typed password does not match the new password you entered.",
                   minlength: "Password must be at laest 5 characters long",
                   maxlength: "Password can not be more than 20 characters long"
               }
           }
       });
   });
</script>
{/literal}