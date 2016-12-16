<?php /* Smarty version 2.6.26, created on 2010-02-20 01:47:06
         compiled from prof_form.tpl */ ?>
<?php echo '
<script type="text/javascript">
   $(document).ready(function(){
       $("#errors").hide();
   });
</script>
'; ?>

<div style="width:740px;">
    <div id="errors"></div>
    <div id="pginfo">
        Creating Profile is a means by which you can show some information about you to the world, to anyone who came across your name by searching.
        You may want them to know about yourself, your occupation, address, country, etc. The form below lets you give some information about you so you can easiliy be searched by users of conveylive aswell as from search engines like google.
    </div>
     
    <form name="profileform" id="frmprof" method="post" enctype="multipart/form-data" action="<?php echo @URL; ?>
/submitprofile.php">
        <fieldset>
            <?php if ($this->_tpl_vars['action'] == 'update'): ?>
                <legend>Update your profile </legend>
            <?php else: ?>
                <legend>Fill out these information to proceed with your profile creation</legend>
            <?php endif; ?>
            <input type="hidden" name="action" value="<?php echo $this->_tpl_vars['action']; ?>
" />
            <input type="hidden" name="user_email" value="<?php echo $this->_tpl_vars['user_email']; ?>
" />
            <div>
                <span>
                    Fields marked with (**) are required
                </span>
            </div>
            <div class="formSepHead">
                Personal Information
            </div>
            <div>
                <span>
                    <div style="float:left; width:130px;"><label for="rel_status">Relationship Status:</label></div>
                    <select name="rel_status" id="rel_status">
                         <option value="">Select</option>
                            <?php $_from = $this->_tpl_vars['relStatusList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['status']):
?>
                                <?php if ($this->_tpl_vars['data']['rel_status'] == $this->_tpl_vars['status']): ?>
                                   <option value="<?php echo $this->_tpl_vars['status']; ?>
" selected = "selected"><?php echo $this->_tpl_vars['status']; ?>
</option>
                                <?php elseif ($this->_tpl_vars['data']['rel_status'] != $this->_tpl_vars['status']): ?>
                                <option value="<?php echo $this->_tpl_vars['status']; ?>
"><?php echo $this->_tpl_vars['status']; ?>
</option>
                                <?php endif; ?>                        
                            <?php endforeach; endif; unset($_from); ?>
                    </select>
                </span>
            </div>
            <div>
                <span>
                    <div style="float:left; width:130px;"><label for="lookfor">Looking for:</label></div>
                    <select name="lookfor" id="lookfor">
                         <option value="">Select</option>
                            <?php $_from = $this->_tpl_vars['lookforList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['look']):
?>
                                <?php if ($this->_tpl_vars['data']['lookingfor'] == $this->_tpl_vars['look']): ?>
                                   <option value="<?php echo $this->_tpl_vars['look']; ?>
" selected = "selected"><?php echo $this->_tpl_vars['look']; ?>
</option>
                                <?php elseif ($this->_tpl_vars['data']['lookfor'] != $this->_tpl_vars['look']): ?>
                                <option value="<?php echo $this->_tpl_vars['look']; ?>
"><?php echo $this->_tpl_vars['look']; ?>
</option>
                                <?php endif; ?>                        
                            <?php endforeach; endif; unset($_from); ?>
                    </select>
                </span>
            </div>            
            <div>
                <span>
                    <div style="float:left; width:130px;"><label for="religion">Religion:</label></div>
                    <input type="text" name="religion" id="religion" size="30" value="<?php echo $this->_tpl_vars['data']['religion']; ?>
"/>
                    <div class="subinfo"> Maximum 20 characters</div>
                </span>
            </div>            
            <div>
                <span>
                    <div style="width:130px;"><label for="about_me">**About Me:</label></div>
                    <textarea name="about_me" id="about_me" cols="108" rows="8" value="<?php echo $this->_tpl_vars['data']['about_me']; ?>
" ><?php echo $this->_tpl_vars['data']['about_me']; ?>
</textarea>
                    <div style="width:500px;" class="subinfo"> Maximum 500 characters</div>
                </span>
            </div>
            <div>
                <span>
                    <div style="width:150px;"><label for="interests">Interests:</label></div>
                    <textarea name="interests" id="interests" cols="108" rows="2" value="<?php echo $this->_tpl_vars['data']['interests']; ?>
" ><?php echo $this->_tpl_vars['data']['interests']; ?>
</textarea>
                    <div style="width:200px;" class="subinfo"> Maximum 100 characters</div>
                </span>
            </div>
            <div>
                <span>
                    <div style="width:150px;"><label for="favorites">Favorites:</label></div>
                    <textarea name="favorites" id="favorites"  cols="108" rows="8" value="<?php echo $this->_tpl_vars['data']['favourites']; ?>
" ><?php echo $this->_tpl_vars['data']['favourites']; ?>
</textarea>
                    <div style="width:200px;" class="subinfo"> Maximum 500 characters</div>
                </span>
            </div>
            <div>
                <span>
                    <div style="width:150px;"><label for="activities">Activities:</label></div>
                    <textarea name="activities" id="activities"  cols="108" rows="8" value="<?php echo $this->_tpl_vars['data']['activities']; ?>
" ><?php echo $this->_tpl_vars['data']['activities']; ?>
</textarea>
                    <div style="width:200px;" class="subinfo"> Maximum 500 characters</div>
                </span>
            </div>            
                        
            <div class="formSepHead">Contact Information</div>
            
            <div>
                <span>
                    <div style="float:left; width:120px;"><label for="address">** Home Address:</label></div>
                    <textarea type="text" name="address" id="address" cols="88" rows="2" value="<?php echo $this->_tpl_vars['data']['addr']; ?>
"><?php echo $this->_tpl_vars['data']['addr']; ?>
</textarea>
                    <div class="subinfo">Maximum 200 characters</div>
                </span>
            </div>
            <div>
                <span>
                    <div style="float:left; width:120px;"><label for="country">**Country:</label></div>
                    <select name="country" id="country" value="<?php echo $this->_tpl_vars['data']['country']; ?>
" >
                        <option value="">Select Country</option>
                            <?php $_from = $this->_tpl_vars['countryList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['c']):
?>
                                <?php if ($this->_tpl_vars['data']['country'] == $this->_tpl_vars['c']): ?>
                                   <option value="<?php echo $this->_tpl_vars['c']; ?>
" selected = "selected"><?php echo $this->_tpl_vars['c']; ?>
</option>
                                <?php elseif ($this->_tpl_vars['data']['country'] != $this->_tpl_vars['c']): ?>
                                <option value="<?php echo $this->_tpl_vars['c']; ?>
"><?php echo $this->_tpl_vars['c']; ?>
</option>
                                <?php endif; ?>                        
                            <?php endforeach; endif; unset($_from); ?>
                    </select>                
                </span>
                <span>
                    <div style="float:left; width:80px; margin-left:35px;"><label for="zip_code">Zip Code:</label></div>
                    <input type="text" name="zip_code" id="zip_code" size="20" value="<?php echo $this->_tpl_vars['data']['zipcode']; ?>
" />
                    <div class="subinfo" style="margin-left:35px; ">Maximum 50 characters</div>
                </span>
            </div>           
            <div>
                <span>
                    <div style="float:left; width:120px;"><label for="city">City:</label></div>
                    <input type="text" name="city" id="city" size="20" value="<?php echo $this->_tpl_vars['data']['city']; ?>
" style="float:left;" />
                    <div class="subinfo">Maximum 20 characters</div>
                </span>
                <span>
                    <div style="float:left; width:90px; margin-left:175px;"><label for="home_town">Hometown:</label></div>
                    <input type="text" name="home_town" id="home_town" size="20" value="<?php echo $this->_tpl_vars['data']['home_town']; ?>
"/>
                    <div style="margin-left:170px;" class="subinfo">Maximum 30 characters</div>
                </span>
            </div>
            <div>
                <span>                
                    <div style="float:left; width:120px;"><label for="phone">Phone:</label></div>
                    <input type="text" name="phone" id="phone" size="20" value="<?php echo $this->_tpl_vars['data']['phone']; ?>
" />
                    <div class="subinfo"> Maximum 80 characters</div>
                </span>
                <span>
                    <div style="float:left; width:120px; margin-left:20px;"><label for="web">Web Address:</label></div>
                    <input type="text" name="web" id="web" size="40" value="<?php echo $this->_tpl_vars['data']['web_url']; ?>
" />
                    <div style="margin-left:20px;"class="subinfo"> Maximum 80 characters</div>
                </span>
            </div>
            <div class="formSepHead">Educational Information</div>
            <div>
                <span>                
                    <div style="width:120px;"><label for="edu_info">Educational Info:</label></div>
                    <textarea name="edu_info" id="edu_info" wrap="virtual" cols="108" rows="4" value="<?php echo $this->_tpl_vars['data']['edu_info']; ?>
" ><?php echo $this->_tpl_vars['data']['edu_info']; ?>
</textarea>
                    <div class="subinfo"> Maximum 200 characters</div>
                </span>
            </div>
            <div class="formSepHead">Work Information</div>
            <div>
                <span>
                    <div style="width:120px;"><label for="work_info">Work description:</label></div>
                    <textarea name="work_info" id="work_info" cols="70" rows="8" value="<?php echo $this->_tpl_vars['data']['work_info']; ?>
"><?php echo $this->_tpl_vars['data']['work_info']; ?>
</textarea>
                    <div class="subinfo"> Maximum 200 characters</div>
                </span>
                <span>
                    <div style="width:80px;" ><label for="occupation">Occupation:</label></div>
                    <input type="text" name="occupation" id="occupation" size="30" value="<?php echo $this->_tpl_vars['data']['occupation']; ?>
"/>
                    <div class="subinfo"> Maximum 50 characters</div>
                </span>
            </div>
            <div>
                <span>
                    <input type="submit" name="submit" class="frmbtn" id="button" value="Submit" /><input type="reset" name="reset" class="frmbtn" id="button" value="Reset" />
                </span>
            </div>
        </fieldset>
    </form>
</div>
<?php echo '
<script type="text/javascript">
   
   $(document).ready(function(){       
       $("#frmprof").validate({
           errorLabelContainer: "#errors",
           wrapper: "p",
           rules:{
               address:{ required: true },
               country:{ required: true },
               about_me:{ required: true},
               web:{ url: true },
               religion: {maxlength: 20},
               interests :{maxlength: 100},
               favorites:{maxlength: 500},
               activities:{maxlength: 500},
               zip_code: {maxlength: 50},
               city:{maxlength: 20},
               home_town: {maxlength: 30},
               edu_info: {maxlength: 200},
               work_info:{maxlength: 200},
               occupation:{maxlength: 50}
           },
           messages:{
               address:"Enter your address",
               country:"Select country",
               about_me:"Enter something about you",
               web: "Please enter a valid web address of yours. Example: http://www.conveylive.com ",
               religion: "The religion field should have maximum 20 characters",
               interests: "The interests field must be less than or equal to 100 characters",
               favorites: "The favorites field must have less than or equal to 500 characters",
               activities: "The activities field should have less than or equal to 500 characters",
               zip_code: "The zip code must be less than or equal to 50 characters",
               city: "The city\'s name must be less than or equal to 20 characters",
               home_town: "The home town\'s name must be less than or equal to 30 characters",
               edu_info: "The education info must be less than or equal to 200 characters",
               work_info:"The work info must be less than or equal to 200 characters",
               occupation:"The occupation must be less than or equal to 50 characters"
           }
       });
   });
</script>
'; ?>