<?php

// ################################################################
defined( '_JOMRES_INITCHECK' ) or die( '' );
// ################################################################

class j16000save_extended_maps {
	function j16000save_extended_maps()
		{
		// Must be in all minicomponents. Minicomponents with templates that can contain editable text should run $this->template_touch() else just return 
		$MiniComponents =jomres_getSingleton('mcHandler');
		if ($MiniComponents->template_touch)
			{
			$this->template_touchable=false; return;
			}

		$extended_maps = new jrportal_extended_maps();
		$extended_maps->save_extended_maps();
		
		jomresRedirect( jomresURL(JOMRES_SITEPAGE_URL_ADMIN."&task=extended_maps"), "" );
		}

	// This must be included in every Event/Mini-component
	function getRetVals()
		{
		return null;
		}
	}
?>