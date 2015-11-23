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

class JBToolbarHelper extends AppHelper
{

    /**
     * Show toolbar buttons
     */
    public function toolbar()
    {

    }

    /**
     * Show button for popup window
     * @param string $icon
     * @param string $name
     * @param array  $urlParams
     * @param int    $width
     * @param int    $height
     */
    protected function _popup($icon, $name, array $urlParams, $width = 600, $height = 450)
    {
        $urlParams = array_merge(array(
            'option' => 'com_zoo',
            'tmpl'   => 'component'
        ), $urlParams);

        $link = JRoute::_(JURI::root() . 'administrator/index.php?' . http_build_query($urlParams), true, -1);

        JToolBar::getInstance('toolbar')->appendButton('Popup', $icon, $name, $link, $width, $height);
    }

    /**
     * Show link-button
     * @param string $icon
     * @param string $name
     * @param array  $urlParams
     */
    protected function _link($icon, $name, $urlParams)
    {
        $urlParams = array_merge(array(
            'option' => 'com_zoo',
            'tmpl'   => 'component'
        ), $urlParams);

        $link = JRoute::_(JURI::root() . 'administrator/index.php?' . http_build_query($urlParams), true, -1);

        JToolBar::getInstance('toolbar')->appendButton('Link', $icon, $name, $link);
    }
}