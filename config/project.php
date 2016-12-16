<?php
define('PATH', str_replace(DIRECTORY_SEPARATOR, '/', realpath(dirname(__FILE__).'/..')));
define('ROOT', str_replace(' ', '%20', preg_replace('/'.preg_quote(str_replace(DIRECTORY_SEPARATOR, '/', $_SERVER['DOCUMENT_ROOT']), '/').'\/?/', '', str_replace(DIRECTORY_SEPARATOR, '/', realpath(dirname(__FILE__) . '/..')))));
define('URL', (empty($_SERVER['HTTPS']) ? 'http://' : 'https://') . $_SERVER['HTTP_HOST'] . (strlen(ROOT) ? ("/" . ROOT) : ''));

define('HOST', 'localhost');
define('DBNM', 'conlive_clive');
define('DBUS', 'conlive_cuser');
define('DBPS', 'mod#8121431');

error_reporting(E_ALL ^ E_NOTICE);

require_once(PATH . '/scripts/libs/Smarty.class.php'); 
require_once(PATH . '/data/dblib.php');

class Project
{
    var $db;
    var $tp;

	function Project()
	{
        $this->loadlib();
        
        $ser = $_SERVER['HTTP_HOST'];

        if($_SERVER['HTTP_HOST'] == "localhost")
        {
            $this->db = new dblib("localhost", "conlivenew", "root", "");
        }
        else
        {
            $this->db = new dblib(HOST, DBNM, DBUS, DBPS);
        }

        $this->tp = new Template();

        session_start();
    }
	
	function loadlib()
	{
        require_once(PATH . '/data/tpllibs.php');
        require_once(PATH . '/data/login.php');
        require_once(PATH . '/data/dbdata.php');
        require_once(PATH . '/data/static.php');
        require_once(PATH . '/data/small.php');
        require_once(PATH . '/data/profile.php');
        require_once(PATH . '/data/account.php');
        require_once(PATH . '/data/message.php');
        require_once(PATH . '/data/friends.php');
        require_once(PATH . '/data/paginate.php');
        require_once(PATH . '/data/article.php');
        require_once(PATH . '/data/audio.php');
        require_once(PATH . '/data/video.php');
        require_once(PATH . '/data/picture.php');
        require_once(PATH . '/data/blog.php');
        require_once(PATH . '/data/club.php');
        require_once(PATH . '/data/home.php');
        require_once(PATH . '/scripts/libs/SmartyPaginate.class.php');
        require_once(PATH . '/scripts/mailer/swift_required.php');
        require_once(PATH . '/scripts/inviter/openinviter.php');
	}
}

class Template extends Smarty
{
    function Template()
    {
        $this->Smarty();
        $this->template_dir = PATH . '/interface/';
        $this->compile_dir = PATH . '/scripts/libs/compile/';
        $this->config_dir = PATH . '/scripts/libs/config/';
        $this->cache_dir = PATH . '/scripts/libs/cache/';
    }
}

?>