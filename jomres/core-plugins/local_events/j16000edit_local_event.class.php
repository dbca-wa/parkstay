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

class j16000edit_local_event {
	function j16000edit_local_event()
		{
		// Must be in all minicomponents. Minicomponents with templates that can contain editable text should run $this->template_touch() else just return 
		if (!function_exists('jomres_getSingleton'))
			global $MiniComponents;
		else
			$MiniComponents =jomres_getSingleton('mcHandler');
		if ($MiniComponents->template_touch)
			{
			$this->template_touchable=false; return;
			}
		global $ePointFilepath,$jomresConfig_live_site,$jrConfig;
		
		$output=array();
		if ($jrConfig['autoDetectJSCalendarLang'] == "1")
			{
			$calfileSought="calendar-".$jomresConfig_lang.".js";
			if (file_exists('javascript'.JRDS.'cal'.JRDS.'lang'.JRDS.$calfileSought))
				$jrConfig['jscalendarLangfile']=$calfileSought;
			else
				$jrConfig['jscalendarLangfile']="calendar-en-GB.js";
			}
		if (!defined("JOMRES_CALENDARJSCALLED") )
			{
			define ('JOMRES_CALENDARJSCALLED',1);
			jomres_cmsspecific_addheaddata("css",$jomresConfig_live_site.'/jomres/javascript/cal/css/',$jrConfig['jscalendarCSSfile']);
			jomres_cmsspecific_addheaddata("javascript",$jomresConfig_live_site.'/jomres/javascript/cal/',"calendar.js");
			jomres_cmsspecific_addheaddata("javascript",$jomresConfig_live_site.'/jomres/javascript/cal/',"calendar-setup.js");
			jomres_cmsspecific_addheaddata("javascript",$jomresConfig_live_site.'/jomres/javascript/cal/lang/',$jrConfig['jscalendarLangfile']);
			}

		$output['HEVENT_TITLE']		=jr_gettext( '_JRPORTAL_LOCAL_EVENTS_EVENT_TITLE',_JRPORTAL_LOCAL_EVENTS_EVENT_TITLE,false);
		$output['HSTARTDATE']		=jr_gettext( '_JRPORTAL_LOCAL_EVENTS_STARTDATE',_JRPORTAL_LOCAL_EVENTS_STARTDATE,false);
		$output['HENDDATE']			=jr_gettext( '_JRPORTAL_LOCAL_EVENTS_ENDDATE',_JRPORTAL_LOCAL_EVENTS_ENDDATE,false);
		$output['HLATITUDE']		=jr_gettext( '_JRPORTAL_LOCAL_EVENTS_LATITUDE',_JRPORTAL_LOCAL_EVENTS_LATITUDE,false);
		$output['HLONGITUDE']		=jr_gettext( '_JRPORTAL_LOCAL_EVENTS_LONGITUDE',_JRPORTAL_LOCAL_EVENTS_LONGITUDE,false);
		$output['HWEBSITEURL']		=jr_gettext( '_JRPORTAL_LOCAL_EVENTS_WEBSITEURL',_JRPORTAL_LOCAL_EVENTS_WEBSITEURL,false);
		$output['HEVENTLOGORELPATH']=jr_gettext( '_JRPORTAL_LOCAL_EVENTS_EVENTLOGORELPATH',_JRPORTAL_LOCAL_EVENTS_EVENTLOGORELPATH,false);
		$output['HDESCRIPTION']		=jr_gettext( '_JRPORTAL_ADD_ADHOC_ITEM_DESCRIPTION',_JRPORTAL_ADD_ADHOC_ITEM_DESCRIPTION,false);
		$output['NOTES']			=jr_gettext( '_JRPORTAL_LOCAL_EVENTS_NOTES',_JRPORTAL_LOCAL_EVENTS_NOTES,false);
		$output['_JRPORTAL_LOCAL_EVENTS_EDIT']			=jr_gettext( '_JRPORTAL_LOCAL_EVENTS_EDIT',_JRPORTAL_LOCAL_EVENTS_EDIT,false);
		
		$id		= jomresGetParam( $_REQUEST, 'id', 0 );
		
		$output['ID']=$id;
		$output['TITLE']="Change me";
		$output['START_DATE']=generateDateInput('start_date',date("Y/m/d"));
		$output['END_DATE']=generateDateInput('end_date',date("Y/m/d"));
		$output['LATITUDE']='51.8'.rand(01,99);
		$output['LONGITUDE']='-4.9'.rand(01,99);
		$output['WEBSITE_URL']='';
		$output['EVENT_LOGO']='';
		$output['DESCRIPTION']='';
		
		if ($id >0)
			{
			$query = "SELECT * FROM #__jomres_local_events WHERE id = ".$id;
			$result = doSelectSql($query,2);
			$output['TITLE']=$result['title'];
			$output['START_DATE']=generateDateInput('start_date',str_replace("-","/",$result['start_date']));
			$output['END_DATE']=generateDateInput('end_date',str_replace("-","/",$result['end_date']));
			$output['LATITUDE']=$result['latitude'];
			$output['LONGITUDE']=$result['longitude'];
			$output['WEBSITE_URL']=$result['website_url'];
			$output['EVENT_LOGO']=$result['event_logo'];
			$output['DESCRIPTION']=jr_gettext("_JRPORTAL_LOCAL_EVENTS_CUSTOMTEXT_DESCRIPTION".$id,$result['description'],false,false);
			}

		if (class_exists('jomres_toolbar'))
			$jrtbar = new jomres_toolbar();
		else
			$jrtbar =jomres_getSingleton('jomres_toolbar');
		$jrtb  = $jrtbar->startTable();
		$jrtb .= $jrtbar->toolbarItem('save','','',true,'save_local_event');
		$jrtb .= $jrtbar->toolbarItem('cancel',JOMRES_SITEPAGE_URL_ADMIN."&task=list_local_events",'');
		if ($id>0)
			$jrtb .= $jrtbar->toolbarItem('delete',JOMRES_SITEPAGE_URL_ADMIN."&task=delete_local_event&no_html=1&id=".$id,'');
		$jrtb .= $jrtbar->endTable();
		$output['JOMRESTOOLBAR']=$jrtb;

		$output['JOMRES_SITEPAGE_URL_ADMIN']=JOMRES_SITEPAGE_URL_ADMIN;
		
		$pageoutput[]=$output;
		$tmpl = new patTemplate();
		if (using_bootstrap())
			$tmpl->setRoot( $ePointFilepath.JRDS."templates".JRDS."bootstrap" );
		else
			$tmpl->setRoot( $ePointFilepath.JRDS."templates".JRDS."jquery_ui" );
		$tmpl->readTemplatesFromInput( 'edit_local_event.html');
		$tmpl->addRows( 'pageoutput', $pageoutput );
		$tmpl->displayParsedTemplate();
		
		}

	// This must be included in every Event/Mini-component
	function getRetVals()
		{
		return null;
		}
	}
?>