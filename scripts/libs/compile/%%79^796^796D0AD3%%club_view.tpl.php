<?php /* Smarty version 2.6.26, created on 2010-01-26 16:15:57
         compiled from club_view.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'club_view.tpl', 11, false),array('modifier', 'replace', 'club_view.tpl', 27, false),array('function', 'paginate_first', 'club_view.tpl', 120, false),array('function', 'paginate_prev', 'club_view.tpl', 120, false),array('function', 'paginate_middle', 'club_view.tpl', 120, false),array('function', 'paginate_next', 'club_view.tpl', 120, false),array('function', 'paginate_last', 'club_view.tpl', 120, false),)), $this); ?>

<a href="<?php echo @URL; ?>
/clubs/browse">Browse Clubs</a>&nbsp;|&nbsp;<a href="<?php echo @URL; ?>
/clubs/new">Create Club</a>
<?php if ($this->_tpl_vars['club']['clubType'] == 'secret' && $this->_tpl_vars['is_member'] == false): ?>
    <p>No such club exists</p>
<?php else: ?>
<div style="float:left; width:740px;">
    <?php if ($this->_tpl_vars['reqArr'] != null): ?>
        <div class="artcont" style="border:#ccc solid 1px; background:#eee;">
            <?php $_from = $this->_tpl_vars['reqArr']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['req']):
?>
                <div class="entry" style="width:50%;">
                    <strong><a href="<?php echo @URL; ?>
/profile/view/<?php echo $this->_tpl_vars['req']['pid']; ?>
"><?php echo $this->_tpl_vars['req']['f_name']; ?>
 <?php echo $this->_tpl_vars['req']['l_name']; ?>
</a> wants to join this club. <br/>Request sent on <?php echo ((is_array($_tmp=$this->_tpl_vars['req']['join_date'])) ? $this->_run_mod_handler('date_format', true, $_tmp) : smarty_modifier_date_format($_tmp)); ?>
</strong>
                </div>
                <div class="entry" style="width:18%;">
                    <strong><a href="<?php echo @URL; ?>
/clubs/approve/<?php echo $this->_tpl_vars['club']['id']; ?>
/<?php echo $this->_tpl_vars['req']['id']; ?>
">Approve</a></strong>
                </div>
                <div class="entry" style="width:18%;">
                    <strong><a href="<?php echo @URL; ?>
/clubs/deny/<?php echo $this->_tpl_vars['club']['id']; ?>
/<?php echo $this->_tpl_vars['req']['id']; ?>
">Deny</a></strong>
                </div>
            <?php endforeach; endif; unset($_from); ?>
        </div>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['clubType'] == 'closed' && $this->_tpl_vars['is_member'] == false): ?>
        <div class="artcont">
            <div class="entry" style="width:30%;" id="profbox" align="center"><img src="<?php echo @URL; ?>
/getimage.php?id=<?php echo $this->_tpl_vars['club']['image_id']; ?>
" alt="<?php echo $this->_tpl_vars['club']['name']; ?>
,<?php echo $this->_tpl_vars['club']['category']; ?>
" width="180" border="1" /></div>
            <div class="entry" style="width:65%; "><h3 style="color:olive; font-weight: bolder; font-size: 18px;"><?php echo $this->_tpl_vars['club']['cname']; ?>
</h3>
                <br/>Created: <?php echo ((is_array($_tmp=$this->_tpl_vars['club']['ins_date'])) ? $this->_run_mod_handler('date_format', true, $_tmp) : smarty_modifier_date_format($_tmp)); ?>

                <br/>Category: <a href="<?php echo @URL; ?>
/clubs/catbrowse/<?php echo ((is_array($_tmp=$this->_tpl_vars['club']['category'])) ? $this->_run_mod_handler('replace', true, $_tmp, ' ', '_') : smarty_modifier_replace($_tmp, ' ', '_')); ?>
"><?php echo $this->_tpl_vars['club']['category']; ?>
</a>
                <br />Club Creator: <a href="<?php echo @URL; ?>
/profile/view/<?php echo $this->_tpl_vars['club']['creator']['pid']; ?>
"><?php echo $this->_tpl_vars['club']['f_name']; ?>
 <?php echo $this->_tpl_vars['club']['l_name']; ?>
</a>
            </div>
            <div class="entry" style="width:100%;">
                <a href="<?php echo @URL; ?>
/clubs/join/<?php echo $this->_tpl_vars['club']['id']; ?>
">Join Club</a>
                <p>This is a closed group. Your request to join this group requires admin approval.</p>
            </div>        
            <div class="entry" style="width:65%;">Total <?php echo $this->_tpl_vars['club']['mem_count']; ?>
 member(s)</div>
            <?php if ($this->_tpl_vars['club']['description'] != null): ?>
                <div class="entry" style="width:100%;">
                      <?php echo $this->_tpl_vars['club']['description']; ?>

                </div>
            <?php endif; ?>
        </div>
    <?php else: ?>
    <div id="profbox" style="width:95%;">
        <div class="entry" style="width:30%;" id="profbox" align="center"><img src="<?php echo @URL; ?>
/getimage.php?id=<?php echo $this->_tpl_vars['club']['image_id']; ?>
" alt="<?php echo $this->_tpl_vars['club']['name']; ?>
,<?php echo $this->_tpl_vars['club']['category']; ?>
" style="width:95%;" border="1" align="middle"/></div>
        <div class="entry" style="width:65%; "><h3 style="color: olive; font-weight: bolder; font-size: 18px;"><?php echo $this->_tpl_vars['club']['cname']; ?>
</h3>
            <?php if ($this->_tpl_vars['club']['clubType'] == 'open'): ?>
                <p>This is an open club. Anyone can join and share there views</p>
            <?php endif; ?>
            <?php if ($this->_tpl_vars['club']['clubType'] == 'closed'): ?>
                <p>This is closed club. It requires the approval of the admin for members to join</p>
            <?php endif; ?>
            <?php if ($this->_tpl_vars['club']['clubType'] == 'secret'): ?>
                <p>This is an secret club. Members can only join here by invitation</p>
            <?php endif; ?>
            <?php if ($this->_tpl_vars['club']['description'] != null): ?>
                <div class="entry" style="width:100%;">
                    Description: <?php echo $this->_tpl_vars['club']['description']; ?>

                </div>
            <?php endif; ?>            
        </div>
        <div class="entry" style="width:100%;" align="center"  >
           <a href="#Members" style="width:20%; " class="clubpart1" id="clubtop">Members</a>
           <a href="#Photos" style="width:20%; " class="clubpart2" id="clubtop">Photos</a>
           <a href="#Topics" style="width:20%; " class="clubpart3" id="clubtop">Topics</a>
           <a href="#Shared Files" style="width:20%; " class="clubpart4" id="clubtop">Shared Files</a>
        </div>
        <div class="entry" style="width:30%;" id="profbox">
            <div class="entry" style="width:100%;">
                Owner: <a href="<?php echo @URL; ?>
/profile/view/<?php echo $this->_tpl_vars['club']['creator']['pid']; ?>
"><?php echo $this->_tpl_vars['club']['f_name']; ?>
 <?php echo $this->_tpl_vars['club']['l_name']; ?>
</a>
            </div>
            <div class="entry" style="width:30%;">
                Admin(s):
            </div>
            <div class="entry" style="width:60%;">
            <?php $_from = $this->_tpl_vars['club']['adminList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['admin']):
?>
                <div><a href="<?php echo @URL; ?>
/profile/view/<?php echo $this->_tpl_vars['admin']['pid']; ?>
"><?php echo $this->_tpl_vars['admin']['f_name']; ?>
 <?php echo $this->_tpl_vars['admin']['l_name']; ?>
</a></div>
            <?php endforeach; endif; unset($_from); ?>
            </div>
            <div class="entry" style="width:100%;">
                <br/>Created: <?php echo ((is_array($_tmp=$this->_tpl_vars['club']['ins_date'])) ? $this->_run_mod_handler('date_format', true, $_tmp) : smarty_modifier_date_format($_tmp)); ?>

                <br/>Category: <a href="<?php echo @URL; ?>
/clubs/catbrowse/<?php echo ((is_array($_tmp=$this->_tpl_vars['club']['category'])) ? $this->_run_mod_handler('replace', true, $_tmp, ' ', '_') : smarty_modifier_replace($_tmp, ' ', '_')); ?>
"><?php echo $this->_tpl_vars['club']['category']; ?>
</a>
                <br /><a href="<?php echo @URL; ?>
/clubs/viewmembers/<?php echo $this->_tpl_vars['club']['id']; ?>
">Total <?php echo $this->_tpl_vars['club']['mem_count']; ?>
 member(s)</a>
            </div>
        </div>
        <div class="entry" style="width:30%; margin-left:10px; border:none;" id="profbox">
            <?php if ($this->_tpl_vars['is_member'] == true): ?>
                <div class="catmenuLink" style="border:none; "><a href="<?php echo @URL; ?>
/clubs/invite/<?php echo $this->_tpl_vars['club']['id']; ?>
" ><img src="<?php echo @URL; ?>
/interface/icos/club_members.png" width="40px;"/>Invite friends</a></div> 
                <div class="catmenuLink" style="border:none; "><a href="<?php echo @URL; ?>
/clubs/newtopic/<?php echo $this->_tpl_vars['club']['id']; ?>
" ><img src="<?php echo @URL; ?>
/interface/icos/posttopic.png" width="40px;"/>New topic Post</a></div>
                <div class="catmenuLink" style="border:none; "><a href="<?php echo @URL; ?>
/clubs/addphotos/<?php echo $this->_tpl_vars['club']['id']; ?>
"><img src="<?php echo @URL; ?>
/interface/icos/addphoto.png" width="40px;"/>Add photos to club</a></div>
                <div class="catmenuLink" style="border:none; "><a href="<?php echo @URL; ?>
/clubs/uploadfile/<?php echo $this->_tpl_vars['club']['id']; ?>
" ><img src="<?php echo @URL; ?>
/interface/icos/sharefiles.png" width="40px;"/>Upload Files to Share</a></div>
            <?php endif; ?>
            <?php if ($this->_tpl_vars['is_admin'] == true): ?>
                <div class="catmenuLink" style="border:none; "><a href="<?php echo @URL; ?>
/clubs/clubmessage/<?php echo $this->_tpl_vars['club']['id']; ?>
" <img src="<?php echo @URL; ?>
/interface/icos/mail_new.png" width="40px;"/>Send Message to all</a></div>
            <?php endif; ?>
        </div>
        <div class="entry" style="width:25%; border:none;" id="profbox">
            <?php if ($this->_tpl_vars['is_member'] == true): ?>
                <div class="catmenuLink" style="border:none; "><a href="<?php echo @URL; ?>
/clubs/leave/<?php echo $this->_tpl_vars['club']['id']; ?>
" class="clubdel" >Leave Club</a></div>
            <?php endif; ?>
            <?php if ($this->_tpl_vars['is_member'] == false): ?>
                <div class="catmenuLink" style="border:none; "><a href="<?php echo @URL; ?>
/clubs/join/<?php echo $this->_tpl_vars['club']['id']; ?>
">Join Club</a></div>
            <?php endif; ?>
            <?php if ($this->_tpl_vars['is_admin'] == true): ?>
                <div class="catmenuLink" style="border:none; "><a href="<?php echo @URL; ?>
/clubs/editmembers/<?php echo $this->_tpl_vars['club']['id']; ?>
" >Edit Members</a> </div>
            <?php endif; ?>
            <?php if ($this->_tpl_vars['club']['user_email'] == $this->_tpl_vars['email']): ?>
                <div class="catmenuLink" style="border:none; "><a href="<?php echo @URL; ?>
/clubs/edit/<?php echo $this->_tpl_vars['club']['id']; ?>
">Edit Club </a></div>
                <div class="catmenuLink" style="border:none; "><a href="<?php echo @URL; ?>
/clubs/delete/<?php echo $this->_tpl_vars['club']['id']; ?>
" class="audiodel">Delete Club</a></div>
            <?php endif; ?>
        </div>       
    </div>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['is_member'] == true): ?>
    <div id="profbox" style="width:95%;">
        <h3 style="background:#D9F1FF; padding:10px;border: thin #eee solid;" id="Members">Members</h3>
        <img src="<?php echo @URL; ?>
/interface/icos/club_members.png" width="40px;"/><a href="<?php echo @URL; ?>
/clubs/invite/<?php echo $this->_tpl_vars['club']['id']; ?>
" >Invite friends</a>
        <br />
        <br />
        <?php if ($this->_tpl_vars['members'] != null): ?>
        <div style="float:left;width:100%;"><p><strong>Showing <?php echo $this->_tpl_vars['mem_paginate']['first']; ?>
-<?php echo $this->_tpl_vars['mem_paginate']['last']; ?>
 of <?php echo $this->_tpl_vars['mem_paginate']['total']; ?>
 members &nbsp;<a href="<?php echo @URL; ?>
/clubs/viewmembers/<?php echo $this->_tpl_vars['club']['id']; ?>
">See All</a></strong></p></div>
        <span class="pageLink" ><?php echo smarty_function_paginate_first(array('id' => 'member'), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_prev(array('id' => 'member'), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_middle(array('id' => 'member','format' => 'page','prefix' => "",'suffix' => "",'link_prefix' => "&nbsp;",'link_suffix' => "&nbsp;"), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_next(array('id' => 'member'), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_last(array('id' => 'member'), $this);?>
</span>
        <table>
            <tr>
                <?php $_from = $this->_tpl_vars['members']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['mi'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['mi']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['mem']):
        $this->_foreach['mi']['iteration']++;
?>
                <td height="80" style="background:white;">
                    <a href="<?php echo @URL; ?>
/profile/view/<?php echo $this->_tpl_vars['mem']['pid']; ?>
"><img src="<?php echo @URL; ?>
/getsmimage.php?id=<?php echo $this->_tpl_vars['mem']['user_imgs_id']; ?>
" style="max-width:200px; max-height: 80px;" alt="<?php echo $this->_tpl_vars['mem']['f_name']; ?>
, <?php echo $this->_tpl_vars['mem']['l_name']; ?>
, conveylive"/></a>&nbsp;
                    <br/><a href="<?php echo @URL; ?>
/profile/view/<?php echo $this->_tpl_vars['mem']['pid']; ?>
"><?php echo $this->_tpl_vars['mem']['f_name']; ?>
 <?php echo $this->_tpl_vars['mem']['l_name']; ?>
</a>
                </td>
                <?php endforeach; endif; unset($_from); ?>
            </tr>
        </table>
        <br/>
        <?php endif; ?>
    </div>

    <div id="profbox" style="width:95%;">
        <h3 style="background:#fee; padding:10px;border: thin #eee solid;" id="Photos">Photos</h3>
        <br />
        <img src="<?php echo @URL; ?>
/interface/icos/addphoto.png" width="40px;"/><a href="<?php echo @URL; ?>
/clubs/addphotos/<?php echo $this->_tpl_vars['club']['id']; ?>
">Add photos to club</a>
        <br/> <br/> 
        <?php if ($this->_tpl_vars['pictures'] != null): ?>
        <div style="float:left;width:100%;"><p><strong>Showing <?php echo $this->_tpl_vars['pic_paginate']['first']; ?>
-<?php echo $this->_tpl_vars['pic_paginate']['last']; ?>
 of <?php echo $this->_tpl_vars['pic_paginate']['total']; ?>
 photos </strong></p></div>
        <br/>
        <div class="pageLink" > <?php echo smarty_function_paginate_first(array('id' => 'picture'), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_prev(array('id' => 'picture'), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_middle(array('id' => 'picture','format' => 'page','prefix' => "",'suffix' => "",'link_prefix' => "&nbsp;",'link_suffix' => "&nbsp;"), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_next(array('id' => 'picture'), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_last(array('id' => 'picture'), $this);?>
</div>
        <table>
            <tr>
                <?php $_from = $this->_tpl_vars['pictures']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['pic']):
?>
                    <td height="80">
                        <a href="<?php echo @URL; ?>
/picture/view/<?php echo $this->_tpl_vars['pic']['id']; ?>
"><img src="<?php echo @URL; ?>
/getsmimage.php?id=<?php echo $this->_tpl_vars['pic']['id']; ?>
" style="max-width:200px; max-height: 80px;" alt="<?php echo $this->_tpl_vars['pic']['f_name']; ?>
, <?php echo $this->_tpl_vars['pic']['l_name']; ?>
" border="1"/> </a>&nbsp;
                    </td>
                <?php endforeach; endif; unset($_from); ?>
            </tr>
        </table>
        <br/>
        <?php endif; ?>
    </div>

    <div id="profbox" style="width:95%;">
        <h3 style="background:#ffe; padding:10px;border: thin #eee solid;" id="Topics">Topics</h3>
        <br />
        <img src="<?php echo @URL; ?>
/interface/icos/posttopic.png" width="40px;"/><a href="<?php echo @URL; ?>
/clubs/newtopic/<?php echo $this->_tpl_vars['club']['id']; ?>
" >Post New Topic</a><br/>
        <br />
        <?php if ($this->_tpl_vars['topics'] != null): ?>
            <div style="float:left;width:100%;"><p><strong>Showing <?php echo $this->_tpl_vars['top_paginate']['first']; ?>
-<?php echo $this->_tpl_vars['top_paginate']['last']; ?>
 of <?php echo $this->_tpl_vars['top_paginate']['total']; ?>
 topics <a href="<?php echo @URL; ?>
/clubs/topics/<?php echo $this->_tpl_vars['club']['id']; ?>
">See All</a></strong></p></div>
            <br/>
            <span class="pageLink" ><?php echo smarty_function_paginate_first(array('id' => 'topic'), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_prev(array('id' => 'topic'), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_middle(array('id' => 'topic','format' => 'page','prefix' => "",'suffix' => "",'link_prefix' => "&nbsp;",'link_suffix' => "&nbsp;"), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_next(array('id' => 'topic'), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_last(array('id' => 'topic'), $this);?>
</span>
            <br /><br />
            <ol>
                <?php $_from = $this->_tpl_vars['topics']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['top'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['top']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['t']):
        $this->_foreach['top']['iteration']++;
?>
                    <li>&nbsp;&nbsp;<a href="<?php echo @URL; ?>
/clubs/viewpost/<?php echo $this->_tpl_vars['t']['post_id']; ?>
"><?php echo $this->_tpl_vars['t']['topic']; ?>
</a></li>
                    <br />
                <?php endforeach; endif; unset($_from); ?>
            </ol>
            <br/>
        <?php endif; ?>
    </div>
    
    <div id="profbox" style="width:95%;">
        
        <h3 style="background:#B8DCDC; padding:10px;border: thin #eee solid;" id="Shared Files">Shared Files</h3>
        <br />
        <img src="<?php echo @URL; ?>
/interface/icos/sharefiles.png" width="40px;"/><a href="<?php echo @URL; ?>
/clubs/uploadfile/<?php echo $this->_tpl_vars['club']['id']; ?>
" >Upload Files to Share</a><br/>
        <br />
        <?php if ($this->_tpl_vars['files'] != null): ?>
            <div style="float:left;width:100%;">
                <p><strong>Showing <?php echo $this->_tpl_vars['file_paginate']['first']; ?>
-<?php echo $this->_tpl_vars['file_paginate']['last']; ?>
 of <?php echo $this->_tpl_vars['file_paginate']['total']; ?>
 files </strong></p>
            </div>
            <span class="pageLink" ><?php echo smarty_function_paginate_first(array('id' => 'files'), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_prev(array('id' => 'files'), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_middle(array('id' => 'files','format' => 'page','prefix' => "",'suffix' => "",'link_prefix' => "&nbsp;",'link_suffix' => "&nbsp;"), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_next(array('id' => 'files'), $this);?>
&nbsp;&nbsp;<?php echo smarty_function_paginate_last(array('id' => 'files'), $this);?>
</span>
            <div style="margin-top:10px;">
                <?php $_from = $this->_tpl_vars['files']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['f'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['f']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['file']):
        $this->_foreach['f']['iteration']++;
?>
                    <li>
                    <?php if ($this->_tpl_vars['file']['file_ext'] == ".pdf"): ?>
                        <img src="<?php echo @URL; ?>
/interface/icos/pdf.png" alt="pdf, <?php echo $this->_tpl_vars['file']['file_name']; ?>
, <?php echo $this->_tpl_vars['file']['f_name']; ?>
 <?php echo $this->_tpl_vars['file']['l_name']; ?>
, conveylive.com" width="20px" />
                    <?php elseif ($this->_tpl_vars['file']['file_ext'] == ".doc"): ?>
                        <img src="<?php echo @URL; ?>
/interface/icos/doc.png" alt="doc, <?php echo $this->_tpl_vars['file']['file_name']; ?>
, <?php echo $this->_tpl_vars['file']['f_name']; ?>
 <?php echo $this->_tpl_vars['file']['l_name']; ?>
, conveylive.com" width="20px" />
                    <?php elseif ($this->_tpl_vars['file']['file_ext'] == ".docx"): ?>
                        <img src="<?php echo @URL; ?>
/interface/icos/doc.png" alt="doc, <?php echo $this->_tpl_vars['file']['file_name']; ?>
, <?php echo $this->_tpl_vars['file']['f_name']; ?>
 <?php echo $this->_tpl_vars['file']['l_name']; ?>
, conveylive.com" width="20px" />
                    <?php elseif ($this->_tpl_vars['file']['file_ext'] == ".zip"): ?>
                        <img src="<?php echo @URL; ?>
/interface/icos/zip.png" alt="zip, <?php echo $this->_tpl_vars['file']['file_name']; ?>
, <?php echo $this->_tpl_vars['file']['f_name']; ?>
 <?php echo $this->_tpl_vars['file']['l_name']; ?>
, conveylive.com" width="20px" />
                    <?php elseif ($this->_tpl_vars['file']['file_ext'] == ".txt"): ?>
                        <img src="<?php echo @URL; ?>
/interface/icos/text.png" alt="txt, <?php echo $this->_tpl_vars['file']['file_name']; ?>
, <?php echo $this->_tpl_vars['file']['f_name']; ?>
 <?php echo $this->_tpl_vars['file']['l_name']; ?>
, conveylive.com" width="20px" />
                    <?php elseif ($this->_tpl_vars['file']['file_ext'] == ".rtf"): ?>
                        <img src="<?php echo @URL; ?>
/interface/icos/rtf.png" alt="rtf, <?php echo $this->_tpl_vars['file']['file_name']; ?>
, <?php echo $this->_tpl_vars['file']['f_name']; ?>
 <?php echo $this->_tpl_vars['file']['l_name']; ?>
, conveylive.com" width="20px" />
                    <?php elseif ($this->_tpl_vars['file']['file_ext'] == ".ppt"): ?>
                        <img src="<?php echo @URL; ?>
/interface/icos/ppt.png" alt="ppt, <?php echo $this->_tpl_vars['file']['file_name']; ?>
, <?php echo $this->_tpl_vars['file']['f_name']; ?>
 <?php echo $this->_tpl_vars['file']['l_name']; ?>
, conveylive.com" width="20px" />
                    <?php else: ?>
                        <img src="<?php echo @URL; ?>
/interface/icos/help.png" alt="unknown, <?php echo $this->_tpl_vars['file']['file_name']; ?>
, <?php echo $this->_tpl_vars['file']['f_name']; ?>
 <?php echo $this->_tpl_vars['file']['l_name']; ?>
, conveylive.com" width="20px" />    
                    <?php endif; ?>
                    &nbsp;&nbsp;<a href="<?php echo @URL; ?>
/getfile.php?id=<?php echo $this->_tpl_vars['file']['file_id']; ?>
&cid=<?php echo $this->_tpl_vars['club']['id']; ?>
"><?php echo $this->_tpl_vars['file']['file_name']; ?>
</a> uploaded by  <a href="<?php echo @URL; ?>
/profile/view/<?php echo $this->_tpl_vars['file']['pid']; ?>
"><?php echo $this->_tpl_vars['file']['f_name']; ?>
 <?php echo $this->_tpl_vars['file']['l_name']; ?>
</a> on <?php echo ((is_array($_tmp=$this->_tpl_vars['file']['date'])) ? $this->_run_mod_handler('date_format', true, $_tmp) : smarty_modifier_date_format($_tmp)); ?>
 &nbsp; <?php if ($this->_tpl_vars['is_admin'] == true): ?><a href="<?php echo @URL; ?>
/clubs/deletefile/<?php echo $this->_tpl_vars['club']['id']; ?>
/<?php echo $this->_tpl_vars['file']['file_id']; ?>
" class="filedel">Delete</a><?php endif; ?></li>
                <?php endforeach; endif; unset($_from); ?>
            </div>
            
            <br/>
        <?php endif; ?>
    </div>
    <?php endif; ?>
</div>
<?php endif; ?>
<?php if ($this->_tpl_vars['relArt'] != null || $this->_tpl_vars['latArt'] != null || $this->_tpl_vars['popArt'] != null): ?>
<div id="profbox" style="width:93%;">
    <?php if ($this->_tpl_vars['relArt'] != null): ?>
        <div style="float:left;width:500px;">
            <h3>Related Clubs</h3>
            <div class="relList">
            <?php $_from = $this->_tpl_vars['relArt']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['art']):
?>
                <li><a href='<?php echo @URL; ?>
/clubs/view/<?php echo $this->_tpl_vars['art']['id']; ?>
'><?php echo $this->_tpl_vars['art']['cname']; ?>
</a></li>
            <?php endforeach; endif; unset($_from); ?>
            <li>Browse <a href="<?php echo @URL; ?>
/clubs/catbrowse/<?php echo ((is_array($_tmp=$this->_tpl_vars['club']['category'])) ? $this->_run_mod_handler('replace', true, $_tmp, ' ', '_') : smarty_modifier_replace($_tmp, ' ', '_')); ?>
"> >> <?php echo $this->_tpl_vars['club']['category']; ?>
</a></li>
            </div>
            
        </div>
    <?php else: ?>
        <br />
    <?php endif; ?>
    
    <?php if ($this->_tpl_vars['latArt'] != null): ?>
        <div style="float:left;">
            <h3>Latest Clubs</h3>
            <div class="relList">
            <?php $_from = $this->_tpl_vars['latArt']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['art']):
?>
                <li><a href='<?php echo @URL; ?>
/clubs/view/<?php echo $this->_tpl_vars['art']['id']; ?>
'><?php echo $this->_tpl_vars['art']['name']; ?>
</a></li>
            <?php endforeach; endif; unset($_from); ?>
            </div>
            <p><a href="<?php echo @URL; ?>
/clubs/browse">>> All Latest Clubs</a></p>
        </div>
    <?php else: ?>    
        <br />
    <?php endif; ?>
    
    <?php if ($this->_tpl_vars['popArt'] != null): ?>
        <div style="float:left;width:160px;">
            <h3>Popular Clubs</h3>
            <div class="relList">
            <?php $_from = $this->_tpl_vars['popArt']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['art']):
?>
                <li><a href='<?php echo @URL; ?>
/clubs/view/<?php echo $this->_tpl_vars['art']['id']; ?>
'><?php echo $this->_tpl_vars['art']['name']; ?>
</a></li>
            <?php endforeach; endif; unset($_from); ?>
            </div>
        </div>
    <?php else: ?>    
        <br />
    <?php endif; ?>
</div>
<?php endif; ?>

<?php echo '
<script type="text/javascript">
$(document).ready(function(){
    $(\'a.clubdel\').click(function(){
       var link = $(this).attr(\'href\');
        jConfirm(\'Are you sure you want to leave this club?\', \'Confirmation Dialog\', function(r) {
            if(r == true){
                window.location.href = link;
            }
            else{
                return false;
            }
        });
        return false;
    });
    $(\'a.filedel\').click(function(){
       var link = $(this).attr(\'href\');
        jConfirm(\'Are you sure you want to delete this file?\', \'Confirmation Dialog\', function(r) {
            if(r == true){
                window.location.href = link;
            }
            else{
                return false;
            }
        });
        return false;
    });
});

</script>
'; ?>