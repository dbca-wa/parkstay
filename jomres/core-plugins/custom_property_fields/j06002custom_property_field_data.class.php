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

class j06002custom_property_field_data
	{
	function j06002custom_property_field_data()
		{
		$MiniComponents =jomres_getSingleton('mcHandler');
		if ($MiniComponents->template_touch)
			{
			$this->template_touchable=true; return;
			}
		$ePointFilepath=get_showtime('ePointFilepath');
		$defaultProperty=getDefaultProperty();
		$output = array();
		$pageoutput = array();
		$rows=array();
		
		$current_property_details = jomres_singleton_abstract::getInstance( 'basic_property_details' );
		$current_property_details->gather_data( $defaultProperty );
		$ptype_id = $current_property_details->ptype_id;
		
		$output['_JOMRES_CUSTOM_PROPERTY_FIELDS_MANAGER_TITLE'] = jr_gettext('_JOMRES_CUSTOM_PROPERTY_FIELDS_MANAGER_TITLE',_JOMRES_CUSTOM_PROPERTY_FIELDS_MANAGER_TITLE,false,false);
		
		jr_import('jomres_custom_property_field_handler');
		$custom_fields = new jomres_custom_property_field_handler();
		$allCustomFields = $custom_fields->getAllCustomFields($ptype_id);
		
		$current_data = $custom_fields->get_custom_field_data_for_property_uid($defaultProperty);
		if (count($allCustomFields)>0)
			{
			foreach ($allCustomFields as $field)
				{
				$r=array();
				$fieldname =$field['fieldname'];
				$r['fieldname']=$fieldname;
				$r['description']=jomres_decode($field['description']);
				if (!isset($current_data[$fieldname]))
					$r['default_value']=jomres_decode($field['default_value']);
				else
					{
					$r['default_value']=jomres_decode($current_data[$fieldname]);
					}
				$rows[]=$r;
				}
			}
		else
			{
			echo "Oops, you haven't created any custom fields in the administrator area";
			return;
			}
		
		$jrtbar =jomres_getSingleton('jomres_toolbar');
		$jrtb  = $jrtbar->startTable();
		$jrtb .= $jrtbar->toolbarItem('save','','',true,'save_custom_property_field_data');
		$jrtb .= $jrtbar->toolbarItem('cancel',jomresURL(JOMRES_SITEPAGE_URL.""),'');
		$jrtb .= $jrtbar->endTable();
		$output['JOMRESTOOLBAR']=$jrtb;
		

		$pageoutput[]=$output;
		$tmpl = new patTemplate();
		if (using_bootstrap())
			$tmpl->setRoot( $ePointFilepath.JRDS.'templates'.JRDS.'bootstrap' );
		else
			$tmpl->setRoot( $ePointFilepath.JRDS.'templates'.JRDS.'jquery_ui' );
		$tmpl->readTemplatesFromInput( 'edit_custom_property_data.html' );
		$tmpl->addRows( 'pageoutput', $pageoutput );
		$tmpl->addRows( 'rows', $rows );
		$tmpl->displayParsedTemplate();
		}

	function touch_template_language()
		{
		$output=array();
		$output[]=jr_gettext('_JOMRES_CUSTOM_PROPERTY_FIELDS_MANAGER_TITLE',_JOMRES_CUSTOM_PROPERTY_FIELDS_MANAGER_TITLE);

		
		foreach ($output as $o)
			{
			echo $o;
			echo "<br/>";
			}
		}
	// This must be included in every Event/Mini-component
	function getRetVals()
		{
		return null;
		}
	}

?>