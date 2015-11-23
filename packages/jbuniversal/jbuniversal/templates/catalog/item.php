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

$this->app->jbdebug->mark('template::item::start');

$this->app->jblayout->setView($this);

$this->app->jbwrapper->start();

// render item
if (!$this->app->jbcache->start(array($this->item->modified, $this->item->id))) {
    echo $this->app->jblayout->renderItem($this->item, 'full');
    $this->app->jbcache->stop();
}

// render comments (if no rendered in element)
if (!defined('JBZOO_COMMENTS_RENDERED')) {
    echo $this->app->comment->renderComments($this, $this->item);
}

$this->app->jbwrapper->end();

$this->app->jbdebug->mark('template::item::finish');
