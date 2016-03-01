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

class plugin_info_funky_search_features
	{
	function plugin_info_funky_search_features()
		{
		$this->data=array(
			"name"=>"funky_search_features",
			"version"=>(float)"1.8",
			"description"=> "  Offers a list of features to search by. Best to offer a link via a menu option to get to this page. Set the url to something like http://www.domain.com/index.php?option=com_jomres&itemid=NN&task=funky_search_features.",
			"lastupdate"=>"2013/08/07",
			"min_jomres_ver"=>"7.3.1",
			"manual_link"=>'funky_search_features',
			'change_log'=>' v1.1 removed line height in tempate css and update notes to say : Note, this feature uses the basic search settings from the integrated search feature, so you will need to enable searching by features in Site Config -> integrated search if you want to use this plugin. 1.2 Modified javascript to make it compatible with v5.2, this plugin requires Jomres v5.2beta2 or greater. 1.3 Fixed a fatal error that\'ll show regarding a missing search class. 1.4 Updated to add a menu option to Jomres 6 mainmenu. Added a lang file. 1.5 Updated to work with Jr7 1.6 fixed the name of it the class. 1.7 fixed a broken url. v1.8 Improved how an input is filtered.',
			'highlight'=>'',
			'image'=>'http://www.jomres.net/non-joomla/plugin_list/plugin_images/funky_search_features.png',
			'demo_url'=>''
			);
		}
	}
?>