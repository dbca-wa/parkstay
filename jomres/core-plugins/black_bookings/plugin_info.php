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

class plugin_info_black_bookings
	{
	function plugin_info_black_bookings()
		{
		$this->data=array(
			"name"=>"black_bookings",
			"version"=>(float)"2.4",
			"description"=> " Adds a new button to the receptionist's toolbar, allows receptionists and managers to black book rooms or properties out, making them unavailable for certain periods.",
			"lastupdate"=>"2013/08/11",
			"min_jomres_ver"=>"7.1.0",
			"manual_link"=>'black_bookings',
			'change_log'=>'v2.0 changed the order of days in the calendar. v2.1  Made changes in support of the Text Editing Mode in 7.2.6. v2.2 Removed references to Token functionality that is no longer used. v2.3 Removed references to Jomres URL Token function. v2.4 changed how text is rendered to enable translation of some strings.',
			'highlight'=>'',
			'image'=>'http://www.jomres.net/non-joomla/plugin_list/plugin_images/black_bookings.png',
			'demo_url'=>'http://userdemo.jomres-demo.net/index.php?option=com_jomres&Itemid=103&task=listBlackBookings'
			);
		}
	}
?>