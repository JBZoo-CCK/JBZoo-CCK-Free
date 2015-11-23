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

class JBEventItem extends JBEvent
{

    public static function init($event)
    {
    }

    /**
     * Item saved event
     * @static
     * @param $event AppEvent
     */
    public static function saved($event)
    {
    }

    /**
     * Item deleted event
     * @static
     * @param $event AppEvent
     */
    public static function deleted($event)
    {
        $item = $event->getSubject();

        $jbimageElements = $item->getElements();

        foreach ($jbimageElements as $element) {
            if (method_exists($element, 'triggerItemDeleted')) {
                $element->triggerItemDeleted();
            }
        }
    }

    public static function stateChanged($event)
    {
    }

    public static function beforeDisplay($event)
    {
    }

    public static function afterDisplay($event)
    {
    }
}