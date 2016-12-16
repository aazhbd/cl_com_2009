<div style="float:left;width:98%;">
    <div id="box">
        <div style="width:42px; height:42px; float:left;">
            <a href="{$smarty.const.URL}/profile/view/{$pid}"><img src="{$smarty.const.URL}/getsmimage.php?id={$img_id}" alt="{$uname}" height="40" /></a>
        </div>
        <div class="smallbox">
            <a href="{$smarty.const.URL}/profile/view/{$pid}">{$uname}</a><br />
            {$imgstats.ins_date|date_format}
        </div>
        <div class="infobox">
            {$com_count|default:'0'} Comments | {$imgstats.view_count} Views |
            {$imgstats.tothits} Hits
            <br />
            {if $imgstats.user_email neq $email && $islogin == true}
                Rate up &nbsp;<a href="{$smarty.const.URL}/picture/rateup/{$media_id}" id="rateup" title="Rate Up"><img src="{$smarty.const.URL}/interface/icos/thumbs_up.gif" width="15px" alt="{$uname},rating-up, {$album_name}" border="0"/></a> &nbsp;
                Rate down &nbsp;<a href="{$smarty.const.URL}/picture/ratedown/{$media_id}" id="ratedown" title="Rate down"><img src="{$smarty.const.URL}/interface/icos/thumbs_down.gif" width="15px" alt="{$uname}, rating-down, {$album_name}" border="0" /></a>
            {/if}
        </div>
        <div class="ratingbox">
            Rating: {$imgstats.rating}
            {section name=foo start=1 loop=6 max=6 step=1}
                {if $smarty.section.foo.index <= $imgstats.rating}
                    <img src="{$smarty.const.URL}/interface/icos/star.png" alt="{$uname} , {$album_name}" width="12px"/>
                {elseif $smarty.section.foo.index > $imgstats.rating}
                    <img src="{$smarty.const.URL}/interface/icos/star_dull.png" alt="{$uname} , {$album_name}" width="12px"/>
                {/if}
            {/section}
            
            {if $album_name != ""}<br /><a href="{$smarty.const.URL}/article/categorybrowse/{$article.album_name|replace:' ':'_'}">{$album_name}{/if}</a>
        </div>
    </div>
</div>