{literal}
<script type="text/javascript">
   $(document).ready(function(){
       $("#errors").hide();
   });
</script>
{/literal}
<div style="width:730px;">   
<div id="errors"></div>
<div id="pginfo">
    You can publish your personal photo albums of tours, birthday parties, convocation, friends and families, rare collection of photos, artwork etc to share with the community of conveylive.
</div>
{*include file="subtpl/had.tpl"*}
<form method="post" action="{$smarty.const.URL}/submitalbum.php" id="frmalbum" enctype="multipart/form-data">
    <fieldset>
        <legend>Create New Album</legend> 
        <input type="hidden" name="category_id" id="category_id" value="{$category_id}" />
        <div>
            <span>
                <div style="float:left; width:100px;">
                    <label for="albumname">Album Name:</label>
                </div>
                <input type="text" name="albumname" id="albumname" style="width:550px;" />
                <div class="subinfo"> Maximum 50 characters</div>
            </span>
        </div>
        <div>
            <span>
                <div style="float:left; width:100px;">
                    <label for="remarks">Remarks:</label>
                </div>
                <textarea name="remarks" id="remarks" style="width:550px;" rows="8" ></textarea>
                <div class="subinfo"> Maximum 200 characters</div>
            </span>
        </div>
        <div>
            <span>
                <div style="float:left; width:100px;">
                    <label for="picture">Photo:</label>
                </div>
                <input type="hidden" name="MAX_FILE_SIZE" value="2097152" />
                <input type="file" name="picture" id="picture" size="20" value="" />
                <div class="subinfo">File size limit 2 MB. If your upload does not work, try a smaller picture.</div>
            </span>
        </div>
        <div>
            <span>
                <div style="float:left; width:100px;"><label for="privacy">Privacy:</label></div>
                <select name='privacy' />
                   <option value='0' selected="selected">Everybody</option>
                   <option value='1'>Only Friends</option>
                </select>
            </span>
        </div>
        <div>
            <span style="padding-left:100px; ">
                <input type="submit" name="submit" class="frmbtn" value="Create Album" />
                <input type="reset" name="reset" id="reset" value="Reset" class="frmbtn" />
                <a href="{$smarty.const.URL}/home">Cancel</a>
            </span>
        </div>
    </fieldset>
</form>
<br />

{if $createImage == true}
{if $albums != null}
<form method="post" action="{$smarty.const.URL}/submitalbum.php" id="frmimg" enctype="multipart/form-data" >
    <fieldset>
        <legend>Add Album Images</legend>
        <div>You can upload maximum {$max_img} images per album. </div>
        <div>
            <span>
                <div style="float:left; width:100px;">
                    <label for="aid">Album:</label>
                </div>
                <select name="aid" id="aid">
                    {foreach item=album from=$albums}
                        {if $album.id == $aid}
                            <option value="{$album.id}" selected="selected">{$album.album_name} ({$album.tot})</option>
                        {else}
                            <option value="{$album.id}" {if $album.album_name == "Profile" && $aid == null} selected="selected" {/if} >{$album.album_name} ({$album.tot})</option>
                        {/if}
                    {/foreach}
                </select>
            </span>
        </div>
        <div>
            <span>
                <div style="float:left; width:100px;">
                    <label for="picture">Photo:</label>
                </div>
                <input type="hidden" name="MAX_FILE_SIZE" value="2097152" />
                <input type="file" name="picture" id="picture" size="20" value="" />
                <label><input type="checkbox" name="frontimg[]" id="frontimg[]" size="20" value="1" /><span class="subinfo">Set this photo as album cover</span></label>
                <div class="subinfo">File size limit 2 MB. If your upload does not work, try a smaller picture.</div>
            </span>
        </div>
        <div>
            <span style="padding-left:100px; ">
                <input type="submit" name="submit" class="frmbtn" value="Add Picture" />
                <input type="reset" name="reset" id="reset" value="Reset" class="frmbtn" />
                <a href="{$smarty.const.URL}/home">Cancel</a>
            </span>
        </div>
    </fieldset>
</form>
{/if}
{/if}

{if $albums != null}
    <br />
    <h3>Your Albums</h3>
    <br />
    <div style="float:left; width:730px;">    
        <center>
            <div style="width:720px;">
                {foreach item=album from=$albums}
                    {if $album.image_id == 0}
                    <div class="album">
                        <div class="browsealbums">
                            <center>
                                <a href='{$smarty.const.URL}/picture/albumview/{$album.id}'><img src='{$smarty.const.URL}/interface/icos/albumimg.gif.' style="max-height:100px;" alt="{$album.album_name}, conveylive" /></a>
                                <h3><a href='{$smarty.const.URL}/picture/albumview/{$album.id}'>{$album.album_name}</a></h3>
                                {$album.ins_date|date_format}<br />
                                Total {$album.tot} photo(s)<br />
                                <a href='{$smarty.const.URL}/picture/albumremove/{$album.id}'>Delete this album</a>
                                <br />
                            </center>
                        </div>
                    </div>
                    {else}
                    <div class="album">
                        <center>
                            <div class="browsealbums">
                                <a href='{$smarty.const.URL}/picture/albumview/{$album.id}'><img src='{$smarty.const.URL}/getsmimage.php?id={$album.image_id}' style="max-height:100px;" alt="{$album.album_name}, conveylive" /></a>
                                <h3><a href='{$smarty.const.URL}/picture/albumview/{$album.id}'>{$album.album_name}</a></h3>
                                {$album.ins_date|date_format}<br />
                                Total {$album.tot} photo(s)<br />
                                <a href='{$smarty.const.URL}/picture/albumremove/{$album.id}'>Delete this album</a>
                                <br />
                            </div>
                        </center>
                    </div>
                    {/if}
                {/foreach}
            </div>
        </center>
    </div>
{/if}
</div>

{literal}
<script type="text/javascript">
   
   $(document).ready(function(){      
       $("#frmalbum").validate({
       errorLabelContainer: "#errors",
       wrapper: "p",
           rules:{
               albumname:{ required: true , maxlength: 50 },
               remarks:{ maxlength: 200 },
               picture:{ required: true, allow: "jpeg|jpg|JPEG|JPG|GIF|gif|bmp|BMP" }
           },
           messages:{
               albumname: 
               {
                   required: "Please enter a name for the album.",
                   maxlength: "Album name can not have more than 50 characters"
               },
               remarks: "Remarks can not have more than 200 characters",
               picture: 
               {
                   required: "Please select an image to upload.",
                   allow: "Please upload images with any valid extensions: jpeg ,jpg, JPEG, JPG, GIF, gif, bmp, BMP"
               }
           }
       });
       
       $("#frmimg").validate({
       errorLabelContainer: "#errors",
       wrapper: "p",
           rules:{
               picture:{ required: true, allow: "jpeg|jpg|JPEG|JPG|GIF|gif|bmp|BMP" }
           },
           messages:{
               picture: 
               {
                   required: "Please select an image to upload.",
                   allow: "Please upload images with any valid extensions: jpeg ,jpg, JPEG, JPG, GIF, gif, bmp, BMP"
               }
           }
       });
   });
</script>
{/literal}