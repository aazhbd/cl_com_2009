{literal}
<script type="text/javascript">
   $(document).ready(function(){
       $("#errors").hide();
   });
</script>
{/literal}
<div style="width:730px;">
    <div id="errors"></div>
     
    <div class="subtitle">You are about to add <a href='{$smarty.const.URL}/profile/view/{$prof.id}'>{$prof.name|capitalize}</a> as your friend !</div>
    
    <form id="frmfreq" method="post" action="{$smarty.const.URL}/friendrequest.php">
        <fieldset title="Friend Request">
            <div>
                <span><h3>{$prof.name} will have to confirm that you are friends.</h3></span>
            </div>
            <div>
                <span align="left">
                    <input type="submit" name="submit" id="button" value="Send Request" class="frmbtn"/>
                    <a href="{$smarty.const.URL}/home">Cancel</a>
                    <input type="hidden" name="email" id="email" size="30" value="{$email}"/>
                    <input type="hidden" name="f_email" id="f_email"  value="{$prof.user_email}"/>
                </span>
            </div>
            <div>
                <span>
                    <div style="float:left; width: 200px;">
                        <label for="cont">Message: (optional)</label>
                    </div>
                    <textarea  name="cont" id="c" rows="2" cols="110" ></textarea>
                     <div class="subinfo">Maximum 100 characters</div>
                </span>
            </div>            
        </fieldset>
    </form>
</div>
{literal}
<script type="text/javascript">
   
   $(document).ready(function(){      
       $("#frmfreq").validate({
       errorLabelContainer: "#errors",
       wrapper: "p",
           rules:{
               cont:{ maxlength: 100},
           },
           messages:{
               cont: {
                   maxlength: "Message can not be more than 100 characters long"
               }
           }
       });
   });
</script>
{/literal}