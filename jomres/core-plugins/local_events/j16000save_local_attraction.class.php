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

class j16000save_local_attraction {
	function j16000save_local_attraction()
		{
		// Must be in all minicomponents. Minicomponents with templates that can contain editable text should run $this->template_touch() else just return 
		if (!function_exists('jomres_getSingleton'))
			global $MiniComponents;
		else
			$MiniComponents =jomres_getSingleton('mcHandler');
		if ($MiniComponents->template_touch)
			{
			$this->template_touchable=false; return;
			}
		$id		= jomresGetParam( $_POST, 'id', 0 );
		$attraction_title			= jomresGetParam( $_POST, 'attraction_title', '' );
		$icon						= jomresGetParam( $_POST, 'icon', '' );
		$latitude				= jomresGetParam( $_POST, 'latitude', '' );
		$longitude				= jomresGetParam( $_POST, 'longitude', '' );
		$websiteurl				= trim(str_replace("http://","", jomresGetParam( $_POST, 'websiteurl', '' )));
		$websiteurl				= str_replace(" ","", $websiteurl);
		$eventlogorelpath		= trim(str_replace("http://","", jomresGetParam( $_POST, 'eventlogorelpath', '' )));
		$description			= jomresGetParam( $_POST, 'description', '' );
		
		if ($id == 0)
			{
			$query = "INSERT INTO #__jomres_local_attractions
				(`title`,`icon`,`latitude`,`longitude`,`website_url`,`event_logo`,`description`) 
				VALUES 
				('".$attraction_title."','".$icon."','".$latitude."','".$longitude."','".$websiteurl."','".$eventlogorelpath."','".$description."')";
			}
		else
			{
			$query = "UPDATE #__jomres_local_attractions SET 
				`title`='".$attraction_title."' ,
				`icon`='".$icon."',
				`latitude`='".$latitude."' ,
				`longitude`='".$longitude."' ,
				`website_url`='".$websiteurl."' ,
				`event_logo`='".$eventlogorelpath."',
				`description`='".$description."'
				WHERE id = ".$id;
			}

		if( doInsertSql($query,"") )
			jomresRedirect( JOMRES_SITEPAGE_URL_ADMIN."&task=list_local_attractions", "" );
		else
			echo "Error saving local attraction";
		}

	// This must be included in every Event/Mini-component
	function getRetVals()
		{
		return null;
		}
	}
?>