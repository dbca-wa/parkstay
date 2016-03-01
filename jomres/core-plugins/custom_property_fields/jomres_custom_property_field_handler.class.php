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


class jomres_custom_property_field_handler
	{
	/**
	#
	* Constructor.
	#
	*/
	function jomres_custom_property_field_handler($specific_path=false)
		{
		$this->custom_fields=array();
		$this->custom_fields_by_ptype_id = array();
		$this->getAllCustomFields();
		}

	//function getAllCustomFields()
//		{
//		$query = "SELECT `id`,`fieldname`,`default_value`,`description`,`required`,`order`,`ptype_xref` FROM #__jomres_custom_property_fields_fields ORDER BY `order`";
//		$fields = doSelectSql($query);
//		if (count($fields)>0)
//			{
//			foreach ($fields as $t)
//				{
//				$this->custom_fields[$t->id]=array('uid'=>$t->id,'fieldname'=>$t->fieldname,'default_value'=>$t->default_value,'description'=>$t->description,'required'=>$t->required,'order'=>$t->order,'ptype_xref'=>$t->ptype_xref);
//				}
//			}
//		return $this->custom_fields;
//		}
	
	function getAllCustomFields( $ptype_id = 0 )
		{
		$this->custom_fields_by_ptype_id[ $ptype_id ] = get_showtime( 'custom_fields_by_ptype_id'.$ptype_id );
		$this->custom_fields=get_showtime( 'all_custom_fields' );

		if ( count( $this->custom_fields ) == 0 )
			{
			$query  = "SELECT `id`,`fieldname`,`default_value`,`description`,`required`,`order`,`ptype_xref` FROM #__jomres_custom_property_fields_fields ORDER BY `order`";
			$fields = doSelectSql( $query );
			if ( count( $fields ) > 0 )
				{
				foreach ( $fields as $t )
					{
					$ptype_xref=unserialize($t->ptype_xref);
					if (count($ptype_xref)>0)
						{
						foreach($ptype_xref as $ptype)
							{
							$this->custom_fields_by_ptype_id[ $ptype ][ $t->id ] = array ( 'uid' => $t->id, 'fieldname' => $t->fieldname, 'default_value' => $t->default_value, 'description' => $t->description, 'required' => $t->required, 'ptype_xref' => $t->ptype_xref );
							set_showtime( 'custom_fields_by_ptype_id'.$ptype, $this->custom_fields_by_ptype_id[ $ptype ] );
							}
						$this->custom_fields[$t->id]=array('uid'=>$t->id,'fieldname'=>$t->fieldname,'default_value'=>$t->default_value,'description'=>$t->description,'required'=>$t->required,'order'=>$t->order,'ptype_xref'=>$t->ptype_xref);
						}
					}
				set_showtime( 'all_custom_fields', $this->custom_fields );
				}
			}
		
		if ($ptype_id > 0)
			{
			if (get_showtime( 'custom_fields_by_ptype_id'.$ptype_id ) )
				return $this->custom_fields_by_ptype_id[ $ptype_id ];
			else
				return array();
			}
		else
			return $this->custom_fields;
		}
		
	function get_custom_field_data_for_property_uid($property_uid)
		{
		
		$all_field_names = array();
		foreach ($this->custom_fields as $f)
			{
			$all_field_names[] = $f['fieldname'];
			}
				
		$custom_field_data = array();
		$query = "SELECT id,fieldname,data FROM #__jomres_custom_property_fields_data WHERE property_uid = ".(int)$property_uid;
		$result = doSelectSql($query);
		if (count($result)>0)
			{
			
			foreach ($result as $r)
				{
				if (in_array($r->fieldname,$all_field_names) )
					{
					if ($r->data!='')
						$custom_field_data[$r->fieldname]=jr_gettext("CUSTOM_PROPERTY_FIELD_DATA_".$r->fieldname."_".$property_uid,$r->data,false,false);
					}
				}
			}
			//var_dump($custom_field_data);exit;
		return $custom_field_data;
		}
	}
	
?>