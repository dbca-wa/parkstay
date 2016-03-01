<?php
/**
 * Core file
 * @author Vince Wooll <sales@jomres.net>
 * @version Jomres 5
* @package Jomres
* @copyright	2005-2011 Vince Wooll
* Jomres (tm) PHP files are released under both MIT and GPL2 licenses. This means that you can choose the license that best suits your project, and use it accordingly, however all images, css and javascript which are copyright Vince Wooll are not GPL licensed and are not freely distributable. 
**/

// ################################################################
defined( '_JOMRES_INITCHECK' ) or die( '' );
// ################################################################

class j06000featured_listings_slider_1
	{
	function j06000featured_listings_slider_1()
		{
		$MiniComponents =jomres_getSingleton('mcHandler');
		if ($MiniComponents->template_touch)
			{
			$this->template_touchable=false; return;
			}
//		$description_number_of_chars = 200;
 $description_number_of_chars = 88;
		$ePointFilepath = get_showtime('ePointFilepath'); // Need to set this here, because the calls further down will reset the path to the called minicomponent's path.
		if (!using_bootstrap())
			{
			jomres_cmsspecific_addheaddata("javascript",get_showtime('eLiveSite').'javascript/',"coda-slider.1.1.1.pack.js",false);
			jomres_cmsspecific_addheaddata("javascript",get_showtime('eLiveSite').'javascript/',"jquery-easing-1.3.pack.js",false);
			jomres_cmsspecific_addheaddata("javascript",get_showtime('eLiveSite').'javascript/',"jquery-easing-compatibility.1.2.pack.js",false);
			jomres_cmsspecific_addheaddata("css",get_showtime('eLiveSite').'css/','slider.css',false);
			}
		
		//limit displayed properties
		$listLimit = (int)jomresGetParam( $_REQUEST, 'limit', 5)+1;
		// e.g. "hotels:1;villas:6;camp sites:4" 
		$arguments = jomresGetParam( $_REQUEST, 'ptype_ids', '' );
		$property_type_bang = explode (",",$arguments);
		
		$required_property_type_ids = array();
		foreach ($property_type_bang as $ptype)
			{
			$required_property_type_ids[] = (int)$ptype;
			}
		$g_ptype_ids=$this->genericIn($required_property_type_ids);
		
		$query="SELECT property_uid FROM #__jomresportal_featured_properties ORDER BY `order`";
		$featured_propertiesList=doSelectSQL($query);
		if (count($featured_propertiesList)>0)
			{
			foreach ($featured_propertiesList as $p)
				{
				$featured[]=$p->property_uid;
				}
			}
		else
			{
			echo "You haven't featured any properties yet.";
			return;
			}
		
		if (count($featured)>$listLimit)
			$featured=array_splice($featured, $listLimit);
		
		//Grab the property details
		$current_property_details =jomres_getSingleton('basic_property_details');
		$current_property_details->gather_data_multi($featured);
		
		//Grab the property imaages
		$jomres_media_centre_images = jomres_singleton_abstract::getInstance( 'jomres_media_centre_images' );
		$jomres_media_centre_images->get_images_multi($featured, array('property'));
		
		$counter = 1;
		$rows=array();
		foreach ($featured as $f)
			{
			$r = array();
			$property_uid = (int)$f;
			$current_property_details->gather_data($f);
			if ((in_array($current_property_details->ptype_id,$required_property_type_ids) || $required_property_type_ids[0]==0) && $counter<=$listLimit)
				{
				$r['PROPERTY_NAME'] = jomres_decode($current_property_details->property_name);
				$r['ID'] = $counter;
				
				$jomres_media_centre_images->get_images($property_uid, array('property'));
				$r['PROPERTY_IMAGE'] =$jomres_media_centre_images->images ['property'][0][0]['large'];
				$r['PROPERTY_IMAGE_THUMB'] =$jomres_media_centre_images->images ['property'][0][0]['small'];

				$description_stripped =strip_tags(html_entity_decode($current_property_details->property_description));
				$r['PROPERTY_DESCRIPTION'] = substr($description_stripped,0,$description_number_of_chars);
				 $r['PROPERTY_DESCRIPTION'] .=	"...";
				$r['MOREINFORMATIONLINK']=jomresURL( JOMRES_SITEPAGE_URL."&task=viewproperty&property_uid=".$property_uid) ;
				
				if ($counter==1)
					$r['ACTIVE'] = "active";
				else
					$r['ACTIVE'] = '';

				$rows[] = $r;
				$counter++;
				}
			}
		
		
		$rows2=$rows;
		$output['HOME_URL'] = get_showtime('eLiveSite');
		$output['FIRST_PROPERTY_IMAGE_THUMB'] = $rows[0]['PROPERTY_IMAGE_THUMB'];
		$output['TITLE'] = jr_gettext('_JRPORTAL_FEATUREDLISTINGS_TITLE',_JRPORTAL_FEATUREDLISTINGS_TITLE,false,false);
		array_shift ( $rows2 );
		
		$pageoutput[]=$output;
		$tmpl = new patTemplate();
		if (using_bootstrap())
			$tmpl->setRoot( $ePointFilepath.JRDS.'templates'.JRDS.'bootstrap' );
		else
			$tmpl->setRoot( $ePointFilepath.JRDS.'templates'.JRDS.'jquery_ui' );
		$tmpl->readTemplatesFromInput( 'slider.html');
		$tmpl->addRows( 'pageoutput', $pageoutput );
		$tmpl->addRows( 'rows', $rows );
		$tmpl->addRows( 'rows2', $rows2 );
		$tmpl->displayParsedTemplate();
		}

	// This must be included in every Event/Mini-component
	function getRetVals()
		{
		return null;
		}
	
	function genericIn($idArray,$idArrayisInteger=true)
		{
		$newArr=array();
		foreach ($idArray as $id)
			{
			$newArr[]=$id;
			}
		$idArray=$newArr;
		$txt=" ( ";
		for ($i=0, $n=count($idArray); $i < $n; $i++)
			{
			if ($idArrayisInteger)
				$id=(int)$idArray[$i];
			else
				$id=$idArray[$i];
			$txt .= "'$id'";
			if ($i < count($idArray)-1)
				$txt .= ",";
			}
		$txt .= " ) ";
		return $txt;
		}
	}

?>
