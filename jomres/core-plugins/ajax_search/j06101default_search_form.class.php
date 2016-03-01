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

class j06101default_search_form
	{
	function j06101default_search_form()
		{
		$MiniComponents =jomres_getSingleton('mcHandler');
		if ($MiniComponents->template_touch)
			{
			$this->template_touchable=false; return;
			}
		$pageoutput = array();
		$output = array();
		$rows = array();
		
		$features_array = prepFeatureSearch();
		
		if (count($features_array)>0)
			{
			foreach ($features_array as $feature)
				{
				$id=$feature['id'];
				if ($id > 0) // Need to not use the id 0 as that's a special "all" id that's used by jomsearch, but not by us here
					{
					$image = '/'.$feature['image'];
					$feature_abbv = jr_gettext('_JOMRES_CUSTOMTEXT_FEATURES_ABBV'.(int)$feature['id'],		jomres_decode($feature['title']),false,false);
					$feature_desc = jr_gettext('_JOMRES_CUSTOMTEXT_FEATURES_DESC'.(int)$feature['id'],		jomres_decode($feature['description']),false,false);
					$r['ICON']=jomres_makeTooltip($feature_abbv,$feature_abbv,$feature_desc,$image,"","property_feature",array());
					$r['ID']=$id;
					$rows[]=$r;
					}
				}
			}
		
		$pageoutput[]=$output;
		$tmpl = new patTemplate();
		$tmpl->setRoot( get_showtime('ePointFilepath').JRDS.'templates' );
		$tmpl->readTemplatesFromInput( 'default_search_form.html' );
		$tmpl->addRows( 'pageoutput', $pageoutput );
		$tmpl->addRows( 'rows', $rows );
		$this->ret_vals = $tmpl->getParsedTemplate();
		}
	
	// This must be included in every Event/Mini-component
	function getRetVals()
		{
		return array("SEARCHFORM"=>$this->ret_vals);
		}
	}

?>