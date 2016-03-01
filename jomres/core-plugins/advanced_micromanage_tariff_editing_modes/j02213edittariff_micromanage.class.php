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
class j02213edittariff_micromanage {
	/**
	#
	 * Constructor: Constructs and displays edit tariff form
	#
	 */
	function j02213edittariff_micromanage()
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
		$defaultProperty=getDefaultProperty();
	 	if ($jrConfig['useGlobalRoomTypes']=="1")
			$roomTypeSearchParameter="0";
		else
			$roomTypeSearchParameter=$defaultProperty;
		if (!isset($mrConfig['tariffsenhanceddefault']))
			$defaultTariffValue=100.55;
		else
			$defaultTariffValue=$mrConfig['tariffsenhanceddefault'];
		
		$defaultMinDays = 1;
		
		if (!isset($mrConfig['tariffsenhancedyearstoshow']))
			$numberOfYearsToGenerate=2;
		else
			$numberOfYearsToGenerate=$mrConfig['tariffsenhancedyearstoshow'];

		$tarifftypeid	= intval(jomresGetParam( $_REQUEST, 'tarifftypeid', 0 ) );
		$clone			= intval(jomresGetParam( $_REQUEST, 'clone', 0 ) );

		// security check
		if ($tarifftypeid > 0)
			{
			$query="SELECT `name` FROM #__jomcomp_tarifftypes WHERE id = '$tarifftypeid' AND property_uid = '$defaultProperty' ";
			$result=doSelectSql($query);
			if (count($result) == 0)
				trigger_error ("Unable to update tariff details, incorrect tarifftype id / property uid combination. Possible hack attempt", E_USER_ERROR);
			}
		$output['HTARIFFTITLE']=jr_gettext('_JOMRES_COM_MR_LISTTARIFF_RATETITLE',_JOMRES_COM_MR_LISTTARIFF_RATETITLE,false);
		$output['HMINDAYS']=jr_gettext('_JOMRES_COM_MR_LISTTARIFF_MINDAYS',_JOMRES_COM_MR_LISTTARIFF_MINDAYS,false);
		$output['HMAXDAYS']=jr_gettext('_JOMRES_COM_MR_LISTTARIFF_MAXDAYS',_JOMRES_COM_MR_LISTTARIFF_MAXDAYS,false);
		$output['HMINPEOPLE']=jr_gettext('_JOMRES_COM_MR_LISTTARIFF_MINPEOPLE',_JOMRES_COM_MR_LISTTARIFF_MINPEOPLE,false);
		$output['HMAXPEOPLE']=jr_gettext('_JOMRES_COM_MR_LISTTARIFF_MAXPEOPLE',_JOMRES_COM_MR_LISTTARIFF_MAXPEOPLE,false);
		$output['HROOMTYPEDROPDOWN']=jr_gettext('_JOMRES_COM_MR_LISTTARIFF_ROOMCLASS',_JOMRES_COM_MR_LISTTARIFF_ROOMCLASS,false);
		$output['HIGNOREPPPNDROPDOWN']=jr_gettext('_JOMRES_COM_MR_LISTTARIFF_IGNOREPPN',_JOMRES_COM_MR_LISTTARIFF_IGNOREPPN,false);
		$output['HALLOWWEEKENDSDROPDOWN']=jr_gettext('_JOMRES_COM_MR_LISTTARIFF_ALLOWWE',_JOMRES_COM_MR_LISTTARIFF_ALLOWWE,false);
		$output['HWEEKENDONLY']=jr_gettext('_JOMRES_COM_WEEKENDONLY',_JOMRES_COM_WEEKENDONLY,false);
		
		$output['PICKER_DAYSOFWEEK']=jr_gettext('_JOMRES_MICROMANAGE_PICKER_DAYSOFWEEK',_JOMRES_MICROMANAGE_PICKER_DAYSOFWEEK,false);
		$output['PICKER_DATERANGES']=jr_gettext('_JOMRES_MICROMANAGE_PICKER_DATERANGES',_JOMRES_MICROMANAGE_PICKER_DATERANGES,false);
		$output['PICKER_DATERANGES_START']=jr_gettext('_JOMRES_MICROMANAGE_PICKER_DATERANGES_START',_JOMRES_MICROMANAGE_PICKER_DATERANGES_START,false);
		$output['PICKER_DATERANGES_END']=jr_gettext('_JOMRES_MICROMANAGE_PICKER_DATERANGES_END',_JOMRES_MICROMANAGE_PICKER_DATERANGES_END,false);
		$output['PICKER_DATERANGES_RATE']=jr_gettext('_JOMRES_MICROMANAGE_PICKER_DATERANGES_RATE',_JOMRES_MICROMANAGE_PICKER_DATERANGES_RATE,false);
		$output['PICKER_DATERANGES_SET']=jr_gettext('_JOMRES_MICROMANAGE_PICKER_DATERANGES_SET',_JOMRES_MICROMANAGE_PICKER_DATERANGES_SET,false,false);
		$output['_JOMRES_COM_MR_LISTTARIFF_LINKTEXT']=jr_gettext('_JOMRES_COM_MR_LISTTARIFF_LINKTEXT',_JOMRES_COM_MR_LISTTARIFF_LINKTEXT,false);
		
		$output['_JOMRES_MICROMANAGE_PICKERDROPDOWN_EDITPRICES']=jr_gettext('_JOMRES_MICROMANAGE_PICKERDROPDOWN_EDITPRICES',_JOMRES_MICROMANAGE_PICKERDROPDOWN_EDITPRICES,false);
		$output['_JOMRES_MICROMANAGE_PICKERDROPDOWN_EDITMINDAYS']=jr_gettext('_JOMRES_MICROMANAGE_PICKERDROPDOWN_EDITMINDAYS',_JOMRES_MICROMANAGE_PICKERDROPDOWN_EDITMINDAYS,false);
		$output['_JOMRES_MICROMANAGE_PICKER_SETMINDAYS']=jr_gettext('_JOMRES_MICROMANAGE_PICKER_SETMINDAYS',_JOMRES_MICROMANAGE_PICKER_SETMINDAYS,false);
		$output['_JOMRES_MICROMANAGE_PICKER_TYPE_DOW']=jr_gettext('_JOMRES_MICROMANAGE_PICKER_TYPE_DOW',_JOMRES_MICROMANAGE_PICKER_TYPE_DOW,false);
		$output['_JOMRES_MICROMANAGE_PICKER_TYPE_INTERVAL_RATES']=jr_gettext('_JOMRES_MICROMANAGE_PICKER_TYPE_INTERVAL_RATES',_JOMRES_MICROMANAGE_PICKER_TYPE_INTERVAL_RATES,false);
		$output['_JOMRES_MICROMANAGE_PICKER_TYPE_INTERVAL_MINDAYS']=jr_gettext('_JOMRES_MICROMANAGE_PICKER_TYPE_INTERVAL_MINDAYS',_JOMRES_MICROMANAGE_PICKER_TYPE_INTERVAL_MINDAYS,false);
		$output['_JOMRES_MICROMANAGE_PICKER_INSTRUCTIONS_RATES']=jr_gettext('_JOMRES_MICROMANAGE_PICKER_INSTRUCTIONS_RATES',_JOMRES_MICROMANAGE_PICKER_INSTRUCTIONS_RATES,false);
		$output['_JOMRES_MICROMANAGE_PICKER_INSTRUCTIONS_MINDAYS']=jr_gettext('_JOMRES_MICROMANAGE_PICKER_INSTRUCTIONS_MINDAYS',_JOMRES_MICROMANAGE_PICKER_INSTRUCTIONS_MINDAYS,false);
		$output['_JOMRES_MICROMANAGE_PICKERS_SELECTOR_INFO']=jr_gettext('_JOMRES_MICROMANAGE_PICKERS_SELECTOR_INFO',_JOMRES_MICROMANAGE_PICKERS_SELECTOR_INFO,false);
		$output['_JOMRES_MICROMANAGE_PICKERS_SELECTOR']=jr_gettext('_JOMRES_MICROMANAGE_PICKERS_SELECTOR',_JOMRES_MICROMANAGE_PICKERS_SELECTOR,false);
		
		$output['_JOMRES_MICROMANAGE_PICKER_BYDOW']=jr_gettext('_JOMRES_MICROMANAGE_PICKER_BYDOW',_JOMRES_MICROMANAGE_PICKER_BYDOW,false);
		$output['_JOMRES_MICROMANAGE_PICKER_BYDOW_INFO']=jr_gettext('_JOMRES_MICROMANAGE_PICKER_BYDOW_INFO',_JOMRES_MICROMANAGE_PICKER_BYDOW_INFO,false);
		
		
		$output['HFIXED_DAYOFWEEK']=jr_gettext('_JOMRES_COM_MR_VIEWBOOKINGS_ARRIVAL',_JOMRES_COM_MR_VIEWBOOKINGS_ARRIVAL)." ".jr_gettext('_JOMRES_DTV_DOW',_JOMRES_DTV_DOW,false);
		
		$def_mindays=1;
		$def_maxdays=100;
		$def_minpeople=1;
		$def_maxpeople=100;
		$def_roomclass_uid=1;
		$def_tarifftypename="Change me";
		$def_we=1;
		$def_ignore_pppn=0;
		$def_minrooms_alreadyselected = 0;
		$def_maxrooms_alreadyselected = 100;
		$def_weekendonly=0;

		$already_selected = array();
		if ($mrConfig['singleRoomProperty'] ==  '0') 
			{
			$already_selected['HMINROOMS']=jr_gettext('_JOMRES_COM_MR_EB_ROOM_MINROOMS',_JOMRES_COM_MR_EB_ROOM_MINROOMS,false);
			$already_selected['HMAXROOMS']=jr_gettext('_JOMRES_COM_MR_EB_ROOM_MAXROOMS',_JOMRES_COM_MR_EB_ROOM_MAXROOMS,false);
			$already_selected['MINROOMS_DESC']=jr_gettext('_JOMRES_COM_MR_EB_ROOM_MINROOMS_DESC',_JOMRES_COM_MR_EB_ROOM_MINROOMS_DESC,false);
			$already_selected['MAXROOMS_DESC']=jr_gettext('_JOMRES_COM_MR_EB_ROOM_MAXROOMS_DESC',_JOMRES_COM_MR_EB_ROOM_MAXROOMS_DESC,false);
			}
		
		//$weekendsArray=array('monday'=>false,'tuesday'=>false,'wednesday'=>false,'thursday'=>false,'friday'=>false,'saturday'=>true,'sunday'=>true);
		$allow_we=$def_we;
		$ignore_pppn=$def_ignore_pppn;
		//Let's get the current tarifftype details, and find the first tariff of this type so that we can get the min & max people and min and max days
		if ($tarifftypeid > 0)
			{
			$query="SELECT `name` FROM #__jomcomp_tarifftypes WHERE id = '$tarifftypeid' AND property_uid = '$defaultProperty' ";
			$output['TARIFFTYPENAME']=doSelectSql($query,1);
			$rateIdArray=array();
			$query="SELECT tariff_id FROM #__jomcomp_tarifftype_rate_xref WHERE tarifftype_id = '$tarifftypeid'";
			$rateIds=doSelectSql($query);
			foreach ($rateIds as $r)
				{
				$rateIdArray[]=$r->tariff_id;
				}
			$gor=genericOr($rateIdArray,'rates_uid');
			$query="SELECT * FROM #__jomres_rates WHERE ".$gor."";
			$rates=doSelectSql($query);
			$rateDetails=array();
			foreach ($rates as $r)
				{
				$output['MINDAYS']=$r->mindays;
				$output['MAXDAYS']=$r->maxdays;
				$output['MINPEOPLE']=$r->minpeople;
				$output['MAXPEOPLE']=$r->maxpeople;
				$already_selected['MINROOMS_ALREADYSELECTED']=jomresHTML::integerSelectList( 0,100,1, 'minrooms_alreadyselected','class="inputbox" size="1"', $r->minrooms_alreadyselected);
				$already_selected['MAXROOMS_ALREADYSELECTED']=jomresHTML::integerSelectList( 0,100,1, 'maxrooms_alreadyselected','class="inputbox" size="1"', $r->maxrooms_alreadyselected);
				$ignore_pppn=$r->ignore_pppn;
				$allow_we=$r->allow_we;
				$weekendonly= $r->weekendonly;
				$roomclassid=$r->roomclass_uid;
				$rateDetails[$r->rates_uid]=array(
					'validFrom'=>$r->validfrom,
					'validTo'=>$r->validto,
					'roomrateperday'=>$r->roomrateperday,
					'mindays'=>$r->mindays,
					'maxdays'=>$r->maxdays,
					'minpeople'=>$r->minpeople,
					'maxpeople'=>$r->maxpeople,
					'roomclass_uid'=>$r->roomclass_uid,
					'ignore_pppn'=>$r->ignore_pppn,
					'allow_we'=>$r->allow_we
					);
				$fixed_dayofweek=$r->dayofweek;
				}
			$this->rateDetails=$rateDetails;
			}
		else
			{
			$output['TARIFFTYPENAME']=$def_tarifftypename;
			$output['MINDAYS']=$def_mindays;
			$output['MAXDAYS']=$def_maxdays;
			$output['MINPEOPLE']=$def_minpeople;
			$output['MAXPEOPLE']=$def_maxpeople;
			$already_selected['MINROOMS_ALREADYSELECTED']=jomresHTML::integerSelectList( 0,100,1, 'minrooms_alreadyselected','class="inputbox" size="1"', $def_minrooms_alreadyselected);
			$already_selected['MAXROOMS_ALREADYSELECTED']=jomresHTML::integerSelectList( 0,100,1, 'maxrooms_alreadyselected','class="inputbox" size="1"', $def_maxrooms_alreadyselected);
			$roomclassid=$def_roomclass_uid;
			$weekendonly=$def_weekendonly;
			}
			
		$output['MINDAYS_DROPDOWN']=jomresHTML::integerSelectList( 0,365,1, 'mindays','', $output['MINDAYS']);
		$output['MAXDAYS_DROPDOWN']=jomresHTML::integerSelectList( 0,365,1, 'maxdays','', $output['MAXDAYS']);
		$output['MINPEOPLE_DROPDOWN']=jomresHTML::integerSelectList( 0,1000,1, 'minpeople','', $output['MINPEOPLE']);
		$output['MAXPEOPLE_DROPDOWN']=jomresHTML::integerSelectList( 0,1000,1, 'maxpeople','', $output['MAXPEOPLE']);
				
		$pppnOptions[]=jomresHTML::makeOption( '0', jr_gettext('_JOMRES_COM_MR_NO',_JOMRES_COM_MR_NO,FALSE) );
		$pppnOptions[]=jomresHTML::makeOption( '1', jr_gettext('_JOMRES_COM_MR_YES',_JOMRES_COM_MR_YES,FALSE));
		$ignoreDropdown= jomresHTML::selectList($pppnOptions, 'ignore_pppn', 'class="inputbox" size="1"', 'value', 'text', $ignore_pppn);

		$weOptions[]=jomresHTML::makeOption( '0', jr_gettext('_JOMRES_COM_MR_NO',_JOMRES_COM_MR_NO,FALSE) );
		$weOptions[]=jomresHTML::makeOption( '1', jr_gettext('_JOMRES_COM_MR_YES',_JOMRES_COM_MR_YES,FALSE));
		$allowWEDropdown= jomresHTML::selectList($weOptions, 'allow_we', 'class="inputbox" size="1"', 'value', 'text', $allow_we);

		$weoOptions[]=jomresHTML::makeOption( '0', jr_gettext('_JOMRES_COM_MR_NO',_JOMRES_COM_MR_NO,FALSE) );
		$weoOptions[]=jomresHTML::makeOption( '1', jr_gettext('_JOMRES_COM_MR_YES',_JOMRES_COM_MR_YES,FALSE));
		$weekendonlyDropdown= jomresHTML::selectList($weoOptions, 'weekendonly', 'class="inputbox" size="1"', 'value', 'text', $weekendonly);
		
		$output['IGNOREPPPNDROPDOWN']=$ignoreDropdown;
		$output['ALLOWWEEKENDSDROPDOWN']=$allowWEDropdown;
		$output['WEEKENDONLY']=$weekendonlyDropdown;
		
		$def_roomrateperday=$defaultTariffValue;

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
			$basic_property_details->gather_data($defaultProperty);
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
					if ($room_classes_uid==$roomclassid)
						$selected="selected";
					$dropDownList .= "<option ".$selected." value=\"".$room_classes_uid."\">".$room_class_abbv."</option>";
					}
				}
			$dropDownList.="</select>";
			$output['ROOMTYPEDROPDOWN']=$dropDownList;
			}
			
		// Let's make our years/months/days array
		$dowInitArrays=array();
		$today = getdate();
		$firstYear=$today['year'];
		$firstMonth=$today['mon'];
		$todaysepoch=$today[0];
		$firstOfJan=strtotime("1 January $firstYear");
		$datesInyearsArray = array();
		$currdate=getdate($firstOfJan);
		$currMonth=1;
		date_default_timezone_set('UTC'); // Must be left in place, without it the date range selectors will not work properly on servers with different timezones.
		for ($y = 0;$y <$numberOfYearsToGenerate;$y++)
			{
			$currYear=$firstYear+$y;
			for ($m = 1;$m <=12;$m++)
				{
				if ( ($m >= $firstMonth && $currYear ==$firstYear ) || $currYear >$firstYear )
					{
					$currMonth=date("m",mktime(0, 0, 0, $m,1,$currYear));
					$daysInMonth= date("t",mktime(0, 0, 0, $m,1,$currYear));

					for ($d = 1;$d <=$daysInMonth;$d++)
						{
						$day= date("d",mktime(0, 0, 0, $currMonth,$d,$currYear));
						$epoch=mktime(0,0,0,$currMonth,$day,$currYear);
						$dow=getdate($epoch);
						$dayofweek=$dow['weekday'];
						$fontcolour="black";

						if ($tarifftypeid > 0)
							{
							$datesInyearsArray[$currYear][$currMonth][$day]['value']=$this->getValueForTariffThisDate($epoch);
							$datesInyearsArray[$currYear][$currMonth][$day]['mindays']=$this->getMinintervalForTariffThisDate($epoch);
							}
						else
							{
							$datesInyearsArray[$currYear][$currMonth][$day]['value']=$defaultTariffValue;
							$datesInyearsArray[$currYear][$currMonth][$day]['mindays']=$defaultMinDays;
							}
						
						if ($datesInyearsArray[$currYear][$currMonth][$day]['value'] != $defaultTariffValue)
							$fontcolour="red";
						if ($epoch<$todaysepoch)
							$fontcolour="grey";
						$dowInit=substr($dayofweek,0,2);
						
						switch ($dowInit)
							{
							case "Su": $dowInit = jr_gettext("_JOMRES_COM_MR_WEEKDAYS_SUNDAY_ABBR",_JOMRES_COM_MR_WEEKDAYS_SUNDAY_ABBR,false); break;
							case "Mo": $dowInit = jr_gettext("_JOMRES_COM_MR_WEEKDAYS_MONDAY_ABBR",_JOMRES_COM_MR_WEEKDAYS_MONDAY_ABBR,false); break;
							case "Tu": $dowInit = jr_gettext("_JOMRES_COM_MR_WEEKDAYS_TUESDAY_ABBR",_JOMRES_COM_MR_WEEKDAYS_TUESDAY_ABBR,false); break;
							case "We": $dowInit = jr_gettext("_JOMRES_COM_MR_WEEKDAYS_WEDNESDAY_ABBR",_JOMRES_COM_MR_WEEKDAYS_WEDNESDAY_ABBR,false); break;
							case "Th": $dowInit = jr_gettext("_JOMRES_COM_MR_WEEKDAYS_THURSDAY_ABBR",_JOMRES_COM_MR_WEEKDAYS_THURSDAY_ABBR,false); break;
							case "Fr": $dowInit = jr_gettext("_JOMRES_COM_MR_WEEKDAYS_FRIDAY_ABBR",_JOMRES_COM_MR_WEEKDAYS_FRIDAY_ABBR,false); break;
							case "Sa": $dowInit = jr_gettext("_JOMRES_COM_MR_WEEKDAYS_SATURDAY_ABBR",_JOMRES_COM_MR_WEEKDAYS_SATURDAY_ABBR,false); break;
							}

						if ($dayofweek=="Saturday" || $dayofweek=="Sunday")
							$datesInyearsArray[$currYear][$currMonth][$day]['dom']='<font color="'.$fontcolour.'"><b>'.$dowInit.' '.$day.'</b></font>';
						else
							$datesInyearsArray[$currYear][$currMonth][$day]['dom']='<font color="'.$fontcolour.'">'.$dowInit.' '.$day.'</font>';
						$datesInyearsArray[$currYear][$currMonth][$day]['class']="jomres_te_".$dowInit;
						if (!in_array("jomres_te_".$dowInit,$dowInitArrays) )
							$dowInitArrays["jomres_te_".$dowInit]=array("class"=>"jomres_te_".$dowInit,"text"=>$dowInit,"dom"=>$datesInyearsArray[$currYear][$currMonth][$day]['dom']);
						$datesInyearsArray[$currYear][$currMonth][$day]['epoch']=$epoch;
						}
					}
				}
			}
		$def_validfrom=date("Y/m/d",$datesInyearsArray[$firstYear]['01']['01']['epoch']);
		$def_validto=date("Y/m/d",$datesInyearsArray[$currYear]['12']['31']['epoch']);
		$yearrows=array();

		// Let's generate our autofil buttons & inputs
		$prefills=array();
		$prefillbuttons=array();
		$styleinfo='style="padding: 1px; font-size: 9px;border:solid 1px #cccccc; background-color: #ffffff;';

		foreach ($dowInitArrays as $dia)
			{
			$p=array();
			//$pb=array();
			$p["BUTTON"]='
				<input type="button" class="btn tariff_multi_input"  id="'.$dia['class'].'" value="'.$dia['text'].'" onClick="set_rates_by_dow(\''.$dia['class'].'\')" />
				<input type="button" class="btn mindays_multi_input" id="'.$dia['class'].'" value="'.$dia['text'].'" onClick="set_mindays_by_dow(\''.$dia['class'].'\')"  style="display:none" />
				';
			//$p["BUTTON"]=$pb["BUTTON"];
			$p["DOW"]=$dia['text'];
			if (!using_bootstrap())
				$p["INPUT"]='
					<input class="'.$dia['class'].'_rates   tariff_multi_input"  type="number" '.$styleinfo.'" size="8"  name="'.$dia['class'].'_rates" value="'.$defaultTariffValue.'" />
					<input class="'.$dia['class'].'_mindays mindays_multi_input" type="number" '.$styleinfo.' display:none" size="8"  name="'.$dia['class'].'_mindays" value="'.$defaultMinDays.'" />
					';
			else
				$p["INPUT"]='
					<input class="'.$dia['class'].'_rates   input-small tariff_multi_input"  type="number" step="any" min="0" name="'.$dia['class'].'_rates" value="'.$defaultTariffValue.'" />
					<input class="'.$dia['class'].'_mindays input-small mindays_multi_input" type="number" step="any" min="0"  name="'.$dia['class'].'_mindays" value="'.$defaultMinDays.'"  style="display:none"/>
					';
			//$p["CLASS"]=$dia['class'];

			$prefills[]=$p;
			//$prefillbuttons[]=$pb;

			}

			
		$output['PICKER_FROM']=generateDateInput("picker_from","");
		$output['PICKER_TO']=generateDateInput("picker_to","");
		$output['DATE_FORMAT']=$jrConfig['cal_input'];

		foreach ($datesInyearsArray as $ykey=>$y)
			{
			foreach ($y as $mkey=>$m)
				{
				$dr=array();
				$dr['YEAR']=$ykey;
				$dr['MONTH']=$mkey;
				$days1="";
				$inputs1="";
				$days2="";
				$inputs2="";
				foreach ($m as $dkey=>$d)
					{
					if ($dkey<=15)
						{
						$days1.='<td>'.$d['dom'].'</td>';
						if (!using_bootstrap())
							{
							$inputs1.='
								<td>
									<input type="text" size="3" class="'.$d['class'].'_rates tariff_multi_input" style="padding: 1px; font-size: 9px;border:solid 1px #cccccc; background-color: #ffffff;" name="tariffinput['.$d['epoch'].']" value="'.$d['value'].'" />
									<input type="text" size="3" class="'.$d['class'].'_mindays mindays_multi_input" style="padding: 1px; font-size: 9px;border:solid 1px #cccccc; background-color: #ffffff; display:none;" name="mindaysinput['.$d['epoch'].']" value="'.$d['mindays'].'" />
								</td>';
							}
						else
							{
							$inputs1.='
							<td>
								<input type="number" class="'.$d['class'].'_rates input-mini tariff_multi_input" style="padding: 1px; width:90%;font-size: 9px;" name="tariffinput['.$d['epoch'].']" value="'.$d['value'].'" />
								<input type="number" class="'.$d['class'].'_mindays input-mini mindays_multi_input" style="padding: 1px; width:90%;font-size: 9px; display:none" name="mindaysinput['.$d['epoch'].']" value="'.$d['mindays'].'" />
							</td>';
							}
						}
					else
						{
						$days2.='<td>'.$d['dom'].'</td>';
						if (!using_bootstrap())
							{
							$inputs2.='
								<td>
									<input type="text" size="3" class="'.$d['class'].'_rates tariff_multi_input" style="padding: 1px; font-size: 9px;border:solid 1px #cccccc; background-color: #ffffff;" name="tariffinput['.$d['epoch'].']" value="'.$d['value'].'" />
									<input type="text" size="3" class="'.$d['class'].'_mindays mindays_multi_input" style="padding: 1px; font-size: 9px;border:solid 1px #cccccc; background-color: #ffffff;display:none;" name="mindaysinput['.$d['epoch'].']" value="'.$d['mindays'].'" />
								</td>';
							}
						else
							{
							
							$inputs2.='
							<td>
								<input type="number" class="'.$d['class'].'_rates input-mini tariff_multi_input" style="padding: 1px;width:90%;font-size: 9px;" name="tariffinput['.$d['epoch'].']" value="'.$d['value'].'" />
								<input type="number" class="'.$d['class'].'_mindays input-mini mindays_multi_input" style="padding: 1px;width:90%;font-size: 9px; display:none" name="mindaysinput['.$d['epoch'].']" value="'.$d['mindays'].'" />
							</td>';
							}
						
						}
					}
				$dr['DAYS1']=$days1;
				$dr['INPUTS1']=$inputs1;
				$dr['DAYS2']=$days2;
				$dr['INPUTS2']=$inputs2;
				$daterows[]=$dr;
				}
			}
		if ($clone < 1)
			$output['TARIFFTYPEID']	= $tarifftypeid;
		else
			$output['TARIFFTYPEID']	= 0;


		$cancelText=jr_gettext('_JOMRES_COM_A_CANCEL',_JOMRES_COM_A_CANCEL,FALSE);
		$deleteText=jr_gettext('_JOMRES_COM_MR_ROOM_DELETE',_JOMRES_COM_MR_ROOM_DELETE,FALSE);

		if (!isset($fixed_dayofweek))
			$fixed_dayofweek = 7;
		
		$weekDays=array();
		$weekDays[] = jomresHTML::makeOption(7, jr_gettext('_JOMRES_SEARCH_ALL',_JOMRES_SEARCH_ALL,false,false) );
		$weekDays[] = jomresHTML::makeOption(1, jr_gettext("_JOMRES_COM_MR_WEEKDAYS_MONDAY",_JOMRES_COM_MR_WEEKDAYS_MONDAY));
		$weekDays[] = jomresHTML::makeOption(2, jr_gettext("_JOMRES_COM_MR_WEEKDAYS_TUESDAY",_JOMRES_COM_MR_WEEKDAYS_TUESDAY));
		$weekDays[] = jomresHTML::makeOption(3, jr_gettext("_JOMRES_COM_MR_WEEKDAYS_WEDNESDAY",_JOMRES_COM_MR_WEEKDAYS_WEDNESDAY));
		$weekDays[] = jomresHTML::makeOption(4, jr_gettext("_JOMRES_COM_MR_WEEKDAYS_THURSDAY",_JOMRES_COM_MR_WEEKDAYS_THURSDAY));
		$weekDays[] = jomresHTML::makeOption(5, jr_gettext("_JOMRES_COM_MR_WEEKDAYS_FRIDAY",_JOMRES_COM_MR_WEEKDAYS_FRIDAY));
		$weekDays[] = jomresHTML::makeOption(6, jr_gettext("_JOMRES_COM_MR_WEEKDAYS_SATURDAY",_JOMRES_COM_MR_WEEKDAYS_SATURDAY));
		$weekDays[] = jomresHTML::makeOption(0, jr_gettext("_JOMRES_COM_MR_WEEKDAYS_SUNDAY",_JOMRES_COM_MR_WEEKDAYS_SUNDAY));
		$weekdayDropdown= jomresHTML::selectList($weekDays, 'fixed_dayofweek', 'class="inputbox" size="1"', 'value', 'text', $fixed_dayofweek);
		$output['FIXED_ARRIVAL_DAYOFWEEK']=$weekdayDropdown;

		$jrtbar =jomres_singleton_abstract::getInstance('jomres_toolbar');
		$jrtb  = $jrtbar->startTable();
		$jrtb .= $jrtbar->toolbarItem('save',jomresURL(JOMRES_SITEPAGE_URL."&task=saveTariff"),jr_gettext('_JOMRES_COM_MR_SAVE',_JOMRES_COM_MR_SAVE,FALSE),true,'saveTariff');
		$jrtb .= $jrtbar->toolbarItem('cancel',jomresURL(JOMRES_SITEPAGE_URL."&task=propertyadmin"),$cancelText);
		if (!$clone && $tarifftypeid>0)
			$jrtb .= $jrtbar->toolbarItem('delete',jomresURL(JOMRES_SITEPAGE_URL."&task=deleteTariff&tarifftypeid=".$tarifftypeid),$deleteText);
		$jrtb .= $jrtbar->endTable();
		$output['JOMRESTOOLBAR']=$jrtb;

		$output['JOMRES_SITEPAGE_URL']=JOMRES_SITEPAGE_URL."&task=saveTariff";
		
		$already_selected_rows = array($already_selected);
		$pageoutput[]=$output;
		$tmpl = new patTemplate();
		
		$tmpl->setRoot( JOMRES_TEMPLATEPATH_BACKEND );
		if (using_bootstrap())
			$tmpl->setRoot( $ePointFilepath.'templates'.JRDS.'bootstrap' );
		else
			$tmpl->setRoot( $ePointFilepath.'templates'.JRDS.'jquery_ui' );
		$tmpl->readTemplatesFromInput( 'edit_micromanage_tariff.html');
		$tmpl->addRows( 'pageoutput',$pageoutput);
		$tmpl->addRows( 'prefills',$prefills);
		$tmpl->addRows( 'prefilltitles',$prefilltitles);
		$tmpl->addRows( 'prefillbuttons',$prefillbuttons);
		$tmpl->addRows( 'daterows',$daterows);
		$tmpl->addRows( 'already_selected_rows',$already_selected_rows);
		$tmpl->displayParsedTemplate();
		}

	function getValueForTariffThisDate($epoch)
		{
		foreach ($this->rateDetails as $r )
			{
			//var_dump($r);exit;
			$date_elements  = explode("/",$r['validFrom']);
			$unixValidFromDate= mktime(0,0,0,$date_elements[1],$date_elements[2],$date_elements[0]);
			$date_elements  = explode("/",$r['validTo']);
			$unixValidToDate= mktime(0,0,0,$date_elements[1],$date_elements[2],$date_elements[0]);
			//echo $r['validTo'];exit;
			if ($epoch >= $unixValidFromDate && $epoch <= $unixValidToDate )
				{
				return $r['roomrateperday'];
				}
			}
		return false;
		}
	
	function getMinintervalForTariffThisDate($epoch)
		{
		foreach ($this->rateDetails as $r )
			{
			//var_dump($r);exit;
			$date_elements  = explode("/",$r['validFrom']);
			$unixValidFromDate= mktime(0,0,0,$date_elements[1],$date_elements[2],$date_elements[0]);
			$date_elements  = explode("/",$r['validTo']);
			$unixValidToDate= mktime(0,0,0,$date_elements[1],$date_elements[2],$date_elements[0]);
			//echo $r['validTo'];exit;
			if ($epoch >= $unixValidFromDate && $epoch <= $unixValidToDate )
				{
				return $r['mindays'];
				}
			}
		return false;
		}
	
	function touch_template_language()
		{
		$output=array();
		$output[]		=jr_gettext('_JOMRES_COM_MR_LISTTARIFF_RATETITLE',_JOMRES_COM_MR_LISTTARIFF_RATETITLE);
		$output[]		=jr_gettext('_JOMRES_COM_MR_LISTTARIFF_MINDAYS',_JOMRES_COM_MR_LISTTARIFF_MINDAYS);
		$output[]		=jr_gettext('_JOMRES_COM_MR_LISTTARIFF_MAXDAYS',_JOMRES_COM_MR_LISTTARIFF_MAXDAYS);
		$output[]		=jr_gettext('_JOMRES_COM_MR_LISTTARIFF_MINPEOPLE',_JOMRES_COM_MR_LISTTARIFF_MINPEOPLE);
		$output[]		=jr_gettext('_JOMRES_COM_MR_LISTTARIFF_MAXPEOPLE',_JOMRES_COM_MR_LISTTARIFF_MAXPEOPLE);
		$output[]		=jr_gettext('_JOMRES_COM_MR_LISTTARIFF_ROOMCLASS',_JOMRES_COM_MR_LISTTARIFF_ROOMCLASS);
		$output[]		=jr_gettext('_JOMRES_COM_MR_LISTTARIFF_IGNOREPPN',_JOMRES_COM_MR_LISTTARIFF_IGNOREPPN);
		$output[]		=jr_gettext('_JOMRES_COM_MR_LISTTARIFF_ALLOWWE',_JOMRES_COM_MR_LISTTARIFF_ALLOWWE);

		$output[]		=jr_gettext('_JOMRES_COM_MR_LISTTARIFF_IGNOREPPN',_JOMRES_COM_MR_LISTTARIFF_IGNOREPPN);
		$output[]		=jr_gettext('_JOMRES_COM_WEEKENDONLY',_JOMRES_COM_WEEKENDONLY);
		$output[]		=jr_gettext('_JOMRES_MICROMANAGE_PICKER_DAYSOFWEEK',_JOMRES_MICROMANAGE_PICKER_DAYSOFWEEK);
		$output[]		=jr_gettext('_JOMRES_MICROMANAGE_PICKER_DATERANGES',_JOMRES_MICROMANAGE_PICKER_DATERANGES);
		$output[]		=jr_gettext('_JOMRES_MICROMANAGE_PICKER_DATERANGES_START',_JOMRES_MICROMANAGE_PICKER_DATERANGES_START);
		$output[]		=jr_gettext('_JOMRES_MICROMANAGE_PICKER_DATERANGES_END',_JOMRES_MICROMANAGE_PICKER_DATERANGES_END);
		$output[]		=jr_gettext('_JOMRES_MICROMANAGE_PICKER_DATERANGES_RATE',_JOMRES_MICROMANAGE_PICKER_DATERANGES_RATE);
		$output[]		=jr_gettext('_JOMRES_MICROMANAGE_PICKER_DATERANGES_SET',_JOMRES_MICROMANAGE_PICKER_DATERANGES_SET);
		
		
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