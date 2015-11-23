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

class JBDebugHelper extends AppHelper
{

    /**
     * JBDump instance
     * @var JBDump|null
     */
    protected static $_jbdump = null;

    /**
     * JBDump context
     * @var string
     */
    protected $_jbdumpContext = 'jbzoo';

    /**
     * JBDump params
     * @var array
     */
    protected $_jbdumpParams = array();

    /**
     * @param Application $app
     */
    public function __construct($app)
    {
        parent::__construct($app);
        return; // for debug only

        if (JFactory::getApplication()->isSite() && self::$_jbdump === null) {

            if (class_exists('jbdump')) {
                // jbdump plugin
                self::$_jbdump = JBDump::i($this->_jbdumpParams);
            }
        }

    }

    /**
     * Set profiler mark
     * @param string $name
     */
    public function mark($name = '')
    {
        return; // for debug only

        if (self::$_jbdump !== null) {
            self::$_jbdump->mark($name);
        }
    }

    /**
     * Dump sql queries
     * @param $select
     */
    public function sql($select)
    {
        return; // for debug only

        if (self::$_jbdump !== null) {

            $select = (string)$select;
            self::$_jbdump->dump((string)$select, 'jbdebug::sql');
        }
    }
}
