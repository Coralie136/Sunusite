<?php
/**
 * @copyright	Copyright (C) 2005 - 2008 Open Source Matters. All rights reserved.
 * @license		GNU/GPL, see LICENSE.php
 * Joomla! is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * See COPYRIGHT.php for copyright notices and details.
 */

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" >
<head>
<jdoc:include type="head" />

<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/system/css/system.css" type="text/css" />
<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/system/css/general.css" type="text/css" />
<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/home/css/template.css" type="text/css" />
<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/home/css/<?php echo $this->params->get('backgroundVariation'); ?>_bg.css" type="text/css" />
<!--[if lte IE 6]>
<link href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/css/ieonly.css" rel="stylesheet" type="text/css" />
<![endif]-->
<?php if($this->direction == 'rtl') : ?>
	<link href="<?php echo $this->baseurl ?>/templates/home/css/template_rtl.css" rel="stylesheet" type="text/css" />
<?php endif; ?>

</head>
<body id="page_bg" class="color_<?php echo $this->params->get('colorVariation'); ?> bg_<?php echo $this->params->get('backgroundVariation'); ?> width_<?php echo $this->params->get('widthStyle'); ?>">
<a name="up" id="up"></a>
<div class="scenter" align="scenter">
	<div id="wrapper">
		<div id="wrapper_r">
			<div id="header">
				<div id="header_l">
					<div id="header_r">
						<a href="index.php"><div id="logo"></div></a>
						<img src="templates/home/images/image00.jpg" />
						<jdoc:include type="modules" name="tops" />
					</div>
				</div>
			</div>

			<div id="tabarea">
				<div id="tabarea_l">
					<div id="tabarea_r">
						<div id="tabmenu">
						<table cellpadding="0" cellspacing="0" class="pill">
							<tr>
								<td class="pill_l">&nbsp;</td>
								<td class="pill_m">
								<div id="pillmenu">
									<!--jdoc:include type="modules" name="user3" /-->
								</div>
								</td>
								<td class="pill_r">&nbsp;</td>
							</tr>
							</table>
						</div>
					</div>
				</div>
			</div>
<!-- 
			<div id="search">
				<jdoc:include type="modules" name="user4" />
			</div>

			<div id="pathway">
				<jdoc:include type="modules" name="breadcrumb" />
			</div>

			<div class="clr"></div>
 -->

			<div id="whitebox">
				<div id="whitebox_m">
					<table width="1000" height="570" border="0" cellspacing="0" cellpadding="0">
					<tr>
					    <td align="right" valign="top" width="600"></td>
					    <td valign="top" width="400">
					    	<img src="templates/home/images/pixelt.gif" width="1" height="25">
					    	<br>
					    	<!--jdoc:include type="modules" name="user1" /-->
					    </td>
					</tr>
					</table>
					<div class="clr"></div>
				</div>
 			</div>

			<div id="footerspacer"></div>
		</div>

 		<div id="footer">
			<div id="footer_l">
				<div id="footer_r">
					<p id="syndicate">
						<!--jdoc:include type="modules" name="syndicate" /-->
					</p>
				</div>
			</div>
		</div>

 	</div>
</div>
<jdoc:include type="modules" name="debug" />

</body>
</html>
