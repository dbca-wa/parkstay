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

function jria_createbookingsfromcart($arguments)
	{
	$obj = new stdClass;
	$obj->success=true;
	if($arguments['jsid'] == "")
		{
		$obj->success=false;
		$obj->error_message="jsid not passed";
		set_showtime("internal_api_results",$obj);
		}
	
	$tmpBookingHandler =jomres_getSingleton('jomres_temp_booking_handler');
	$tmpBookingHandler->initBookingSession($arguments['jsid']);
	$items = $arguments['items'];
	
	if(count($items)>0)
		{
		foreach ($items as $key=>$cart_data)
			{
			$cart_data = $tmpBookingHandler->cart_data[$key];
			$tmpBookingHandler->tmpbooking = $tmpBookingHandler->cart_data[$key];
			$tmpBookingHandler->tmpguest = $tmpBookingHandler->cart_data[$key]['tmpguest'];
			$tmpBookingHandler->updateBookingField('cart_payment',true);
			$depositPaid=(bool)$arguments['booking_paid'];
			//var_dump($tmpBookingHandler->tmpbooking);exit;
			
			insertInternetBooking("",$depositPaid,$confirmationPageRequired=false);
			// $MiniComponents =jomres_singleton_abstract::getInstance('mcHandler');
			// $componentArgs=array('jomressession'=>get_showtime('jomressession'),'depositPaid'=>true,'usejomressessionasCartid'=>false);
			// $result=$MiniComponents->triggerEvent('03020',$componentArgs); // Trigger the insert booking mini-comp
			// gateway_log("insertInternetBooking: ".serialize($MiniComponents->miniComponentData['03020']) );
			// if (!$MiniComponents->miniComponentData['03020']['insertbooking']['insertSuccessful'])
				// {
				// $obj->success=false;
				// $obj->error_message="Booking could not be inserted for some reason.";
				// }
			
			$tmpBookingHandler->resetTempBookingData();
			$tmpBookingHandler->resetTempGuestData();
			}
		}
	else
		{
		$obj->success=false;
		$obj->error_message="No items passed.";
		}
	
	$tmpBookingHandler->resetCart();
	set_showtime("internal_api_results",$obj);
	}
?>