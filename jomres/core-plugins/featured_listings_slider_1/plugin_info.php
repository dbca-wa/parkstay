<?php
/**
 * Plugin
 * @author Vince Wooll <sales@jomres.net>
 * @version Jomres 5
* @package Jomres
* @copyright	2005-2011 Vince Wooll
* Jomres (tm) PHP files are released under both MIT and GPL2 licenses. This means that you can choose the license that best suits your project, and use it accordingly, however all images, css and javascript which are copyright Vince Wooll are not GPL licensed and are not freely distributable. 
**/

// ################################################################
defined( '_JOMRES_INITCHECK' ) or die( '' );
// ################################################################

class plugin_info_featured_listings_slider_1
	{
	function plugin_info_featured_listings_slider_1()
		{
		$this->data=array(
			"name"=>"featured_listings_slider_1",
			"version"=>(float)"1.9",
			"description"=> "Allows you to display a slider with the featured listings in a module position using jomres_asamodule by setting the task to featured_listings_slider_1. You can also set the property/listing types ids to be displayed by using &ptype_ids=X,Y,Z and the number of properties/listings to be displayed by using &limit=L.",
			"lastupdate"=>"2013/10/15",
			"min_jomres_ver"=>"7.5.0",
			"manual_link"=>'',
			'change_log'=>'1.1 fixed a bug where the limit wasn\'t being set correctly. v1.2 Improved how html is stripped from descriptions. v1.3 tweak to ensure limit setting is used. 1.4 css tweak 1.5 Updated to work with Jr7 1.6 Bootstrapped. If using bootstrap this plugin will use Bootstrap carousel instead of the older slideshow functionality. 1.7 Modified thumbnail so that it links to property details page. 1.8 Added code supporting Media Centre image locations. v1.9 Improved how the feature listings ordering is calculated',
			'highlight'=>'',
			'image'=>'',
			'demo_url'=>'http://userdemo.jomres-demo.net/index.php?option=com_content&view=article&id=3&Itemid=105'
			);
		}
	}
?>