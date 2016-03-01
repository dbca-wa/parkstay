<?php
/**
 * Plugin
 * @author Vince Wooll <sales@jomres.net>
 * @version Jomres 4 
* @package Jomres
* @copyright	2005-2010 Vince Wooll
* Jomres (tm) PHP files are released under both MIT and GPL2 licenses. This means that you can choose the license that best suits your project, and use it accordingly, however all images, css and javascript which are copyright Vince Wooll are not GPL licensed and are not freely distributable. 
**/

// ################################################################
defined( '_JOMRES_INITCHECK' ) or die( '' );
// ################################################################

class j06000extended_maps
	{
	function j06000extended_maps()
		{
		$MiniComponents =jomres_getSingleton('mcHandler');
		if ($MiniComponents->template_touch)
			{
			$this->template_touchable=false; return;
			}
		global $jomresConfig_absolute_path;
		$eLiveSite=get_showtime('eLiveSite');
		add_gmaps_source();
		
		$ePointFilepath = get_showtime('ePointFilepath');
		$jomresConfig_live_site=get_showtime('live_site');
		
		$siteConfig = jomres_getSingleton('jomres_config_site_singleton');
		$jrConfig=$siteConfig->get();
		
		$allProperties=array();
		$rows = array();
		$output=array();
		$pageoutput=array();

//print_r($_REQUEST);	
	
		// e.g. "hotels:1;villas:6;camp sites:4" 
		$arguments = jomresGetParam( $_REQUEST, 'ptype_ids', '' );
		$show_properties = jomresGetParam( $_REQUEST, 'show_properties', 1 );
		$show_events = jomresGetParam( $_REQUEST, 'show_events', 1 );
		$show_attractions = jomresGetParam( $_REQUEST, 'show_attractions', 1 );
		
		if ($arguments!='' && $arguments!=0)
			{
			$property_type_bang = explode (",",$arguments);
			
			$required_property_type_ids = array();
			foreach ($property_type_bang as $ptype)
				{
				$required_property_type_ids[] = (int)$ptype;
				}
			$g_ptype_ids=$this->genericIn($required_property_type_ids);
			$clause=" AND ptype_id IN ".$g_ptype_ids." ";
			}
		else
			$clause="";
		
		if (isset($_REQUEST['country']))
			{
			$country = jomresGetParam( $_REQUEST, 'country',"" );
			$clause = " AND property_country = '".$country."' ";
			}
		elseif (isset($_REQUEST['region']))
			{
			$region = jomresGetParam( $_REQUEST, 'region',"" );
			$clause = " AND property_region = '".$region."' ";
			}
		elseif (isset($_REQUEST['region_promo']))
			{
                $region = jomresGetParam( $_REQUEST, 'region_promo',"" );
			$clause = " AND property_regionpromo = '".$region."' ";
			}
		elseif (isset($_REQUEST['town']))
			{
			$town = jomresGetParam( $_REQUEST, 'town',"" );
			$clause = " AND property_town = '".$town."' ";
			}
// By Nitin for tile and description on the region page. 		
	$output['PROPERTY_REGION'] = $_REQUEST['prefilter_region'];	
//	$output['PROPERTY_REGION'] = $_REQUEST['prefilter_region'];
		$output['APIKEY']=$jrConfig['google_maps_api_key'];
		$output['LIVESITE']=$jomresConfig_live_site;
		jr_import('browser_detect');
		$b = new browser_detect();
		$browser = $b->getBrowser();
		$output['VAR']="";
		if ($browser=="Internet Explorer")
			$output['VAR']="var";
		$lang=get_showtime('lang');
		$current_language=split('-',$lang);
		$output['LANG']=$current_language[0];

		$mapsettings = new jrportal_extended_maps();
		$mapsettings->get_extended_maps();
		$output['WIDTH']=(int)$mapsettings->extended_mapsConfigOptions['width'];
		$output['HEIGHT']=(int)$mapsettings->extended_mapsConfigOptions['height'];
		$groupmarkers=(int)$mapsettings->extended_mapsConfigOptions['groupmarkers'];
		if ($groupmarkers==1)
			{
			jomres_cmsspecific_addheaddata("javascript",$eLiveSite.'javascript/',"markerclusterer_compiled.js",false);
			$output['GROUPMARKERS']='var markerCluster = new MarkerClusterer(map, markers);';
			}
		$maptype=$mapsettings->extended_mapsConfigOptions['maptype'];
		
		if($maptype=='normal' || $maptype==''){
			$maptype='ROADMAP';
		}elseif ($maptype=='satellite'){
			$maptype='SATELLITE';	
		}elseif ($maptype=='hybrid'){
			$maptype='HYBRID';
		}elseif ($maptype=='terrain'){
			$maptype='TERRAIN';
		}

		$output['MAPTYPE']=$maptype;
		
		if ($show_properties == 1)
			{
	$query="SELECT `propertys_uid`,`lat`,`long`,`property_street`,`property_town`,`property_region`,`property_description`,`stars`,`ptype_id`,`property_features` FROM #__jomres_propertys  WHERE  published = 1  AND (`lat` != '' AND `long` != '') AND (CAST(`lat` AS DECIMAL(10,6)) BETWEEN '-89' AND '89') AND (CAST(`long` AS DECIMAL(10,6)) BETWEEN '-179' AND '179')"
			.$clause;

//print_r($query); 
			$result=doSelectSql($query);
	
			if (count($result)>0)
				{
				$original_property_uid=get_showtime('property_uid');
				foreach ($result as $r)
					{
					if ($r->lat != "" && $r->lat != "0" && $r->long != "" && $r->long != "0")
						{
						set_showtime('property_uid',(int)$r->propertys_uid);
						$allProperties[$r->propertys_uid]['id']=(int)$r->propertys_uid ;
						$allProperties[$r->propertys_uid]['lat']=stripslashes($r->lat);
						$allProperties[$r->propertys_uid]['long']=stripslashes($r->long);
						$allProperties[$r->propertys_uid]['property_street']=str_replace("'","`", jomres_decode(jr_gettext('_JOMRES_CUSTOMTEXT_PROPERTY_STREET',$r->property_street,false,false)));
						$allProperties[$r->propertys_uid]['property_town']=str_replace("'","`", jomres_decode(jr_gettext('_JOMRES_CUSTOMTEXT_PROPERTY_TOWN',$r->property_town,false,false)));

                            if (isset($_REQUEST['region']))
                            {
                                $allProperties[$r->propertys_uid]['property_region']=str_replace("'","`", jomres_decode(jr_gettext('_JOMRES_CUSTOMTEXT_PROPERTY_REGION',$r->property_region,false,false)));

                            }
                            elseif (isset($_REQUEST['region_promo']))
                            {
                                $allProperties[$r->propertys_uid]['property_region']=str_replace("'","`", jomres_decode(jr_gettext('_JOMRES_CUSTOMTEXT_PROPERTY_REGION',$r->property_regionpromo,false,false)));

                            }


						$description = str_replace("'","`", jomres_decode(jr_gettext('_JOMRES_CUSTOMTEXT_ROOMTYPE_DESCRIPTION', $r->property_description,false,false )));
						$description = str_replace("&lt;","<",$description);
						$description = str_replace("&gt;",">",$description);
						$description = jomres_remove_HTML($description);
						$allProperties[$r->propertys_uid]['property_description']= $description;
						$allProperties[$r->propertys_uid]['stars']=stripslashes($r->stars);
						$allProperties[$r->propertys_uid]['ptype_id']=(int)$r->ptype_id;
			                        $allProperties[$r->propertys_uid]['features']=$r->property_features;
//print_r($allProperties[$r->propertys_uid]['features']);
//die();
						}
					}
				set_showtime('property_uid',$original_property_uid);
				}
			$numberOfProperties=count($allProperties);

			$all_property_uids=array_keys($allProperties);
			
			//grab the property names
			$current_property_details = jomres_singleton_abstract::getInstance( 'basic_property_details' );
			$current_property_details->get_property_name_multi( $all_property_uids );
			
			//Grab the property imaages
			$jomres_media_centre_images = jomres_singleton_abstract::getInstance( 'jomres_media_centre_images' );
			$jomres_media_centre_images->get_images_multi($all_property_uids, array('property'));
	
			$mrConfigs = array();
			$query="SELECT property_uid,akey,value FROM #__jomres_settings WHERE property_uid != 0";
			$settingsList=doSelectSql($query);
			if (count($settingsList)>0)
				{
				foreach ($settingsList as $setting)
					{
					$mrConfigs[$setting->property_uid][$setting->akey]=$setting->value;
					}
				}
	
			foreach ($allProperties as $property)
				{
				$r=array();
				$id=$property['id'];
				$tmp_mrConfig=$mrConfigs[$id];
				//print_r($property);
				if (!isset($tmp_mrConfig['singleRoomProperty']))
					$tmp_mrConfig['singleRoomProperty'] = 0;
				
				/*if ($tmp_mrConfig['singleRoomProperty'] == 0)
					$r['ICON']=$jomresConfig_live_site.$mapsettings->extended_mapsConfigOptions['mrpicon'];
				else
					$r['ICON']=$jomresConfig_live_site.$mapsettings->extended_mapsConfigOptions['srpicon'];*/
			$property_uid = $id;	
				if (file_exists($ePointFilepath.JRDS.'markers'.JRDS.'ptype'.JRDS.$property['ptype_id'].'.png') )
					$r['ICON']=$eLiveSite.'/markers/ptype/'.$property['ptype_id'].'.png';
				else
					$r['ICON']=$eLiveSite.'/markers/ptype/default.png';
				
				$r['lat']=$property['lat'];
				$r['long']=$property['long'];
				$r['ptype'] = $property['ptype_id'];
				$jomres_media_centre_images->get_images($id, array('property'));
				$r['property_image']=$jomres_media_centre_images->images ['property'][0][0]['small'];
	
				$r['URL']=str_replace("'","",jomresURL( JOMRES_SITEPAGE_URL."&task=viewproperty&property_uid=".$property['id']));

				$pageoutput=array();
				$o=array();
				$o['PROPERTY_NAME']=$current_property_details->property_names[$id];
                // Nitin Start
				$r['PROPERTY_NAME'] = $o['PROPERTY_NAME'];
                
                // End
 $r['features'] = $property['features'];
//print_r($r['features']);

$flag=false;
if($r['features'] != ",,"){
$feat=array();
$feat[] = explode(',',$r['features']);


$fe = '';

    foreach($feat[0] as $fe){


          if($fe != "" ) {

           $query_feature = "SELECT `hotel_features_uid`,`hotel_feature_abbv`,`hotel_feature_full_desc`,`image` FROM #__jomres_hotel_features WHERE  hotel_features_uid ='". $fe ."'";
                 $res1=doSelectSql($query_feature);

     $featureL['FEATURE'] = $res1[0]->image ;


 $featureList[$property_uid][]=$featureL;
//print_r($featureList);
$flag=true;
    }
    }

}
else
{
$flag = false;
}

				$o['URL']=$r['URL'];
				if ($mapsettings->extended_mapsConfigOptions['trim_description']=="1")
					{
					$trim_value=(int)$mapsettings->extended_mapsConfigOptions['trim_value'];
					//$o['PROPERTY_DESCRIPTION']=jr_substr(strip_tags($property['property_description']),0,$trim_value,"UTF-8")."...";
					}
				else
					//$o['PROPERTY_DESCRIPTION']=$property['property_description'];
				if ($mapsettings->extended_mapsConfigOptions['show_description']=="0")
					$o['PROPERTY_DESCRIPTION']="";
			//	$o['PROPERTY_STREET']=$property['property_street'];
				$o['PROPERTY_TOWN']=$property['property_town'];
				if (is_numeric($property['property_region']))
					{
					$jomres_regions = jomres_singleton_abstract::getInstance('jomres_regions');

                        $o['PROPERTY_REGION']=jr_gettext("_JOMRES_CUSTOMTEXT_REGIONS_".$property['property_region'],$jomres_regions->regions[$property['property_region']]['regionname'],$editable,false);
					}
				else
					$o['PROPERTY_REGION']=jr_gettext('_JOMRES_CUSTOMTEXT_PROPERTY_REGION',$property['property_region'],$editable,false);
				$o['STARS']=$r['stars'];
				$o['IMAGE']=$r['property_image'];
                $o['VIEW_LINK']='<a href="'.$r['URL'].'" class="btn btn-primary property_details_buttons">More info</a>';
//                $o= $r['URL'];
                    //.jr_gettext('_JOMRES_COM_A_CLICKFORMOREINFORMATION',_JOMRES_COM_A_CLICKFORMOREINFORMATION,false,false).'</a>';
				$o['POPUP_WIDTH']=$mapsettings->extended_mapsConfigOptions['popupwidth'];
				$o['IMG_WIDTH']=$mapsettings->extended_mapsConfigOptions['img_width'];
				$o['IMG_HEIGHT']=$mapsettings->extended_mapsConfigOptions['img_height'];
                $o['FEATURES'] = $property['features'];
				$pageoutput[]=$o;
				$tmpl = new patTemplate();
				if (using_bootstrap())
					$tmpl->setRoot( $ePointFilepath.JRDS."templates".JRDS."bootstrap" );
				else
					$tmpl->setRoot( $ePointFilepath.JRDS."templates".JRDS."jquery_ui" );
				$tmpl->readTemplatesFromInput( 'popup.html');
				$tmpl->addRows( 'pageoutput',$pageoutput);

if(empty($featuresList) && $r['features'] != ",," && $flag == true ){
 //       $fea = $featureList[68];
//        print_r($featureList);
        $tmpl->addRows( 'property_features',$featureList[$property_uid]);
      }

				$str=$tmpl->getParsedTemplate();
                $str = trim($str);
				$str = str_replace('\r\n', '', $str);
				$str = str_replace(chr(10), " ", $str);
				$str = str_replace(chr(13), " ", $str);
	
				$r['POPUP']=$str;
				$rows[]=$r;
				unset($tmpl);
				}
			}

		$events=array();
		if (file_exists($jomresConfig_absolute_path.JRDS."jomres".JRDS."core-plugins".JRDS."local_events".JRDS."plugin_info.php"))
			{
			if ($show_events == 1)
				{
				$today = date("Y-m-d");
				$query = "SELECT * FROM #__jomres_local_events WHERE start_date >= '".$today."'";
				$result = doSelectSql($query);
	
				if (count($result)>0)
					{
					foreach ($result as $res)
						{
						$e=array();
						$pageoutput=array();
						$e['LAT']=$res->latitude;
						$e['LONG']=$res->longitude;
						$e['ICON']=$output['INFOICON'];
						$o['PAGETITLE']=str_replace("'","`", jr_gettext('_JRPORTAL_LOCAL_EVENTS_TITLE',_JRPORTAL_LOCAL_EVENTS_TITLE,false,false));
						$o['TITLE']=str_replace("'","`", $res->title);
						$o['START_DATE']=outputDate(str_replace("-","/",$res->start_date));
						$o['END_DATE']=outputDate(str_replace("-","/",$res->end_date));
						$o['LAT']=$res->latitude;
						$o['LONG']=$res->longitude;
						$o['WEBSITE_URL']=trim($res->website_url);
						$o['EVENT_LOGO']=trim($res->event_logo);
						$o['POPUP_WIDTH']=$mapsettings->extended_mapsConfigOptions['popupwidth'];
						$o['IMG_WIDTH']=$mapsettings->extended_mapsConfigOptions['img_width'];
						$o['IMG_HEIGHT']=$mapsettings->extended_mapsConfigOptions['img_height'];
						//$o['PTYPE'] = "1000";
						$pageoutput[]=$o;
	
						$tmpl = new patTemplate();
						if (using_bootstrap())
							$tmpl->setRoot( $ePointFilepath.JRDS."templates".JRDS."bootstrap" );
						else
							$tmpl->setRoot( $ePointFilepath.JRDS."templates".JRDS."jquery_ui" );
						$tmpl->readTemplatesFromInput( 'events.html');
						$tmpl->addRows( 'pageoutput',$pageoutput);
						$str=$tmpl->getParsedTemplate();
						$str = trim($str);
						$str = str_replace('\r\n', '', $str);
						$str = str_replace(chr(10), " ", $str);
						$str = str_replace(chr(13), " ", $str);
	
						$e['POPUP']=$str;
						$events[]=$e;
						unset($tmpl);
						}
					}
				}
			
			if ($show_attractions == 1)
				{
				$query = "SELECT * FROM #__jomres_local_attractions";
				$result = doSelectSql($query);
				if (count($result)>0)
					{
					foreach ($result as $res)
						{
						$a=array();
						$pageoutput=array();
						$a['LAT']=$res->latitude;
						$a['LONG']=$res->longitude;
						$a['ICON']=$eLiveSite.'markers/'.$res->icon;
						$o['PAGETITLE']=str_replace("'","`", jr_gettext('_JRPORTAL_LOCAL_ATTRACTIONS_TITLE',_JRPORTAL_LOCAL_ATTRACTIONS_TITLE,false,false));
						$o['TITLE']=str_replace("'","`", $res->title);
						$o['LAT']=$res->latitude;
						$o['LONG']=$res->longitude;
						$o['WEBSITE_URL']=trim($res->website_url);
						$o['EVENT_LOGO']=trim($res->event_logo);
						$o['POPUP_WIDTH']=$mapsettings->extended_mapsConfigOptions['popupwidth'];
						$o['IMG_WIDTH']=$mapsettings->extended_mapsConfigOptions['img_width'];
						$o['IMG_HEIGHT']=$mapsettings->extended_mapsConfigOptions['img_height'];
						//$o['PTYPE'] = "1000";
						$pageoutput[]=$o;
	
						$tmpl = new patTemplate();
						if (using_bootstrap())
							$tmpl->setRoot( $ePointFilepath.JRDS."templates".JRDS."bootstrap" );
						else
							$tmpl->setRoot( $ePointFilepath.JRDS."templates".JRDS."jquery_ui" );
						$tmpl->readTemplatesFromInput( 'attractions.html');
						$tmpl->addRows( 'pageoutput',$pageoutput);
						$str=$tmpl->getParsedTemplate();
						$str = trim($str);
						$str = str_replace('\r\n', '', $str);
						$str = str_replace(chr(10), " ", $str);
						$str = str_replace(chr(13), " ", $str);
	
						$a['POPUP']=$str;
						$attractions[]=$a;
						unset($tmpl);
						}
					}
				}
			}
		
		if (!isset($jrConfig['gmap_layer_weather']))
			{
			$jrConfig['gmap_layer_weather'] = "1";
			$jrConfig['gmap_layer_panoramio'] = "0";
			$jrConfig['gmap_layer_transit'] = "0";
			$jrConfig['gmap_layer_traffic'] = "0";
			$jrConfig['gmap_layer_bicycling'] = "0";
			$jrConfig['gmap_layer_temperature_grad'] = "CELCIUS";
			}
		
		if ($jrConfig['gmap_layer_weather'] == "1")
			$output['WEATHER_LAYER'] .='
			var weatherLayer = new google.maps.weather.WeatherLayer({
				temperatureUnits: google.maps.weather.TemperatureUnit.'.$jrConfig['gmap_layer_temperature_grad'].'
				});
				weatherLayer.setMap(map);
			';
			
		// Added, but commented out specifically because it's not a good idea to add these items to maps that cover larger areas.
/* 		if ($jrConfig['gmap_layer_panoramio'] == "1")
			$output['PANORAMIO_LAYER'] .='
				var panoramioLayer = new google.maps.panoramio.PanoramioLayer();
				panoramioLayer.setMap(map);
			';
			
			
		if ($jrConfig['gmap_layer_transit'] == "1")
			$output['TRANSIT_LAYER'] .='
				var transitLayer = new google.maps.TransitLayer();
				transitLayer.setMap(map);
			';
			
			
		if ($jrConfig['gmap_layer_traffic'] == "1")
			$output['TRAFFIC_LAYER'] .='
				var trafficLayer = new google.maps.TrafficLayer();
				trafficLayer.setMap(map);
			';
			
		if ($jrConfig['gmap_layer_bicycling'] == "1")
			$output['BICYCLING_LAYER'] .='
				var bikeLayer = new google.maps.BicyclingLayer();
				bikeLayer.setMap(map);
			'; */
//		var_dump($rows);
//die();
		if (count($rows)>0 || count($events) >0  || count($attractions)>0)
			{
			$pageoutput=array();
			$pageoutput[]=$output;
			$tmpl = new patTemplate();
			if (using_bootstrap())
				$tmpl->setRoot( $ePointFilepath.JRDS."templates".JRDS."bootstrap" );
			else
				$tmpl->setRoot( $ePointFilepath.JRDS."templates".JRDS."jquery_ui" );
			$tmpl->readTemplatesFromInput( 'extended_maps.html');
			$tmpl->addRows( 'pageoutput',$pageoutput);
			$tmpl->addRows( 'rows',$rows);
			$tmpl->addRows( 'events',$events);
			$tmpl->addRows( 'attractions',$attractions);
			$tmpl->displayParsedTemplate();
			}
		else
			echo "Ooops, you need at least one published property with latitude and longitude set before the google map will show";
		}
	
	function genericIn($idArray,$idArrayisInteger=true)
		{
		$newArr=array();
		foreach ($idArray as $id)
			{
			$newArr[]=$id;
			}
		$idArray=$newArr;
		$txt=" ( ";
		for ($i=0, $n=count($idArray); $i < $n; $i++)
			{
			if ($idArrayisInteger)
				$id=(int)$idArray[$i];
			else
				$id=$idArray[$i];
			$txt .= "'$id'";
			if ($i < count($idArray)-1)
				$txt .= ",";
			}
		$txt .= " ) ";
		return $txt;
		}

	// This must be included in every Event/Mini-component
	function getRetVals()
		{
		return null;
		}
	}
?>
