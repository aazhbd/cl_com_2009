
{if $islogin != null}
    <div class="box" style="margin-top:5px;">
        <h3>Invite Your Friends</h3>
        <div class="sideCont">
            <div class="contName">
                <div id="err"></div>
                <form id="invitefrm" action="{$smarty.const.URL}/singleinvite.php" method="post">
                    <span>
                        <input type="text" id = "email" name="email" value="Email" onclick="this.value=''" style="margin:5px;" />
                    </span>
                    <span>
                        <input type="submit" id="submit" name="submit" value="Send" class="frmbtn"/>
                    </span>
                    <span>
                        <br />
                        <a href="{$smarty.const.URL}/invitemessage" >Invite with Message</a>
                    </span>
                </form>
            </div>
        </div>
    </div>
{/if}

{literal}
<script type="text/javascript">
   
   $(document).ready(function(){      
       
       $("#err").hide();
       
       $("#invitefrm").validate({
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