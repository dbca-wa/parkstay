<?php
/**
 * Plugin
 * @author Vince Wooll <sales@jomres.net>
 * @version Jomres 4 
* @package Jomres
* @copyright	2005-2010 Vince Wooll
* Jomres (tm) PHP files are released under both MIT and GPL2 licenses. This means that you can choose the license that best suits your project, and use it accordingly, however all images, css and javascript which are copyright Vince Wooll are not GPL licensed and are not freely distributable. 
**/

// ################################################################
defined( '_JOMRES_INITCHECK' ) or die( '' );
// ################################################################

class plugin_info_alternative_init
	{
	function plugin_info_alternative_init()
		{
		$this->data=array(
			"name"=>"alternative_init",
			"version"=>(float)"2",
			"description"=> "When Jomres starts it needs some information to be created before it will run. Jomres.php/j00030search.class.php will do this normally however there are times when you may want to run use Jomres functionality without actually running Jomres in the component area. In this case you can include the alt_init.php script included in this plugin. This will perform the required initialisation steps without actually running Jomres itself.",
			"lastupdate"=>"2012/10/05",
			"min_jomres_ver"=>"7.0.2",
			"manual_link"=>'alt_init',
			'change_log'=>'  v1.1 Added image location paths. 1.3 Added trigger point 00005, means that plugins that call their own lang files will be triggered even if we\'re not on a Jomres page. Mainly this is for facilitating the new Jomres Main Menu. 1.4 Tracked down the cause of some servers not being able to use the Live Scrolling feature, it was because alt init was starting a fresh temp booking session after one had already been set up. This fix gets alt init to check and see whether the jomressession is already set, if not then alt init will not try to start a new session. 1.5 Updated plugin to enable use of new js and css caching offered by Jomres 6.3.3. 1.6 updated plugin to use the new 00004 in 6.6.3, however this plugin should work fine with 6.6.2. 1.7 6.6.4 modified how javascript is constructed, which necessitates a change to this plugin. 1.8  Changed how the temp booking handler is initialised to resolve intermittent language selection problems. v1.9 Further related language tweaks.',
			'highlight'=>'',
			'image'=>'',
			'demo_url'=>''
			
			);
		}
	}
?>