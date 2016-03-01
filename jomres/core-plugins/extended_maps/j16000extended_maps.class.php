<?php

// ################################################################
defined( '_JOMRES_INITCHECK' ) or die( '' );
// ################################################################

class j16000extended_maps
	{
	function j16000extended_maps()
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

		$extended_maps = new jrportal_extended_maps();
		$extended_maps->get_extended_maps();
		
		$output['HWIDTH']=jr_gettext('_JRPORTAL_EXTENDED_MAPS_HWIDTH',_JRPORTAL_EXTENDED_MAPS_HWIDTH,FALSE);
		$output['WIDTH']=$extended_maps->extended_mapsConfigOptions['width'];
		
		$output['HHEIGHT']=jr_gettext('_JRPORTAL_EXTENDED_MAPS_HHEIGHT',_JRPORTAL_EXTENDED_MAPS_HHEIGHT,FALSE);
		$output['HEIGHT']=$extended_maps->extended_mapsConfigOptions['height'];
		
		$options = array();
		$options[] = jomresHTML::makeOption( 'normal', 'Normal' );
		$options[] = jomresHTML::makeOption( 'satellite', 'Satellite' );
		$options[] = jomresHTML::makeOption( 'hybrid', 'Hybrid' );
		$options[] = jomresHTML::makeOption( 'terrain', 'Terrain' );
		$selected = $extended_maps->extended_mapsConfigOptions['maptype'];
		$output['MAPTYPE']=jomresHTML::selectList( $options, 'maptype','class="inputbox" size="1"', 'value', 'text', $selected);
		$output['HMAPTYPE']=jr_gettext('_JRPORTAL_EXTENDED_MAPS_HMAPTYPE',_JRPORTAL_EXTENDED_MAPS_HMAPTYPE,FALSE);
		
		$options = array();
		$options[] = jomresHTML::makeOption( '1', jr_gettext('_JOMRES_COM_MR_YES',_JOMRES_COM_MR_YES) );
		$options[] = jomresHTML::makeOption( '0', jr_gettext('_JOMRES_COM_MR_NO',_JOMRES_COM_MR_NO) );
		$selected = $extended_maps->extended_mapsConfigOptions['overrideplist'];
		$output['OVERRIDE_PROPERTYLIST']=jomresHTML::selectList( $options, 'overrideplist','class="inputbox" size="1"', 'value', 'text', $selected);
		$output['HOVERRIDE_PROPERTYLIST']=jr_gettext('_JRPORTAL_EXTENDED_MAPS_HOVERRIDE_PROPERTYLIST',_JRPORTAL_EXTENDED_MAPS_HOVERRIDE_PROPERTYLIST,FALSE);
		
		$output['HSRPICON']=jr_gettext('_JRPORTAL_EXTENDED_MAPS_HSRPICON',_JRPORTAL_EXTENDED_MAPS_HSRPICON,FALSE);
		$output['SRPICON']=$extended_maps->extended_mapsConfigOptions['srpicon'];
		
		$output['HMRPICON']=jr_gettext('_JRPORTAL_EXTENDED_MAPS_HMRPICON',_JRPORTAL_EXTENDED_MAPS_HMRPICON,FALSE);
		$output['MRPICON']=$extended_maps->extended_mapsConfigOptions['mrpicon'];
		
		$output['HINFOICON']=jr_gettext('_JRPORTAL_EXTENDED_MAPS_HINFOICON',_JRPORTAL_EXTENDED_MAPS_HINFOICON,FALSE);
		$output['INFOICON']=$extended_maps->extended_mapsConfigOptions['infoicon'];
		
		$output['HPOPUP_WIDTH']=jr_gettext('_JRPORTAL_EXTENDED_MAPS_HPOPUP_WIDTH',_JRPORTAL_EXTENDED_MAPS_HPOPUP_WIDTH,FALSE);
		$output['POPUP_WIDTH']=$extended_maps->extended_mapsConfigOptions['popupwidth'];
		
		$output['HIMAGE_WIDTH']=jr_gettext('_JRPORTAL_EXTENDED_MAPS_HPROPERTY_IMGWIDTH',_JRPORTAL_EXTENDED_MAPS_HPROPERTY_IMGWIDTH,FALSE);
		$output['IMAGE_WIDTH']=$extended_maps->extended_mapsConfigOptions['img_width'];
		
		$output['HIMAGE_HEIGHT']=jr_gettext('_JRPORTAL_EXTENDED_MAPS_HPROPERTY_IMGHEIGHT',_JRPORTAL_EXTENDED_MAPS_HPROPERTY_IMGHEIGHT,FALSE);
		$output['IMAGE_HEIGHT']=$extended_maps->extended_mapsConfigOptions['img_height'];
		
		$options = array();
		$options[] = jomresHTML::makeOption( '1', jr_gettext('_JOMRES_COM_MR_YES',_JOMRES_COM_MR_YES) );
		$options[] = jomresHTML::makeOption( '0',jr_gettext('_JOMRES_COM_MR_NO',_JOMRES_COM_MR_NO)  );
		$selected = $extended_maps->extended_mapsConfigOptions['trim_description'];
		$output['TRIM_DESCRIPTION']=jomresHTML::selectList( $options, 'trim_description','class="inputbox" size="1"', 'value', 'text', $selected);
		$output['HTRIM_DESCRIPTION']=jr_gettext('_JRPORTAL_EXTENDED_MAPS_HTRIM_DESCRIPTION',_JRPORTAL_EXTENDED_MAPS_HTRIM_DESCRIPTION,FALSE);
		
		$output['HTRIM_VALUE']=jr_gettext('_JRPORTAL_EXTENDED_MAPS_HTRIM_VALUE',_JRPORTAL_EXTENDED_MAPS_HTRIM_VALUE,FALSE);
		$output['TRIM_VALUE']=$extended_maps->extended_mapsConfigOptions['trim_value'];
		
		$options = array();
		$options[] = jomresHTML::makeOption( '1', jr_gettext('_JOMRES_COM_MR_YES',_JOMRES_COM_MR_YES) );
		$options[] = jomresHTML::makeOption( '0', jr_gettext('_JOMRES_COM_MR_NO',_JOMRES_COM_MR_NO) );
		$selected = $extended_maps->extended_mapsConfigOptions['show_description'];
		$output['SHOW_DESCRIPTION']=jomresHTML::selectList( $options, 'show_description','class="inputbox" size="1"', 'value', 'text', $selected);
		$output['HSHOW_DESCRIPTION']=jr_gettext('_JRPORTAL_EXTENDED_MAPS_HSHOW_DESCRIPTION',_JRPORTAL_EXTENDED_MAPS_HSHOW_DESCRIPTION,FALSE);
		
		$options = array();
		$options[] = jomresHTML::makeOption( '1', jr_gettext('_JOMRES_COM_MR_YES',_JOMRES_COM_MR_YES) );
		$options[] = jomresHTML::makeOption( '0',jr_gettext('_JOMRES_COM_MR_NO',_JOMRES_COM_MR_NO)  );
		$selected = $extended_maps->extended_mapsConfigOptions['groupmarkers'];
		$output['GROUPMARKERS']=jomresHTML::selectList( $options, 'groupmarkers','class="inputbox" size="1"', 'value', 'text', $selected);
		$output['HGROUPMARKERS']=jr_gettext('_JRPORTAL_EXTENDED_MAPS_GROUPMARKERS',_JRPORTAL_EXTENDED_MAPS_GROUPMARKERS,FALSE);
		
		$output['PAGETITLE']=jr_gettext('_JRPORTAL_EXTENDED_MAPS_TITLE',_JRPORTAL_EXTENDED_MAPS_TITLE,FALSE);
		$output['HMAPSETTINGS']=jr_gettext('_JRPORTAL_EXTENDED_MAPS_MAP_SETTINGS',_JRPORTAL_EXTENDED_MAPS_MAP_SETTINGS,FALSE);
		$output['HMARKERSETTINGS']=jr_gettext('_JRPORTAL_EXTENDED_MAPS_MARKERSETTINGS',_JRPORTAL_EXTENDED_MAPS_MARKERSETTINGS,FALSE);
		$output['HPOPUPSETTINGS']=jr_gettext('_JRPORTAL_EXTENDED_MAPS_HPOPUP_SETTINGS',_JRPORTAL_EXTENDED_MAPS_HPOPUP_SETTINGS,FALSE);

		$jrtbar =jomres_getSingleton('jomres_toolbar');
		$jrtb  = $jrtbar->startTable();
		$jrtb .= $jrtbar->toolbarItem('save','','',true,'save_extended_maps');
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
		$tmpl->readTemplatesFromInput( 'admin_extended_maps.html');
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