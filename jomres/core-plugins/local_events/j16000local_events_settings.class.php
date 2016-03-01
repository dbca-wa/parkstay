<?php

// ################################################################
defined( '_JOMRES_INITCHECK' ) or die( '' );
// ################################################################

class j16000local_events_settings
	{
	function j16000local_events_settings()
		{
		// Must be in all minicomponents. Minicomponents with templates that can contain editable text should run $this->template_touch() else just return
		$MiniComponents =jomres_getSingleton('mcHandler');
		if ($MiniComponents->template_touch)
			{
			$this->template_touchable=false; return;
			}
		$ePointFilepath = get_showtime('ePointFilepath');
		$jomresConfig_live_site = get_showtime('live_site');
		
		$output=array();
		$pageoutput=array();

		jr_import('local_events');
		$local_events = new local_events();
		$local_events->get_local_events_settings();
		
		$output['_JRPORTAL_LOCAL_EVENTS_SETTINGS_RADIUS']=jr_gettext('_JRPORTAL_LOCAL_EVENTS_SETTINGS_RADIUS',_JRPORTAL_LOCAL_EVENTS_SETTINGS_RADIUS,FALSE);
		$output['RADIUS']=$local_events->local_eventsConfigOptions['radius'];
		$output['_JRPORTAL_LOCAL_EVENTS_SETTINGS_RADIUS_DESC']=jr_gettext('_JRPORTAL_LOCAL_EVENTS_SETTINGS_RADIUS_DESC',_JRPORTAL_LOCAL_EVENTS_SETTINGS_RADIUS_DESC,FALSE);
		
		$jrtbar =jomres_getSingleton('jomres_toolbar');
		$jrtb  = $jrtbar->startTable();
		$jrtb .= $jrtbar->toolbarItem('save','','',true,'save_local_events_settings');
		$jrtb .= $jrtbar->toolbarItem('cancel',jomresURL("index.php?option=com_jomres"),'');
		$jrtb .= $jrtbar->endTable();
		$output['JOMRESTOOLBAR']=$jrtb;
		
		$output['JOMRES_SITEPAGE_URL_ADMIN']=JOMRES_SITEPAGE_URL_ADMIN;
		$output['LIVESITE']=get_showtime('live_site');

		$pageoutput[]=$output;
		$tmpl = new patTemplate();
		if (using_bootstrap())
			$tmpl->setRoot( $ePointFilepath.JRDS."templates".JRDS."bootstrap" );
		else
			$tmpl->setRoot( $ePointFilepath.JRDS."templates".JRDS."jquery_ui" );
		$tmpl->readTemplatesFromInput( 'admin_local_events.html');
		$tmpl->addRows( 'pageoutput',$pageoutput);
		$tmpl->displayParsedTemplate();
		}

	//Must be included in every mini-component
	function getRetVals()
		{
		return null;
		}
	}
?>