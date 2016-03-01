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

class j16000list_custom_property_fields
	{
	function j16000list_custom_property_fields()
		{
		// Must be in all minicomponents. Minicomponents with templates that can contain editable text should run $this->template_touch() else just return
		$MiniComponents =jomres_getSingleton('mcHandler');
		if ($MiniComponents->template_touch)
			{
			$this->template_touchable=false; return;
			}
		$ePointFilepath = get_showtime('ePointFilepath');
		$output=array();
		$sample_template = "";
		
		$output['TITLE']=jr_gettext("_JOMRES_CUSTOM_PROPERTY_FIELDS_MANAGER_TITLE",_JOMRES_CUSTOM_PROPERTY_FIELDS_MANAGER_TITLE,false);
		$output['INSTRUCTIONS']=jr_gettext("_JOMRES_CUSTOM_PROPERTY_FIELDS_INFO",_JOMRES_CUSTOM_PROPERTY_FIELDS_INFO,false);
		$output['HFIELDNAME']=jr_gettext("_JOMRES_COM_CUSTOMFIELDS_FIELDNAME",_JOMRES_COM_CUSTOMFIELDS_FIELDNAME,false);
		$output['HDEFAULTVALUE']=jr_gettext("_JOMRES_COM_CUSTOMFIELDS_DEFAULTVALUE",_JOMRES_COM_CUSTOMFIELDS_DEFAULTVALUE,false);
		$output['HDESCRIPTION']=jr_gettext("_JOMRES_COM_CUSTOMFIELDS_DESCRIPTION",_JOMRES_COM_CUSTOMFIELDS_DESCRIPTION,false);
		$output['HREQUIRED']=jr_gettext("_JOMRES_COM_CUSTOMFIELDS_REQUIRED",_JOMRES_COM_CUSTOMFIELDS_REQUIRED,false);
		$output['HORDER']=jr_gettext("_JOMRES_ORDER",_JOMRES_ORDER);
		$output['_JOMRES_CUSTOM_PROPERTY_FIELDS_INSTRUCTIONS']=jr_gettext("_JOMRES_CUSTOM_PROPERTY_FIELDS_INSTRUCTIONS",_JOMRES_CUSTOM_PROPERTY_FIELDS_INSTRUCTIONS,false);
		$output[ 'HPROPERTY_TYPES' ] = jr_gettext( '_JOMRES_FRONT_PTYPE', _JOMRES_FRONT_PTYPE,false );
		
		jr_import('jomres_custom_property_field_handler');
		$custom_fields = new jomres_custom_property_field_handler();
		$allCustomFields = $custom_fields->getAllCustomFields();
		
		$editIcon	='<img src="'.get_showtime('live_site').'/jomres/images/jomresimages/small/EditItem.png" border="0" alt="editicon" />';
		
		$query      = "SELECT * FROM #__jomres_ptypes";
		$ptypeList  = doSelectSql( $query );
		$all_ptypes = array ();
		if ( count( $ptypeList ) > 0 )
			{
			foreach ( $ptypeList as $ptype )
				{
				$all_ptypes[ $ptype->id ] = $ptype->ptype;
				}
			}

		if (count ($allCustomFields)>0)
			{
			$sample_template .='<patTemplate:tmpl name="pageoutput" unusedvars="strip">';
			foreach ($allCustomFields as $field)
				{
				$ptype_xref=unserialize($field['ptype_xref']);
				$selected_ptype_rows = "";
				foreach ( $ptype_xref as $ptype )
					{
					$selected_ptype_rows .= $all_ptypes[ $ptype ] . ", ";
					}
				
				$r=array();
				$r['REQUIRED']=jr_gettext("_JOMRES_COM_MR_NO",_JOMRES_COM_MR_NO);
				if ($field['required']==1)
					$r['REQUIRED']="<b>".jr_gettext("_JOMRES_COM_MR_YES",_JOMRES_COM_MR_YES,false)."</b>";
				$r['DEFAULT_VALUE']=$field['default_value'];
				$r['DESCRIPTION']=$field['description'];
				$r['ORDER']=$field['order'];
				$r['FIELDNAME']=$field['fieldname'];
				$r['EDITLINK']= '<a href="'.JOMRES_SITEPAGE_URL_ADMIN.'&task=edit_custom_property_field&uid='.$field['uid'].'">'.$editIcon.'</a>' ;
				$r[ 'PROPERTY_TYPES' ] = $selected_ptype_rows;
				$rows[]=$r;
				$sample_template .= '<div><b>{'.strtoupper($field['fieldname']).'_DESC}</b> {'.strtoupper($field['fieldname']).'}</div>';
				}
			$sample_template .='</patTemplate:tmpl>';
			}

		$jrtbar =jomres_getSingleton('jomres_toolbar');
		$jrtb  = $jrtbar->startTable();
		$image = $jrtbar->makeImageValid("/jomres/images/jomresimages/small/AddItem.png");
		$link = JOMRES_SITEPAGE_URL_ADMIN;
		$jrtb .= $jrtbar->customToolbarItem('edit_custom_field',$link,jr_gettext("_JOMRES_COM_MR_NEWTARIFF",_JOMRES_COM_MR_NEWTARIFF,false),$submitOnClick=true,$submitTask="edit_custom_property_field",$image);
		$jrtb .= $jrtbar->toolbarItem('cancel',JOMRES_SITEPAGE_URL_ADMIN,jr_gettext("_JRPORTAL_CANCEL",_JRPORTAL_CANCEL,false));
		$jrtb .= $jrtbar->spacer();
		$jrtb .= $jrtbar->endTable();
		$output['JOMRESTOOLBAR']=$jrtb;

		$output['JOMRES_SITEPAGE_URL_ADMIN']=JOMRES_SITEPAGE_URL_ADMIN;
		$output['SAMPLE_TEMPLATE']='<textarea class="inputbox" cols="100" rows="30" >'.$sample_template.'</textarea>';

		$pageoutput[]=$output;
		$tmpl = new patTemplate();
		if (using_bootstrap())
			$tmpl->setRoot( $ePointFilepath.JRDS.'templates'.JRDS.'bootstrap' );
		else
			$tmpl->setRoot( $ePointFilepath.JRDS.'templates'.JRDS.'jquery_ui' );
		$tmpl->readTemplatesFromInput( 'list_custom_property_data.html');
		$tmpl->addRows( 'pageoutput',$pageoutput);
		$tmpl->addRows( 'rows',$rows);
		$tmpl->displayParsedTemplate();
		echo $output['SAMPLE_TEMPLATE'];
		}


	// This must be included in every Event/Mini-component
	function getRetVals()
		{
		return null;
		}
	}