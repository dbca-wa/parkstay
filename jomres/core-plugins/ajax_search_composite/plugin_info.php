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

class plugin_info_ajax_search_composite
	{
	function plugin_info_ajax_search_composite()
		{
		$this->data=array(
			"name"=>"ajax_search_composite",
			"version"=>(float)"3.8",
			"description"=> "Uses the ajax search framework, and replaces ajax search asamodule. Allows you to put a search module that offers searching on availability, price range, features, property type, room type, guest numbers, stars, country, region and town in a sidebar. You'll need to create a new jomres asamodule module, set the task to 'ajax_search' and the arguments to '&ajs_plugin=ajax_search_composite'. You will then have a new option in the administrator -> portal area which allows you to enable/dislable different options. You can also 'pre filter' property uids and property types, so instead of searching all properties, you can tell the system to only return properties that fall into a group that you have already selected. To do that, you would add more arguments to the arguments field like so : '&ajs_plugin=ajax_search_composite&property_uids=1,3&ptypes=5' By default all options are enabled, you can disable them through the new button under 'Portal Functionality' titled 'Ajax search composite settings', or through the arguments list. 
			In v3.8 we added the option to prefilter countries and regions, so to prefilter the countries so that only regions in certain countries are shown you would do something like &prefilter_country_code=GB,FR which will only show regions in the UK and France. Similarly, you can prefilter regions like so : &prefilter_region=Avon which will only show towns in the county of Avon. Because Avon is in the UK, no other coutries will be shown.
			
			To disable an option through the arguments list you can set the arguments like so : '&ajs_plugin=ajax_search_composite&by_stars=0' however be aware that if you have set an option via 'Ajax search composite settings' to No then setting 'by_stars' in the arguments list will have no effect. The full list of options are by_stars, by_price, by_features, by_country, by_region, by_town, by_roomtype, by_propertytype and by_guestnumber, by_date. If you're using a bootstrapped template you've got a choice of two templates to use, by setting the Modal option to Yes or No. With this set to No then all filter options will be viewable as buttons. If set to Yes then the title becomes clickable and the filter options can be seen in a modal popup. If you have html experience and are familiar with bootstrap then you can further customise this look/feel by combining the elements you like from each template into one. ",
			"lastupdate"=>"2013/10/18",
			"min_jomres_ver"=>"7.5.0",
			"manual_link"=>'',
			'change_log'=>'v3.2 Modified templates to ensure use of both jq ui and bootstrap templates for plugin configuration in administrator. v3.2 modified functionality so that stars checkboxes can be reset, and another ajax call is triggered so that reset is saved to the session so on a new page load, the reset means that buttons are also reset. Improvement, not bugfix. v3.3 uses a new Jomres 7.2.16 function "genericLike" which helps to search for towns with multiple words. v3.4 Minor tweak to ensure that editing mode does not interfere with buttons. v3.5 Added code to sort Countries, Regions and Towns "naturally". v3.6 Removed references to Token functionality that is no longer used. v3.7 Added Array Caching. v3.8 Added prefiltering for countries and regions, improved sorting and added country names to region output and region names to town output.',
			'highlight'=>'',
			'image'=>'',
			'demo_url'=>''
			);
		}
	}
?>