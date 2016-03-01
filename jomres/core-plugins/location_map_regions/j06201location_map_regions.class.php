<?php
/**
 * Core file
 * @author Vince Wooll <sales@jomres.net>
 * @version Jomres 5
* @package Jomres
* @copyright	2005-2011 Vince Wooll
* Jomres (tm) PHP files are released under both MIT and GPL2 licenses. This means that you can choose the license that best suits your project, and use it accordingly, however all images, css and javascript which are copyright Vince Wooll are not GPL licensed and are not freely distributable. 
**/

// ################################################################
defined( '_JOMRES_INITCHECK' ) or die( '' );
// ################################################################

class j06201location_map_regions
	{
	function j06201location_map_regions()
		{
		$MiniComponents =jomres_getSingleton('mcHandler');
		if ($MiniComponents->template_touch)
			{
			$this->template_touchable=true; return;
			}
		$ePointFilepath = get_showtime('ePointFilepath');
		
		$regions = mega_menu_get_regions_and_towns();

		foreach ($regions as $region=>$towns)
			{
			$o = array();
			$po = array();
			if (isset($region) )
				{
				$o['TITLE_TEXT'] = jomres_decode($region);
				$o['TITLE_URL'] = jomresURL(JOMRES_SITEPAGE_URL.'&send=Search&calledByModule=mod_jomsearch_m0&region='.jomres_decode($region));
				$rows=array();
				ksort($towns);
				foreach ($towns as $town)
					{
					$r = array();
					if ($town != "")
						{
						$r['TEXT'] = $town;
						$r['URL'] = jomresURL(JOMRES_SITEPAGE_URL.'&send=Search&calledByModule=mod_jomsearch_m0&region='.jomres_decode($region).'&town='.jomres_decode($town) );
						$rows[] = $r;
						}
					}

				$po[]=$o;
				$tmpl = new patTemplate();
				if (using_bootstrap())
					$tmpl->setRoot( $ePointFilepath.JRDS."templates".JRDS."bootstrap" );
				else
					$tmpl->setRoot( $ePointFilepath.JRDS."templates".JRDS."jquery_ui" );
				$tmpl->readTemplatesFromInput( 'links.html');
				$tmpl->addRows( 'pageoutput', $po );
				$tmpl->addRows( 'rows', $rows );
				$links[] = array('LINK'=>$tmpl->getParsedTemplate() );
				}
			}
		$pageoutput[]=$output;
		$tmpl = new patTemplate();
		$tmpl->setRoot( $ePointFilepath.'templates' );
		if (using_bootstrap())
			$tmpl->setRoot( $ePointFilepath.JRDS."templates".JRDS."bootstrap" );
		else
			$tmpl->setRoot( $ePointFilepath.JRDS."templates".JRDS."jquery_ui" );
		$tmpl->readTemplatesFromInput( 'wrapper.html');
		$tmpl->addRows( 'pageoutput', $pageoutput );
		$tmpl->addRows( 'links', $links );
		$content = $tmpl->getParsedTemplate();
		$this->ret_vals = array('content'=>$content,"title"=>jr_gettext('_JOMRES_MEGA_MENU_REGIONS',"Regions",false,false) );
		}
	
	function touch_template_language()
		{
		$output=array();
		$output[]=jr_gettext('_JOMRES_MEGA_MENU_REGIONS',"Regions");

		foreach ($output as $o)
			{
			echo $o;
			echo "<br/>";
			}
		}
	
	// This must be included in every Event/Mini-component
	function getRetVals()
		{
		return $this->ret_vals;
		}
	}

?>