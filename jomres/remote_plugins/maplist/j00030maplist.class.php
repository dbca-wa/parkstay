<?php
/**
 * Core file
 *
 * @author Vince Wooll <sales@jomres.net>
 * @version Jomres 7
 * @package Jomres
 * @copyright    2005-2013 Vince Wooll
 * Jomres (tm) PHP, CSS & Javascript files are released under both MIT and GPL2 licenses. This means that you can choose the license that best suits your project, and use it accordingly.
 **/

// ################################################################
defined( '_JOMRES_INITCHECK' ) or die( '' );
// ################################################################

/**
#
 * The search minicomponent
#
 *
 * @package Jomres
#
 */
class j00030maplist
	{

	/**
	#
	 * Takes information, decides if we have been called by a module or not. If called by a module uses the search object to decide what items the module wants to search upon and performs the search
	#
	 */
	function j00030maplist( $componentArgs )
		{
	//	global $jomressession, $jomresConfig_live_site, $jomresConfig_absolute_path, $itemId, $jrConfig, $ePointFilepath, $mrConfig;
	//	global $eLiveSite, $jomresConfig_live_site, $mosConfig_absolute_path, $mosConfig_lang;

	if (!function_exists('jomres_getSingleton'))
			global $MiniComponents;
		else
			$MiniComponents = jomres_getSingleton('mcHandler');
		if ($MiniComponents->template_touch) {
			$this->template_touchable = false;
			return;
		}
         
        	$plugin = "maplist";

		$path = dirname(realpath(__FILE__));
//print_r($_REQUEST);
$_REQUEST['ml'] = "maplist";
if($_REQUEST['task'] == 'maplist') {
$_REQUEST['task'] = "extended_maps";
//$_REQUEST['country'] = "AU";
//$_REQUEST['region'] = "152";
$ePointFilepath = get_showtime('ePointFilepath');
		$back = "../../core-plugins/";
		require_once($ePointFilepath. $back . "extended_maps/j06000extended_maps.class.php");
        //JRDS = "../../core-plugins/extended_maps/";
            
        $emap = new j06000extended_maps();
        
/*jimport('joomla.application.module.helper');
    // this is where you want to load your module position
    $modules = JModuleHelper::getModules('header'); 
    foreach($modules as $module)
    {
    echo JModuleHelper::renderModule($module);
    }
*/


/*
$document = &JFactory::getDocument();
$renderer       = $document->loadRenderer('module');
$options        = array('style' => 'raw');
$mod = JModuleHelper::getModule('regionDescription');
$mod->params = "cols=2\nrows=10";
echo $renderer->render($mod, $options);
*/

		//	jimport('joomla.application.module.helper');
		//	$module = JModuleHelper::getModule('Breadcrumbs');
		//	echo JModuleHelper::renderModule($module);

	}
    //    require_once("/var/www/parkstay_old_8240/jomres/core-plugins/ajax_search_composite/j06100ajax_search_composite.class.php");
      //  $_REQUEST['task'] = "ajax_search"; 
       // $tmp = "";
     //   $lsearch = new j06100ajax_search_composite($tmp);
      //  $emap
        //$emap = jomres_singleton_abstract::getInstance(j06000extended_maps);
        //j06000extended_maps();
		/*$bookingdata = $componentArgs['bookingdata'];

		$guestdata = $componentArgs['guestdata'];
		$property_uid = $componentArgs['property_uid'];*/
        
      /*  
		$thisJRUser    = jomres_singleton_abstract::getInstance( 'jr_user' );
		$siteConfig    = jomres_singleton_abstract::getInstance( 'jomres_config_site_singleton' );
		$jrConfig      = $siteConfig->get();
		$option        = jomresGetParam( $_REQUEST, 'option', "" );
		$customTextObj = jomres_singleton_abstract::getInstance( 'custom_text' );
print_r($_REQUEST);
		$data_only = false;
		if ( isset( $_REQUEST[ 'dataonly' ] ) ) $data_only = true;

		unset ( $sch );
		$doSearch          = false;
		$includedInModule  = false;
		$calledByModule    = "";
		$searchRestarted   = false;
		$showSearchOptions = true;

 $map = jomres_singleton_abstract::getInstance( 'extended_maps' ); 
print_r($map);*/


		}

	function touch_template_language()
		{
		$output = array ();

		$output[ ] = jr_gettext( '_JOMRES_SEARCH_BUTTON', _JOMRES_SEARCH_BUTTON );
		$output[ ] = jr_gettext( '_JOMRES_FRONT_MR_SEARCH_HERE', _JOMRES_FRONT_MR_SEARCH_HERE );
		$output[ ] = jr_gettext( '_JOMRES_SEARCH_ALL', _JOMRES_SEARCH_ALL );

		$output[ ] = jr_gettext( '_JOMRES_SEARCH_GEO_COUNTRYSEARCH', _JOMRES_SEARCH_GEO_COUNTRYSEARCH );
		$output[ ] = jr_gettext( '_JOMRES_SEARCH_GEO_REGIONSEARCH', _JOMRES_SEARCH_GEO_REGIONSEARCH );
		$output[ ] = jr_gettext( '_JOMRES_SEARCH_GEO_TOWNSEARCH', _JOMRES_SEARCH_GEO_TOWNSEARCH );
		$output[ ] = jr_gettext( '_JOMRES_SEARCH_DESCRIPTION_INFO', _JOMRES_SEARCH_DESCRIPTION_INFO );
		$output[ ] = jr_gettext( '_JOMRES_SEARCH_DESCRIPTION_LABEL', _JOMRES_SEARCH_DESCRIPTION_LABEL );
		$output[ ] = jr_gettext( '_JOMRES_SEARCH_FEATURE_INFO', _JOMRES_SEARCH_FEATURE_INFO );
		$output[ ] = jr_gettext( '_JOMRES_SEARCH_RTYPES', _JOMRES_SEARCH_RTYPES );
		$output[ ] = jr_gettext( '_JOMRES_SEARCH_AVL_INFO', _JOMRES_SEARCH_AVL_INFO );
		$output[ ] = jr_gettext( '_JOMRES_COM_MR_VIEWBOOKINGS_ARRIVAL', _JOMRES_COM_MR_VIEWBOOKINGS_ARRIVAL );
		$output[ ] = jr_gettext( '_JOMRES_COM_MR_VIEWBOOKINGS_DEPARTURE', _JOMRES_COM_MR_VIEWBOOKINGS_DEPARTURE );
		$output[ ] = jr_gettext( '_JOMRES_SEARCH_GUESTNUMBER', _JOMRES_SEARCH_GUESTNUMBER );
		$output[ ] = jr_gettext( '_JOMRES_SEARCH_STARS', _JOMRES_SEARCH_STARS );
		$output[ ] = jr_gettext( '_JOMRES_SEARCH_PRICERANGES', _JOMRES_SEARCH_PRICERANGES );

		$output[ ] = jr_gettext( '_JOMRES_SEARCH_PTYPES', _JOMRES_SEARCH_PTYPES );

		$query        = "SELECT room_classes_uid, room_class_abbv, room_class_full_desc,image FROM #__jomres_room_classes WHERE property_uid = '0' ORDER BY room_class_abbv ";
		$roomTypeList = doSelectSql( $query );
		foreach ( $roomTypeList as $rtype )
			{
			$output[ ] = jr_gettext( _JOMRES_CUSTOMTEXT_ROOMCLASS_DESCRIPTION . $rtype->room_classes_uid, jomres_decode( $rtype->room_class_abbv ) );
			}

		$query     = "SELECT id, ptype FROM #__jomres_ptypes WHERE published = '1' ORDER BY `order` ASC";
		$ptypeList = doSelectSql( $query );
		foreach ( $ptypeList as $ptype )
			{
			$output[ ] = jr_gettext( _JOMRES_CUSTOMTEXT_PROPERTYTYPE . $ptype->id, jomres_decode( $ptype->ptype ) );
			}
		foreach ( $output as $o )
			{
			echo $o;
			echo "<br/>";
			}
		}

	/**
	#
	 * Must be included in every mini-component
	#
	 * Returns any settings the the mini-component wants to send back to the calling script. In addition to being returned to the calling script they are put into an array in the mcHandler object as eg. $mcHandler->miniComponentData[$ePoint][$eName]
	#
	 */
	// This must be included in every Event/Mini-component
	function getRetVals()
		{
		return null;
		}
	}

?>
