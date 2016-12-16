{if $coms != null}    
    {foreach item=com from=$coms}
        <div class="combox">
            {if $com.pid != null}
                <div style="float:left; width:50px;">
                    <a href="{$smarty.const.URL}/profile/view/{$com.pid}"><img src="{$smarty.const.URL}/getsmimage.php?id={$com.user_imgs_id}" alt="{$com.f_name}, {$com.l_name} , ConveyLive.com, Photos, Picture, Album" height="40" /></a>
                </div>
                <div style="float:left; width:85%; padding:5px; text-align: justify;">
                    <p>
                        <strong><a href="{$smarty.const.URL}/profile/view/{$com.pid}">{$com.f_name} {$com.l_name} </a></strong> : {$com.comment} 
                    </p>
                    <span class="subinfo">
                        {$com.ins_date|date_format} at {$com.ins_date|date_format:'%I:%M %p, %A'} &nbsp;
{*                        {if ( $com.email == $email || $uemail == $email ) && $islogin == true}
                            <a href="{$smarty.const.URL}/cmtprocess.php?id={$com.id}" id="removecmt">remove</a>
                        {/if}
*}
                    </span>
                </div>
            {else}
                <div style="float:left; width:50px;">
                    <img src="{$smarty.const.URL}/getsmimage.php?id=0" alt="{$com.f_name}, {$com.l_name} , ConveyLive.com, Photos, Picture, Album" height="40" />
                </div>
                <div style="float:left; width:85%; padding:5px; text-align: justify;">
                    <p>
                        <strong>{$com.f_name} {$com.l_name} </strong> : {$com.comment|strip_tags:false} 
                    </p>

                    <span class="subinfo">
                        {$com.ins_date|date_format} at {$com.ins_date|date_format:'%I:%M %p, %A'} &nbsp;
{*
                      {if ($com.email == $email || $uemail == $email ) && $islogin == true}
                            <a href="{$smarty.const.URL}/cmtprocess.php?id={$com.id}" id="removecmt">remove</a>
                      {/if}
*}
                    </span>
                </div>
            {/if}
        </div>
        <br/>
    {/foreach}
{/if}