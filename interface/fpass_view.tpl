{literal}
<script type="text/javascript">
   $(document).ready(function(){
       $("#errors").hide();
   });
</script>
{/literal}

<div style="width:735px;">
<div id="errors">{$err}</div>
<div id="pginfo">
    If you have forgotten your password, please enter your login email below.
    <br /><br />
    If your email is registered with ConveyLive, we will send you an email with your current password
</div>
{*include file="subtpl/had.tpl"*}
<div style="width:735px;">
<form id="fpass" method="post" action="forgetpass.php">
    <fieldset title="Forgot Password">
    <legend><b>Enter your email</b></legend> 
        <div align="center">
            <span>
                <label style="float:left; width:50px;">Email: </label>
                <input id="email" type="text" name="email" size="18" class="log" align="middle" />
            </span>
            <span>
                <input type="submit" name="submit" id="button" class="frmbtn" value="Send" />
            </span>
        </div>
        &nbsp;
        <br/>
    </fieldset>
</form>
</div>
</div>
{literal}
<script type="text/javascript"> 
   $(document).ready(function(){      
       $("#fpass").validate({
       errorLabelContainer: "#errors",
       wrapper: "p",
           rules:{
               email:{ required: true, email: true , maxlength: 50}
           },
           messages:{
               email: "Please enter a valid email address."
           }
       });
   });
</script>
{/literal}