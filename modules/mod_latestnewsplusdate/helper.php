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

require_once JPATH_SITE.'/components/com_content/helpers/route.php';

jimport('joomla.application.component.model');

JModelLegacy::addIncludePath(JPATH_SITE.'/components/com_content/models', 'ContentModel');

abstract class modLatestNewsHelperPlusDate
{	
	public static function getList(&$params)
	{
		// Get the dbo
		$db = JFactory::getDbo();
	
		// Get an instance of the generic articles model
		$model = JModelLegacy::getInstance('Articles', 'ContentModel', array('ignore_request' => true));

		// Set application parameters in model
		$app = JFactory::getApplication();
		$appParams = $app->getParams();
		$model->setState('params', $appParams);
		
		//Get Parameters in module params
		$count			= (int) $params->get('count', 5);
		$show_featured	= $params->get('show_featured', 1);
		$show_introtext	= $params->get( 'show_introtext', 0 );
		$introtext_limit = $params->get('limit_intro', 100);

		// Set the filters based on the module params
		$model->setState('list.start', (int) $params->get('num_intro_skip', 0));
		$model->setState('list.limit', (int) $params->get('count', 5));
		$model->setState('filter.published', 1);

		// Access filter
		$access = !JComponentHelper::getParams('com_content')->get('show_noauth');
		$authorised = JAccess::getAuthorisedViewLevels(JFactory::getUser()->get('id'));
		$model->setState('filter.access', $access);

		// Category filter
		$model->setState('filter.category_id', $params->get('catid', array()));

		// User filter
		$userId = JFactory::getUser()->get('id');
		switch ($params->get('user_id'))
		{
			case 'by_me':
				$model->setState('filter.author_id', (int) $userId);
				break;
			case 'not_me':
				$model->setState('filter.author_id', $userId);
				$model->setState('filter.author_id.include', false);
				break;

			case '0':
				break;

			default:
				$model->setState('filter.author_id', (int) $params->get('user_id'));
				break;
		}

		// Filter by language
		$model->setState('filter.language',$app->getLanguageFilter());

		//  Featured switch
		switch ($params->get('show_featured'))
		{
			case '1':
				$model->setState('filter.featured', 'only');
				break;
			case '0':
				$model->setState('filter.featured', 'hide');
				break;
			default:
				$model->setState('filter.featured', 'show');
				break;
		}

		// Set ordering
		$order_map = array(
			'm_dsc' => 'a.modified DESC, a.created',
			'mc_dsc' => 'CASE WHEN (a.modified = '.$db->quote($db->getNullDate()).') THEN a.created ELSE a.modified END',
			'c_dsc' => 'a.created',
			'p_dsc' => 'a.publish_up',
		);
		$ordering = JArrayHelper::getValue($order_map, $params->get('ordering'), 'a.publish_up');
		$dir = 'DESC';

		$model->setState('list.ordering', $ordering);
		$model->setState('list.direction', $dir);

		$items = $model->getItems();

		foreach ($items as &$item) {
			$item->slug = $item->id.':'.$item->alias;
			$item->catslug = $item->catid.':'.$item->category_alias;
			$item->categtitle = $item->category_title;
			
			if ($access || in_array($item->access, $authorised)) {
				// We know that user has the privilege to view the article
				$item->link = JRoute::_(ContentHelperRoute::getArticleRoute($item->slug, $item->catslug));
			} else {
				$item->link = JRoute::_('index.php?option=com_users&view=login');
			}
			
			$item->link = JRoute::_(ContentHelperRoute::getArticleRoute($item->slug, $item->catslug));
			$item->text = htmlspecialchars( $item->title );
			$item->id = htmlspecialchars( $item->id );
			$item->introtext = JHtml::_('content.prepare', $item->introtext);
			//$item->created=JHTML::_('date', htmlspecialchars( $item->created ),"d F Y H:i", $offset);
			//$item->images = htmlspecialchars( $item->images );
			
			//Category List and Blog
			$item->categblog = JRoute::_(ContentHelperRoute::getCategoryRoute($item->catslug));
			$item->categlist = JRoute::_('index.php?option=com_content&view=category&id='.$item->catid);

		}

		return $items;
	}

	public static function _cleanIntrotext($introtext)
	{
		$introtext = str_replace('<p>', ' ', $introtext);
		$introtext = str_replace('</p>', ' ', $introtext);
		$introtext = strip_tags($introtext, '<a><em><strong>');

		$introtext = trim($introtext);

		return $introtext;
	}
	
	public static function truncate($html, $maxLength = 0)
	{
		$baseLength = strlen($html);
		$diffLength = 0;

		// First get the plain text string. This is the rendered text we want to end up with.
		$ptString = JHtml::_('string.truncate', $html, $maxLength, $noSplit = true, $allowHtml = false);

		for ($maxLength; $maxLength < $baseLength;)
		{
			// Now get the string if we allow html.
			$htmlString = JHtml::_('string.truncate', $html, $maxLength, $noSplit = true, $allowHtml = true);

			// Now get the plain text from the html string.
			$htmlStringToPtString = JHtml::_('string.truncate', $htmlString, $maxLength, $noSplit = true, $allowHtml = false);

			// If the new plain text string matches the original plain text string we are done.
			if ($ptString == $htmlStringToPtString)
			{
				return $htmlString;
			}
			// Get the number of html tag characters in the first $maxlength characters
			$diffLength = strlen($ptString) - strlen($htmlStringToPtString);

			// Set new $maxlength that adjusts for the html tags
			$maxLength += $diffLength;
			if ($baseLength <= $maxLength || $diffLength <= 0)
			{
				return $htmlString;
			}
		}
		return $html;
	}
	
	public static function lnd_showThumb($row_images,$params,$row_id,$row_slug,$row_catslug,$row_link)
	{
		$showthumb = intval( $params->get( 'showthumb', 0 ) );
		$thumb_width = intval( $params->get( 'thumb_width', 32 ) );
		$thumb_height = intval( $params->get( 'thumb_height', 32 ) );
		$aspect = intval( $params->get( 'aspect', 0 ) );

		$default_image_path = "/modules/mod_latestnewsplusdate/assets/default.gif";
		if ($showthumb == 1) 
		{	
			echo '<a href="'. $row_link .'">';
							
			if (!empty($row_images))
			{
				$img = "/images/" . strtok($row_images,"|\r\n");
				$class="";
				$extra = ' align="left" alt="article thumbnail" ';
				modLatestNewsHelperPlusDate::lnd_thumb_size($img, $thumb_width, $thumb_height, $image, $extra, $class, $aspect);
					
				echo $image;
				
			}
			else if ($row_images !="")
			{
				echo '<img src="'.JURI::base().'/images/' . $row_images .' " width="' . $thumb_width . '" height="' . $thumb_height .'" style="float: left;" alt="article image" />';
			}
			else {
							
				$img = $default_image_path;
				$class="";
				$extra = ' align="left" alt="article thumbnail" ';
						   	
				modLatestNewsHelperPlusDate::lnd_thumb_size($img, $thumb_width, $thumb_height, $image, $extra, $class, $aspect);
				echo $image;
			}
			echo '</a>';
		}
	
	}
	
	public static function lnd_thumb_size($file, $wdth, $hgth, &$image, &$xtra, $class, $aspect)
	{
			$app = JFactory::getApplication();

			if($class!='') $xtra .= ' class="'.$class.'"';
			
			// Find the extension of the file
			$ext = substr(strrchr(basename(JPATH_SITE.$file), '.'), 1);
			$thumb = str_replace('.'.$ext, '_lnd_thumb.'.$ext, $file);
			$image = '';
			$image_path = JPATH_SITE.$thumb;

			$image_site = JURI::base(true).$thumb;
			$found = false;

			if (file_exists($image_path))
			{
				$size = '';
				$wx = $hy = 0;
				if (function_exists( 'getimagesize' ))
				{
					$size = @getimagesize( $image_path );
					if (is_array( $size ))
					{
						$wx = $size[0];
						$hy = $size[1];
						$size = 'width="'.$wx.'" height="'.$hy.'"';
					}
		    	}
		    	if ($wx == $wdth && $hy == $hgth)
		    	//if ( $wx == $wdth )
		    	{
						$found = true;
						$image= '<img src="'.$image_site.'" '.$size.$xtra.' />';
					}
			}
		
			if (!$found)
			{
				$size = '';
				$wx = $hy = 0;
				$size = @getimagesize( JPATH_SITE.$file );
				if (is_array( $size ))
				{
					$wx = $size[0];
					$hy = $size[1];
				}
				
				modLatestNewsHelperPlusDate::lnd_calcsize($wx, $hy, $wdth, $hgth, $aspect);
				switch ($ext)
				{
					case 'jpg':
					case 'jpeg':
					case 'png':
						modLatestNewsHelperPlusDate::lnd_thumbIt(JPATH_SITE.$file,$image_path,$ext,$wdth,$hgth);
						$size = 'width="'.$wdth.'" height="'.$hgth.'"';
						$image= '<img  src="'.$image_site.'" '.$size.$xtra.' />';
						break;
		
					case 'gif':
						if (function_exists("imagegif")) {
							modLatestNewsHelperPlusDate::lnd_thumbIt(JPATH_SITE.$file,$image_path,$ext,$wdth,$hgth);
							$size = 'width="'.$wdth.'" height="'.$hgth.'"';
							$image= '<img src="'.$image_site.'" '.$size.$xtra.' />';
							break;
		        		}
						
					default:
						$size = 'width="'.$wdth.'" height="'.$hgth.'"';
						$image= '<img src="'.JURI::base().$file.'" '.$size.$xtra.' />';
						break;
				}
			}
	}
	
	private static function lnd_thumbIt ($file, $thumb, $ext, &$new_width, &$new_height) 
	{
			$img_info = getimagesize ( $file );
			$orig_width = $img_info[0];
			$orig_height = $img_info[1];
			
			if($orig_width<$new_width || $orig_height<$new_height)
			{
				$new_width = $orig_width;
				$new_height = $orig_height;
			}
			
			switch ($ext) {
				case 'jpg':
				case 'jpeg':
					$im  = imagecreatefromjpeg($file);
					$tim = imagecreatetruecolor ($new_width, $new_height);
					modLatestNewsHelperPlusDate::lnd_ImageCopyResampleBicubic($tim, $im, 0,0,0,0, $new_width, $new_height, $orig_width, $orig_height);
					imagedestroy($im);
		
					imagejpeg($tim, $thumb, 75);
					imagedestroy($tim);
					break;
	
				case 'png':
					$im  = imagecreatefrompng($file);
					$tim = imagecreatetruecolor ($new_width, $new_height);
					modLatestNewsHelperPlusDate::lnd_ImageCopyResampleBicubic($tim, $im, 0,0,0,0, $new_width, $new_height, $orig_width, $orig_height);
					imagedestroy($im);
	
					imagepng($tim, $thumb, 9);
					imagedestroy($tim);
					break;
	
				case 'gif':
					if (function_exists("imagegif")) {
						$im  = imagecreatefromgif($file);
						$tim = imagecreatetruecolor ($new_width, $new_height);
						modLatestNewsHelperPlusDate::lnd_ImageCopyResampleBicubic($tim, $im, 0,0,0,0, $new_width, $new_height, $orig_width, $orig_height);
						imagedestroy($im);
	
						imagegif($tim, $thumb, 75);
						imagedestroy($tim);
	    			}
					break;
	
				default:
					break;
			}
	}
	
	private static function lnd_ImageCopyResampleBicubic (&$dst_img, &$src_img, $dst_x, $dst_y, $src_x, $src_y, $dst_w, $dst_h, $src_w, $src_h) 
	{
			if ($dst_w==$src_w && $dst_h==$src_h) {
				$dst_img = $src_img;
				return;
			}
	  		ImagePaletteCopy ($dst_img, $src_img);
			$rX = $src_w / $dst_w;
			$rY = $src_h / $dst_h;
			$w = 0;
			for ($y = $dst_y; $y < $dst_h; $y++) 
			{
				$ow = $w; $w = round(($y + 1) * $rY);
				$t = 0;
				for ($x = $dst_x; $x < $dst_w; $x++) 
				{
					$r = $g = $b = 0; $a = 0;
					$ot = $t; $t = round(($x + 1) * $rX);
					for ($u = 0; $u < ($w - $ow); $u++) 
					{
						for ($p = 0; $p < ($t - $ot); $p++) 
						{
							$c = ImageColorsForIndex ($src_img, ImageColorAt ($src_img, $ot + $p, $ow + $u));
							$r += $c['red'];
	          				$g += $c['green'];
	          				$b += $c['blue'];
	          				$a++;
	        			}
					}
					if(!$a) $a = 1;
					ImageSetPixel ($dst_img, $x, $y, ImageColorClosest ($dst_img, $r / $a, $g / $a, $b / $a));
				}
			}
	}
	
	private static function lnd_calcsize($srcx, $srcy, &$forcedwidth, &$forcedheight, $aspect) 
	{
			if ($forcedwidth > $srcx)  $forcedwidth = $srcx;
			if ($forcedheight > $srcy) $forcedheight = $srcy;
			if ( $forcedwidth <=0 && $forcedheight > 0) {
				$forcedwidth = round(($forcedheight * $srcx) / $srcy);
			}else if ( $forcedheight <=0 && $forcedwidth > 0) {
				$forcedheight = round(($forcedwidth * $srcy) / $srcx);
			}else if ( $forcedwidth/$srcx>1 && $forcedheight/$srcy>1) {
				//May not make an image larger!
				$forcedwidth = $srcx;
				$forcedheight = $srcy;
			}
			else if ( $forcedwidth/$srcx<1 && $aspect) {
				//$forcedheight = round(($forcedheight * $forcedwidth) /$srcx);
				$forcedheight = round( ($srcy/$srcx) * $forcedwidth );
				$forcedwidth = $forcedwidth;
			}
	}
	
	public static function lnd_limittext($text,$allowed_tags,$limit)
	{
		$strip = strip_tags($text);
		$endText = (strlen($strip) > $limit) ? "&nbsp;[&nbsp;...&nbsp;]" : ""; 
		if ($limit == 0) $endText = "";
		$strip = substr($strip, 0, $limit);
		$striptag = strip_tags($text, $allowed_tags);
		$lentag = strlen($striptag);
		
		$display = "";
		
		$x = 0;
		$ignore = true;
		for($n = 0; $n < $limit; $n++) {
			for($m = $x; $m < $lentag; $m++) {
				$x++;
				$striptag_m = (!empty($striptag[$m])) ? $striptag[$m] : null;
				if($striptag[$m] == "<") {
					$ignore = false;
				} else if($striptag[$m] == ">") {
					$ignore = true;
				}
				if($ignore == true) {
					$strip_n = (!empty($strip[$n])) ? $strip[$n] : null;
					if($strip[$n] != $striptag[$m]) {
						$display .= $striptag[$m];
					} else {
						$display .= $strip[$n];
						break;
					}
				} else {
					$display .= $striptag[$m];
				}
				}
		}
		if ($limit == 0)  return self::fix_tags (''); 
		else return self::fix_tags('<p>'.$display.$endText.'</p>'); 
	}

	public static function unhtmlentities($string)
	{
	    // replace numeric entities
	    $string = preg_replace('~&#x([0-9a-f]+);~ei', 'chr(hexdec("\\1"))', $string);
	    $string = preg_replace('~&#([0-9]+);~e', 'chr("\\1")', $string);
	    // replace literal entities
	    $trans_tbl = get_html_translation_table(HTML_ENTITIES);
	    $trans_tbl = array_flip($trans_tbl);
	    return strtr($string, $trans_tbl);
	}

	private static function fix_tags($html) {
		  $result = "";
		  $tag_stack = array();

		  // these corrections can simplify the regexp used to parse tags
		  // remove whitespaces before '/' and between '/' and '>' in autoclosing tags
		  $html = preg_replace("#\s*/\s*>#is","/>",$html);
		  // remove whitespaces between '<', '/' and first tag letter in closing tags
		  $html = preg_replace("#<\s*/\s*#is","</",$html);
		  // remove whitespaces between '<' and first tag letter 
		  $html = preg_replace("#<\s+#is","<",$html);

		  while (preg_match("#(.*?)(<([a-z\d]+)[^>]*/>|<([a-z\d]+)[^>]*(?<!/)>|</([a-z\d]+)[^>]*>)#is",$html,$matches)) {
			$result .= $matches[1];
			$html = substr($html, strlen($matches[0]));

			// Closing tag 
			if (isset($matches[5])) { 
			  $tag = $matches[5];

			  if ($tag == $tag_stack[0]) {
				// Matched the last opening tag (normal state) 
				// Just pop opening tag from the stack
				array_shift($tag_stack);
				$result .= $matches[2];
			  } elseif (array_search($tag, $tag_stack)) { 
				// We'll never should close 'table' tag such way, so let's check if any 'tables' found on the stack
				$no_critical_tags = !array_search('table',$tag_stack);
				if (!$no_critical_tags) {
				  $no_critical_tags = (array_search('table',$tag_stack) >= array_search($tag, $tag_stack));
				};

				if ($no_critical_tags) {
				  // Corresponding opening tag exist on the stack (somewhere deep)
				  // Note that we can forget about 0 value returned by array_search, becaus it is handled by previous 'if'
				  
				  // Insert a set of closing tags for all non-matching tags
				  $i = 0;
				  while ($tag_stack[$i] != $tag) {
					$result .= "</{$tag_stack[$i]}> ";
					$i++;
				  }; 
				  
				  // close current tag
				  $result .= "</{$tag_stack[$i]}> ";
				  // remove it from the stack
				  array_splice($tag_stack, $i, 1);
				  // if this tag is not "critical", reopen "run-off" tags
				  $no_reopen_tags = array("tr","td","table","marquee","body","html");
				  if (array_search($tag, $no_reopen_tags) === false) {
					while ($i > 0) {
					  $i--;
					  $result .= "<{$tag_stack[$i]}> ";
					}; 
				  } else {
					array_splice($tag_stack, 0, $i);
				  };
				};
			  } else {
				// No such tag found on the stack, just remove it (do nothing in out case, as we have to explicitly 
				// add things to result
			  };
			} elseif (isset($matches[4])) {
			  // Opening tag
			  $tag = $matches[4];
			  array_unshift($tag_stack, $tag);
			  $result .= $matches[2];
			} else {
			  // Autoclosing tag; do nothing specific
			  $result .= $matches[2];
			};
		  };

		  // Close all tags left
		  while (count($tag_stack) > 0) {
			$tag = array_shift($tag_stack);
			$result .= "</".$tag.">";
		  }	

		  return $result;
		}
}

