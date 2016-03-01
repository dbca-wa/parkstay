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

/**
#
 * Passed the property uids to be listed, will re-order those property uids. Allows us to create plugins (for example for the portal) which can create featured properties
 #
* @package Jomres
#
 */
class j01009z_featured_listings
	{
	function j01009z_featured_listings($componentArgs)
		{
		$MiniComponents =jomres_getSingleton('mcHandler');
		if ($MiniComponents->template_touch)
			{
			$this->template_touchable=false; return;
			}
		$siteConfig = jomres_getSingleton('jomres_config_site_singleton');
		$jrConfig=$siteConfig->get();
		$this->propertys_uids=get_showtime('filtered_property_uids');

		$featured=array();
		$query="SELECT a.property_uid FROM #__jomresportal_featured_properties a, #__jomres_propertys b WHERE (a.property_uid = b.propertys_uid) AND b.published = '1' ORDER BY a.order ";
		$x_featured_listingsList=doSelectSQL($query);
		if (count($x_featured_listingsList)>0)
			{
			foreach ($x_featured_listingsList as $p)
				{
				$featured[]=(int)$p->property_uid;
				}
			}

		$featured_listing_ids=array();
		if (count($featured)>0)
			{
			foreach ($featured as $f)
				{
				if (in_array($f,$this->propertys_uids) )
					{
					$featured_listing_ids[]=$f;
					}
				}
			if (count($featured_listing_ids)>0)
				{
				$newArray=array();
				foreach ($this->propertys_uids as $id)
					{
					if (!in_array($id,$featured_listing_ids))
						$newArray[]=$id;
					}

				$this->propertys_uids=array_merge($featured_listing_ids,$newArray);
				}
			}
		set_showtime("featured_properties",$featured_listing_ids);
		
		if (isset($_REQUEST['calledByModule']) || get_showtime('task') == "" )
			{
			$tmpBookingHandler->tmpsearch_data['ajax_list_search_results'] = $this->propertys_uids;
			unset($tmpBookingHandler->tmpsearch_data['ajax_list_properties_sets']);
			}
		}

	// This must be included in every Event/Mini-component
	function getRetVals()
		{
		return $this->propertys_uids;
		}
	}
?>