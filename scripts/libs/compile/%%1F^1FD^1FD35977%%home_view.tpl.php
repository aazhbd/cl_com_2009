<?php /* Smarty version 2.6.26, created on 2010-02-18 13:16:07
         compiled from home_view.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'home_view.tpl', 140, false),array('function', 'paginate_first', 'home_view.tpl', 151, false),array('function', 'paginate_prev', 'home_view.tpl', 151, false),array('function', 'paginate_middle', 'home_view.tpl', 151, false),array('function', 'paginate_next', 'home_view.tpl', 151, false),array('function', 'paginate_last', 'home_view.tpl', 151, false),)), $this); ?>

<div style="float:left; width:740px;">
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
            <div id="profstat" style="padding: 10px; margin: 5px; width: 96%;" >
                <?php echo $this->_tpl_vars['prof']['f_name']; ?>
 says, <?php echo $this->_tpl_vars['prof']['pstatus']; ?>
 <a href="<?php echo @URL; ?>
/profile/remstat/<?php echo $this->_tpl_vars['email']; ?>
" class="subinfo">remove</a>
            </div>
        <?php endif; ?>
        
        <div style="text-align:left;">
        <form id="statusfrm" action="" method="post" >
            <fieldset>
                <label><?php echo $this->_tpl_vars['prof']['f_name']; ?>
 says, </label>
                <input id="stat" name="stat" type="text" style="width:530px;" />
                <input id="pid" name="pid" type="hidden" value="<?php echo $this->_tpl_vars['prof']['id']; ?>
" />
                <input id="statusup" name="statusup" class="frmbtn" type="submit" value="Update" />
            </fieldset>
        </form>
        </div>
        <br />
    <?php endif; ?>

<div style="float:left;width:740px;">
    <div style="float:left;width:455px;">
        <a href="<?php echo @URL; ?>
/article/browse">
        <div style="float:left; width:215px;  height:110px;" class="item">
            <img src="<?php echo @URL; ?>
/interface/icos/article.png" alt="Browse Articles, Literature, Document, Writeup, Text" height="60px"/>
            <br />
            <h3>Pages</h3>
            Explore all kind of writeups, literature, documents, articles and journals
        </div>
        </a>
        <a href="<?php echo @URL; ?>
/picture/browse">
        <div style="float:left; width:215px;  height:110px;" class="item">
            <img src="<?php echo @URL; ?>
/interface/icos/images.png" alt="Browse Albums, Image, Picture, Photo, Album" height="60px"/>
            <br />
            <h3>Albums</h3>
            See the latest albums and photos published by the other users at conveylive
        </div>
        </a>
        <a href="<?php echo @URL; ?>
/audio/browse">
        <div style="float:left; width:215px;  height:110px;" class="item">
            <img src="<?php echo @URL; ?>
/interface/icos/audio.png" alt="Browse Audio, Recording, Music, Audio, Sound, Voice" height="60px"/>
            <br />
            <h3>Audio</h3>
            Explore and listen to all kinds of recording, personal songs, music; Share your sound with the world.
        </div>
        </a>
        <a href="<?php echo @URL; ?>
/video/browse">
        <div style="float:left; width:215px;  height:110px;" class="item">
            <img src="<?php echo @URL; ?>
/interface/icos/video.png" alt="Browse Video, Video, Broadcast, Movie, Clip, Share" height="60px"/>
            <br />
            <h3>Video</h3>
            Explore and watch new personal video, clips and share with the community of conveylive
        </div>
        </a>
        <a href="<?php echo @URL; ?>
/blog/browseall">
        <div style="float:left; width:215px;  height:110px;" class="item">
            <img src="<?php echo @URL; ?>
/interface/icos/blog.png" alt="Browse Blogs, Writeup, Discuss, Share" height="60px"/>
            <br />
            <h3>Blog</h3>
            Browse community blogs, the online journals where people post their short writeups, experience or daily incidents.
        </div>
        </a>
        <a href="<?php echo @URL; ?>
/clubs/browse">
        <div style="float:left; width:215px;  height:110px;" class="item">
            <img src="<?php echo @URL; ?>
/interface/icos/club.png" alt="Browse Clubs, Club, Community, Discuss, Share, Topic, Post, Network, Group, People, Interest" height="60px"/>
            <br />
            <h3>Clubs</h3>
            Browse and join conveylive clubs to communicate, discuss and share files and images.
        </div>
        </a>
    </div>
    <div class="innerbox" style="float:right;width:270px;">
        <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "invite.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
        <div style="width:270px;">
            <?php if ($this->_tpl_vars['req_count'] > 0): ?>
                <div class="msgbox" >
                    <h3><img src="<?php echo @URL; ?>
/interface/icos/users.png" alt="Friends, Requests" height="30px"/>Friend Requests</h3>
                    <a href='<?php echo @URL; ?>
/friend/requestlist'>You have <?php echo $this->_tpl_vars['req_count']; ?>
 friend request(s)</a>
                </div>
            <?php endif; ?>
        </div>
        <div style="width:270px;">
            <?php if ($this->_tpl_vars['joinreq_count'] > 0): ?>
                <div class="msgbox" >
                    <h3><img src="<?php echo @URL; ?>
/interface/icos/club.png" alt="Friends, Requests" height="30px"/>Club Join Requests</h3>
                    <a href='<?php echo @URL; ?>
/clubs/joinrequestlist'>You have <?php echo $this->_tpl_vars['joinreq_count']; ?>
 request(s) to join club(s)</a>
                </div>
            <?php endif; ?>
        </div>
        <div style="width:270px;">
            <?php if ($this->_tpl_vars['mail_count'] > 0): ?>
                <div class="msgbox" >
                    <h3><img src="<?php echo @URL; ?>
/interface/icos/mail.png" alt="Mail, Networking, Communication" height="30px"/>Unread Messages</h3>
                    <a href='<?php echo @URL; ?>
/message/inbox'>You have <?php echo $this->_tpl_vars['mail_count']; ?>
 unread messages</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<div style='float:left;width:740px'>

    <div class="bhead" style='width:713px'>
        News Feed
    </div>    
    <div id="tabs" style='width:730px'>
        <ul>
            <li><a href="#tabs-1">Status</a></li>
            <li><a href="#tabs-2">Pages</a></li>
            <li><a href="#tabs-3">Photos</a></li>
            <li><a href="#tabs-4">Audio</a></li>
            <li><a href="#tabs-5">Videos</a></li>
            <li><a href="#tabs-6">Blogs</a></li>
            <li><a href="#tabs-7">Clubs</a></li>
        </ul>
        <div id="tabs-1">
            <?php if ($this->_tpl_vars['statuses'] != null): ?>
                <h3>Status Update <?php echo $this->_tpl_vars['pag_stat']['first']; ?>
-<?php echo $this->_tpl_vars['pag_stat']['last']; ?>
 of <?php echo $this->_tpl_vars['pag_stat']['total']; ?>
</h3><br/>
                <?php $_from = $this->_tpl_vars['statuses']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['cont']):
?>
                    <?php if ($this->_tpl_vars['cont']['pstatus'] != ""): ?>
                    <div class="artcont">
                        <div class="entry" style="width:10%;">
                            <img src="<?php echo @URL; ?>
/getsmimage.php?id=<?php echo $this->_tpl_vars['cont']['user_imgs_id']; ?>
" alt="<?php echo $this->_tpl_vars['cont']['f_name']; ?>
, <?php echo $this->_tpl_vars['cont']['l_name']; ?>
" height="40px"/>
                        </div>
                        <div class="entry" style="width:80%;">
                            On <?php echo ((is_array($_tmp=$this->_tpl_vars['cont']['date'])) ? $this->_run_mod_handler('date_format', true, $_tmp) : smarty_modifier_date_format($_tmp)); ?>
  <a href="<?php echo @URL; ?>
/profile/view/<?php echo $this->_tpl_vars['cont']['pid']; ?>
"><?php echo $this->_tpl_vars['cont']['f_name']; ?>
 <?php echo $this->_tpl_vars['cont']['l_name']; ?>
 </a> changed status to  <br/><h3><i><?php echo $this->_tpl_vars['cont']['pstatus']; ?>
</i></h3>
                        </div>
                    </div>
                    <?php endif; ?>
                <?php endforeach; else: ?>
                    <div class="artcont">
                        <div class="entry" style="width:90%;">
                            <h3>You have no recent status updates</h3>
                        </div>
                    </div>
                <?php endif; unset($_from); ?>
                <span><?php echo smarty_function_paginate_first(array('id' => 'status'), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_prev(array('id' => 'status'), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_middle(array('id' => 'status','format' => 'page','prefix' => "",'suffix' => "",'link_prefix' => "&nbsp;",'link_suffix' => "&nbsp;"), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_next(array('id' => 'status'), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_last(array('id' => 'status'), $this);?>
</span>
            <?php else: ?>
                <div class="artcont">
                    <div class="entry" style="width:90%;">
                        <h3>You have no recent status updates</h3>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        <div id="tabs-2">
            <?php if ($this->_tpl_vars['articles'] != null): ?>
                <hr />
                <h3>Pages <?php echo $this->_tpl_vars['pag_art']['first']; ?>
-<?php echo $this->_tpl_vars['pag_art']['last']; ?>
 of <?php echo $this->_tpl_vars['pag_art']['total']; ?>
</h3><br/>
                <?php $_from = $this->_tpl_vars['articles']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['cont']):
?>
                    <div class="artcont">
                        <div class="entry" style="width:10%;">
                            <img src="<?php echo @URL; ?>
/getsmimage.php?id=<?php echo $this->_tpl_vars['cont']['user_imgs_id']; ?>
" alt="<?php echo $this->_tpl_vars['cont']['f_name']; ?>
, <?php echo $this->_tpl_vars['cont']['l_name']; ?>
" height="40px"/>
                        </div>
                        <div class="entry" style="width:80%;">
                            <?php if ($this->_tpl_vars['cont']['art_url'] == ""): ?>
                                    On <?php echo ((is_array($_tmp=$this->_tpl_vars['cont']['date'])) ? $this->_run_mod_handler('date_format', true, $_tmp) : smarty_modifier_date_format($_tmp)); ?>
  <a href="<?php echo @URL; ?>
/profile/view/<?php echo $this->_tpl_vars['cont']['pid']; ?>
"><?php echo $this->_tpl_vars['cont']['f_name']; ?>
 <?php echo $this->_tpl_vars['cont']['l_name']; ?>
 </a> published the page named <a href="<?php echo @URL; ?>
/article/view/<?php echo $this->_tpl_vars['cont']['art_id']; ?>
"><?php echo $this->_tpl_vars['cont']['art_title']; ?>
 </a>
                            <?php else: ?>
                                    On <?php echo ((is_array($_tmp=$this->_tpl_vars['cont']['date'])) ? $this->_run_mod_handler('date_format', true, $_tmp) : smarty_modifier_date_format($_tmp)); ?>
  <a href="<?php echo @URL; ?>
/profile/view/<?php echo $this->_tpl_vars['cont']['pid']; ?>
"><?php echo $this->_tpl_vars['cont']['f_name']; ?>
 <?php echo $this->_tpl_vars['cont']['l_name']; ?>
 </a> published the page named <a href="<?php echo @URL; ?>
/a/<?php echo $this->_tpl_vars['cont']['art_url']; ?>
"><?php echo $this->_tpl_vars['cont']['art_title']; ?>
 </a>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; else: ?>
                    <div class="artcont">
                        <div class="entry" style="width:90%;">
                            <h3>You have no recent news on pages</h3>
                        </div>
                    </div>
                <?php endif; unset($_from); ?>
                <span><?php echo smarty_function_paginate_first(array('id' => 'articles'), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_prev(array('id' => 'articles'), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_middle(array('id' => 'articles','format' => 'page','prefix' => "",'suffix' => "",'link_prefix' => "&nbsp;",'link_suffix' => "&nbsp;"), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_next(array('id' => 'articles'), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_last(array('id' => 'articles'), $this);?>
</span>
            <?php else: ?>
                <div class="artcont">
                    <div class="entry" style="width:90%;">
                        <h3>You have no recent news on Pages</h3>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        <div id="tabs-3">
            <?php if ($this->_tpl_vars['albums'] != null): ?>
                <hr />
                <h3>Albums <?php echo $this->_tpl_vars['pag_alb']['first']; ?>
-<?php echo $this->_tpl_vars['pag_alb']['last']; ?>
 of <?php echo $this->_tpl_vars['pag_alb']['total']; ?>
</h3><br/>
                <?php $_from = $this->_tpl_vars['albums']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['cont']):
?>
                    <div class="artcont">
                        <div class="entry" style="width:10%;">
                            <img src="<?php echo @URL; ?>
/getsmimage.php?id=<?php echo $this->_tpl_vars['cont']['user_imgs_id']; ?>
" alt="<?php echo $this->_tpl_vars['cont']['f_name']; ?>
, <?php echo $this->_tpl_vars['cont']['l_name']; ?>
" height="40px"/>
                        </div>                        
                        <div class="entry" style="width:80%;">
                            On <?php echo ((is_array($_tmp=$this->_tpl_vars['cont']['date'])) ? $this->_run_mod_handler('date_format', true, $_tmp) : smarty_modifier_date_format($_tmp)); ?>
 <a href="<?php echo @URL; ?>
/profile/view/<?php echo $this->_tpl_vars['cont']['pid']; ?>
"><?php echo $this->_tpl_vars['cont']['f_name']; ?>
 <?php echo $this->_tpl_vars['cont']['l_name']; ?>
 </a> published the album <a href="<?php echo @URL; ?>
/picture/albumview/<?php echo $this->_tpl_vars['cont']['alb_id']; ?>
"><?php echo $this->_tpl_vars['cont']['alb_title']; ?>
 </a> 
                        </div>
                    </div>
                <?php endforeach; else: ?>
                    <div class="artcont">
                        <div class="entry" style="width:90%;">
                            <h3>You have no recent updates on albums</h3>
                        </div>
                    </div>
                <?php endif; unset($_from); ?>
                <span><?php echo smarty_function_paginate_first(array('id' => 'albums'), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_prev(array('id' => 'albums'), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_middle(array('id' => 'albums','format' => 'page','prefix' => "",'suffix' => "",'link_prefix' => "&nbsp;",'link_suffix' => "&nbsp;"), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_next(array('id' => 'albums'), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_last(array('id' => 'albums'), $this);?>
</span>
            <?php else: ?>
                <div class="artcont">
                    <div class="entry" style="width:90%;">
                        <h3>You have no recent updates on albums</h3>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        <div id="tabs-4">
            <?php if ($this->_tpl_vars['audios'] != null): ?>
                <hr />
                <h3>Audio <?php echo $this->_tpl_vars['pag_aud']['first']; ?>
-<?php echo $this->_tpl_vars['pag_aud']['last']; ?>
 of <?php echo $this->_tpl_vars['pag_aud']['total']; ?>
</h3><br/>
                <?php $_from = $this->_tpl_vars['audios']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['cont']):
?>                    
                    <div class="artcont">
                        <div class="entry" style="width:10%;">
                            <img src="<?php echo @URL; ?>
/getsmimage.php?id=<?php echo $this->_tpl_vars['cont']['user_imgs_id']; ?>
" alt="<?php echo $this->_tpl_vars['cont']['f_name']; ?>
, <?php echo $this->_tpl_vars['cont']['l_name']; ?>
" height="40px"/>
                        </div>
                        <div class="entry" style="width:80%;">
                            On <?php echo ((is_array($_tmp=$this->_tpl_vars['cont']['date'])) ? $this->_run_mod_handler('date_format', true, $_tmp) : smarty_modifier_date_format($_tmp)); ?>
 <a href="<?php echo @URL; ?>
/profile/view/<?php echo $this->_tpl_vars['cont']['pid']; ?>
"><?php echo $this->_tpl_vars['cont']['f_name']; ?>
 <?php echo $this->_tpl_vars['cont']['l_name']; ?>
 </a> published the audio <a href="<?php echo @URL; ?>
/audio/listen/<?php echo $this->_tpl_vars['cont']['aud_id']; ?>
"><?php echo $this->_tpl_vars['cont']['aud_title']; ?>
 </a> 
                        </div>
                    </div>
                <?php endforeach; else: ?>
                    <div class="artcont">
                        <div class="entry" style="width:90%;">
                            <h3>You have no recent news on audio</h3>
                        </div>
                    </div>
                <?php endif; unset($_from); ?>
                <span><?php echo smarty_function_paginate_first(array('id' => 'audios'), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_prev(array('id' => 'audios'), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_middle(array('id' => 'audios','format' => 'page','prefix' => "",'suffix' => "",'link_prefix' => "&nbsp;",'link_suffix' => "&nbsp;"), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_next(array('id' => 'audios'), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_last(array('id' => 'audios'), $this);?>
</span>
            <?php else: ?>
                <div class="artcont">
                    <div class="entry" style="width:90%;">
                        <h3>You have no recent updates on audio</h3>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        <div id="tabs-5">
            <?php if ($this->_tpl_vars['videos'] != null): ?>
                <hr />
                <h3>Video <?php echo $this->_tpl_vars['pag_vid']['first']; ?>
-<?php echo $this->_tpl_vars['pag_vid']['last']; ?>
 of <?php echo $this->_tpl_vars['pag_vid']['total']; ?>
</h3><br/>
                <?php $_from = $this->_tpl_vars['videos']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['cont']):
?>
                    <div class="artcont">
                        <div class="entry" style="width:10%;">
                            <img src="<?php echo @URL; ?>
/getsmimage.php?id=<?php echo $this->_tpl_vars['cont']['user_imgs_id']; ?>
" alt="<?php echo $this->_tpl_vars['cont']['f_name']; ?>
, <?php echo $this->_tpl_vars['cont']['l_name']; ?>
" height="40px"/>
                        </div>
                        <div class="entry" style="width:80%;">
                            On <?php echo ((is_array($_tmp=$this->_tpl_vars['cont']['date'])) ? $this->_run_mod_handler('date_format', true, $_tmp) : smarty_modifier_date_format($_tmp)); ?>
 <a href="<?php echo @URL; ?>
/profile/view/<?php echo $this->_tpl_vars['cont']['pid']; ?>
"><?php echo $this->_tpl_vars['cont']['f_name']; ?>
 <?php echo $this->_tpl_vars['cont']['l_name']; ?>
 </a> published the audio <a href="<?php echo @URL; ?>
/video/watch/<?php echo $this->_tpl_vars['cont']['vid_id']; ?>
"><?php echo $this->_tpl_vars['cont']['vid_title']; ?>
 </a> 
                        </div>
                    </div>
                <?php endforeach; else: ?>
                    <div class="artcont">
                        <div class="entry" style="width:90%;">
                            <h3>You have no recent news on video</h3>
                        </div>
                    </div>
                <?php endif; unset($_from); ?>
                <span><?php echo smarty_function_paginate_first(array('id' => 'videos'), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_prev(array('id' => 'videos'), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_middle(array('id' => 'videos','format' => 'page','prefix' => "",'suffix' => "",'link_prefix' => "&nbsp;",'link_suffix' => "&nbsp;"), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_next(array('id' => 'videos'), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_last(array('id' => 'videos'), $this);?>
</span>
            <?php else: ?>
                <div class="artcont">
                    <div class="entry" style="width:90%;">
                        <h3>You have no recent updates on video</h3>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        <div id="tabs-6">
            <?php if ($this->_tpl_vars['blogposts'] != null): ?>
                <h3>Blog Post <?php echo $this->_tpl_vars['pag_post']['first']; ?>
-<?php echo $this->_tpl_vars['pag_post']['last']; ?>
 of <?php echo $this->_tpl_vars['pag_post']['total']; ?>
</h3><br/>
                <?php $_from = $this->_tpl_vars['blogposts']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['cont']):
?>
                    <div class="artcont">
                        <div class="entry" style="width:10%;">
                            <img src="<?php echo @URL; ?>
/getsmimage.php?id=<?php echo $this->_tpl_vars['cont']['user_imgs_id']; ?>
" alt="<?php echo $this->_tpl_vars['cont']['f_name']; ?>
, <?php echo $this->_tpl_vars['cont']['l_name']; ?>
" height="40px"/>
                        </div>
                        <div class="entry" style="width:80%;">
                            On <?php echo ((is_array($_tmp=$this->_tpl_vars['cont']['date'])) ? $this->_run_mod_handler('date_format', true, $_tmp) : smarty_modifier_date_format($_tmp)); ?>
 <a href="<?php echo @URL; ?>
/profile/view/<?php echo $this->_tpl_vars['cont']['pid']; ?>
"><?php echo $this->_tpl_vars['cont']['f_name']; ?>
 <?php echo $this->_tpl_vars['cont']['l_name']; ?>
 </a> published the blog post <a href="<?php echo @URL; ?>
/b/<?php echo $this->_tpl_vars['cont']['blog_url']; ?>
/<?php echo $this->_tpl_vars['cont']['post_id']; ?>
"><?php echo $this->_tpl_vars['cont']['post_title']; ?>
 </a> 
                        </div>
                    </div>
                <?php endforeach; else: ?>
                    <div class="artcont">
                        <div class="entry" style="width:90%;">
                            <h3>You have no recent news on blog posts</h3>
                        </div>
                    </div>
                <?php endif; unset($_from); ?>
                <span><?php echo smarty_function_paginate_first(array('id' => 'blogposts'), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_prev(array('id' => 'blogposts'), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_middle(array('id' => 'blogposts','format' => 'page','prefix' => "",'suffix' => "",'link_prefix' => "&nbsp;",'link_suffix' => "&nbsp;"), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_next(array('id' => 'blogposts'), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_last(array('id' => 'blogposts'), $this);?>
</span>
            <?php else: ?>
                <div class="artcont">
                    <div class="entry" style="width:90%;">
                        <h3>You have no recent updates on blog posts</h3>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        <div id="tabs-7">
            <?php if ($this->_tpl_vars['clubs'] != null): ?>
                <h3>Clubs <?php echo $this->_tpl_vars['pag_clu']['first']; ?>
-<?php echo $this->_tpl_vars['pag_clu']['last']; ?>
 of <?php echo $this->_tpl_vars['pag_clu']['total']; ?>
</h3><br/>
                <?php $_from = $this->_tpl_vars['clubs']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['cont']):
?>
                    <div class="artcont">
                        <div class="entry" style="width:10%;">
                            <img src="<?php echo @URL; ?>
/getsmimage.php?id=<?php echo $this->_tpl_vars['cont']['user_imgs_id']; ?>
" alt="<?php echo $this->_tpl_vars['cont']['f_name']; ?>
, <?php echo $this->_tpl_vars['cont']['l_name']; ?>
" width="40px"/>
                        </div>
                        <div class="entry" style="width:80%;">
                            On <?php echo ((is_array($_tmp=$this->_tpl_vars['cont']['date'])) ? $this->_run_mod_handler('date_format', true, $_tmp) : smarty_modifier_date_format($_tmp)); ?>
 <a href="<?php echo @URL; ?>
/profile/view/<?php echo $this->_tpl_vars['cont']['pid']; ?>
"><?php echo $this->_tpl_vars['cont']['f_name']; ?>
 <?php echo $this->_tpl_vars['cont']['l_name']; ?>
 </a> published the club <a href="<?php echo @URL; ?>
/clubs/view/<?php echo $this->_tpl_vars['cont']['club_id']; ?>
"><?php echo $this->_tpl_vars['cont']['club_name']; ?>
 </a>
                        </div>
                    </div>
                <?php endforeach; else: ?>
                    <div class="artcont">
                        <div class="entry" style="width:55%;">
                            <h3>You have no recent news on blog post</h3>
                        </div>
                    </div>
                <?php endif; unset($_from); ?>
                <span><?php echo smarty_function_paginate_first(array('id' => 'clubs'), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_prev(array('id' => 'clubs'), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_middle(array('id' => 'clubs','format' => 'page','prefix' => "",'suffix' => "",'link_prefix' => "&nbsp;",'link_suffix' => "&nbsp;"), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_next(array('id' => 'clubs'), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_last(array('id' => 'clubs'), $this);?>
</span>
            <?php else: ?>
                <div class="artcont">
                    <div class="entry" style="width:90%;">
                        <h3>You have no recent updates on clubs</h3>
                    </div>
                </div>
            <?php endif; ?>            
        </div>
    </div>
</div>

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