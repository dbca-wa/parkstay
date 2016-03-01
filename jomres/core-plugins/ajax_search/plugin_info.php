<?php
/**
 * Plugin
 * @author Vince Wooll <sales@jomres.net>
 * @version Jomres 4 
* @package Jomres
* @copyright	2005-2013 Vince Wooll/Woollyinwales IT
* Jomres (tm) PHP files are released under both MIT and GPL2 licenses. This means that you can choose the license that best suits your project, and use it accordingly, however all images, css and javascript which are copyright Vince Wooll are not GPL licensed and are not freely distributable. 
**/

// ################################################################
defined( '_JOMRES_INITCHECK' ) or die( '' );
// ################################################################

class plugin_info_ajax_search
	{
	function plugin_info_ajax_search()
		{
		$this->data=array(
			"name"=>"ajax_search",
			"version"=>(float)"3.6",
			"description"=> " Provides a framework for other plugins to enable ajax based search functionality. All plugins titled ajax_search_XXX require this plugin to run. By default this plugin offers a search by features series of inputs, which is designed to work as a fallback if an 'ajax search' plugin hasn't been installed yet. ",
			"lastupdate"=>"2013/08/07",
			"min_jomres_ver"=>"7.3.1",
			"manual_link"=>'site_managers_guide_plugins_ajax_search',
			'change_log'=>'3.1 improved the auto-strolling to scroll to the top of the Jomres content div, instead of the top of the page. 3.2  Made changes in support of the Text Editing Mode in 7.2.6. v3.3 modified a function in ajax search, scrolling to top caused an error to be thrown in IE, so that is fixed. v3.4 modified a clause, where we check to see if the current page includes the booking form, as the ajax search cannot be shown on the same page. v3.5 Added random identifier to the submit button. v3.6 Commented out a function that adds gmaps source as this is now handled by core functionality.',
			'highlight'=>'',
			'image'=>'http://www.jomres.net/non-joomla/plugin_list/plugin_images/ajax_search.png',
			'demo_url'=>''
			);
		}
	}
?>