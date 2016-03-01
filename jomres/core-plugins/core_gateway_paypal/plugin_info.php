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

class plugin_info_core_gateway_paypal
	{
	function plugin_info_core_gateway_paypal()
		{
		$this->data=array(
			"name"=>"core_gateway_paypal",
			"version"=>(float)"2.5",
			"description"=> " Adds paypal gateway functionality. Apart from ordinary deposit payments, this plugin is required if you want to use the subscription functionality.",
			"lastupdate"=>"2013/08/11",
			"min_jomres_ver"=>"7.3.1",
			"manual_link"=>'core_gateway_paypal',
			'change_log'=>' V1.1 updated for use in v5.6 1.2 updated to deal with new paypal expansion changes. 1.3 As we have removed the generic onload script from jomres.js this plugin has now been adapted to use document ready to trigger the redirection to paypal. 1.4 Changed a url to match new changes in 6.6.7 v1.5 Fixed a broken url. 1.6 updated to work with Jr7.1 v1.7 v7.1 specific changes v1.8 Added some extra, probably superfluous but better to have it that not, sanitisation. v1.9 Made changes in support of the Text Editing Mode in 7.2.6.v2 added code to prevent buttons being clicked twice. v2.1 Reversed the previous change as it does not work on Chrome. v2.2 Minor tweak to ensure that editing mode does not interfere with buttons. Added support for double-click prevention. v2.3 Fixed an issued where automatic redirection to paypal would not take place due to new "double click" prevention being added. v2.4 hardened a field. v2.5 Removed references to Token functionality that is no longer used.',
			'highlight'=>'',
			'image'=>'http://www.jomres.net/non-joomla/plugin_list/plugin_images/paypal_gateway.png',
			'demo_url'=>''
			);
		}
	}
?>