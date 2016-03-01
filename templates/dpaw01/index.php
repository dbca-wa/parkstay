<?php
defined('_JEXEC') or die;
header('X-UA-Compatible: IE=edge');
$this->baseurl = JURI::root();

$app = JFactory::getApplication();
$menu = $app->getMenu();
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

// add modal window support
//JHTML::_('behavior.modal');

// Add Stylesheets
$doc->addStyleSheet(JURI::root().'templates/system/css/system.css');
$doc->addStyleSheet(JURI::root().'templates/'.$this->template.'/css/bootstrap.min.css');
$doc->addStyleSheet(JURI::root().'templates/'.$this->template.'/css/style.css');
$doc->addStyleSheet(JURI::root().'templates/'.$this->template.'/css/app.css');

// Add Javascript
// remove Joomla core bootstrap js
unset($this->_scripts[JURI::root(true).'/media/jui/js/bootstrap.min.js']); 

unset($this->_scripts[JURI::root(true).'/media/system/js/mootools-core.js']);
unset($this->_scripts[JURI::root(true).'/media/system/js/mootools-more.js']);

unset($this->_scripts[JURI::root(true).'/media/jui/js/jquery.min.js']);
$doc->addScript(JURI::root().'templates/'.$this->template.'/js/bootstrap.min.js');
$doc->addScript(JURI::root().'templates/'.$this->template.'/js/app.js');
//$doc->addScript(JURI::root().'templates/'.$this->template.'/js/jquery.isotope.min.js');






// Add current user information
$user = JFactory::getUser();

// Module positions
$showFeatured  = ($this->countModules('position-4') or $this->countModules('position-5'));
if ($this->countModules('position-5')) { $Featuredspan = "col-lg-9";} else { $Featuredspan = "col-lg-12";}

$showRight  = ($this->countModules('position-8'));
if ($this->countModules('position-8')) { $MainContentspan = "col-lg-9";} else { $MainContentspan = "col-lg-12";}
// wider right column for frontpage only
//if ($menu->getActive() == $menu->getDefault()) {$MainContentspan = "col-lg-8";} else { $MainContentspan = "col-lg-9";}


$showBaseBlocks  = ($this->countModules('position-9') or $this->countModules('position-10') or $this->countModules('position-11'));
$showFooterFeatures  = ($this->countModules('position-12') or $this->countModules('position-13') or $this->countModules('position-14') or $this->countModules('position-15'));

// Logo file or site title param
if ($this->params->get('logoFile'))
{
  $logo = '<img src="'. JURI::root() . $this->params->get('logoFile') .'" alt="'. htmlspecialchars($this->params->get('sitetitle')) .'" class="img-responsive" />';
}
elseif ($this->params->get('sitetitle'))
{
  $logo = '<span class="site-title" title="'. $sitename .'">'. htmlspecialchars($this->params->get('sitetitle')) .'</span>';
}
else
{
  $logo = '<span class="site-title" title="'. $sitename .'">Government of Western Australia</span>';
}
// remove Joomla generator meta tag
$this->setGenerator(null);
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">
  <head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="geo.placename" content="Australia" />
    <meta name="geo.region" content="AU-WA" />
    <meta name="geo.position" content="-31.953004;115.857469" />
    <meta name="ICBM" content="-31.953004, 115.857469" />
    <meta http-equiv="expires" content="0">
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>

<script>
if (typeof jQuery == 'undefined') {
    document.write(unescape("%3Cscript src='<?php echo JURI::root(); ?>templates/<?php echo $this->template; ?>/js/jquery.min.js' type='text/javascript'%3E%3C/script%3E"));
}
</script>
    <jdoc:include type="head" />
  <?php
  // Use of Google Font
  if ($this->params->get('googleFont'))
  {
  ?>
    <link href='//fonts.googleapis.com/css?family=<?php echo $this->params->get('googleFontName');?>' rel='stylesheet' type='text/css' />
    <style type="text/css">
      .gfont{
        font-family: '<?php echo str_replace('+', ' ', $this->params->get('googleFontName'));?>', cursive, sans-serif;      
      }
    </style>
  <?php
  }
  ?>
  <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
  <!--[if lt IE 9]>
  <script src="<?php echo JURI::root(); ?>media/jui/js/html5.js"></script>
  <style type="text/css">
      .gradient {filter: none;}
    </style>
  <![endif]-->
    <!--[if IE 7]>
       <script src="<?php echo JURI::root(); ?>templates/<?php echo $this->template; ?>/js/lte-ie7.js"></script>
  <![endif]-->

    <!-- Fav and touch icons -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo $this->baseurl ?>templates/<?php echo $this->template; ?>/img/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo $this->baseurl ?>templates/<?php echo $this->template; ?>/img/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo $this->baseurl ?>templates/<?php echo $this->template; ?>/img/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="<?php echo $this->baseurl ?>templates/<?php echo $this->template; ?>/img/apple-touch-icon-57-precomposed.png">
    <link rel="shortcut icon" href="<?php echo $this->baseurl ?>templates/<?php echo $this->template; ?>/img/favicon.ico">
      <script>
          var $buoop = {c:2};
          function $buo_f(){
              var e = document.createElement("script");
              e.src = "//browser-update.org/update.min.js";
              document.body.appendChild(e);
          };
          try {document.addEventListener("DOMContentLoaded", $buo_f,false)}
          catch(e){window.attachEvent("onload", $buo_f)}
      </script>
  </head>
  <body class="site <?php echo $option . " view-" . $view . " layout-" . $layout . " task-" . $task . " itemid-" . $itemid . " ";?>"><a id="top" name="top"></a>
    <?php if ($this->countModules('position-0')): ?>
    <!-- Top Navbar -->
     <div class="navbar navbar-inverse navbar-fixed-top">
            <div class="container">
                <a class="skip hidden-xs hidden-sm" href="#content">skip to content</a>
                <jdoc:include type="modules" name="position-0" style="none" />
            </div>
    </div>
  <!--// Top Navbar -->
    <?php endif; ?>
    <!-- Top Mast -->
    <div class="topmast">
  
        <div class="container">     
            <div class="masthead">     
                <div class="row">    
                    <div class="col-lg-8">
                        <div class="agency-freespace">
<!--a class="brand pull-left" href="<?php echo $this->baseurl; ?>">
<?php echo $logo;?> <?php if ($this->params->get('sitedescription')) { echo '<div class="site-description">'. htmlspecialchars($this->params->get('sitedescription')) .'</div>'; } ?>
</a-->
<?php
// frontpage check
if ($menu->getActive() == $menu->getDefault()) {
?>
                            <h1 id="site-title" class="site-logo"><a href="<?php echo $this->baseurl; ?>">
                            <!--<img src="<?php echo $this->baseurl ?>templates/<?php echo $this->template; ?>/images/logo-dpaw.gif" alt="Department of Parks and Wildlife" />-->
                            <?php echo $logo;?>
                            <br><br><br>Department of <br><strong>Parks and Wildlife</strong></a></h1>
<?php } ?>
<?php
// frontpage check
if ($menu->getActive() != $menu->getDefault()) {
?>
                            <div id="site-title" class="site-logo pull-left"><a href="<?php echo $this->baseurl; ?>">
                            <!--<img src="<?php echo $this->baseurl ?>templates/<?php echo $this->template; ?>/images/logo-dpaw.gif" alt="Department of Parks and Wildlife" />-->
                            <?php echo $logo;?>
                            <br>Department of <br><strong>Parks and Wildlife</strong></a>
                            </div>
<?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!--// Top Mast -->
    
    <!-- Top Nav -->
    <nav class="navbar" role="navigation" id="mainnav">
        <div class="container">
        <?php if ($this->countModules('position-2')): ?>
          <?php if ($this->countModules('position-navsearch')): ?>
          <div class="pull-left visible-sm pad-5">
          <jdoc:include type="modules" name="position-navsearch" style="none" />
          <small><a href="http://wa.gov.au/search/" data-original-title="" title="Go to whole of WA Government search">Go to whole of WA Government search</a></small>
          </div>
            <?php endif; ?>
           <button class="btn btn-default btn-navbar btn-inverse navbar-toggle" data-toggle="collapse"  data-target=".navbar-mainnav-collapse"><i class="icon-menu">&nbsp;</i> Menu
    
            <!--<col-lg- class="icon-bar"></span>
            <col-lg- class="icon-bar"></span>
            <col-lg- class="icon-bar"></span>-->
            </button>
            <!-- nav collapse -->
        <div class="clearfix"></div>
        <div class="collapse navbar-collapse navbar-mainnav-collapse">  
        <jdoc:include type="modules" name="position-2" style="none" />
        </div>
        <!--/.nav-collapse -->
        <?php endif; ?>
      </div>
  </nav>
    <!--// Top Nav -->
    
    <div class="underNav">
    <div class="row">
    <div class="container">&nbsp;</div>
    </div>
    </div>
    
   
    <?php if ($showFeatured) : ?>
    <!-- Featured -->
    <div id="featured">
        <div class="row row-offcanvas row-offcanvas-right">  
            <div class="mainfeatured container">
                <?php if ($this->countModules('position-region1')): ?>
                    <div class="col-lg-4 feature-right">
                        <div class="feature-links">
                            <jdoc:include type="modules" name="position-region1" style="none" />
                        </div>
                    </div>
                <?php endif; ?>

                <?php if ($this->countModules('position-region2')): ?>
                    <div class="col-lg-4 feature-right">
                        <div class="feature-links">
                            <jdoc:include type="modules" name="position-region2" style="none" />
                        </div>
                    </div>
                <?php endif; ?>

                <?php if ($this->countModules('position-region3')): ?>
                    <div class="col-lg-4 feature-right">
                        <div class="feature-links">
                            <jdoc:include type="modules" name="position-region3" style="none" />
                        </div>
                    </div>
                <?php endif; ?>

                <?php if ($this->countModules('position-region4')): ?>
                    <div class="col-lg-4 feature-right">
                        <div class="feature-links">
                            <jdoc:include type="modules" name="position-region4" style="none" />
                        </div>
                    </div>
                <?php endif; ?>

                <?php if ($this->countModules('position-region5')): ?>
                    <div class="col-lg-4 feature-right">
                        <div class="feature-links">
                            <jdoc:include type="modules" name="position-region5" style="none" />
                        </div>
                    </div>
                <?php endif; ?>

                <?php if ($this->countModules('position-region6')): ?>
                    <div class="col-lg-4 feature-right">
                        <div class="feature-links">
                            <jdoc:include type="modules" name="position-region6" style="none" />
                        </div>
                    </div>
                <?php endif; ?>

                <?php if ($this->countModules('position-promo1')): ?>
                    <div class="col-lg-4 feature-right">
                        <div class="feature-links">
                            <jdoc:include type="modules" name="position-promo1" style="none" />
                        </div>
                    </div>
                <?php endif; ?>

                <?php if ($this->countModules('position-promo2')): ?>
                    <div class="col-lg-4 feature-right">
                        <div class="feature-links">
                            <jdoc:include type="modules" name="position-promo2" style="none" />
                        </div>
                    </div>
                <?php endif; ?>

                <div class="col-lg-4 feature search-box">
                <?php if ($this->countModules('position-4')): ?>
                <jdoc:include type="modules" name="position-4" style="none" />
                <?php endif; ?>
                </div>


                <?php if (FALSE && $this->countModules('position-5')): ?>
                <div class="col-lg-4 search-box">
            <div class="feature-links">
                <jdoc:include type="modules" name="position-5" style="none" />
            </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <!--// Featured -->
     <?php endif; ?>
  <div class="under-feature"></div>
 <?php if ($this->countModules('position-3')): ?>
    <!-- Breadcrumbs -->
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
            <jdoc:include type="modules" name="position-3" style="none" /> 
            </div>
        </div>
    </div>
    <!--// Breadcrumbs -->
    <?php endif; ?>
    <!-- start main content -->
    <div class="container" id="ContentContainer">
    <div class="row <?php //row-offcanvas row-offcanvas-left ?>">
        <!-- content left -->
      <div id="MainContent" class="<?php echo $MainContentspan;?>">
              <!-- Begin Content -->
              <div class="pad-10">

                  <?php
/* 
<button class="navbar-toggle pull-left visible-xs btn btn-default btn-navbar btn-inverse" type="button" data-toggle="offcanvas" data-target=".bs-navbar-collapse">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
</button>
*/
?>
              <?php if ($this->countModules('position-1')): ?>
                  <div class="col-lg-4 topsearch hidden-xs hidden-sm text-right" style="float:right;">
                      <div class="hidden-sm">
                          <jdoc:include type="modules" name="position-1" style="none" />
                      </div>
                  </div>
              <?php endif; ?>
                <div class="homepage_full">
                    <jdoc:include type="modules" name="position-6" style="none" />
                </div>
              <a name="content" id="content"></a>  
              <jdoc:include type="message" />
              <jdoc:include type="component" />
              <jdoc:include type="modules" name="position-map" style="none" />
              <div id="asamodule_search_results"></div>
              <jdoc:include type="modules" name="position-7" style="none" />
              </div>

      </div>
        <?php if ($this->countModules('position-8')): ?>

          <!-- content right -->
            <aside id="RightColumn" class="col-lg-3<?php //if ($menu->getActive() == $menu->getDefault()) {echo "col-lg-4";} else {echo "col-lg-3";}  ?> <?php //sidebar-offcanvas?>">
        <jdoc:include type="modules" name="position-8" style="xhtml" />
          
        </aside>
      <?php endif; ?>
    </div>
    <div class="clearfix">&nbsp;</div>
    <div class="row">
      <div class="col-lg-12">
        <p class="pull-right"><a href="#top" title="Back to top of page" class="pagetop"><i class="icon-arrow-up-2"></i> Back To Top</a></p>
      </div>
    </div>
    <div class="clearfix">&nbsp;</div>
      <!-- Example row of columns -->
      <div class="row">
        <?php if ($this->countModules('position-9')): ?>
        <div class="col-lg-4">
         <div class="pad-10">
          <jdoc:include type="modules" name="position-9" style="none" />
         </div>
        </div>
        <?php endif; ?>
        <?php if ($this->countModules('position-10')): ?>
        <div class="col-lg-4">
         <div class="pad-10">
            <jdoc:include type="modules" name="position-10" style="none" />
         </div>
        </div>
        <?php endif; ?>
        <?php if ($this->countModules('position-11')): ?>
        <div class="col-lg-4">
         <div class="pad-10">
            <jdoc:include type="modules" name="position-11" style="none" />
         </div>
        </div>
        <?php endif; ?>
      </div>

    </div> <!-- /container -->

<footer>
<div id="basePosition">
<div class="container">
  <div class="row"> 
        <?php if ($this->countModules('position-12')): ?>
        <div class="col-lg-3">
       <div class="pad-10">
        <jdoc:include type="modules" name="position-12" style="xhtml" />
       </div>
        </div>
        <?php endif; ?>
        <?php if ($this->countModules('position-13')): ?>
        <div class="col-lg-3">
       <div class="pad-10">
        <jdoc:include type="modules" name="position-13" style="xhtml" />
       </div>
        </div>
        <?php endif; ?>
        <?php if ($this->countModules('position-14')): ?>
        <div class="col-lg-3">
       <div class="pad-10">
        <jdoc:include type="modules" name="position-14" style="xhtml" />
        </div>
       </div>
        <?php endif; ?>
        <?php if ($this->countModules('position-15')): ?>
        <div class="col-lg-3">
      <div class="pad-10">
        <jdoc:include type="modules" name="position-15" style="xhtml" />
      </div>
        </div>
        <?php endif; ?>  
  </div>
</div>
</div>
<?php if ($this->countModules('position-social')): ?>
<div class="row socialbar">
  <div class="container">
    <div class="col-lg-12">
    <div class="pad-10">
        <jdoc:include type="modules" name="position-social" style="none" />
        </div>
      </div>
  </div>
</div>
<?php endif; ?>  

<div class="row footer-block">
  <div class="container">
    <div class="col-lg-2 link-wagov">
          <a href="http://www.wa.gov.au" title="Go to WA Government Online Entry Point">wa.gov.au</a>
        </div>
    <div class="col-lg-10">
      <jdoc:include type="modules" name="position-16" style="none" />
      <div class="copyright"><p>All contents copyright &copy; Government of Western Australia. All rights reserved.</p></div>
    </div>    
  </div>
</div>

</footer>
<!-- Because IE Doesn't understand @Media queries -->
<!--[if lt IE 9]>
<script defer src="<?php echo JURI::root(); ?>templates/<?php echo $this->template; ?>/js/respond.min.js"></script>
<![endif]-->
<script type='text/javascript'>//<![CDATA[ 
    jQuery(document).ready(function($){ 
<?php
/* Off canvas menu
  $('[data-toggle=offcanvas]').click(function() {
    $('.row-offcanvas').toggleClass('active');
  });
*/
 ?>
<?php
// frontpage check
if ($menu->getActive() == $menu->getDefault()) {
?>
$("input[name='nodates']").prop('checked', false);
//$("#featured").backstretch("<?php echo JURI::root(); ?>templates/<?php echo $this->template; ?>/rotate.php");
<?php } ?>

// allow top menu item to be clickable if not on desktop
var pageWidth = $(window).width();
if (pageWidth < 979) {
$('#mainnav .nav li a').each(function(){
     if ($(this).hasClass('dropdown-toggle'))
       $(this).attr("href", "#")
});
};

if (pageWidth > 980) {
$('#mainnav .nav li a').each(function(){
     if ($(this).hasClass('dropdown-toggle'))
       $(this).addClass('disabled')
});
};

});

//]]>  
</script>
<?php if ($this->countModules('debug')): ?>
<jdoc:include type="modules" name="debug" style="none" />
<?php endif; ?> 
</body>
</html>
