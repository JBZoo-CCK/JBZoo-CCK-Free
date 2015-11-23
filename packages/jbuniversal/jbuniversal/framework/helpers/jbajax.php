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

class JBAjaxHelper extends AppHelper
{

    /**
     * Send response in JSON-format
     * @param array $data
     * @param bool  $result
     */
    public function send(array $data = array(), $result = true)
    {
        $data['result'] = $result;

        JResponse::allowCache(false);
        JResponse::setHeader('Last-Modified', gmdate('D, d M Y H:i:s', time()) . ' GMT', true);
        JResponse::setHeader('Content-Type', 'application/json; charset=utf-8', true);
        JResponse::sendHeaders();

        jexit(json_encode($data));
    }

}
