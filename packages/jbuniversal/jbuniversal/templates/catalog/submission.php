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

// add page title
$page_title = sprintf(($this->item->id ? JText::_('Edit %s') : JText::_('Add %s')), '');
$this->app->document->setTitle($page_title);

$css_class = $this->application->getGroup() . '-' . $this->template->name;

$class = array('zoo', 'jbzoo', 'yoo-zoo', $css_class, $css_class . '-' . $this->submission->alias);

?>

<div id="yoo-zoo" class="<?php echo implode(' ', $class); ?>">

    <div class="submission">

        <h1 class="headline"><?php echo $page_title;?></h1>

        <?php echo $this->partial('submission'); ?>

    </div>

</div>
