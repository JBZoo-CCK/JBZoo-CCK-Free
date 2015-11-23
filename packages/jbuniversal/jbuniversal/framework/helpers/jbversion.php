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

class JBVersionHelper extends AppHelper
{
    /**
     * Get Zoo version
     * @param null $compareWirh
     * @return bool|string
     */
    public function zoo($compareWirh = null)
    {
        static $version;

        if (!isset($version)) {
            $xml     = simplexml_load_file(JPATH_SITE . '/administrator/components/com_zoo/zoo.xml');
            $version = (string)$xml->version;
        }

        return $this->_compareVersion($version, $compareWirh);
    }

    /**
     * Get Joomla version
     * @param null $compareWirh
     * @return bool|string
     */
    public function joomla($compareWirh = null)
    {
        return $this->_compareVersion(JVERSION, $compareWirh);
    }

    /**
     * Get JBZoo version
     * @param null $compareWirh
     * @return bool|string
     */
    public function jbzoo($compareWirh = null)
    {
        static $version;

        if (!isset($version)) {
            $xml     = simplexml_load_file(JPATH_SITE . '/media/zoo/applications/jbuniversal/application.xml');
            $version = (string)$xml->version;
        }

        return $this->_compareVersion($version, $compareWirh);
    }

    /**
     * Compare version
     * @param string $currentVersion
     * @param null   $compareWith
     * @return bool|string
     */
    private function _compareVersion($currentVersion, $compareWith = null)
    {
        if ($compareWith) {
            $compareResult = version_compare($compareWith, $currentVersion);
            return ($compareResult <= 0) ? true : false;
        }

        return $currentVersion;
    }

}
