<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  Templates.dec
 *
 * @copyright   Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

$app   = JFactory::getApplication();
$doc   = JFactory::getDocument();
$this->language = $doc->language;
$this->direction = $doc->direction;
$doc->addStyleSheet($this->baseurl.'/templates/'.$this->template.'/css/bootstrap.min.css', $type = 'text/css', $media = 'screen');
$doc->addStyleSheet($this->baseurl.'/templates/'.$this->template.'/css/style.css', $type = 'text/css', $media = 'screen');
$doc->addStyleSheet($this->baseurl.'/templates/'.$this->template.'/css/app.css', $type = 'text/css', $media = 'screen');
//$doc->addStyleSheet($this->baseurl.'/templates/'.$this->template.'/css/print.css', $type = 'text/css', $media = 'print');
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">
<head>
<jdoc:include type="head" />
<!--[if lt IE 9]>
	<script src="<?php echo $this->baseurl ?>/media/jui/js/html5.js"></script>
<![endif]-->
<?php
if($_GET['print'] == "1")
{
?>
<style>
body {background:#fff; background-image:none;}
</style>
<?php } ?>
</head>
<body class="contentpane modal">
<?php
if($_GET['print'] == "1")
{
?>
<div class="row" style="background:#fff;border-bottom: 1px solid #eeeeee;">
  <div class="span12 agency-freespace"><div id="site-title"><img src="<?php echo $this->baseurl.'/templates/'.$this->template.'/images/print-logo-dpaw.gif'; ?>" alt="Department of Parks adn Wildlife" /></div></div>
</div>
<?php
}
?>
<jdoc:include type="message" />
<jdoc:include type="component" />
</body>
</html>
