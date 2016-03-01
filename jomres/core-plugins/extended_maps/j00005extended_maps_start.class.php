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
 * xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
 #
* @package Jomres
#
 */
class j00005extended_maps_start {

	/**
	#
	 * xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
	#
	 */
	function j00005extended_maps_start($componentArgs)
		{
		// Must be in all minicomponents. Minicomponents with templates that can contain editable text should run $this->template_touch() else just return 
		$MiniComponents =jomres_getSingleton('mcHandler');
		if ($MiniComponents->template_touch)
			{
			$this->template_touchable=false; return;
			}
		$ePointFilepath = get_showtime('ePointFilepath');
		
		require_once($ePointFilepath."extended_maps.class.php");
		
		if (file_exists($ePointFilepath.'language'.JRDS.get_showtime('lang').'.php'))
			require_once($ePointFilepath.'language'.JRDS.get_showtime('lang').'.php');
		else
			{
			if (file_exists($ePointFilepath.'language'.JRDS.'en-GB.php'))
				require_once($ePointFilepath.'language'.JRDS.'en-GB.php');
			}
			
		$obsolete_plugin_files = get_showtime('obsolete_plugin_files');
		$obsolete_plugin_files[] = get_showtime('ePointFilepath').'j00001extended_maps_start.class.php';
		set_showtime('obsolete_plugin_files',$obsolete_plugin_files);
		
				
		$asamodule_plugin_information = get_showtime('asamodule_plugin_information');
		
		$asamodule_plugin_information['j06000extended_maps'] = 
			array(
				"asamodule_task"=>"extended_maps",
				"asamodule_info"=>"Shows google maps with various icons for display of properties, local events and attractions.",
				"asamodule_example_link"=>JOMRES_SITEPAGE_URL_NOSEF.'&tmpl=component&task=extended_maps',
				"asamodule_manual_link"=>''
				);
		set_showtime('asamodule_plugin_information',$asamodule_plugin_information);
		
		}

	// This must be included in every Event/Mini-component
	function getRetVals()
		{
		return null;
		}
	}
?>