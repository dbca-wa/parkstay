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
// ################################################################
if (defined('JPATH_BASE'))
	defined('_JEXEC') or die('Direct Access to this location is not allowed.');
else
	defined( '_VALID_MOS') or die('Direct Access to this location is not allowed.');

// ################################################################
//

require('VPCPaymentConnection.php');

class j00605migs
{

	function j00605migs($componentArgs)
	{
		global $jomressession, $jomresConfig_live_site, $jomresConfig_absolute_path, $itemId, $jrConfig, $ePointFilepath, $mrConfig;
		global $eLiveSite, $jomresConfig_live_site, $mosConfig_absolute_path, $mosConfig_lang;

		if (!function_exists('jomres_getSingleton'))
			global $MiniComponents;
		else
			$MiniComponents = jomres_getSingleton('mcHandler');
		if ($MiniComponents->template_touch) {
			$this->template_touchable = false;
			return;
		}

		$plugin = "migs";

		$path = dirname(realpath(__FILE__));


		$bookingdata = $componentArgs['bookingdata'];

		$guestdata = $componentArgs['guestdata'];
		$property_uid = $componentArgs['property_uid'];
		$tmpBookingHandler = jomres_getSingleton('jomres_temp_booking_handler');
		$tmpdata = $tmpBookingHandler->tmpbooking;
		$query = "SELECT setting,value FROM #__jomres_pluginsettings WHERE prid LIKE '" . $bookingdata['property_uid'] . "' AND plugin LIKE '$plugin' ";

		$settingsList = doSelectSql($query);
		foreach ($settingsList as $set) {
			$settingArray[$set->setting] = $set->value;
		}
		if ($settingArray['usefax']) {
			$fax = $tmpdata[$settingArray['faxfieldname']];
		} else {
			$fax = time();
		}
		$chname = $settingArray['chfield'];
		$bookingDeets = gettempBookingdata();

		$deposit_required = $bookingdata['deposit_required'];
//		$deposit_required=1;
		global $tmpBookingHandler;
		$amount = $deposit_required;
// start sending payment
		$total = round($deposit_required, 2) * 100;
		//print_r($total);die();
		$amount = $total;
		$oid = time();
//	$returl=JURI::base()."index.php?option=com_jomres&page=completebk&jsid=$jomressession&plugin=$plugin";
		$returl = JURI::base() . "jomres/remote_plugins/jomres_gateway_migs/notify.php";
		$params = array("Title" => "PHP VPC 3-Party", "vpc_Version" => "1", "vpc_Command" => "pay", "vpc_AccessCode" => $settingArray['accesscode'], "vpc_MerchTxnRef" => $fax, "vpc_Merchant" => $settingArray['merchantid'], "vpc_OrderInfo" => $oid, "vpc_Amount" => $total, "vpc_Locale" => $settingArray['locale'], "vpc_ReturnURL" => $returl, "vpc_TicketNo" => $oid);
		ksort($params);

        $title = $params["Title"];
        unset($params["Title"]);
        
        $conn = new VPCPaymentConnection();
        $conn->setSecureSecret($settingArray['secure']);

		$vpcURL = $settingArray['returl'];
        
        foreach($params as $key => $value) {
            if (strlen($value) > 0) {
                $conn->addDigitalOrderField($key, $value);
            }
        }

        $secureHash = $conn->hashAllFields();
        $conn->addDigitalOrderField("Title", $title);
        $conn->addDigitalOrderField("vpc_SecureHash", $secureHash);
        $conn->addDigitalOrderField("vpc_SecureHashType", "SHA256");

        $vpcURL = $conn->getDigitalOrder($vpcURL);

		//$vpcURL.="&SessionVariable1=1234";
		//echo $vpcURL;die();
		header("Location: " . $vpcURL);
// stop sending	payment
	}

	// This must be included in every Event/Mini-component
	function getRetVals()
	{
		return null;
	}

}


?>
