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

class j06000funky_filter_features
	{
	function j06000funky_filter_features()
		{
		$MiniComponents =jomres_getSingleton('mcHandler');
		if ($MiniComponents->template_touch)
			{
			$this->template_touchable=false; return;
			}
			
		$this->resultBucket = array();

		if ($_GET['field'] == 'feature_ids')
			{
			$feature_string = substr($_GET['value'],0,strlen($_GET['value'])-1);
			$feature_string = filter_var( $feature_string, FILTER_SANITIZE_SPECIAL_CHARS );
			$features = explode(",",$feature_string);
			//$filter = genericOr($features,'property_country',false);

			$ids	=	$features;
			if (!empty($ids) && count($ids)>0)
				{
				$st="";
				foreach ($ids as $id)
					{
					$st.="'%,".$id.",%' AND property_features LIKE ";
					}
				$st=substr($st,0,-28);
				}

			$query="SELECT propertys_uid FROM #__jomres_propertys WHERE property_features LIKE $st AND published = '1'";
			$result=doSelectSql($query);

			foreach ($result as $res)
				{
				$tmp[]=$res->propertys_uid;
				}
			$this->resultBucket=$tmp;
			}

		$componentArgs=array();
		$componentArgs['propertys_uid']=$this->resultBucket;

		$MiniComponents->specificEvent('01010','listpropertys',$componentArgs); 
		
		}
	
	function get_all_properties() 
		{
		$query="SELECT propertys_uid FROM #__jomres_propertys WHERE  published='1' ORDER BY property_name";
		$result=doSelectSql($query);
		$tmp=array();
		foreach ($result as $res)
			{
			$tmp[]=$res->propertys_uid;
			}
		$this->resultBucket=$tmp;
		}
	
	// This must be included in every Event/Mini-component
	function getRetVals()
		{
		return null;
		}
	}

?>