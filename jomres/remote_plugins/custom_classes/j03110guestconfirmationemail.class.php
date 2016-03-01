<?php
/**
 * Core file
 *
 * @author Vince Wooll <sales@jomres.net>
 * @version Jomres 7
 * @package Jomres
 * @copyright    2005-2013 Vince Wooll
 * Jomres (tm) PHP, CSS & Javascript files are released under both MIT and GPL2 licenses. This means that you can choose the license that best suits your project, and use it accordingly.
 **/


// ################################################################
defined( '_JOMRES_INITCHECK' ) or die( '' );
// ################################################################

/**
#
 * Sends the guest's confirmation email
#
 *
 * @package Jomres
#
 */
class j03110guestconfirmationemail
	{

	/**
	#
	 * Constructor: Sends the guest's confirmation email
	#
	 */
	function j03110guestconfirmationemail( $componentArgs )
		{
		// Must be in all minicomponents. Minicomponents with templates that can contain editable text should run $this->template_touch() else just return
		$MiniComponents = jomres_singleton_abstract::getInstance( 'mcHandler' );
		if ( $MiniComponents->template_touch )
			{
			$this->template_touchable = true;

			return;
			}
            
           
		$output              = array ();
		$tmpBookingHandler   = jomres_singleton_abstract::getInstance( 'jomres_temp_booking_handler' );
		$mrConfig            = getPropertySpecificSettings();
		$currfmt             = jomres_singleton_abstract::getInstance( 'jomres_currency_format' );
		$tempBookingDataList = $componentArgs[ 'tempBookingDataList' ];
		$cartnumber          = $componentArgs[ 'cartnumber' ];
		$guestDetails        = $componentArgs[ 'guestDetails' ];
		$guests_uid          = $componentArgs[ 'guests_uid' ];
		$property_uid        = (int) $componentArgs[ 'property_uid' ];
		$arrivalDate         = $componentArgs[ 'arrivalDate' ];
		$departureDate       = $componentArgs[ 'departureDate' ];
		$contract_total      = $componentArgs[ 'contract_total' ];
		$rates_uids          = $componentArgs[ 'rates_uids' ];
		$specialReqs         = $componentArgs[ 'specialReqs' ];
		$deposit_required    = $componentArgs[ 'deposit_required' ];
		if ( !isset( $componentArgs[ 'email_when_done' ] ) ) $email_when_done = true;
		else
		$email_when_done = $componentArgs[ 'email_when_done' ]; // Optional. We'll set email_when_done by default to true, otherwise we'll set it in the componentArgs variable. This allows us to call this script independantly which in turn allows us to view the email as it's contructed, rather than when sent.

		$clientIP = $_SERVER[ 'REMOTE_ADDR' ];

		$rmids         = array ();
		$requestedRoom = $tempBookingDataList[ 0 ]->requestedRoom;

		$rooms = explode( ",", $requestedRoom );
		foreach ( $rooms as $r )
			{
			$rm       = explode( "^", $r );
			$rmids[ ] = $rm[ 0 ];
			}
		$gor        = genericOr( $rmids, 'room_uid' );
		$query      = "SELECT propertys_uid,room_number,room_name,room_features_uid FROM #__jomres_rooms WHERE $gor ";
		$roomList   = doSelectSql( $query );
		$roomNumber = "";
		$room_name  = "";
		$counter    = 0;
		// Nitin Start
		$room_class="";
		// End

	$query      = "SELECT room_features_uid,feature_description FROM #__jomres_room_features";
		$featureList   = doSelectSql( $query );
		foreach ( $featureList as $featurel )
			{
				$featurearr[$featurel->room_features_uid] = $featurel->feature_description;
			}


		foreach ( $roomList as $room )
			{
			if($room->room_features_uid > 0)
				if ($feature == "")
					$feature = $featurearr[$room->room_features_uid] ;
				else
					$feature .= ","  . $featurearr[$room->room_features_uid] ;

			$property = $room->propertys_uid;
			$roomNumber .= $room->room_number.", ";
			$room_name .= $room->room_name;
			// Nitin Start
			$room_class.=$room->room_classes_uid;
			// End

	/*if($room->room_features_uid > 0)
		if ($feature == "")
			$feature = $featurearr[$room->room_features_uid] ;
		else
			$feature .= ","  . $featurearr[$room->room_features_uid] ;

			$property = $room->propertys_uid;
			$roomNumber .= $room->room_number;
			$room_class.=$room->room_classes_uid;
			// End
			if ( $room->room_name != "" ) $room_name .= $room->room_name;
			if ( $counter < count( $roomList ) )
				{
				$roomNumber .= ",";
				if ( $room->room_name != "" ) $room_name .= ",";
				}*/
			}

	// Nitin Start
			$queryclass			=	"SELECT * from  #__jomres_room_classes where room_classes_uid = '".$room_class."' LIMIT 1";
			$room_classname="";
				$roomclassnam		=	doSelectSql($queryclass);
	// End

		$propertyID = $componentArgs[ 'property_uid' ];

		$query         = "SELECT property_name,property_town,property_description,property_checkin_times,property_tel,property_email,property_airports,property_othertransport,property_policies_disclaimers,property_booking_configuration FROM #__jomres_propertys WHERE propertys_uid = '" . $componentArgs[ 'property_uid' ] . "' LIMIT 1";
		$propertyEmail = doSelectSql( $query );

		foreach ( $propertyEmail as $email )
			{
			$propertyName                    = $email->property_name;
			$propertyTown                    = $email->property_town;
			$propertyTel                     = stripslashes( $email->property_tel );
			$hotelemail                      = stripslashes( $email->property_email );
            $description                     = $email->property_description;
            $airports                        = $email->property_airports;
            $otherTransport                        = $email->property_othertransport;
            $checkin                        = $email->property_checkin_times;
			$siteType                        = $email->property_booking_configuration;
			$output[ 'POLICIESDISCLAIMERS' ] = jr_gettext( '_JOMRES_CUSTOMTEXT_ROOMTYPE_DISCLAIMERS', trim( stripslashes( $email->property_policies_disclaimers ) ), false, false );
			}

		$output[ 'HPOLICIESDISCLAIMERS' ] = jr_gettext( '_JOMRES_COM_MR_VRCT_PROPERTY_HEADER_POLICIESDISCLAIMERS', _JOMRES_COM_MR_VRCT_PROPERTY_HEADER_POLICIESDISCLAIMERS );

		$query         = "SELECT firstname,surname,email,tel_landline,tel_mobile FROM #__jomres_guests WHERE guests_uid = '" . (int) $guests_uid . "'";
		$guestNameList = doSelectSql( $query );
		foreach ( $guestNameList as $guestName )
			{
			$firstname = stripslashes( $guestName->firstname );
			$surname   = stripslashes( $guestName->surname );
			$landline  = stripslashes( $guestName->tel_landline );
			$mobile    = stripslashes( $guestName->tel_mobile );
			$guestEmail    = stripslashes( $guestName->email );
			}
		$rateOutput = "";
		$currency   = urldecode( $mrConfig[ 'currencyCode' ] );
		foreach ( $rates_uids as $rates_uid )
			{
			$query     = "SELECT rates_uid,rate_title,rate_description,roomrateperday FROM #__jomres_rates WHERE rates_uid = '" . (int) $rates_uid . "'";
			$ratesList = doSelectSql( $query );
			foreach ( $ratesList as $rate )
				{
				if ( $mrConfig[ 'tariffmode' ] == "2" )
					{
					$query          = "SELECT tarifftype_id FROM #__jomcomp_tarifftype_rate_xref WHERE tariff_id = '" . (int) $rate->rates_uid . "' LIMIT 1";
					$tariff_type_id = doSelectSql( $query, 1 );
					$rTitle         = jr_gettext( '_JOMRES_CUSTOMTEXT_TARIFF_TITLE_TARIFFTYPE_ID' . $tariff_type_id, $rate->rate_title, false, false );
					}
				else
				$rTitle = jr_gettext( '_JOMRES_CUSTOMTEXT_TARIFF_TITLE' . (int) $rate->rates_uid, $rate->rate_title, false, false );
				$rDesc = jr_gettext( '_JOMRES_CUSTOMTEXT_TARIFFDESC' . (int) $rate->rates_uid, $rate->rate_description, false, false );
				$rRate = $currfmt->get_formatted( $rate->roomrateperday );
				$rateOutput .= $rTitle . ' ' . $rDesc . ' ' . $rRate . ' ';
				}
			}

		$bookingDeets     = gettempBookingdata();
		$extras           = $bookingDeets[ 'extras' ];
		$extrasquantities = $bookingDeets[ 'extrasquantities' ];
		$extrasArray      = explode( ",", $extras );
		if ( count( $extrasArray ) > 0 )
			{
			foreach ( $extrasArray as $extraAll )
				{
				if ( !empty( $extraAll ) )
					{
					$extra = $extraAll;

					$query     = "SELECT price, name FROM #__jomres_extras WHERE uid = '$extra'";
					$thisPrice = doSelectSql( $query, 2 );

					$extra_parts[ 'NAME' ] = jr_gettext( '_JOMRES_CUSTOMTEXT_EXTRANAME' . $ex->uid, htmlspecialchars( trim( stripslashes( $thisPrice[ 'name' ] ) ), ENT_QUOTES ) ) . " X " . $extrasquantities[ $extra ];
					$booking_extras[ ]     = $extra_parts;
					}
				}
			$extratext                       = array ();
			$extra_text[ 'AJAXFORM_EXTRAS' ] = jr_gettext( '_JOMRES_AJAXFORM_EXTRAS', _JOMRES_AJAXFORM_EXTRAS );
			$extra_text[ 'EXTRASTOTAL' ]     = output_price( $bookingDeets[ 'extrasvalue' ] );
			$extra_text[ 'HEXTRASTOTAL' ]    = jr_gettext( '_JOMRES_AJAXFORM_EXTRAS_TOTAL', _JOMRES_AJAXFORM_EXTRAS_TOTAL );
			$extrastext[ ]                   = $extra_text;
			}

		//$subject = jr_gettext( '_JOMRES_FRONT_GUEST_EMAIL_TEXT_THANKS', _JOMRES_FRONT_GUEST_EMAIL_TEXT_THANKS, false, false ) . " " . stripslashes( $propertyName ) . " " . $cartnumber;
		$subject = "Your booking for " . stripslashes( $propertyName ) . ", " . stripslashes( $propertyTown ) . ", Number " . $cartnumber ."";
		$output['SUBJECT'] = $subject;

		$output['CAMPGROUND'] = $propertyName;
		$output['PARK'] = $propertyTown;

		//$fileLocation=checkForImage('property',$property_uid);

		if ( strlen( $specialReqs ) > 0 )
			{
			$output[ 'HSPECIAL_REQUIREMENTS' ] = jr_gettext( '_JOMRES_COM_MR_EB_ROOM_BOOKINGSPECIALREQ', _JOMRES_COM_MR_EB_ROOM_BOOKINGSPECIALREQ, false, false );
			$output[ 'SPECIAL_REQUIREMENTS' ]  = getEscaped( $specialReqs );
			}


		$output[ 'MOSCONFIGLIVESITE' ] = get_showtime( 'live_site' );

		$output[ 'LINK' ]           = JOMRES_SITEPAGE_URL_NOSEF . "&task=viewproperty&property_uid=" . $property_uid;
		$output[ 'LINKTOPROPERTY' ] = "<a style=\"color: blue;\" href=\"" . JOMRES_SITEPAGE_URL_NOSEF . "&task=viewproperty&property_uid=" . $property_uid . "\">" . jr_gettext( '_JOMRES_COM_MR_VRCT_PROPERTY_HEADER_WEBSITE', _JOMRES_COM_MR_VRCT_PROPERTY_HEADER_WEBSITE, false, false ) . "</a>";
		if ( $mrConfig[ 'singleRoomProperty' ] != "1" )
			{
			$output[ 'HROOM' ] = jr_gettext( '_JOMRES_FRONT_MR_EMAIL_TEXT_ROOM', _JOMRES_FRONT_MR_EMAIL_TEXT_ROOM, false, false );
		//	$output[ 'ROOM' ]  = $roomNumber . " " . $room_name;

		if(isset($siteType) && $siteType == 'site_type'){
			$output[ 'ROOM' ] = "Allocated on arrival/Choose from sites unoccupied on arrival";
		}
		elseif(isset($siteType) && $siteType == 'numbered_site'){
			$output[ 'ROOM' ]  = $roomNumber . " " . $room_name;
		}
		else{
			$output[ 'ROOM' ]  = $roomNumber . " " . $room_name;
		}

		/*if ( $propertyID == 54 || $propertyID == 56 )
				{
					$output[ 'ROOM' ]  = "Allocated on arrival " . $room_name ."<br /> <strong>Site type:</strong>" . $feature;
				}
				else
					if(!empty($feature))
					$output[ 'ROOM' ]  = $roomNumber . " " . $room_name . "<br /> <strong>Site type:</strong>" . $feature;
					else
					$output[ 'ROOM' ]  = $roomNumber . " " . $room_name;
		*/
			}

		$output[ 'THANKS' ]    = "Thank you for booking. Please check all details carefully and retain a copy of this email for presentation at any time during your stay.";
		$output[ 'HELLO' ]     = jr_gettext( '_JOMRES_FRONT_GUEST_EMAIL_TEXT_HELLO', _JOMRES_FRONT_GUEST_EMAIL_TEXT_HELLO, false, false );
		$output[ 'GUESTNAME' ] = stripslashes( $firstname ) . " " . stripslashes( $surname );
		$output[ 'QUESTIONS' ] = jr_gettext( '_JOMRES_FRONT_GUEST_EMAIL_TEXT_ANYQUESTIONS', _JOMRES_FRONT_GUEST_EMAIL_TEXT_ANYQUESTIONS, false, false );
		$output[ 'TELEPHONE' ] = "or by phone " . $propertyTel;
		$output[ 'EMAIL' ]     = "<a style=\"color: blue;\" href=\"mailto:$hotelemail?subject=" . jr_gettext( '_JOMRES_BOOKING_NUMBER', _JOMRES_BOOKING_NUMBER, false, false ) . " " . $cartnumber . " \">" . $hotelemail . "</a>";
		$output[ 'SUMMARY' ]   = jr_gettext( '_JOMRES_FRONT_GUEST_EMAIL_TEXT_SUMMARY', _JOMRES_FRONT_GUEST_EMAIL_TEXT_SUMMARY, false, false );

		$output[ 'HBOOKINGNO' ] = jr_gettext( '_JOMRES_BOOKING_NUMBER', _JOMRES_BOOKING_NUMBER, false, false );
		$output[ 'BOOKINGNO' ]  = $cartnumber;
		$output[ 'HARRIVAL' ]   = jr_gettext( '_JOMRES_FRONT_MR_EMAIL_TEXT_ARRIVAL', _JOMRES_FRONT_MR_EMAIL_TEXT_ARRIVAL, false, false );
		$output[ 'ARRIVAL' ]    = outputDate( $arrivalDate );
		if ( $mrConfig[ 'showdepartureinput' ] == "1" )
			{
			$output[ 'HDEPARTURE' ] = jr_gettext( '_JOMRES_FRONT_MR_EMAIL_TEXT_DEPARTURE', _JOMRES_FRONT_MR_EMAIL_TEXT_DEPARTURE, false, false );
			$output[ 'DEPARTURE' ]  = outputDate( $departureDate );
			}
		$output[ 'HNAME' ]        = jr_gettext( '_JOMRES_FRONT_GUEST_EMAIL_TEXT_HELLO', _JOMRES_FRONT_GUEST_EMAIL_TEXT_HELLO, false, false );
		$output[ 'FIRSTNAME' ]    = stripslashes( $firstname );
		$output[ 'SURNAME' ]      = stripslashes( $surname );

		$output[ 'GUESTEMAIL' ]      = stripslashes( $guestEmail );
		$output[ 'LANDLINE' ]      = stripslashes( $landline );
		$output[ 'MOBILE' ]      = stripslashes( $mobile );

		$output[ 'HTOTAL' ]       = jr_gettext( '_JOMRES_FRONT_MR_EMAIL_TEXT_TOTAL', _JOMRES_FRONT_MR_EMAIL_TEXT_TOTAL, false, false );
		$output[ 'TOTAL' ]        = output_price( $contract_total );
		$output[ 'HTARIFFTITLE' ] = jr_gettext( '_JOMRES_FRONT_TARIFFS_TITLE', _JOMRES_FRONT_TARIFFS_TITLE, false, false );
		$output[ 'TARIFFINFO' ]   = $rateOutput;

		$output[ 'HDEPOSIT' ] = jr_gettext( '_JOMRES_COM_MR_EB_PAYM_DEPOSITREQUIRED', _JOMRES_COM_MR_EB_PAYM_DEPOSITREQUIRED );
		$output[ 'DEPOSIT' ]  = output_price( $deposit_required );

		$guestDetails = getGuestDetailsForContract( $componentArgs[ 'contract_uid' ] );
		$rows         = array ();

		if ( count( $guestDetails ) > 0 )
			{
			$output[ 'HNUMBEROFGUESTS' ] = jr_gettext( '_JOMRES_COM_MR_QUICKRES_STEP4_NUMBEROFGUESTS', _JOMRES_COM_MR_QUICKRES_STEP4_NUMBEROFGUESTS, false, false );
			foreach ( $guestDetails as $g )
				{
					if($g[ 'qty' ] == 0){
						continue;
					}

					$r               = array ();
					$r[ 'TITLE' ]    = $g[ 'title' ];
					$r[ 'QUANTITY' ] = $g[ 'qty' ];
					$r[ 'NOTE' ] = "";

					if($g['title'] == "Adult (16 years and older)") {
						$r[ 'TITLE' ] = "Adult (16 years +, no concession card):";
					}
					elseif($g['title'] == "Child (6-15 years)"){
						$r[ 'TITLE' ]    = "Child (6-15 years)";
						$r[ 'NOTE' ]    = "(Children 5 years and under are not included and stay free of charge)";
					}
					elseif($g['title'] == "Concession card holder"){
						$r[ 'TITLE' ]    = "Concession card holders";
						$r[ 'NOTE' ]    = "(Evidence of entitlement must be produced on request)";
					}

					$rows[ ]         = $r;
				}
			}

		$invoice_id = $MiniComponents->miniComponentData[ '03025' ][ 'insertbooking_invoice' ][ 'invoice_id' ];
		if ( (int) $invoice_id > 0 )
			{
			$invoice_template    = $MiniComponents->specificEvent( '06005', 'view_invoice', array ( 'internal_call' => true, 'invoice_id' => $invoice_id ) );
			$output[ 'INVOICE' ] = $invoice_template;
			}

		$query         = "SELECT contract_id, paid FROM #__jomresportal_invoices WHERE id = '" . $invoice_id . "' LIMIT 1";
		$invoiceData = doSelectSql( $query );

		foreach ( $invoiceData as $invoice ) {
			$output['INVOICE_NUM'] = $invoice_id;
			$output['CONTRACT'] = $invoice->contract_id;
			$output['PAID'] = $invoice->paid;
		}

		$output['CONTRACT_TOTAL'] = $contract_total;

        $output[ 'PROPERTY_DESCRIPTION' ] = $description;
        $output[ 'PROPERTY_AIRPORTS' ] = $airports;
        $output[ 'OTHER_TRANSPORT' ] = $otherTransport;
        $output[ 'CHECKIN' ] = $checkin;

		/*** Adding campsite details from booking confirmation ***/
		$roomadd = 0; $i =1;$j=1;
		$prevroomclass = 0;
		$fulldesc = "";

		$room_info = array ();
		foreach ( $roomList as $room )
		{
			$roomtype = array ();

			if($room->room_features_uid > 0)
				if ($feature == "")
					$feature = $featurearr[$room->room_features_uid] ;
				else
					$feature .= ","  . $featurearr[$room->room_features_uid] ;


			if ( $roomNumber == "" ) $roomNumber = $room->room_number;
			else
			$roomNumber .= ', ' . $room->room_number;
			$room_name        = $room->room_name;
			$room_classes_uid = $room->room_classes_uid;


			/*if ( $propertyID == 54 || $propertyID == 56 )
			{
				$room_info[ ] = array ( "ROOM_NAME" => $room_name, "ROOM_NUMBER" => "Not applicable", "ROOM_FEATURE" => $feature  , "HROOM_NAME" => jr_gettext( "_JOMRES_COM_MR_EB_ROOM_NAME" ), "HROOM_NUMBER" => jr_gettext( "_JOMRES_COM_MR_EB_ROOM_NUMBER" ) );
			}*/
			if ( isset($siteType) && $siteType == 'site_type' )
			{
				$room_info[ ] = array ( "ROOM_NAME" => $room_name, "ROOM_NUMBER" => "Not applicable", "ROOM_FEATURE" => $feature  , "HROOM_NAME" => jr_gettext( "_JOMRES_COM_MR_EB_ROOM_NAME" ), "HROOM_NUMBER" => jr_gettext( "_JOMRES_COM_MR_EB_ROOM_NUMBER" ) );
			}
			else
				$room_info[ ] = array ( "ROOM_NAME" => $room_name, "ROOM_NUMBER" => $room->room_number, "HROOM_NAME" => jr_gettext( "_JOMRES_COM_MR_EB_ROOM_NAME" ), "HROOM_NUMBER" => jr_gettext( "_JOMRES_COM_MR_EB_ROOM_NUMBER" ) );

			if ( $room_classes_uid != $prevroomclass )
			{
				if ( $prevroomclass != 0 )
				{
					//output previous room
					//		$roomtype[ 'FULLDESC' ] = $roomadd . " x " . $fulldesc;
					$booking_rooms[ ]       = $roomtype;
					$prevroomclass          = $room_classes_uid;
				}
				else
					$prevroomclass = $room_classes_uid;

				$roomadd   = $roomadd + 1;
				$query     = "SELECT room_class_full_desc FROM #__jomres_room_classes WHERE property_uid = '" . (int) $property_uid . "' and room_classes_uid = '" . (int) $room_classes_uid . "' ";
				$roomclass = doSelectSql( $query );

				if ( count( $roomclass ) > 0 )
				{
					foreach ( $roomclass as $class ) $fulldesc .=  "<br />" . jr_gettext( '_JOMRES_CUSTOMTEXT_ROOMTYPES_DESC' . (int) $room_classes_uid, stripslashes( $class->room_class_full_desc ), false, false );
				}
				else
				{
					$query     = "SELECT room_class_abbv FROM #__jomres_room_classes WHERE property_uid = 0 and room_classes_uid = '$room_classes_uid'";
					$roomclass = doSelectSql( $query );
					if ( count( $roomclass ) > 0 )
					{
						foreach ( $roomclass as $class )
							$fulldesc .= "<br />" . $i . " X " .    jr_gettext( '_JOMRES_CUSTOMTEXT_ROOMTYPES_ABBV' . $room_classes_uid, stripslashes( $class->room_class_abbv ), false, false );
					}
				}
			}
			else
			{
				$roomadd++;
				$query     = "SELECT room_class_abbv FROM #__jomres_room_classes WHERE property_uid = 0 and room_classes_uid = '$room_classes_uid'";
				$roomclass = doSelectSql( $query );
				if ( count( $roomclass ) > 0 )
				{
					foreach ( $roomclass as $class )
						$fulldesc .=  "<br />" . $i . " X " .  jr_gettext( '_JOMRES_CUSTOMTEXT_ROOMTYPES_ABBV' . $room_classes_uid, stripslashes( $class->room_class_abbv ), false, false );
				}

			}
		}
		/*** Adding campsite details from booking confirmation ***/

		$output[ 'FULLDESC' ] = "Total site booked: ". $roomadd  . $fulldesc;

		/*if ( $propertyID == 54 || $propertyID == 56 )
			$output[ 'ROOMNUMBER' ] = "<br /><strong>Site number:</strong> Allocated on arrival " ; //. "<br /> <strong>Site type:</strong>" . $feature;*/
		if ( isset($siteType) && $siteType == 'site_type' )
			$output[ 'ROOMNUMBER' ] = "<br /><strong>Site number:</strong> Allocated on arrival " ; //. "<br /> <strong>Site type:</strong>" . $feature;
		else {
			if (!empty($feature)) {
				$output['ROOMNUMBER'] = "<br /><strong>Site number:</strong>" . $roomNumber; //. "<br /> <strong>Site type:</strong>" . $feature;
			} else {
				$output['ROOMNUMBER'] = "<br /><strong>Site number:</strong>" . $roomNumber;
			}
		}

		$room_name        = "";
		$room_number      = "";
		$room_class_abbvs = array ();
		$query            = "SELECT room_uid FROM #__jomres_room_bookings WHERE contract_uid = '" . (int) $componentArgs[ 'contract_uid' ] . "' AND `date` = '" . (string) $arrivalDate . "'";
		$roomData         = doSelectSql( $query );

		foreach ( $roomData as $room )
		{
			$counter  = 1;

			if($room->room_features_uid > 0)
				if ($feature == "")
					$feature = $featurearr[$room->room_features_uid] ;
				else
					$feature .= ","  . $featurearr[$room->room_features_uid] ;

			$query    = "SELECT propertys_uid,room_name,room_number,room_classes_uid,room_features_uid FROM #__jomres_rooms WHERE room_uid = '" . (int) $room->room_uid . "'";
			$roomData = doSelectSql( $query );
			foreach ( $roomData as $r )
			{
				if($r->room_features_uid > 0) {
					if ($feature == "") {
						$feature = $featurearr[$r->room_features_uid];
					}
					else {
						$feature .= "," . $featurearr[$r->room_features_uid];
					}
				}

				$property = $r->propertys_uid;
				$roomNumber .= $r->room_number;
				$room_name .= $r->room_name;
				// Nitin Start
				$room_class.=$r->room_classes_uid;
				// End

				if ( strlen( $r->room_name ) > 0 ) $room_name .= $r->room_name;
				if ( strlen( $r->room_number ) > 0 ) $room_number .= $r->room_number;
				$room_classes_uid = $r->room_classes_uid;
				if ( $counter < count( $roomData ) )
				{
					if ( strlen( $r->room_number ) > 0 ) $room_number .= ",";
					if ( strlen( $r->room_name ) > 0 ) $room_name .= ",";
				}
				else
				{
					if ( strlen( $r->room_number ) > 0 ) $room_number .= ".";
					if ( strlen( $r->room_name ) > 0 ) $room_name .= ".";
				}
				$query         = "SELECT room_class_abbv FROM #__jomres_room_classes WHERE room_classes_uid = '" . (int) $room_classes_uid . "'";
				$roomClassData = doSelectSql( $query );

				foreach ( $roomClassData as $roomClass )
				{
					$room_class_abbvs[ ] = $roomClass->room_class_abbv . " ";
				}
				$counter++;
			}
		}

		$room_class_abbvs_data = array_count_values( $room_class_abbvs );
		$counter               = 1;
		$room_class_abbv = "";
		foreach ( $room_class_abbvs_data as $key => $val )
		{
			$room_class_abbv .= $key . " x " . $val;
			if ( $counter < count( $room_class_abbvs_data ) ) $room_class_abbv .= ",";
			else
				$room_class_abbv .= ".";
			$counter++;
		}

		$output[ 'ROOMTYPE' ]         = $room_class_abbv;


		$output[ 'ALLOCATION_NOTE' ] = $tmpBookingHandler->tmpbooking[ "booking_notes" ][ "suppliment_note" ];

		$output[ 'CSS_STYLES' ] = mailer_get_css();

		$custom_field_output = array ();
		jr_import( 'jomres_custom_field_handler' );
		$custom_fields   = new jomres_custom_field_handler();
		$allCustomFields = $custom_fields->getAllCustomFields();
		if ( count( $allCustomFields ) > 0 )
			{
			foreach ( $allCustomFields as $f )
				{
				$formfieldname          = $f[ 'fieldname' ] . "_" . $f[ 'uid' ];
				$custom_field_output[ ] = array ( "DESCRIPTION" => jr_gettext( 'JOMRES_CUSTOMTEXT' . $f[ 'uid' ], $f[ 'description' ] ), "VALUE" => $tmpBookingHandler->tmpbooking[ $formfieldname ] );
				}
			}

		$output[ '_JOMRES_PLEASE_PRINT' ]        = jr_gettext( '_JOMRES_PLEASE_PRINT', _JOMRES_PLEASE_PRINT, false, false );
		$output[ '_JOMRES_OFFICE_USE_ONLY' ]     = jr_gettext( '_JOMRES_OFFICE_USE_ONLY', _JOMRES_OFFICE_USE_ONLY, false, false );
		$output[ '_JOMRES_SCAN_FOR_DIRECTIONS' ] = jr_gettext( '_JOMRES_SCAN_FOR_DIRECTIONS', _JOMRES_SCAN_FOR_DIRECTIONS, false, false );

		$url            = JOMRES_SITEPAGE_URL_NOSEF . "&task=editBooking&thisProperty=" . $propertyUid . "&contract_uid=" . $componentArgs[ 'contract_uid' ];
		$qr_code_office = jomres_make_qr_code( $url );
		$url            = make_gmap_url_for_property_uid( $property_uid );
		$qr_code_map    = jomres_make_qr_code( $url );

		$output[ 'OFFICE_QR_CODE_IMAGE' ] = "cid:office_qr_code";
		$output[ 'DIRECTIONS_QR_CODE' ]   = "cid:map_qr_code";
// Nitin Start
$output['CLASSTYPE'] = $roomclassnam[0]->room_class_abbv;
// End

// Nitin Start
         $output['HACTCODE'] = "Activity Code";
                 $output['ACTCODE'] = $tempBookingDataList[0]->fax_1;
                         $output['CLASSTYPE'] = $roomclassnam[0]->room_class_abbv;
/*                                 $pageoutput[]=$output;
                                 // echo $hotelemail;
                                 // print_r($tempBookingDataList);
                                 $today = date("Y-m-d");

                                list($actcode,$brid) = split('/', $output['ACTCODE']);
                                 //$output['ACTCODE'] = $actcode;
                                $date = $arrivalDate;
                                 list($year, $month, $day) = split('[/]', $date);
                                 $date =$year ."-" . $month ."-" . $day;
 */
                                 $description = $propertyName ."-" . $roomNumber ."-" . $room_name ."-" . $cartnumber ."-". $roomclassnam[0]->room_class_abbv;
                                 // split('AUD',$output['TOTAL']);
 
           // End

        $pageoutput[ ] = $output;
		$tmpl          = new patTemplate();
		$tmpl->setRoot( JOMRES_TEMPLATEPATH_FRONTEND );
		$tmpl->readTemplatesFromInput( 'guest_conf_email.html' );
		$tmpl->addRows( 'custom_field_output', $custom_field_output );
		$tmpl->addRows( 'pageoutput', $pageoutput );
		$tmpl->addRows( 'rows', $rows );
		$tmpl->addRows( 'booking_extras', $booking_extras );
		$tmpl->addRows( 'booking_extratext', $extrastext );

		if ( $email_when_done )
			{
			$text = $tmpl->getParsedTemplate();
			jomres_audit( $text, jr_gettext( '_JOMRES_MR_AUDIT_BOOKED_ROOM', _JOMRES_MR_AUDIT_BOOKED_ROOM, false ) );
			$query = "SELECT email FROM #__jomres_guests WHERE guests_uid = '" . (int) $guests_uid . "' LIMIT 1";
			if ( $mrConfig[ 'errorCheckingShowSQL' ] ) echo $query . "<br>";
			$userEmail = doSelectSql( $query );
			foreach ( $userEmail as $email )
				{
				$useremail = stripslashes( $email->email );
				}
			$result = false;

			if ( count( $useremail ) > 0 )
				{

				$office_qr_code = array ( "type" => "image", "image_path" => $qr_code_office[ 'absolute_path' ], "CID" => "office_qr_code" );
				$attachments[ ] = $office_qr_code;

				$map_qr_code    = array ( "type" => "image", "image_path" => $qr_code_map[ 'absolute_path' ], "CID" => "map_qr_code" );
				$attachments[ ] = $map_qr_code;

				// Nitin Start
				//if ( !jomresMailer( $hotelemail, $propertyName, $useremail, $subject, $text, $mode = 1, $attachments ) ) error_logging( 'Failure in sending confirmation email to guest. Target address: ' . $useremail . ' Subject ' . $subject );

				if(!jomresMailer( "campgrounds@dpaw.wa.gov.au", $propertyName, $useremail, $subject, $text,$mode=1))
					error_logging('Failure in sending confirmation email to guest. Target address: '.$useremail.' Subject '.$subject);
				// End
				}
			}
		else
		$tmpl->displayParsedTemplate();

		}

	function touch_template_language()
		{
		$output = array ();

		$output[ ] = jr_gettext( '_JOMRES_FRONT_GUEST_EMAIL_TEXT_THANKS', _JOMRES_FRONT_GUEST_EMAIL_TEXT_THANKS );
		$output[ ] = jr_gettext( '_JOMRES_FRONT_MR_EMAIL_TEXT_ROOM', _JOMRES_FRONT_MR_EMAIL_TEXT_ROOM );
		$output[ ] = jr_gettext( '_JOMRES_FRONT_GUEST_EMAIL_TEXT_HELLO', _JOMRES_FRONT_GUEST_EMAIL_TEXT_HELLO );
		$output[ ] = jr_gettext( '_JOMRES_FRONT_GUEST_EMAIL_TEXT_ANYQUESTIONS', _JOMRES_FRONT_GUEST_EMAIL_TEXT_ANYQUESTIONS );
		$output[ ] = jr_gettext( '_JOMRES_FRONT_GUEST_EMAIL_TEXT_TELEPHONE', _JOMRES_FRONT_GUEST_EMAIL_TEXT_TELEPHONE );
		$output[ ] = jr_gettext( '_JOMRES_FRONT_GUEST_EMAIL_TEXT_EMAIL', _JOMRES_FRONT_GUEST_EMAIL_TEXT_EMAIL );
		$output[ ] = jr_gettext( '_JOMRES_BOOKING_NUMBER', _JOMRES_BOOKING_NUMBER );
		$output[ ] = jr_gettext( '_JOMRES_FRONT_GUEST_EMAIL_TEXT_SUMMARY', _JOMRES_FRONT_GUEST_EMAIL_TEXT_SUMMARY );
		$output[ ] = jr_gettext( '_JOMRES_BOOKING_NUMBER', _JOMRES_BOOKING_NUMBER );
		$output[ ] = jr_gettext( '_JOMRES_FRONT_MR_EMAIL_TEXT_ARRIVAL', _JOMRES_FRONT_MR_EMAIL_TEXT_ARRIVAL );
		$output[ ] = jr_gettext( '_JOMRES_FRONT_MR_EMAIL_TEXT_DEPARTURE', _JOMRES_FRONT_MR_EMAIL_TEXT_DEPARTURE );
		$output[ ] = jr_gettext( '_JOMRES_FRONT_GUEST_EMAIL_TEXT_HELLO', _JOMRES_FRONT_GUEST_EMAIL_TEXT_HELLO );
		$output[ ] = jr_gettext( '_JOMRES_FRONT_MR_EMAIL_TEXT_TOTAL', _JOMRES_FRONT_MR_EMAIL_TEXT_TOTAL );
		$output[ ] = jr_gettext( '_JOMRES_COM_MR_QUICKRES_STEP4_NUMBEROFGUESTS', _JOMRES_COM_MR_QUICKRES_STEP4_NUMBEROFGUESTS );
		$output[ ] = jr_gettext( '_JOMRES_FRONT_TARIFFS_TITLE', _JOMRES_FRONT_TARIFFS_TITLE );

		foreach ( $output as $o )
			{
			echo $o;
			echo "<br/>";
			}
		}

	/**
	#
	 * Must be included in every mini-component
	#
	 * Returns any settings the the mini-component wants to send back to the calling script. In addition to being returned to the calling script they are put into an array in the mcHandler object as eg. $mcHandler->miniComponentData[$ePoint][$eName]
	#
	 */
	// This must be included in every Event/Mini-component
	function getRetVals()
		{
		return null;
		}
	}

?>
