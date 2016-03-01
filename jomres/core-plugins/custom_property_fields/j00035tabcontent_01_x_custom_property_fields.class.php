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

class j00035tabcontent_01_x_custom_property_fields
	{
	function j00035tabcontent_01_x_custom_property_fields($componentArgs)
		{
		$MiniComponents =jomres_getSingleton('mcHandler');
		if ($MiniComponents->template_touch)
			{
			$this->template_touchable=false; return;
			}
		$property_uid=(int)$componentArgs['property_uid'];  
		$ePointFilepath=get_showtime('ePointFilepath');
		$mrConfig=getPropertySpecificSettings($property_uid);
		$output = array();
		
		$current_property_details = jomres_singleton_abstract::getInstance( 'basic_property_details' );
		$current_property_details->gather_data( $property_uid );
		$ptype_id = $current_property_details->ptype_id;
		
		jr_import('jomres_custom_property_field_handler');
		$custom_fields = new jomres_custom_property_field_handler();
		$allCustomFields = $custom_fields->getAllCustomFields($ptype_id);
		$current_data = $custom_fields->get_custom_field_data_for_property_uid($property_uid);
		if (count($current_data)==0) // Nothing to see here, move along
			return;
		
		$all_fields=array();
		foreach ($allCustomFields as $field) // Just grabbing the stuff we need from the allCustomFields arr
			{
			$all_field_descriptions[$field['fieldname']]=$field['description'];
			}
		
		foreach ($current_data as $fieldname=>$fielddata)
			{
			$field_title = $all_field_descriptions[$fieldname];
			$output[$fieldname] = jomres_decode($fielddata);
			$output[$fieldname."_DESC"] = jomres_decode(jr_gettext("CUSTOM_PROPERTY_FIELD_TITLE_".$fieldname."_".$property_uid,$field_title) );
			}
		
		$pageoutput[]=$output;
		$tmpl = new patTemplate();
		$tmpl->addRows( 'pageoutput', $pageoutput );
		$tmpl->setRoot( $ePointFilepath.JRDS.'templates' );
		
		$tmpl->readTemplatesFromInput( 'tabcontent_01_custom_property_fields.html');
		$parsedTemplate = $tmpl->getParsedTemplate();

		$anchor = jomres_generate_tab_anchor(jr_gettext("_JOMRES_CUSTOM_PROPERTY_FIELDS_MANAGER_TITLE",_JOMRES_CUSTOM_PROPERTY_FIELDS_MANAGER_TITLE,false));
		$tab = array(
			"TAB_ANCHOR"=>$anchor,
			"TAB_TITLE"=>jr_gettext("_JOMRES_CUSTOM_PROPERTY_FIELDS_MANAGER_TITLE",_JOMRES_CUSTOM_PROPERTY_FIELDS_MANAGER_TITLE,false),
			"TAB_CONTENT"=>$parsedTemplate
			);
		$this->retVals = $tab;
		
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
		return $this->retVals;
		}

	}
?>