<?php

// ################################################################
defined( '_JOMRES_INITCHECK' ) or die( '' );
// ################################################################

class j16000save_local_events_settings {
	function j16000save_local_events_settings()
		{
		// Must be in all minicomponents. Minicomponents with templates that can contain editable text should run $this->template_touch() else just return 
		$MiniComponents =jomres_getSingleton('mcHandler');
		if ($MiniComponents->template_touch)
			{
			$this->template_touchable=false; return;
			}
		
		jr_import('local_events');
		$local_events = new local_events();
		$local_events->save_local_events_settings();
		
		jomresRedirect( jomresURL(JOMRES_SITEPAGE_URL_ADMIN."&task=local_events_settings"), "" );
		}

	// This must be included in every Event/Mini-component
	function getRetVals()
		{
		return null;
		}
	}
?>