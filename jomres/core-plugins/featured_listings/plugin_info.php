<?php
/**
 * Plugin
 * @author Vince Wooll <sales@jomres.net>
 * @version Jomres 4 
* @package Jomres
* @copyright	2005-2011 Vince Wooll/Woollyinwales IT
* Jomres (tm) PHP files are released under both MIT and GPL2 licenses. This means that you can choose the license that best suits your project, and use it accordingly, however all images, css and javascript which are copyright Vince Wooll are not GPL licensed and are not freely distributable. 
**/

// ################################################################
defined( '_JOMRES_INITCHECK' ) or die( '' );
// ################################################################

class plugin_info_featured_listings
	{
	function plugin_info_featured_listings()
		{
		$this->data=array(
			"name"=>"featured_listings",
			"version"=>"1.5",
			"description"=> " Allows you to set some listings as featured. The search results will have the featured listings (that qualify in the search) displayed at the top. Successor to the older 'featured properties' plugins.",
			"lastupdate"=>"2013/07/17",
			"min_jomres_ver"=>"7.3.0",
			"author"=>"Vince Wooll",
			"authoremail"=>"sales@jomres.net",
			"manual_link"=>'',
			'change_log'=>'v1.1 Modified to work with bootstrap, and added option to enter a featured listings class so that featured listings are emphasised in the property list. 1.2  Templates bootstrapped. 1.3 updated to work with Jr7.1 1.4 Jr7.1 specific changes v1.5 Minor tweak to ensure that editing mode does not interfere with buttons.',
			'highlight'=>'',
			'image'=>'',
			'demo_url'=>''
			);
		}
		

	}
?>