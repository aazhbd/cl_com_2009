<?php /* Smarty version 2.6.26, created on 2010-02-15 23:13:57
         compiled from prof_view.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'prof_view.tpl', 79, false),array('modifier', 'wordwrap', 'prof_view.tpl', 94, false),array('modifier', 'truncate', 'prof_view.tpl', 292, false),array('function', 'paginate_first', 'prof_view.tpl', 230, false),array('function', 'paginate_prev', 'prof_view.tpl', 230, false),array('function', 'paginate_middle', 'prof_view.tpl', 230, false),array('function', 'paginate_next', 'prof_view.tpl', 230, false),array('function', 'paginate_last', 'prof_view.tpl', 230, false),)), $this); ?>
<div style="float:left; width:750px;">
    <?php if ($this->_tpl_vars['prof'] == null): ?>
        <div id="pginfo">
            This user does not have a public profile.
        </div>
    <?php else: ?>

        <?php echo '
        <script type="text/javascript">
            $(document).ready(function() {
                $("#reps").hide();
                $(\'#tabs\').tabs();
                $(\'#tabs\').tabs({ fx: { opacity: \'toggle\' } });
                $(\'#tabs\').tabs(\'option\', \'fx\', { opacity: \'toggle\' });
            });
        </script>
        '; ?>

        
        <?php if ($this->_tpl_vars['prof']['user_email'] == $this->_tpl_vars['email']): ?>
            <?php if ($this->_tpl_vars['prof']['pstatus'] != ""): ?>
                <div style="padding:5px; padding: 10px; margin: 5px; width: 96%;" id="profstat">
                    <?php echo $this->_tpl_vars['prof']['f_name']; ?>
 says, <?php echo $this->_tpl_vars['prof']['pstatus']; ?>

                    <a href="<?php echo @URL; ?>
/profile/remstat/<?php echo $this->_tpl_vars['email']; ?>
" class="subinfo">remove</a>
                </div>
            <?php endif; ?>
            <div style="text-align:right;">
            <form id="statusfrm" action="" method="post" >
                <fieldset>
                    <label style="padding:10px;"><?php echo $this->_tpl_vars['prof']['f_name']; ?>
 says,</label>
                    <input id="stat" name="stat" type="text" style="width:530px;" />
                    <input id="pid" name="pid" type="hidden" value="<?php echo $this->_tpl_vars['prof']['id']; ?>
" />
                    <input id="statusup" name="statusup" class="frmbtn" type="submit" value="Update" />
                </fieldset>
            </form>
            </div>
        <?php else: ?>
            <?php if ($this->_tpl_vars['prof']['pstatus'] != ""): ?>
                <div style="padding:5px; padding: 10px; margin: 5px; width: 96%;" id="profstat" id="profstat">
                    <?php echo $this->_tpl_vars['prof']['f_name']; ?>
 says, <?php echo $this->_tpl_vars['prof']['pstatus']; ?>

                </div>
            <?php endif; ?>
        <?php endif; ?>
        <br />
        <?php if ($this->_tpl_vars['prof']['user_email'] != $this->_tpl_vars['user_email'] && $this->_tpl_vars['islogin'] == true): ?>
            <div style="width:95%;padding:5px; float:left;">
                <?php if ($this->_tpl_vars['isfriend'] == false && $this->_tpl_vars['hasProfile'] == true): ?>
                    <a href="<?php echo @URL; ?>
/friend/request/<?php echo $this->_tpl_vars['prof']['id']; ?>
"><img src="<?php echo @URL; ?>
/interface/icos/personal.png" />Add as friend</a>
                <?php endif; ?>
                <?php if ($this->_tpl_vars['hasProfile'] == false): ?>
                    <a href="<?php echo @URL; ?>
/profile/create/<?php echo $this->_tpl_vars['email']; ?>
"><img src="<?php echo @URL; ?>
/interface/icos/create.png" />Create a profile to add me as friend</a>&nbsp;
                <?php endif; ?>
                <a href="<?php echo @URL; ?>
/friend/sendmessage/<?php echo $this->_tpl_vars['prof']['id']; ?>
" ><img src="<?php echo @URL; ?>
/interface/icos/mail_send.png" />Send a message</a>&nbsp;
                <a href="<?php echo @URL; ?>
/friend/viewfriends/<?php echo $this->_tpl_vars['prof']['id']; ?>
"><img src="<?php echo @URL; ?>
/interface/icos/users.png" />View Friends</a>
            </div>
        <?php elseif ($this->_tpl_vars['islogin'] == false): ?>
            <div style="width:95%;padding:5px; float:left;">
                <a href="<?php echo @URL; ?>
/signup/friend" ><img src="<?php echo @URL; ?>
/interface/icos/users.png" />Add as friend</a>&nbsp;
            </div>
        <?php endif; ?>    
        <div style="width:98%;">
            <div align="center" style="width:30%; float:left;">
                <a id="profimg" style="width:90%; float:left;" href="<?php echo @URL; ?>
/picture/view/<?php echo $this->_tpl_vars['prof']['user_imgs_id']; ?>
">
                    <img src="<?php echo @URL; ?>
/getsmimage.php?id=<?php echo $this->_tpl_vars['prof']['user_imgs_id']; ?>
" class="profpic" align="middle"  alt="<?php echo $this->_tpl_vars['prof']['f_name']; ?>
 ,<?php echo $this->_tpl_vars['prof']['l_name']; ?>
" style="max-width: 220px; max-height:250px;"/>
                </a>
            </div>
            <div style="float:left; padding: 5px; width: 60%;" id="profbox">
                <div>
                    <a href="<?php echo @URL; ?>
/profile/view/<?php echo $this->_tpl_vars['prof']['id']; ?>
" style="font-weight: bold; font-size: 16px;"><?php echo $this->_tpl_vars['prof']['f_name']; ?>
 <?php echo $this->_tpl_vars['prof']['l_name']; ?>
</a><br />
                    <?php if ($this->_tpl_vars['prof']['gender'] != null): ?>
                        <?php if ($this->_tpl_vars['prof']['gender'] == 'm'): ?>
                            Male
                        <?php elseif ($this->_tpl_vars['prof']['gender'] == 'f'): ?>
                            Female
                        <?php endif; ?>
                        <br />
                    <?php endif; ?>
                    
                    <?php if ($this->_tpl_vars['prof']['birth_date']): ?>
                        Born on <?php echo ((is_array($_tmp=$this->_tpl_vars['prof']['birth_date'])) ? $this->_run_mod_handler('date_format', true, $_tmp) : smarty_modifier_date_format($_tmp)); ?>
 <br />
                    <?php endif; ?>
                    <?php if ($this->_tpl_vars['prof']['age']): ?>
                        Age : <?php echo $this->_tpl_vars['prof']['age']; ?>
 <br />
                    <?php endif; ?>
                    
                    <?php if ($this->_tpl_vars['prof']['country'] != null): ?> From: <?php echo $this->_tpl_vars['prof']['country']; ?>
 <?php endif; ?><br />
                    <?php if ($this->_tpl_vars['prof']['lang'] != null): ?>Language: <?php echo $this->_tpl_vars['prof']['lang']; ?>
<br /> <?php endif; ?> 
                    <?php if ($this->_tpl_vars['prof']['religion'] != null): ?> Religion: <?php echo $this->_tpl_vars['prof']['religion']; ?>
 <br /><?php endif; ?> 
                     
                    <?php if ($this->_tpl_vars['prof']['phone'] != ""): ?>
                        Phone No.: <?php echo $this->_tpl_vars['prof']['phone']; ?>
 <br />  
                    <?php endif; ?>
                    
                    <?php if ($this->_tpl_vars['prof']['web_url'] != ""): ?>
                        Web: <a href="<?php echo $this->_tpl_vars['prof']['web_url']; ?>
"><?php echo ((is_array($_tmp=$this->_tpl_vars['prof']['web_url'])) ? $this->_run_mod_handler('wordwrap', true, $_tmp, 65, "<br />", true) : smarty_modifier_wordwrap($_tmp, 65, "<br />", true)); ?>
</a>
                        <br />
                    <?php endif; ?>
                    
                    <?php if ($this->_tpl_vars['prof']['last_login_date'] != null): ?>
                        Last Login: <?php echo ((is_array($_tmp=$this->_tpl_vars['prof']['last_login_date'])) ? $this->_run_mod_handler('date_format', true, $_tmp) : smarty_modifier_date_format($_tmp)); ?>
 <?php echo ((is_array($_tmp=$this->_tpl_vars['prof']['last_login_date'])) ? $this->_run_mod_handler('date_format', true, $_tmp, '%I:%M %p') : smarty_modifier_date_format($_tmp, '%I:%M %p')); ?>
<br />
                    <?php endif; ?>
                    <?php if ($this->_tpl_vars['prof']['ins_date'] != null): ?>
                        Member since <?php echo ((is_array($_tmp=$this->_tpl_vars['prof']['ins_date'])) ? $this->_run_mod_handler('date_format', true, $_tmp) : smarty_modifier_date_format($_tmp)); ?>
 <br />
                    <?php endif; ?>
                    <?php if ($this->_tpl_vars['prof']['upd_date'] != ""): ?>
                        Profile Last Updated: <?php echo ((is_array($_tmp=$this->_tpl_vars['prof']['upd_date'])) ? $this->_run_mod_handler('date_format', true, $_tmp) : smarty_modifier_date_format($_tmp)); ?>

                    <?php endif; ?>
                </div>
            </div>
        </div>
        <br />
        <div id="tabs">
            <ul>
                <li><a href="#tabs-1">Info</a></li>
                <li><a href="#tabs-2">Photos</a></li>
                <li><a href="#tabs-3">Pages</a></li>
                <li><a href="#tabs-4">Audios</a></li>
                <li><a href="#tabs-5">Videos</a></li>
                <li><a href="#tabs-6">Blogs</a></li>
                <li><a href="#tabs-7">Clubs</a></li>
            </ul>
            <div id="tabs-1">
                <div id="profbox">
                    <?php if ($this->_tpl_vars['prof']['rel_status'] != "" || $this->_tpl_vars['prof']['activities'] != "" || $this->_tpl_vars['prof']['interests'] != null || $this->_tpl_vars['prof']['favourites'] != null || $this->_tpl_vars['prof']['edu_info'] != null || $this->_tpl_vars['prof']['work_info'] != null || $this->_tpl_vars['prof']['occupation'] != null || $this->_tpl_vars['prof']['about_me'] != null || $this->_tpl_vars['prof']['lookingfor'] != null || $this->_tpl_vars['prof']['activities'] != null): ?>
                        <h3 style="color:#69C;">Personal Details</h3><br />
                    
                            <?php if ($this->_tpl_vars['prof']['about_me'] != null): ?>
                                <p><b>About me</b>: <?php echo $this->_tpl_vars['prof']['about_me']; ?>
</p>
                            <?php endif; ?>
                            
                            <?php if ($this->_tpl_vars['prof']['lookingfor'] != ""): ?>
                                <p>Looking for: <?php echo $this->_tpl_vars['prof']['lookingfor']; ?>
</p>
                            <?php endif; ?>
                            <?php if ($this->_tpl_vars['prof']['rel_status'] != ""): ?>
                                <p><b>Relationship status</b>: <?php echo $this->_tpl_vars['prof']['rel_status']; ?>
</p>
                            <?php endif; ?>
                            <?php if ($this->_tpl_vars['prof']['interests'] != null): ?>
                                <p><b>Interests</b>: <?php echo ((is_array($_tmp=$this->_tpl_vars['prof']['interests'])) ? $this->_run_mod_handler('wordwrap', true, $_tmp, 80, "\n", true) : smarty_modifier_wordwrap($_tmp, 80, "\n", true)); ?>
</p>
                            <?php endif; ?>
                            <?php if ($this->_tpl_vars['prof']['favourites'] != null): ?>
                                <p><b>Favorites</b>: <?php echo ((is_array($_tmp=$this->_tpl_vars['prof']['favourites'])) ? $this->_run_mod_handler('wordwrap', true, $_tmp, 80, "\n", true) : smarty_modifier_wordwrap($_tmp, 80, "\n", true)); ?>
</p>
                            <?php endif; ?>
                            <?php if ($this->_tpl_vars['prof']['activities'] != null): ?>
                                <p><b>Activities</b>: <?php echo ((is_array($_tmp=$this->_tpl_vars['prof']['activities'])) ? $this->_run_mod_handler('wordwrap', true, $_tmp, 80, "\n", true) : smarty_modifier_wordwrap($_tmp, 80, "\n", true)); ?>
</p>
                            <?php endif; ?>
                    <?php endif; ?>
                </div>
                <?php if ($this->_tpl_vars['prof']['edu_info'] != null): ?>
                    <div id="profbox">
                        <h3 style="color:#69C;">Educational info</h3><br />
                        <p><?php echo $this->_tpl_vars['prof']['edu_info']; ?>
</p>
                    </div>
                <?php endif; ?>
                    
                <?php if ($this->_tpl_vars['prof']['work_info'] != null || $this->_tpl_vars['prof']['occupation'] != null): ?>
                    <div id="profbox">
                        <h3 style="color:#69C;">Work info</h3><br />
                        <?php if ($this->_tpl_vars['prof']['work_info'] != null): ?>
                            <p><?php echo $this->_tpl_vars['prof']['work_info']; ?>
</p>
                        <?php endif; ?>
                        <?php if ($this->_tpl_vars['prof']['occupation'] != null): ?>
                            <p><b>Occupation</b>: <?php echo $this->_tpl_vars['prof']['occupation']; ?>
</p>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
                <div id="profbox">
                    <h3 style="color:#69C;">Contact info</h3><br />
                    <?php if ($this->_tpl_vars['prof']['addr'] != null): ?>
                        <p><b>Address</b>: <?php echo $this->_tpl_vars['prof']['addr']; ?>
</p>
                    <?php endif; ?>
                    <?php if ($this->_tpl_vars['prof']['home_town'] != ""): ?>
                        <p><b>Home Town</b>: <?php echo $this->_tpl_vars['prof']['home_town']; ?>
</p>
                    <?php endif; ?>
                    <?php if ($this->_tpl_vars['prof']['city'] != ""): ?>
                        <p><b>Current City</b>: <?php echo $this->_tpl_vars['prof']['city']; ?>
</p>
                    <?php endif; ?>
                    <?php if ($this->_tpl_vars['prof']['zipcode'] != ""): ?>
                        <p><b>Zip Code</b>: <?php echo $this->_tpl_vars['prof']['zipcode']; ?>
</p>
                    <?php endif; ?>
                    <?php if ($this->_tpl_vars['prof']['country']): ?>
                        <p><b>Country</b>: <?php echo $this->_tpl_vars['prof']['country']; ?>
</p>
                    <?php endif; ?>
                </div>
                    
                <?php if ($this->_tpl_vars['friends'] != null): ?>
                     <div style="padding:5px; width:680px;" id="profbox">
                        <p><b style="color:#69C;"><img src='<?php echo @URL; ?>
/interface/icos/users.png' style="height:20px;" alt="Friend icon" />Friends </b>- Total <?php echo $this->_tpl_vars['tot']; ?>
 friends  <a href="<?php echo @URL; ?>
/friend/viewfriends/<?php echo $this->_tpl_vars['prof']['id']; ?>
">See all</a></p>
                         <?php $_from = $this->_tpl_vars['friends']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['frnd']):
?>
                            <div style="float: left; margin:10px;" class="friend">
                                <a href='<?php echo @URL; ?>
/profile/view/<?php echo $this->_tpl_vars['frnd']['pid']; ?>
'><img src='<?php echo @URL; ?>
/getsmimage.php?id=<?php echo $this->_tpl_vars['frnd']['user_imgs_id']; ?>
' style="height:40px;max-width:80px;" alt="<?php echo $this->_tpl_vars['frnd']['f_name']; ?>
 , <?php echo $this->_tpl_vars['frnd']['f_name']; ?>
,<?php echo $this->_tpl_vars['frnd']['l_name']; ?>
, conveylive"/></a>
                                <br /><a href='<?php echo @URL; ?>
/profile/view/<?php echo $this->_tpl_vars['frnd']['pid']; ?>
'><?php echo $this->_tpl_vars['frnd']['f_name']; ?>
 <?php echo $this->_tpl_vars['frnd']['l_name']; ?>
</a>
                            </div>
                         <?php endforeach; endif; unset($_from); ?>
                     </div>
                <?php else: ?>
                    <div id="profbox" style="width:95%; margin:2px;">
                        <?php if ($this->_tpl_vars['prof']['user_email'] == $this->_tpl_vars['email']): ?>
                            <h3>No friends listed. Click <a href="<?php echo @URL; ?>
/invite.php">here</a> to invite friends from your email contacts</h3>
                        <?php else: ?>
                            <h3><?php echo $this->_tpl_vars['prof']['f_name']; ?>
 <?php echo $this->_tpl_vars['prof']['l_name']; ?>
 has no friends</h3>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
        
     
        <div id="tabs-2">
            <div style="width:98%;">
                <?php if ($this->_tpl_vars['email'] == $this->_tpl_vars['prof']['email']): ?>
                <div class="publishlink">
                    <div style="float:left;width:40px;padding:5px;"><img src="<?php echo @URL; ?>
/interface/icos/images.png" width="40" /></div>
                    <div style="float:left;width:200px;padding:10px;"><a href="<?php echo @URL; ?>
/picture/new" style="color:#39C;">Publish Your Album</a></div>
                </div>
                <?php endif; ?>
                <?php if ($this->_tpl_vars['albums'] != null): ?>
                <div>
                    <div class="bhead" style="width:95%;">
                        Albums <?php echo $this->_tpl_vars['pag_alb']['first']; ?>
-<?php echo $this->_tpl_vars['pag_alb']['last']; ?>
 of <?php echo $this->_tpl_vars['pag_alb']['total']; ?>

                    </div>
                    <br/>
                    <div class="catmenuLink" style="border:none;">
                        <?php $_from = $this->_tpl_vars['albums']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['cont']):
?>
                            <li class="list-new" >
                                <a href="<?php echo @URL; ?>
/picture/albumview/<?php echo $this->_tpl_vars['cont']['alb_id']; ?>
" ><?php echo $this->_tpl_vars['cont']['alb_title']; ?>
 </a> on <?php echo ((is_array($_tmp=$this->_tpl_vars['cont']['date'])) ? $this->_run_mod_handler('date_format', true, $_tmp) : smarty_modifier_date_format($_tmp)); ?>

                            </li>
                            <br />
                        <?php endforeach; endif; unset($_from); ?>
                    </div>
                    <br />
                    <span class="pageLink"><?php echo smarty_function_paginate_first(array('id' => 'albums'), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_prev(array('id' => 'albums'), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_middle(array('id' => 'albums','format' => 'page','prefix' => "",'suffix' => "",'link_prefix' => "&nbsp;",'link_suffix' => "&nbsp;"), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_next(array('id' => 'albums'), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_last(array('id' => 'albums'), $this);?>
</span>
                    <br /><br />
                </div>
                <?php else: ?>
                    <p><?php echo $this->_tpl_vars['prof']['f_name']; ?>
 <?php echo $this->_tpl_vars['prof']['l_name']; ?>
 did not publish any album</p>
                <?php endif; ?>
                <br />
                <?php if ($this->_tpl_vars['albumsList'] != null): ?>
                    <div style="float:left; width:740%;">
                        <center>
                            <?php $_from = $this->_tpl_vars['albumsList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['album']):
?>
                                <?php if ($this->_tpl_vars['album']['privacy'] == 0 || ( $this->_tpl_vars['album']['privacy'] == 1 && $this->_tpl_vars['album']['user_email'] == $this->_tpl_vars['prof']['email'] ) || ( $this->_tpl_vars['album']['privacy'] == 2 && $this->_tpl_vars['album']['user_email'] == $this->_tpl_vars['prof']['email'] ) || ( $this->_tpl_vars['album']['privacy'] == 1 && $this->_tpl_vars['isfriend'] == true ) || ( $this->_tpl_vars['album']['privacy'] == 2 && $this->_tpl_vars['isfriend'] == true )): ?>
                                    <?php if ($this->_tpl_vars['album']['image_id'] == 0): ?>
                                    <div class="album">
                                        <div class="browsealbums">
                                            <center>
                                                <a href='<?php echo @URL; ?>
/picture/albumview/<?php echo $this->_tpl_vars['album']['id']; ?>
'><img src='<?php echo @URL; ?>
/interface/icos/albumimg.gif.' style="max-height:100px;" alt="People, Friends, Network, ConveyLive, <?php echo $this->_tpl_vars['album']['album_name']; ?>
"/></a>
                                                <h3><a href='<?php echo @URL; ?>
/picture/albumview/<?php echo $this->_tpl_vars['album']['id']; ?>
'><?php echo $this->_tpl_vars['album']['album_name']; ?>
</a></h3>
                                                <?php echo ((is_array($_tmp=$this->_tpl_vars['album']['ins_date'])) ? $this->_run_mod_handler('date_format', true, $_tmp) : smarty_modifier_date_format($_tmp)); ?>
<br />
                                                Total <?php echo $this->_tpl_vars['album']['tot']; ?>
 photo(s)<br />
                                                <br />
                                            </center>
                                        </div>
                                    </div>
                                    <?php else: ?>
                                    <div class="album">
                                        <center>
                                            <div class="browsealbums">
                                                <a href='<?php echo @URL; ?>
/picture/albumview/<?php echo $this->_tpl_vars['album']['id']; ?>
'><img src='<?php echo @URL; ?>
/getsmimage.php?id=<?php echo $this->_tpl_vars['album']['image_id']; ?>
' style="max-height:100px;" alt="People, Friends, Network, ConveyLive, <?php echo $this->_tpl_vars['album']['album_name']; ?>
"/></a>
                                                <h3><a href='<?php echo @URL; ?>
/picture/albumview/<?php echo $this->_tpl_vars['album']['id']; ?>
'><?php echo $this->_tpl_vars['album']['album_name']; ?>
</a></h3>
                                                <?php echo ((is_array($_tmp=$this->_tpl_vars['album']['ins_date'])) ? $this->_run_mod_handler('date_format', true, $_tmp) : smarty_modifier_date_format($_tmp)); ?>
<br />
                                                Total <?php echo $this->_tpl_vars['album']['tot']; ?>
 photo(s)<br />
                                                <br />
                                            </div>
                                        </center>
                                    </div>
                                    <?php endif; ?>
                                <?php endif; ?>
                            <?php endforeach; endif; unset($_from); ?>
                        </center>
                    </div>
                <?php endif; ?>
             </div>    
        </div>
        <div id="tabs-3">
            <div style="width:98%;">
                <?php if ($this->_tpl_vars['email'] == $this->_tpl_vars['prof']['email']): ?>
                <div class="publishlink">
                    <div style="float:left;width:40px;padding:5px;"><img src="<?php echo @URL; ?>
/interface/icos/note.png" width="40" /></div>
                    <div style="float:left;width:200px;padding:10px;"><a href="<?php echo @URL; ?>
/article/new" style="color:#39C;">Publish Your Pages</a></div>
                </div>
                <?php endif; ?>
                <?php if ($this->_tpl_vars['articles'] != null): ?>
                        <div>
                            <div class="bhead" style="width:95%;">
                                Pages <?php echo $this->_tpl_vars['pag_art']['first']; ?>
-<?php echo $this->_tpl_vars['pag_art']['last']; ?>
 of <?php echo $this->_tpl_vars['pag_art']['total']; ?>

                            </div>
                            <br/>
                            <div style="width:95%;" class="catmenuLink" style="border:none;">
                                <?php $_from = $this->_tpl_vars['articles']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['cont']):
?>
                                    <li class="list-new" >
                                        <?php if ($this->_tpl_vars['cont']['art_url'] == ""): ?>
                                            <a href="<?php echo @URL; ?>
/a/<?php echo $this->_tpl_vars['cont']['art_id']; ?>
" style="color:#39C;"><?php echo ((is_array($_tmp=$this->_tpl_vars['cont']['art_title'])) ? $this->_run_mod_handler('truncate', true, $_tmp) : smarty_modifier_truncate($_tmp)); ?>
</a> on <?php echo ((is_array($_tmp=$this->_tpl_vars['cont']['date'])) ? $this->_run_mod_handler('date_format', true, $_tmp) : smarty_modifier_date_format($_tmp)); ?>

                                        <?php else: ?>
                                            <a href="<?php echo @URL; ?>
/a/<?php echo $this->_tpl_vars['cont']['art_url']; ?>
" ><?php echo ((is_array($_tmp=$this->_tpl_vars['cont']['art_title'])) ? $this->_run_mod_handler('truncate', true, $_tmp) : smarty_modifier_truncate($_tmp)); ?>
 </a> on <?php echo ((is_array($_tmp=$this->_tpl_vars['cont']['date'])) ? $this->_run_mod_handler('date_format', true, $_tmp) : smarty_modifier_date_format($_tmp)); ?>

                                        <?php endif; ?>
                                    </li>
                                    <br />
                                <?php endforeach; endif; unset($_from); ?>
                            </div>
                            <br />
                            <span class="pageLink"><?php echo smarty_function_paginate_first(array('id' => 'articles'), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_prev(array('id' => 'articles'), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_middle(array('id' => 'articles','format' => 'page','prefix' => "",'suffix' => "",'link_prefix' => "&nbsp;",'link_suffix' => "&nbsp;"), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_next(array('id' => 'articles'), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_last(array('id' => 'articles'), $this);?>
</span>
                            <br /><br />
                        </div>
                    <?php else: ?>
                        <p><?php echo $this->_tpl_vars['prof']['f_name']; ?>
 <?php echo $this->_tpl_vars['prof']['l_name']; ?>
 did not publish any page</p>
                    <?php endif; ?>
                </div>
            </div>
            <div id="tabs-4">
                <div style="width:98%;">
                    <?php if ($this->_tpl_vars['email'] == $this->_tpl_vars['prof']['email']): ?>
                    <div class="publishlink">
                        <div style="float:left;width:40px;padding:5px;"><img src="<?php echo @URL; ?>
/interface/icos/audio.png" width="40" /></div>
                        <div style="float:left;width:200px;padding:10px;"><a href="<?php echo @URL; ?>
/audio/new" style="color:#39C;">Publish Your Audios</a></div>
                    </div>
                    <?php endif; ?>
                    <?php if ($this->_tpl_vars['audios'] != null): ?>
                        <div>
                            <div class="bhead" style="width:95%;">Audios <?php echo $this->_tpl_vars['pag_aud']['first']; ?>
-<?php echo $this->_tpl_vars['pag_aud']['last']; ?>
 of <?php echo $this->_tpl_vars['pag_aud']['total']; ?>
</div>
                            <br/>
                            <div class="catmenuLink" style="border:none;">

                                <?php $_from = $this->_tpl_vars['audios']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['cont']):
?>
                                    <li class="list-new">
                                        <a href="<?php echo @URL; ?>
/audio/listen/<?php echo $this->_tpl_vars['cont']['aud_id']; ?>
" ><?php echo $this->_tpl_vars['cont']['aud_title']; ?>
 </a> on <?php echo ((is_array($_tmp=$this->_tpl_vars['cont']['date'])) ? $this->_run_mod_handler('date_format', true, $_tmp) : smarty_modifier_date_format($_tmp)); ?>

                                    </li>
                                    <br />
                                <?php endforeach; endif; unset($_from); ?>
                            </div>
                            <br />
                            <span class="pageLink"><?php echo smarty_function_paginate_first(array('id' => 'audios'), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_prev(array('id' => 'audios'), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_middle(array('id' => 'audios','format' => 'page','prefix' => "",'suffix' => "",'link_prefix' => "&nbsp;",'link_suffix' => "&nbsp;"), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_next(array('id' => 'audios'), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_last(array('id' => 'audios'), $this);?>
</span>
                            <br /><br />
                        </div>
                    <?php else: ?>
                        <p><?php echo $this->_tpl_vars['prof']['f_name']; ?>
 <?php echo $this->_tpl_vars['prof']['l_name']; ?>
 did not publish any audio</p>
                  <?php endif; ?>
                </div>
            </div>
            
            <div id="tabs-5">
                <div style="width:98%;">
                    <?php if ($this->_tpl_vars['email'] == $this->_tpl_vars['prof']['email']): ?>
                    <div class="publishlink">
                        <div style="float:left;width:40px;padding:5px;"><img src="<?php echo @URL; ?>
/interface/icos/video.png" width="40" /></div>
                        <div style="float:left;width:200px;padding:10px;"><a href="<?php echo @URL; ?>
/video/new" style="color:#39C;">Publish Your Videos</a></div>
                    </div>
                    <?php endif; ?>
                    
                    <?php if ($this->_tpl_vars['videos'] != null): ?>
                        <div>
                            <div class="bhead" style="width:95%;">Videos <?php echo $this->_tpl_vars['pag_vid']['first']; ?>
-<?php echo $this->_tpl_vars['pag_vid']['last']; ?>
 of <?php echo $this->_tpl_vars['pag_vid']['total']; ?>
</div><br/>
                            <div class="catmenuLink" style="border:none;">
                                <?php $_from = $this->_tpl_vars['videos']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['cont']):
?>        
                                    <li class="list-new">
                                        <a href="<?php echo @URL; ?>
/video/watch/<?php echo $this->_tpl_vars['cont']['vid_id']; ?>
" ><?php echo $this->_tpl_vars['cont']['vid_title']; ?>
 </a> on <?php echo ((is_array($_tmp=$this->_tpl_vars['cont']['date'])) ? $this->_run_mod_handler('date_format', true, $_tmp) : smarty_modifier_date_format($_tmp)); ?>

                                    </li>
                                    <br />
                                <?php endforeach; endif; unset($_from); ?>
                            </div>
                            <br />
                            <span class="pageLink"><?php echo smarty_function_paginate_first(array('id' => 'videos'), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_prev(array('id' => 'videos'), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_middle(array('id' => 'videos','format' => 'page','prefix' => "",'suffix' => "",'link_prefix' => "&nbsp;",'link_suffix' => "&nbsp;"), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_next(array('id' => 'videos'), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_last(array('id' => 'videos'), $this);?>
</span>
                            <br /><br />
                        </div>
                    <?php else: ?>
                        <p><?php echo $this->_tpl_vars['prof']['f_name']; ?>
 <?php echo $this->_tpl_vars['prof']['l_name']; ?>
 did not publish any video</p>
                    <?php endif; ?>
                </div>
            </div>
            
            <div id="tabs-6">
            
                <div style="width:98%;">
                    <?php if ($this->_tpl_vars['email'] == $this->_tpl_vars['prof']['email']): ?>
                    <div class="publishlink">
                        <div style="float:left;width:40px;padding:5px;"><img src="<?php echo @URL; ?>
/interface/icos/blog.png" width="40" /></div>
                        <div style="float:left;width:200px;padding:10px;"><a href="<?php echo @URL; ?>
/blog/new" style="color:#39C;">Publish Your Blog Posts</a></div>
                    </div>
                    <?php endif; ?>
                    
                <?php if ($this->_tpl_vars['blogposts'] != null): ?>
                        <div>
                            <div class="bhead" style="width:95%;">Blog Posts <?php echo $this->_tpl_vars['pag_post']['first']; ?>
-<?php echo $this->_tpl_vars['pag_post']['last']; ?>
 of <?php echo $this->_tpl_vars['pag_post']['total']; ?>
</div>
                            <br/>
                            <div class="catmenuLink" style="border:none;">
                                <?php $_from = $this->_tpl_vars['blogposts']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['cont']):
?>
                                    <li class="list-new">
                                        <a href="<?php echo @URL; ?>
/b/<?php echo $this->_tpl_vars['blog']['url']; ?>
/<?php echo $this->_tpl_vars['cont']['post_id']; ?>
" ><?php echo $this->_tpl_vars['cont']['post_title']; ?>
 </a> on <?php echo ((is_array($_tmp=$this->_tpl_vars['cont']['date'])) ? $this->_run_mod_handler('date_format', true, $_tmp) : smarty_modifier_date_format($_tmp)); ?>

                                    </li>
                                    <br />
                                <?php endforeach; endif; unset($_from); ?>
                            </div>
                            <br />
                            <span class="pageLink"><?php echo smarty_function_paginate_first(array('id' => 'blogposts'), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_prev(array('id' => 'blogposts'), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_middle(array('id' => 'blogposts','format' => 'page','prefix' => "",'suffix' => "",'link_prefix' => "&nbsp;",'link_suffix' => "&nbsp;"), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_next(array('id' => 'blogposts'), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_last(array('id' => 'blogposts'), $this);?>
</span>
                            <br /><br />
                        </div>
                <?php else: ?>
                    <p><?php echo $this->_tpl_vars['prof']['f_name']; ?>
 <?php echo $this->_tpl_vars['prof']['l_name']; ?>
 did not publish any post</p>
                <?php endif; ?>
            </div>
        </div>
        <div id="tabs-7">
            <div style="width:98%;">
                <?php if ($this->_tpl_vars['email'] == $this->_tpl_vars['prof']['email']): ?>
                    <div class="publishlink">
                        <div style="float:left;width:40px;padding:5px;"><img src="<?php echo @URL; ?>
/interface/icos/club.png" width="40" /></div>
                        <div style="float:left;width:200px;padding:10px;"><a href="<?php echo @URL; ?>
/clubs/new" style="color:#39C;">Publish Your Clubs</a></div>
                    </div>
                <?php endif; ?>
                <?php if ($this->_tpl_vars['clubs'] != null): ?>
                    <div>
                        <div class="bhead" style="width:95%;">Clubs <?php echo $this->_tpl_vars['pag_clu']['first']; ?>
-<?php echo $this->_tpl_vars['pag_clu']['last']; ?>
 of <?php echo $this->_tpl_vars['pag_clu']['total']; ?>
</div><br/>
                        <div class="catmenuLink" style="border:none;">
                            <?php $_from = $this->_tpl_vars['clubs']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['cont']):
?>
                                <li class="list-new">
                                    <a href="<?php echo @URL; ?>
/clubs/view/<?php echo $this->_tpl_vars['cont']['club_id']; ?>
" ><?php echo $this->_tpl_vars['cont']['cname']; ?>
 </a> on <?php echo ((is_array($_tmp=$this->_tpl_vars['cont']['date'])) ? $this->_run_mod_handler('date_format', true, $_tmp) : smarty_modifier_date_format($_tmp)); ?>

                                </li>
                                <br />
                            <?php endforeach; endif; unset($_from); ?>
                        </div>
                        <br />
                        <span class="pageLink"><?php echo smarty_function_paginate_first(array('id' => 'clubs'), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_prev(array('id' => 'clubs'), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_middle(array('id' => 'clubs','format' => 'page','prefix' => "",'suffix' => "",'link_prefix' => "&nbsp;",'link_suffix' => "&nbsp;"), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_next(array('id' => 'clubs'), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_last(array('id' => 'clubs'), $this);?>
</span>
                        <br /><br />
                    </div>
                <?php else: ?>
                    <p><?php echo $this->_tpl_vars['prof']['f_name']; ?>
 <?php echo $this->_tpl_vars['prof']['l_name']; ?>
 did not create any clubs</p>
                <?php endif; ?>
            </div>
        </div>
     </div>
     
     <br />
        <div style="width:98%;padding:5px; float:left;">
            <?php if ($this->_tpl_vars['coms'] != null): ?>
                <br />
                <h3><img src="<?php echo @URL; ?>
/interface/icos/comments.png" style="width:30px;" />Comments on this profile</h3>
                <br />
            <?php endif; ?>
            <div id="comlist">
                <?php if ($this->_tpl_vars['coms'] != null): ?>
                    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "comment_view.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
                <?php endif; ?>
            </div>
            <?php if ($this->_tpl_vars['islogin'] == true): ?>
                <br />
                <div>
                    <?php $this->assign('mid', $this->_tpl_vars['prof']['id']); ?>
                    <?php $this->assign('mtype', 'Profile'); ?>
                    
                    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'frm_comment.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>                    
                </div>
            <?php endif; ?>
        </div>
     <?php endif; ?>
</div>


<?php echo '
<script type="text/javascript">
    $(document).ready(function(){
        var ok = "no";
        $(\'#statusup\').click(function(){
            var stat = $(\'#stat\').val();
            var pid = $(\'#pid\').val();
            var dataString = \'stat=\'+ stat + \'&pid=\'+pid;
            var aurl = site.url + "/statupdt.php";
            if(stat.length == 0)
            {
                alert("Please type a status.");
                return false;
            }
            if(stat.length > 250)
            {
                alert("Status can not have more than 250 characters");
                return false;
            }
            $.ajax({
                type: "POST",
                url: aurl,
                data: dataString,
                cache: false,
                dataType: "html",
                async: false,
                success: function(response){
                    if(response == "not updated")
                    {
                        alert("Could not update status");
                        $("#reps").fadeIn(400).html(\'Could not update status\');
                        ok = "no";
                        return false;
                    }
                    else if(response == "updated"){
                        ok = "ok";
                        $("#reps").show();
                        $("#reps").fadeIn(400).html(\'Status updated\');
                        $("#st").fadeIn(400).html(stat);
                        return false;
                    }
                }
            });
            if(ok == "no") return false;
        });

        $("#statusfrm").validate({
            errorLabelContainer: "#reps",
            wrapper: "p",
               rules:{
                   stat:{ required: true , maxlength: 250 }
               },
               messages:{
                   stat: 
                   {
                       required: "Please type your status.",
                       maxlength: "Status can not have more than 250 characters"
                   }
               }
        });
    });
</script>
'; ?>