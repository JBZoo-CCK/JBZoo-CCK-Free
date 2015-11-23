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

$this->app->jbdebug->mark('template::favorite::start');
$this->app->jblayout->setView($this);
$this->app->document->setTitle(JText::_('JBZOO_FAVORITE_ITEMS'));
$this->app->jbwrapper->start();

?><h1 class="title"><?php echo JText::_('JBZOO_FAVORITE_ITEMS');?></h1><?php

if (!empty($this->items)) {
    // items
    echo $this->app->jblayout->render('favorite', $this->items);
    echo '<p class="jsJBZooFavoriteEmpty" style="display:none;">' . JText::_('JBZOO_FAVORITE_ITEMS_NOT_FOUND') . '</p>';
} else {
    echo '<p>' . JText::_('JBZOO_FAVORITE_ITEMS_NOT_FOUND') . '</p>';
}

$this->app->jbwrapper->end();
$this->app->jbdebug->mark('template::favorite::finish');
