<?php
/**
 * Core file
 * @author Vince Wooll <sales@jomres.net>
 * @version Jomres 4 
* @package Jomres
* @copyright	2005-2011 Vince Wooll
* Jomres (tm) PHP files are released under both MIT and GPL2 licenses. This means that you can choose the license that best suits your project, and use it accordingly, however all images, css and javascript which are copyright Vince Wooll are not GPL licensed and are not freely distributable. 
**/

// ################################################################
defined( '_JOMRES_INITCHECK' ) or die( '' );
// ################################################################

// Pass a list of property uids, the property list will be returned, complete with headers
function jria_listproperties($arguments)
	{
	if(!$arguments['showheaders'])
		define('JOMRES_NOHTML',true);
	$MiniComponents =jomres_singleton_abstract::getInstance('mcHandler');
	$tmpBookingHandler =jomres_singleton_abstract::getInstance('jomres_temp_booking_handler');
	$tmpBookingHandler->user_settings['jomsearch_sortby']= $arguments['jomsearch_sortby'];
	$componentArgs=array();
	$componentArgs['propertys_uid']=$arguments['property_uids'];
	$MiniComponents->triggerEvent('01004',$componentArgs); // optional
	$MiniComponents->triggerEvent('01005',$componentArgs); // optional
	$MiniComponents->triggerEvent('01006',$componentArgs); // optional
	$MiniComponents->triggerEvent('01007',$componentArgs); // optional
	$componentArgs['live_scrolling_enabled']=false;
	$MiniComponents->triggerEvent('01010',$componentArgs); // listPropertys
	}
?>