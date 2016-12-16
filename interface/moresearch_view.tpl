<div style="width:745px;">
<div id="pginfo">
    Here you can Search People by their profile information, Email etc. You can add people as friends from search results. If they approve, then you can become friends with them. You can also send messages to people.
</div>
<br />
{if $searchtype == 'People'}

<form name="srchform" id="srchform" method="post" action="{$smarty.const.URL}/moresearchpost.php">
    <fieldset>
    <legend>Enter your search text and/or select the category for searching people</legend>
        <input type="hidden" name="email" value="{$data.user_email}" />
        
        <div style="font-weight:bold; font-size: 16px; float:left: width:98%;  margin-top: 10px; color:#069; ">Personal Information</div>
        
        <div>
            <div style="float:left;width:150px;"><label for="name">Name:</label></div>
            <span><input type="text" name="name" id="name" style="float:left; width:200px;" /></span>
            <div style="float:left;width:80px;margin-left:30px;"><label for="sex">Sex:</label></div>
            <span>
                <select name="sex" id="sex" style="float:left; width:200px;">
                     <option value=""></option>
                     <option value="m">Male</option>
                     <option value="f">Female</option>
                </select>
            </span>
        </div>
        <div>
            <div style="float:left;width:150px;"><label for="rel_status">Relationship Status:</label></div>
            <span>
                <select name="rel_status" id="rel_status" style="float:left; width:200px;">
                     <option value=""> </option>
                        {foreach item=status from=$data.relStatusList}
                            <option value="{$status}">{$status}</option>
                        {/foreach}
                </select>
            </span>
            <div style="float:left;width:80px;margin-left:30px;"><label for="user_email">Email:</label></div>
            <input type="text" name="user_email" id="user_email"  style="float:left; width:202px;"/>
        </div>        
        <div>
            <div style="float:left;width:150px;"><label for="year">Birth Year:</label></div>
            <span>
                <select name="year" id="year" style="width:200px; float:left;">
                    <option value=""></option>
                    {section name=y start=1950 loop=2051 step=1}
                        <option value="{$smarty.section.y.index}">{$smarty.section.y.index}</option>
                    {/section}                    
                </select>
            </span>
            <div style="float:left;width:80px;margin-left:30px;"><label for="month">Birth Month:</label></div>
            <span>
                <select name="month" id="month" style="width:200px; float:left;">
                    <option value=""></option>
                    {foreach item="m" from=$monthList key=k}
                        <option value="{$k}">{$m}</option>
                    {/foreach}                    
                </select>
            </span>
        </div>
        <div>
            <div style="float:left;width:150px;"><label for="religion">Religion:</label></div>
            <span>
                <select name="religion" id="religion" style="width:202px; float:left;">
                    <option value=""></option>
                    {foreach item=c from=$data.religionList}
                        <option value="{$c}">{$c}</option>
                    {/foreach}
                </select>
            </span>            
            <div style="float:left;width:80px;margin-left:25px;"><label for="religion">Language:</label></div>
            <span>
                <select name="language" id="language" style="width:202px; float:left;">
                    <option value=""></option>
                    {foreach item=c from=$data.languageList}
                        <option value="{$c}">{$c}</option>
                    {/foreach}
                </select>
            </span>
        </div>
        <div>
            <div style="float:left;width:150px;"><label for="religion">Interests:</label></div>
            <span><input type="text" name="interests" id="interests" style="width:200px; float:left;" /></span>
            <div style="float:left;width:80px;margin-left:25px;"><label for="religion">Favorites:</label></div>
            <span><input type="text" name="favorites" id="favorites" style="width:200px; float:left;" /></span>
        </div>        
        
        <div style="font-weight:bold; float:left: width:98%; margin-top: 10px; font-size: 16px; color:#069;">Contact Information</div>
        
        <div>
            <div style="float:left;width:150px;"><label for="country">Country:</label></div>
            <span>
                <select name="country" id="country" style="width:200px; float:left;">
                    <option value=""></option>
                    {foreach item=c from=$data.countryList}
                        <option value="{$c}">{$c}</option>
                    {/foreach}
                </select>
            </span>
            <div style="float:left;width:80px;margin-left:30px;"><label for="city">City:</label></div>
            <span>
                <select name="city" id="city" style="width:200px; float:left;">
                    <option value=""></option>
                    {foreach item=c from=$data.cityList}
                        <option value="{$c}">{$c}</option>
                    {/foreach}
                </select>
            </span>
        </div>
        <div>
            <div style="float:left;width:150px;"><label for="religion">Address:</label></div>
            <span><input type="text" name="address" id="address" style="float:left; width:200px;" /></span>
            <div style="float:left;width:80px;margin-left:25px;"><label for="home_town">Hometown:</label></div>
            <span>
                <select name="home_town" id="home_town" style="width:202px; float:left;">
                    <option value=""></option>
                    {foreach item=c from=$data.htownList}
                        <option value="{$c}">{$c}</option>
                    {/foreach}
                </select>
            </span>
        </div>
        
        <div style="font-weight:bold; float:left: width:98%; margin-top: 10px; font-size: 16px; color:#069;">Education and Work Information</div>
        
        <div>
            <div style="float:left;width:150px;"><label for="religion">Educational Info:</label></div>
            <span><input type="text" name="eduinfo" id="eduinfo" style="width:200px; float:left;" /></span>
            <div style="float:left;width:80px;margin-left:25px;"><label for="religion">Work Info:</label></div>
            <span><input type="text" name="workinfo" id="workinfo" style="width:200px; float:left;" /></span>
        </div>
        <div>
            <div style="float:left;width:150px;"><label for="religion">Occupation:</label></div>
            <span>
                <select name="occupation" id="occupation" style="width:202px; float:left;">
                    <option value=""></option>
                    {foreach item=c from=$data.occupationList}
                        <option value="{$c}">{$c}</option>
                    {/foreach}
                </select>
            </span>
            <div style="float:left;width:80px;margin-left:25px;"><label for="weburl">Web URL:</label></div>
            <span><input type="text" name="weburl" id="weburl" style="width:200px; float:left;" /></span>                        
        </div>
        <div>
            <input type="hidden" name="searchtype" id="searchtype" size="40" value="{$searchtype}" />
            <div style="float:left;width:150px;"><label for="submit">&nbsp;</label></div>
            <span><input type="submit" name="submit" id="button" value="Search" class="frmbtn"/>
            <input type="reset" name="reset" id="button" value="Reset" class="frmbtn" /></span>
        </div>
        </fieldset>
</form>
{/if}
</div>