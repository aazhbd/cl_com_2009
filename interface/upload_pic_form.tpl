<div style="width:740px;">
    <div id="pginfo">
        Update your profile photos from here.
        You may upload photos for your profile and the photos you have uploaded can be seen as an album from the link below , "Profile Photos Album".
        Your published albums are also displayed in this page. You may also chose images from your photo album and set them as your profile picture.
    </div>
    
    <span>
        <strong><a href="{$smarty.const.URL}/picture/albumview/0">Profile Photos Album</a></strong>&nbsp;|&nbsp;<strong><a href="{$smarty.const.URL}/picture/new">Create New Album</a></strong>
    </span>
    <br /><br />

    {if $action == "update"}
        <div style="width:330px;float:left;">
            <div><strong>Current Profile Picture</strong></div> 
            <br />
            <div style="width:300px;">
                <center>
                    <span>
                        <img src="{$smarty.const.URL}/getsmimage.php?id={$data.user_imgs_id}" name="pic" id="pic" style="border:1px #ccc solid;min-width:200px; max-height:300px;" alt="People, Friends, Network, ConveyLive, Album"/>
                    </span>
                </center>
            </div>
        </div>
    {/if}
    <div style="width:390px;float:left;margin-top:40px;">
        <form id="frmimgnew" method="post" enctype="multipart/form-data" action="{$smarty.const.URL}/savepicture.php">
            <fieldset title="ProfileImage">
            {if $action == "update"}
                <legend>Update your profile photo</legend>
                {else}
                <legend>Add new profile picture</legend>
            {/if}
                <input type="hidden" name="action" value="{$action}" />
                <input type="hidden" name="user_email" value="{$user_email}" />
                <input type="hidden" name="aid" value="{$aid}" />                
                <div>
                    <span>
                        <input type="hidden" name="MAX_FILE_SIZE" value="2097152" />
                        <div style="float:left; width:150px;"><label for="picture">Upload Picture:</label></div>
                        <input type="file" name="picture" id="picture" size="20" value=""/>
                        <div style="float:left;">File size limit is 2 MB. If your upload does not work, try a smaller picture</div>
                    </span>
                </div>
                <div>
                    <span>
                        <input type="submit" name="submit" class="frmbtn" id="button" value="Upload" />
                    </span>
                </div>
            </fieldset>
        </form>
    </div>
    
    <br />
    
    {if $albums != null}
        <div style="width:740px;float:left;padding-top:50px;">
            <h3>Your Albums</h3>
            <br />
            <div style="float:left; width:730px;">    
                <center>
                    <div style="width:700px;">
                        {foreach item=album from=$albums}

                            <div class="album">
                                <center>
                                    <div class="browsealbums">
                                        <a href='{$smarty.const.URL}/picture/albumview/{$album.id}'><img src='{$smarty.const.URL}/getsmimage.php?id={$album.image_id}' style="max-height:100px;" alt="People, Friends, Network, ConveyLive, {$album.album_name}"/></a>
                                        <h3><a href='{$smarty.const.URL}/picture/albumview/{$album.id}'>{$album.album_name}</a></h3>
                                        {$album.ins_date|date_format}<br />
                                        Total {$album.tot} photo(s)<br />
                                        <a href='{$smarty.const.URL}/picture/albumremove/{$album.id}'>Delete this album</a>
                                        <br />
                                    </div>
                                </center>
                            </div>

                        {/foreach}
                    </div>
                </center>
            </div>
        </div>
    {/if}
</div>
{literal}
<script type="text/javascript">
   
   $(document).ready(function(){       
       $("#frmimgnew").validate({
           errorLabelContainer: "#errors",
           wrapper: "p",
           rules:{
               picture:{ required: true,  allow: "jpeg|jpg|JPEG|JPG|GIF|gif|bmp|BMP" }
           },
           messages:{
               picture:"Select a picture from your computer.",
               allow: "Please upload images with any valid extensions: jpeg ,jpg, JPEG, JPG, GIF, gif, bmp, BMP"
           }
       });
   });
</script>
{/literal}