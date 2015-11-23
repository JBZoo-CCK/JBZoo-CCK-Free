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

class JBJoomlaHelper extends AppHelper
{

    /**
     * Render modules by position name
     * @param string $position
     * @param array  $options
     * @return string
     */
    public function renderPosition($position, array $options = array())
    {
        $this->app->jbdebug->mark('jbjoomla::renderPosition (' . $position . ')::start');

        $document     = JFactory::getDocument();
        $renderer     = $document->loadRenderer('modules');
        $positionHtml = $renderer->render($position, $options, null);

        $this->app->jbdebug->mark('jbjoomla::renderPosition (' . $position . ')::finish');

        return $positionHtml;
    }

    /**
     * Render module by id
     * @param int $moduleId
     * @return null|string
     */
    public function renderModuleById($moduleId)
    {
        $this->app->jbdebug->mark('jbjoomla::renderModuleById (' . $moduleId . ')::start');

        $modules = $this->app->module->load();

        if ($moduleId && isset($modules[$moduleId])) {

            if ($modules[$moduleId]->published) {
                $rendered = JModuleHelper::renderModule($modules[$moduleId]);

                $this->app->jbdebug->mark('jbjoomla::renderModuleById (' . $moduleId . ')::finish');

                return $rendered;
            }

        }

        $this->app->jbdebug->mark('jbjoomla::renderModuleById (' . $moduleId . ')::finish');

        return null;
    }

}
