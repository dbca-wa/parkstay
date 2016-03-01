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

/**
#
 * xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
 #
* @package Jomres
#
 */
class j00016local_attractions {

	/**
	#
	 * xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
	#
	 */
	function j00016local_attractions($componentArgs)
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
		$output=array();
		
		$output['PAGETITLE']=jr_gettext('_JRPORTAL_LOCAL_ATTRACTIONS_TITLE',_JRPORTAL_LOCAL_ATTRACTIONS_TITLE,false);
		
		$output['HEVENT_TITLE']		=jr_gettext('_JRPORTAL_LOCAL_ATTRACTIONS_ATTRACTION_TITLE',_JRPORTAL_LOCAL_ATTRACTIONS_ATTRACTION_TITLE,false);
		$output['HWEBSITEURL']		=jr_gettext('_JRPORTAL_LOCAL_ATTRACTIONS_WEBSITEURL',_JRPORTAL_LOCAL_ATTRACTIONS_WEBSITEURL,false);
		$output['HEVENTLOGORELPATH']=jr_gettext('_JRPORTAL_LOCAL_ATTRACTIONS_ATTRACTIONLOGORELPATH',_JRPORTAL_LOCAL_ATTRACTIONS_ATTRACTIONLOGORELPATH,false);
		
		$today = date("Y-m-s");
		
		$property_uid = get_showtime('property_uid');
		jr_import('local_events');
		$local_events = new local_events();
		$local_events->get_local_events_settings();
		$result = $local_events->find_items_within_range_for_property_uid("local_attractions",$property_uid);

		if (count($result)==0)
			return;
		
		$rows=array();
		$counter=0;
		foreach ($result as $res)
			{
			$r=array();
			$r['ID']=$res->id;
			$r['TITLE']=$res->title;
			$r['WEBSITE_URL']=trim($res->website_url);
			$r['EVENT_LOGO']=trim($res->event_logo);
			$r['DESCRIPTION']=jr_gettext("_JRPORTAL_LOCAL_ATTRACTIONS_CUSTOMTEXT_DESCRIPTION".$res->id,$res->description,false,false);
			if ($counter%2)
				$r['CLASS']="even";
			else
				$r['CLASS']="odd";
			$rows[]=$r;
			$counter++;
			}

		$pageoutput[]=$output;
		$tmpl = new patTemplate();
		if (using_bootstrap())
			$tmpl->setRoot( $ePointFilepath.JRDS."templates".JRDS."bootstrap" );
		else
			$tmpl->setRoot( $ePointFilepath.JRDS."templates".JRDS."jquery_ui" );
		$tmpl->readTemplatesFromInput( 'frontend_list_local_attractions.html');
		$tmpl->addRows( 'pageoutput',$pageoutput);
		$tmpl->addRows( 'rows',$rows);
		$tmpl->displayParsedTemplate();
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