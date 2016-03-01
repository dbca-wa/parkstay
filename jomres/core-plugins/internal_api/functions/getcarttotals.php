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

function jria_getcarttotals($arguments)
	{
	$tmpBookingHandler =jomres_getSingleton('jomres_temp_booking_handler');
	jr_import('jomres_cart');
	$cart = new jomres_cart();
	$obj = new stdClass;
	$obj->currency_code				= $cart->currency_code;
	$obj->total						= $cart->contract_total;
	$obj->deposit					= $cart->deposit_required;
	$obj->jsid						= $tmpBookingHandler->getJomressession();
	$obj->number_of_bookings		= $cart->number_of_bookings;
	$obj->items						= $cart->items;
	set_showtime("internal_api_results",$obj);
	}
?>