<?php
/**
 * Plugin
 * @author Vince Wooll <sales@jomres.net>
 * @version Jomres 4 
* @package Jomres
* @copyright	2005-2010 Vince Wooll
* Jomres (tm) PHP files are released under both MIT and GPL2 licenses. This means that you can choose the license that best suits your project, and use it accordingly, however all images, css and javascript which are copyright Vince Wooll are not GPL licensed and are not freely distributable. 
**/

// ################################################################
defined( '_JOMRES_INITCHECK' ) or die( '' );
// ################################################################

class j16000save_featured_listings
	{
	function j16000save_featured_listings()
		{
		// Must be in all minicomponents. Minicomponents with templates that can contain editable text should run $this->template_touch() else just return 
		$MiniComponents =jomres_getSingleton('mcHandler');
		if ($MiniComponents->template_touch)
			{
			$this->template_touchable=false; return;
			}
		$featured=array();
		$orders=array();
		if (isset($_REQUEST['idarray']) )
			{
			foreach ($_POST['idarray'] as $k=>$v)
				{
				$key=(int)$k;
				$value=(int)$v;
				$featured[$key]=$value;
				}
			}
		foreach ($_POST['orderarray'] as $k=>$v)
			{
			$key=(int)trim($k);
			$value=(int)trim($v);
			$orders[$key]=$value;
			}

		$query="DELETE FROM #__jomresportal_featured_properties";
		$result=doInsertSQL($query,"");
		if (count($featured) >0)
			{
			foreach ($featured as $f)
				{
				$query="INSERT INTO #__jomresportal_featured_properties (`property_uid`,`order`) VALUES (".(int)$f.",".(int)$orders[$f].")";
				$result=doInsertSQL($query,"");
				}
			}
		$query="DELETE FROM #__jomres_site_settings WHERE `akey`='featured_listings_emphasis'";
		$result=doInsertSQL($query,"");
		$class = jomresGetParam($_REQUEST,'emphasis','');
		$query = "INSERT INTO  #__jomres_site_settings (`akey`,`value`) VALUES ('featured_listings_emphasis','".$class."')";
		$result=doInsertSQL($query,"");
		
		jomresRedirect(JOMRES_SITEPAGE_URL_ADMIN."&task=featured_listings", '');
		}
	
	
	// This must be included in every Event/Mini-component
	function getRetVals()
		{
		return null;
		}	
	}