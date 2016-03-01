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

class plugin_info_jomsearch_m3
	{
	function plugin_info_jomsearch_m3()
		{
		$this->data=array(
			"name"=>"jomsearch_m3",
			"version"=>(float)"2.8",
			"description"=> 'Module. Search module.',
			"lastupdate"=>"2013/02/12",
			"type"=>"module",
			"min_jomres_ver"=>"7.2.10",
			"manual_link"=>'jomsearch_mx',
			'change_log'=>'2.1 Updated module to bring it into line with v5.1. 2.2 Added a dependencies check file to ensure that users are advised that alt_init needs to be installed before they install this plugin. 2.3 Added a check to see if _JOMRES_INITCHECK has already been defined. 2.4 Added geosearch options to xml file. 2.5 added module class suffix. 2.6 Modified the form url, to ensure that the language parameter is sent with queries. 2.7 minor code tidyup. v2.8  Changed the construction of the form url.',
			'highlight'=>'REQUIRES THE ALT INIT PLUGIN TO BE INSTALLED FIRST. ONCE INSTALLED PLEASE USE JOOMLA\'S DISCOVER FEATURE TO FINISH THE MODULE\'S INSTALLATION. <p><i>To upgrade, you need to uninstall this plugin via the Joomla extension manager first, then reinstall it through the Jomres plugin manager. Once you have uninstalled it in the module manager it will still show up as installed in the Jomres plugin manager, but the files will have been removed by Joomla.</i></p>',
			'image'=>'',
			'demo_url'=>''
			);
		}
	}
?>