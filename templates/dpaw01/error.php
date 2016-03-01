<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  Templates.dec
 *
 * @copyright   Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

// Getting params from template
$params = JFactory::getApplication()->getTemplate(true)->params;

$app = JFactory::getApplication();
$doc = JFactory::getDocument();
$this->language = $doc->language;
$this->direction = $doc->direction;

// Detecting Active Variables
$option   = $app->input->getCmd('option', '');
$view     = $app->input->getCmd('view', '');
$layout   = $app->input->getCmd('layout', '');
$task     = $app->input->getCmd('task', '');
$itemid   = $app->input->getCmd('Itemid', '');
$sitename = $app->getCfg('sitename');


// Add JavaScript Frameworks
JHtml::_('bootstrap.framework');

// Add current user information
$user = JFactory::getUser();


// Logo file
if ($params->get('logoFile'))
{
	$logo = JURI::root() . $params->get('logoFile');
}
else
{
	$logo = $this->baseurl . "/templates/" . $this->template . "/images/logo.png";
}




$this->setMetaData('generator',''); 

?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">
<head>
	<title><?php echo $this->title; ?> <?php echo $this->error->getMessage();?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta name="language" content="<?php echo $this->language; ?>" />
    
    <link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/system/css/system.css" type="text/css" />
	<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/css/bootstrap.min.css" type="text/css" />
    <link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/css/style.css" type="text/css" />
    <link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/css/app.css" type="text/css" />
	<?php
	// If Right-to-Left
	if ($this->direction == 'rtl')
	{
	?>
		<link rel="stylesheet" href="<?php echo $this->baseurl ?>/media/jui/css/bootstrap-rtl.css" type="text/css" />
	<?php
	}
	// Use of Google Font
	if ($params->get('googleFont'))
	{
	?>
		<link href='http://fonts.googleapis.com/css?family=<?php echo $params->get('googleFontName');?>' rel='stylesheet' type='text/css'>
	<?php
	}
	?>
	<link href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/favicon.ico" rel="shortcut icon" type="image/vnd.microsoft.icon" />

	<!--[if lt IE 9]>
		<script src="<?php echo $this->baseurl ?>/media/jui/js/html5.js"></script>
	<![endif]-->
	<!--[if lt IE 7]>
	<script src="<?php echo JURI::root(); ?>templates/<?php echo $this->template; ?>/lte-ie7.js"></script>
	<![endif]-->
	<meta name="robots" content="noindex, nofollow" />
</head>
<body class="site <?php echo $option . " view-" . $view . " layout-" . $layout . " task-" . $task . " itemid-" . $itemid . " ";?>"><a id="top" name="top"></a>
<div class="navbar navbar-inverse navbar-fixed-top">
	<div class="navbar-inner">
		<div class="container">
        <ul class="nav pull-left"><li><a href="#content" data-original-title="Jump to main page content">skip to content</a></li></ul>
         <?php
				// Display position-1 modules
				$this->navmodules = JModuleHelper::getModules('position-0');
				foreach ($this->navmodules as $navmodule) {
					$output = JModuleHelper::renderModule($navmodule, array('style' => 'none'));
					$params = new JRegistry;
					$params->loadString($navmodule->params);
					echo $output;
				}
				?>
        </div>
	</div>
</div>
<div class="topmast">

		<div class="container">
			<!-- Header -->
			<div class="masthead">
			
<div class="row-fluid">
<div class="span2 GovLogo">
<a class="brand pull-left" href="<?php echo JURI::root(); ?>"><img src="<?php echo $logo;?>" alt="<?php echo $sitename; ?>" /></a>
</div>

<div class="span6 AgencyLogo">
<div class="agency-freespace">
<div id="site-title" class="site-logo"><a href="<?php echo $this->baseurl; ?>"><img src="<?php echo JURI::root(); ?>templates/<?php echo $this->template; ?>/images/logo-dpaw.gif" alt="Department of Parks and Wildlife" />
                            Department of <br><strong>Parks and Wildlife</strong></a></div>
</div>
</div>
<div class="span4 topsearch hidden-phone text-right">
<div class="header-search pull-right hidden-phone">
						<?php
						// Display position-0 modules
						$this->searchmodules = JModuleHelper::getModules('position-1');
						foreach ($this->searchmodules as $searchmodule) {
							$output = JModuleHelper::renderModule($searchmodule, array('style' => 'none'));
							$params = new JRegistry;
							$params->loadString($searchmodule->params);
							echo $output;
						}
						?>
					</div>
</div>

</div>
					<div class="clearfix"></div>
				</div>
			</div>
</div>

 <!-- Top Nav -->
    <div class="navbar" id="mainnav">
        <div class="container">
 	<a class="btn btn-navbar btn-inverse" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          	</a>
            <!-- nav collapse -->
			<div class="nav-collapse collapse navigation">
		
				<?php
				// Display position-1 modules
				$this->navmodules = JModuleHelper::getModules('position-2');
				foreach ($this->navmodules as $navmodule) {
					$output = JModuleHelper::renderModule($navmodule, array('style' => 'none'));
					$params = new JRegistry;
					$params->loadString($navmodule->params);
					echo $output;
				}
				?>
			</div>


</div>
</div>
</div>
<div class="under-feature"></div>

			<div class="row-fluid">
<div class="container">
				<div id="content" class="span12">
					<!-- Begin Content -->
					<h1 class="page-header"><br /><?php echo $this->error->getCode(); ?> - <?php echo JText::_('JERROR_LAYOUT_PAGE_NOT_FOUND'); ?></h1>
					<div class="well">
						<div class="row-fluid">
							<div class="span6">
								<p><strong><?php echo JText::_('JERROR_LAYOUT_ERROR_HAS_OCCURRED_WHILE_PROCESSING_YOUR_REQUEST'); ?></strong></p>
								<p><?php echo JText::_('JERROR_LAYOUT_NOT_ABLE_TO_VISIT'); ?></p>
								<ul>
									<li><?php echo JText::_('JERROR_LAYOUT_AN_OUT_OF_DATE_BOOKMARK_FAVOURITE'); ?></li>
									<li><?php echo JText::_('JERROR_LAYOUT_MIS_TYPED_ADDRESS'); ?></li>
									<li><?php echo JText::_('JERROR_LAYOUT_SEARCH_ENGINE_OUT_OF_DATE_LISTING'); ?></li>
									<li><?php echo JText::_('JERROR_LAYOUT_YOU_HAVE_NO_ACCESS_TO_THIS_PAGE'); ?></li>
								</ul>
<p><?php echo JText::_('JERROR_LAYOUT_GO_TO_THE_HOME_PAGE'); ?></p>
								<p><a href="<?php echo JURI::root(); ?>" class="btn"><i class="icon-home"></i> <?php echo JText::_('JERROR_LAYOUT_HOME_PAGE'); ?></a></p>
							</div>
							<div class="span6">
																
<!--p><img src="<?php echo $this->baseurl ?>templates/<?php echo $this->template; ?>/images/404.jpg" alt="Page not found" /></p-->
							</div>
						</div>
						<hr />
						<p><?php echo JText::_('JERROR_LAYOUT_PLEASE_CONTACT_THE_SYSTEM_ADMINISTRATOR'); ?></p>
						<blockquote>
							<span class="label label-inverse"><?php echo $this->error->getCode(); ?></span> <?php echo $this->error->getMessage();?>
						</blockquote>
					</div>
					<!-- End Content -->
				</div>
			</div>
		</div>
	</div>
	<!-- Footer -->
	<div class="footer">
		<div class="container">
			<hr />
			<jdoc:include type="modules" name="footer" style="none" />
			<p class="pull-right"><a href="#top" id="back-top">Back to top</a></p>
			<p>&copy; <?php echo $sitename; ?> <?php echo date('Y');?></p>
		</div>
	</div>
</div>
	<jdoc:include type="modules" name="debug" style="none" />
</body>
</html>
