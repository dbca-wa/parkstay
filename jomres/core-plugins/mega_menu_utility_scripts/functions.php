<?php

function mega_menu_get_countries_and_regions()
	{
	// First let's find the first 200 published properties
	$query="SELECT propertys_uid FROM #__jomres_propertys WHERE #__jomres_propertys.published = 1 LIMIT 200";
	//$query="SELECT propertys_uid FROM #__jomres_propertys";  // For testing with limited data
	$base_property_uids =doSelectSql($query); 

	// Do we have at least one property?
	if (count($base_property_uids)==0)
		{
		echo "Error, you don't have any published properties";
		return;
		}
		
	$list = array();
	foreach ($base_property_uids as $p)
		{
		$list[]=(int)$p->propertys_uid;
		}

	for ($i=0;$i<200;$i++)
		{
		if (isset($list[$i]))
			$property_uids[]=$list[$i];
		}

	// Grab the property details
	$current_property_details =jomres_getSingleton('basic_property_details');
	$current_property_details->gather_data_multi($property_uids);

	$regions = array();
	$countries = array();
	foreach ($current_property_details->multi_query_result as $p)
		{
		$country_code = $p['property_country_code'];
		$region = $p['property_region'];
		$country_name = getSimpleCountry($p['property_country_code']);
		if (isset($country_name) && $region != "" )
			{
			$countries[$country_name]["country_code"] =$country_code;
			$countries[$country_name][$region] =$region;
			}
		}
	ksort($countries);
	return $countries;
	}

function mega_menu_get_regions_and_towns()
	{
	// First let's find the first 200 published properties
	$query="SELECT propertys_uid FROM #__jomres_propertys WHERE #__jomres_propertys.published = 1 LIMIT 200";
	//$query="SELECT propertys_uid FROM #__jomres_propertys";  // For testing with limited data
	$base_property_uids =doSelectSql($query); 

	// Do we have at least one property?
	if (count($base_property_uids)==0)
		{
		echo "Error, you don't have any published properties";
		return;
		}
		
	$list = array();
	foreach ($base_property_uids as $p)
		{
		$list[]=(int)$p->propertys_uid;
		}

	for ($i=0;$i<200;$i++)
		{
		if (isset($list[$i]))
			$property_uids[]=$list[$i];
		}

	// Grab the property details
	$current_property_details =jomres_getSingleton('basic_property_details');
	$current_property_details->gather_data_multi($property_uids);

	$regions = array();
	$towns = array();
	foreach ($current_property_details->multi_query_result as $p)
		{
		$town = $p['property_town'];
		$region = $p['property_region'];
		if ($region != "")
			$regions[$region][$town]=$town;
		}
	
	ksort($regions);
	return $regions;
	}
?>