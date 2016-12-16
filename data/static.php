<?php

$contName[] = "User";
$contName[] = "Profile";
$contName[] = "Friends";
$contName[] = "Blog";
$contName[] = "Article";
$contName[] = "Album";
$contName[] = "Audio";
$contName[] = "Video";
$contName[] = "Club";
$contName[] = "Message";

$userType[] = "Non-Registered, non-approved, no-profile,";
$userType[] = "Registered, non-approved, no-profile";
$userType[] = "Registered, approved, no-profile";
$userType[] = "Registered, approved, has-profile";
$userType[] = "Admin";

function getFileCat()
{
    $file = array();
    $file[] = 'Miscellaneous or unsorted';
    $file[] = 'Education';
    $file[] = 'Assignments and specification';
    $file[] = 'Literature And Novels';
    $file[] = 'Howto';
    $file[] = 'Presentation';
    $file[] = 'Project';
    $file[] = 'Office Documents';
    $file[] = 'Excel Sheets';
    $file[] = 'Plain Text';
    $file[] = 'Zipped File';
    $file[] = 'Entertainment and Gaming';
    $file[] = 'People & Blogs';
    $file[] = 'Science & Technology';
    $file[] = 'Travel & Events';
    return $file;    
}

function getMetaDesc()
{
    $desc = array();
    $desc[] = 'Autos & Vehicles';
    $desc[] = 'Comedy';
    $desc[] = 'Education';
    $desc[] = 'Entertainment';
    $desc[] = 'Film & Animation';
    $desc[] = 'Gaming';
    $desc[] = 'Howto & Style';
    $desc[] = 'Movies';
    $desc[] = 'Music';
    $desc[] = 'News & Politics';
    $desc[] = 'Nonprofits & Activism';
    $desc[] = 'People & Blogs';
    $desc[] = 'Pets & Animals';
    $desc[] = 'Science & Technology';
    $desc[] = 'Sports';
    $desc[] = 'Travel & Events';
    $d = implode(',', $desc);
    return $d; 
}

function getMetaKeys()
{
    $keys = array( 'convey', 'live', 'conveylive', 'transfer', 'message', 'carry', 'publish', 'broadcast', 'publicity', 'communicate', 'transmission', 'transmit', 'recieve', 'impart', 'I followed', 'articles', 'audio', 'video', 'multimedia', 'magazine', 'read', 'write', 'popular', 'pop', 'information', 'share', 'bring', 'bear', 'convene', 'convenor', 'assemble', 'convenir', 'direct', 'alive', 'telecasting', 'casting');
    $keys[] = 'Autos & Vehicles';
    $keys[] = 'Comedy';
    $keys[] = 'Education';
    $keys[] = 'Entertainment';
    $keys[] = 'Film & Animation';
    $keys[] = 'Gaming';
    $keys[] = 'Howto & Style';
    $keys[] = 'Movies';
    $keys[] = 'Music';
    $keys[] = 'News & Politics';
    $keys[] = 'Nonprofits & Activism';
    $keys[] = 'People & Blogs';
    $keys[] = 'Pets & Animals';
    $keys[] = 'Science & Technology';
    $keys[] = 'Sports';
    $keys[] = 'Travel & Events';
    
    $k = implode(',', $keys);
    return $k;
}

function getLangList()
{
    $data = array();
    $data[] = 'Bangla';
    $data[] = 'English';
    $data[] = 'French';
    $data[] = 'Spanish';
    $data[] = 'Italian';
    $data[] = 'Chinese';
    $data[] = 'Japanese';
    $data[] = 'Russian';
    $data[] = 'Hindi';
    return $data; 
}

function getLookforList()
{
    $data = array();
    $data[] = 'Friendship';
    $data[] = 'Networking';
    $data[] = 'Nothing in particular';
    $data[] = 'Boy Friend';
    $data[] = 'Girl Friend';
    $data[] = 'A Relationship';
    $data[] = 'Dating';
    return $data; 
}

function getMetaAuthor()
{
    $author = array('Articulate Logic', 'Articulate', 'Logic', 'aazhbd', 'Zakir Hossain', 'Zakir', 'Abdullah Al Zakir Hossain');
    $a = implode(',', $author);
    return $a;
}

function getClubCategory()
{
    $clubCat = array();
    $clubCat[] = 'Bussiness';
    $clubCat[] = 'Common Interest';
    $clubCat[] = 'Entertainment and Arts';
    $clubCat[] = 'Geography';
    $clubCat[] = 'Internet and Technology';
    $clubCat[] = 'Just For Fun';
    $clubCat[] = 'Music';
    $clubCat[] = 'Organizations';
    $clubCat[] = 'Sports and Recreation';
    $clubCat[] = 'Students Group';
    return $clubCat;
}

function getVideoCategory()
{
    $videoList = array();
    
    $videoList[] = 'Personal Home Videos';
    $videoList[] = 'Fun and Comedy';
    $videoList[] = 'Entertainment';
    $videoList[] = 'Music';
    $videoList[] = 'Film and Animation';
    $videoList[] = 'Gaming';
    $videoList[] = 'Howto and Style';
    $videoList[] = 'Education';
    $videoList[] = 'People and Blogs';
    $videoList[] = 'News and Politics';
    $videoList[] = 'Nonprofits and Activism';
    $videoList[] = 'Science and Technology';
    $videoList[] = 'Computer and IT';
    $videoList[] = 'Sports';
    $videoList[] = 'Travel and Events';
    $videoList[] = 'Autos and Vehicles';

    return $videoList;
}

function getGenreList()
{
    $genreList = array();
    
    $genreList[] = 'Pop';
    $genreList[] = 'Classical music';
    $genreList[] = 'Folk and Country';
    $genreList[] = 'Metal';
    $genreList[] = 'Rock and roll';
    $genreList[] = 'Film soundtrack';
    $genreList[] = 'Comedy';
    $genreList[] = 'Instrumental';
    $genreList[] = 'Vocal';
    $genreList[] = 'News and Events';
    $genreList[] = 'Sports and Travel';
    $genreList[] = 'Science and Technology';
    $genreList[] = 'Education and Reference';
    $genreList[] = 'Society and Culture';
    $genreList[] = 'Games and Recreation';
     
    return $genreList;

}

function getCatList()
{
    $catList = array();
        
    $catList[] = 'News and Events';
    $catList[] = 'Science';
    $catList[] = 'Computer and Technology';
    $catList[] = 'Cars and Automobile';
    $catList[] = 'Business';
    $catList[] = 'Arts and Humanities';
    $catList[] = 'Finance and Accounting';
    $catList[] = 'Politics';
    $catList[] = 'Religion';
    $catList[] = 'Society and Culture';
    $catList[] = 'Family and relationships';
    $catList[] = 'Entertainment';
    $catList[] = 'Music';
    $catList[] = 'Recreation and Games';
    $catList[] = 'Literature';
    $catList[] = 'Education and Reference';
    $catList[] = 'Health and Medicine';
    $catList[] = 'Psychology';
    $catList[] = 'Food and Drink';
    $catList[] = 'Sports and Travel';
            
    return $catList;
}
function getStatic($pName)
{
	$pageInfo = array(
                "privacy"  => " <h2>Privacy Policy</h2>
                                <p>This policy is effective as of July 07, 2009.</p>
                                <h3>Articulate Logic Principles</h3>

                                <p>ArticulateLogic is a privately owned Software Engineering Company providing software development and offshore outsourcing solutions. Our goal is to make sure that each customer is fully satisfied with the service and web design product delivered. We also allowed user accounts to be created in our domain to make it easy to share information with other users and download software shared by us and other users. We understand you may not want everyone to have the information you share on ArticulateLogic; that is why we give you control of your information. Our default privacy settings limit the information displayed in your profile.</p>
                                <p>ArticulateLogic follows three core principles:</p>

                                <li>1. You should have control over your personal information. </li>
                                <p>ArticulateLogic helps you share information with other users. You choose what information you put in your profile, including contact and personal information, pictures, interests etc. And you control the information you share.</p>

                                <li>2. You should have access to the information others want to share.</li>
                                <p>There is an increasing amount of information available in ArticulateLogic, and you may want to know what relates to you, your friends, and people around you. We want to help you easily get that information.</p>

                                <li>3. You should be able to download software and share projects in ArticulateLogic. </li>
                                <p>ArtculateLogic allows you download software upon having a membership in ArticulateLogic.com shared by other users or ArticulateLogic Team. You can also submit your own projects in our site provided that you agree to the terms and conditions of our site. </p>

                                <h3>ArticulateLogic 's Privacy Policy</h3>
                                <p>ArticulateLogic 's Privacy Policy is designed to help you understand how we collect and use the personal information you decide to share, and help you make informed decisions when using ArticulateLogic, located at www.articulatelogic.com and its directly associated domains (collectively, 'ArticulateLogic' or 'Website')</p>
                                <p>By using or accessing ArticulateLogic, you are accepting the practices described in this Privacy Policy.</p>
                                <p>This privacy statement covers the site www.articulatelogic.com and its directly associated domains. Because this Web site wants to demonstrate its commitment to your privacy, it has agreed to disclose its information practices and have its privacy practices reviewed for compliance. </p>
                                <p>If you have questions regarding this statement, please contact us. </p>

                                <h3>The Information We Collect</h3>
                                <p>When you visit ArticulateLogic.com you provide us with two types of information: login information and your profile information that you knowingly choose to disclose. We do not sell your information to anyone and it’s secured in our database.</p>

                                <p>When you register with ArticulateLogic, you provide us with certain personal information, such as your name, your email address, your gender, and any other personal or preference information that you provide to us.</p>

                                <p>When you enter ArticulateLogic, we collect your IP address. This information is gathered for all ArticulateLogic visitors.</p>

                                <p>You post Profile Information and software for other users to download on the Site at your own risk. Although, we do not expose your login information to anyone, please be aware that no security measures are perfect or impenetrable. We cannot control the actions of other Users with whom you may choose to share your information. Therefore, we cannot and do not guarantee that Profile Information you post on the Site will not be viewed by unauthorized persons. We are not responsible for circumvention of any privacy settings or security measures contained on the Site. You understand and acknowledge that, even after removal, copies of Profile Information may remain viewable in cached and archived pages or if other Users have copied or stored your Profile Information.</p>

                                <p>Any improper collection or misuse of information provided on ArticulateLogic is a violation of the ArticulateLogic Terms of Service and should be reported through the Contact Section.</p>
                                <h3>Use of Information Obtained by ArticulateLogic</h3>

                                <p>When you register with ArticulateLogic, you create your own profile. Your profile information, as well as your name, email and photo, are displayed to other members in ArticulateLogic upon searching to enable you to connect with people on ArticulateLogic. We may occasionally use your name and email address to send you notifications regarding new services offered by ArticulateLogic that we think you may find valuable.</p>

                                <p>Profile information is used by ArticulateLogic primarily to be presented back to and edited by you when you access the service and to be presented to others permitted to view that information. </p>
                                <p>ArticulateLogic may send you service-related announcements from time to time through the general operation of the service.</p>

                                <h3>Sharing Your Information with Third Parties</h3>
                                <p>If the ownership of all or substantially all of the ArticulateLogic business, were to change, your user information may be transferred to the new owner so the service can continue operations. In any such transfer of information, your user information would remain subject to the promises made in any pre-existing Privacy Policy.</p>

                                <h3>Links</h3>
                                <p>ArticulateLogic may contain links to other websites. We are of course not responsible for the privacy practices of other web sites. We encourage our users to be aware when they leave our site to read the privacy statements of each and every web site that collects personally identifiable information. This Privacy Policy applies solely to information collected by ArticulateLogic.</p>

                                <h3>Changing or Removing Information</h3>
                                <p>Access and control over most personal information on ArticulateLogic is readily available through the profile editing tools. ArticulateLogic users may modify or delete any of their profile information at any time by logging into their account. Information will be updated immediately. Individuals who wish to deactivate their ArticulateLogic account may do so on the Accounts page. Removed information may persist in backup copies for a reasonable period of time but will not be generally available to members of ArticulateLogic.</p>

                                <h3>Security</h3>
                                <p>ArticulateLogic takes appropriate precautions to protect our users' information. Your account information is located on a secured server behind a firewall. When you enter sensitive information (such as credit card number or your password), we encrypt that information using secure socket layer technology (SSL). (To learn more about SSL, go to http://en.wikipedia.org/wiki/Secure_Sockets_Layer). Because email and instant messaging are not recognized as secure communications, we request that you not send private information to us by email or instant messaging services. If you have any questions about the security of ArticulateLogic Web Site, please contact us through the Contact Section.</p>
                                <p>The software that you download from Articulatelogic’s Downloads Section developed by ArticulateLogic, are well tested to ensure that it is 100% free of spyware, viruses, and other malware. Users can freely download the software submitted by other users but we provide no guarantee to those software. Users are permitted to download and use them at their own risk.</p>

                                <h3>Terms of Use, Notices and Revisions</h3>
                                <p>Your use of ArticulateLogic, and any disputes arising from it, is subject to this Privacy Policy as well as our Terms of Use and all of its dispute resolution provisions including arbitration, limitation on damages and choice of law. We reserve the right to change our Privacy Policy and our Terms of Use at any time. Non-material changes and clarifications will take effect immediately, and material changes will take effect within 30 days of their posting on this site. If we make changes, we will post them and will indicate at the top of this page the policy's new effective date. If we make material changes to this policy, we will notify you here, by email, or through notice on our home page. We encourage you to refer to this policy on an ongoing basis so that you understand our current privacy policy. Unless stated otherwise, our current privacy policy applies to all information that we have about you and your account.</p>

                                <h3>Contacting the Web Site</h3>
                                <p>If you have any questions about this privacy policy, please contact us via Contact section at ArticulateLogic.com.</p>",
                                
                "terms"   =>    "<h2>Terms And Conditons</h2>
                                <p>Date of Last Revision: July 08, 2009</p>

                                <h3>Statement of Rights and Responsibilities</h3>
                                <p>This Statement of Rights and Responsibilities ('Statement') derives from the ArticulateLogic Principles, and governs our relationship with users and others who interact with ArticulateLogic. By using or accessing ArticulateLogic, you agree to this Statement.</p>

                                <h3>Privacy </h3>
                                <p>Your privacy is very important to us. We designed our Privacy Policy to make important disclosures to you about how we collect and use the information you post on ArticulateLogic. We encourage you to read the Privacy Policy, and to use the information it contains to help make informed decisions.</p>

                                <h3>Sharing Your Content and Information </h3>
                                <p>You own all of the content and information you post on ArticulateLogic, and you can control how we share your content. In order for us to use certain types of content and provide you with ArticulateLogic, you agree to the following:</p>

                                <p>For content that is covered by intellectual property rights, like photos ('IP content'), you specifically give us the following permission, subject to your privacy settings: you grant us a non-exclusive, transferable, sub-licensable, royalty-free, worldwide license to use any IP content that you post on or in connection with ArticulateLogic ('IP License'). This IP License ends when you delete your IP content or your account (except to the extent your content has been shared with others, and they have not deleted it). </p>
                                <p>When you delete IP content, it is deleted in a manner similar to emptying the recycle bin on a computer. However, you understand that removed content may persist in backup copies for a reasonable period of time (but will not be available to others).</p>
                                <p>We always appreciate your feedback or other suggestions about ArticulateLogic, but you understand that we may use them without any obligation to compensate you for them (just as you have no obligation to offer them). </p>

                                <h3>Safety</h3> 
                                <p>We do our best to keep ArticulateLogic safe, but we cannot guarantee it. We need your help in order to do that, which includes the following commitments:</p>

                                <li>You will not send or otherwise post unauthorized commercial communications to users (such as spam). </li>
                                <li>You will not collect users' information, or otherwise access ArticulateLogic, using automated means (such as harvesting bots, robots, spiders, or scrapers) without our permission. </li>
                                <li>You will not upload viruses or other malicious code. </li>
                                <li>You will not solicit login information or access an account belonging to someone else. </li>
                                <li>You will not bully, intimidate, or harass any user. </li>
                                <li>You will not post content that is hateful, threatening, pornographic, or that contains nudity or graphic or gratuitous violence. </li>
                                <li>You will not develop or operate a third party application containing, or advertise or otherwise market alcohol-related or other mature content without appropriate age-based restrictions. </li>
                                <li>You will not use ArticulateLogic to do anything unlawful, misleading, malicious, or discriminatory. </li>
                                <li>You will not facilitate or encourage any violations of this Statement. </li>

                                <h3>Registration and Account Security </h3>
                                <p>ArticulateLogic users provide their real names and information, and we need your help to keep it that way. Here are some commitments you make to us relating to registering and maintaining the security of your account:</p>

                                <li>You will not provide any false personal information on ArticulateLogic, or create an account for anyone other than yourself without permission. </li>
                                <li>You will not use ArticulateLogic if you are a convicted sex offender. </li>
                                <li>You will keep your contact information accurate and up-to-date. </li
                                <li>You will not share your password, let anyone else access your account, or do anything else that might jeopardize the security of your account.</li> 
                                <li>You will not transfer your account to anyone without first getting our written permission. </li>

                                <h3>Protecting Other People's Rights </h3>
                                <p>We respect other people's rights, and expect you to do the same.</p>

                                <p>You will not post content or take any action on ArticulateLogic that infringes someone else's rights or otherwise violates the law.</p> 
                                <p>We can remove any content you post on ArticulateLogic if we believe that it violates this Statement. </p>
                                <p>We will provide you with tools to help you protect your intellectual property rights. To learn more, visit our How to Report Claims of Intellectual Property Infringement page. </p>
                                <p>If we removed your content for infringing someone else's copyright, and you believe we removed it by mistake, we will provide you with an opportunity to appeal. </p>

                                <p>If you repeatedly infringe other people's intellectual property rights, we will disable your account when appropriate. </p>
                                <p>You will not use our copyrights or trademarks (including ArticulateLogic, the ArticulateLogic and F Logos, FB, Face, Poke, Wall and 32665) without our written permission. </p>
                                <p>If you collect information from users, you will: obtain their consent, make it clear you (and not ArticulateLogic) are the one collecting their information, and post a privacy policy explaining what information you collect and how you will use it. </p>
                                <p>You will not post anyone's identification documents or sensitive financial information on ArticulateLogic. </p>

                                <p>You give us all rights necessary to allow other users to download the software you submitted including the right to: place content, including ads, around your software information. </p>
                                <p>We can analyze your software, content, and data to ensure safety and usability.</p>
                                <p>To ensure your application is safe for users, we can audit it. </p>

                                <h3>Amendments </h3>
                                <p>We can change this Statement as long as we provide you notice through ArticulateLogic (unless you opt-out of such notice) and an opportunity to comment. </p>
                                <p>For all changes we will give you a minimum of seven days notice. </p>
                                <p>We can make changes for legal or administrative reasons upon notice without opportunity to comment. </p>

                                <h3>Termination </h3>
                                <p>If you violate the letter or spirit of this Statement, or otherwise create possible legal exposure for us, we can stop providing all or part of ArticulateLogic to you. We will generally try to notify you, but have no obligation to do so. You may also delete your account or disable your application at any time. In all such cases, this Statement shall terminate.</p>

                                <h3>Disputes </h3>
                                <p>If anyone brings a claim against us related to your actions or your content on ArticulateLogic, you will indemnify and hold us harmless from and against all damages, losses, and expenses of any kind (including reasonable legal fees and costs) related to such claim. </p>

                                <p>WE TRY TO KEEP ARTICULATELOGIC UP, BUG-FREE, AND SAFE, BUT YOU USE IT AT YOUR OWN RISK. WE ARE PROVIDING ARTICULATELOGIC 'AS IS' WITHOUT ANY EXPRESS OR IMPLIED WARRANTIES INCLUDING, BUT NOT LIMITED TO, IMPLIED WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE, AND NON-INFRINGEMENT. WE DO NOT GUARANTEE THAT ARTICULATELOGIC WILL BE SAFE OR SECURE. ARTICULATELOGIC IS NOT RESPONSIBLE FOR THE ACTIONS OR CONTENT OF THIRD PARTIES, AND YOU RELEASE US, OUR DIRECTORS, OFFICERS, EMPLOYEES, AND AGENTS FROM ANY CLAIMS AND DAMAGES, KNOWN AND UNKNOWN, ARISING OUT OF OR IN ANY WAY CONNECTED WITH ANY CLAIM YOU HAVE AGAINST ANY SUCH THIRD PARTIES. WE WILL NOT BE LIABLE TO YOU FOR ANY LOST PROFITS OR OTHER CONSEQUENTIAL, SPECIAL, INDIRECT, OR INCIDENTAL DAMAGES ARISING OUT OF OR IN CONNECTION WITH THIS STATEMENT OR ARTICULATELOGIC, EVEN IF WE HAVE BEEN ADVISED OF THE POSSIBILITY OF SUCH DAMAGES. OUR AGGREGATE LIABILITY ARISING OUT OF THIS STATEMENT OR ARTICULATELOGIC WILL NOT EXCEED THE GREATER OF ONE HUNDRED DOLLARS ($100) OR THE AMOUNT YOU HAVE PAID US IN THE PAST TWELVE MONTHS. APPLICABLE LAW MAY NOT ALLOW THE LIMITATION OR EXCLUSION OF LIABILITY OR INCIDENTAL OR CONSEQUENTIAL DAMAGES, SO THE ABOVE LIMITATION OR EXCLUSION MAY NOT APPLY TO YOU. IN SUCH CASES, ARTICULATELOGIC 'S LIABILITY WILL BE LIMITED TO THE FULLEST EXTENT PERMITTED BY APPLICABLE LAW. </p>

                                <h3>Definitions </h3>
                                <li>By 'ArticulateLogic' we mean the features and services we make available, including through (a) our website at www.articulatelogic.com and any other ArticulateLogic branded or co-branded websites; and (b) our Platform;</p> 
                                <p>By 'us,' 'we' and 'our' we mean ArticulateLogic, Inc. and/or its affiliates.</p> 
                                <p>By 'content' we mean the content and information you post on ArticulateLogic, including information about you and the actions you take. </p>
                                <p>By 'post' we mean post on ArticulateLogic or otherwise make available to us. </p>
                                <p>By 'use' we mean use, copy, publicly perform or display, distribute, modify, translate, and create derivative works of. </p>

                                <h3>Other</h3> 
                                <p>This Statement makes up the entire agreement between the parties regarding ArticulateLogic, and supersedes any prior agreements. </p>
                                <p>If any portion of this Statement is found to be unenforceable, the remaining portion will remain in full force and effect. </p>
                                <p>If we fail to enforce any of this Statement, it will not be considered a waiver. </p>
                                <p>Any amendment to or waiver of this Statement must be made in writing and signed by us. </p>
                                <p>You will not transfer any of your rights or obligations under this Statement to anyone else without our consent. </p>
                                <p>All of our rights and obligations under this Statement are freely assignable by us in connection with a merger, acquisition, or sale of assets, or by operation of law or otherwise. </p>
                                <p>Nothing in this Agreement shall prevent us from complying with the law. </p>
                                <p>This Statement does not confer any third party beneficiary rights. </p>

                                <h4>You may also want to review the following documents:</h4>
                                <p>Privacy Policy: The Privacy Policy is designed to help you understand how we collect and use information. </p>
"
                          );
	
	return $pageInfo[$pName];
}

function getCountryList()
{
    $countryList = array(
                "AF" =>"Afghanistan",
                "AX" =>"Aland Islands",
                "AL" =>"Albania",
                "DZ" =>"Algeria",
                "AS" =>"American Samoa",
                "AD" =>"Andorra",
                "AO" =>"Angola",
                "AI" =>"Anguilla",
                "AQ" =>"Antarctica",
                "AG" =>"Antigua and Barbuda",
                "AR" =>"Argentina",
                "AO" =>"Angola",
                "AO" =>"Angola",
                "AO" =>"Angola",
                "AO" =>"Angola",
                "AO" =>"Angola",
                "AO" =>"Angola",
                "AO" =>"Angola",
                "AO" =>"Angola",
                "AO" =>"Angola",
                "AO" =>"Angola",
                "AO" =>"Angola",
                "AO" =>"Angola",
                "AM" =>"Armenia", 
                "AW" =>"Aruba",
                "AU" => "Australia",
                "AT" =>"Austria",
                "AZ" =>"Azerbaijan",
                "BS" =>"Bahamas",
                "BH" =>"Bahrain",
                "BD" =>"Bangladesh",
                "BB" =>"Barbados",
                "BY" =>"Belarus",
                "BE" =>"Belgium",
                "BZ" =>"Belize",
                "BJ" =>"Benin",
                "BM" =>"Bermuda",
                "BT" =>"Bhutan",
                "BO" =>"Bolivia",
                "BA" =>"Bosnia and Herzegovina",
                "BW" =>"Botswana",
                "BV" =>"Bouvet Island",
                "BR" =>'Brazil',
                "IO" =>"British Indian Ocean Territory",
                "BN" =>"Brunei",
                "BG" =>"Bulgaria",
                "BF" =>"Burkina Faso",
                "BI" =>"Burundi",
                "KH" =>"Cambodia",
                "CM" =>"Cameroon",
                "CA" =>"Canada",
                "CV" =>"Cape Verde",
                "KY" =>"Cayman Islands",
                "CF" =>"Central African Republic",
                "TD" =>"Chad",
                "CL" =>"Chile",
                "CN" =>"China",
                "CX" =>"Christmas Island",
                "CC" =>"Cocos Islands",
                "CO" =>"Colombia",
                "KM" =>"Comoros",
                "CG" =>"Congo",
                "CD" =>"Congo, Democratic Republic of the",
                "CK" =>"Cook Islands",
                "CR" =>"Costa Rica",
                "CI" =>"Cote",
                "HR" =>"Croatia",
                "CU" =>"Cuba",
                "CY" =>"Cyprus",
                "CZ" =>"Czech Republic",
                "DK" =>"Denmark",
                "DJ" =>"Djibouti",
                "DM" =>"Dominica",
                "DO" =>"Dominican Republic",
                "EC" =>"Ecuador",
                "EG" =>"Egypt",
                "SV" =>"El Salvador",
                "GQ" =>"Equatorial Guinea",
                "ER" =>"Eritrea",
                "EE" =>"Estonia",
                "ET" =>"Ethiopia",
                "FK" =>"Falkland Islands",
                "FO" =>"Faroe Islands",
                "FJ" =>"Fiji",
                "FI" =>"Finland",
                "FR" =>"France",
                "GF" =>"French Guiana",
                "PF" =>"French Polynesia",
                "TF" =>"French Southern Territories",
                "GA" =>"Gabon",
                "GM" =>"Gambia",
                "GE" =>"Georgia",
                "DE" =>"Germany",
                "GH" =>"Ghana",
                "GI" =>"Gibraltar",
                "GR" =>"Greece",
                "GL" =>"Greenland",
                "GD" =>"Grenada",
                "GP" =>"Guadeloupe",
                "GU" =>"Guam",
                "GT" =>"Guatemala",
                "GG" =>"Guernsey",
                "GN" =>"Guinea",
                "GW" =>"Guinea-Bissau",
                "GY" =>"Guyana",
                "HT" =>"Haiti",
                "HM" =>"Heard Island and McDonald Islands",
                "HN" =>"Honduras",
                "HK" =>"Hong Kong",
                "HU" =>"Hungary",
                "IS" =>"Iceland",
                "IN" =>"India",
                "ID" =>"Indonesia",
                "IR" =>"Iran",
                "IQ" =>"Iraq",
                "IE" =>"Ireland",
                "IM" =>"Isle of Man",
                "IL" =>"Israel",
                "IT" =>"Italy",
                "JM" =>"Jamaica",
                "JP" =>"Japan",
                "JE" =>"Jersey",
                "JO" =>"Jordan",
                "KZ" =>"Kazakhstan",
                "KE" =>"Kenya",
                "KI" =>"Kiribati",
                "KW" =>"Kuwait",
                "KG" =>"Kyrgyzstan",
                "LA" =>"Laos",
                "LV" =>"Latvia",
                "LB" =>"Lebanon",
                "LS" =>"Lesotho",
                "LR" =>"Liberia",
                "LY" =>"Libya",
                "LI" =>"Liechtenstein",
                "LT" =>"Lithuania",
                "LU" =>"Luxembourg",
                "MO" =>"Macao",
                "MK" =>"Macedonia",
                "MG" =>"Madagascar",
                "MW" =>"Malawi",
                "MY" =>"Malaysia",
                "MV" =>"Maldives",
                "ML" =>"Mali",
                "MT" =>"Malta",
                "MH" =>"Marshall Islands",
                "MQ" =>"Martinique",
                "MR" =>"Mauritania",
                "MU" =>"Mauritius",
                "YT" =>'Mayotte',
                "MX" =>"Mexico",
                "FM" =>"Micronesia",
                "MD" =>"Moldova",
                "MC" =>"Monaco",
                "MN" =>"Mongolia",
                "ME" =>"Montenegro",
                "MS" =>"Montserrat",
                "MA" =>"Morocco",
                "MZ" =>"Mozambique",
                "MM" =>"Myanmar",
                "NA" =>"Namibia",
                "NR" =>"Nauru",
                "NP" =>"Nepal",
                "NL" =>"Netherlands",
                "AN" =>"Netherlands Antilles",
                "NC" =>"New Caledonia",
                "NZ" =>"New Zealand",
                "NI" =>"Nicaragua",
                "NE" =>"Niger",
                "NG" =>"Nigeria",
                "NU" =>"Niue",
                "NF" =>"Norfolk Island",
                "MP" =>"Northern Mariana Islands",
                "KP" =>"North Korea",
                "NO" =>"Norway",
                "OM" =>"Oman",
                "PK" =>"Pakistan",
                "PW" =>"Palau",
                "PS" =>"Palestinian Territories",
                "PA" =>'Panama',
                "PG" =>"Papua New Guinea",
                "PY" =>"Paraguay",
                "PE" =>"Peru",
                "PH" =>"Philippines",
                "PN" =>'Pitcairn',
                "PL" =>"Poland",
                "PT" =>"Portugal",
                "PR" =>"Puerto Rico",
                "QA" =>"Qatar",
                "RE" =>"Reunion",
                "RO" =>"Romania",
                "RU" =>"Russia",
                "RW" =>"Rwanda",
                "SH" =>"Saint Helena",
                "KN" =>"Saint Kitts and Nevis",
                "LC" =>"Saint Lucia",
                "PM" =>"Saint Pierre and Miquelon",
                "VC" =>"Saint Vincent and the Grenadines",
                "WS" =>"Samoa",
                "SM" =>"San Marino",
                "ST" =>"Sao Tome and Príncipe",
                "SA" =>"Saudi Arabia",
                "SN" =>"Senegal",
                "RS" =>"Serbia",
                "CS" =>"Serbia and Montenegro",
                "SC" =>"Seychelles",
                "SL" =>"Sierra Leone",
                "SG" =>"Singapore",
                "SK" =>"Slovakia",
                "SI" =>"Slovenia",
                "SB" =>"Solomon Islands",
                "SO" =>"Somalia",
                "ZA" =>"South Africa",
                "GS" =>"South Georgia and the South Sandwich Islands",
                "KR" =>"South Korea",
                "ES" =>"Spain",
                "LK" =>"Sri Lanka",
                "SD" =>"Sudan",
                "SR" =>"Suriname",
                "SJ" =>"Svalbard and Jan Mayen",
                "SZ" =>"Swaziland",
                "SE" =>"Sweden",
                "CH" =>"Switzerland",
                "SY" =>"Syria",
                "TW" =>"Taiwan",
                "TJ" =>"Tajikistan",
                "TZ" =>"Tanzania",
                "TH" =>"Thailand",
                "TL" =>"Timor-Leste",
                "TG" =>"Togo",
                "TK" =>"Tokelau",
                "TO" =>"Tonga",
                "TT" =>"Trinidad and Tobago",
                "TN" =>"Tunisia",
                "TR" =>"Turkey",
                "TM" =>"Turkmenistan",
                "TC" =>"Turks and Caicos Islands",
                "TV" =>"Tuvalu",
                "UG" =>"Uganda",
                "UA" =>"Ukraine",
                "AE" =>"United Arab Emirates",
                "GB" =>"United Kingdom",
                "US" =>"United States",
                "UM" =>"United States minor outlying islands",
                "UY" =>"Uruguay",
                "UZ" =>"Uzbekistan",
                "VU" =>"Vanuatu",
                "VA" =>"Vatican City",
                "VE" =>"Venezuela",
                "VN" =>"Vietnam",
                "VG" =>"Virgin Islands, British",
                "VI" =>"Virgin Islands, U.S.",
                "WF" =>"Wallis and Futuna",
                "EH" =>"Western Sahara",
                "YE" =>"Yemen",
                "ZM" =>"Zambia",
                "ZW" =>"Zimbabwe");
    return $countryList;
}

function content_type($name) 
{ 
    $contenttype  = 'application/octet-stream'; 
    $contenttypes = array( 'html' => 'text/html', 
                           'htm'  => 'text/html', 
                           'txt'  => 'text/plain', 
                           'gif'  => 'image/gif', 
                           'jpg'  => 'image/jpeg', 
                           'png'  => 'image/png', 
                           'sxw'  => 'application/vnd.sun.xml.writer', 
                           'sxg'  => 'application/vnd.sun.xml.writer.global', 
                           'sxd'  => 'application/vnd.sun.xml.draw', 
                           'sxc'  => 'application/vnd.sun.xml.calc', 
                           'sxi'  => 'application/vnd.sun.xml.impress', 
                           'xls'  => 'application/vnd.ms-excel', 
                           'ppt'  => 'application/vnd.ms-powerpoint', 
                           'doc'  => 'application/msword', 
                           'rtf'  => 'text/rtf', 
                           'zip'  => 'application/zip', 
                           'mp3'  => 'audio/mpeg', 
                           'pdf'  => 'application/pdf', 
                           'tgz'  => 'application/x-gzip', 
                           'gz'   => 'application/x-gzip', 
                           'vcf'  => 'text/vcf' ); 

    $name = ereg_replace("§", " ", $name); 
    foreach ($contenttypes as $type_ext => $type_name) { 
        if (preg_match ("/$type_ext$/i",  $name)) $contenttype = $type_name; 
    } 
    return $contenttype; 
}
?>
