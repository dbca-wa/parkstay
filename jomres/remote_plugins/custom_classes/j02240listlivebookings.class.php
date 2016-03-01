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
 * Constructs and displays all bookings
#
 *
 * @package Jomres
#
 */
class j02240listlivebookings
	{
	/**
	#
	 * Constructor: Constructs and displays all bookings
	#
	 */
	function j02240listlivebookings()
		{
		// Must be in all minicomponents. Minicomponents with templates that can contain editable text should run $this->template_touch() else just return
		$MiniComponents = jomres_singleton_abstract::getInstance( 'mcHandler' );
		if ( $MiniComponents->template_touch )
			{
			$this->template_touchable = true;

			return;
			}
//$arrivalDates=date("Y/m/d");
	//	$arrivalDates = jomresGetParam( $_REQUEST, 'arrivalDates', '' );


    if ( $arrivalDates == '%' ) unset( $arrivalDates );
		$defaultProperty = getDefaultProperty();
		if ( isset( $arrivalDates ) && !empty( $arrivalDates ) )
			{
// $arrivalDates = date("Y/m/d");
//print_r($arrivalDates);
/*			 $query = "SELECT c.contract_uid,c.tag, c.arrival, c.departure,c.booked_in
                        FROM #__jomres_contracts c
                        WHERE c.property_uid = '" . (int) $defaultProperty . "' AND c.arrival >= '". $arrivalDates ."'  AND c.cancelled = 0 AND c.bookedout = 0 ORDER BY c.arrival";
*/

			$query = "SELECT c.contract_uid,c.tag, c.arrival, c.departure,c.booked_in,c.contract_total,c.rate_rules,c.rooms_tariffs, c.contract_total, c.deposit_paid, c.deposit_required, g.guests_uid, g.firstname, g.surname, g.contracts_contract_uid, g.mos_userid,g.tel_mobile,g.tel_landline,g.email,g.car_regno,g.property_uid
			FROM #__jomres_contracts c, #__jomres_guests g
WHERE (c.guest_uid = g.guests_uid)  AND  c.property_uid = '" . (int) $defaultProperty . "'  AND c.departure >= '". $arrivalDates ."'AND c.cancelled = 0 AND c.bookedout = 0  ORDER BY c.arrival";
			}
		else
        {
            $arrivalDates = date("Y/m/d");
			$query = "SELECT c.contract_uid,c.tag, c.arrival, c.departure,c.booked_in,c.contract_total,c.rate_rules,c.rooms_tariffs, c.contract_total, c.deposit_paid, c.deposit_required, g.guests_uid, g.firstname, g.surname, g.contracts_contract_uid, g.mos_userid,g.tel_mobile,g.tel_landline,g.email,g.car_regno,g.property_uid
			FROM #__jomres_contracts c, #__jomres_guests g
			WHERE (c.guest_uid = g.guests_uid) AND c.property_uid = '" . (int) $defaultProperty . "' AND c.departure >= '". $arrivalDates ."' AND c.cancelled = 0 AND c.bookedout = 0
			ORDER BY c.arrival";
			}

	$contractsList = doSelectSql( $query );
//if(count($contractsList) == 0) {
  $query = "SELECT c.contract_uid,c.tag, c.arrival, c.departure,c.booked_in,c.contract_total,c.rate_rules,c.rooms_tariffs
                        FROM #__jomres_contracts c
                        WHERE c.guest_uid = '0' AND c.property_uid = '" . (int) $defaultProperty . "' AND c.departure >= '". $arrivalDates ."'  AND c.cancelled = 0 AND c.bookedout = 0 ORDER BY c.arrival";

 $contractsList1 = doSelectSql( $query );
//}


 $contractsList = array_merge($contractsList,$contractsList1);

		$dates = array ();
		if ( count( $contractsList ) > 0 )
			{
			foreach ( $contractsList as $contract )
				{
				$arrivalDateArray[ ] = $contract->arrival;
				}
			if ( !empty( $arrivalDateArray ) )
				{
				$dates = array_unique( $arrivalDateArray );
				asort( $dates );
				}

            }

        $contractsList[0]->property_name=getPropertyName($defaultProperty);

        for ($i=0, $n=count( $contractsList ); $i < $n; $i++)
        {
            $variances=$contractsList[$i]->rate_rules;
            $rooms_tariffs=$contractsList[$i]->rooms_tariffs;

            $varianceArray=explode(",",$variances);
  //          print_r($varianceArray);

           $query =    "SELECT note FROM #__jomcomp_notes where contract_uid= '".$contractsList[$i]->contract_uid."' and `timestamp` in  (select MAX(`timestamp`) )  and (note like '%Migrated%' or note like '%booking%' or note like '%simple%') ";
            $last_note = doSelectSql($query);
            $note = "note";
//            print_r($last_note);
            $contractsList[$i]->$note = $last_note[0]->note;


            foreach ($varianceArray as $v)
            {
                $vDeets=explode("_",$v);
//print_r($vDeets);
                if ($vDeets[0]=="guesttype")
                {

                                $vu=$vDeets[1];
                                    $vq=$vDeets[2];
                                    $vv=$vDeets[3];
                                        $query="SELECT `type` FROM #__jomres_customertypes where id = '".(int)$vu."' ";
                                        $vtitle=doSelectSql($query,1);
                                            if($vtitle == "Child (6-15 years)") {
                                                        $vtitle = "Child";
                                            }
                                            if($vtitle == "Adult (16 years and older)")
                                                $vtitle = "Adult";
                                             if($vtitle == "Concession card holder")
                                                $vtitle = "Concession";
                                        $contractsList[$i]->$vtitle = $vq;
                                             // print_r($contractsList);
                                                // $contractsList[$i]->'value'=$vv;
                  }
             }
            $room_and_tariff_info = explode(",",$rooms_tariffs);
//            print_r($room_and_tariff_info);
                           foreach ($room_and_tariff_info as $e)
                                {
                                    $tariff_sitenumber = "";
                                                     $rt=explode("^",$e);
                                                        $room=$rt[0];
                                                     //  $tariff=$rt[1];
                                                      $tariff_number=$query="SELECT room_number FROM #__jomres_rooms WHERE room_uid = ".$room;
                                                      $tariff_sitenumber=doSelectSql($query,1);
                                                    if($tariff_sitenumber == ''){
                                                       $tariff_number=$query="SELECT room_name FROM #__jomres_rooms WHERE room_uid = ".$room;
                                                        $tariff_sitenumber=doSelectSql($query,1);
                                                    }
                                              //  $tariffsInfo[$room]=$tariff_name;

                                    if(empty($tariff_sitenumber) || $tariff_sitenumber == ""){
                                        $query = "SELECT r.room_uid
                                        FROM #__jomres_room_bookings r
                                                    WHERE r.contract_uid = '" . (int) $contractsList[$i]->contract_uid . "'";

                                        $contractRoomResults = doSelectSql( $query );

                                        foreach($contractRoomResults as $contractRoom){
                                            $contractRooms[$contractRoom->room_uid] = $contractRoom->room_uid;
                                        }

                                        $roomKey = 0;
                                        $tariff_sitenumber = "";
                                        foreach($contractRooms as $contractRoom){
                                            $roomKey++;
                                            $query = "SELECT r.room_number
                                            FROM #__jomres_rooms r
                                                        WHERE r.room_uid = '" . (int) $contractRoom . "' LIMIT 1";

                                            $roomUID = doSelectSql( $query );

                                            if($roomKey > 1)
                                            {
                                                $tariff_sitenumber .= ", ".$roomUID[0]->room_number;
                                            }
                                            else{
                                                $tariff_sitenumber = $roomUID[0]->room_number;
                                            }
                                        }
                                        unset($contractRooms);
                                    }
                                               if($contractsList[$i]->room == "")
                                                 {
                                                     $contractsList[$i]->room = $tariff_sitenumber;
                                                    }
                                             else {
                                                 $contractsList[$i]->room = $contractsList[$i]->room . ",<br>"  .$tariff_sitenumber;
                                               }
                                            }
                }
//print_r($contractsList);

		$arrivaldateDropdown = filterForm( 'arrivalDates', $dates, "date", "listLiveBookings" );
		showLiveBookings( $contractsList, jr_gettext( '_JOMRES_COM_MR_EDITBOOKING_ADMIN_TITLE', _JOMRES_COM_MR_EDITBOOKING_ADMIN_TITLE, false ), $arrivaldateDropdown );
		}

	function touch_template_language()
		{
		$output = array ();

		$output[ ] = jr_gettext( '_JOMRES_COM_MR_EDITBOOKING_ADMIN_TITLE', _JOMRES_COM_MR_EDITBOOKING_ADMIN_TITLE );

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
