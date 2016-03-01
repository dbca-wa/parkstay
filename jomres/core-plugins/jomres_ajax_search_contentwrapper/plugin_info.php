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

class plugin_info_jomres_ajax_search_contentwrapper
	{
	function plugin_info_jomres_ajax_search_contentwrapper()
		{
		$this->data=array(
			"name"=>"jomres_ajax_search_contentwrapper",
			"version"=>(float)"1",
			"description"=> "Mambot. Wraps all Joomla content areas in a div that gives the jomres ajaxsearch asamodule a place to put search results. In short, when a search is triggered it replaces the contents of the component area with the search results. ",
			"lastupdate"=>"2012/01/12",
			"type"=>"mambot",
			"min_jomres_ver"=>"7.-1.0",
			'highlight'=>'Use the Jomres plugin manager to add it to your system, then use Joomla\'s Discover feature to install it. After that, use the Joomla Plugin Manager to enable the plugin. <p><i>Cannot be uninstalled via the Jomres plugin manager, you must use the Joomla Extension Manager instead.</i></p>',
			);
		}
	}
?>