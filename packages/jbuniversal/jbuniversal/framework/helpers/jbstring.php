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

class JBStringHelper extends AppHelper
{

    const MAX_LENGTH = 30;

    /**
     * Get sub string (by words)
     * @param $text
     * @param $searchword
     * @return mixed|string
     */
    public function smartSubstr($text, $searchword)
    {
        $length      = self::MAX_LENGTH;
        $textlen     = JString::strlen($text);
        $lsearchword = JString::strtolower($searchword);
        $wordfound   = false;
        $pos         = 0;
        $chunk       = '';

        while ($wordfound === false && $pos < $textlen) {

            if (($wordpos = @JString::strpos($text, ' ', $pos + $length)) !== false) {
                $chunk_size = $wordpos - $pos;
            } else {
                $chunk_size = $length;
            }

            $chunk     = JString::substr($text, $pos, $chunk_size);
            $wordfound = JString::strpos(JString::strtolower($chunk), $lsearchword);

            if ($wordfound === false) {
                $pos += $chunk_size + 1;
            }
        }

        if ($wordfound !== false) {
            return (($pos > 0) ? '...' : '') . $chunk;

        } elseif (($wordpos = @JString::strpos($text, ' ', $length)) !== false) {
            return JString::substr($text, 0, $wordpos) . '...';

        } else {
            return JString::substr($text, 0, $length);
        }
    }

}