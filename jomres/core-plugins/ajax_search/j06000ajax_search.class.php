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

class j06000ajax_search
	{
	function j06000ajax_search()
		{
		$MiniComponents =jomres_getSingleton('mcHandler');
		if ($MiniComponents->template_touch)
			{
			$this->template_touchable=false; return;
			}
		$ePointFilepath = get_showtime('ePointFilepath'); // Need to set this here, because the calls further down will reset the path to the called minicomponent's path.
		
		$siteConfig = jomres_getSingleton('jomres_config_site_singleton');
		$jrConfig=$siteConfig->get();
		
		if (isset($_REQUEST['task'])) // Showing ajax search on the same page as the booking form may result in conflicts, so it needs to be switched off if we're on the booking form. Did this because from time to time the booking form wouldn't process the booking as ok_to_book, presumably ajax search was sending something that was also in the booking form which caused this flag to be set to false.
			{
			if ($_REQUEST['task'] == "dobooking" || ($_REQUEST['task'] == "viewproperty" && $jrConfig['show_booking_form_in_property_details'] =="1") || ($_REQUEST['task'] == "preview" && $jrConfig['show_booking_form_in_property_details'] =="1") )
				return;
			}
		
		$search_form = jomresGetParam( $_REQUEST, 'ajs_plugin', "" );
		jomres_cmsspecific_addheaddata("javascript",'jomres/javascript/',"jquery.livequery.js");
		
		// We'll use 06009 to include any files that contain functions that might be needed by these scripts. In our default one, we will include a 06009 that imports the jomSearch.class.php because we'll want to use the prep search functions (beats reinventing the wheel). An ajax search minicomponent can have it's own 06009 for it's own search functions, if needed, or it could use the ones in jomSearch.
		$MiniComponents->triggerEvent('06009');
		prep_ajax_search_filter_cache();
		//add_gmaps_source();
		
		$pageoutput = array();
		$output = array();
		$f = array();
		$forms = array();
		$output['AJAXURL']=JOMRES_SITEPAGE_URL_AJAX;
		
		$random_identifier = generateJomresRandomString(10);
		
		// First we'll see if we have been told to run a specific ajax search plugin. If we haven't, we'll try to find ANY 6100 plugin. If that doesn't exist, we'll fall back to the default (6101) region search
		$componentArgs=array("FORM_NAME"=>$random_identifier);
		if ($MiniComponents->eventSpecificlyExistsCheck('06100',$search_form) && $search_form != "" )
			$result=$MiniComponents->specificEvent('06100',$search_form,$componentArgs);
		else if ($MiniComponents->eventFileExistsCheck('06100'))
			$result=$MiniComponents->triggerEvent('06100',$componentArgs);
		else
			$result=$MiniComponents->triggerEvent('06101',$componentArgs);
		
		
		$output['FORM_NAME']=$random_identifier;
		if (isset($result['button_on']))
			{
			if (!using_bootstrap())
				$output['SUBMITBUTTON']='<button name="searchbutton" class="fg-button ui-state-default ui-corner-all" type="button" onclick="submit_search(\''.$random_identifier.'\');">'.jr_gettext('_JOMRES_SEARCH_BUTTON',_JOMRES_SEARCH_BUTTON,false,false).'</button>';
			else
				$output['SUBMITBUTTON']='<button name="searchbutton" class="btn btn-primary" type="button" onclick="submit_search(\''.$random_identifier.'\');">'.jr_gettext('_JOMRES_SEARCH_BUTTON',_JOMRES_SEARCH_BUTTON,false,false).'</button>';
			}
		else
			{
			$output['ONCHANGE_JAVASCRIPT']='
			// Binds to the form so triggers the ajax search on change
			jomresJquery(function(){
				jomresJquery("#'.$random_identifier.'").change(
					function(){
						submit_search("'.$random_identifier.'");
						killScroll = false; // IMPORTANT
						last_scrolled_id = 0;
						}
					);
				});
				';
			}

		if (!defined('_JOMRES_AJAX_SEARCH_SUBMIT_FUNCTION'))
			{
			define('_JOMRES_AJAX_SEARCH_SUBMIT_FUNCTION',1);
			
			
			if ($_REQUEST['option'] == "com_jomres")
				$content_div = 'jomres_content_area';
			else
				$content_div = 'asamodule_search_results';
			$output['SUBMIT_FUNCTION']='
function submit_search(form_name)
	{
	//jomresJquery(\'#'.$content_div.'\').fadeThenSlideToggle();
	//populateDiv(\''.$content_div.'\',\'<img src="'.get_showtime("live_site").'/jomres/images/ajax_animation/broken_circle.gif" alt="ajax_animation_image"/>\');
	var_form_data = jomresJquery("#"+form_name).serialize();
	jomresJquery.get(\''.JOMRES_SITEPAGE_URL_AJAX.'\'+\'&task=ajax_search_filter&nofollowtmpl&\'+var_form_data,
		function(data){
			
			var result = data.split("^");
			populateDiv(\''.$content_div.'\',result[0]);
			jomresJquery("html, body").animate({ scrollTop: jomresJquery(\'#jomres_content_area\').position.top }, 600);
			parse_ajax_returned_scripts(data);
			//jomresJquery(\'#'.$content_div.'\').fadeThenSlideToggle();
			jomresJquery(\'.plist-button\').livequery(function() {
				jomresJquery(this).button();
				jomresJquery(this).show();
				});
			jomresJquery(\'.plist-button-last\').livequery(function() {
				jomresJquery(this).button();
				jomresJquery(this).show();
				});
			bind_data_toggle();
			jomresJquery("input[type=checkbox][name=compare]").click(function() {
				var bol = jomresJquery("input[type=checkbox][name=compare]:checked").length >= 3;
				jomresJquery("input[type=checkbox][name=compare]").not(":checked").attr("disabled",bol);
				});
			}
		);
	}
		';
			};

		jomres_cmsspecific_addheaddata("javascript",'jomres/javascript/',"list_properties.js",'',true);
		$f['SEARCHFORM']=$result['SEARCHFORM'];
		
		$forms[]=$f;
		$pageoutput[]=$output;
		$tmpl = new patTemplate();
		$tmpl->setRoot( $ePointFilepath.'templates' );
		$tmpl->readTemplatesFromInput( 'ajax_search.html' );
		$tmpl->addRows( 'pageoutput', $pageoutput );
		$tmpl->addRows( 'forms', $forms );
		$tmpl->displayParsedTemplate();
		}
	
	// This must be included in every Event/Mini-component
	function getRetVals()
		{
		return null;
		}
	}

?>