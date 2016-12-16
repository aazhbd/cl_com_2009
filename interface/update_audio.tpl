{php}$id = $_GET['id'];{/php}
{literal}
<script type="text/javascript">
    $(document).ready(function() {
        $("#reps").hide();
    });
</script>
{/literal}
<div style="width:745px;">
    <div id="reps"></div>
    <form method="post" action="{$smarty.const.URL}/submitaudio.php" id="frmaudio" enctype="multipart/form-data" >
        <fieldset>
            <legend>Add Audio</legend>
            <input type="hidden" name="id" id="id" value="{$audio.id}"/>
            <div>
                <span>
                    <div style="float:left; width:90px;"><label for="audiotitle">Title : </label></div>
                    <input type="text" name="audiotitle" id="audiotitle" style="width:400px;" value="{$audio.title}"/>
                </span>
            </div>
            <div>
                <span>
                    <div style="float:left; width:90px;"><label for="artist">Artist(s): </label></div>
                    <textarea id="artist" name="artist" cols="50" rows="5" style="width:400px;">{$audio.artist}</textarea>
                </span>
            </div>
            <div>
                <span>
                    <div style="float:left; width:90px;"><label for="genre">Genre: </label></div>
                    <select name='genre' id='genre' style="width:230px;">
                        {if $audio.genre == null}
                            <option value='' selected="selected" style="color:#CCC">Select</option>
                        {/if}
                        {foreach item=genre from=$genreList}
                            
                            {if $audio.category_id == $genre.id}
                                <option selected="selected" value='{$genre.id}' style="color:#636;">{$genre.cname}</option>
                            {else}
                                <option value='{$genre.id}'>{$genre.cname}</option>
                            {/if}
                        {/foreach}
                    </select>
                </span>
            </div>
            <div>
                <span>
                    {if $action == 'update'}
                    <input type="submit" value="Edit" class="frmbtn"/>
                    {/if}
                    <input type="reset" value="Reset" class="frmbtn" />
                    <input type="hidden" value="{$action}" name="action" />
                </span>
            </div>
            <div style="float:left;width:720px;">
                <span style="float:left;">
                    <label for="meta_tags">Keywords: </label><br />
                    <textarea id="meta_tags" name="meta_tags" style="width:320px;" rows="8" >{$audio.meta_tags}</textarea>
                    <div style="width:250px;" class="subinfo">Maximum 200 characters. Seperate your keywords with comma (,) to make it available to the search engines</div>
                </span>
                <span style="float:right;">
                    <label for="additional">Additional: </label><br />
                    <textarea id="additional" name="additional" style="width:335px;" rows="8" >{$audio.additional}</textarea>
                    <div style="width:250px;" class="subinfo">Maximum 200 characters</div>
                </span>
            </div>
        </fieldset>
    </form>
</div>
{literal}
<script type="text/javascript">
    $(document).ready(function()
    {
        $("#frmaudio").validate(
        {
            errorLabelContainer: "#reps",
            wrapper: "p",
            rules: {
                genre: { required: true },
                audiotitle: { required: true, maxlength: 100, minlength: 1 },
                artist: { required: true, maxlength: 200,  minlength: 1 },
                additional: { maxlength: 200 },
                meta_tags: { maxlength: 200 }
            },
            messages: {
                genre: { required: "Select genre for this audio to upload" },
                audiotitle: {
                    required: "Please write the title for this audio",
                    maxlength: "The title should be within 100 characters",
                    minlength: "Please write the title for this audio"
                },
                artist: {
                    required: "Please put atleast one name of the artist/band for this audio",
                    maxlength: "The artist name should be within 200 characters",
                    minlength: "Please write the title for this audio"
                },
                additional: {
                    maxlength: "The additional information should be within 200 characters"
                },
                meta_tags: {
                    maxlength: "The Keywords should be within 200 characters"
                }
            }
        });
    });
</script>
{/literal}