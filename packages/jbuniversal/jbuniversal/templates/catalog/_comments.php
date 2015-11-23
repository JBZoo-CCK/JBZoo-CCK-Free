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

$this->app->jbdebug->mark('template::_comments::start');

echo $this->app->jblayout->render(
    'comments', $comments, array(
        'active_author' => $active_author,
        'comments'      => $comments,
        'captcha'       => $captcha,
        'params'        => $params,
        'item'          => $item,
    )
);

$this->app->jbdebug->mark('template::_comments::finish');