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

$this->app->jbdebug->mark('layout::item_columns::start');

if ($vars['count']) {

    $count = $vars['count'];

    echo '<div class="items items-col-' . $vars['cols_num'] . '">';

    $j = 0;
    foreach ($vars['objects'] as $object) {

        $first = ($j == 0) ? ' first' : '';
        $last = ($j == $count - 1) ? ' last' : '';
        $j++;

        $isLast = $j % $vars['cols_num'] == 0 && $vars['cols_order'] == 0;

        if ($isLast) {
            $last .= ' last';
        }

        echo'<div class="column rborder width' . intval(100 / $vars['cols_num']) . $first . $last . '">' . $object
            . '</div>';

        if ($isLast) {
            echo '<div class="clear clr"></div>';
        }

    }

    echo '</div>';
    echo '<div class="clear clr"></div>';

}

$this->app->jbdebug->mark('layout::item_columns::finish');