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


class j06000stepz
	{
	function j06000stepz()
		{
		global $MiniComponents;
		if ($MiniComponents->template_touch)
			{
			$this->template_touchable=true; return;
			}
		global $thisJRUser;
		$output=array();
		$ePointFilepath = get_showtime('ePointFilepath');
		$eLiveSite = get_showtime('eLiveSite');
		
		$task 				= jomresGetParam( $_REQUEST, 'task', "" );
		$no_html			= (int)jomresGetParam( $_REQUEST, 'no_html', 0 );
		
		if ($task == "handlereq")
			return;
		if ($no_html == 1)
			return;
		// if ($thisJRUser->userIsManager)
			// return;
//print_r($_REQUEST);
	
if($_REQUEST['property_uid'] >= 1) {
 	$mrConfig       = getPropertySpecificSettings( $_REQUEST['property_uid'] );
//print_r($mrConfig);
}

if($mrConfig['is_real_estate_listing'] == '0' || $mrConfig['is_real_estate_listing'] == '')
{

		$output['STEP1']	=jr_gettext('_JOMRES_STEPZ_STEP1',_JOMRES_STEPZ_STEP1);
		$output['STEP2']	=jr_gettext('_JOMRES_STEPZ_STEP2',_JOMRES_STEPZ_STEP2);
		$output['STEP3']	=jr_gettext('_JOMRES_STEPZ_STEP3',_JOMRES_STEPZ_STEP3);
		$output['STEP4']	=jr_gettext('_JOMRES_STEPZ_STEP4',_JOMRES_STEPZ_STEP4);
		$output['STEP5']	=jr_gettext('_JOMRES_STEPZ_STEP5',_JOMRES_STEPZ_STEP5);
		$output['STEP6']	=jr_gettext('_JOMRES_STEPZ_STEP6',_JOMRES_STEPZ_STEP6);
}

else 
{
 $output['STEP1']        =jr_gettext('_JOMRES_STEPZ_STEP1',_JOMRES_STEPZ_STEP1);
 $output['STEP2']        =jr_gettext('_JOMRES_STEPZ_STEP2',_JOMRES_STEPZ_STEP2);
if($task == "dobooking")  { 
		$output['STEP3']        =jr_gettext('_JOMRES_STEPZ_STEP3',_JOMRES_STEPZ_STEP3);
                $output['STEP4']        =jr_gettext('_JOMRES_STEPZ_STEP4',_JOMRES_STEPZ_STEP4);
                $output['STEP5']        =jr_gettext('_JOMRES_STEPZ_STEP5',_JOMRES_STEPZ_STEP5);
                $output['STEP6']        =jr_gettext('_JOMRES_STEPZ_STEP6',_JOMRES_STEPZ_STEP6);

	}

}		
		$template_file = "";
		if ($task == "" || $task == "search")
			$template_file = "stepz1.html";
		if ($task == "viewproperty" &&  $mrConfig['is_real_estate_listing'] == 1)
			$template_file = "stepz2a.html";
		 if ($task == "viewproperty" &&  $mrConfig['is_real_estate_listing'] == 0)
                        $template_file = "stepz2.html";
		if ($task == "dobooking")
			$template_file = "stepz3.html";
		if ($task == "confirmbooking" && $mrConfig['is_real_estate_listing'] == 0)
			$template_file = "stepz4.html";
		if ($task == "processpayment" && $mrConfig['is_real_estate_listing'] == 0)
			$template_file = "stepz5.html";
		if ($task == "completebk" && $mrConfig['is_real_estate_listing'] == 0)
			$template_file = "stepz6.html";
		
		if ($template_file == "")
			return;
		
		$pageoutput[]=$output;
		$tmpl = new patTemplate();
		if (using_bootstrap())
			{
			jomres_cmsspecific_addheaddata( "css", $eLiveSite."/templates/bootstrap/","style.css", false );
			}
		
		$tmpl->setRoot( $ePointFilepath.'templates'.JRDS.'bootstrap' );
		$tmpl->readTemplatesFromInput( $template_file );
		$tmpl->addRows( 'pageoutput',$pageoutput);
		$tmpl->displayParsedTemplate();
		}

	function touch_template_language()
		{
		$output=array();

		$output[]	=jr_gettext('_JOMRES_STEPZ_STEP1',_JOMRES_STEPZ_STEP1);
		$output[]	=jr_gettext('_JOMRES_STEPZ_STEP2',_JOMRES_STEPZ_STEP2);
		$output[]	=jr_gettext('_JOMRES_STEPZ_STEP3',_JOMRES_STEPZ_STEP3);
		$output[]	=jr_gettext('_JOMRES_STEPZ_STEP4',_JOMRES_STEPZ_STEP4);
		$output[]	=jr_gettext('_JOMRES_STEPZ_STEP5',_JOMRES_STEPZ_STEP5);
		$output[]	=jr_gettext('_JOMRES_STEPZ_STEP6',_JOMRES_STEPZ_STEP6);

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
