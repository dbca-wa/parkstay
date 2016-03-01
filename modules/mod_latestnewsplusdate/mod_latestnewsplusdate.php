<?php
/**
 * @version		$Id: mod_latestnewsplusdate.php 2.1.0
 * @Rony S Y Zebua (Joomla 1.7 & Joomla 2.5 & Joomla 3.0)
 * @Official site http://www.templateplazza.com
 * @based on mod_latestnews
 * @package		Joomla 3.0.x 
 * @subpackage	mod_latestnewsplusdate
 * @copyright	Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */
 
// no direct access
defined('_JEXEC') or die;

$doc			= JFactory::getDocument();
$modulebase		= ''.JURI::base(true).'/modules/mod_latestnewsplusdate/';

// Include the syndicate functions only once
require_once dirname(__FILE__).'/helper.php';
require_once dirname(__FILE__).'/image.php'; /* for image to thumbnail processing if image source come from intro or fulltext image parameter - schro */


$show_introtext	= $params->get( 'show_introtext', 1 );
$numofintrotext	= $params->get( 'numofintrotext', 1 );
$num_intro_skip = $params->get( 'num_intro_skip', 0 );
$introtext_limit	= intval( $params->get( 'limit_intro', 200 ) );
$show_date		= $params->get( 'show_date', 0 );
$show_date_type	= $params->get( 'show_date_type', 0 );
//Get the config
$config = JFactory::getConfig();
$offset = $config->get('config.offset');

$showthumb 			= intval( $params->get( 'showthumb', 0 ) );
$thumb_width 		= intval( $params->get( 'thumb_width', 80 ) );
$thumb_height 		= intval( $params->get( 'thumb_height', 80 ) );
//$aspect 			= intval( $params->get( 'aspect', 0 ) );

$loadorder 			= intval( $params->get( 'loadorder', 1 ) );
$show_more_in 		= intval( $params->get( 'show_more_in', 0 ) );
$show_more_type 	= intval( $params->get( 'show_more_type', 1 ) ); /* if we set default to 0 then there'll be 404 error in the category list page - schro founded on 21/11/2012 */ 
//$show_date_in_introtext 	= intval( $params->get( 'show_date_in_introtext', 0 ) );

$image_path = $params->get( 'image_path', 'images' );
$allowed_tags 		=  "<i><b>";  // add/remove tags here if you like
$doc->addStyleSheet($modulebase.'assets/style.css');

$list = modLatestNewsHelperPlusDate::getList($params);
$n = 0;
foreach($list as $index => $item)
{
	if($numofintrotext>0) {
	
		if ($showthumb ) {
			
			/* The code lines bellow are added to support intro and fulltext image in article parameter - schro added 13/11/2012 */
			$images = json_decode($item->images);
			$introImage = htmlspecialchars( $images->image_intro );
			$fulltextImage = htmlspecialchars( $images->image_fulltext );
			
			/* First find image in intro text parameter - added 14/11/2012 */
			if ( !empty($introImage) ) {
			
				$item->image = $introImage;
				$item->imgtitle = ($images->image_intro_caption) ? htmlspecialchars($images->image_intro_caption) : '';
				$item->imgalt = htmlspecialchars($images->image_intro_alt);
				
			} elseif ( empty($introImage) && !empty($fulltextImage) ) {
			
				/* If no image in introtext can be found, then find out image in full text parameter */
				$item->image = $fulltextImage;
				$item->imgtitle = ($images->image_fulltext_caption) ? htmlspecialchars($images->image_fulltext_caption) : '';
				$item->imgalt = htmlspecialchars($images->image_fulltext_alt);
				
			} elseif( empty($introImage) && empty($fulltextImage) ) {
				
				/* If still no image in fulltext parameter can be found, then find out image inserted inside text editor */
				/* end added - schro */
			
				/* Regex tool for finding image path on img tag - thx to Jerson Figueiredo */	
				//preg_match_all("/<img[^>]*>/Ui", modLatestNewsHelperPlusDate::unhtmlentities(html_entity_decode(htmlentities($item->introtext))), $txtimg);
				preg_match_all("/<img[^>]*>/Ui", $item->introtext, $txtimg);
				if (!empty($txtimg[0])) 
				{
					foreach ($txtimg[0] as $txtimgel) 
					{	
						$item->introtext = str_replace($txtimgel,"",$item->introtext);
						if ( strstr($txtimgel, $image_path) ) 
						{
							if (strstr($txtimgel, 'src="/')) {
								preg_match_all("#src=\"\/" . addslashes($image_path) . "\/([\:\-\/\_A-Za-z0-9\.]+)\"#",$txtimgel,$txtimgelsr);
							}
							else {
								preg_match_all("#src=\"" . addslashes($image_path) . "\/([\:\-\/\_A-Za-z0-9\.]+)\"#",$txtimgel,$txtimgelsr);
							}
							
							if (!empty($item->image)) {
								$item->image = $txtimgelsr[1][0] . "\n" . $item->image;
							}
							else {
								$item->image = $txtimgelsr[1][0];
							}
						} elseif (preg_match_all("#http#",$txtimgel,$txtimelsr,PREG_PATTERN_ORDER) > 0) {
							preg_match_all("#src=\"([\-\/\_A-Za-z0-9\.\:]+)\"#",$txtimgel,$txtimgelsr);
							if (!empty($item->image)) {
								$item->image = $txtimgelsr[1][0] . "\n" . $item->image;
							}
							else {
								$item->image = $txtimgelsr[1][0];
							}
						} 
					
					}
				} else {
					// image not found in article, load default img
					$item->image = '';
				}
			}	
			
		} // end of thumbnail processing
		
		if($introtext_limit){
			$item->displayIntrotext = preg_replace("/{[^}]*}/","",$item->introtext);
			//$item->introtext = modLatestNewsHelperPlusDate::lnd_limittext($item->introtext,$allowed_tags,$introtext_limit);
			$item->displayIntrotext = modLatestNewsHelperPlusDate::_cleanIntrotext($item->introtext);
			$item->displayIntrotext = $show_introtext ? modLatestNewsHelperPlusDate::truncate($item->displayIntrotext, $introtext_limit) : '';
		} else {
			$item->introtext = null;
		}
		
		$list[$index] = $item;
		$numofintrotext--;
	
	} else {
		$item->introtext = null;
		$item->image = '';
	}
	
}

$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'));
require JModuleHelper::getLayoutPath('mod_latestnewsplusdate', $params->get('layout', 'default'));