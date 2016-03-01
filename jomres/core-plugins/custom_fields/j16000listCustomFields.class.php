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

class j16000listCustomFields
	{
	function j16000listCustomFields()
		{
		// Must be in all minicomponents. Minicomponents with templates that can contain editable text should run $this->template_touch() else just return
		$MiniComponents =jomres_getSingleton('mcHandler');
		if ($MiniComponents->template_touch)
			{
			$this->template_touchable=false; return;
			}
		$editIcon	='<img src="'.get_showtime('live_site').'/jomres/images/jomresimages/small/EditItem.png" border="0" alt="editicon" />';
		
		$current_property_details =jomres_singleton_abstract::getInstance('basic_property_details');
		$all_ptypes=$current_property_details->all_property_types;
		
		$output=array();
		$output['TITLE']=jr_gettext("_JOMRES_COM_CUSTOMFIELDS_TITLE",_JOMRES_COM_CUSTOMFIELDS_TITLE,false);
		$output['INSTRUCTIONS']=jr_gettext("_JOMRES_COM_CUSTOMFIELDS_DESC",_JOMRES_COM_CUSTOMFIELDS_DESC,false);
		$output['HFIELDNAME']=jr_gettext("_JOMRES_COM_CUSTOMFIELDS_FIELDNAME",_JOMRES_COM_CUSTOMFIELDS_FIELDNAME,false);
		$output['HDEFAULTVALUE']=jr_gettext("_JOMRES_COM_CUSTOMFIELDS_DEFAULTVALUE",_JOMRES_COM_CUSTOMFIELDS_DEFAULTVALUE,false);
		$output['HDESCRIPTION']=jr_gettext("_JOMRES_COM_CUSTOMFIELDS_DESCRIPTION",_JOMRES_COM_CUSTOMFIELDS_DESCRIPTION,false);
		$output['HREQUIRED']=jr_gettext("_JOMRES_COM_CUSTOMFIELDS_REQUIRED",_JOMRES_COM_CUSTOMFIELDS_REQUIRED,false);
		$output[ 'HPROPERTY_TYPES' ] = jr_gettext( '_JOMRES_FRONT_PTYPE', _JOMRES_FRONT_PTYPE,false );
		
		jr_import('jomres_custom_field_handler');
		$custom_fields = new jomres_custom_field_handler();
		$allCustomFields = $custom_fields->getAllCustomFields();
		
		if (count ($allCustomFields)>0)
			{
			foreach ($allCustomFields as $field)
				{
				$ptype_xref=unserialize($field['ptype_xref']);
				$selected_ptype_rows = "";
				foreach ( $ptype_xref as $ptype )
					{
					$selected_ptype_rows .= $current_property_details->all_property_type_titles[ $ptype ] . ", ";
					}
				
				$r=array();
				$r['REQUIRED']=jr_gettext("_JOMRES_COM_MR_NO",_JOMRES_COM_MR_NO,false);
				if ($field['required']==1)
					$r['REQUIRED']="<b>".jr_gettext("_JOMRES_COM_MR_YES",_JOMRES_COM_MR_YES,false)."</b>";

				$r['DEFAULT_VALUE']=$field['default_value'];
				$r['DESCRIPTION']=$field['description'];

				$r['FIELDNAME']=$field['fieldname'];
				$r[ 'PROPERTY_TYPES' ] = $selected_ptype_rows;
				$r['EDITLINK']= '<a href="'.JOMRES_SITEPAGE_URL_ADMIN.'&task=edit_custom_field&uid='.$field['uid'].'">'.$editIcon.'</a>' ;
				
				$rows[]=$r;
				}
			}


		$jrtbar =jomres_getSingleton('jomres_toolbar');
		$jrtb  = $jrtbar->startTable();
		$image = $jrtbar->makeImageValid("/jomres/images/jomresimages/small/AddItem.png");
		$link = JOMRES_SITEPAGE_URL_ADMIN;
		$jrtb .= $jrtbar->customToolbarItem('edit_custom_field',$link,jr_gettext("_JOMRES_COM_MR_NEWTARIFF",_JOMRES_COM_MR_NEWTARIFF,false),$submitOnClick=true,$submitTask="edit_custom_field",$image);
		$jrtb .= $jrtbar->toolbarItem('cancel',JOMRES_SITEPAGE_URL_ADMIN,jr_gettext("_JRPORTAL_CANCEL",_JRPORTAL_CANCEL,false));
		$jrtb .= $jrtbar->spacer();
		$jrtb .= $jrtbar->endTable();
		$output['JOMRESTOOLBAR']=$jrtb;

		$output['JOMRES_SITEPAGE_URL_ADMIN']=JOMRES_SITEPAGE_URL_ADMIN;

		$pageoutput[]=$output;
		$tmpl = new patTemplate();
		$tmpl->setRoot( JOMRES_TEMPLATEPATH_ADMINISTRATOR );
		$tmpl->readTemplatesFromInput( 'list_custom_fields.html');
		$tmpl->addRows( 'pageoutput',$pageoutput);
		$tmpl->addRows( 'rows',$rows);
		$tmpl->displayParsedTemplate();
		}


	// This must be included in every Event/Mini-component
	function getRetVals()
		{
		return null;
		}
	}