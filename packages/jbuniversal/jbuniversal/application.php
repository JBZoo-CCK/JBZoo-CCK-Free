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

// include jbzoo init class
require_once realpath(dirname(__FILE__) . '/framework/jbzoo.php');

define('JBZOO_CONFIG_SHOWUPDATE', true);

/**
 * JBZoo Application class
 */
class JBUniversalApplication extends Application
{
    /**
     * App Constructor
     */
    public function __construct()
    {
        parent::__construct();

        $this->app = App::getInstance('zoo');
        $this->_init();

        $this->app->jbdebug->mark('application::init::end');

        // check is event plugin enabled
        if (!$this->app->jbenv->isSite() && !JPluginHelper::isEnabled('system', 'jbzoo')) {
            $this->app->jbnotify->notice('JBZoo plugin is not enabled!');
        }
    }

    /**
     * Register controller path, only for frontend
     */
    private function _init()
    {
        JBZoo::init();

        if ($this->app->jbenv->isSite()) {
            $this->app->jbassets->setAppCSS($this->alias);
            $this->app->jbassets->setAppJS($this->alias);
        } else {
            $this->checkUpdates();
        }
    }

    /**
     * Dispatch
     */
    public function dispatch()
    {
        $this->app->jbdebug->mark('application::dispatch::before');

        parent::dispatch();

        $this->app->jbdebug->mark('application::dispatch::after');
    }

    /**
     * Init form elements
     * @return null
     */
    public function getParamsForm()
    {
        // get parameter xml file
        if ($xml = $this->app->path->path($this->getResource() . $this->metaxml_file)) {

            // get form
            $form = $this->app->parameterform->create($xml);

            // add own joomla elements
            $form->addElementPath($this->app->path->path('applications:' . $this->getGroup() . '/joomla/elements'));

            return $form;
        }

        return null;
    }

    /**
     * Check has application icon
     * @return bool
     */
    public function hasAppIcon()
    {
        return (bool)$this->app->path->path($this->getResource() . 'assets/app_icons/' . $this->alias . '.png');
    }

    /**
     * Get application icon
     * @return string
     */
    public function getIcon()
    {
        if ($this->hasAppIcon()) {
            return $this->app->path->url($this->getResource() . 'assets/app_icons/' . $this->alias . '.png');
        } else {
            if ($this->hasIcon()) {
                return $this->app->path->url($this->getResource() . 'application.png');
            } else {
                return $this->app->path->url('assets:images/zoo.png');
            }
        }
    }

    /**
     * Get JBZoo application group
     * @return string
     */
    public function getGroup()
    {
        return JBZOO_APP_GROUP;
    }

    /**
     * Check updates
     */
    public function checkUpdates()
    {
        static $isShow;

        if (!isset($isShow)) {

            $cache     = $this->app->jbcache;
            $jbversion = $this->app->jbversion;

            $lastCheckTime = (time() - filemtime($this->app->path->path('root:cache/jbzoo/update'))) / 86400;
            if ($lastCheckTime >= 2) {
                $this->app->jbcache->clear('update');
            }

            if (!($response = $cache->get('response', 'update', true))) {
                if (function_exists('file_get_contents') && (int)ini_get('allow_url_fopen')) {
                    $response = @file_get_contents('http://server.jbzoo.com/checkupdates?' . http_build_query(array(
                        'zoo'    => $jbversion->zoo(),
                        'jbzoo'  => $jbversion->jbzoo(),
                        'joomla' => $jbversion->joomla(),
                        'host'   => isset($_SERVER['SERVER_NAME']) ? $_SERVER['SERVER_NAME'] : '<undefined>',
                        'uri'    => JURI::root(),
                    )));
                }
                $cache->set('response', $response, 'update', true);
            }

            $data = (array)json_decode($response);

            if (JBZOO_CONFIG_SHOWUPDATE && !empty($data)) {
                if (isset($data['message']) && $data['message']) {
                    $this->app->jbnotify->notice($data['message']);
                }
            }

            $isShow = true;
        }

    }
}
