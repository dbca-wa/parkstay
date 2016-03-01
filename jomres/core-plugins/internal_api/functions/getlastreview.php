<?php
/**
 * Core file
 * @author Vince Wooll <sales@jomres.net>
 * @version Jomres 4 
* @package Jomres
* @copyright	2005-2011 Vince Wooll
* Jomres (tm) PHP files are released under both MIT and GPL2 licenses. This means that you can choose the license that best suits your project, and use it accordingly, however all images, css and javascript which are copyright Vince Wooll are not GPL licensed and are not freely distributable. 
**/

// ################################################################
defined( '_JOMRES_INITCHECK' ) or die( '' );
// ################################################################

function jria_getlastreview($arguments)
	{
	$MiniComponents =jomres_singleton_abstract::getInstance('mcHandler');
	$componentArgs=array();
	$componentArgs['property_uid']=(int)$arguments['property_uid'];
	set_showtime('property_uid',(int)$arguments->property_uid);

	$reviews = array();
	$query = "SELECT * FROM #__jomres_reviews_ratings ORDER BY rating_id DESC LIMIT 1";
	$result = DoSelectSql($query);
	if (count($result)==1)
		{
		foreach ($result as $res)
			{
			$property_uid = $res->item_id;
			$reviews[$res->rating_id]['rating_id']=$res->rating_id;
			$reviews[$res->rating_id]['property_uid']=$res->item_id;
			$reviews[$res->rating_id]['user_id']=$res->user_id;
			$reviews[$res->rating_id]['review_title']=$res->review_title;
			$reviews[$res->rating_id]['review_description']=$res->review_description;
			$reviews[$res->rating_id]['pros']=$res->pros;
			$reviews[$res->rating_id]['cons']=$res->cons;
			$reviews[$res->rating_id]['rating']=$res->rating;
			$reviews[$res->rating_id]['rating_ip']=$res->rating_ip;
			$reviews[$res->rating_id]['rating_date']=$res->rating_date;
			$reviews[$res->rating_id]['published']=$res->published;
			}
		}
	set_showtime("internal_api_results",$reviews);
	}
?>