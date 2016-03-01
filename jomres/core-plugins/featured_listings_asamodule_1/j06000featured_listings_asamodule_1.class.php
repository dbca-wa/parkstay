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

class j06000featured_listings_asamodule_1
	{
	function j06000featured_listings_asamodule_1()
		{
		$MiniComponents = jomres_singleton_abstract::getInstance( 'mcHandler' );
		if ($MiniComponents->template_touch)
			{
			$this->template_touchable=false; return;
			}
		$jomresConfig_live_site=get_showtime('live_site');
		$ePointFilepath=get_showtime('ePointFilepath');
		$thisJRUser=jomres_getSingleton('jr_user');

		$task = jomresGetParam( $_REQUEST, 'task', '');
		$calledByModule = jomresGetParam( $_REQUEST, 'calledByModule', '');
		$plistpage = jomresGetParam( $_REQUEST, 'plistpage', '');
		if ( $calledByModule != "" || $plistpage != "" )
			return;
		
		//limit displayed properties
		$listLimit = (int)jomresGetParam( $_REQUEST, 'limit', 5);
		// e.g. "hotels:1;villas:6;camp sites:4" 
		$arguments = jomresGetParam( $_REQUEST, 'ptype_ids', '' );
		$property_type_bang = explode (",",$arguments);
		
		if ($arguments!='')
			{
			$required_property_type_ids = array();
			foreach ($property_type_bang as $ptype)
				{
				$required_property_type_ids[] = (int)$ptype;
				}
			$g_ptype_ids=$this->genericIn($required_property_type_ids);
			$clause="AND ptype_id IN ".$g_ptype_ids." ";
			}
		else
			$clause='';

		$featured=array();
		$rows = array();
		$output = array();
		$pageoutput=array();
		$toprowoutput = array();
		
		$query="SELECT property_uid FROM #__jomresportal_featured_properties ORDER BY `order`";
		$featured_listingsList=doSelectSQL($query);
		
		if (count($featured_listingsList)>0)
			{
			foreach ($featured_listingsList as $p)
				{
				$featured[]=$p->property_uid;
				}
			}
		else
			return;

		$g_in=$this->genericIn($featured);
		
		$orderBy="ORDER BY ";
		foreach ($featured as $ft)
			{
			$orderBy.="`propertys_uid` = '".(int)$ft."' DESC,";
			}
		$orderBy=rtrim($orderBy,",");
		
		$query="SELECT propertys_uid FROM #__jomres_propertys WHERE propertys_uid IN $g_in AND published ='1' $clause $orderBy LIMIT $listLimit ";
		$property_info=doSelectSQL($query);
		
		if (count($property_info)>0)
			{
			$propertiesToShow=array();
			foreach ($property_info as $p)
				{
				$propertiesToShow[]=$p->propertys_uid;
				}
			}
		
		$current_property_details = jomres_singleton_abstract::getInstance( 'basic_property_details' );
		$current_property_details->gather_data_multi( $propertiesToShow );
		
		$jomres_media_centre_images = jomres_singleton_abstract::getInstance( 'jomres_media_centre_images' );
		$jomres_media_centre_images->get_images_multi($propertiesToShow, array('property'));

		$rows=array();
		foreach($propertiesToShow as $puid)
			{
			$r= $this->jomresFeaturedPropertysMakeOutput($puid);
			$rows[] = $r;
			$limit_counter++;
			}

		$pageoutput[]=$output;
		$tmpl = new patTemplate();
		if (using_bootstrap())
			$tmpl->setRoot( $ePointFilepath.JRDS."templates".JRDS."bootstrap" );
		else
			$tmpl->setRoot( $ePointFilepath.JRDS."templates".JRDS."jquery_ui" );
		$tmpl->readTemplatesFromInput( 'featured_listings_asamodule_1.html');
		$tmpl->addRows( 'pageoutput',$pageoutput);
		$tmpl->addRows( 'rows',$rows);
		$tmpl->displayParsedTemplate();
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
	
	function jomresFeaturedPropertysMakeOutput($puid)
		{
		$siteConfig = jomres_singleton_abstract::getInstance( 'jomres_config_site_singleton' );
		$jrConfig = $siteConfig->get();
		$customTextObj = jomres_singleton_abstract::getInstance( 'custom_text' );
		$current_property_details = jomres_singleton_abstract::getInstance( 'basic_property_details' );
		$current_property_details->gather_data( $puid );
		set_showtime( 'property_uid', $puid );
		set_showtime( 'property_type', $current_property_details->property_type );
		$customTextObj->get_custom_text_for_property( $puid );
		$jomres_media_centre_images = jomres_singleton_abstract::getInstance( 'jomres_media_centre_images' );
		$jomres_media_centre_images->get_images($puid, array('property'));
						
		$output = array();
		
		$output['NAME']=$current_property_details->property_name;
		$output['STREET']=$current_property_details->property_street;
		$output['TOWN']=$current_property_details->property_town;
		$output['REGION']=$current_property_details->property_region;
		$output['COUNTRY']=$current_property_details->property_country;
		$output['DESCRIPTION']=$current_property_details->property_description;

		$output['IMAGE']=$jomres_media_centre_images->images ['property'][0][0]['small'];
		
		$output['MOREINFORMATION']= jr_gettext('_JOMRES_COM_A_CLICKFORMOREINFORMATION',_JOMRES_COM_A_CLICKFORMOREINFORMATION,$editable=false,true) ;
	
		$output['URL']=jomresURL( JOMRES_SITEPAGE_URL."&task=viewproperty&property_uid=".$puid) ;
		$output['VIEW_LINK']='<a href="'.$output['URL'].'" target="_blank">'.jr_gettext('_JOMRES_COM_A_CLICKFORMOREINFORMATION',_JOMRES_COM_A_CLICKFORMOREINFORMATION,false,false).'</a>';
	
		$output['STARS']="<img src=\"".get_showtime('live_site')."/jomres/images/blank.png\" alt=\"star\" border=\"0\" height=\"1\" hspace=\"10\" vspace=\"1\" />";
	
		$stars=(int)$current_property_details->stars;
		if ($stars>0)
			{
			$starsimage="";
			for ($n=1;$n<=$stars;$n++)
				{
				$starsimage.="<img src=\"".get_showtime( 'live_site' )."/jomres/images/star.png\" alt=\"star\" border=\"0\" />";
				}
			$output['STARS']=$starsimage;
			}
		$output[ 'SUPERIOR' ] = '';
		if ( $current_property_details->superior == 1 ) 
			$output[ 'SUPERIOR' ] = "<img src=\"" . get_showtime( 'live_site' ) . "/jomres/images/superior.png\" alt=\"superior\" border=\"0\" />";
	
		return $output;
		}

	// This must be included in every Event/Mini-component
	function getRetVals()
		{
		return null;
		}
	}	
?>