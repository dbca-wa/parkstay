<?php
/**
 * @package		Joomla.Site
 * @subpackage	com_content
 * @copyright	Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;
?>

<div class="items-more">
	<ul class="nav nav-tabs nav-stacked">
		<li class="nav-header"><i class="icon-list">&nbsp;</i> <?php echo JText::_('COM_CONTENT_MORE_ARTICLES'); ?></li>
		<?php foreach ($this->link_items as &$item) : ?>
		<li> <a href="<?php echo JRoute::_(ContentHelperRoute::getArticleRoute($item->slug, $item->catslug)); ?>"> <?php echo $item->title; ?></a> </li>
		<?php endforeach; ?>
	</ul>
</div>
