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

if ((int)$this->getView()->application->params->get('global.config.column_heightfix', 0)) {
    $this->app->jbassets->heightFix();
}

$this->app->jbdebug->mark('layout::items::start');

echo $this->columns('item', $vars['objects'], true);

$this->app->jbdebug->mark('layout::items::finish');
