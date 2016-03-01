<?php

// ################################################################
defined( '_JOMRES_INITCHECK' ) or die( '' );
// ################################################################

class j16000ajax_search_composite
	{
	function j16000ajax_search_composite()
		{
		// Must be in all minicomponents. Minicomponents with templates that can contain editable text should run $this->template_touch() else just return
		$MiniComponents =jomres_getSingleton('mcHandler');
		if ($MiniComponents->template_touch)
			{
			$this->template_touchable=false; return;
			}
		$ePointFilepath = get_showtime('ePointFilepath');
		$jomresConfig_live_site = get_showtime('live_site');
		
		$output=array();
		$pageoutput=array();

		$ajax_search_composite = new ajax_search_composite();
		$ajax_search_composite->get();
		
		$output['PAGETITLE']=jr_gettext("_JOMRES_AJAX_SEARCH_COMPOSITE_TITLE",_JOMRES_AJAX_SEARCH_COMPOSITE_TITLE,false);
		
		$options = array();
		$options[] = jomresHTML::makeOption( '1', jr_gettext("_JOMRES_COM_MR_YES",_JOMRES_COM_MR_YES) );
		$options[] = jomresHTML::makeOption( '0', jr_gettext("_JOMRES_COM_MR_NO",_JOMRES_COM_MR_NO) );
		
		$output['BY_STARS']=jomresHTML::selectList( $options, 'by_stars','class="inputbox" size="1"', 'value', 'text', $ajax_search_composite->ajax_search_compositeConfigOptions['by_stars']);
		$output['_JOMRES_AJAX_SEARCH_COMPOSITE_BYSTARS']=jr_gettext('_JOMRES_AJAX_SEARCH_COMPOSITE_BYSTARS',_JOMRES_AJAX_SEARCH_COMPOSITE_BYSTARS,FALSE);
		$output['by_price']=jomresHTML::selectList( $options, 'by_price','class="inputbox" size="1"', 'value', 'text', $ajax_search_composite->ajax_search_compositeConfigOptions['by_price']);
		$output['_JOMRES_AJAX_SEARCH_COMPOSITE_BYPRICES']=jr_gettext('_JOMRES_AJAX_SEARCH_COMPOSITE_BYPRICES',_JOMRES_AJAX_SEARCH_COMPOSITE_BYPRICES,FALSE);
		$output['by_features']=jomresHTML::selectList( $options, 'by_features','class="inputbox" size="1"', 'value', 'text', $ajax_search_composite->ajax_search_compositeConfigOptions['by_features']);
		$output['_JOMRES_AJAX_SEARCH_COMPOSITE_BYFEATURES']=jr_gettext('_JOMRES_AJAX_SEARCH_COMPOSITE_BYFEATURES',_JOMRES_AJAX_SEARCH_COMPOSITE_BYFEATURES,FALSE);
		$output['by_country']=jomresHTML::selectList( $options, 'by_country','class="inputbox" size="1"', 'value', 'text', $ajax_search_composite->ajax_search_compositeConfigOptions['by_country']);
		$output['_JOMRES_AJAX_SEARCH_COMPOSITE_BYCOUNTRY']=jr_gettext('_JOMRES_AJAX_SEARCH_COMPOSITE_BYCOUNTRY',_JOMRES_AJAX_SEARCH_COMPOSITE_BYCOUNTRY,FALSE);
		$output['by_region']=jomresHTML::selectList( $options, 'by_region','class="inputbox" size="1"', 'value', 'text', $ajax_search_composite->ajax_search_compositeConfigOptions['by_region']);
		$output['_JOMRES_AJAX_SEARCH_COMPOSITE_BYREGION']=jr_gettext('_JOMRES_AJAX_SEARCH_COMPOSITE_BYREGION',_JOMRES_AJAX_SEARCH_COMPOSITE_BYREGION,FALSE);
		$output['by_town']=jomresHTML::selectList( $options, 'by_town','class="inputbox" size="1"', 'value', 'text', $ajax_search_composite->ajax_search_compositeConfigOptions['by_town']);
		$output['_JOMRES_AJAX_SEARCH_COMPOSITE_BYTOWN']=jr_gettext('_JOMRES_AJAX_SEARCH_COMPOSITE_BYTOWN',_JOMRES_AJAX_SEARCH_COMPOSITE_BYTOWN,FALSE);

		$output['by_roomtype']=jomresHTML::selectList( $options, 'by_roomtype','class="inputbox" size="1"', 'value', 'text', $ajax_search_composite->ajax_search_compositeConfigOptions['by_roomtype']);
		$output['_JOMRES_AJAX_SEARCH_COMPOSITE_BYROOMTYPE']=jr_gettext('_JOMRES_AJAX_SEARCH_COMPOSITE_BYROOMTYPE',_JOMRES_AJAX_SEARCH_COMPOSITE_BYROOMTYPE,FALSE);
		$output['by_propertytype']=jomresHTML::selectList( $options, 'by_propertytype','class="inputbox" size="1"', 'value', 'text', $ajax_search_composite->ajax_search_compositeConfigOptions['by_propertytype']);
		$output['_JOMRES_AJAX_SEARCH_COMPOSITE_BYPROPERTYTYPE']=jr_gettext('_JOMRES_AJAX_SEARCH_COMPOSITE_BYPROPERTYTYPE',_JOMRES_AJAX_SEARCH_COMPOSITE_BYPROPERTYTYPE,FALSE);
		$output['by_guestnumber']=jomresHTML::selectList( $options, 'by_guestnumber','class="inputbox" size="1"', 'value', 'text', $ajax_search_composite->ajax_search_compositeConfigOptions['by_guestnumber']);
		$output['_JOMRES_AJAX_SEARCH_COMPOSITE_BYGUESTNUMBER']=jr_gettext('_JOMRES_AJAX_SEARCH_COMPOSITE_BYGUESTNUMBER',_JOMRES_AJAX_SEARCH_COMPOSITE_BYGUESTNUMBER,FALSE);
		$output['by_date']=jomresHTML::selectList( $options, 'by_date','class="inputbox" size="1"', 'value', 'text', $ajax_search_composite->ajax_search_compositeConfigOptions['by_date']);
		$output['_JOMRES_AJAX_SEARCH_COMPOSITE_BYDATES']=jr_gettext('_JOMRES_AJAX_SEARCH_COMPOSITE_BYDATES',_JOMRES_AJAX_SEARCH_COMPOSITE_BYDATES,FALSE);
		
		$output['modal']=jomresHTML::selectList( $options, 'modal','class="inputbox" size="1"', 'value', 'text', $ajax_search_composite->ajax_search_compositeConfigOptions['modal']);
		$output['_JOMRES_AJAX_SEARCH_COMPOSITE_MODAL']=jr_gettext('_JOMRES_AJAX_SEARCH_COMPOSITE_MODAL',_JOMRES_AJAX_SEARCH_COMPOSITE_MODAL,FALSE);
		
		
		$jrtbar =jomres_getSingleton('jomres_toolbar');
		$jrtb  = $jrtbar->startTable();
		$jrtb .= $jrtbar->toolbarItem('save','','',true,'save_ajax_search_composite');
		$jrtb .= $jrtbar->toolbarItem('cancel',jomresURL("index.php?option=com_jomres"),'');
		$jrtb .= $jrtbar->endTable();
		$output['JOMRESTOOLBAR']=$jrtb;
		
		$output['JOMRES_SITEPAGE_URL_ADMIN']=JOMRES_SITEPAGE_URL_ADMIN;
		$output['LIVESITE']=get_showtime('live_site');

		$pageoutput[]=$output;
		$tmpl = new patTemplate();
		if (!using_bootstrap())
			$tmpl->setRoot( $ePointFilepath.JRDS.'templates'.JRDS.'jquery_ui' );
		else
			$tmpl->setRoot( $ePointFilepath.JRDS.'templates'.JRDS.'bootstrap' );
		$tmpl->readTemplatesFromInput( 'admin_ajax_search_composite.html');
		$tmpl->addRows( 'pageoutput',$pageoutput);
		$tmpl->displayParsedTemplate();
		}

	//Must be included in every mini-component
	function getRetVals()
		{
		return null;
		}
	}
?>