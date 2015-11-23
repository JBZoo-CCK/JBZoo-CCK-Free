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

class JBArrayHelper extends AppHelper
{
    /**
     * Convert values to names
     * @param array $options
     * @param array $values
     * @return array
     */
    public function valuesToName(array $options, array $values)
    {
        $result = array();

        foreach ($values as $value) {
            if (isset($options[$value])) {
                $result[] = $options[$value]['name'];
            }
        }

        return $result;
    }

    /**
     * Group array by key
     * @param array  $options
     * @param string $fieldName
     * @return array
     */
    public function group($options, $fieldName = 'id')
    {
        $result = array();

        if (!empty($options) && is_array($options)) {
            foreach ($options as $option) {
                $result[$option[$fieldName]] = $option;
            }
        }

        return $result;
    }

    /**
     * Add cell to assoc array
     * @param array  $array
     * @param string $key
     * @param mixed  $val
     * @return array
     */
    function unshiftAssoc(array $array, $key, $val)
    {
        $array       = array_reverse($array, true);
        $array[$key] = $val;
        $array       = array_reverse($array, true);

        return $array;
    }


    /**
     * Get one field from array of arrays (array of objects)
     * @param array  $options
     * @param string $fieldName
     * @return array
     */
    public function getField($options, $fieldName = 'id')
    {
        $result = array();

        if (!empty($options) && is_array($options)) {
            foreach ($options as $option) {
                if (is_array($option)) {
                    $result[] = $option[$fieldName];

                } else if (is_object($option)) {
                    $result[] = $option->$fieldName;
                }
            }
        }

        return $result;
    }

}
