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

class j16000edit_local_attraction {
	function j16000edit_local_attraction()
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

		$output['HEVENT_TITLE']		=jr_gettext( '_JRPORTAL_LOCAL_ATTRACTIONS_ATTRACTION_TITLE',_JRPORTAL_LOCAL_ATTRACTIONS_ATTRACTION_TITLE,false);
		$output['HICON']			=jr_gettext( '_JRPORTAL_LOCAL_ATTRACTIONS_ICON',_JRPORTAL_LOCAL_ATTRACTIONS_ICON,false);
		$output['HLATITUDE']		=jr_gettext( '_JRPORTAL_LOCAL_ATTRACTIONS_LATITUDE',_JRPORTAL_LOCAL_ATTRACTIONS_LATITUDE,false);
		$output['HLONGITUDE']		=jr_gettext( '_JRPORTAL_LOCAL_ATTRACTIONS_LONGITUDE',_JRPORTAL_LOCAL_ATTRACTIONS_LONGITUDE,false);
		$output['HWEBSITEURL']		=jr_gettext( '_JRPORTAL_LOCAL_ATTRACTIONS_WEBSITEURL',_JRPORTAL_LOCAL_ATTRACTIONS_WEBSITEURL,false);
		$output['HEVENTLOGORELPATH']=jr_gettext( '_JRPORTAL_LOCAL_ATTRACTIONS_ATTRACTIONLOGORELPATH',_JRPORTAL_LOCAL_ATTRACTIONS_ATTRACTIONLOGORELPATH,false);
		$output['HDESCRIPTION']		=jr_gettext( '_JRPORTAL_ADD_ADHOC_ITEM_DESCRIPTION',_JRPORTAL_ADD_ADHOC_ITEM_DESCRIPTION,false);
		$output['NOTES']			=jr_gettext( '_JRPORTAL_LOCAL_ATTRACTIONS_NOTES',_JRPORTAL_LOCAL_ATTRACTIONS_NOTES,false);
		$output['_JRPORTAL_LOCAL_ATTRACTIONS_EDIT']			=jr_gettext( '_JRPORTAL_LOCAL_ATTRACTIONS_EDIT',_JRPORTAL_LOCAL_ATTRACTIONS_EDIT,false);
		
		$id		= jomresGetParam( $_REQUEST, 'id', 0 );
		
		$extended_maps_installed = false;
		if (file_exists(JOMRESCONFIG_ABSOLUTE_PATH.JRDS.'jomres'.JRDS.'core-plugins'.JRDS.'extended_maps'.JRDS.'plugin_info.php'))
			{
			$extended_maps_installed = true;
			$icons = $this->get_extended_maps_icons();
			}
		else
			$icons = array();
			
		$output['ID']=$id;
		$output['TITLE']="Change me";
		$output['ICONS']='';
		$output['LATITUDE']='51.8'.rand(01,99);
		$output['LONGITUDE']='-4.9'.rand(01,99);
		$output['WEBSITE_URL']='';
		$output['EVENT_LOGO']='';
		$output['DESCRIPTION']='';
		
		if ($extended_maps_installed)
			{
			$icon_output = "";
			foreach ($icons as $icon)
				{
				$checked = "";
				if ($result['icon'] == $icon['ICON'])
					$checked = "checked";
				$icon_output .= '<input type="radio" name="icon" value="'.$icon['ICON'].'" '.$checked.' ><img src="'.get_showtime('live_site').'/jomres/core-plugins/extended_maps/markers/'.$icon['ICON'].'" border = \"0\"/>';
				}
			$output['ICONS']= $icon_output;
			}

		if ($id >0)
			{
			$query = "SELECT * FROM #__jomres_local_attractions WHERE id = ".$id;
			$result = doSelectSql($query,2);
			$output['TITLE']=$result['title'];
			if ($extended_maps_installed)
				{
				$icon_output = "";
				foreach ($icons as $icon)
					{
					$checked = "";
					if ($result['icon'] == $icon['ICON'])
						$checked = "checked";
					$icon_output .= '<input type="radio" name="icon" value="'.$icon['ICON'].'" '.$checked.' ><img src="'.get_showtime('live_site').'/jomres/core-plugins/extended_maps/markers/'.$icon['ICON'].'" border = \"0\"/>';
					}
				$output['ICONS']= $icon_output;
				}
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
		$jrtb .= $jrtbar->toolbarItem('save','','',true,'save_local_attraction');
		$jrtb .= $jrtbar->toolbarItem('cancel',JOMRES_SITEPAGE_URL_ADMIN."&task=list_local_attractions",'');
		if ($id>0)
			$jrtb .= $jrtbar->toolbarItem('delete',JOMRES_SITEPAGE_URL_ADMIN."&task=delete_local_attraction&no_html=1&id=".$id,'');
		$jrtb .= $jrtbar->endTable();
		$output['JOMRESTOOLBAR']=$jrtb;

		$output['JOMRES_SITEPAGE_URL_ADMIN']=JOMRES_SITEPAGE_URL_ADMIN;
		
		$pageoutput[]=$output;
		$tmpl = new patTemplate();
		if (using_bootstrap())
			$tmpl->setRoot( $ePointFilepath.JRDS."templates".JRDS."bootstrap" );
		else
			$tmpl->setRoot( $ePointFilepath.JRDS."templates".JRDS."jquery_ui" );
		$tmpl->readTemplatesFromInput( 'edit_local_attraction.html');
		$tmpl->addRows( 'pageoutput', $pageoutput );
		$tmpl->displayParsedTemplate();
		
		}

	function get_extended_maps_icons()
		{
		$map=JOMRESCONFIG_ABSOLUTE_PATH.JRDS.'jomres'.JRDS.'core-plugins'.JRDS.'extended_maps'.JRDS.'markers'.JRDS;
		$mrp=$jomresConfig_live_site.'/jomres/core-plugins/extended_maps/markers';
		$d = @dir($map);
		$docs = array();
		$rows=array();
		if($d)
			{
			while (FALSE !== ($entry = $d->read()))
				{
				$filename = $entry;
				if(is_file($map.$filename) && substr($entry,0,1) != '.' && strtolower($entry) !== 'cvs' && $filename != "shadow.png")
					{
					$docs=array();
					$docs['ICON'] =$filename;
					$rows[]=$docs;
					}
				}
			$d->close();
			}
		return $rows;
		}
	// This must be included in every Event/Mini-component
	function getRetVals()
		{
		return null;
		}
	}
?>