<?php /* Smarty version 2.6.26, created on 2010-01-20 05:32:02
         compiled from subtpl/menu.tpl */ ?>
<ul id="h_nav">
    <li><a href="<?php echo @URL; ?>
/home">Home</a></li>
    <li><a href="">People</a>
        <ul>
            <li><a href="<?php echo @URL; ?>
/moresearch/people">Find People</a></li>
            <li><a href="<?php echo @URL; ?>
/invite.php">Invite Friends</a></li>
        </ul>
    </li>
    <li>
        <?php if ($this->_tpl_vars['blogexist'] == true): ?>
        <a href="<?php echo $this->_tpl_vars['blog_url']; ?>
">Blog</a>
        <?php else: ?>
        <a href="<?php echo @URL; ?>
/blog/create">Blog</a>
        <?php endif; ?>
        <ul>
            <?php if ($this->_tpl_vars['blogexist'] == true): ?>
            <li><a href="<?php echo @URL; ?>
/blog/new">New Post</a></li>
            <li><a href="<?php echo $this->_tpl_vars['blog_url']; ?>
">Browse Your Own posts</a></li>
            <?php else: ?>
            <li><a href="<?php echo @URL; ?>
/blog/create">Create New Blog</a></li>
            <?php endif; ?>
            <li><a href="<?php echo @URL; ?>
/blog/browseall">Browse Other's Blogs</a></li>
        </ul>
    </li>
    <li><a href="">Publish</a>
        <ul>
            <li><a href="<?php echo @URL; ?>
/article/new">Pages</a></li>
            <li><a href="<?php echo @URL; ?>
/picture/new">Photos</a></li> 
            <li><a href="<?php echo @URL; ?>
/audio/new">Audio</a></li>
            <li><a href="<?php echo @URL; ?>
/video/new">Video</a></li>
            <li><a href="<?php echo @URL; ?>
/clubs/new">Clubs</a></li>
        </ul>
    </li>
    <li><a href="">Browse</a>
        <ul>
            <li><a href="<?php echo @URL; ?>
/article/browse">Pages</a></li>
            <li><a href="<?php echo @URL; ?>
/picture/browse">Photos</a></li>
            <li><a href="<?php echo @URL; ?>
/audio/browse">Audio</a></li>
            <li><a href="<?php echo @URL; ?>
/video/browse">Video</a></li>
            <li><a href="<?php echo @URL; ?>
/clubs/browse">Clubs</a></li>
        </ul>
    </li>
    <?php if ($this->_tpl_vars['islogin'] == true): ?>
    <li><a href="<?php echo @URL; ?>
/accounts/edit/<?php echo $this->_tpl_vars['email']; ?>
">Settings</a>
        <ul>
            <li><a href="">Privacy</a></li>
            <li><a href="<?php echo @URL; ?>
/accounts/edit/<?php echo $this->_tpl_vars['email']; ?>
">Account</a></li>
        </ul>
    </li>
    <li><a href="<?php echo @URL; ?>
/message/inbox">Messages</a>
        <ul>
            <li><a href="<?php echo @URL; ?>
/message/new">New Message</a></li>
            <li><a href="<?php echo @URL; ?>
/message/inbox">Inbox</a></li>
            <li><a href="<?php echo @URL; ?>
/message/sentmessages">Sent Messages</a></li>
        </ul>
    </li>
    <li><a href="<?php echo @URL; ?>
/logout">Logout</a></li>
    <?php endif; ?>
</ul>