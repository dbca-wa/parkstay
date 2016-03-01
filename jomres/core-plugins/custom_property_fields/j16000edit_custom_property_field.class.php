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

class j16000edit_custom_property_field {
	function j16000edit_custom_property_field()
		{
		// Must be in all minicomponents. Minicomponents with templates that can contain editable text should run $this->template_touch() else just return 
		$MiniComponents =jomres_getSingleton('mcHandler');
		if ($MiniComponents->template_touch)
			{
			$this->template_touchable=false; return;
			}
		$ePointFilepath = get_showtime('ePointFilepath');
		$output=array();
		$uid=intval(jomresGetParam( $_REQUEST, 'uid', 0 ));

		$output['HFIELD']=jr_gettext("_JOMRES_COM_CUSTOMFIELDS_FIELDNAME",_JOMRES_COM_CUSTOMFIELDS_FIELDNAME,false);
		$output['HDEFAULT_VALUE']=jr_gettext("_JOMRES_COM_CUSTOMFIELDS_DEFAULTVALUE",_JOMRES_COM_CUSTOMFIELDS_DEFAULTVALUE,false);
		$output['HDESCRIPTION']=jr_gettext("_JOMRES_COM_CUSTOMFIELDS_DESCRIPTION",_JOMRES_COM_CUSTOMFIELDS_DESCRIPTION,false);
		$output['HREQUIRED']=jr_gettext("_JOMRES_COM_CUSTOMFIELDS_REQUIRED",_JOMRES_COM_CUSTOMFIELDS_REQUIRED,false);
		$output['PAGETITLE']=jr_gettext("_JOMRES_CUSTOM_PROPERTY_FIELDS_TITLE_EDIT",_JOMRES_CUSTOM_PROPERTY_FIELDS_TITLE_EDIT,false);
		$output[ '_JOMRES_PROPERTY_TYPE_ASSIGNMENT' ] = jr_gettext( '_JOMRES_PROPERTY_TYPE_ASSIGNMENT', _JOMRES_PROPERTY_TYPE_ASSIGNMENT,false );

		$yesno = array();
		$yesno[] = jomresHTML::makeOption( '0', jr_gettext("_JOMRES_COM_MR_NO",_JOMRES_COM_MR_NO,false) );
		$yesno[] = jomresHTML::makeOption( '1', jr_gettext("_JOMRES_COM_MR_YES",_JOMRES_COM_MR_YES,false) );
			
		jr_import('jomres_custom_property_field_handler');
		$custom_fields = new jomres_custom_property_field_handler();
		$allCustomFields = $custom_fields->getAllCustomFields();
		
		$thisField = $allCustomFields[$uid];
		
		$query     = "SELECT * FROM #__jomres_ptypes";
		$ptypeList = doSelectSql( $query );
		
		$ptype_xref=unserialize($thisField['ptype_xref']);
		
		$all_ptype_rows = array ();
		if ( count( $ptypeList ) > 0 )
			{
			foreach ( $ptypeList as $ptype )
				{
				$row                        = array ();
				$row[ 'propertytype_id' ]   = $ptype->id;
				$row[ 'propertytype_desc' ] = $ptype->ptype;
				$row[ 'checked' ]           = "";
				if ( in_array( $ptype->id, $ptype_xref ) ) $row[ 'checked' ] = " checked ";
				$all_ptype_rows[ ] = $row;
				}
			}

		$output['FIELDNAME']=$thisField['fieldname'];
		$output['DEFAULT_VALUE']=$thisField['default_value'];
		$output['DESCRIPTION']=$thisField['description'];
		$output['REQUIRED']=jomresHTML::selectList( $yesno, 'required','class="inputbox" size="1"', 'value', 'text', $thisField['required']);
		$output['UID']=$thisField['uid'];
		
		$jrtbar =jomres_getSingleton('jomres_toolbar');
		$jrtb  = $jrtbar->startTable();
		$jrtb .= $jrtbar->toolbarItem('save','','',true,'save_custom_property_field');
		$jrtb .= $jrtbar->toolbarItem('cancel',JOMRES_SITEPAGE_URL_ADMIN."&task=list_custom_property_fields",'');
		if ($uid>0)
			$jrtb .= $jrtbar->toolbarItem('delete',JOMRES_SITEPAGE_URL_ADMIN."&task=delete_custom_property_field&no_html=1&uid=".$uid,'');
		$jrtb .= $jrtbar->endTable();
		$output['JOMRESTOOLBAR']=$jrtb;

		$output['JOMRES_SITEPAGE_URL_ADMIN']=JOMRES_SITEPAGE_URL_ADMIN;
		
		$pageoutput[]=$output;
		$tmpl = new patTemplate();
		
		if (using_bootstrap())
			$tmpl->setRoot( $ePointFilepath.JRDS.'templates'.JRDS.'bootstrap' );
		else
			$tmpl->setRoot( $ePointFilepath.JRDS.'templates'.JRDS.'jquery_ui' );
		$tmpl->readTemplatesFromInput( 'edit_custom_property_field.html' );
		$tmpl->addRows( 'pageoutput', $pageoutput );
		$tmpl->addRows( 'all_ptype_rows', $all_ptype_rows );
		$tmpl->displayParsedTemplate();
		}

	// This must be included in every Event/Mini-component
	function getRetVals()
		{
		return null;
		}
	}
?>