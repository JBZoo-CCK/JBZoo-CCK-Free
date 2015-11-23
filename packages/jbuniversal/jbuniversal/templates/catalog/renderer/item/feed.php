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

$desc = JString::trim(strip_tags($this->renderPosition('description')));

$descArr = explode(' ', $desc);
$descArr_tmp = array();

foreach ($descArr as $word) {
    $word = JString::trim($word);

    if ($word) {
        $descArr_tmp[] = $word;
    }

}

if (count($descArr_tmp) > 30) {
    $descArr_tmp = array_slice($descArr_tmp, 0, 30);
    echo implode(' ', $descArr_tmp) . ' ...';

} else {
    echo implode(' ', $descArr_tmp);
}
