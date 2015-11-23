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

class JBElementHelper extends AppHelper
{

    /**
     * Parse text by lines
     * @param string $text
     * @return array
     */
    public function parseLines($text)
    {
        $text  = JString::trim($text);
        $lines = explode("\n", $text);

        $result = array();
        if (!empty($lines)) {

            foreach ($lines as $line) {

                $line = JString::trim($line);
                if (!empty($line)) {
                    $result[] = $line;
                }

            }
        }

        return $result;
    }

}
