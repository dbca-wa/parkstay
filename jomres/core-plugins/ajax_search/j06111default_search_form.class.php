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

class j06111default_search_form
	{
	function j06111default_search_form()
		{
		$MiniComponents =jomres_getSingleton('mcHandler');
		if ($MiniComponents->template_touch)
			{
			$this->template_touchable=false; return;
			}
		
		$feature_uids = jomresGetParam( $_REQUEST, 'feature_uids', array() );

		if( count($feature_uids) > 0 )
			{
			$st="";
			foreach ($feature_uids as $id)
				{
				$st.="'%,".(int)$id.",%' AND property_features LIKE ";
				}
			$st=substr($st,0,-28);
			}
		
		$query="SELECT propertys_uid FROM #__jomres_propertys WHERE property_features LIKE $st  $property_ors AND published = '1'";
		$result = doSelectSql($query);
		
		$arr = array();
		if (count($result)>0)
			{
			foreach ($result as $r)
				$arr[]=$r->propertys_uid;
			}
		$this->ret_vals = $arr;
		}
	
	// This must be included in every Event/Mini-component
	function getRetVals()
		{
		return $this->ret_vals;
		}
	}

?>