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

class j16000save_template 
	{
	function j16000save_template()
		{
		// Must be in all minicomponents. Minicomponents with templates that can contain editable text should run $this->template_touch() else just return 
		$MiniComponents =jomres_getSingleton('mcHandler');
		if ($MiniComponents->template_touch)
			{
			$this->template_touchable=false; return;
			}
		//
		
		$templateData		= str_replace("text<x>area","textarea",$_REQUEST['code']);
		$last_edited		= date( 'Y-m-d H:i:s' );
		$templateData		= addslashes(htmlspecialchars($templateData));
		$propertyType		= jomresGetParam( $_REQUEST, 'propertyType', 0 );
		$custom_templates =jomres_getSingleton('jomres_custom_template_handler');

		if (isset($_REQUEST['templatename']))
			$templatename		= jomresGetParam( $_REQUEST, 'templatename', '' );
		else
			{
			$templateid		= jomresGetParam( $_REQUEST, 'id', 0 ); 
			if ($templateid > 0)
				{
				foreach ($custom_templates->custom_templates as $key=>$val)
					{
					foreach ($val as $t)
						{
						if ($t['id'] == $templateid && $t['ptype_id'] == $propertyType)
							{
							$templatename		= $t['template_name'];
							}
						}
					}
				}
			}

		if ($custom_templates->hasThisTemplateBeenCustomised($templatename,$propertyType))
			{
			$query = "UPDATE #__jomres_custom_templates SET `value`='".$templateData."',`last_edited`='".$last_edited."',`ptype_id`=".$propertyType." WHERE template_name = '".$templatename."' AND uid=".(int)$templateid."";
			$result = doInsertSql($query,'');
			}
		else
			{
			$query = "INSERT INTO #__jomres_custom_templates (`template_name`,`value`,`ptype_id`,`last_edited`) VALUES ( '".$templatename."','".$templateData."',".(int)$propertyType.",'".$last_edited."')";
			$templateid = doInsertSql($query,'');
			}

		if ($templatename == "jomrescss.css")
			{
			$fp=fopen(JOMRESPATH_BASE.JRDS."temp".JRDS."jomrescss.css",'w');
			fwrite($fp, $templateData);
			fclose($fp);
			}
		
		if ($templatename == "jomrescss_bootstrap.css")
			{
			$fp=fopen(JOMRESPATH_BASE.JRDS."temp".JRDS."jomrescss_bootstrap.css",'w');
			fwrite($fp, $templateData);
			fclose($fp);
			}
		emptyDir(JOMRESCONFIG_ABSOLUTE_PATH.JRDS.'jomres'.JRDS.'cache'.JRDS);
		jomresRedirect( jomresURL(JOMRES_SITEPAGE_URL_ADMIN.'&task=edit_template&id='.$templateid), "" );
		}

	// This must be included in every Event/Mini-component
	function getRetVals()
		{
		return null;
		}
	}
?>