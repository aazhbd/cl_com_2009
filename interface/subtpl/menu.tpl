<ul id="h_nav">
    <li><a href="{$smarty.const.URL}/home">Home</a></li>
    <li><a href="">People</a>
        <ul>
            <li><a href="{$smarty.const.URL}/moresearch/people">Find People</a></li>
            <li><a href="{$smarty.const.URL}/invite.php">Invite Friends</a></li>
        </ul>
    </li>
    <li>
        {if $blogexist == true}
        <a href="{$blog_url}">Blog</a>
        {else}
        <a href="{$smarty.const.URL}/blog/create">Blog</a>
        {/if}
        <ul>
            {if $blogexist == true}
            <li><a href="{$smarty.const.URL}/blog/new">New Post</a></li>
            <li><a href="{$blog_url}">Browse Your Own posts</a></li>
            {else}
            <li><a href="{$smarty.const.URL}/blog/create">Create New Blog</a></li>
            {/if}
            <li><a href="{$smarty.const.URL}/blog/browseall">Browse Other's Blogs</a></li>
        </ul>
    </li>
    <li><a href="">Publish</a>
        <ul>
            <li><a href="{$smarty.const.URL}/article/new">Pages</a></li>
            <li><a href="{$smarty.const.URL}/picture/new">Photos</a></li> 
            <li><a href="{$smarty.const.URL}/audio/new">Audio</a></li>
            <li><a href="{$smarty.const.URL}/video/new">Video</a></li>
            <li><a href="{$smarty.const.URL}/clubs/new">Clubs</a></li>
        </ul>
    </li>
    <li><a href="">Browse</a>
        <ul>
            <li><a href="{$smarty.const.URL}/article/browse">Pages</a></li>
            <li><a href="{$smarty.const.URL}/picture/browse">Photos</a></li>
            <li><a href="{$smarty.const.URL}/audio/browse">Audio</a></li>
            <li><a href="{$smarty.const.URL}/video/browse">Video</a></li>
            <li><a href="{$smarty.const.URL}/clubs/browse">Clubs</a></li>
        </ul>
    </li>
    {if $islogin == true}
    <li><a href="{$smarty.const.URL}/accounts/edit/{$email}">Settings</a>
        <ul>
            <li><a href="">Privacy</a></li>
            <li><a href="{$smarty.const.URL}/accounts/edit/{$email}">Account</a></li>
        </ul>
    </li>
    <li><a href="{$smarty.const.URL}/message/inbox">Messages</a>
        <ul>
            <li><a href="{$smarty.const.URL}/message/new">New Message</a></li>
            <li><a href="{$smarty.const.URL}/message/inbox">Inbox</a></li>
            <li><a href="{$smarty.const.URL}/message/sentmessages">Sent Messages</a></li>
        </ul>
    </li>
    <li><a href="{$smarty.const.URL}/logout">Logout</a></li>
    {/if}
</ul>