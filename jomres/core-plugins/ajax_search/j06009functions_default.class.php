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

class j06009functions_default
	{
	function j06009functions_default()
		{
		$MiniComponents =jomres_getSingleton('mcHandler');
		if ($MiniComponents->template_touch)
			{
			$this->template_touchable=false; return;
			}
		
		jr_import('jomSearch');
		
		}
	
	// This must be included in every Event/Mini-component
	function getRetVals()
		{
		if (isset($this->ret_vals))
			return array("SEARCHFORM"=>$this->ret_vals);
		else
			return true;
		}
	}

function prep_ajax_search_filter_cache()
	{
	$tmpBookingHandler =jomres_getSingleton('jomres_temp_booking_handler');
	if (!isset($tmpBookingHandler->tmpsearch_data['ajax_search_plugin_filter']))
		$tmpBookingHandler->tmpsearch_data['ajax_search_plugin_filter'] = array();
	
	}

function add_value_to_filter($id,$value)
	{
	$tmpBookingHandler =jomres_getSingleton('jomres_temp_booking_handler');
	$tmpBookingHandler->tmpsearch_data['ajax_search_plugin_filter'][$id]=$value;
	}

function remove_value_from_filter($id)
	{
	unset($tmpBookingHandler->tmpsearch_data['ajax_search_plugin_filter'][$id]);
	}

?>