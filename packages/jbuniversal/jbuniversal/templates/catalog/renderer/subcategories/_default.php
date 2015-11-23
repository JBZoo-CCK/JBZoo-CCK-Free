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

$this->app->jbdebug->mark('layout::subcategories::start');

// remove empty categories
if ($vars['params']->get('template.subcategory_items', 0)) {

    $objects = array();
    foreach ($vars['objects'] as $category) {
        if ($category->itemCount()) {
            $objects[] = $category;
        }
    }

} else {
    $objects = $vars['objects'];
}


echo $this->columns('subcategory', $objects);


$this->app->jbdebug->mark('layout::subcategories::finish');