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

class plugin_info_featured_listings_asamodule_1
	{
	function plugin_info_featured_listings_asamodule_1()
		{
		$this->data=array(
			"name"=>"featured_listings_asamodule_1",
			"version"=>"1.8",
			"description"=> "Allows you to display the featured listings in a module position using jomres_asamodule by setting the task to featured_listings_asamodule_1. You can also set the property/listing types ids to be displayed by using &ptype_ids=X,Y,Z and the number of properties/listings to be displayed by using &limit=L",
			"lastupdate"=>"2013/10/09",
			"min_jomres_ver"=>"7.4.0",
			"author"=>"Vince Wooll",
			"authoremail"=>"sales@jomres.net",
			"manual_link"=>'',
			'change_log'=>'1.1 fixed an issue where this plugin and featured_listings_asamodule_2 had a duplicated function name. 1.2 Small change to make it work if ptype_ids param is not set. If it`s not set, will display all featured properties. 1.3  change in the description output. first we don`t need to parse the description by bots in modules, and we also use strip html tags and html entity decode to avoid displaying the html code in text. v1.4 Updated to work with Jr7 1.5  Templates bootstrapped. v1.6 updated code to use translatable region names. v1.7 Added code supporting Media Centre image locations. v1.8 Improved how the feature listings ordering is calculated.',
			'image'=>'',
			'demo_url'=>''
			);
		}
		

	}
?>