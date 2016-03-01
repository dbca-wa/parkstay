<?php
/**
 * Core file
 * @author Vince Wooll <sales@jomres.net>
 * @version Jomres 4 
* @package Jomres
* @copyright	2005-2010 Vince Wooll
* Jomres (tm) PHP files are released under both MIT and GPL2 licenses. This means that you can choose the license that best suits your project, and use it accordingly, however all images, css and javascript which are copyright Vince Wooll are not GPL licensed and are not freely distributable. 
**/

// ################################################################
defined( '_JOMRES_INITCHECK' ) or die( '' );
// ################################################################

class j06110ajax_search_composite
	{
	function j06110ajax_search_composite()
		{
		$MiniComponents =jomres_getSingleton('mcHandler');
		if ($MiniComponents->template_touch)
			{
			$this->template_touchable=false; return;
			}
		$tmpBookingHandler =jomres_singleton_abstract::getInstance('jomres_temp_booking_handler');
		
		$nearest_matches = array();
		
		$filters = array();
		$property_prefilter = jomresGetParam( $_REQUEST, 'property_prefilter', '' );
		if ($property_prefilter!='' && $property_prefilter!=0)
			{
			$tmp = array();
			$property_uid_bang = explode (",",$property_prefilter);
			foreach ($property_uid_bang as $id)
				{
				if ((int)$id != 0 )
					$tmp[]=(int)$id;
				}
			$filters['property_uids'] = $tmp;
			}
		
		$ptype_prefilter = jomresGetParam( $_REQUEST, 'ptype_prefilter', '' );
		if ($ptype_prefilter!='' && $ptype_prefilter!=0)
			{
			$tmp = array();
			$ptype_prefilter = explode (",",$ptype_prefilter);
			foreach ($ptype_prefilter as $id)
				{
				if ((int)$id != 0 )
					$tmp[]=(int)$id;
				}
			$filters['ptypes'] = $tmp;
			}
		
		$this->get_all_published_properties($filters);
		
		$search_performed = false;
		
		//////////////////////////////////// STARS /////////////////////////////////////////////////////////
		$stars = jomresGetParam( $_REQUEST, 'stars', array() );
		$tmpBookingHandler->tmpsearch_data['ajax_search_composite_selections']['stars']=$stars;
		if( count($stars) > 0 )
			{
			$gor = genericOr($stars,'stars');
			$pgor = genericOr($this->search_results,'propertys_uid');
			$query="SELECT propertys_uid FROM #__jomres_propertys WHERE $gor AND $pgor";
			$result=doSelectSql($query);
			$arr = array();
			if (count($result)>0)
				{
				foreach ($result as $r)
					$arr[]=$r->propertys_uid;
				}
			$this->search_results = $arr;
			if (count($arr)>0)
				$nearest_matches = $arr;
			$search_performed = true;
			}

		//////////////////////////////////// Price ranges /////////////////////////////////////////////////////////
		$pricerange_value_from = (int)jomresGetParam( $_REQUEST, 'pricerange_value_from', 0 );
		$pricerange_value_to = (int)jomresGetParam( $_REQUEST, 'pricerange_value_to', 0 );
		
		$priceranges = jomresGetParam( $_REQUEST, 'priceranges', array() );
		if (count($priceranges)>0)
			{
			$all_ranges = array();
			foreach ($priceranges as $ranges)
				{
				$tmpBookingHandler->tmpsearch_data['ajax_search_composite_selections']['priceranges'][]=$ranges;
				$bang = explode("-",$ranges);
				$all_ranges[]=(int)$bang[0];
				$all_ranges[]=(int)$bang[1];
				}
			$pricerange_value_from = min ($all_ranges);
			$pricerange_value_to =  max ($all_ranges);
			}
		
		$tmpBookingHandler->tmpsearch_data['ajax_search_composite_selections']['pricerange_value_from']=$pricerange_value_from;
		$tmpBookingHandler->tmpsearch_data['ajax_search_composite_selections']['pricerange_value_to']=$pricerange_value_to;
		if ($pricerange_value_to > 0)
			{
			$pgor = genericOr($this->search_results,'propertys_uid');
			
			$query="SELECT property_uid FROM #__jomres_rates,#__jomres_propertys WHERE #__jomres_rates.roomrateperday >= ".$pricerange_value_from." AND #__jomres_rates.roomrateperday <= ".$pricerange_value_to." AND #__jomres_rates.property_uid = #__jomres_propertys.propertys_uid AND $pgor ";
			$result=doSelectSql($query);

			$arr = array();
			if (count($result)>0)
				{
				foreach ($result as $r)
					$arr[]=$r->property_uid;
				
				}

			$query = "SELECT property_key,propertys_uid FROM #__jomres_propertys WHERE published = 1  AND $pgor ORDER by property_key";
			$realestateList = doSelectSql($query);
			if (count($realestateList)>0)
				{
				foreach ($realestateList as $rate)
					{
					if ( (float)$rate->property_key >= $pricerange_value_from && (float)$rate->property_key <= $pricerange_value_to )
						$arr[]=$rate->propertys_uid;
					}
				
				}
			
			$this->search_results=array_unique($arr);
			if (count($arr)>0)
				$nearest_matches = $arr;
			$search_performed = true;
			}

		//////////////////////////////////// FEATURES /////////////////////////////////////////////////////////
		$feature_uids = jomresGetParam( $_REQUEST, 'feature_uids', array() );
		$tmpBookingHandler->tmpsearch_data['ajax_search_composite_selections']['feature_uids']=$feature_uids;
		if( count($feature_uids) > 0 )
			{
			$gor='';
			if (count($arr)>0)
				$gor = " AND ".genericOr($arr,'propertys_uid');

			$st="";
			foreach ($feature_uids as $id)
				{
				$st.="'%,".(int)$id.",%' AND property_features LIKE ";
				}
			$st=substr($st,0,-28);
			$pgor = genericOr($this->search_results,'propertys_uid');
			$query="SELECT propertys_uid FROM #__jomres_propertys WHERE property_features LIKE $st $gor AND $pgor ";
			$result = doSelectSql($query);
			$arr = array();
			if (count($result)>0)
				{
				foreach ($result as $r)
					$arr[]=$r->propertys_uid;
				}
			$this->search_results=array_unique($arr);
			if (count($arr)>0)
				$nearest_matches = $arr;
			$search_performed = true;
			}
		
		//////////////////////////////////// COUNTRIES /////////////////////////////////////////////////////////
		$countries = jomresGetParam( $_REQUEST, 'countries', array() );
		$tmpBookingHandler->tmpsearch_data['ajax_search_composite_selections']['countries']=$countries;
		$real_countries = countryCodesArray();
		$tmp = array();
		foreach ($countries as $country)
			{
			$cc = filter_var($country,FILTER_SANITIZE_SPECIAL_CHARS);
			if (array_key_exists($cc,$real_countries))
				$tmp[]=$cc;
			}
		$countries = $tmp;
		
		if( count($countries) > 0 )
			{
			$gor = genericOr($countries,'property_country',false);
			$pgor = genericOr($this->search_results,'propertys_uid');
			$query="SELECT propertys_uid FROM #__jomres_propertys WHERE $gor AND $pgor";
			$result=doSelectSql($query);
			$arr = array();
			if (count($result)>0)
				{
				foreach ($result as $r)
					$arr[]=$r->propertys_uid;
				}
			$this->search_results = $arr;
			if (count($arr)>0)
				$nearest_matches = $arr;
			$search_performed = true;
			}
		//////////////////////////////////// REGIONS /////////////////////////////////////////////////////////
		$regions = jomresGetParam( $_REQUEST, 'regions', array() );
		$tmpBookingHandler->tmpsearch_data['ajax_search_composite_selections']['regions']=$regions;
		$tmp = array();
		foreach ($regions as $region)
			{
			$cc = jomres_cmsspecific_stringURLSafe($region);
			if (!is_numeric($cc))
				$tmp[]=$cc;
			if (function_exists('find_region_id'))
				{
				$region_id = find_region_id($cc);
				$tmp[]=$region_id;
				}
			else
				$tmp[]=$cc;
			
			}
		$regions = $tmp;
		
		if( count($regions) > 0 )
			{
			$gor = genericOr($regions,'property_region',false);
			$pgor = genericOr($this->search_results,'propertys_uid');
			$query="SELECT propertys_uid FROM #__jomres_propertys WHERE $gor AND $pgor";
			$result=doSelectSql($query);
			$arr = array();
			if (count($result)>0)
				{
				foreach ($result as $r)
					$arr[]=$r->propertys_uid;
				}
			$this->search_results = $arr;
			if (count($arr)>0)
				$nearest_matches = $arr;
			$search_performed = true;
			}
		
		//////////////////////////////////// TOWNS /////////////////////////////////////////////////////////
		$towns = jomresGetParam( $_REQUEST, 'towns', array() );
		$tmpBookingHandler->tmpsearch_data['ajax_search_composite_selections']['towns']=$towns;
		$tmp = array();
		foreach ($towns as $town)
			{
			$cc = jomres_cmsspecific_stringURLSafe($town);
			$cc = str_replace("-","%",$cc);
			$tmp[]=$cc;
			}
		$towns = $tmp;
		
		if( count($towns) > 0 )
			{
			$gor = genericLike($towns,'property_town',false);
			$pgor = genericOr($this->search_results,'propertys_uid');
			$query="SELECT propertys_uid FROM #__jomres_propertys WHERE $gor AND $pgor";
			$result=doSelectSql($query);
			$arr = array();
			if (count($result)>0)
				{
				foreach ($result as $r)
					$arr[]=$r->propertys_uid;
				}
			$this->search_results = $arr;
			if (count($arr)>0)
				$nearest_matches = $arr;
			$search_performed = true;
			}
		
		//////////////////////////////////// ROOM TYPES /////////////////////////////////////////////////////////
		$room_type_uids = jomresGetParam( $_REQUEST, 'room_type_uids', array() );
		$tmpBookingHandler->tmpsearch_data['ajax_search_composite_selections']['room_type_uids']=$room_type_uids;
		if( count($room_type_uids) > 0 )
			{
			$gor = genericOr($room_type_uids,'room_classes_uid');
			$pgor = genericOr($this->search_results,'propertys_uid');
			$query="SELECT propertys_uid FROM #__jomres_rooms WHERE $gor AND $pgor";
			$result=doSelectSql($query);
			$arr = array();
			if (count($result)>0)
				{
				foreach ($result as $r)
					$arr[]=$r->propertys_uid;
				}
			$this->search_results = $arr;
			if (count($arr)>0)
				$nearest_matches = $arr;
			$search_performed = true;
			}
		
		//////////////////////////////////// PROPERTY TYPES /////////////////////////////////////////////////////////
		$property_type_uids = jomresGetParam( $_REQUEST, 'property_type_uids', array() );
		$tmpBookingHandler->tmpsearch_data['ajax_search_composite_selections']['property_type_uids']=$property_type_uids;
		if( count($property_type_uids) > 0 )
			{
			$gor = genericOr($property_type_uids,'ptype_id');
			$pgor = genericOr($this->search_results,'propertys_uid');
			$query="SELECT propertys_uid FROM #__jomres_propertys WHERE $gor AND $pgor";
			$result=doSelectSql($query);
			$arr = array();
			if (count($result)>0)
				{
				foreach ($result as $r)
					$arr[]=$r->propertys_uid;
				}
			$this->search_results = $arr;
			if (count($arr)>0)
				$nearest_matches = $arr;
			$search_performed = true;
			}
		
		//////////////////////////////////// GUEST NUMBERS /////////////////////////////////////////////////////////
		$guestnumbers = jomresGetParam( $_REQUEST, 'guestnumbers', array() );
		$tmpBookingHandler->tmpsearch_data['ajax_search_composite_selections']['guestnumbers']=$guestnumbers;
		if( count($guestnumbers) > 0 )
			{
			$siteConfig = jomres_singleton_abstract::getInstance('jomres_config_site_singleton');
			$jrConfig=$siteConfig->get();
			if (!isset( $jrConfig['guestnumbersearch']))
				$jrConfig['guestnumbersearch'] = "equal";
			
			$clause = (count($guestnumbers) > 1) ? ' (maxpeople ' : ' maxpeople ';
			$counter = 0;
			foreach ($guestnumbers as $num)
				{
				switch ($jrConfig['guestnumbersearch'])
					{
					case 'lessthan':
						$clause .= '<= ';
						break;
					case 'equal':
						$clause .= '= ';
						break;
					case 'greaterthan':
						$clause .= '>= ';
						break;
					}
				$counter++;
				if ($counter == count($guestnumbers))
					$clause .=(int)$num. " ";
				else
					$clause .=(int)$num. " OR maxpeople ";
				}
			$clause .= (count($guestnumbers) > 1) ? ') ' : '';
			
			//$gor = genericOr($guestnumbers,"maxpeople");
			$pgor = genericOr($this->search_results,'property_uid');

			$query="SELECT property_uid FROM #__jomres_rates WHERE ".$clause." AND ".$pgor;
			$result=doSelectSql($query);
			$arr = array();
			foreach ($result as $r)
				{
				$arr[]=$r->property_uid;
				}

			$this->search_results = array_unique($arr);
			if (count($arr)>0)
				$nearest_matches = $arr;
			$search_performed = true;
			}

		//////////////////////////////////// DATES /////////////////////////////////////////////////////////
		$arrivalDate	=jomresGetParam( $_REQUEST, 'arrivalDate', "");
		$departureDate	=jomresGetParam( $_REQUEST, 'departureDate', "");
		$tmpBookingHandler->tmpsearch_data['ajax_search_composite_selections']['arrivalDate']=$arrivalDate;
		$tmpBookingHandler->tmpsearch_data['ajax_search_composite_selections']['departureDate']=$departureDate;
		if ($arrivalDate != "" && $departureDate !="")
			{
			$arrivalDate	=JSCalConvertInputDates(jomresGetParam( $_REQUEST, 'arrivalDate', "" ),$siteCal=true);
			$departureDate	=JSCalConvertInputDates(jomresGetParam( $_REQUEST, 'departureDate', "" ),$siteCal=true);
			
			$tmpBookingHandler =jomres_singleton_abstract::getInstance('jomres_temp_booking_handler');
			$tmpBookingHandler->tmpsearch_data['jomsearch_availability']= $arrivalDate;
			$tmpBookingHandler->tmpsearch_data['jomsearch_availability_departure']= $departureDate;
			$tmpBookingHandler->close_jomres_session();

			$stayDays=dateDiff("d",$arrivalDate,$departureDate);
			$dateRangeArray=array();
			$date_elements  = explode("/",$arrivalDate);
			$unixCurrentDate= mktime(0,0,0,$date_elements[1],$date_elements[2],$date_elements[0]);
			$secondsInDay = 86400;
			$currentUnixDay=$unixCurrentDate;
			$currentDay=$arrivalDate;
			for ($i=0, $n=$stayDays; $i < $n; $i++)
				{
				$currentDay=date("Y/m/d",$unixCurrentDate);
				$dateRangeArray[]=$currentDay;
				$unixCurrentDate=$unixCurrentDate+$secondsInDay;
				}
			$st="";
			foreach ($dateRangeArray as $eachdate)
				{
				$st.="`date` = '".$eachdate."' OR ";
				}
			$st=substr($st,0,-3);
			$propertiesWithFreeRoomsArray=array();
			
			$all_property_rooms = array();
			$property_ors=genericOr( $this->search_results,"propertys_uid");
			$query="SELECT propertys_uid,room_uid,room_classes_uid FROM #__jomres_rooms WHERE ".$property_ors;
			$roomsLists=doSelectSql($query);
			if (count($roomsLists)>0)
				{
				foreach ($roomsLists as $room)
					{
					$all_property_rooms[$room->propertys_uid][$room->room_uid]=array("room_classes_uid"=>$room->room_classes_uid,"room_uid"=>$room->room_uid );
					}
				}
			$all_property_bookings = array();
			$property_ors=genericOr( $this->search_results,"property_uid");
			$query="SELECT property_uid,room_uid,`date` FROM #__jomres_room_bookings WHERE ".$property_ors." AND (".$st.")";
			$datesList=doSelectSql($query);
			if (count($datesList)>0)
				{
				foreach ($datesList as $date)
					{
					$all_property_bookings[$date->property_uid][]=$date->room_uid;
					}
				}

			foreach ($this->search_results as $property)
				{
				$propertyHasFreeRooms=FALSE;
				$roomsList=$all_property_rooms[(int)$property];
				foreach ($roomsList as $room)
					{
					$ok=true;
					if ($_REQUEST['room_type'] != $this->searchAll)
						{
						if (!empty($_REQUEST['room_type'] ) && $room['room_classes_uid'] != $this->filter['room_type'])
							$ok=false;
						}
					if ($ok)
						{
						if (!in_array ( $room['room_uid'], $all_property_bookings[$property] ) )
							$propertyHasFreeRooms=TRUE;
						}
					}
				if ($propertyHasFreeRooms)
					$propertiesWithFreeRoomsArray[]=$property;
				}
			if (count($propertiesWithFreeRoomsArray)>0)
				{
				if (count($propertiesWithFreeRoomsArray) >1 )
					$propertiesWithFreeRoomsArray=array_unique($propertiesWithFreeRoomsArray);
				$this->search_results = $propertiesWithFreeRoomsArray;
				if (count($propertiesWithFreeRoomsArray)>0)
					$nearest_matches = $propertiesWithFreeRoomsArray;
				$search_performed = true;
				}
			else $this->search_results = array();
				
			}

//print_r($this->search_results);

		if ($search_performed && count($this->search_results)>0)
			$this->ret_vals = $this->search_results;
		else
			{
			$siteConfig = jomres_singleton_abstract::getInstance('jomres_config_site_singleton');
			$jrConfig=$siteConfig->get();
			$randomsearchlimit = (int)$jrConfig['randomsearchlimit'];
			if (count($this->all_published_properties)<=$randomsearchlimit)
				$randomsearchlimit = count($this->all_published_properties);
			
			if (count($nearest_matches)>1)
				$alternative_results = array_rand ( $nearest_matches , $randomsearchlimit);
			else
				$alternative_results =  $nearest_matches;

			set_showtime("alternative_search_results",$alternative_results);
			$this->ret_vals = array();
			}

		}
	
	function get_all_published_properties($filters)
		{
		$property_id_clause = "";
		if (isset($filters['property_uids']))
			{
			$property_id_clause = genericOr( $filters['property_uids'],"propertys_uid");
			}
		$ptype_clause = "";
		if (isset($filters['ptypes']))
			{
			$ptype_clause = genericOr( $filters['ptypes'],"ptype_id");
			}
		
		$and_str1 = "";
		if ( $property_id_clause != "" || $ptype_clause != "")
			$and_str1 = " AND ";
			
		$and_str2 = "";
		if ( $property_id_clause != "" && $ptype_clause != "")
			$and_str2 = " AND ";
		
		$query = "SELECT propertys_uid FROM #__jomres_propertys WHERE published = 1 ".$and_str1.$property_id_clause.$and_str2.$ptype_clause;
		$result = doSelectSql($query);
		$property_uids = array();
		$count = count($result);
		if ($count>0)
			{
			foreach ($result as $r)
				{
				$property_uids[] = (int)$r->propertys_uid;
				}
			}
		$this->all_published_properties = $property_uids;
		$this->search_results = $property_uids;
		}
	
	// This must be included in every Event/Mini-component
	function getRetVals()
		{
		return $this->ret_vals;
		}
	}

?>
