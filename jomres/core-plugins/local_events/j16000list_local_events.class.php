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

class j16000list_local_events
	{
	function j16000list_local_events()
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
		global $jomresConfig_live_site;
		global $ePointFilepath;
		$editIcon	='<IMG SRC="'.$jomresConfig_live_site.'/jomres/images/jomresimages/small/EditItem.png" border="0" alt="editicon">';
		$output=array();
		
		$output['PAGETITLE']=jr_gettext( '_JRPORTAL_LOCAL_EVENTS_TITLE',_JRPORTAL_LOCAL_EVENTS_TITLE,false);
		
		$output['HEVENT_TITLE']		=jr_gettext( '_JRPORTAL_LOCAL_EVENTS_EVENT_TITLE',_JRPORTAL_LOCAL_EVENTS_EVENT_TITLE,false);
		$output['HSTARTDATE']		=jr_gettext( '_JRPORTAL_LOCAL_EVENTS_STARTDATE',_JRPORTAL_LOCAL_EVENTS_STARTDATE,false);
		$output['HENDDATE']			=jr_gettext( '_JRPORTAL_LOCAL_EVENTS_ENDDATE',_JRPORTAL_LOCAL_EVENTS_ENDDATE,false);
		$output['HLATITUDE']		=jr_gettext( '_JRPORTAL_LOCAL_EVENTS_LATITUDE',_JRPORTAL_LOCAL_EVENTS_LATITUDE,false);
		$output['HLONGITUDE']		=jr_gettext( '_JRPORTAL_LOCAL_EVENTS_LONGITUDE',_JRPORTAL_LOCAL_EVENTS_LONGITUDE,false);
		$output['HWEBSITEURL']		=jr_gettext( '_JRPORTAL_LOCAL_EVENTS_WEBSITEURL',_JRPORTAL_LOCAL_EVENTS_WEBSITEURL,false);
		$output['HEVENTLOGORELPATH']=jr_gettext( '_JRPORTAL_LOCAL_EVENTS_EVENTLOGORELPATH',_JRPORTAL_LOCAL_EVENTS_EVENTLOGORELPATH,false);
		
		$query = "SELECT * FROM #__jomres_local_events";
		$result = doSelectSql($query);

		$rows=array();
		foreach ($result as $res)
			{
			$r=array();
			$r['ID']=$res->id;
			$r['TITLE']=$res->title;
			$r['START_DATE']=$res->start_date;
			$r['END_DATE']=$res->end_date;
			$r['LATITUDE']=$res->latitude;
			$r['LONGITUDE']=$res->longitude;
			$r['WEBSITE_URL']=$res->website_url;
			$r['EVENT_LOGO']=$res->event_logo;
			$r['EDITLINK']='<a href="'.JOMRES_SITEPAGE_URL_ADMIN.'&task=edit_local_event&id='.(int)$res->id.'">'.$editIcon.'</a>';
			$rows[]=$r;
			}

		if (class_exists('jomres_toolbar'))
			$jrtbar = new jomres_toolbar();
		else
			$jrtbar =jomres_getSingleton('jomres_toolbar');
		$jrtb  = $jrtbar->startTable();
		$jrtb .= $jrtbar->toolbarItem('new',JOMRES_SITEPAGE_URL_ADMIN."&task=edit_local_event",'');
		$jrtb .= $jrtbar->toolbarItem('cancel',JOMRES_SITEPAGE_URL_ADMIN,jr_gettext( '_JRPORTAL_CANCEL',_JRPORTAL_CANCEL,false));
		$jrtb .= $jrtbar->spacer();
		$jrtb .= $jrtbar->endTable();
		$output['JOMRESTOOLBAR']=$jrtb;

		$pageoutput[]=$output;
		$tmpl = new patTemplate();
		if (using_bootstrap())
			$tmpl->setRoot( $ePointFilepath.JRDS."templates".JRDS."bootstrap" );
		else
			$tmpl->setRoot( $ePointFilepath.JRDS."templates".JRDS."jquery_ui" );
		$tmpl->readTemplatesFromInput( 'list_local_events.html');
		$tmpl->addRows( 'pageoutput',$pageoutput);
		$tmpl->addRows( 'rows',$rows);
		$tmpl->displayParsedTemplate();
		}


	// This must be included in every Event/Mini-component
	function getRetVals()
		{
		return null;
		}
	}