<?php

// ################################################################
defined( '_JOMRES_INITCHECK' ) or die( '' );
// ################################################################

class j10002extended_maps
	{
	function j10002extended_maps()
		{
		// Must be in all minicomponents. Minicomponents with templates that can contain editable text should run $this->template_touch() else just return 
		$MiniComponents =jomres_getSingleton('mcHandler');
		if ($MiniComponents->template_touch)
			{
			$this->template_touchable=false; return;
			}
		$htmlFuncs =jomres_getSingleton('html_functions');
		$this->cpanelButton=$htmlFuncs->cpanelButton(JOMRES_SITEPAGE_URL_ADMIN.'&task=extended_maps', 'images/extendedmaps.png', jr_gettext('_JRPORTAL_EXTENDED_MAPS_TITLE',_JRPORTAL_EXTENDED_MAPS_TITLE,false,false),"images/",jr_gettext( "_JOMRES_CUSTOMCODE_MENUCATEGORIES_PORTAL" , _JOMRES_CUSTOMCODE_MENUCATEGORIES_PORTAL ,false,false));
		}
	
	// This must be included in every Event/Mini-component
	function getRetVals()
		{
		return $this->cpanelButton;
		}	
	}
?>