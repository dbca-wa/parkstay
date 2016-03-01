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

class plugin_info_jomres_asamodule
	{
	function plugin_info_jomres_asamodule()
		{
		$this->data=array(
			"name"=>"jomres_asamodule",
			"version"=>(float)"1.4",
			"description"=> 'Module. Allows you to run a certain Jomres task as a module. See the module parameters page for more information.  ',
			"lastupdate"=>"2012/05/08",
			"type"=>"module",
			"min_jomres_ver"=>"7.-1.0",
			"manual_link"=>'jomres_asamodule',
			'change_log'=>' v1.2 Updated plugin for v4/v5 compatability. 1.3 tweaked plugin for v6 to ensure that the showtime task is set. 1.4 minor code tidyup.',
			'highlight'=>' REQUIRES THE ALT INIT PLUGIN TO BE INSTALLED FIRST. ONCE INSTALLED PLEASE USE JOOMLA\'S DISCOVER FEATURE TO FINISH THE MODULE\'S INSTALLATION. <p><i>To upgrade, you need to reinstall it through the Jomres plugin manager. Once you have uninstalled it in the module manager it will still show up as installed in the Jomres plugin manager, but the files will have been removed by Joomla.</i></p>',
			'image'=>'',
			'demo_url'=>''
			);
		}
	}
?>