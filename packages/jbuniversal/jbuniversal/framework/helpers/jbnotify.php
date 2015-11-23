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

class JBNotifyHelper extends AppHelper
{
    /**
     * Show warning message
     * @param $message string
     * @return mixed
     */
    public function warning($message)
    {
        return $this->app->error->raiseWarning(0, $message);
    }

    /**
     * Show warning message
     * @param $message string
     * @return mixed
     */
    public function notice($message)
    {
        return $this->app->error->raiseNotice(0, $message);
    }

    /**
     * Show error message
     * @param $message
     * @return mixed
     */
    public function error($message)
    {
        return $this->app->error->raiseError(500, $message);
    }

}
