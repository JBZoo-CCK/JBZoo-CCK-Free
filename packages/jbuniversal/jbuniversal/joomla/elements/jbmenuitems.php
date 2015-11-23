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

$app = App::getInstance('zoo');

if ($app->jbversion->joomla('3')) {
    echo App::getInstance('zoo')->jbfield->menuitems_j3($name, $value, $control_name, $node, $parent);
} else {
    echo App::getInstance('zoo')->jbfield->menuitems_j25($name, $value, $control_name, $node, $parent);
}
