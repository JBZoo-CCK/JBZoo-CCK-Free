<?php
/**
 * JBZoo is universal CCK, application for YooTheme Zoo component
 * @package     JBZoo
 * @author      JBZoo App http://jbzoo.com
 * @copyright   Copyright (C) JBZoo.com
 * @license     http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

class JBCacheHelper extends AppHelper
{
    /**
     * @var JCache
     */
    protected $_cache = null;

    /**
     * Start cache process
     * @param mixed  $params
     * @param string $type
     * @return mixed
     */
    public function start($params = null, $type = null)
    {
        return null; // disibled
        !$type && $type = $this->app->jbrequest->get('view');
        !$type && $type = $this->app->jbrequest->get('task');

        $application = $this->app->zoo->getApplication();
        if ($application) {
            $group = 'jbzoo_' . $application->alias . '_' . $type;
        } else {
            $group = 'jbzoo_' . $type;
        }

        $this->_cache = JFactory::getCache($group, 'output');

        $result = $this->_cache->start($this->_getKey($params));

        return $result;
    }

    /**
     * Stop cache
     */
    public function stop()
    {
        return null; // disibled
        return $this->_cache->end();
    }

    /**
     * Create uniq cache key
     * @param array       $params
     * @return string
     */
    public function _getKey($params = null)
    {
        $result   = array();
        $result[] = $this->app->jbwrapper->attrs();
        $result[] = serialize($params);
        $result[] = serialize($_GET);
        $result[] = $this->app->jbrequest->get('tmpl', 'index');
        $result[] = $this->app->jbrequest->get('page', 1);

        return implode('||', $result);
    }

    /**
     * Check config, is enabled joomla caching
     * @return int
     */
    public function isEnabled()
    {
        $config = JFactory::getConfig();
        return (int)$config->get('caching', 0);
    }

    /**
     * Set data to cache storage by key
     * @param string $key
     * @param mixed  $data
     * @param string $group
     * @param bool   $isForce
     * @return bool
     */
    public function set($key, $data, $group = 'default', $isForce = false)
    {
        if ($this->isEnabled() || $isForce) {

            $cache = $this->app->cache->create(JPATH_SITE . '/cache/jbzoo/' . $group, true);
            $key   = $this->_simpleHash($key);

            $cache->set($key, $data);
            $cache->save();
            return true;
        }

        return false;
    }

    /**
     * Get cache data by key
     * @param string $key
     * @param string $group
     * @param bool   $isForce
     * @return null
     */
    public function get($key, $group = 'default', $isForce = false)
    {
        if ($this->isEnabled() || $isForce) {

            $cache = $this->app->cache->create(JPATH_SITE . '/cache/jbzoo/' . $group, true);

            $key = $this->_simpleHash($key);
            return $cache->get($key);
        }

        return null;
    }

    /**
     * Clear cache
     * @param $group
     */
    public function clear($group)
    {
        $file = JPATH_SITE . '/cache/jbzoo/' . $group;
        if (JFile::exists($file)) {
            JFile::delete($file);
        }
    }

    /**
     * Create simple hash from var
     * @param mixed $var
     * @return string
     */
    protected function _simpleHash($var)
    {
        return sha1(serialize($var));
    }

}
