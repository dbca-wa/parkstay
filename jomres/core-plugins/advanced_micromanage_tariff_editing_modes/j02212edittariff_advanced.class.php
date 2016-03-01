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

/**
#
 * Constructs and displays edit tariff form
 #
* @package Jomres
#
 */
class j02212edittariff_advanced {
	/**
	#
	 * Constructor: Constructs and displays edit tariff form
	#
	 */
	function j02212edittariff_advanced()
		{
		// Must be in all minicomponents. Minicomponents with templates that can contain editable text should run $this->template_touch() else just return
		$MiniComponents =jomres_singleton_abstract::getInstance('mcHandler');
		if ($MiniComponents->template_touch)
			{
			$this->template_touchable=true; return;
			}
		$ePointFilepath=get_showtime('ePointFilepath');
		$mrConfig=getPropertySpecificSettings();
		$siteConfig = jomres_singleton_abstract::getInstance('jomres_config_site_singleton');
		$jrConfig=$siteConfig->get();
		if ( $mrConfig['tariffmode']=="2")
			$MiniComponents->triggerEvent('02213'); //
		else
			{
			$defaultProperty=getDefaultProperty();
		 	if ($jrConfig['useGlobalRoomTypes']=="1")
				$roomTypeSearchParameter="0";
			else
				$roomTypeSearchParameter=$defaultProperty;

			$ignore_pppn="";
			$allow_we="";
			$rate_title="";
			$rate_description="";
			$validfrom="";
			$validto="";
			$roomrateperday="";
			$mindays="";
			$maxdays="";
			$minpeople="";
			$maxpeople="";
			$maxpeople="";
			$roomclass_uid="";
			$dayofweek=0;
			$minrooms_alreadyselected = 0;
			$maxrooms_alreadyselected = 100;

			$tariffUid	= intval(jomresGetParam( $_REQUEST, 'tariffUid', 0 ) );
			$clone		= intval(jomresGetParam( $_REQUEST, 'clone', 0 ) );
			$usersProperty=getDefaultProperty();
			if (isset($tariffUid) && !empty($tariffUid) )
				{
				$query = "SELECT rate_title,rate_description,validfrom,validto,roomrateperday,mindays,maxdays,minpeople,maxpeople,roomclass_uid,ignore_pppn,allow_ph,allow_we,weekendonly,dayofweek,minrooms_alreadyselected,maxrooms_alreadyselected,property_uid  FROM #__jomres_rates WHERE rates_uid = '".(int)$tariffUid."' AND property_uid = '".(int)$defaultProperty."'";
				$tariffList =doSelectSql($query);
				foreach($tariffList as $tariff)
					{
					$ignore_pppn=$tariff->ignore_pppn;
					$allow_we=$tariff->allow_we;
					$rate_title=$tariff->rate_title;
					$rate_description= $tariff->rate_description;
					$validfrom= $tariff->validfrom;
					$validto= $tariff->validto;
					$roomrateperday= $tariff->roomrateperday;
					$mindays= $tariff->mindays;
					$maxdays= $tariff->maxdays;
					$minpeople= $tariff->minpeople;
					$maxpeople= $tariff->maxpeople;
					$maxpeople= $tariff->maxpeople;
					$roomclass_uid= $tariff->roomclass_uid;
					$weekendonly= $tariff->weekendonly;
					$dayofweek = $tariff->dayofweek;
					$minrooms_alreadyselected= $tariff->minrooms_alreadyselected;
					$maxrooms_alreadyselected = $tariff->maxrooms_alreadyselected;
					
					}
				}
			else
				{
				$ignore_pppn="0";
				$allow_we="1";
				$dayofweek = "7";
				}


			$weekDays=array();
			$weekDays[] = jomresHTML::makeOption(7, jr_gettext('_JOMRES_SEARCH_ALL',_JOMRES_SEARCH_ALL,false,false) );
			$weekDays[] = jomresHTML::makeOption(1, jr_gettext('_JOMRES_COM_MR_WEEKDAYS_MONDAY',_JOMRES_COM_MR_WEEKDAYS_MONDAY,false));
			$weekDays[] = jomresHTML::makeOption(2, jr_gettext('_JOMRES_COM_MR_WEEKDAYS_TUESDAY',_JOMRES_COM_MR_WEEKDAYS_TUESDAY,false));
			$weekDays[] = jomresHTML::makeOption(3, jr_gettext('_JOMRES_COM_MR_WEEKDAYS_WEDNESDAY',_JOMRES_COM_MR_WEEKDAYS_WEDNESDAY,false));
			$weekDays[] = jomresHTML::makeOption(4, jr_gettext('_JOMRES_COM_MR_WEEKDAYS_THURSDAY',_JOMRES_COM_MR_WEEKDAYS_THURSDAY,false));
			$weekDays[] = jomresHTML::makeOption(5, jr_gettext('_JOMRES_COM_MR_WEEKDAYS_FRIDAY',_JOMRES_COM_MR_WEEKDAYS_FRIDAY,false));
			$weekDays[] = jomresHTML::makeOption(6, jr_gettext('_JOMRES_COM_MR_WEEKDAYS_SATURDAY',_JOMRES_COM_MR_WEEKDAYS_SATURDAY,false));
			$weekDays[] = jomresHTML::makeOption(0, jr_gettext('_JOMRES_COM_MR_WEEKDAYS_SUNDAY',_JOMRES_COM_MR_WEEKDAYS_SUNDAY,false));
			$weekdayDropdown= jomresHTML::selectList($weekDays, 'dayofweek', '', 'value', 'text', $dayofweek);

			if ($clone)
				$tariffUid=FALSE;
			if ($mrConfig['singleRoomProperty'] ==  '1') 
				{
				$query = "SELECT room_classes_uid FROM #__jomres_rooms WHERE propertys_uid = '".(int)$defaultProperty."'"; 
				$original_room_classes_uid =doSelectSql($query,1); 
				$query = "SELECT room_class_abbv FROM #__jomres_room_classes WHERE `room_classes_uid` = '".$original_room_classes_uid."' ORDER BY room_class_abbv "; 
				$room_class_abbv=doSelectSql($query,1); 
				$output['ROOMTYPEDROPDOWN']='<input type="hidden" name="roomClass" value="'.$original_room_classes_uid.'" />'.$room_class_abbv; 
				}
			else
				{
				$basic_property_details =jomres_singleton_abstract::getInstance('basic_property_details');
				$basic_property_details->gather_data($usersProperty);
				$property_type_id = $basic_property_details->ptype_id;
				
				$room_classes_array = array();
				if (count($basic_property_details->this_property_room_classes)>0)
					{
					foreach ( $basic_property_details->this_property_room_classes as $key=>$val )
						{
						$room_classes_array[]= $key;
						}
					$genericOrClasses = genericOr($room_classes_array,"room_classes_uid");
					}

				$query = "SELECT room_classes_uid,room_class_abbv,room_class_full_desc,property_uid FROM #__jomres_room_classes  WHERE property_uid = '0' AND ".$genericOrClasses." ORDER BY room_class_abbv ";
				$roomClasses =doSelectSql($query);
				
				$query = "SELECT DISTINCT room_classes_uid FROM #__jomres_rooms WHERE propertys_uid = '".(int)$defaultProperty."' AND ".$genericOrClasses." ";
				$currentPropertyRoomClasses =doSelectSql($query);
				foreach ($currentPropertyRoomClasses as $currentPropertyRoomClass)
					{
					$currentPropertyRoomClassesArray[]=$currentPropertyRoomClass->room_classes_uid;
					}
				
				$dropDownList ="<select class=\"inputbox\" name=\"roomClass\">";
				//$dropDownList .= "<option value=\"\"></option>";   // Disabled so that tariff _has_ to be associated with a room type. 
				foreach ($roomClasses as $roomClass)
					{
					if (in_array($roomClass->room_classes_uid, $currentPropertyRoomClassesArray))
						{
						$selected="";
						$room_classes_uid=$roomClass->room_classes_uid;
						$room_class_abbv = jr_gettext('_JOMRES_CUSTOMTEXT_ROOMTYPES_ABBV'.(int)$roomClass->room_classes_uid,stripslashes($roomClass->room_class_abbv),false,false);
						if ($room_classes_uid==$roomclass_uid)
							$selected="selected";
						$dropDownList .= "<option ".$selected." value=\"".$room_classes_uid."\">".$room_class_abbv."</option>";
						}
					}
				$dropDownList.="</select>";
				$output['ROOMTYPEDROPDOWN']=$dropDownList;
				}
			$pppnOptions[]=jomresHTML::makeOption( '0', jr_gettext('_JOMRES_COM_MR_NO',_JOMRES_COM_MR_NO,FALSE) );
			$pppnOptions[]=jomresHTML::makeOption( '1', jr_gettext('_JOMRES_COM_MR_YES',_JOMRES_COM_MR_YES,FALSE));
			$ignoreDropdown= jomresHTML::selectList($pppnOptions, 'ignore_pppn', '', 'value', 'text', $ignore_pppn);

			$weOptions[]=jomresHTML::makeOption( '0', jr_gettext('_JOMRES_COM_MR_NO',_JOMRES_COM_MR_NO,FALSE) );
			$weOptions[]=jomresHTML::makeOption( '1', jr_gettext('_JOMRES_COM_MR_YES',_JOMRES_COM_MR_YES,FALSE));
			$allowWEDropdown= jomresHTML::selectList($weOptions, 'allow_we', '', 'value', 'text', $allow_we);

			$weoOptions[]=jomresHTML::makeOption( '0', jr_gettext('_JOMRES_COM_MR_NO',_JOMRES_COM_MR_NO,FALSE) );
			$weoOptions[]=jomresHTML::makeOption( '1', jr_gettext('_JOMRES_COM_MR_YES',_JOMRES_COM_MR_YES,FALSE));
			$weekendonlyDropdown= jomresHTML::selectList($weoOptions, 'weekendonly', '', 'value', 'text', $weekendonly);

			$output['TARIFFTITLE']=$rate_title ;
			$output['TARIFFDESC']=$rate_description ;
			$output['VALIDFROM']=generateDateInput("validfrom",$validfrom);
			$output['VALIDTO']=generateDateInput("validto",$validto);
			$output['RATEPERDAY']=$roomrateperday ;
			//$output['CURRENCY']=$mrConfig['currency'];
			$output['MINDAYS']=$mindays ;
			$output['MAXDAYS']=$maxdays ;
			$output['MINPEOPLE']=$minpeople;
			$output['MAXPEOPLE']=$maxpeople;
			
			$output['MINDAYS_DROPDOWN']=jomresHTML::integerSelectList( 0,365,1, 'mindays','', $output['MINDAYS']);
			$output['MAXDAYS_DROPDOWN']=jomresHTML::integerSelectList( 0,365,1, 'maxdays','', $output['MAXDAYS']);
			$output['MINPEOPLE_DROPDOWN']=jomresHTML::integerSelectList( 0,1000,1, 'minpeople','', $output['MINPEOPLE']);
			$output['MAXPEOPLE_DROPDOWN']=jomresHTML::integerSelectList( 0,1000,1, 'maxpeople','', $output['MAXPEOPLE']);
			
			
			$output['IGNOREPPPNDROPDOWN']=$ignoreDropdown;
			$output['ALLOWWEEKENDSDROPDOWN']=$allowWEDropdown;
			$output['WEEKENDONLY']=$weekendonlyDropdown;
			$output['DAYOFWEEK']=$weekdayDropdown;

			$output['HTARIFFTITLE']=jr_gettext('_JOMRES_COM_MR_LISTTARIFF_RATETITLE',_JOMRES_COM_MR_LISTTARIFF_RATETITLE,false);
			$output['HTARIFFDESC']=jr_gettext('_JOMRES_COM_MR_LISTTARIFF_RATEDESCRIPTION',_JOMRES_COM_MR_LISTTARIFF_RATEDESCRIPTION,false);
			$output['HVALIDFROM']=jr_gettext('_JOMRES_COM_MR_LISTTARIFF_VALIDFROM',_JOMRES_COM_MR_LISTTARIFF_VALIDFROM,false);
			$output['HVALIDTO']=jr_gettext('_JOMRES_COM_MR_LISTTARIFF_VALIDTO',_JOMRES_COM_MR_LISTTARIFF_VALIDTO,false);
			if ($mrConfig['tariffChargesStoredWeeklyYesNo']=="1")
				$output['HRATEPERDAY']=jr_gettext('_JOMRES_COM_MR_LISTTARIFF_ROOMRATEPERWEEK',_JOMRES_COM_MR_LISTTARIFF_ROOMRATEPERWEEK,false);
			else
				$output['HRATEPERDAY']=jr_gettext('_JOMRES_COM_MR_LISTTARIFF_ROOMRATEPERDAY',_JOMRES_COM_MR_LISTTARIFF_ROOMRATEPERDAY,false);
			$output['HMINDAYS']=jr_gettext('_JOMRES_COM_MR_LISTTARIFF_MINDAYS',_JOMRES_COM_MR_LISTTARIFF_MINDAYS,false);
			$output['HMAXDAYS']=jr_gettext('_JOMRES_COM_MR_LISTTARIFF_MAXDAYS',_JOMRES_COM_MR_LISTTARIFF_MAXDAYS,false);
			$output['HMINPEOPLE']=jr_gettext('_JOMRES_COM_MR_LISTTARIFF_MINPEOPLE',_JOMRES_COM_MR_LISTTARIFF_MINPEOPLE,false);
			$output['HMAXPEOPLE']=jr_gettext('_JOMRES_COM_MR_LISTTARIFF_MAXPEOPLE',_JOMRES_COM_MR_LISTTARIFF_MAXPEOPLE,false);
			$output['HROOMTYPEDROPDOWN']=jr_gettext('_JOMRES_COM_MR_LISTTARIFF_ROOMCLASS',_JOMRES_COM_MR_LISTTARIFF_ROOMCLASS,false);
			$output['HIGNOREPPPNDROPDOWN']=jr_gettext('_JOMRES_COM_MR_LISTTARIFF_IGNOREPPN',_JOMRES_COM_MR_LISTTARIFF_IGNOREPPN,false);
			$output['HALLOWWEEKENDSDROPDOWN']=jr_gettext('_JOMRES_COM_MR_LISTTARIFF_ALLOWWE',_JOMRES_COM_MR_LISTTARIFF_ALLOWWE,false);
			$output['HWEEKENDONLY']=jr_gettext('_JOMRES_COM_WEEKENDONLY',_JOMRES_COM_WEEKENDONLY,false);
			$output['HDAYOFWEEK']=jr_gettext('_JOMRES_COM_MR_VIEWBOOKINGS_ARRIVAL',_JOMRES_COM_MR_VIEWBOOKINGS_ARRIVAL)." ".jr_gettext('_JOMRES_DTV_DOW',_JOMRES_DTV_DOW,false);

			if ($mrConfig['singleRoomProperty']!="1")
				{
				$already_selected = array();
				$as=array();
				$as['MINROOMS_ALREADYSELECTED']=jomresHTML::integerSelectList( 0,100,1, 'minrooms_alreadyselected','', $minrooms_alreadyselected);
				$as['MAXROOMS_ALREADYSELECTED']=jomresHTML::integerSelectList( 0,100,1, 'maxrooms_alreadyselected','', $maxrooms_alreadyselected);
				$as['HMINROOMS']=jr_gettext('_JOMRES_COM_MR_EB_ROOM_MINROOMS',_JOMRES_COM_MR_EB_ROOM_MINROOMS,false);
				$as['HMAXROOMS']=jr_gettext('_JOMRES_COM_MR_EB_ROOM_MAXROOMS',_JOMRES_COM_MR_EB_ROOM_MAXROOMS,false);
				$as['MINROOMS_DESC']=jr_gettext('_JOMRES_COM_MR_EB_ROOM_MINROOMS_DESC',_JOMRES_COM_MR_EB_ROOM_MINROOMS_DESC,false);
				$as['MAXROOMS_DESC']=jr_gettext('_JOMRES_COM_MR_EB_ROOM_MAXROOMS_DESC',_JOMRES_COM_MR_EB_ROOM_MAXROOMS_DESC,false);
				$already_selected[]=$as;
				}
			
			$output['tariffuid']=$tariffUid;

			$cancelText=jr_gettext('_JOMRES_COM_A_CANCEL',_JOMRES_COM_A_CANCEL,FALSE);
			$deleteText=jr_gettext('_JOMRES_COM_MR_ROOM_DELETE',_JOMRES_COM_MR_ROOM_DELETE,FALSE);
			$jrtbar =jomres_singleton_abstract::getInstance('jomres_toolbar');
			$jrtb  = $jrtbar->startTable();
			$jrtb .= $jrtbar->toolbarItem('save',jomresURL(JOMRES_SITEPAGE_URL."&task=saveTariff"),jr_gettext('_JOMRES_COM_MR_SAVE',_JOMRES_COM_MR_SAVE,FALSE),true,'saveTariff');
			$jrtb .= $jrtbar->toolbarItem('cancel',jomresURL(JOMRES_SITEPAGE_URL."&task=propertyadmin"),$cancelText);
			if (!$clone && $tariffUid)
				$jrtb .= $jrtbar->toolbarItem('delete',jomresURL(JOMRES_SITEPAGE_URL."&task=deleteTariff&tariffUid=".$tariffUid),$deleteText);
			$jrtb .= $jrtbar->endTable();
			$output['JOMRESTOOLBAR']=$jrtb;

			$output['pagetitle']=jr_gettext('_JOMRES_COM_MR_LISTTARIFF_TITLE_EDIT',_JOMRES_COM_MR_LISTTARIFF_TITLE_EDIT,false);

			$output['JOMRES_SITEPAGE_URL']=JOMRES_SITEPAGE_URL;
			
			$pageoutput[]=$output;
			$tmpl = new patTemplate();
			if (using_bootstrap())
				$tmpl->setRoot( $ePointFilepath.'templates'.JRDS.'bootstrap' );
			else
				$tmpl->setRoot( $ePointFilepath.'templates'.JRDS.'jquery_ui' );
			$tmpl->readTemplatesFromInput( 'edit_advanced_tariff.html');
			$tmpl->addRows( 'already_selected',$already_selected);
			$tmpl->addRows( 'pageoutput',$pageoutput);
			$tmpl->displayParsedTemplate();
			}
		}

	function touch_template_language()
		{
		$output=array();
		$output[]		=jr_gettext('_JOMRES_COM_MR_LISTTARIFF_RATETITLE',_JOMRES_COM_MR_LISTTARIFF_RATETITLE);
		$output[]		=jr_gettext('_JOMRES_COM_MR_LISTTARIFF_RATEDESCRIPTION',_JOMRES_COM_MR_LISTTARIFF_RATEDESCRIPTION);
		$output[]		=jr_gettext('_JOMRES_COM_MR_LISTTARIFF_VALIDFROM',_JOMRES_COM_MR_LISTTARIFF_VALIDFROM);
		$output[]		=jr_gettext('_JOMRES_COM_MR_LISTTARIFF_VALIDTO',_JOMRES_COM_MR_LISTTARIFF_VALIDTO);
		$output[]		=jr_gettext('_JOMRES_COM_MR_LISTTARIFF_ROOMRATEPERDAY',_JOMRES_COM_MR_LISTTARIFF_ROOMRATEPERDAY);
		$output[]		=jr_gettext('_JOMRES_COM_MR_LISTTARIFF_MINDAYS',_JOMRES_COM_MR_LISTTARIFF_MINDAYS);
		$output[]		=jr_gettext('_JOMRES_COM_MR_LISTTARIFF_MAXDAYS',_JOMRES_COM_MR_LISTTARIFF_MAXDAYS);
		$output[]		=jr_gettext('_JOMRES_COM_MR_LISTTARIFF_MINPEOPLE',_JOMRES_COM_MR_LISTTARIFF_MINPEOPLE);
		$output[]		=jr_gettext('_JOMRES_COM_MR_LISTTARIFF_MAXPEOPLE',_JOMRES_COM_MR_LISTTARIFF_MAXPEOPLE);
		$output[]		=jr_gettext('_JOMRES_COM_MR_LISTTARIFF_ROOMCLASS',_JOMRES_COM_MR_LISTTARIFF_ROOMCLASS);
		$output[]		=jr_gettext('_JOMRES_COM_MR_LISTTARIFF_IGNOREPPN',_JOMRES_COM_MR_LISTTARIFF_IGNOREPPN);
		$output[]		=jr_gettext('_JOMRES_COM_MR_LISTTARIFF_ALLOWWE',_JOMRES_COM_MR_LISTTARIFF_ALLOWWE);
		$output[]		=jr_gettext('_JOMRES_COM_WEEKENDONLY',_JOMRES_COM_WEEKENDONLY);

		foreach ($output as $o)
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