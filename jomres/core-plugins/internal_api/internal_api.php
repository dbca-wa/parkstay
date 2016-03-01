<?php
/**
 * Core file
 * @author Vince Wooll <sales@jomres.net>
 * @version Jomres 4 
* @package Jomres
* @copyright	2005-2012 Vince Wooll
* Jomres (tm) PHP files are released under both MIT and GPL2 licenses. This means that you can choose the license that best suits your project, and use it accordingly, however all images, css and javascript which are copyright Vince Wooll are not GPL licensed and are not freely distributable. 
**/


// ################################################################
defined( '_JEXEC' ) or die( '' );
// ################################################################

require_once(JPATH_BASE.DS.'jomres'.DS.'core-plugins'.DS.'alternative_init'.DS.'alt_init.php');

define("JOMRES_RETURNDATA",1);

class internal_api
	{
	function get($call,$arguments=array())
		{
		$function_name='jria_'.$call; // We prepend the function name just to ensure that we don't trip over any other functions with similar names. 
		ob_start();
		if(file_exists(JPATH_BASE.DS.'jomres'.DS.'core-plugins'.DS.'internal_api'.DS.'functions'.DS.$call.'.php'))
			{
			require_once(JPATH_BASE.DS.'jomres'.DS.'core-plugins'.DS.'internal_api'.DS.'functions'.DS.$call.'.php');
			$function_name($arguments);
			}
		else
			{
			echo "HI";
			}
		
		if (get_showtime("internal_api_results") != null)
			return get_showtime("internal_api_results");
		else
			{
			$contents = ob_get_contents();
			ob_end_clean();
			return $contents;
			}
		}
	}
?>
<?php

///////////////////////////////////////////////////////////////////////////////////////////////////////
// Property details page

// require_once(JPATH_BASE.DS.'jomres'.DS.'core-plugins'.DS.'internal_api'.DS.'internal_api.php');
// $arguments = array();
// $arguments['property_uid'] = 1;
// $property_details = internal_api::get("viewproperty",$arguments);
// echo $property_details;

///////////////////////////////////////////////////////////////////////////////////////////////////////
// Property list page

// require_once(JPATH_BASE.DS.'jomres'.DS.'core-plugins'.DS.'internal_api'.DS.'internal_api.php');
// $arguments = array();
// $arguments['property_uids'] = array(1,2,3);
// $arguments['showheaders'] = true;
// $arguments['jomsearch_sortby'] = 2;
// $property_list = internal_api::get("listproperties",$arguments);
// echo $property_list;

///////////////////////////////////////////////////////////////////////////////////////////////////////
// Information about the booking items in the cart

// An object will be returned 
// Object sample :
// object(stdClass)[284]
// public 'currency_code' => string 'EUR' (length=3)
// public 'total' => float 310.66084280321
// public 'deposit' => float 164.54012649299
// public 'jsid' => string 'HpTtVtpLtgUUmqLpMQLltwUIYDPLYJBmYCVzFBWHnjIlIgnPNw' (length=50)
// public 'number_of_bookings' => int 2
// public 'items' => 
  // array
    // 'ShvNZaMmqCldPRZlXCPy' => 
      // array
        // 'total' => float 148.3044913474
        // 'deposit' => float 148.3044913474
    // 'BGnRxsRrsxslisflZtDv' => 
      // array
        // 'total' => float 162.35635145581
        // 'deposit' => float 16.235635145581

// Get information about the items in the Jomres cart. Regardless of the currency of the booking all figures are converted to the Global Currency code before being returned in this object.
// Whilst you're given the total, you're not expected to act on it, that's for your own information/use. Instead you're expected to act on the $obj->deposit sum, taking payment for that. 
// Don't take another figure in your payment gateway and expect Jomres to adapt accordingly. When the time comes to mark the booking paid and the bookings are created, Jomres will mark the deposit it expected, as paid so if you're taking a different figure then your user's records may become confused.
// Your script will need to make a note of jsid, as you'll be using that later when you want to create the bookings (until payment is made they're still not created, they're only created in the next step).

/*
require_once(JPATH_BASE.DS.'jomres'.DS.'core-plugins'.DS.'internal_api'.DS.'internal_api.php');
$obj = internal_api::get("getcarttotals",array());
*/
//var_dump($obj);


///////////////////////////////////////////////////////////////////////////////////////////////////////
// Marking a booking as paid

// We're assuming that your own component has handled payment, so there will be no checking on Jomres' part that payment has been taken, you're simply telling Jomres that it's been paid and that Jomres should create the bookings in it's system.
// We'll re-use $obj here, normally you would be generating the object/data yourself after you've processed payment
/*
require_once(JPATH_BASE.DS.'jomres'.DS.'core-plugins'.DS.'internal_api'.DS.'internal_api.php');
// To mark a booking paid, there's a few things we need to pass back to Jomres
$arguments = array();
// First we need the jsid. The Jomres Session ID is initially passed back to the calling script when you've called "getcarttotals" See the previous example.
$arguments['jsid'] = $obj->jsid;
// Then the items. This is a security check to stop a user adding more bookings once the calling component has taken over payment duties
$arguments['items'] = $obj->items;
// Can be true or false. This refers to the deposit. If it's set to false then the booking information will show the deposit as still owing.
$arguments['booking_paid'] = true;

$result = internal_api::get("createbookingsfromcart",$arguments);

var_dump($result );
*/

///////////////////////////////////////////////////////////////////////////////////////////////////////
// Get the last review entered
/* 
require_once(JPATH_BASE.DS.'jomres'.DS.'core-plugins'.DS.'internal_api'.DS.'internal_api.php');
$arguments = array();
$arguments['property_uid'] = 1;
$review = internal_api::get("getlastreview",$arguments);

 */
?>