<?php
/**
 * @package     Joomla.Site
 * @subpackage  Templates.protostar
 *
 * @copyright   Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

$app             = JFactory::getApplication();
$doc             = JFactory::getDocument();
$user            = JFactory::getUser();
$this->language  = $doc->language;
$this->direction = $doc->direction;

// Getting params from template
$params = $app->getTemplate(true)->params;

// Detecting Active Variables
$option   = $app->input->getCmd('option', '');
$view     = $app->input->getCmd('view', '');
$layout   = $app->input->getCmd('layout', '');
$task     = $app->input->getCmd('task', '');
$itemid   = $app->input->getCmd('Itemid', '');
$sitename = $app->get('sitename');

if($task == "edit" || $layout == "form" )
{
	$fullWidth = 1;
}
else
{
	$fullWidth = 0;
}

// Add JavaScript Frameworks
JHtml::_('bootstrap.framework');
$doc->addScript('templates/' . $this->template . '/js/template.js');

// Add Stylesheets
$doc->addStyleSheet('templates/' . $this->template . '/css/style1.css');
$doc->addStyleSheet('templates/' . $this->template . '/css/skeleton12.css');
$doc->addStyleSheet('templates/' . $this->template . '/css/normalize.css');
$doc->addStyleSheet('templates/' . $this->template . '/css/default.css');

$doc->addStyleSheet('templates/' . $this->template . '/css/touch.gallery.css');
$doc->addStyleSheet('templates/' . $this->template . '/css/isotope.css');

$doc->addStyleSheet('templates/' . $this->template . '/css/template.css');
$doc->addStyleSheet('templates/' . $this->template . '/css/responsive.css');

// Load optional RTL Bootstrap CSS
JHtml::_('bootstrap.loadCss', false, $this->direction);

// Adjusting content width
if ($this->countModules('position-7') && !$this->countModules('position-8'))
{
	$span = "rt-grid-8 rt-push-4";
	$side = "rt-grid-4 rt-pull-8";
	$class = "sa4-mb8";
}
elseif (!$this->countModules('position-7') && $this->countModules('position-8'))
{
	$span = "rt-grid-8";
	$side = "rt-grid-4";
	$class = "mb8-sa4";
}
else
{
	$span = "rt-grid-12";
	$side = "";
	$class = "mb12";
}

// Logo file or site title param
if ($this->params->get('logoFile'))
{
	$logo = '<img src="' . JUri::root() . $this->params->get('logoFile') . '" alt="' . $sitename . '" />';
}
elseif ($this->params->get('sitetitle'))
{
	$logo = '<span class="site-title" title="' . $sitename . '">' . htmlspecialchars($this->params->get('sitetitle')) . '</span>';
}
else
{
	$logo = '<span class="site-title" title="' . $sitename . '">' . $sitename . '</span>';
}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<jdoc:include type="head" />
	<?php // Use of Google Font ?>
	<?php if ($this->params->get('googleFont')) : ?>
		<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Ubuntu:400,300,300italic,400italic,500,500italic,700,700italic" type="text/css"/>
		<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Anton" type="text/css"/>
		<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=<?php echo $this->params->get('googleFontName'); ?>" type="text/css">
		<!--style type="text/css">
			h1,h2,h3,h4,h5,h6,.site-title{
				font-family: '<?php echo str_replace('+', ' ', $this->params->get('googleFontName')); ?>', sans-serif;
			}
		</style-->
	<?php endif; ?>
	<?php // Template color ?>
	<?php if ($this->params->get('templateColor')) : ?>
	<!--style type="text/css">
		body.site
		{
			border-top: 3px solid <?php echo $this->params->get('templateColor'); ?>;
			background-color: <?php echo $this->params->get('templateBackgroundColor'); ?>
		}
		a
		{
			color: <?php echo $this->params->get('templateColor'); ?>;
		}
		.navbar-inner, .nav-list > .active > a, .nav-list > .active > a:hover, .dropdown-menu li > a:hover, .dropdown-menu .active > a, .dropdown-menu .active > a:hover, .nav-pills > .active > a, .nav-pills > .active > a:hover,
		.btn-primary
		{
			background: <?php echo $this->params->get('templateColor'); ?>;
		}
		.navbar-inner
		{
			-moz-box-shadow: 0 1px 3px rgba(0, 0, 0, .25), inset 0 -1px 0 rgba(0, 0, 0, .1), inset 0 30px 10px rgba(0, 0, 0, .2);
			-webkit-box-shadow: 0 1px 3px rgba(0, 0, 0, .25), inset 0 -1px 0 rgba(0, 0, 0, .1), inset 0 30px 10px rgba(0, 0, 0, .2);
			box-shadow: 0 1px 3px rgba(0, 0, 0, .25), inset 0 -1px 0 rgba(0, 0, 0, .1), inset 0 30px 10px rgba(0, 0, 0, .2);
		}
	</style-->
	<?php endif; ?>
	<!--[if lt IE 9]>
		<script src="<?php echo $this->baseurl; ?>/media/jui/js/html5.js"></script>
	<![endif]-->
	<style type="text/css">body a{color:#cd022b;}body a:hover{color:#373a3f;}a.moduleItemReadMore,a.k2ReadMore,a.moduleCustomLink{color:#cd022b;background:transparent;}a.moduleItemReadMore:hover,a.k2ReadMore:hover,a.moduleCustomLink:hover{color:#373a3f;background:transparent;}div.itemCommentsForm form input#submitCommentButton,input[type="submit"],button.button{color:#cd022b;background:transparent;}div.itemCommentsForm form input#submitCommentButton:hover,input[type="submit"]:hover,button.button:hover{color:#373a3f;background:transparent;}.sf-menu>li>a,.sf-menu>li>span{color:#373a3f;}
		body{font-family:Arial,Helvetica,sans-serif;font-size:13px;line-height:21px;color:#333;/*color:#83868a;*/}
	</style>
	
</head>

<body class="site <?php echo $option
	. ' view-' . $view
	. ($layout ? ' layout-' . $layout : ' no-layout')
	. ($task ? ' task-' . $task : ' no-task')
	. ($itemid ? ' itemid-' . $itemid : '')
	. ($params->get('fluidContainer') ? ' fluid' : '');
?>">

	<!-- Body -->
	<div id="body-wrapper">
		<div id="rt-iewarn">
			<div class="rt-container">
				<div class="clear"></div>
			</div>
		</div>
		<div id="wrapper" class=" homepage view-itemlist option-com_k2 task-category homepage">
			<div class="headerContent">
				<div id="rt-top">
					<div class="rt-container">
						<div class="rt-grid-4 rt-alpha">
							<div class="rt-block">
								<a href="" id="rt-logo"></a>
							</div>
						</div>
						<div class="rt-grid-8 rt-omega">
							<div class="rt-block">
								<div class="rt-siteName">&nbsp;</div>
							</div>
						</div>
						<div class="clear"></div>
					</div>
				</div>
				<div id="rt-header">
					<div class="rt-container">
						<div class="rt-grid-12 rt-alpha rt-omega">
							<jdoc:include type="modules" name="position-1" style="none" />
							<!--[if (gt IE 9)|!(IE)]><!-->
							<script type="text/javascript">
									jQuery(function(){
										jQuery('.sf-menu').mobileMenu({});
									})
								</script>
							<!--<![endif]-->
						</div>
						<div class="clear"></div>
					</div>
				</div>
				<?php if ($this->countModules('position-2')) : ?>
				<div id="rt-showcase">
					<div class="rt-container homepage">
						<div class="rt-grid-12 rt-alpha rt-omega">
							<div class="rt-block">
								<div class="flex-nav-container">
									<jdoc:include type="modules" name="position-2" />
								</div>
							</div>
						</div>
						<div class="clear"></div>
					</div>
				</div>
				<?php endif;?>
			</div>

			<?php if ($this->countModules('position-3')) : ?>
			<div id="rt-feature">
				<div class="rt-container">
					<div class="rt-grid-3 rt-alpha">
						<div class="title">
							<div class="rt-block">
								<div class="module-title">
									<h2 class="title">Nos metiers:</h2>
								</div>
								<div class="customtitle">
								</div>
							</div>
						</div>
					</div>
					<div class="rt-grid-9 rt-omega">
						<div class="carousel">
							<div class="rt-block">
								<div class="carousel">
									<jdoc:include type="modules" name="position-3" style="none" />
								</div>
							</div>
						</div>
					</div>
					<div class="clear"></div>
				</div>
			</div>
			<?php endif;?>
			
			<div id="rt-utility">
				<div class="rt-container">
					<div class="clear"></div>
				</div>
			</div>
			
			
			<?php if (($this->countModules('position-5') or $this->countModules('position-6')) and ($view!='article')) : ?>
			<div id="rt-maintop">
				<div class="rt-container">
				<?php if (($this->countModules('position-7') && !$this->countModules('position-8')) or (!$this->countModules('position-7') && $this->countModules('position-8'))) :?>
					<div class="rt-grid-12 rt-alpha rt-omega">
						<jdoc:include type="modules" name="position-5" style="well" />
						<jdoc:include type="modules" name="position-6" style="well" />
					</div>
				<?php else:;?>
					<div class="rt-grid-6 rt-alpha">
						<jdoc:include type="modules" name="position-5" style="well" />
					</div>
					
					<div class="rt-grid-6 rt-omega">
						<jdoc:include type="modules" name="position-6" style="well" />
					</div>
				<?php endif;?>
					<div class="clear"></div>
				</div>
			</div>
			<?php endif;?>
			
						
			<div id="rt-main" class="<?php echo $class; ?>">
				<div class="rt-container">
					<div class="rt-containerInner">
					
						<div class="<?php echo $span;?>">
							<?php if ($this->countModules('position-9') OR $this->countModules('position-10') ) : ?>
							<div id="rt-content-top">
                            	<div class="rt-grid-4 rt-alpha">
									<jdoc:include type="modules" name="position-9" style="well" />
								</div>
								<div class="rt-grid-4">
									<jdoc:include type="modules" name="position-10" style="well" />
								</div>
								<div class="rt-grid-4 rt-omega">
									<jdoc:include type="modules" name="position-11" style="well" />
								</div>
                            	<div class="clear"></div>
                        	</div>
                        	<?php endif;?>
							
							<div class="rt-block">
								<div id="rt-mainbody">
									<jdoc:include type="component" />
								</div>
							</div>
						</div>
						
						<?php if ($side):?>
						<div class="<?php echo $side;?>">
							<div id="rt-sidebar-a">
								<jdoc:include type="modules" name="position-7" style="well" />
								<jdoc:include type="modules" name="position-8" style="well" />
							</div>
						</div>
						<?php endif;?>
						
						<div class="clear"></div>
					</div>
				</div>
			</div>

			<?php if ($this->countModules('position-12') OR $this->countModules('position-13') ) : ?>
			<div id="rt-bottom">
				<div class="rt-container">
					<div class="rt-grid-8 rt-alpha">
						<jdoc:include type="modules" name="position-12" style="well" />
					</div>
					<div class="rt-grid-4 rt-omega">
						<div class="rt-block">
							<div class="custom">
								<div class="custom">
									<strong>Recrutement:<br/>travailler chez Sunu Assurances</strong>
									<a href="#" class="view">voir détails</a>
								</div>
							</div>
						</div>
					</div>
					<div class="clear"></div>
				</div>
			</div>
			<?php endif;?>

			<div id="push"></div>
		</div>
		
		<div id="footer">
			<div class="footer-container">
				<div id="rt-footer">
					<div class="rt-container">
						<div class="rt-grid-8 rt-alpha">
							<div class="clear"></div>
							<div class="rt-block">
								<p class="copyright">
									<span class="siteName"><span>SUNU</span> Assurances</span> &copy; 2014 | <a href="index.php/privacy-policy">Annonce légale</a><br/>
									<span>Bénin | Burkina Faso | Cameroun | Centrafrique | Côte d'Ivoire | Guinée | Gabon | Mali | Niger | Sénégal | Togo</span>
								</p>
							</div>
						</div>
						<div class="rt-grid-4 rt-omega">
							<div class="rt-block">
								<ul class="menu-social">
									<li id="item-301">
										<a href="#">
											<span><img src="images/twitter.png" alt="twitter"/><span class="image-title">twitter</span></span></a>
									</li>
									<li id="item-302">
										<a href="#"><span><img src="images/facebook.png" alt="facebook"/><span class="image-title">facebook</span> </span></a>
									</li><li id="item-303"><a href="#"><span><img src="images/flickr.png" alt="flickr"/><span class="image-title">flickr</span> </span></a></li><li id="item-304"><a href="#"><span><img src="images/rss.png" alt="rss"/><span class="image-title">rss</span> </span></a></li><li id="item-305"><a href="#"><span><img src="images/plus.png" alt="plus"/><span class="image-title">plus</span> </span></a></li></ul> </div>
						</div>
					 
						<div class="clear"></div>
					</div>
				</div>
				<div id="rt-copyright">
					<div class="rt-container">
						<div class="rt-grid-12 rt-alpha rt-omega">
							<div class="clear"></div>
							<div class="rt-block totop">
								<a href="#" id="gantry-totop">Scroll to Top</a>
							</div>
						</div>
						<div class="clear"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script type="text/javascript">/* CloudFlare analytics upgrade */
	</script>
</body>
</html>
