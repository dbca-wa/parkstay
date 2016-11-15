<?php
/**
 * @version		$Id: osdcs $
 * @package		migs
 * @copyright	Copyright (C) 2005 - 2010 osdcs.com. All rights reserved.
 *              see COPYRIGHT.php
 * @license		GNU/GPL, see LICENSE.php
 * Joomla! is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 */
//
// ################################################################
if (defined('JPATH_BASE'))
	defined('_JEXEC') or die('Direct Access to this location is not allowed.');
else
	defined( '_VALID_MOS') or die('Direct Access to this location is not allowed.');
// ################################################################
//include "lphp.php";

global $eLiveSite, $jomresConfig_live_site, $jomresConfig_absolute_path, $mosConfig_absolute_path, $mosConfig_lang;
$plugin = "migs";

require('VPCPaymentConnection.php');

class j00610migs
{

	function j00610migs()
	{

		global $jomresConfig_absolute_path, $jomressession, $tmpBookingHandler, $jomresConfig_live_site;

		if (!function_exists('jomres_getSingleton'))
			global $MiniComponents;
		else
			$MiniComponents = jomres_getSingleton('mcHandler');
		if ($MiniComponents->template_touch) {
			$this->template_touchable = false;
			return;
		}

		$plugin = "migs";
		$tmpBookingHandler = jomres_getSingleton('jomres_temp_booking_handler');
		$tmpdata = $tmpBookingHandler->tmpbooking;
		$bookingDeets = gettempBookingdata();
		global $property_uid, $jomressession, $tmpBookingHandler, $contract_uid;
		$query = "SELECT setting,value FROM #__jomres_pluginsettings WHERE plugin LIKE '$plugin' ";
		$settingsList = doSelectSql($query);
		foreach ($settingsList as $set) {
			$settingArray[$set->setting] = $set->value;
		}
		$query = "SELECT setting,value FROM #__jomres_pluginsettings WHERE prid LIKE '" . $property_uid . "' AND plugin LIKE '$plugin' ";
		$settingsList = doSelectSql($query);
		foreach ($settingsList as $set) {
			$settingArray[$set->setting] = $set->value;
		}
// start reciving payment
// stop reciving payment
//echo $settingArray['secure'];

        $conn = new VPCPaymentConnection();
		$conn->setSecuresecret($settingArray['secure']);

		foreach ($_POST as $key => $value) {
			if (($key != "vpc_SecureHash") && ($key != "vpc_SecureHashType") && (substr($key, 0, 4) == 'vpc_')) {
                $conn->addDigitalOrderField($key, $value);
            }
        }

        $serverSecureHash = array_key_exists("vpc_SecureHash", $_POST) ? $_POST["vpc_SecureHash"] : "";
        $secureHash = $conn->hashAllFields();

		/*echo "hash=".$hash;echo "<br />";
		  echo "StrHash=".strtoupper(hash_hmac('SHA256', $hashData, pack('H*', $hashSecret)));echo "<br />";
		  echo $hashData;
		  die();*/
		if ($_REQUEST['vpc_AcqResponseCode'] == "00" && $serverSecureHash == $secureHash) {
			gateway_log("Payment passed for " . $jomressession);
			echo "<h3>" . jr_gettext('_JOMRES_COM_A_MIGS_SUCCESSFUL' . $plugin, 'Booking successful') . ".</h3>";
			$beforebook = date("Y-m-d H:i");
			$tmpBookingHandler->updateBookingField('depositpaidsuccessfully',true);
			$result = insertInternetBooking($jomressession, $paymentSuccessful = true, $confirmationPageRequired = true, $customTextForConfirmationForm = "", $usejomressessionasCartid = false);
			$afterbook = date("Y-m-d H:i");
			$SQL = "SELECT * FROM #__jomres_contracts WHERE property_uid='{$tmpdata['property_uid']}' AND rooms_tariffs='{$tmpdata['requestedRoom']}' AND arrival='{$tmpdata['arrivalDate']}' AND departure='{$tmpdata['departureDate']}'";
			$contract = doSelectSql($SQL);
			if ($result) {

				gateway_log("Booking insert passed for " . $jomressession);
				$contract_uid = intval($contract[0]->contract_uid);
				if ($contract_uid > 0) {
					$propertyid = $bookingDeets['property_uid'];

					$requestedRoom = $bookingDeets['requestedRoom'];


					$dt = date("Y-m-d H-i-s");
					$query = "INSERT INTO #__jomcomp_notes (`contract_uid`,`note`,`timestamp`,`property_uid`) VALUES ('" . (int) $contract[0]->contract_uid . "','Maybankard refference No : {$_REQUEST[ReferenceNo]}<br />Card Number: {$_REQUEST['PaddedCardNo']}<br /> Responce code: {$_REQUEST['ResponseCode']}-{$_REQUEST['ReasonCodeDesc']}<br /> Authorization Code: {$_REQUEST['AuthCode']}<br />Card holder Name: {$tmpdata[$chname]}','$dt','" . (int) $property_uid . "')";
					doInsertSql($query, "");
					$tmpBookingHandler->resetTempBookingData();
				}
			}
			else
				gateway_log("Booking insert failed for " . $jomressession);
		}
		else {
			if (defined('_JOMRES_COM_A_MIGS_CANCELLED'))
				echo "<h3>" . _JOMRES_COM_A_MIGS_CANCELLED . "</h3>";
			else
				echo "<h3>Booking Cancelled</h3>";
		}
	}

	function getRetVals()
	{
		return null;
	}

}


?>
