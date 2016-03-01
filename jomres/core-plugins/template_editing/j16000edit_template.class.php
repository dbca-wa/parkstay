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

class j16000edit_template {
	function j16000edit_template()
		{
		// Must be in all minicomponents. Minicomponents with templates that can contain editable text should run $this->template_touch() else just return 
		$MiniComponents =jomres_getSingleton('mcHandler');
		if ($MiniComponents->template_touch)
			{
			$this->template_touchable=false; return;
			}
		$editing_by_id = false;
		if (isset($_REQUEST['jomresTemplateFile']))
			$templatename		= jomresGetParam( $_REQUEST, 'jomresTemplateFile', '' );
		else
			{
			$editing_by_id = true;
			$templateid		= jomresGetParam( $_REQUEST, 'id', 0 ); // Identifying templates by their id allows us to begin having templates for different property types
			$copy_template	= jomresGetParam( $_REQUEST, 'copy', false );
			}
		
		$custom_templates =jomres_getSingleton('jomres_custom_template_handler');

		if (!$editing_by_id)
			{
			$ptypeid = 0;
			$templatehtml= $custom_templates->getTemplateData($templatename,$ptypeid);
			}
		else
			{
			foreach ($custom_templates->custom_templates as $ptype)
				{
				foreach ($ptype as $key=>$val)
					{
					if ($key == $templateid)
						{
						
						$ptypeid = $val['ptype_id'];
						$templatehtml =$custom_templates->getTemplateData($val['template_name'],$ptypeid);
						$templatename = $val['template_name'];
						}
					}
				}
			if ($copy_template)
				$templateid = 0;
			}

		$output['TEMPLATEHTML']=str_replace("textarea","text<x>area",$templatehtml);
		$output['TEMPLATENAME']=$templatename;

		$dropdown = '';
		$mode = 'css';
		if ($templatename != "jomrescss_bootstrap.css" && $templatename != "jomrescss.css")
			{
			$dropdown = getPropertyTypeDropdown($ptypeid,true);
			$mode='text/html';
			}
		
		if ($templatename != "jomrescss_bootstrap.css" && $templatename != "jomrescss.css")
			{
			$siteConfig = jomres_singleton_abstract::getInstance('jomres_config_site_singleton');
			$jrConfig=$siteConfig->get();
			if (_JOMRES_DETECTED_CMS == "joomla30" || _JOMRES_DETECTED_CMS == "joomla31")
				$this->using_bootstrap = true;
			else
				{
				if ($jrConfig['use_bootstrap_in_frontend'] == "1")
					$this->using_bootstrap = true;
				else
					$this->using_bootstrap = false;
				}
			
			if ($this->using_bootstrap)
				$original = file_get_contents(JOMRESPATH_BASE.JRDS.'templates'.JRDS.'bootstrap'.JRDS.'frontend'.JRDS.$templatename );
			else
				$original = file_get_contents(JOMRESPATH_BASE.JRDS.'templates'.JRDS.'jquery_ui'.JRDS.'frontend'.JRDS.$templatename);
			}
		else
			$original = file_get_contents(JOMRESPATH_BASE.JRDS."css".JRDS.$templatename );
		
		$jrtbar =jomres_getSingleton('jomres_toolbar');
		$jrtb	= $jrtbar->startTable();
		$jrtb .= $jrtbar->toolbarItem('save','','',true,'save_template');
		$jrtb .= $jrtbar->toolbarItem('cancel',JOMRES_SITEPAGE_URL_ADMIN."&task=listTemplates",'');
		if ($templateid>0)
			$jrtb .= $jrtbar->toolbarItem('delete',JOMRES_SITEPAGE_URL_ADMIN."&task=delete_template&no_html=1&id=".$templateid,'');
		$jrtb .= $jrtbar->endTable();
		$output['JOMRESTOOLBAR']=$jrtb;

		$output['JOMRES_SITEPAGE_URL_ADMIN']=JOMRES_SITEPAGE_URL_ADMIN;

		// We can't use patTemplate to output the template data here because.....it tries to parse the data from the template file _as_ it's own template data. No biggie
		// Back to good ol' "echo" in this script.
		$outputString = '
		<h2>'.$output['TEMPLATENAME'].'</h2>
		
		<form action="'.JOMRES_SITEPAGE_URL_ADMIN.'" method="post" name="adminForm">
		'.$dropdown.'<br/>
		'.$output['JOMRESTOOLBAR'].'
		
		<textarea id=code name=code>'.$output['TEMPLATEHTML'].'</textarea>';
		
		if (!$editing_by_id)
			$outputString .= '<input type="hidden" name="templatename" value="'.$output['TEMPLATENAME'].'" />';
		else
			{
			if ($templateid>0)
				$outputString .= '<input type="hidden" name="id" value="'.$templateid.'" />';
			else
				$outputString .= '<input type="hidden" name="templatename" value="'.$output['TEMPLATENAME'].'" />';
			}

		$outputString .=
		'<input type="hidden" name="task" value="save_template" />
		</form>
		<br/><br/>
		<h1>Original</h1>
		<textarea id=original name=original>'.str_replace("textarea","text<x>area",$original).'</textarea>
		
		<script src='.get_showtime('live_site').'/jomres/javascript/codemirror-2.34/lib/codemirror.js></script>
		<script src='.get_showtime('live_site').'/jomres/javascript/codemirror-2.34/mode/xml/xml.js></script>
		<script src='.get_showtime('live_site').'/jomres/javascript/codemirror-2.34/mode/php/php.js></script>
		<script src='.get_showtime('live_site').'/jomres/javascript/codemirror-2.34/mode/javascript/javascript.js></script>
		<script src='.get_showtime('live_site').'/jomres/javascript/codemirror-2.34/mode/css/css.js></script>
		<script src='.get_showtime('live_site').'/jomres/javascript/codemirror-2.34/mode/htmlmixed/htmlmixed.js></script>
		<link rel=stylesheet href='.get_showtime('live_site').'/jomres/javascript/codemirror-2.34/lib/codemirror.css>

		<style type=text/css>
			.CodeMirror {
			float: left;
			width: 100%;
			border: 1px solid black;
			}
			
		.CodeMirror-scroll {
			height: auto;
			overflow-y: hidden;
			overflow-x: auto;
		}
		</style>
		 
		<script>
		var editor = CodeMirror.fromTextArea(document.getElementById("code"), {
			mode: "'.$mode.'",
			lineNumbers: true,
			lineWrapping: true,
			tabMode: \'indent\'
		});
		var hlLine = editor.setLineClass(0, "activeline");
		var editor = CodeMirror.fromTextArea(document.getElementById("original"), {
			mode: "'.$mode.'",
			lineNumbers: true,
			lineWrapping: true,
			readOnly : true
		});
		</script>
		';
		echo $outputString;
		}

	// This must be included in every Event/Mini-component
	function getRetVals()
		{
		return null;
		}
	}
?>