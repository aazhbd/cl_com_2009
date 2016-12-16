{literal}

<script type="text/javascript">

   $(document).ready(function(){

       $("#errors").hide();

   });

</script>

{/literal}

<div style="float:left; width:730px;">
    <div>
        <img src="{$smarty.const.URL}/getimage.php?id={$club.image_id}" width="80" alt="{$club.cname}, conveylive.com, club" />
        <a href="{$smarty.const.URL}/clubs/view/{$club.id}">Back to Club</a>
    </div>
    <br />
    <div id="errors"></div>
    {*include file="subtpl/had.tpl"*}  
    {if $friendList != null}

    <div style="float:left; width:610px;">
        <form method="post" action="{$smarty.const.URL}/sendinvite.php" id="frminvite" >
            <fieldset>
                <legend>Select your friends to send invitations</legend>
                <div class="entry" style="width:100%;">

                    {foreach item=friend from=$friendList}

                        <label for="inv"><input type="checkbox" name="inv[]" value="{$friend.id}" class="frmbtn" checked="checked"/>{$friend.f_name} {$friend.l_name}</label>
                        <br />

                    {/foreach}

                </div>

                <div class="entry" style="width:100%;">
                    <span>
                        <div style="width: 80px; float:left;">
                            <label for="msg">Message: </label>
                        </div>
                        <textarea id="msg" name="msg" cols="50" style="height:100px; padding:10px;" >Come and join {$club_name} to share your views and discuss various topics with me and other friends of mine. Click the following link to join this club <a href="{$smarty.const.URL}/clubs/join/{$club_id}">Join</a></textarea>
                    </span>
                </div>
                
                <input type="hidden" name="club_name" value="{$club_name}" />
                <input type="hidden" name="club_id" value="{$club_id}" /> 
                <input type="hidden" name="club_type" value="{$club_type}" />
                <div>
                    <span>
                        <input type="submit" name="submit" value="Invite to Club" class="frmbtn" />&nbsp;<a href="{$smarty.const.URL}/clubs/view/{$club_id}" >Cancel</a>
                    </span>
                </div>
            </fieldset>
        </form>
    </div>
    {else}
        <br />
        <div class="artcont">You do not have friends to invite to this club. Please invite your friends to join conveylive. <br />Click <a href="{$smarty.const.URL}/invite.php">here</a> to invite</div>
    {/if}
</div>

{literal}

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

{/literal}