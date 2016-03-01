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
 * 
 #
* @package Jomres
#
 */
class j02320regprop3 {
	/**
	#
	 * Constructor: 
	#
	 */
	function j02320regprop3()
		{
		// Must be in all minicomponents. Minicomponents with templates that can contain editable text should run $this->template_touch() else just return 
		$MiniComponents =jomres_singleton_abstract::getInstance('mcHandler');
		if ($MiniComponents->template_touch)
			{
			$this->template_touchable=false; return;
			}
		$thisJRUser=jomres_singleton_abstract::getInstance('jr_user');
		$siteConfig = jomres_singleton_abstract::getInstance('jomres_config_site_singleton');
		$jrConfig=$siteConfig->get();
		if (!subscribers_checkUserHasSubscriptionsToCreateNewProperty() && !$thisJRUser->superPropertyManager && $jrConfig['useSubscriptions']=="1" )
			jomresRedirect( JOMRES_SITEPAGE_URL."&task=list_subscription_packages","");

		
		if ($jrConfig['selfRegistrationAllowed']=="0" && !$thisJRUser->superPropertyManager)
			return;
			
		
		$roomClass						= jomresGetParam( $_POST, 'roomClass', 0 );
		$mrpsrp							= jomresGetParam( $_POST, 'mrpsrp', "" );

		$property_name					= trim(jomresGetParam( $_POST, 'property_name', "" ));
		$property_street				= jomresGetParam( $_POST, 'property_street', "" );
		$property_town					= jomresGetParam( $_POST, 'property_town', "" );
		$property_region				= jomresGetParam( $_POST, 'property_region', "" );
		if ($jrConfig['limit_property_country'] == "0")
			$property_country				= jomresGetParam( $_POST, 'property_country', "" );
		else
			$property_country				= $jrConfig['limit_property_country_country'];

		$property_postcode				= jomresGetParam( $_POST, 'property_postcode', "" );
		$property_tel					= jomresGetParam( $_POST, 'property_tel', "" );
		$property_fax					= jomresGetParam( $_POST, 'property_fax', "" );
		$property_email					= jomresGetParam( $_POST, 'property_email', "" );
		$property_mappinglink			= urlencode(jomresGetParam( $_POST, 'property_mappinglink', "" ) );

		if ($jrConfig['allowHTMLeditor'] == "0")
			{
			$property_description			= $this->convert_lessgreaterthans(jomresGetParam( $_POST, 'property_description', "" ));
			$property_checkin_times			= $this->convert_lessgreaterthans(jomresGetParam( $_POST, 'property_checkin_times', "" ));
			$property_area_activities		= $this->convert_lessgreaterthans(jomresGetParam( $_POST, 'property_area_activities', "" ));
			$property_driving_directions	= $this->convert_lessgreaterthans(jomresGetParam( $_POST, 'property_driving_directions', "" ));
			$property_airports				= $this->convert_lessgreaterthans(jomresGetParam( $_POST, 'property_airports', "" ));
			$property_othertransport		= $this->convert_lessgreaterthans(jomresGetParam( $_POST, 'property_othertransport', "" ));
			$property_policies_disclaimers	= $this->convert_lessgreaterthans(jomresGetParam( $_POST, 'property_policies_disclaimers', "" ));
			
			$property_description			= strip_tags(  $property_description );
			$property_checkin_times			= strip_tags(  $property_checkin_times);
			$property_area_activities		= strip_tags(  $property_area_activities );
			$property_driving_directions	= strip_tags(  $property_driving_directions);
			$property_airports				= strip_tags(  $property_airports );
			$property_othertransport		= strip_tags(  $property_othertransport );
			$property_policies_disclaimers	= strip_tags(  $property_policies_disclaimers );
			}
		else
			{
			$property_description			=jomresGetParam( $_POST, 'property_description', "" );
			$property_checkin_times			=jomresGetParam( $_POST, 'property_checkin_times', "" );
			$property_area_activities		=jomresGetParam( $_POST, 'property_area_activities', "" );
			$property_driving_directions	=jomresGetParam( $_POST, 'property_driving_directions', "" );
			$property_airports				=jomresGetParam( $_POST, 'property_airports', "" );
			$property_othertransport		=jomresGetParam( $_POST, 'property_othertransport', "" );
			$property_policies_disclaimers	=jomresGetParam( $_POST, 'property_policies_disclaimers', "" );
			
			if ($jrConfig['use_jomres_own_editor'])
				{
				$property_description			= $this->convert_lessgreaterthans($property_description);
				$property_checkin_times			= $this->convert_lessgreaterthans($property_checkin_times);
				$property_area_activities		= $this->convert_lessgreaterthans($property_area_activities);
				$property_driving_directions	= $this->convert_lessgreaterthans($property_driving_directions);
				$property_airports				= $this->convert_lessgreaterthans($property_airports);
				$property_othertransport		= $this->convert_lessgreaterthans($property_othertransport);
				$property_policies_disclaimers	= $this->convert_lessgreaterthans($property_policies_disclaimers);
			
				$unwanted = array("<p><br></p>","<brb>","</brb>","<p></p>","<p> </p>","<p> 		</p>");
				$property_description 				= str_replace($unwanted,"",$property_description); // The Jomres editor adds stray spaces and <p> to the end, this will remove them
				$property_checkin_times 			= str_replace($unwanted,"",$property_checkin_times); 
				$property_area_activities 			= str_replace($unwanted,"",$property_area_activities); 
				$property_driving_directions 		= str_replace($unwanted,"",$property_driving_directions); 
				$property_airports 					= str_replace($unwanted,"",$property_airports); 
				$property_othertransport 			= str_replace($unwanted,"",$property_othertransport); 
				$property_policies_disclaimers 		= str_replace($unwanted,"",$property_policies_disclaimers); 
				
				$property_description			= $this->encode_lessgreaterthans($property_description);
				$property_checkin_times			= $this->encode_lessgreaterthans($property_checkin_times);
				$property_area_activities		= $this->encode_lessgreaterthans($property_area_activities);
				$property_driving_directions	= $this->encode_lessgreaterthans($property_driving_directions);
				$property_airports				= $this->encode_lessgreaterthans($property_airports);
				$property_othertransport		= $this->encode_lessgreaterthans($property_othertransport);
				$property_policies_disclaimers	= $this->encode_lessgreaterthans($property_policies_disclaimers);
				}
			}
		$property_type					= intval(jomresGetParam( $_POST, 'propertyType', "" ));
		//$isthisanmrp					= intval(jomresGetParam( $_POST, 'isthisanmrp', 0 ));
		$property_stars					= intval(jomresGetParam( $_POST, 'stars', "" ) );
		$features_list					= jomresGetParam( $_POST, 'pid', array() );
		$price							= jomresGetParam( $_POST, 'price','' );
		$price=str_replace(",","",$price);
		
		$realestate						= (int)jomresGetParam( $_POST, 'realestate', 0 );
		
		$lat							= parseFloat(jomresGetParam( $_POST, 'lat', '' ));
		$long							= parseFloat(jomresGetParam( $_POST, 'long', '' ));
		
		if (count($features_list)>1)
			$featuresList=implode(",",$features_list);
		if (count($features_list)==1)
			{
			$featuresList=implode(",",$features_list);
			//
			}
		$featuresList=",".$featuresList.",";

		$apikey=createNewAPIKey();
		
		if (!isset($jrConfig['automatically_approve_new_properties']))
			$jrConfig['automatically_approve_new_properties']=1;
		
		$approved = 0;
		if ($jrConfig['automatically_approve_new_properties'] =="1")
			$approved=1;
		
		$query="INSERT INTO #__jomres_propertys (`property_name`,`property_street`,`property_town`,
			`property_region`,`property_country`,`property_postcode`,`property_tel`,`property_fax`,
			`property_email`,`property_features`,`property_mappinglink`,
			`property_description`,`property_checkin_times`,`property_area_activities`,
			`property_driving_directions`,`property_airports`,`property_othertransport`,`property_policies_disclaimers`,`property_key`,stars,ptype_id,apikey,`lat`,`long`,`approved`)
			VALUES
			('$property_name','$property_street',
			'$property_town','$property_region','$property_country','$property_postcode','$property_tel',
			'$property_fax','$property_email','$featuresList',
			'$property_mappinglink','$property_description','$property_checkin_times','$property_area_activities',
			'$property_driving_directions','$property_airports','$property_othertransport',
			'$property_policies_disclaimers','".(float)$price."','".(int)$property_stars."','".(int)$property_type."','".$apikey."','".$lat."','".$long."',".(int)$approved."
			)";
		$newPropId=doInsertSql($query,jr_gettext('_JOMRES_MR_AUDIT_INSERT_PROPERTY',_JOMRES_MR_AUDIT_INSERT_PROPERTY,FALSE));
		
		updateCustomText( "_JOMRES_CUSTOMTEXT_ROOMTYPE_DESCRIPTION", $property_description, true, $newPropId );
		updateCustomText( "_JOMRES_CUSTOMTEXT_ROOMTYPE_CHECKINTIMES", $property_checkin_times, true, $newPropId );
		updateCustomText( "_JOMRES_CUSTOMTEXT_ROOMTYPE_AREAACTIVITIES", $property_area_activities, true, $newPropId );
		updateCustomText( "_JOMRES_CUSTOMTEXT_ROOMTYPE_DIRECTIONS", $property_driving_directions, true, $newPropId );
		updateCustomText( "_JOMRES_CUSTOMTEXT_ROOMTYPE_AIRPORTS", $property_airports, true, $newPropId );
		updateCustomText( "_JOMRES_CUSTOMTEXT_ROOMTYPE_OTHERTRANSPORT", $property_othertransport, true, $newPropId );
		updateCustomText( "_JOMRES_CUSTOMTEXT_ROOMTYPE_DISCLAIMERS", $property_policies_disclaimers, true, $newPropId );
		updateCustomText( "_JOMRES_CUSTOMTEXT_PROPERTY_NAME", $property_name, true, $newPropId );

		if ($realestate ==0)
			{
			if ($mrpsrp == "MRP")
				$singleRoomProperty="0";
			else
				{
				$singleRoomProperty="1";
				$query="INSERT INTO #__jomres_rooms (
					`room_classes_uid`,
					`propertys_uid`,
					`max_people`
					)VALUES (
					'".$roomClass."',
					".(int)$newPropId.",
					'100'
					)";
				if (!doInsertSql($query)) 
					trigger_error ("Sql error when saving new room", E_USER_ERROR);
				}
			$query="INSERT INTO #__jomres_settings (property_uid,akey,value) VALUES ('".(int)$newPropId."','singleRoomProperty','".$singleRoomProperty."')";
			doInsertSql($query,jr_gettext('_JOMRES_MR_AUDIT_EDIT_PROPERTY_SETTINGS',_JOMRES_MR_AUDIT_EDIT_PROPERTY_SETTINGS,FALSE));
			}
		else
			{
			$query="INSERT INTO #__jomres_settings (property_uid,akey,value) VALUES ('".(int)$newPropId."','is_real_estate_listing',1)";
			doInsertSql($query,jr_gettext('_JOMRES_MR_AUDIT_EDIT_PROPERTY_SETTINGS',_JOMRES_MR_AUDIT_EDIT_PROPERTY_SETTINGS,FALSE));
			}
			


		if (!$thisJRUser->userIsManager)
			{
			jr_import('jrportal_user_functions');
			$ufuncs=new jrportal_user_functions();
			$userdeets=$ufuncs->getJoomlaUserDetailsForJoomlaId($thisJRUser->id);
			$query="INSERT INTO #__jomres_managers (`userid`,`username`,`property_uid`,`access_level`)VALUES (".(int)$userdeets['id'].",'".(string)$userdeets['username']."','".(int)$newPropId."','2')";
			$managerId=doInsertSql($query,jr_gettext("_JOMRES_REGISTRATION_AUDIT_CREATEPROPERTY",_JOMRES_REGISTRATION_AUDIT_CREATEPROPERTY));
			}
		
		$jomres_messaging =jomres_singleton_abstract::getInstance('jomres_messages');
		$jomres_messaging->set_message(jr_gettext("_JOMRES_REGISTRATION_AUDIT_CREATEPROPERTY",_JOMRES_REGISTRATION_AUDIT_CREATEPROPERTY));
		$thisJRUser->authorisedProperties[]=$newPropId;
		updateManagerIdToPropertyXrefTable($thisJRUser->id,$thisJRUser->authorisedProperties );
		$componentArgs=array('property_uid'=>(int)$newPropId);
		$MiniComponents->triggerEvent('04901',$componentArgs); // Trigger point. Not currently used, but available if somebody wants a trigger point after the create property phase.
		$subject=jr_gettext("_JOMRES_REGISTRATION_CREATEDPROPERTY",_JOMRES_REGISTRATION_CREATEDPROPERTY,false).$property_name;
		$message=jr_gettext("_JOMRES_REGISTRATION_CREATEDPROPERTY_FORUSER",_JOMRES_REGISTRATION_CREATEDPROPERTY_FORUSER,false).$thisJRUser->username;
		sendAdminEmail($subject,$message);
		
		if ($approved ==0)
			{
			$link = JOMRES_SITEPAGE_URL_ADMIN."&task=list_properties_awaiting_approval";
			$subject=jr_gettext("_JOMRES_APPROVALS_ADMIN_EMAIL_SUBJECT",_JOMRES_APPROVALS_ADMIN_EMAIL_SUBJECT,false);
			$message=jr_gettext("_JOMRES_APPROVALS_ADMIN_EMAIL_CONTENT",_JOMRES_APPROVALS_ADMIN_EMAIL_CONTENT,false).$link;
			sendAdminEmail($subject,$message);
		
			}

		if ($realestate ==0)
			jomresRedirect( JOMRES_SITEPAGE_URL."&task=propertyadmin&thisProperty=".$newPropId,"");
		else
			jomresRedirect( JOMRES_SITEPAGE_URL."&thisProperty=".$newPropId,"");
		}

	function encode_lessgreaterthans($string)
		{
		$string			= str_replace("<", "&#60;", $string );
		$string			= str_replace(">","&#62;", $string );
		return $string;
		}
	
	function convert_lessgreaterthans($string)
		{
		$string			= str_replace( "&#60;","<", $string );
		$string			= str_replace( "&#62;",">", $string );
		return $string;
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