<?php
/**
 * Plugin
 * @author Vince Wooll <sales@jomres.net>
 * @version Jomres 4 
* @package Jomres
* @copyright	2005-2010 Vince Wooll
* Jomres (tm) PHP files are released under both MIT and GPL2 licenses. This means that you can choose the license that best suits your project, and use it accordingly, however all images, css and javascript which are copyright Vince Wooll are not GPL licensed and are not freely distributable. 
**/

// Designed to allow a non-jomres script to include jomres functionality without actually running Jomres itself

if (!defined('JPATH_BASE'))
	defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );
else if (file_exists(JPATH_BASE .'/includes/defines.php') )
		defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );
	else
		defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

if (!defined('_JOMRES_INITCHECK'))
	define('_JOMRES_INITCHECK', 1 );

require_once('jomres/integration.php');

$thisJRUser=jomres_singleton_abstract::getInstance('jr_user');
$siteConfig = jomres_singleton_abstract::getInstance('jomres_config_site_singleton');

$tmpBookingHandler =jomres_singleton_abstract::getInstance('jomres_temp_booking_handler');

if (is_null($tmpBookingHandler->jomressession))
	{
	$tmpBookingHandler->initBookingSession(get_showtime('jomressession'));
	$jomressession  = $tmpBookingHandler->getJomressession();
	}


$property_uid = detect_property_uid();
if ($property_uid > 0)
	{
	$current_property_details =jomres_singleton_abstract::getInstance('basic_property_details');
	$current_property_details->gather_data($property_uid);
	$query="SELECT ptype_desc FROM #__jomres_ptypes WHERE id = ".(int)$current_property_details->ptype_id;
	$propertytype = doSelectSql($query,1);
	$jomreslang =jomres_singleton_abstract::getInstance('jomres_language');
	$jomreslang->get_language($propertytype);
	}
else
	{
	$jomreslang =jomres_singleton_abstract::getInstance('jomres_language');
	$jomreslang->get_language('');
	}


$customTextObj =jomres_singleton_abstract::getInstance('custom_text');

if (!defined('JOMRES_IMAGELOCATION_ABSPATH'))
	{
	define('JOMRES_IMAGELOCATION_ABSPATH',JOMRESCONFIG_ABSOLUTE_PATH.JRDS.'jomres'.JRDS.'uploadedimages'.JRDS);
	define('JOMRES_IMAGELOCATION_RELPATH',get_showtime('live_site').'/jomres/uploadedimages/');
	}

$MiniComponents =jomres_singleton_abstract::getInstance('mcHandler');
$MiniComponents->triggerEvent('00003'); // 
init_javascript(); // 00004 is triggered in this function now.
$MiniComponents->triggerEvent('00005');
$componentArgs=array();
$MiniComponents->triggerEvent('99999',$componentArgs); // Javascript and CSS caching handling is needed 
$componentArgs=array();
