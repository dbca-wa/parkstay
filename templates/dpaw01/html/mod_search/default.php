<?php
/**
 * @package     Joomla.Site
 * @subpackage  Template.atomic
 *
 * @copyright   Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
?>
<form action="<?php echo JRoute::_('index.php');?>" method="post" class="inline">
	<div class="search<?php echo $params->get('moduleclass_sfx') ?> input">

<div class="input-group">
		<?php
			$output = '<input style="width:165px;" name="searchword" id="mod-search-searchword" maxlength="'.$maxlength.'" class="form-control" type="text" size="'.$width.'" value="'.$text.'"  onblur="if (this.value==\'\') this.value=\''.$text.'\';" onfocus="if (this.value==\''.$text.'\') this.value=\'\';" />';

			if ($button) :
				if ($imagebutton) :
					$button = ' <input type="image" value="'.$button_text.'" class="button'.$moduleclass_sfx.'" src="'.$img.'" onclick="this.form.searchword.focus();"/>';
				else :
					$button = ' <span class="input-group-btn"><button type="submit" value="'.$button_text.'" class="btn btn-default" onclick="this.form.searchword.focus();"/>Go!</button></span>';
				endif;
			endif;

			switch ($button_pos) :
				case 'top' :
					$button = $button.'<br />';
					$output = $button.$output;
					break;

				case 'bottom' :
					$button = '<br />'.$button;
					$output = $output.$button;
					break;

				case 'right' :
					$output = $output.$button;
					break;

				case 'left' :
				default :
					$output = $button.$output;
					break;
			endswitch;

			echo $output;
		?>

	<input type="hidden" name="task" value="search" />
	<input type="hidden" name="option" value="com_search" />
	<input type="hidden" name="Itemid" value="<?php echo $mitemid; ?>" />
	</div>
</div>
<p class="hidden-phone"><small><a href="http://wa.gov.au/search/" data-original-title="" title="">Go to whole of WA Government search</a></small></p>


</form>

