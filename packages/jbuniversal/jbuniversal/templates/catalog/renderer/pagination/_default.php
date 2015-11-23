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

$this->app->jbdebug->mark('layout::pagination::start');

if ($pagination = $vars['object']->render($vars['link'])) : ?>
    <div class="pagination">
        <?php echo $pagination; ?>
        <div class="clr clear"></div>
    </div>
<?php endif;

$this->app->jbdebug->mark('layout::pagination::finish');
