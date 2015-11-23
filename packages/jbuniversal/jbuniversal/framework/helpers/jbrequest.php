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

class JBRequestHelper extends AppHelper
{

    /**
     * Clear and escape all values (recursive)
     * @param string|array $value
     * @return null|string
     */
    public function clear($value)
    {
        if (!is_array($value)) {

            $value = strip_tags($value);
            $value = str_replace(array('"', "'", ';', '--'), '', $value);
            $value = JString::trim($value);

            if (JString::strlen($value)) {
                return $value;
            }

        } else {

            foreach ($value as $key => $val) {
                $value[$key] = $this->clear($val);
            }

            return $value;
        }

        return null;
    }

    /**
     * Get variable from request
     * @param      $valueName
     * @param null $default
     * @return null|string
     */
    public function get($valueName, $default = null)
    {
        $jInput = JFactory::getApplication()->input;
        $value = $jInput->get($valueName, $default, false);
        $value = $this->clear($value);

        return $value;
    }

    /**
     * Get element name
     * @return mixed
     */
    public function getElement()
    {
        $element = str_replace('filterEl_', '', $this->get('element'));
        return $element;
    }

    /**
     * Get element
     * @return array
     */
    public function getElements()
    {
        static $result;

        if (!isset($result)) {

            $elements = $this->app->request->get('e', 'array', array());
            $elements = $this->clear($elements);

            $result = array();
            foreach ($elements as $key => $value) {

                if (is_string($value) && strlen($value)) {
                    $result[$key] = $value;

                } elseif (is_array($value)) {

                    foreach ($value as $valueRow) {
                        if (!empty($valueRow)) {
                            $result[$key] = $value;
                            break;
                        }
                    }

                }
            }
        }

        return $result;
    }

    /**
     * Check if is current request method is POST
     * @return bool
     */
    public function isPost()
    {
        if (version_compare(JVERSION, '1.5.0', '<=')) {
            return 'POST' == JFactory::getApplication()->input->getMethod(false, false);
        } else {
            return 'POST' == JRequest::getMethod();
        }
    }

    /**
     * Check, is current request - ajax
     * @return bool
     */
    public function isAjax()
    {
        if (function_exists('apache_request_headers')) {

            $headers = apache_request_headers();
            foreach ($headers as $key => $value) {
                if (strToLower($key) == 'x-requested-with' && strToLower($value) == 'xmlhttprequest') {
                    return true;
                }
            }

        } else if (isset($_SERVER['HTTP_X_REQUESTED_WITH'])
                && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'
        ) {
            return true;
        }

        return false;
    }

    /**
     * Check request value
     * @param $requestKey string
     * @param $value      string
     * @return bool
     */
    public function is($requestKey, $value)
    {
        return $this->get($requestKey, null) == $value;
    }

}
