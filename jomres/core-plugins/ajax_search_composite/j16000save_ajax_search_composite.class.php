<?php

// ################################################################
defined( '_JOMRES_INITCHECK' ) or die( '' );
// ################################################################

class j16000save_ajax_search_composite {
	function j16000save_ajax_search_composite()
		{
		// Must be in all minicomponents. Minicomponents with templates that can contain editable text should run $this->template_touch() else just return 
		$MiniComponents =jomres_getSingleton('mcHandler');
		if ($MiniComponents->template_touch)
			{
			$this->template_touchable=false; return;
			}
		$ajax_search_composite = new ajax_search_composite();
		$ajax_search_composite->save();
		
		jomresRedirect( jomresURL(JOMRES_SITEPAGE_URL_ADMIN."&task=ajax_search_composite"), "" );
		}

	// This must be included in every Event/Mini-component
	function getRetVals()
		{
		return null;
		}
	}
?>