{*include file="subtpl/had.tpl"*}
{foreach item=req from=$join_req}

    <div class="reqCont">

        <a href="{$smarty.const.URL}/clubs/view/{$req.club_id}"><img border="1" src="{$smarty.const.URL}/getsmimage.php?id={$req.club_img_id}" alt="{$req.club_name}" style="width:120px;" /></a>

        <div id="cont">
            <h3 style="padding:5px;">
                <div style="padding:5px;float:left;width:60px;"><a href="{$smarty.const.URL}/profile/view/{$req.by_img_id}"><img style="width:40px;" border="1" src="{$smarty.const.URL}/getsmimage.php?id={$req.by_img_id}" alt="{$req.by}" /></a></div>
                <div><a href="{$smarty.const.URL}/profile/view/{$req.by_pid}">{$req.by}</a> wants you to join the club <a href="{$smarty.const.URL}/clubs/view/{$req.club_id}">{$req.club_name}</a></div>
                <br/>
                <p>Please follow the link below to join this club</p>                                                                                                                                                     
            </h3>
            
            <h3>
            &nbsp;&nbsp;
            <a href="{$smarty.const.URL}/clubs/join/{$req.club_id}">Join {$req.club_name}</a>

            <br /><br />
            &nbsp;&nbsp;
            <a href="{$smarty.const.URL}/clubs/denyrequest/{$req.club_id}">No I don't want to join this club</a>

            </h3>

        </div>

    </div>

    <br/>

{foreachelse}

<h3>You have no requests to join clubs</h3>

{/foreach}