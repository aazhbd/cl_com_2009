<?php /* Smarty version 2.6.26, created on 2010-01-23 19:52:20
         compiled from search_res.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'paginate_first', 'search_res.tpl', 48, false),array('function', 'paginate_prev', 'search_res.tpl', 48, false),array('function', 'paginate_middle', 'search_res.tpl', 48, false),array('function', 'paginate_next', 'search_res.tpl', 48, false),array('function', 'paginate_last', 'search_res.tpl', 48, false),array('modifier', 'date_format', 'search_res.tpl', 103, false),array('modifier', 'replace', 'search_res.tpl', 178, false),array('modifier', 'capitalize', 'search_res.tpl', 178, false),array('modifier', 'truncate', 'search_res.tpl', 247, false),)), $this); ?>
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

<div style="float:left;width:740px;">
        <div>
        <form action="<?php echo @URL; ?>
/searchpost.php" method="post" >
            <fieldset>
                <div>
                    <span>
                        <div style="float:left;">
                            <input type="text" class="field" name="token" id="token" value="<?php echo $this->_tpl_vars['token']; ?>
"  style="width:560px;" />
                            <input type="submit" name="submit" id = "submit" class="frmbtn"  value="Search" />
                        </div>
                    </span>
                </div>
            </fieldset>
        </form>
    </div>
    <div class="bhead" style='width:97%;'>
        Search Results For Keyword(s) : <?php echo $this->_tpl_vars['token']; ?>

    </div>    
    <div id="tabs" style='98%;'>
        <ul>
            <li><a href="#tabs-1">People</a></li>
            <li><a href="#tabs-2">Pages</a></li>
            <li><a href="#tabs-3">Photos</a></li>
            <li><a href="#tabs-4">Audio</a></li>
            <li><a href="#tabs-5">Videos</a></li>
            <li><a href="#tabs-6">Blogs</a></li>
            <li><a href="#tabs-7">Clubs</a></li>
        </ul>
        <div id="tabs-1">
            <?php if ($this->_tpl_vars['people'] != null): ?>
                <div style="float:left; width:100%;">
                    <div>
                        <img src="<?php echo @URL; ?>
/interface/icos/convey-logo.png" style="width:40px;" /> <strong>People Search</strong> :<?php echo $this->_tpl_vars['pag_ppl']['total']; ?>
 result(s) found.
                        <div style="width:100%;" align="right"><?php echo smarty_function_paginate_first(array('id' => 'people'), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_prev(array('id' => 'people'), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_middle(array('id' => 'people','format' => 'page','prefix' => "",'suffix' => "",'link_prefix' => "&nbsp;",'link_suffix' => "&nbsp;"), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_next(array('id' => 'people'), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_last(array('id' => 'people'), $this);?>
</div>
                        <hr />
                        <div style="background:#F0F8FF; padding-left:5px; border: thin solid #eee; color:#336; width:100%; margin-bottom:10px;">
                            Showing <?php echo $this->_tpl_vars['pag_ppl']['first']; ?>
-<?php echo $this->_tpl_vars['pag_ppl']['last']; ?>
 of <?php echo $this->_tpl_vars['pag_ppl']['total']; ?>

                        </div>
                        <?php $_from = $this->_tpl_vars['people']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['frnd']):
?>
                            <div style="border:#eee thin solid; padding:5px; width=400px;">
                                <div>
                                    <div style="float:left; width:150px;"><img src="<?php echo @URL; ?>
/getsmimage.php?id=<?php echo $this->_tpl_vars['frnd']['user_imgs_id']; ?>
" height="70" border="1" alt="<?php echo $this->_tpl_vars['frnd']['f_name']; ?>
 <?php echo $this->_tpl_vars['frnd']['l_name']; ?>
" /></div>
                                    <div style="float:left; width:200px;">
                                        <div><h3><a href="<?php echo @URL; ?>
/profile/view/<?php echo $this->_tpl_vars['frnd']['id']; ?>
"><?php echo $this->_tpl_vars['frnd']['f_name']; ?>
 <?php echo $this->_tpl_vars['frnd']['l_name']; ?>
</a></h3></div>
                                    </div>
                                    <div style="float:left;">
                                        <div><img src="<?php echo @URL; ?>
/interface/icos/email.png" width="20" alt="<?php echo $this->_tpl_vars['frnd']['f_name']; ?>
, <?php echo $this->_tpl_vars['frnd']['l_name']; ?>
, People, Friends, Network, ConveyLive" /><a href="<?php echo @URL; ?>
/friend/sendmessage/<?php echo $this->_tpl_vars['frnd']['id']; ?>
">Send a message</a></div>
                                        <div><img src="<?php echo @URL; ?>
/interface/icos/users.png" width="20" alt="<?php echo $this->_tpl_vars['frnd']['f_name']; ?>
, <?php echo $this->_tpl_vars['frnd']['l_name']; ?>
, People, Friends, Network, ConveyLive" /><a href="<?php echo @URL; ?>
/friend/viewfriends/<?php echo $this->_tpl_vars['frnd']['id']; ?>
">View Friends</a></div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; else: ?>
                            <div class="artcont">
                                <div class="entry" style="width:90%;">
                                    <h3>No Match Found</h3>
                                </div>
                            </div>                            
                        <?php endif; unset($_from); ?>
                    </div>
                    <br />
                    <span><?php echo smarty_function_paginate_first(array('id' => 'people'), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_prev(array('id' => 'people'), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_middle(array('id' => 'people','format' => 'page','prefix' => "",'suffix' => "",'link_prefix' => "&nbsp;",'link_suffix' => "&nbsp;"), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_next(array('id' => 'people'), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_last(array('id' => 'people'), $this);?>
</span>
                </div>
            <?php else: ?>
                <div class="artcont">
                    <div class="entry" style="width:90%;">
                        <h3>No Match Found</h3>
                    </div>
                </div>            
            <?php endif; ?>            
        </div>
        <div id="tabs-2">
            <?php if ($this->_tpl_vars['articles'] != null): ?>
                <div style="float:left; width:100%;">
                    <img src="<?php echo @URL; ?>
/interface/icos/article.png" style="width:42px;" /> <strong>Page Search</strong> :<?php echo $this->_tpl_vars['pag_art']['total']; ?>
 result(s) found.
                    <div style="width:100%;" align="right"><?php echo smarty_function_paginate_first(array('id' => 'articles'), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_prev(array('id' => 'articles'), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_middle(array('id' => 'articles','format' => 'page','prefix' => "",'suffix' => "",'link_prefix' => "&nbsp;",'link_suffix' => "&nbsp;"), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_next(array('id' => 'articles'), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_last(array('id' => 'articles'), $this);?>
</div>
                    <hr />
                    <div style="background:#F0F8FF; padding-left:5px; border: thin solid #eee; color:#336; width:100%; margin-bottom:10px;">
                        Showing <?php echo $this->_tpl_vars['pag_art']['first']; ?>
-<?php echo $this->_tpl_vars['pag_art']['last']; ?>
 of <?php echo $this->_tpl_vars['pag_art']['total']; ?>

                    </div>                    
                    <?php $_from = $this->_tpl_vars['articles']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['art']):
?>
                        <div class="artcont" style="height:100px;">
                            <?php if ($this->_tpl_vars['art']['url'] == null || $this->_tpl_vars['art']['url'] == ""): ?>
                                <div class="entry" style="width:65%;"><a href='<?php echo @URL; ?>
/article/view/<?php echo $this->_tpl_vars['art']['id']; ?>
'><?php echo $this->_tpl_vars['art']['title']; ?>
</a></div>
                            <?php else: ?>
                                <div class="entry" style="width:65%;"><a href='<?php echo @URL; ?>
/a/<?php echo $this->_tpl_vars['art']['url']; ?>
'><?php echo $this->_tpl_vars['art']['title']; ?>
</a></div>
                            <?php endif; ?>
                            <div class="entry" style="width:30%;"><a href="<?php echo @URL; ?>
/profile/view/<?php echo $this->_tpl_vars['art']['pid']; ?>
"><?php echo $this->_tpl_vars['art']['f_name']; ?>
 <?php echo $this->_tpl_vars['art']['l_name']; ?>
</a></div>
                            <div class="entry" style="width:65%;"><?php echo $this->_tpl_vars['art']['sub_title']; ?>
</div>
                            <div class="entry" style="width:30%;"><?php echo ((is_array($_tmp=$this->_tpl_vars['art']['ins_date'])) ? $this->_run_mod_handler('date_format', true, $_tmp) : smarty_modifier_date_format($_tmp)); ?>
</div>
                        </div>
                    <?php endforeach; else: ?>
                        <div class="artcont">
                            <div class="entry" style="width:90%;">
                                <h3>No Match Found</h3>
                            </div>
                        </div>
                    <?php endif; unset($_from); ?>
                </div>
                <span><?php echo smarty_function_paginate_first(array('id' => 'articles'), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_prev(array('id' => 'articles'), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_middle(array('id' => 'articles','format' => 'page','prefix' => "",'suffix' => "",'link_prefix' => "&nbsp;",'link_suffix' => "&nbsp;"), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_next(array('id' => 'articles'), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_last(array('id' => 'articles'), $this);?>
</span>
            <?php else: ?>
                <div class="artcont">
                    <div class="entry" style="width:90%;">
                        <h3>No Match Found</h3>
                    </div>
                </div>
            <?php endif; ?>            
        </div>
        <div id="tabs-3">
            <?php if ($this->_tpl_vars['albums'] != null): ?>
                <div style="float:left; width:98%;">
                    <img src="<?php echo @URL; ?>
/interface/icos/images.png" style="width:42px;" /> <strong>Album Search</strong> :<?php echo $this->_tpl_vars['pag_alb']['total']; ?>
 result(s) found.
                    <div style="width:100%;" align="right"><?php echo smarty_function_paginate_first(array('id' => 'albums'), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_prev(array('id' => 'albums'), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_middle(array('id' => 'albums','format' => 'page','prefix' => "",'suffix' => "",'link_prefix' => "&nbsp;",'link_suffix' => "&nbsp;"), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_next(array('id' => 'albums'), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_last(array('id' => 'albums'), $this);?>
</div>
                    <hr />
                    <div style="background:#F0F8FF; padding-left:5px; border: thin solid #eee; color:#336; width:100%; margin-bottom:10px;">
                        Showing <?php echo $this->_tpl_vars['pag_alb']['first']; ?>
-<?php echo $this->_tpl_vars['pag_alb']['last']; ?>
 of <?php echo $this->_tpl_vars['pag_alb']['total']; ?>

                    </div> 
                    <?php $_from = $this->_tpl_vars['albums']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['album']):
?>
                        <div class="artcont">
                            <div class="entry" style="width:65%;"><a href='<?php echo @URL; ?>
/picture/albumview/<?php echo $this->_tpl_vars['album']['id']; ?>
'><?php echo $this->_tpl_vars['album']['album_name']; ?>
</a> | <?php echo ((is_array($_tmp=$this->_tpl_vars['album']['ins_date'])) ? $this->_run_mod_handler('date_format', true, $_tmp) : smarty_modifier_date_format($_tmp)); ?>
</div>
                            <div class="entry" style="width:30%;">
                                <?php if ($this->_tpl_vars['album']['pid'] != null): ?>
                                    by <a href="<?php echo @URL; ?>
/profile/view/<?php echo $this->_tpl_vars['album']['pid']; ?>
"><?php echo $this->_tpl_vars['album']['f_name']; ?>
 <?php echo $this->_tpl_vars['album']['l_name']; ?>
</a>
                                <?php else: ?>
                                    by <?php echo $this->_tpl_vars['album']['f_name']; ?>
 <?php echo $this->_tpl_vars['album']['l_name']; ?>

                                <?php endif; ?>
                            </div>
                            <div class="entry" style="width:35%;"><a href='<?php echo @URL; ?>
/picture/albumview/<?php echo $this->_tpl_vars['album']['id']; ?>
'><img src="<?php echo @URL; ?>
/getsmimage.php?id=<?php echo $this->_tpl_vars['album']['image_id']; ?>
" alt="<?php echo $this->_tpl_vars['album']['f_name']; ?>
 , <?php echo $this->_tpl_vars['album']['l_name']; ?>
 , <?php echo $this->_tpl_vars['album']['album_name']; ?>
, conveylive.com" width="120px;" /></a></div>
                            <div class="entry" style="width:20%;"><?php echo $this->_tpl_vars['album']['remarks']; ?>
</div>
                        </div>
                    <?php endforeach; else: ?>
                        <div class="artcont">
                            <div class="entry" style="width:90%;">
                                <h3>No Match Found</h3>
                            </div>
                        </div>
                    <?php endif; unset($_from); ?>
                </div>                
                <span><?php echo smarty_function_paginate_first(array('id' => 'albums'), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_prev(array('id' => 'albums'), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_middle(array('id' => 'albums','format' => 'page','prefix' => "",'suffix' => "",'link_prefix' => "&nbsp;",'link_suffix' => "&nbsp;"), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_next(array('id' => 'albums'), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_last(array('id' => 'albums'), $this);?>
</span>
            <?php else: ?>
                <div class="artcont">
                    <div class="entry" style="width:90%;">
                        <h3>No Match Found</h3>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        <div id="tabs-4">
            <?php if ($this->_tpl_vars['audios'] != null): ?>
                
                <div style="float:left; width:98%;">
                    <img src="<?php echo @URL; ?>
/interface/icos/audio.png" style="width:42px;" /> <strong>Audio Search</strong> : <?php echo $this->_tpl_vars['pag_aud']['total']; ?>
 result(s) found.
                    <div style="width:100%;" align="right"><?php echo smarty_function_paginate_first(array('id' => 'audios'), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_prev(array('id' => 'audios'), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_middle(array('id' => 'audios','format' => 'page','prefix' => "",'suffix' => "",'link_prefix' => "&nbsp;",'link_suffix' => "&nbsp;"), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_next(array('id' => 'audios'), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_last(array('id' => 'audios'), $this);?>
</div>
                    <hr />
                    <div style="background:#F0F8FF; padding-left:5px; border: thin solid #eee; color:#336; width:100%; margin-bottom:10px;">
                        Showing <?php echo $this->_tpl_vars['pag_aud']['first']; ?>
-<?php echo $this->_tpl_vars['pag_aud']['last']; ?>
 of <?php echo $this->_tpl_vars['pag_aud']['total']; ?>

                    </div>                     
                    <?php $_from = $this->_tpl_vars['audios']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['audio']):
?>
                        <div class="artcont">
                            <div class="entry" style="width:65%;"><a href='<?php echo @URL; ?>
/audio/listen/<?php echo $this->_tpl_vars['audio']['id']; ?>
'><?php echo $this->_tpl_vars['audio']['title']; ?>
</a> </div>
                            <div class="entry" style="width:30%;">by <a href="<?php echo @URL; ?>
/profile/view/<?php echo $this->_tpl_vars['audio']['pid']; ?>
"><?php echo $this->_tpl_vars['audio']['f_name']; ?>
 <?php echo $this->_tpl_vars['audio']['l_name']; ?>
</a></div>
                            <div class="entry" style="width:30%;"><?php echo ((is_array($_tmp=$this->_tpl_vars['audio']['ins_date'])) ? $this->_run_mod_handler('date_format', true, $_tmp) : smarty_modifier_date_format($_tmp)); ?>
</a></div>
                            <div class="entry" style="width:65%;"><?php echo $this->_tpl_vars['audio']['artist']; ?>
</div>
                            <div class="entry" style="width:100%;">
                                Rating: <?php echo $this->_tpl_vars['audio']['rating']; ?>
 | View: <?php echo $this->_tpl_vars['audio']['view_count']; ?>
 | <a href="<?php echo @URL; ?>
/audio/genrebrowse/<?php echo ((is_array($_tmp=$this->_tpl_vars['audio']['category'])) ? $this->_run_mod_handler('replace', true, $_tmp, ' ', '_') : smarty_modifier_replace($_tmp, ' ', '_')); ?>
"><?php echo ((is_array($_tmp=$this->_tpl_vars['audio']['category'])) ? $this->_run_mod_handler('capitalize', true, $_tmp) : smarty_modifier_capitalize($_tmp)); ?>

                            </div>
                        </div>
                    <?php endforeach; else: ?>
                        <div class="artcont">
                            <div class="entry" style="width:90%;">
                                <h3>No Match Found</h3>
                            </div>
                        </div>
                    <?php endif; unset($_from); ?>
                </div>                
                <span><?php echo smarty_function_paginate_first(array('id' => 'audios'), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_prev(array('id' => 'audios'), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_middle(array('id' => 'audios','format' => 'page','prefix' => "",'suffix' => "",'link_prefix' => "&nbsp;",'link_suffix' => "&nbsp;"), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_next(array('id' => 'audios'), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_last(array('id' => 'audios'), $this);?>
</span>
            <?php else: ?>
                <div class="artcont">
                    <div class="entry" style="width:90%;">
                        <h3>No Match Found</h3>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        <div id="tabs-5">
            <?php if ($this->_tpl_vars['videos'] != null): ?>
                
                <div style="float:left; width:98%;">
                    <img src="<?php echo @URL; ?>
/interface/icos/video.png" style="width:42px;" /> <strong>Video Search</strong> : <?php echo $this->_tpl_vars['pag_vid']['total']; ?>
 result(s) found.
                    <div style="width:100%;" align="right"><?php echo smarty_function_paginate_first(array('id' => 'videos'), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_prev(array('id' => 'videos'), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_middle(array('id' => 'videos','format' => 'page','prefix' => "",'suffix' => "",'link_prefix' => "&nbsp;",'link_suffix' => "&nbsp;"), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_next(array('id' => 'videos'), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_last(array('id' => 'videos'), $this);?>
</div>
                    <hr />
                    <div style="background:#F0F8FF; padding-left:5px; border: thin solid #eee; color:#336; width:100%; margin-bottom:10px;">
                        Showing <?php echo $this->_tpl_vars['pag_vid']['first']; ?>
-<?php echo $this->_tpl_vars['pag_vid']['last']; ?>
 of <?php echo $this->_tpl_vars['pag_vid']['total']; ?>

                    </div>                    
                    <?php $_from = $this->_tpl_vars['videos']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['video']):
?>
                        <div class="artcont">
                            <div class="entry" style="width:65%;"><a href='<?php echo @URL; ?>
/video/watch/<?php echo $this->_tpl_vars['video']['id']; ?>
'><?php echo $this->_tpl_vars['video']['title']; ?>
</a> | <?php echo ((is_array($_tmp=$this->_tpl_vars['video']['ins_date'])) ? $this->_run_mod_handler('date_format', true, $_tmp) : smarty_modifier_date_format($_tmp)); ?>
</div>
                            <div class="entry" style="width:30%;"><a href="<?php echo @URL; ?>
/profile/view/<?php echo $this->_tpl_vars['video']['pid']; ?>
"><?php echo $this->_tpl_vars['video']['f_name']; ?>
 <?php echo $this->_tpl_vars['video']['l_name']; ?>
</a></div>
                            <div class="entry" style="width:65%;"><?php echo $this->_tpl_vars['video']['artist']; ?>
</div>
                            <div class="entry" style="width:65%;"><img src="<?php echo @URL; ?>
/getsmimage.php?id=<?php echo $this->_tpl_vars['video']['img_id']; ?>
" alt="<?php echo $this->_tpl_vars['video']['f_name']; ?>
 , <?php echo $this->_tpl_vars['video']['l_name']; ?>
 , <?php echo $this->_tpl_vars['video']['title']; ?>
, <?php echo $this->_tpl_vars['video']['additional']; ?>
, <?php echo $this->_tpl_vars['video']['meta_tags']; ?>
, conveylive.com"/></div>
                            <div class="entry" style="width:100%;">
                                Rating: <?php echo $this->_tpl_vars['video']['rating']; ?>
 | View: <?php echo $this->_tpl_vars['video']['view_count']; ?>
 | <a href="<?php echo @URL; ?>
/video/categorybrowse/<?php echo ((is_array($_tmp=$this->_tpl_vars['video']['category'])) ? $this->_run_mod_handler('replace', true, $_tmp, ' ', '_') : smarty_modifier_replace($_tmp, ' ', '_')); ?>
"><?php echo ((is_array($_tmp=$this->_tpl_vars['video']['category'])) ? $this->_run_mod_handler('capitalize', true, $_tmp) : smarty_modifier_capitalize($_tmp)); ?>
</a>
                            </div>
                        </div>
                    <?php endforeach; else: ?>
                        <div class="artcont">
                            <div class="entry" style="width:90%;">
                                <h3>No Match Found</h3>
                            </div>
                        </div>
                    <?php endif; unset($_from); ?>
                </div>                
                <span><?php echo smarty_function_paginate_first(array('id' => 'videos'), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_prev(array('id' => 'videos'), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_middle(array('id' => 'videos','format' => 'page','prefix' => "",'suffix' => "",'link_prefix' => "&nbsp;",'link_suffix' => "&nbsp;"), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_next(array('id' => 'videos'), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_last(array('id' => 'videos'), $this);?>
</span>
            <?php else: ?>
                <div class="artcont">
                    <div class="entry" style="width:90%;">
                        <h3>No Match Found</h3>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        <div id="tabs-6">
            <?php if ($this->_tpl_vars['blogposts'] != null): ?>
                <div style="float:left; width:98%;">
                    <img src="<?php echo @URL; ?>
/interface/icos/posttopic.png" style="width:42px;" /> <strong>Blog Post Search</strong> :<?php echo $this->_tpl_vars['pag_post']['total']; ?>
 result(s) found.
                    <div style="width:100%;" align="right"><?php echo smarty_function_paginate_first(array('id' => 'blogposts'), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_prev(array('id' => 'blogposts'), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_middle(array('id' => 'blogposts','format' => 'page','prefix' => "",'suffix' => "",'link_prefix' => "&nbsp;",'link_suffix' => "&nbsp;"), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_next(array('id' => 'blogposts'), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_last(array('id' => 'blogposts'), $this);?>
</div>
                    <hr />
                    <div style="background:#F0F8FF; padding-left:5px; border: thin solid #eee; color:#336; width:100%; margin-bottom:10px;">
                        Showing page <?php echo $this->_tpl_vars['pag_post']['page_current']; ?>
 of <?php echo $this->_tpl_vars['pag_post']['page_total']; ?>

                    </div>
                    <?php $_from = $this->_tpl_vars['blogposts']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['blog']):
?>
                        <div class="artcont">
                            <div class="entry" style="float:left;width:20%;"><a href="<?php echo @URL; ?>
/profile/view/<?php echo $this->_tpl_vars['blog']['pid']; ?>
"><img src='<?php echo @URL; ?>
/getsmimage.php?id=<?php echo $this->_tpl_vars['blog']['user_imgs_id']; ?>
' border="1" style="max-width:100px;max-height:150px;" alt="<?php echo $this->_tpl_vars['blog']['f_name']; ?>
, <?php echo $this->_tpl_vars['blog']['l_name']; ?>
, <?php echo $this->_tpl_vars['blog']['url']; ?>
, <?php echo $this->_tpl_vars['blog']['name']; ?>
 " /></a></div>
                            <div class="entry" style="float:left;width:50%;"><b style="font-size:16px; color:#036;"><a href='<?php echo @URL; ?>
/b/<?php echo $this->_tpl_vars['blog']['url']; ?>
/<?php echo $this->_tpl_vars['blog']['post_id']; ?>
'><?php echo ((is_array($_tmp=$this->_tpl_vars['blog']['title'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 50) : smarty_modifier_truncate($_tmp, 50)); ?>
</a></b></div>
                            <div class="entry" style="width:25%;float:right;">From the Blog: <b style="font-size:12px; color:#036;"><a href='<?php echo @URL; ?>
/b/<?php echo $this->_tpl_vars['blog']['url']; ?>
'><?php echo $this->_tpl_vars['blog']['blog_name']; ?>
</a></b></div>
                            <div class="entry" style="float:left;width:50%;"><?php echo ((is_array($_tmp=$this->_tpl_vars['blog']['ins_date'])) ? $this->_run_mod_handler('date_format', true, $_tmp) : smarty_modifier_date_format($_tmp)); ?>
</div>
                            <div class="entry" style="float:left;width:20%;">by <a href="<?php echo @URL; ?>
/profile/view/<?php echo $this->_tpl_vars['blog']['pid']; ?>
"><?php echo $this->_tpl_vars['blog']['f_name']; ?>
 <?php echo $this->_tpl_vars['blog']['l_name']; ?>
</a></div>
                            <div class="entry" style="float:left;width:50%;"><b style="font-size:12px; "><?php echo ((is_array($_tmp=$this->_tpl_vars['blog']['sub_title'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 80) : smarty_modifier_truncate($_tmp, 80)); ?>
</b></div>
                        </div>
                        <br />
                    <?php endforeach; else: ?>
                        <div class="artcont">
                            <div class="entry" style="width:90%;">
                                <h3>No Match Found</h3>
                            </div>
                        </div>
                    <?php endif; unset($_from); ?>
                </div>
                <span><?php echo smarty_function_paginate_first(array('id' => 'blogposts'), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_prev(array('id' => 'blogposts'), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_middle(array('id' => 'blogposts','format' => 'page','prefix' => "",'suffix' => "",'link_prefix' => "&nbsp;",'link_suffix' => "&nbsp;"), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_next(array('id' => 'blogposts'), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_last(array('id' => 'blogposts'), $this);?>
</span>
            <?php else: ?>
                <div class="artcont">
                    <div class="entry" style="width:90%;">
                        <h3>No Match Found</h3>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        <div id="tabs-7">
            <?php if ($this->_tpl_vars['clubs'] != null): ?>
                <div style="float:left; width:98%;">
                    <img src="<?php echo @URL; ?>
/interface/icos/club.png" style="width:42px;" /> <strong>Club Search</strong> :<?php echo $this->_tpl_vars['pag_clu']['total']; ?>
 result(s) found.
                    <div style="width:100%;" align="right"><?php echo smarty_function_paginate_first(array('id' => 'clubs'), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_prev(array('id' => 'clubs'), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_middle(array('id' => 'clubs','format' => 'page','prefix' => "",'suffix' => "",'link_prefix' => "&nbsp;",'link_suffix' => "&nbsp;"), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_next(array('id' => 'clubs'), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_last(array('id' => 'clubs'), $this);?>
</div>
                    <hr />
                    <div style="background:#F0F8FF; padding-left:5px; border: thin solid #eee; color:#336; width:100%; margin-bottom:10px;">
                        <div style="float:left:width:45%;">Showing <?php echo $this->_tpl_vars['pag_clu']['first']; ?>
-<?php echo $this->_tpl_vars['pag_clu']['last']; ?>
 of <?php echo $this->_tpl_vars['pag_clu']['total']; ?>
</div>
                    </div>
                    <?php $_from = $this->_tpl_vars['clubs']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['club']):
?>
                        <?php if ($this->_tpl_vars['club']['is_member'] == true): ?>
                            <div class="artcont">
                                <div class="entry" style="width:55%;"><a href='<?php echo @URL; ?>
/clubs/view/<?php echo $this->_tpl_vars['club']['id']; ?>
'><?php echo $this->_tpl_vars['club']['name']; ?>
</a> | <?php echo ((is_array($_tmp=$this->_tpl_vars['club']['cdate'])) ? $this->_run_mod_handler('date_format', true, $_tmp) : smarty_modifier_date_format($_tmp)); ?>
</div>
                                <div class="entry" style="width:55%;">
                                    <a href='<?php echo @URL; ?>
/clubs/view/<?php echo $this->_tpl_vars['club']['id']; ?>
'><img src="<?php echo @URL; ?>
/getsmimage.php?id=<?php echo $this->_tpl_vars['club']['image_id']; ?>
" alt="<?php echo $this->_tpl_vars['club']['name']; ?>
,<?php echo $this->_tpl_vars['club']['category']; ?>
, <?php echo $this->_tpl_vars['club']['f_name']; ?>
, <?php echo $this->_tpl_vars['club']['l_name']; ?>
 ConveyLive" width="80" border="1" /></a>
                                </div>
                                <div class="entry" style="width:25%;"><a href="<?php echo @URL; ?>
/clubs/catbrowse/<?php echo ((is_array($_tmp=$this->_tpl_vars['club']['category'])) ? $this->_run_mod_handler('replace', true, $_tmp, ' ', '_') : smarty_modifier_replace($_tmp, ' ', '_')); ?>
"><?php echo $this->_tpl_vars['club']['category']; ?>
</a></div>
                                <div class="entry" style="width:25%;">Total <?php echo $this->_tpl_vars['club']['mem_count']; ?>
 member(s)<br />Owner <a href="<?php echo @URL; ?>
/profile/view/<?php echo $this->_tpl_vars['club']['pid']; ?>
"><?php echo $this->_tpl_vars['club']['f_name']; ?>
 <?php echo $this->_tpl_vars['club']['l_name']; ?>
</a></div>
                            </div>
                        <?php elseif ($this->_tpl_vars['club']['is_member'] == false && $this->_tpl_vars['club']['privacy'] != 2): ?>
                            <div class="artcont">
                                <div class="entry" style="width:55%;"><a href='<?php echo @URL; ?>
/clubs/view/<?php echo $this->_tpl_vars['club']['id']; ?>
'><?php echo $this->_tpl_vars['club']['cname']; ?>
</a> | <?php echo ((is_array($_tmp=$this->_tpl_vars['club']['ins_date'])) ? $this->_run_mod_handler('date_format', true, $_tmp) : smarty_modifier_date_format($_tmp)); ?>
</div>
                                <div class="entry" style="width:55%;">
                                    <a href='<?php echo @URL; ?>
/clubs/view/<?php echo $this->_tpl_vars['club']['id']; ?>
'><img src="<?php echo @URL; ?>
/getsmimage.php?id=<?php echo $this->_tpl_vars['club']['club_img_id']; ?>
" alt="<?php echo $this->_tpl_vars['club']['cname']; ?>
,<?php echo $this->_tpl_vars['club']['category']; ?>
, <?php echo $this->_tpl_vars['club']['f_name']; ?>
, <?php echo $this->_tpl_vars['club']['l_name']; ?>
 ConveyLive" width="80" border="1" /></a>
                                </div>
                                <div class="entry" style="width:25%;"><a href="<?php echo @URL; ?>
/clubs/catbrowse/<?php echo ((is_array($_tmp=$this->_tpl_vars['club']['category'])) ? $this->_run_mod_handler('replace', true, $_tmp, ' ', '_') : smarty_modifier_replace($_tmp, ' ', '_')); ?>
"><?php echo $this->_tpl_vars['club']['category']; ?>
</a></div>
                                <div class="entry" style="width:25%;">Total <?php echo $this->_tpl_vars['club']['mem_count']; ?>
 member(s)<br />Owner <a href="<?php echo @URL; ?>
/profile/view/<?php echo $this->_tpl_vars['club']['pid']; ?>
"><?php echo $this->_tpl_vars['club']['f_name']; ?>
 <?php echo $this->_tpl_vars['club']['l_name']; ?>
</a></div>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; else: ?>
                        <div class="artcont">
                            <div class="entry" style="width:90%;">
                                <h3>No Match Found</h3>
                            </div>
                        </div>
                    <?php endif; unset($_from); ?>
                </div>                
                <span><?php echo smarty_function_paginate_first(array('id' => 'clubs'), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_prev(array('id' => 'clubs'), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_middle(array('id' => 'clubs','format' => 'page','prefix' => "",'suffix' => "",'link_prefix' => "&nbsp;",'link_suffix' => "&nbsp;"), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_next(array('id' => 'clubs'), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_last(array('id' => 'clubs'), $this);?>
</span>
            <?php else: ?>
                <div class="artcont">
                    <div class="entry" style="width:90%;">
                        <h3>No Match Found</h3>
                    </div>
                </div>
            <?php endif; ?>            
        </div>
    </div>
</div>
<?php echo '
<script type="text/javascript">
$(document).ready(function(){
    $(\'a.del\').click(function(){
       var link = $(this).attr(\'href\');
        jConfirm(\'Are you sure you want to delete this ?\', \'Confirmation Dialog\', function(r) {
            if(r == true){
                window.location.href = link;
            }
            else{
                return false;
            }
        });
        return false;
    })
});
</script>
'; ?>