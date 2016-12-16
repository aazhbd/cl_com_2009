<?php
$_pluginInfo=array(
	'name'=>'Yahoo!',
	'version'=>'1.4.2',
	'description'=>"Get the contacts from a Yahoo! account",
	'base_version'=>'1.6.3',
	'type'=>'email',
	'check_url'=>'http://mail.yahoo.com'
	);
/**
 * Yahoo! Plugin
 * 
 * Imports user's contacts from Yahoo!'s AddressBook
 * 
 * @author OpenInviter
 * @version 1.3.8
 */
class yahoo extends OpenInviter_Base
	{
	private $login_ok=false;
	public $showContacts=true;
	public $requirement=false;
	public $allowed_domains=array('yahoo','ymail','rocketmail','yahoo.co.jp');
	public $debug_array=array(
			  'initial_get'=>'form: login information',
			  'login_post'=>'window.location.replace',
			  'contacts_page'=>'import_export',
			  'export_post'=>'crumb2',
			  'contacts_file'=>'","'
			  );
	
	/**
	 * Login function
	 * 
	 * Makes all the necessary requests to authenticate
	 * the current user to the server.
	 * 
	 * @param string $user The current user.
	 * @param string $pass The password for the current user.
	 * @return bool TRUE if the current user was authenticated successfully, FALSE otherwise.
	 */
	public function login($user,$pass)
		{
		$this->resetDebugger();
		$this->service='yahoo';
		$this->service_user=$user;
		$this->service_password=$pass;
		if (!$this->init()) return false;
				
		$res=$this->get("https://login.yahoo.com/config/mail?.intl=us&rl=1");
		if ($this->checkResponse('initial_get',$res))
			$this->updateDebugBuffer('initial_get',"https://login.yahoo.com/config/mail?.intl=us&rl=1",'GET');
		else 
			{
			$this->updateDebugBuffer('initial_get',"https://login.yahoo.com/config/mail?.intl=us&rl=1",'GET',false);
			$this->debugRequest();
			$this->stopPlugin();	
			return false;
			}
		
		$post_elements=$this->getHiddenElements($res);$post_elements["save"]="Sign+In";$post_elements['login']=$user;$post_elements['passwd']=$pass;
	    $res=htmlentities($this->post("https://login.yahoo.com/config/login?",$post_elements,true));
	   	if ($this->checkResponse('login_post',$res))
			$this->updateDebugBuffer('login_post',"https://login.yahoo.com/config/login?",'POST',true,$post_elements);
		else 
			{
			$this->updateDebugBuffer('login_post',"https://login.yahoo.com/config/login?",'POST',false,$post_elements);
			$this->debugRequest();
			$this->stopPlugin();	
			return false;
			}		
		$this->login_ok=$this->login_ok="http://address.mail.yahoo.com/";
		return true;
		}

	/**
	 * Get the current user's contacts
	 * 
	 * Makes all the necesarry requests to import
	 * the current user's contacts
	 * 
	 * @return mixed The array if contacts if importing was successful, FALSE otherwise.
	 */	
	public function getMyContacts()
		{
		if (!$this->login_ok)
			{
			$this->debugRequest();
			$this->stopPlugin();
			return false;
			}
		else
			$url=$this->login_ok;
		$contacts=array();
		$res=$this->get($url,true);
		if ($this->checkResponse("contacts_page",$res))
			{
			$doc=new DOMDocument();libxml_use_internal_errors(true);if (!empty($res)) $doc->loadHTML($res);libxml_use_internal_errors(false);
			$xpath=new DOMXPath($doc);$query="//a[@href]";$data=$xpath->query($query);
			foreach($data as $val) 
				{
				if (strstr($val->getAttribute('href'),"import_export"))  	
					{$url_contacts="http://address.mail.yahoo.com/".str_replace("&amp;","&",$val->getAttribute('href'));break;}
				}
			$res=$this->get($url_contacts,true);
			$this->updateDebugBuffer('contacts_page',"http://address.mail.yahoo.com/",'GET');
			}
		else 
			{
			$this->updateDebugBuffer('contacts_page',"http://address.mail.yahoo.com/",'GET',false);
			$this->debugRequest();
			$this->stopPlugin();	
			return false;
			}
			 
		if ($this->checkResponse('export_post',$res))
			{
			$doc=new DOMDocument();libxml_use_internal_errors(true);if (!empty($res)) $doc->loadHTML($res);libxml_use_internal_errors(false);
			$xpath=new DOMXPath($doc);$query="//input[@id='crumb2']";$data=$xpath->query($query);
			foreach($data as $val) 
				$post_elements=array("VPC"=>"import_export",
									$val->getAttribute('name')=>$val->getAttribute('value'),
									"submit[action_export_yahoo]"=>"Export+Now"
									);
			$res=$this->post("http://address.mail.yahoo.com/index.php",$post_elements);
			$this->updateDebugBuffer('export_post',"{$url_contacts}",'GET');
			}
		else 
			{
			$this->updateDebugBuffer('export_post',"{$url_contacts}",'POST',false);
			$this->debugRequest();
			$this->stopPlugin();	
			return false;			
			}
		if ($this->checkResponse("contacts_file",$res))
			{
			$temp=$this->parseCSV($res);
			$contacts=array();
			foreach ($temp as $values)
				{
				if (!empty($values['7'])) $mess_id=(!$this->isEmail($values['7'])?"{$values['7']}@yahoo.com":$values['7']);
				if (!empty($values[4])) $emailKey=$values[4];
				elseif(!empty($mess_id)) $emailKey=$mess_id;
				elseif(!empty($values['52'])) $emailKey=$values['52']; 
				if (!empty($emailKey))
					$contacts[$emailKey]=array('first_name'=>(!empty($values[0])?$values[0]:false),
												'middle_name'=>(!empty($values[2])?$values[2]:false),
												'last_name'=>(!empty($values[1])?$values[1]:false),
												'nickname'=>(!empty($values[3])?$values[3]:false),
												'email_1'=>(!empty($values[4])?$values[4]:$emailKey),
												'email_2'=>(!empty($values[17])?$values[17]:false),
												'email_3'=>(!empty($values[16])?$values[16]:false),
												'organization'=>false,
												'phone_mobile'=>(!empty($values[12])?$values[12]:false),
												'phone_home'=>(!empty($values[8])?$values[8]:false),			
												'pager'=>(!empty($values[10])?$values[10]:false),
												'address_home'=>(!empty($values[27])?$values[27]:false),
												'address_city'=>(!empty($values[28])?$values[28]:false),
												'address_state'=>(!empty($values[29])?$values[29]:false),
												'address_country'=>(!empty($values[31])?$values[31]:false),
												'postcode_home'=>(!empty($values[30])?$values[30]:false),
												'company_work'=>(!empty($values[21])?$values[21]:false),
												'address_work'=>(!empty($values[2])?$values[22]:false),
												'address_work_city'=>(!empty($values[23])?$values[16]:false),
												'address_work_country'=>(!empty($values[26])?$values[26]:false),
												'address_work_state'=>(!empty($values[24])?$values[24]:false),
												'address_work_postcode'=>(!empty($values[25])?$values[25]:false),
												'fax_work'=>false,
												'phone_work'=>(!empty($values[20])?$values[20]:false),
												'website'=>(!empty($values[18])?$values[18]:false),
												'isq_messenger'=>(!empty($values[50])?$values[50]:false),
												'skype_essenger'=>(!empty($values[48])?$values[48]:false),
												'yahoo_essenger'=>(!empty($values[39])?$values[39]:false),
												'msn_messenger'=>(!empty($values[52])?$values[52]:false),
												'aol_messenger'=>(!empty($values[53])?$values[53]:false),
												'other_messenger'=>false,
											   );
				}
			$this->updateDebugBuffer('contacts_file',"http://address.mail.yahoo.com/index.php",'POST',true,$post_elements);
			}
		else 
			{
			$this->updateDebugBuffer('contacts_file',"http://address.mail.yahoo.com/index.php",'POST',false,$post_elements);
			$this->debugRequest();
			$this->stopPlugin();	
			return false;	
			}
		foreach ($contacts as $email=>$name) if (!$this->isEmail($email)) unset($contacts[$email]);
		return $this->returnContacts($contacts);
		}

	/**
	 * Terminate session
	 * 
	 * Terminates the current user's session,
	 * debugs the request and reset's the internal 
	 * debudder.
	 * 
	 * @return bool TRUE if the session was terminated successfully, FALSE otherwise.
	 */	
	public function logout()
		{
		if (!$this->checkSession()) return false;
		$res=$this->get("http://login.yahoo.com/config/login?logout=1&.done=http://address.yahoo.com&.src=ab&.intl=us");		
		$this->debugRequest();
		$this->resetDebugger();
		$this->stopPlugin();
		return true;
		}

	}
?>