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

function jria_viewproperty($arguments)
	{
	$MiniComponents =jomres_singleton_abstract::getInstance('mcHandler');
	$componentArgs=array();
	$componentArgs['property_uid']=(int)$arguments['property_uid'];
	set_showtime('property_uid',(int)$arguments->property_uid);
	property_header($property_uid);
	$MiniComponents->triggerEvent('00016',$componentArgs);
	}
?>