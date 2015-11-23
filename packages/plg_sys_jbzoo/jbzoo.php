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

jimport('joomla.plugin.plugin');
jimport('joomla.filesystem.file');

class plgSystemJBZoo extends JPlugin
{

    /**
     * Event onAfterInitialise Joomla
     * @return mixed
     */
    public function onAfterInitialise()
    {

        $componentEnabled = JComponentHelper::getComponent('com_zoo', true)->enabled;
        if (!$componentEnabled) {
            return;
        }

        $mainConfig = JPATH_ADMINISTRATOR . '/components/com_zoo/config.php';
        if (!JFile::exists($mainConfig)) {
            return;
        }

        require_once ($mainConfig);
        if (!class_exists('App')) {
            return;
        }

        $zoo = App::getInstance('zoo');
        if ($id = $zoo->request->getInt('changeapp')) {
            $zoo->system->application->setUserState('com_zooapplication', $id);
        }

        $jbzooBootstrap = JPATH_ROOT . '/media/zoo/applications/jbuniversal/framework/jbzoo.php';
        if (JFile::exists($jbzooBootstrap)) {
            require_once ($jbzooBootstrap);
            JBZoo::init();
        }
    }

}
