<?php
/**
 * Core file
 * @author Vince Wooll <sales@jomres.net>
 * @version Jomres 4 
* @package Jomres
* @copyright	2005-2010 Vince Wooll
* Jomres (tm) PHP files are released under both MIT and GPL2 licenses. This means that you can choose the license that best suits your project, and use it accordingly, however all images, css and javascript which are copyright Vince Wooll are not GPL licensed and are not freely distributable. 
**/

// ################################################################
defined( '_JOMRES_INITCHECK' ) or die( '' );
// ################################################################

class j06000funky_search_features
	{
	function j06000funky_search_features()
		{
		$MiniComponents =jomres_getSingleton('mcHandler');
		if ($MiniComponents->template_touch)
			{
			$this->template_touchable=false; return;
			}
		$ePointFilepath = get_showtime('ePointFilepath');
		$output=array();
		$pageoutput = array();
		
		$searchAll = jr_gettext('_JOMRES_SEARCH_ALL',_JOMRES_SEARCH_ALL,false,false);
		$calledByModule="mod_jomsearch_m0";

		jr_import('jomSearch');
		$sch = new jomSearch($calledByModule);
		$customTextObj =jomres_getSingleton('custom_text');
		$output['AJAXURL']=JOMRES_SITEPAGE_URL_AJAX;
		$sch->searchAll=$searchAll;
		$output['CLICKTOHIDE']			=jr_gettext('_JOMRES_REVIEWS_CLICKTOHIDE',_JOMRES_REVIEWS_CLICKTOHIDE,false,false);
		$output['CLICKTOSHOW']			=jr_gettext('_JOMRES_REVIEWS_CLICKTOSHOW',_JOMRES_REVIEWS_CLICKTOSHOW,false,false);
		$output['INSTRUCTIONS']			=jr_gettext('_JOMRES_FUNKYSEARCH_INSTRUCTIONS_FEATURES',_JOMRES_FUNKYSEARCH_INSTRUCTIONS_FEATURES,false,false);
		
		$resultArray=array();
		if (count($sch->prep['features'])>0)
			{
			foreach ($sch->prep['features'] as $feature)
				{
				if (isset($feature['title']))
					{
					$r = array();
					$r['TITLE']=$feature['title'];
					$r['ID']=$feature['id'];
					$resultArray[]=$r;
					}
				}
			array_shift($resultArray);
			}
 
		$pageoutput[]=$output;
		$tmpl = new patTemplate();
		$tmpl->setRoot( $ePointFilepath.JRDS.'templates' );
		if (using_bootstrap())
			$tmpl->readTemplatesFromInput( 'funky_search_bootstrap.html');
		else
			$tmpl->readTemplatesFromInput( 'funky_search.html');
		$tmpl->addRows( 'pageoutput', $pageoutput );
		$tmpl->addRows( 'resultarray', $resultArray );
		$tmpl->displayParsedTemplate();
		}

	function touch_template_language()
		{
		$output=array();
		$output[]	=	jr_gettext('_JOMRES_FUNKYSEARCH_INSTRUCTIONS',_JOMRES_FUNKYSEARCH_INSTRUCTIONS);

		foreach ($output as $o)
			{
			echo $o;
			echo "<br/>";
			}
		}
	// This must be included in every Event/Mini-component
	function getRetVals()
		{
		return null;
		}
	}

?>