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

class j06100ajax_search_composite
	{
	function j06100ajax_search_composite($componentArgs)
		{
		$MiniComponents =jomres_getSingleton('mcHandler');
		if ($MiniComponents->template_touch)
			{
			$this->template_touchable=false; return;
			}
		$ePointFilepath = get_showtime('ePointFilepath');
	//	die();
		$tmpBookingHandler =jomres_singleton_abstract::getInstance('jomres_temp_booking_handler');
		$previous_selections = $tmpBookingHandler->tmpsearch_data['ajax_search_composite_selections'];
		
		
		$ajax_search_composite = new ajax_search_composite();
		$ajax_search_composite->get();
		
		$by_stars 			= true;
		$by_price 			= true;
		$by_features 		= true;
		$by_country 		= true;
		$by_region 			= true;
		$by_town 			= true;
		$by_roomtype		= true;
		$by_propertytype 	= true;
		$by_guestnumber 	= true;
		$by_date 			= true;
		$modal 				= true;

		if ($ajax_search_composite->ajax_search_compositeConfigOptions['by_stars'] == "0" || jomresGetParam($_REQUEST,'by_stars','') == '0')
			$by_stars = false;
		if ($ajax_search_composite->ajax_search_compositeConfigOptions['by_price'] == "0" || jomresGetParam($_REQUEST,'by_price','') == '0')
			$by_price = false;
		if ($ajax_search_composite->ajax_search_compositeConfigOptions['by_features'] == "0" || jomresGetParam($_REQUEST,'by_features','') == '0')
			$by_features = false;
		if ($ajax_search_composite->ajax_search_compositeConfigOptions['by_country'] == "0" || jomresGetParam($_REQUEST,'by_country','') == '0')
			$by_country = false;
		if ($ajax_search_composite->ajax_search_compositeConfigOptions['by_region'] == "0" || jomresGetParam($_REQUEST,'by_region','') == '0')
			$by_region = false;
		if ($ajax_search_composite->ajax_search_compositeConfigOptions['by_town'] == "0" || jomresGetParam($_REQUEST,'by_town','') == '0')
			$by_town = false;
		if ($ajax_search_composite->ajax_search_compositeConfigOptions['by_roomtype'] == "0" || jomresGetParam($_REQUEST,'by_roomtype','') == '0')
			$by_roomtype = false;
		if ($ajax_search_composite->ajax_search_compositeConfigOptions['by_propertytype'] == "0" || jomresGetParam($_REQUEST,'by_propertytype','') == '0')
			$by_propertytype = false;
		if ($ajax_search_composite->ajax_search_compositeConfigOptions['by_guestnumber'] == "0" || jomresGetParam($_REQUEST,'by_guestnumber','') == '0')
			$by_guestnumber = false;
		if ($ajax_search_composite->ajax_search_compositeConfigOptions['by_date'] == "0" || jomresGetParam($_REQUEST,'by_date','0') == '')
			$by_date = false;
		if ($ajax_search_composite->ajax_search_compositeConfigOptions['modal'] == "0" || jomresGetParam($_REQUEST,'modal','0') == '')
			$modal = false;
		
		$siteConfig = jomres_getSingleton('jomres_config_site_singleton');
		$jrConfig=$siteConfig->get();
		
		$pageoutput = array();
		$output = array();
		$rows = array();
		$stars_head = array();
		$features_head = array();
		$price_head = array();
		$country_head = array();
		$region_head = array();
		$town_head = array();
		$room_type_head = array();
		$property_type_head = array();
		$guestnumber_head = array();
		$date_head = array();
		$stars_rows = array();
		$features_rows = array();
		$price_rows = array();
		$country_rows = array();
		$region_rows = array();
		$town_rows = array();
		$room_type_rows = array();
		$property_type_rows = array();
		$guestnumber_rows = array();
		$date_rows = array();
		
		$output['FORM_NAME']=$componentArgs['FORM_NAME'];
		
		$output['PROPERTY_PREFILTER']='';
		$arguments = jomresGetParam( $_REQUEST, 'property_uids', '' );
		if ($arguments!='')
			{
			$property_uid_bang = explode (",",$arguments);
			foreach ($property_uid_bang as $pid)
				$output['PROPERTY_PREFILTER'].=(int)$pid.",";
			}

		$output['PTYPE_PREFILTER']='';
		$arguments = jomresGetParam( $_REQUEST, 'ptypes', '' );
		if ($arguments!='')
			{
			$ptype_bang = explode (",",$arguments);
			foreach ($ptype_bang as $pid)
				$output['PTYPE_PREFILTER'].=(int)$pid.",";
			}

		$country_prefilter = array();
		$arguments = jomresGetParam( $_REQUEST, 'prefilter_country_code', '' );
		if ( $arguments !='' )
			{
			$country_code_bang = explode (",",$arguments);
			foreach ($country_code_bang as $country_code)
				$country_prefilter[]=$country_code;
			}

		$region_prefilter = array();
		$arguments = jomresGetParam( $_REQUEST, 'prefilter_region', '' );
//print_r($arguments);
//die();
		if ($arguments!='')
			{
			$region_bang = explode (",",$arguments);
			foreach ($region_bang as $region)
				$region_prefilter[] =$region;
			}

		if ( count($ptype_bang)==1 )
			$by_propertytype = false;
		
		//////////////////////////////////// STARS /////////////////////////////////////////////////////////
		if ($by_stars)
			{
			$stars_head[] = array('_JOMRES_COM_A_INTEGRATEDSEARCH_BYTARS'=>jr_gettext('_JOMRES_COM_A_INTEGRATEDSEARCH_BYTARS',_JOMRES_COM_A_INTEGRATEDSEARCH_BYTARS,false,false));
			
			$c = jomres_singleton_abstract::getInstance( 'jomres_array_cache' );
			$stars_array=$c->retrieve('all_property_stars');
			
			if (!$stars_array)
				{
				$stars_array=array(0=>0,1=>0,2=>0,3=>0,4=>0,5=>0);
				$query = "SELECT stars FROM #__jomres_propertys WHERE published = 1";
				$result = doSelectSql($query);
			
				if (count($result)>0)
					{
					foreach ($result as $s)
						{
						$no = $s->stars;
						$stars_array[$no]++;
						}
					$c->store('all_property_stars',$stars_array);
					}
				}

			$stars_rows = array();

			foreach ($stars_array as $key=>$st)
				{
				$s=array();
				$s['NUMBER']=$key;
				$s['DISABLED']='';
				if ((int)$st == 0)
					$s['DISABLED']='disabled="disabled"';
				$s['COUNT'] = (int)$st;
				$s['IMAGE']='';
						$s['CHECKED']='';
						if (in_array($key,$previous_selections['stars']))
							{
							$s['CHECKED']='checked="checked"';
							}
				for ($i=1;$i<=(int)$key;$i++)
					{
					$s['IMAGE'] .='<img src="'.get_showtime('livesite').'jomres/images/star.png" alt="star"/>';
					}
				$s['RANDOM_ID']=generateJomresRandomString(10);
				$stars_rows[] = $s;
				}
			}
		
		//////////////////////////////////// FEATURES /////////////////////////////////////////////////////////
		if ($by_features)
			{
			$features_head[] = array('_JOMRES_COM_A_INTEGRATEDSEARCH_BYFEATURES'=>jr_gettext('_JOMRES_COM_A_INTEGRATEDSEARCH_BYFEATURES',_JOMRES_COM_A_INTEGRATEDSEARCH_BYFEATURES,false,false));
			$features_array = prepFeatureSearch();

			if ($output['PTYPE_PREFILTER'] != "")
				{
				$filtered = array();
				$gor = genericOr($ptype_bang,"ptype_id");
				$query = "SELECT hotel_features_uid FROM #__jomres_hotel_features WHERE ".$gor. " OR ptype_id = 0";
				$filter = doSelectSql($query);
				if (count($filter)>0)
					{
					foreach ($filter as $type)
						{
						foreach ($features_array as $feature)
							{
							if ((int)$feature['id'] == $type->hotel_features_uid)
								{
								
								$filtered[]=$feature;
								}
							}
						}
					}
				$features_array =$filtered;
				}

			if (count($features_array)>0)
				{
				foreach ($features_array as $feature)
					{
					$id=$feature['id'];
					if ($id > 0) // Need to not use the id 0 as that's a special "all" id that's used by jomsearch, but not by us here
						{
						$r=array();
						$image = '/'.$feature['image'];
						$feature_abbv = jr_gettext('_JOMRES_CUSTOMTEXT_FEATURES_ABBV'.(int)$feature['id'],		jomres_decode($feature['title']),false,false);
						$feature_desc = jr_gettext('_JOMRES_CUSTOMTEXT_FEATURES_DESC'.(int)$feature['id'],		jomres_decode($feature['description']),false,false);
						$r['TITLE']=$feature_abbv;
						$r['IMAGE']=$image;
						$r['ICON']=jomres_makeTooltip($feature_abbv,$feature_abbv,$feature_desc,$image,"","property_feature",array());
						$r['ID']=$id;
						$r['RANDOM_ID']=generateJomresRandomString(10);
						$r['CHECKED']='';
						$r['ACTIVE_CLASS']='';
						if (in_array($feature['id'],$previous_selections['feature_uids']))
							{
							$r['CHECKED']='checked="checked"';
							$r['ACTIVE_CLASS']=' btn-success active ';
							}
						$features_rows[]=$r;
						}
					}
				}
			}
		
		//////////////////////////////////// Price ranges /////////////////////////////////////////////////////////
		if ($by_price)
			{
			$price_head[] = array('_JOMRES_SEARCH_PRICERANGES'=>jr_gettext('_JOMRES_SEARCH_PRICERANGES',_JOMRES_SEARCH_PRICERANGES,false,false));
			jr_import('currency_codes');
			$currencycode = $jrConfig['globalCurrencyCode'];
			$c_codes = new currency_codes($currencycode);
			$symbols = $c_codes->getSymbol();
			
			$output['PREPRICE'] = $symbols['pre'];
			$output['POSTPRICE'] = $symbols['post'];
			
			$price_ranges = prepPriceRangeSearch();

			// To build the price ranges as buttons
			$prices_rows = array();
			foreach ($price_ranges as $key=>$range)
				{
				if ($key != 0)
					{
					$r=array();
					$r['RANGE']=$range;
					$r['CHECKED']='';
					$r['ACTIVE_CLASS']='';
					if (in_array($range,$previous_selections['priceranges']))
						{
						$r['CHECKED']='checked="checked"';
						$r['ACTIVE_CLASS']=' btn-success active ';
						}
					$r['RANDOM_ID']=generateJomresRandomString(10);
					$prices_rows[]=$r;
					}
				}
			
			
			// To build the sliders.
			$count = count($price_ranges);
			$exploded_ranges = array();
			for ($i=1;$i<=$count;$i++)
				{
				if(array_key_exists($i,$price_ranges))
					{
					$bang = explode("-",$price_ranges[$i]);
					if (is_array($bang))
						{
						if ( (int)$bang[0] > 0 )
							$exploded_ranges[]=(int)$bang[0];
						if ( (int)$bang[1] > 0 )
							$exploded_ranges[]=(int)$bang[1];
						}
					}
				}
			sort($exploded_ranges);
			$num=count($exploded_ranges);
			$output['MINPRICE'] = $exploded_ranges[0];
			$output['MAXPRICE'] = $exploded_ranges[$num-1];
			}
		else
			{
			$output['PREPRICE'] = '';
			$output['POSTPRICE'] = '';
			$output['MINPRICE'] = '0';
			$output['MAXPRICE'] = '1';
			}
		//////////////////////////////////// Geographic search /////////////////////////////////////////////////////////
		
		$locales = prepGeographicSearch();
		$countries = array();
		$regions = array();
		$towns = array();

		if ( count ( $country_prefilter ) > 0 )
			{
			$new_arr = array();
			$count = count($locales ['propertyLocations'] );
			for ($i=0;$i<$count;$i++)
				{
				$locale = $locales['propertyLocations'][$i];
				if ( in_array ( $locales['propertyLocations'][$i]['country'] , $country_prefilter ) )
					{
					$new_arr[] = $locales['propertyLocations'][$i];
					}
				}
			$locales['propertyLocations'] = $new_arr;
			}
		
		if ( count ( $region_prefilter ) > 0 )
			{
			$new_arr = array();
			$count = count($locales ['propertyLocations'] );
			for ($i=0;$i<$count;$i++)
				{
				$locale = $locales['propertyLocations'][$i];
				if ( in_array ( $locales['propertyLocations'][$i]['region'] , $region_prefilter ) )
					{
					$new_arr[] = $locales['propertyLocations'][$i];
					}
				}
			$locales['propertyLocations'] = $new_arr;
			}
		
		foreach ($locales['propertyLocations'] as $locale)
			{
			$countrycode = $locale['country'];
			$region = $locale['region'];
			$town = $locale['property_town'];

			if ($locale['countryname'] != "" && $region != "" && town != "")
				{
				$countries[$countrycode] = $locale['countryname'];
				$regions [$locale['countryname']][$region] =$region;
				$towns[$locale['countryname']][$region][$town] = $town;
				}
			}

		asort($countries,SORT_NATURAL);
		ksort($regions,SORT_NATURAL);
		ksort($towns,SORT_NATURAL);
		
		$new_arr = array();
		foreach ($regions as $country=>$region)
			{
			ksort($region,SORT_NATURAL);
			$new_arr[$country]=$region;
			}
		$regions =$new_arr;

		$new_arr = array();
		foreach ($towns as $country=>$town)
			{
			ksort($town,SORT_NATURAL);
			$new_arr[$country]=$town;
			}
		$towns =$new_arr;

		if ($by_country)
			{
			$country_head[] = array('_JOMRES_SEARCH_GEO_COUNTRYSEARCH'=>jr_gettext('_JOMRES_SEARCH_GEO_COUNTRYSEARCH',_JOMRES_SEARCH_GEO_COUNTRYSEARCH,false,false));
			}
		
		if ($by_region)
			{
			$region_head[] = array('_JOMRES_SEARCH_GEO_REGIONSEARCH'=>jr_gettext('_JOMRES_SEARCH_GEO_REGIONSEARCH',_JOMRES_SEARCH_GEO_REGIONSEARCH,false,false));
			}
		if ($by_town)
			{
			$town_head[] = array('_JOMRES_SEARCH_GEO_TOWNSEARCH'=>jr_gettext('_JOMRES_SEARCH_GEO_TOWNSEARCH',_JOMRES_SEARCH_GEO_TOWNSEARCH,false,false));
			}
			

		
		$country_rows = array();
		foreach ($countries as $country_code=>$country_name)
			{
			$r = array();
			$r['COUNTRYCODE']=$country_code;
			$r['COUNTRYNAME']=$country_name;
			$r['RANDOM_ID']=generateJomresRandomString(10);
			$r['CHECKED']='';
			$r['ACTIVE_CLASS']='';
			if (in_array($country_code,$previous_selections['countries']))
				{
				$r['CHECKED']='checked="checked"';
				$r['ACTIVE_CLASS']=' btn-success active ';
				}
			$country_rows[] = $r;
			}
		
		foreach ($regions as $country=>$regionz)
			{
			$sub_pageoutput = array();
			$sub_output = array( "COUNTRY_NAME" => $country );
			$rows = array();
			foreach ( $regionz as $region )
				{
				$r = array();
				$r['REGION']=$region;
				$r['RANDOM_ID']=generateJomresRandomString(10);
				$r['CHECKED']='';
				$r['ACTIVE_CLASS']='';
				if (in_array($region,$previous_selections['regions']))
					{
					$r['CHECKED']='checked="checked"';
					$r['ACTIVE_CLASS']=' btn-success active ';
					
					}
				$rows[] = $r;
				}
			
			$tmpl = new patTemplate();
			if (!using_bootstrap())
				{
				$tmpl->setRoot( $ePointFilepath.JRDS.'templates'.JRDS.'jquery_ui' );
				}
			else
				{
				$tmpl->setRoot( $ePointFilepath.JRDS.'templates'.JRDS.'bootstrap' );
				}

			$tmpl->readTemplatesFromInput( 'regions.html' );
			$sub_pageoutput[] = $sub_output;
			$tmpl->addRows( 'sub_pageoutput', $sub_pageoutput );
			$tmpl->addRows( 'region_rows', $rows );

			$region_rows[] = array ( "REGIONS" => $tmpl->getParsedTemplate());
			}

		foreach ($towns as $country=>$regionz)
			{
			$town_country_rows[] = array ('COUNTRY'=>$country );
			foreach ($regionz as $region=>$townz)
				{
				$sub_pageoutput = array();
				$sub_output = array( "REGION_NAME" => $region );
				$rows = array();
				foreach ( $townz as $town )
					{
					$r = array();
					$r['TOWN']=$town;
					$r['RANDOM_ID']=generateJomresRandomString(10);
					$r['CHECKED']='';
					$r['ACTIVE_CLASS']='';
					if (in_array($town,$previous_selections['towns']))
						{
						$r['CHECKED']='checked="checked"';
						$r['ACTIVE_CLASS']=' btn-success active ';
						}
					$rows[] = $r;
					}
				
				$tmpl = new patTemplate();
				if (!using_bootstrap())
					{
					$tmpl->setRoot( $ePointFilepath.JRDS.'templates'.JRDS.'jquery_ui' );
					}
				else
					{
					$tmpl->setRoot( $ePointFilepath.JRDS.'templates'.JRDS.'bootstrap' );
					}

				$tmpl->readTemplatesFromInput( 'towns.html' );
				$sub_pageoutput[] = $sub_output;
				$tmpl->addRows( 'sub_pageoutput', $sub_pageoutput );
				$tmpl->addRows( 'town_rows', $rows );

				$town_rows[] = array ( "TOWNS" => $tmpl->getParsedTemplate());
				}
			}

		//////////////////////////////////// ROOM TYPES /////////////////////////////////////////////////////////
		if ($by_roomtype)
			{
			$room_type_head = array();
			$room_type_head[] = array('_JOMRES_SEARCH_RTYPES'=>jr_gettext('_JOMRES_SEARCH_RTYPES',_JOMRES_SEARCH_RTYPES,false,false));
			$room_type_array = prepRoomtypeSearch();
			
			if ($output['PTYPE_PREFILTER'] != "")
				{
				$filtered = array();
				$gor = genericOr($ptype_bang,"propertytype_id");
				$query = "SELECT roomtype_id FROM #__jomres_roomtypes_propertytypes_xref WHERE ".$gor;
				$filter = doSelectSql($query);
				if (count($filter)>0)
					{
					foreach ($filter as $type)
						{
						foreach ($room_type_array as $room_type)
							{
							
							if ((int)$room_type['id'] == $type->roomtype_id)
								{
								
								$filtered[]=$room_type;
								}
							}
						}
					}
				$room_type_array =$filtered;
				}
			
			if (count($room_type_array)>0)
				{
				foreach ($room_type_array as $room_type)
					{
					$id=$room_type['id'];
					if ($id > 0) // Need to not use the id 0 as that's a special "all" id that's used by jomsearch, but not by us here
						{
						$r=array();
						$image = '/'.$room_type['image'];
						$room_type_abbv = jr_gettext('_JOMRES_CUSTOMTEXT_ROOMTYPES_ABBV'.(int)$room_type['id'],		jomres_decode($room_type['title']),false,false);
						$room_type_desc = jr_gettext('_JOMRES_CUSTOMTEXT_ROOMTYPES_DESC'.(int)$room_type['id'],		jomres_decode($room_type['description']),false,false);
						$r['TITLE']=$room_type_abbv;
						$r['IMAGE']=$image;
						$r['ICON']=jomres_makeTooltip($room_type_abbv,$room_type_abbv,$room_type_desc,$image,"","room_type",array());
						$r['ID']=$id;
						$r['RANDOM_ID']=generateJomresRandomString(10);
						$r['CHECKED']='';
						$r['ACTIVE_CLASS']='';
						if (in_array($room_type['id'],$previous_selections['room_type_uids']))
							{
							$r['CHECKED']='checked="checked"';
							$r['ACTIVE_CLASS']=' btn-success active ';
							}
						$room_type_rows[]=$r;
						}
					}
				}
			}
		
		//////////////////////////////////// PROPERTY TYPES /////////////////////////////////////////////////////////
		if ($by_propertytype)
			{
			$property_type_head[] = array('_JOMRES_SEARCH_PTYPES'=>jr_gettext('_JOMRES_SEARCH_PTYPES',_JOMRES_SEARCH_PTYPES,false,false));
			$property_type_array = prepPropertyTypeSearch();
			if (count($property_type_array)>0)
				{
				foreach ($property_type_array as $property_type)
					{
					$id=$property_type['id'];
					if ($id > 0) // Need to not use the id 0 as that's a special "all" id that's used by jomsearch, but not by us here
						{
						$r=array();
						$r['TITLE']=jr_gettext('_JOMRES_CUSTOMTEXT_PROPERTYTYPE'.$property_type['id'],jomres_decode($property_type['ptype']),false,false);
						$r['ID']=$id;
						$r['RANDOM_ID']=generateJomresRandomString(10);
						$r['CHECKED']='';
						$r['ACTIVE_CLASS']='';
						if (in_array($property_type['id'],$previous_selections['property_type_uids']))
							{
							$r['CHECKED']='checked="checked"';
							$r['ACTIVE_CLASS']=' btn-success active ';
							}
						$property_type_rows[]=$r;
						}
					}
				}
			}

		//////////////////////////////////// GUESTNUMBER /////////////////////////////////////////////////////////
		if ($by_guestnumber)
			{
			$guestnumber_head[] = array('_JOMRES_COM_A_INTEGRATEDSEARCH_BYGUESTNUMBER'=>jr_gettext('_JOMRES_COM_A_INTEGRATEDSEARCH_BYGUESTNUMBER',_JOMRES_COM_A_INTEGRATEDSEARCH_BYGUESTNUMBER,false,false));
			$guestnumber_array = prepGuestnumberSearch();
			if (count($guestnumber_array)>0)
				{
				foreach ($guestnumber_array as $guestnumber)
					{
					$r=array();
					$r['NUMBER']=$guestnumber;
					$r['RANDOM_ID']=generateJomresRandomString(10);
					$r['CHECKED']='';
					$r['ACTIVE_CLASS']='';
					if (in_array($guestnumber,$previous_selections['guestnumbers']))
						{
						$r['CHECKED']='checked="checked"';
						$r['ACTIVE_CLASS']=' btn-success active ';
						}
					$guestnumber_rows[]=$r;
					}
				}
			}

		//////////////////////////////////// DATES /////////////////////////////////////////////////////////
		if ($by_date)
			{
			$date_head[] = array('_JOMRES_FRONT_AVAILABILITY'=>jr_gettext('_JOMRES_FRONT_AVAILABILITY',_JOMRES_FRONT_AVAILABILITY,false,false));
			$date_array = prepAvailabilitySearch();
			$r=array();
			$r['ARRIVALDATE']= generateDateInput("arrivalDate",$date_array['arrival'],"ad",TRUE);
			$r['DEPARTUREDATE']= generateDateInput("departureDate",$date_array['departure'],FALSE,TRUE,false);
			$r['_JOMRES_COM_MR_VIEWBOOKINGS_DEPARTURE'] = jr_gettext('_JOMRES_COM_MR_VIEWBOOKINGS_DEPARTURE',_JOMRES_COM_MR_VIEWBOOKINGS_DEPARTURE);
			$r['_JOMRES_COM_MR_VIEWBOOKINGS_ARRIVAL'] = jr_gettext('_JOMRES_COM_MR_VIEWBOOKINGS_ARRIVAL',_JOMRES_COM_MR_VIEWBOOKINGS_ARRIVAL);
			$date_rows[]=$r;
			}



		$output['_JOMRES_RETURN_TO_RESULTS']=jr_gettext('_JOMRES_RETURN_TO_RESULTS',_JOMRES_RETURN_TO_RESULTS,false);
		$output['_JOMRES_COM_A_RESET']=jr_gettext('_JOMRES_COM_A_RESET',_JOMRES_COM_A_RESET,false);
		
		
		$pageoutput[]=$output;
		$tmpl = new patTemplate();
		if (!using_bootstrap())
			{
			$tmpl->setRoot( $ePointFilepath.JRDS.'templates'.JRDS.'jquery_ui' );
			$tmpl->readTemplatesFromInput( 'ajax_search_composite.html' );
			}
		else
			{
			$tmpl->setRoot( $ePointFilepath.JRDS.'templates'.JRDS.'bootstrap' );
			if (!$modal)
				$tmpl->readTemplatesFromInput( 'ajax_search_composite.html' );
			else
				$tmpl->readTemplatesFromInput( 'ajax_search_composite_modals.html' );
			}
	
//print_r($_REQUEST);	
		$tmpl->addRows( 'pageoutput', $pageoutput );
		
		$tmpl->addRows( 'stars_head', $stars_head );
		$tmpl->addRows( 'price_head', $price_head );
		$tmpl->addRows( 'country_head', $country_head );
		$tmpl->addRows( 'region_head', $region_head );
		$tmpl->addRows( 'town_head', $town_head );
		$tmpl->addRows( 'features_head', $features_head );
		$tmpl->addRows( 'room_type_head', $room_type_head );
		$tmpl->addRows( 'property_type_head', $property_type_head );
		$tmpl->addRows( 'guestnumber_head', $guestnumber_head );
		$tmpl->addRows( 'date_head', $date_head );
		
		$tmpl->addRows( 'stars_rows', $stars_rows );
		$tmpl->addRows( 'prices_rows', $prices_rows );
		$tmpl->addRows( 'features_rows', $features_rows );
		$tmpl->addRows( 'country_rows', $country_rows );
		$tmpl->addRows( 'region_rows', $region_rows );
		$tmpl->addRows( 'town_country_rows', $town_country_rows );
		$tmpl->addRows( 'town_rows', $town_rows );
		$tmpl->addRows( 'room_type_rows', $room_type_rows );
		$tmpl->addRows( 'property_type_rows', $property_type_rows );
		$tmpl->addRows( 'guestnumber_rows', $guestnumber_rows );
		$tmpl->addRows( 'date_rows', $date_rows );
		
		$this->ret_vals = $tmpl->getParsedTemplate();
		}
	
	// This must be included in every Event/Mini-component
	function getRetVals()
		{
		return array("SEARCHFORM"=>$this->ret_vals);
		}
	}

?>
