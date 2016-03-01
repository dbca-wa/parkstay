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

class j16000featured_listings {
	function j16000featured_listings()
		{
		// Must be in all minicomponents. Minicomponents with templates that can contain editable text should run $this->template_touch() else just return 
		$MiniComponents =jomres_getSingleton('mcHandler');
		if ($MiniComponents->template_touch)
			{
			$this->template_touchable=false; return;
			}
		$ePointFilepath=get_showtime('ePointFilepath');
		$siteConfig = jomres_singleton_abstract::getInstance('jomres_config_site_singleton');
		$jrConfig=$siteConfig->get();
		
		$output['FEATURED_LISTINGS_CLASS']=$jrConfig['featured_listings_emphasis'];
		$output['HPROPERTYNAME']=jr_gettext("_JRPORTAL_PROPERTIES_PROPERTYNAME",_JRPORTAL_PROPERTIES_PROPERTYNAME,false);
		$output['HPROPERTYADDRESS']=jr_gettext("_JRPORTAL_PROPERTIES_PROPERTYADDRESS",_JRPORTAL_PROPERTIES_PROPERTYADDRESS,false);
		$output['HORDER']=jr_gettext("_JRPORTAL_FEATUREDLISTINGS_ORDER",_JRPORTAL_FEATUREDLISTINGS_ORDER,false);
		$output['_JRPORTAL_FEATUREDLISTINGS_EMPHASIS']=jr_gettext("_JRPORTAL_FEATUREDLISTINGS_EMPHASIS",_JRPORTAL_FEATUREDLISTINGS_EMPHASIS,false);

		$featured=array();
		$query="SELECT `property_uid`,`order` FROM #__jomresportal_featured_properties ORDER BY `order`";
		$featured_listingsList=doSelectSQL($query);
		if (count($featured_listingsList)>0)
			{
			foreach ($featured_listingsList as $p)
				{
				$featured[$p->property_uid]['id']=(int)$p->property_uid;
				$featured[$p->property_uid]['order']=(int)$p->order;
				}
			}

		jr_import('jrportal_property_functions');
			
		$propertyFunctions=new jrportal_property_functions();
		$jomresPropertyList=$propertyFunctions->getAllJomresProperties();

		$counter=0;
		foreach($jomresPropertyList as $k=>$p)
			{
			$r=array();
			$counter++;
			if ($counter % 2)
				$r['STYLE'] ="odd";
			else 
				$r['STYLE'] ="even";
			$checked="";
			$r['ORDER']="";
			$r['PID']=$p['id'];
			if (array_key_exists($p['id'],$featured)  )
				{
				$pid = $p['id'];
				$checked="checked";
				$r['ORDER']=$featured[$pid]['order'];
				}
			$r['CHECKBOX']='<input type="checkbox" name="idarray[]" value="'.$p['id'].'" '.$checked.' />';
			if (function_exists('jomres_decode'))
				{
				$r['PROPERTYNAME']=jomres_decode($p['property_name']);
				$r['PROPERTYADDRESS']=jomres_decode($p['property_street']).', '.jomres_decode($p['property_town']).', '.jomres_decode($p['property_region']).', '.jomres_decode($p['property_country']).', '.$p['property_postcode'];
				}
			else
				{
				$r['PROPERTYNAME']=$p['property_name'];
				$r['PROPERTYADDRESS']=$p['property_street'].', '.$p['property_town'].', '.$p['property_region'].', '.$p['property_country'].', '.$p['property_postcode'];
				}
			$rows[]=$r;
			}

		$jrtbar =jomres_getSingleton('jomres_toolbar');
		$jrtb  = $jrtbar->startTable();
		$jrtb .= $jrtbar->toolbarItem('save','','',true,'save_featured_listings');
		$jrtb .= $jrtbar->toolbarItem('cancel',JOMRES_SITEPAGE_URL_ADMIN,jr_gettext("_JRPORTAL_CANCEL",_JRPORTAL_CANCEL,false));
		$jrtb .= $jrtbar->spacer();
		$jrtb .= $jrtbar->endTable();
		$output['JOMRESTOOLBAR']=$jrtb;
		
		$output['PAGETITLE']=jr_gettext("_JRPORTAL_FEATUREDLISTINGS_TITLE",_JRPORTAL_FEATUREDLISTINGS_TITLE,false);
		$output['HIDDEN'] ='<input type="hidden" name="no_html" value="1">';
		$output['JOMRES_SITEPAGE_URL_ADMIN']=JOMRES_SITEPAGE_URL_ADMIN;
		
		$pageoutput[]=$output;
		$tmpl = new patTemplate();
		if (using_bootstrap())
			$tmpl->setRoot( $ePointFilepath.JRDS."templates".JRDS."bootstrap" );
		else
			$tmpl->setRoot( $ePointFilepath.JRDS."templates".JRDS."jquery_ui" );
		$tmpl->readTemplatesFromInput( 'featured_listings.html');
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
?>